<?php

return [

    /*
    |--------------------------------------------------------------------------
    | WhatsApp Baileys Service
    |--------------------------------------------------------------------------
    |
    | URL microservice Node.js yang menjalankan Baileys.
    | Jalankan service:  node whatsapp-service/index.js
    |
    */

    'service_url' => env('WHATSAPP_SERVICE_URL', 'http://127.0.0.1:3001'),

    'timeout' => (int) env('WHATSAPP_TIMEOUT', 10),

    /*
    | Group ID WhatsApp yang akan menerima notifikasi.
    | Lihat daftar grup: GET /admin/whatsapp/groups
    */
    'notify_group' => env('WHATSAPP_NOTIFY_GROUP', ''),

];
