<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\OfficeModel;

class Offices extends BaseController
{
    // Relative to public/. Stored in the DB as image_path, so the public
    // page can do base_url($office['image_path']) with no changes.
    private const UPLOAD_DIR = 'assets/img/offices';

    protected OfficeModel $officeModel;

    public function __construct()
    {
        $this->officeModel = new OfficeModel();
    }

    // Same login check the other admin controllers use (session 'logged_in').
    private function guard()
    {
        if (! session()->get('logged_in')) {
            return redirect()->to('/admin');
        }

        return null;
    }

    // List all offices
    public function index()
    {
        if ($redirect = $this->guard()) {
            return $redirect;
        }

        $data = [
            'mode'    => 'list',
            'offices' => $this->officeModel
                ->orderBy('city', 'ASC')
                ->orderBy('sort_order', 'ASC')
                ->findAll(),
        ];

        return view('admin/offices', $data);
    }

    // Show empty create form
    public function create()
    {
        if ($redirect = $this->guard()) {
            return $redirect;
        }

        return view('admin/offices', [
            'mode'   => 'create',
            'cities' => $this->existingCities(),
        ]);
    }

    // Handle create form
    public function store()
    {
        if ($redirect = $this->guard()) {
            return $redirect;
        }

        if (! $this->validate($this->rules(true))) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data               = $this->collect();
        $data['image_path'] = $this->saveImage();

        if (! $this->officeModel->insert($data)) {
            return redirect()->back()->withInput()->with('errors', $this->officeModel->errors());
        }

        return redirect()->to('/admin/offices')->with('success', 'Office added successfully!');
    }

    // Show edit form
    public function edit($id)
    {
        if ($redirect = $this->guard()) {
            return $redirect;
        }

        $item = $this->officeModel->find($id);

        if (! $item) {
            return redirect()->to('/admin/offices')->with('error', 'Office not found.');
        }

        return view('admin/offices', [
            'mode'   => 'edit',
            'item'   => $item,
            'cities' => $this->existingCities(),
        ]);
    }

    // Handle edit form
    public function update($id)
    {
        if ($redirect = $this->guard()) {
            return $redirect;
        }

        if (! $this->officeModel->find($id)) {
            return redirect()->to('/admin/offices')->with('error', 'Office not found.');
        }

        if (! $this->validate($this->rules(false))) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = $this->collect();

        // Only replace the photo if a new one was uploaded
        $newImage = $this->saveImage();
        if ($newImage !== null) {
            $data['image_path'] = $newImage;
        }

        if (! $this->officeModel->update($id, $data)) {
            return redirect()->back()->withInput()->with('errors', $this->officeModel->errors());
        }

        return redirect()->to('/admin/offices')->with('success', 'Office updated successfully!');
    }

    // Delete (POST only, see routes)
    public function delete($id)
    {
        if ($redirect = $this->guard()) {
            return $redirect;
        }

        $this->officeModel->delete($id);

        return redirect()->to('/admin/offices')->with('success', 'Office deleted.');
    }

    // ---------------------------------------------------------------

    private function rules(bool $requireImage): array
    {
        $imageRules = 'is_image[image]|mime_in[image,image/jpg,image/jpeg,image/png,image/webp]|max_size[image,4096]';

        return [
            'title'      => 'required|max_length[150]',
            'city'       => 'required|max_length[100]',
            'location'   => 'required|max_length[255]',
            'purpose'    => 'max_length[255]',
            'sort_order' => 'permit_empty|integer',
            'image'      => ($requireImage ? 'uploaded[image]|' : '') . $imageRules,
        ];
    }

    private function collect(): array
    {
        return [
            'title'       => trim((string) $this->request->getPost('title')),
            'city'        => trim((string) $this->request->getPost('city')),
            'location'    => trim((string) $this->request->getPost('location')),
            'purpose'     => trim((string) $this->request->getPost('purpose')),
            'is_top_pick' => $this->request->getPost('is_top_pick') ? 1 : 0,
            'sort_order'  => (int) $this->request->getPost('sort_order'),
        ];
    }

    // Returns the relative path (e.g. assets/img/offices/abc123.jpg) or null if no upload
    private function saveImage(): ?string
    {
        $file = $this->request->getFile('image');

        if ($file && $file->isValid() && ! $file->hasMoved()) {
            $newName = $file->getRandomName();
            $file->move(FCPATH . self::UPLOAD_DIR, $newName);

            return self::UPLOAD_DIR . '/' . $newName;
        }

        return null;
    }

    // Existing group names, used to suggest values in the form
    private function existingCities(): array
    {
        return $this->officeModel->distinct()->orderBy('city', 'ASC')->findColumn('city') ?? [];
    }
}