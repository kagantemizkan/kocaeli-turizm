<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class AdminReservationController extends BaseController
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

        return view('admin/reservations/index', $data);
    }

    public function show($id)
    {
        $query = $this->db->query("SELECT * FROM reservations WHERE RezervasyonID = $id");
        $data['reservation'] = $query->getRow();

        return view('admin/reservations/show', $data);
    }

    public function edit($id)
    {
        $query = $this->db->query("SELECT * FROM reservations WHERE RezervasyonID = $id");
        $data['reservation'] = $query->getRow();

        return view('admin/reservations/edit', $data);
    }

    public function update($id)
    {
        $aktifDurumu = $this->request->getPost('AktifDurumu');

        $query = $this->db->query("UPDATE reservations SET AktifDurumu = '$aktifDurumu' WHERE RezervasyonID = $id");

        return redirect()->to('/admin/reservations');
    }

    public function delete($id)
    {
        $query = $this->db->query("DELETE FROM reservations WHERE RezervasyonID = $id");

        return redirect()->to('/admin/reservations');
    }

    public function userList()
    {
        $query = $this->db->query('SELECT * FROM users');
        $data['users'] = $query->getResult();

        return view('admin_reservations/user_list', $data);
    }

    public function userReservations($userId)
    {
        $query = $this->db->query("SELECT * FROM reservations WHERE KullaniciID = $userId");
        $data['reservations'] = $query->getResult();

        return view('admin_reservations/user_reservations', $data);
    }


}
