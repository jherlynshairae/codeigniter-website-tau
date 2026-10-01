<?php

namespace App\Models;

use CodeIgniter\Model;

class OfficeModel extends Model
{
    protected $table            = 'offices';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;

    protected $allowedFields = [
        'title',
        'city',
        'location',
        'purpose',
        'image_path',
        'is_top_pick',
        'sort_order',
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    protected $validationRules = [
        'title'      => 'required|max_length[150]',
        'city'       => 'required|max_length[100]',
        'location'   => 'required|max_length[255]',
        'image_path' => 'required|max_length[255]',
    ];

    /**
     * Returns offices grouped by city, e.g.:
     * ['Makati City' => [...], 'Taguig City' => [...]]
     * Mirrors how DepartmentController groups content today.
     * Not called anywhere yet — wired in once the admin CRUD exists.
     */
    public function getGroupedByCity(): array
    {
        $offices = $this->orderBy('city', 'ASC')
                         ->orderBy('sort_order', 'ASC')
                         ->findAll();

        $grouped = [];
        foreach ($offices as $office) {
            $grouped[$office['city']][] = $office;
        }

        return $grouped;
    }
}
