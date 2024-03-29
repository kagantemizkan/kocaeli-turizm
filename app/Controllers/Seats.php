<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Seats extends BaseController
{
    protected $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    public function index()
    {
        $query = $this->db->query("SELECT * FROM seats");
        $data['seats'] = $query->getResultArray();

        return view('seats/index', $data);
    }

    public function create()
    {
        return view('seats/create');
    }

    public function store()
    {
        $data = [
            'SeferID' => $this->request->getPost('sefer_id'),
            'KoltukNumarasi' => $this->request->getPost('koltuk_numarasi'),
            'Durumu' => 'Bos', 
            'YolcuID' => null, 
        ];

        $builder = $this->db->table('seats');
        $builder->insert($data);

        return redirect()->to(base_url('seats'));
    }

    public function edit($id)
    {
        $query = $this->db->query("SELECT * FROM seats WHERE KoltukID = ?", [$id]);
        $data['seat'] = $query->getRowArray();

        return view('seats/edit', $data);
    }

    public function update($id)
    {
        $data = [
            'SeferID' => $this->request->getPost('sefer_id'),
            'KoltukNumarasi' => $this->request->getPost('koltuk_numarasi'),
            'Durumu' => $this->request->getPost('durumu'),
            'YolcuID' => $this->request->getPost('yolcu_id'),
        ];

        $builder = $this->db->table('seats');
        $builder->where('KoltukID', $id);
        $builder->update($data);

        return redirect()->to(base_url('seats'));
    }

    public function delete($id)
    {
        $builder = $this->db->table('seats');
        $builder->where('KoltukID', $id);
        $builder->delete();

        return redirect()->to(base_url('seats'));
    }
}
