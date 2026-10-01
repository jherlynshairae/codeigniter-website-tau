<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class OfficeSeeder extends Seeder
{
    public function run()
    {
        // Clear existing rows first so re-running this seeder never leaves
        // stale entries behind (e.g. an old "CET Building" row from an earlier version).
        $this->db->table('offices')->truncate();

        $data = [
            [
                'title'       => 'Registrar\'s Office',
                'city'        => 'TAU Main Campus',
                'location'    => 'Admin Building, Ground Floor',
                'purpose'     => 'Enrollment records, grades, and document requests',
                'image_path'  => 'assets/Images/offices/registrar.jpg',
                'is_top_pick' => 1,
                'sort_order'  => 1,
            ],
            [
                'title'       => 'Guidance Office',
                'city'        => 'TAU Main Campus',
                'location'    => 'Admin Building, 2nd Floor',
                'purpose'     => 'Counseling, testing, and student welfare concerns',
                'image_path'  => 'assets/img/offices/guidance.jpg',
                'is_top_pick' => 0,
                'sort_order'  => 2,
            ],
            [
                'title'       => 'Library and Learning Resource Center',
                'city'        => 'TAU Main Campus',
                'location'    => 'Library Building',
                'purpose'     => 'Book borrowing, research assistance, study areas',
                'image_path'  => 'assets/img/offices/library.jpg',
                'is_top_pick' => 0,
                'sort_order'  => 3,
            ],
        ];

        $this->db->table('offices')->insertBatch($data);
    }
}