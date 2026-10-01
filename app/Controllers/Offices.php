<?php

namespace App\Controllers;

use App\Models\OfficeModel;

class Offices extends BaseController
{
    protected OfficeModel $officeModel;

    public function __construct()
    {
        $this->officeModel = new OfficeModel();
    }

    public function index()
    {
        // Real DB read — once OfficeSeeder has been run, this pulls live rows.
        // Grouped by city so the view can render one "TOP PICKS" section per campus/building,
        // same shape as the Instant Offices reference layout.
        $offices = $this->officeModel->getGroupedByCity();

        $data = [
            'title'   => 'School Offices',
            'offices' => $offices,
        ];

        return view('offices', $data);
    }
}
