<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class UserProfileController extends BaseController
{
    protected $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    public function index()
    {
        $userId = $this->session->get('user_id'); 

        $query = $this->db->query("SELECT * FROM users WHERE KullaniciID = $userId");
        $data['user'] = $query->getRow();

        return view('profile/index', $data);
    }

    public function update()
    {
        $userId = $this->session->get('user_id');
        $name = $this->request->getPost('name');
        $surname = $this->request->getPost('surname');
        $birthdate = $this->request->getPost('birthdate');
        $gender = $this->request->getPost('gender');
        $phone = $this->request->getPost('phone');
        $email = $this->request->getPost('email');
        $identityNumber = $this->request->getPost('identity_number');
        $password = $this->request->getPost('password');

        $query = $this->db->query("UPDATE users SET Adi = '$name', Soyadi = '$surname', DogumTarihi = '$birthdate', Cinsiyet = '$gender', CepTelefonu = '$phone', email = '$email', TCKimlikNoVeyaPasaportNo = '$identityNumber', Sifre = '$password' WHERE KullaniciID = $userId");

        if ($query) {
            return redirect()->to('/profile')->with('success', 'Profil bilgileriniz başarıyla güncellendi.');
        } else {
            return redirect()->back()->with('error', 'Profil bilgileriniz güncellenirken bir hata oluştu. Lütfen tekrar deneyin.');
        }
    }
}
