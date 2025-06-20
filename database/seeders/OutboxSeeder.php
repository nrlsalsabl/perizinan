<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Outbox;

class OutboxSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $outboxes = [
            [
                'category' => 'Category 1',
                'text_sms' => 'This is a sample SMS text for Category 1',
                'text_email' => 'This is a sample email text for Category 1',
                'subject_email' => 'Sample Email Subject for Category 1'
            ],
            [
                'category' => 'Category 2',
                'text_sms' => 'This is a sample SMS text for Category 2',
                'text_email' => 'This is a sample email text for Category 2',
                'subject_email' => 'Sample Email Subject for Category 2'
            ],
            [
                'category' => 'Category 3',
                'text_sms' => 'This is a sample SMS text for Category 3',
                'text_email' => 'This is a sample email text for Category 3',
                'subject_email' => 'Sample Email Subject for Category 3'
            ],
            // Add more entries as needed
        ];

        foreach ($outboxes as $outbox) {
            Outbox::create($outbox);
        }
    }
}
