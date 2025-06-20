<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MasterNotifikasi;

class MasterNotifikasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $notifikasis = [
            [
                'category' => 'Welcome Message',
                'text_sms' => 'Welcome to our service! We are glad to have you.',
                'text_email' => 'Welcome to our service! We are glad to have you.',
                'subject_email' => 'Welcome to Our Service',
            ],
            [
                'category' => 'Password Reset',
                'text_sms' => 'You requested a password reset. Use this code to reset your password: 123456',
                'text_email' => 'You requested a password reset. Use this code to reset your password: 123456',
                'subject_email' => 'Password Reset Request',
            ],
            [
                'category' => 'Subscription Renewal',
                'text_sms' => 'Your subscription is about to expire. Renew now to continue enjoying our services.',
                'text_email' => 'Your subscription is about to expire. Renew now to continue enjoying our services.',
                'subject_email' => 'Subscription Renewal Reminder',
            ],
            // Add more entries as needed
        ];

        foreach ($notifikasis as $notifikasi) {
            MasterNotifikasi::create($notifikasi);
        }
    }
}
