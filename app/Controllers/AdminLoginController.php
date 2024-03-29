<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class AdminLogin extends BaseController
{
    public function index()
    {
        return view('login');
    }

    public function authenticate()
    {
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $user = $this->getUserByEmail($email);

        if ($user && password_verify($password, $user['Sifre'])) {
            $this->session->set([
                'user_id' => $user['KullaniciID'],
                'email' => $user['email'],
                'role_id' => $user['role_id'],
            ]);

            if ($user['role_id'] == 1) {
                return redirect()->to('admin/dashboard');
            } else {
                return redirect()->to('user/dashboard');
            }
        } else {
            return redirect()->back()->with('error', 'Giriş bilgileri geçersiz');
        }
    }

    private function getUserByEmail($email)
    {
        $db = \Config\Database::connect();
        $query = $db->query("SELECT * FROM users WHERE email = ?", [$email]);

        return $query->getRowArray();
    }

    public function logout()
    {
        $this->session->destroy();
        return redirect()->to('login');
    }
}
