<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NotificationSeeder extends Seeder
{
    public function run(): void
    {
        $userId = DB::table('users')->where('username', 'Operator1')->value('id');

        $notifications = [
            [
                'title' => 'Bin Full',
                'message' => 'Capacity reached 87%. Please empty the bin.',
                'type' => 'task',
                'source' => 'system',
                'is_new' => true,
                'has_check' => false,
                'bin_code' => 'BIN-BASAH-01',
                'assigned_to' => $userId,
                'task_status' => 'pending',
            ],
            [
                'title' => 'Bin Full',
                'message' => 'Capacity reached 87%. Please empty the bin.',
                'type' => 'task',
                'source' => 'system',
                'is_new' => true,
                'has_check' => false,
                'bin_code' => 'BIN-KERING-01',
                'assigned_to' => $userId,
                'task_status' => 'pending',
            ],
        ];

        foreach ($notifications as $notification) {
            DB::table('notifications')->updateOrInsert(
                [
                    'title' => $notification['title'],
                    'bin_code' => $notification['bin_code'],
                ],
                [
                    'message' => $notification['message'],
                    'type' => $notification['type'],
                    'source' => $notification['source'],
                    'is_new' => $notification['is_new'],
                    'has_check' => $notification['has_check'],
                    'assigned_to' => $notification['assigned_to'],
                    'task_status' => $notification['task_status'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }

        $this->command->info('✅ Notifications seeded.');
    }
}
