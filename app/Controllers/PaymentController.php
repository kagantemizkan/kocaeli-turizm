<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Payment extends BaseController
{
    protected $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    public function index()
    {
        $query = $this->db->query('SELECT * FROM payments');
        $data['payments'] = $query->getResult();

        return view('payments/index', $data);
    }

    public function create()
    {
        return view('payments/create');
    }

    public function store()
    {
        $kullaniciID = $this->request->getPost('KullaniciID');
        $biletID = $this->request->getPost('BiletID');
        $tarih = date('Y-m-d');
        $miktar = $this->request->getPost('Miktar');
        $odemeYontemi = $this->request->getPost('OdemeYontemi');

        $query = $this->db->query("INSERT INTO payments (KullaniciID, BiletID, Tarih, Miktar, OdemeYontemi) VALUES ($kullaniciID, $biletID, '$tarih', $miktar, '$odemeYontemi')");

        return redirect()->to('/payments');
    }

    public function show($id)
    {
        $query = $this->db->query("SELECT * FROM payments WHERE OdemeID = $id");
        $data['payment'] = $query->getRow();

        return view('payments/show', $data);
    }

    public function edit($id)
    {
        $query = $this->db->query("SELECT * FROM payments WHERE OdemeID = $id");
        $data['payment'] = $query->getRow();

        return view('payments/edit', $data);
    }

    public function update($id)
    {
        $kullaniciID = $this->request->getPost('KullaniciID');
        $biletID = $this->request->getPost('BiletID');
        $miktar = $this->request->getPost('Miktar');
        $odemeYontemi = $this->request->getPost('OdemeYontemi');

        $query = $this->db->query("UPDATE payments SET KullaniciID = $kullaniciID, BiletID = $biletID, Miktar = $miktar, OdemeYontemi = '$odemeYontemi' WHERE OdemeID = $id");

        return redirect()->to('/payments');
    }

    public function delete($id)
    {
        $query = $this->db->query("DELETE FROM payments WHERE OdemeID = $id");

        return redirect()->to('/payments');
    }
}
