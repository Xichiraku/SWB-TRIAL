/**
 * WhatsApp Baileys Service — SWB-TRIAL
 *
 * Startup → input nomor HP → auto-pair → siap kirim pesan.
 * Support QR code + Pairing code.
 *
 * GET  /status    → cek koneksi
 * POST /send      → { "to": "628xxx", "text": "..." }
 */

const {
    default: makeWASocket,
    useMultiFileAuthState,
    DisconnectReason,
    fetchLatestBaileysVersion,
    makeCacheableSignalKeyStore,
} = require('@whiskeysockets/baileys');
const pino = require('pino');
const express = require('express');
const qrcode = require('qrcode-terminal');
const path = require('path');
const fs = require('fs');
const readline = require('readline');

const app = express();
app.use(express.json());

const PORT = process.env.WA_PORT || 3001;
const AUTH_DIR = path.join(__dirname, 'auth_state');

let sock = null;
let connectionState = 'disconnected';

// ── Helpers ──────────────────────────────────────────────
function cleanAuth() {
    try {
        if (fs.existsSync(AUTH_DIR)) {
            fs.rmSync(AUTH_DIR, { recursive: true, force: true });
            console.log('🗑️  Auth state cleaned.');
        }
    } catch (e) {
        console.error('⚠️  Gagal hapus auth_state:', e.message);
    }
}

function getAuthState() {
    if (!fs.existsSync(AUTH_DIR)) fs.mkdirSync(AUTH_DIR, { recursive: true });
    return useMultiFileAuthState(AUTH_DIR);
}

function askInput(question) {
    const rl = readline.createInterface({ input: process.stdin, output: process.stdout });
    return new Promise((resolve) => {
        rl.question(question, (answer) => {
            rl.close();
            resolve(answer.trim());
        });
    });
}

// ── Connect ──────────────────────────────────────────────
async function startService(phoneNumber) {
    try {
        const { state, saveCreds } = await getAuthState();
        const { version } = await fetchLatestBaileysVersion();

        sock = makeWASocket({
            version,
            auth: {
                creds: state.creds,
                keys: makeCacheableSignalKeyStore(state.keys, pino({ level: 'silent' })),
            },
            printQRInTerminal: false,
            browser: ['SWB-TRIAL', 'Chrome', '4.0.0'],
            logger: pino({ level: 'silent' }),
        });

        sock.ev.on('creds.update', saveCreds);

        let pairingRequested = false;

        sock.ev.on('connection.update', async (update) => {
            try {
                const { connection, lastDisconnect, qr, pairingCode } = update;

                // Pairing code dari WhatsApp (jika support)
                if (pairingCode) {
                    console.log('\n========================================');
                    console.log(`🔑 PAIRING CODE: ${pairingCode}`);
                    console.log('========================================');
                    console.log('📱 BUKA HP → Linked Devices → Link with Phone Number');
                    console.log('========================================\n');
                }

                // QR muncul → tampilkan + generate pairing code
                if (qr) {
                    console.log('\n📱 ========================================');
                    console.log('   SCANNER QR CODE');
                    console.log('   Buka HP → WhatsApp → Linked Devices');
                    console.log('   → Link a Device → Scan QR ini');
                    console.log('========================================\n');
                    qrcode.generate(qr, { small: true });

                    // Juga coba pairing code
                    if (phoneNumber && !pairingRequested) {
                        pairingRequested = true;
                        try {
                            const code = await sock.requestPairingCode(phoneNumber);
                            console.log('\n========================================');
                            console.log(`🔑 ATAU MASUKKAN PAIRING CODE: ${code}`);
                            console.log('   HP → Linked Devices → Link with Phone Number');
                            console.log('========================================\n');
                        } catch (e) {
                            // Ignore - QR sudah ditampilkan sebagai fallback
                        }
                    }
                }

                if (connection === 'close') {
                    const code = lastDisconnect?.error?.output?.statusCode;
                    connectionState = 'disconnected';
                    pairingRequested = false;

                    console.log(`⚠️  Connection closed (code: ${code})`);

                    if (code === DisconnectReason.loggedOut) {
                        console.log('🔒 Logged out. Cleaning & retrying...');
                        cleanAuth();
                    }

                    setTimeout(() => startService(phoneNumber), 5000);
                }

                if (connection === 'open') {
                    connectionState = 'connected';
                    console.log('\n✅ ========================================');
                    console.log('   WHATSAPP CONNECTED!');
                    console.log('   Siap kirim pesan.');
                    console.log('========================================\n');
                }
            } catch (e) {
                console.error('⚠️  Update error:', e.message);
            }
        });
    } catch (err) {
        console.error('❌ Start error:', err.message);
        setTimeout(() => startService(phoneNumber), 5000);
    }
}

// ── Routes ───────────────────────────────────────────────

app.get('/status', (_req, res) => {
    res.json({
        ok: true,
        connection: connectionState,
        phone: sock?.user?.id ?? null,
    });
});

app.post('/send', async (req, res) => {
    try {
        const { to, text } = req.body;

        console.log(`📥 Incoming send request -> to=${to} text=${text?.slice(0, 120)}`);

        if (!to || !text) {
            return res.status(400).json({ ok: false, message: 'to & text required' });
        }

        if (connectionState !== 'connected') {
            return res.status(503).json({ ok: false, message: 'WhatsApp not connected' });
        }

        // Auto-detect JID format
        let jid;
        if (to.includes('@g.us') || to.includes('@s.whatsapp.net')) {
            jid = to; // sudah JID lengkap
        } else if (/^\d+$/.test(to)) {
            jid = `${to}@s.whatsapp.net`; // nomor HP → personal
        } else {
            jid = `${to}@g.us`; // group ID
        }

        const result = await sock.sendMessage(jid, { text });
        console.log(`📤 Sent to ${jid}`);
        console.log(`✅ Message id=${result.key.id}`);
        res.json({ ok: true, messageId: result.key.id, to: jid });
    } catch (err) {
        console.error('❌ Send error:', err.message);
        res.status(500).json({ ok: false, message: err.message });
    }
});

// List semua grup WhatsApp
app.get('/groups', async (_req, res) => {
    try {
        if (connectionState !== 'connected') {
            return res.status(503).json({ ok: false, message: 'WhatsApp not connected' });
        }

        const groups = [];
        const chats = await sock.groupFetchAllParticipating();

        for (const [id, group] of Object.entries(chats)) {
            groups.push({
                id: group.id,
                name: group.subject,
                participants: group.participants.length,
                description: group.desc ?? '',
            });
        }

        res.json({ ok: true, groups });
    } catch (err) {
        console.error('❌ Groups error:', err.message);
        res.status(500).json({ ok: false, message: err.message });
    }
});

// ── Error handlers ───────────────────────────────────────
process.on('unhandledRejection', (err) => {
    console.error('⚠️  Unhandled rejection:', err?.message ?? err);
});
process.on('uncaughtException', (err) => {
    console.error('⚠️  Uncaught:', err.message);
});

// ── Start ────────────────────────────────────────────────
(async () => {
    console.log('\n🚀 WhatsApp Baileys Service — SWB-TRIAL\n');

    app.listen(PORT, () => {
        console.log(`🌐 API: http://localhost:${PORT}\n`);

        // Cek apakah auth state sudah ada dari sesi sebelumnya
        const hasAuth = fs.existsSync(path.join(AUTH_DIR, 'creds.json'));

        if (hasAuth) {
            console.log('🔑 Auth state ditemukan — menghubungkan ulang tanpa scan QR...\n');
            startService('');
        } else {
            // Pertama kali: tanya metode connect
            console.log('Pilih metode connect:');
            console.log('  1. QR Code (scan dari HP)');
            console.log('  2. Pairing Code (nomor telepon)');

            askInput('Pilihan (1/2): ').then(method => {
                if (method === '2') {
                    askInput('📱 Masukkan nomor HP WhatsApp (cth: 628xxxxxxxxxx): ').then(raw => {
                        const phoneNumber = raw.replace(/[^0-9]/g, '');
                        if (!phoneNumber) {
                            console.log('❌ Nomor kosong.');
                            process.exit(1);
                        }
                        console.log(`\n📡 Starting (method: Pairing Code)...\n`);
                        startService(phoneNumber);
                    });
                } else {
                    console.log(`\n📡 Starting (method: QR Code)...\n`);
                    startService('');
                }
            });
        }
    });
})();
