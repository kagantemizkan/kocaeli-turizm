<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class UserReservation extends BaseController
{
    protected $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    public function index()
    {
        $kullaniciID = session()->get('KullaniciID');

        $query = $this->db->query("SELECT r.*, b.KalkisSehri, b.VarisSehri FROM reservations r 
                                   LEFT JOIN bus_routes b ON r.SeferID = b.SeferID 
                                   WHERE r.KullaniciID = $kullaniciID");
        $data['reservations'] = $query->getResult();

        return view('user_reservations/index', $data);
    }

    public function create()
    {
        return view('user_reservations/create');
    }
    
    public function store()
    {
        $kullaniciID = session()->get('KullaniciID');
        $seferID = $this->request->getPost('SeferID');
        $koltukID = $this->request->getPost('KoltukID');
        $tarih = date('Y-m-d');
        $aktifDurumu = 'RezerveEdildi';
    
        $query = $this->db->query("INSERT INTO reservations (KullaniciID, SeferID, KoltukID, Tarih, AktifDurumu) VALUES ($kullaniciID, $seferID, $koltukID, '$tarih', '$aktifDurumu')");
    
        if ($query) {
            return redirect()->to('/user_reservations');
        } else {
            return redirect()->to('/error');
        }
    }
    
    public function purchaseWithCreditCard($id)
{
    $kartNumarasi = $this->request->getPost('kart_numarasi');
    $sonKullanmaTarihi = $this->request->getPost('son_kullanma_tarihi');
    $cvv = $this->request->getPost('cvv');

    $kullaniciID = session()->get('KullaniciID');

    $query = $this->db->query("SELECT Ucret FROM reservations WHERE KullaniciID = $kullaniciID AND RezervasyonID = $id");
    $reservation = $query->getRow();
    $ucret = $reservation->Ucret;

    $odemeBasarili = true;

    if ($odemeBasarili) {
        $this->db->query("UPDATE reservations SET AktifDurumu = 'SatinAlindi' WHERE KullaniciID = $kullaniciID AND RezervasyonID = $id");

        return redirect()->to('/user_reservations')->with('success', 'Rezervasyon başarıyla satın alındı.');
    } else {
        return redirect()->back()->withInput()->with('error', 'Ödeme işlemi başarısız oldu. Lütfen tekrar deneyin.');
    }
}


    public function show($id)
    {
        $kullaniciID = session()->get('KullaniciID');
    
        $query = $this->db->query("SELECT r.*, b.KalkisSehri, b.VarisSehri FROM reservations r 
                                   LEFT JOIN bus_routes b ON r.SeferID = b.SeferID 
                                   WHERE r.KullaniciID = $kullaniciID AND r.RezervasyonID = $id");
        $data['reservation'] = $query->getRow();
    
        return view('user_reservations/show', $data);
    }
    
    public function edit($id)
    {
        $kullaniciID = session()->get('KullaniciID');
    
        $query = $this->db->query("SELECT * FROM reservations WHERE KullaniciID = $kullaniciID AND RezervasyonID = $id");
        $data['reservation'] = $query->getRow();
    
        return view('user_reservations/edit', $data);
    }
    
    public function update($id)
    {
        $kullaniciID = session()->get('KullaniciID');
        $seferID = $this->request->getPost('SeferID');
        $koltukID = $this->request->getPost('KoltukID');
        $aktifDurumu = $this->request->getPost('AktifDurumu');
    
        $query = $this->db->query("UPDATE reservations SET SeferID = $seferID, KoltukID = $koltukID, AktifDurumu = '$aktifDurumu' WHERE KullaniciID = $kullaniciID AND RezervasyonID = $id");
    
        return redirect()->to('/user_reservations');
    }
    
    
    public function delete($id)
    {
        $kullaniciID = session()->get('KullaniciID');
    
        $query = $this->db->query("DELETE FROM reservations WHERE KullaniciID = $kullaniciID AND RezervasyonID = $id");
    
        return redirect()->to('/user_reservations');
    }
    
}
