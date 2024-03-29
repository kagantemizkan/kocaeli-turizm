<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Reservation extends BaseController
{
    protected $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    public function index()
    {
        $query = $this->db->query('SELECT * FROM reservations');
        $data['reservations'] = $query->getResult();

        return view('reservations/index', $data);
    }

    public function create()
    {
        return view('reservations/create');
    }

    public function store()
    {
        $kullaniciID = $this->request->getPost('KullaniciID');
        $seferID = $this->request->getPost('SeferID');
        $koltukID = $this->request->getPost('KoltukID');
        $tarih = date('Y-m-d');
        $aktifDurumu = 'RezerveEdildi';

        $query = $this->db->query("INSERT INTO reservations (KullaniciID, SeferID, KoltukID, Tarih, AktifDurumu) VALUES ($kullaniciID, $seferID, $koltukID, '$tarih', '$aktifDurumu')");

        return redirect()->to('/reservations');
    }

    public function show($id)
    {
        $query = $this->db->query("SELECT * FROM reservations WHERE RezervasyonID = $id");
        $data['reservation'] = $query->getRow();

        return view('reservations/show', $data);
    }

    public function edit($id)
    {
        $query = $this->db->query("SELECT * FROM reservations WHERE RezervasyonID = $id");
        $data['reservation'] = $query->getRow();

        return view('reservations/edit', $data);
    }

    public function update($id)
    {
        $kullaniciID = $this->request->getPost('KullaniciID');
        $seferID = $this->request->getPost('SeferID');
        $koltukID = $this->request->getPost('KoltukID');
        $aktifDurumu = $this->request->getPost('AktifDurumu');

        $query = $this->db->query("UPDATE reservations SET KullaniciID = $kullaniciID, SeferID = $seferID, KoltukID = $koltukID, AktifDurumu = '$aktifDurumu' WHERE RezervasyonID = $id");

        return redirect()->to('/reservations');
    }

    public function delete($id)
    {
        $query = $this->db->query("DELETE FROM reservations WHERE RezervasyonID = $id");

        return redirect()->to('/reservations');
    }
}
