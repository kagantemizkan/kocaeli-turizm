<?php

namespace App\Controllers;

use CodeIgniter\API\ResponseTrait;


class RolesController extends BaseController
{
    use ResponseTrait;

    protected $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    public function assignRole()
    {
        if ($this->request->getMethod() === 'post') {
            $userId = $this->request->getPost('user_id');
            $roleId = $this->request->getPost('role_id');

            $success = $this->assignRoleToUser($userId, $roleId);

            if ($success) {
                return redirect()->to('roles/list')->with('success', 'Rol atama başarıyla tamamlandı.');
            } else {
                return redirect()->back()->withInput()->with('error', 'Rol atama sırasında bir hata oluştu.');
            }
        }

        return view('assign_role');
    }

    
    
    public function listRoles()
    {
        sleep(1);

        $query = $this->db->query("SELECT * FROM roles");
        $result = $query->getResult(); // Fetch the query result
    
        $data = array(); // Verileri tutacak dizi

        foreach ($result as $row) {
            // Veriyi diziye ekle
            $data[] = array(
                'role_id' => $row->role_id,
                'name' => $row->name
            );
        }
        return $this->respond($data);
    }
    
    


    public function editRole($roleId)
    {
        if ($this->request->getMethod() === 'post') {
            $newRoleName = $this->request->getPost('new_role_name');

            $success = $this->updateRoleName($roleId, $newRoleName);

            if ($success) {
                return redirect()->to('roles/list')->with('success', 'Rol adı başarıyla güncellendi.');
            } else {
                return redirect()->back()->withInput()->with('error', 'Rol adı güncelleme sırasında bir hata oluştu.');
            }
        }

        $role = $this->getRoleById($roleId);
        return view('edit_role', ['role' => $role]);
    }

    private function assignRoleToUser($userId, $roleId)
    {
        $query = $this->db->query("INSERT INTO user_roles (user_id, role_id) VALUES (?, ?)", [$userId, $roleId]);
        return $query;
    }

    private function getAllRoles()
    {
        $query = $this->db->query("SELECT * FROM roles");
        return $query->getResultArray();
    }

    private function updateRoleName($roleId, $newRoleName)
    {
        $query = $this->db->query("UPDATE roles SET name = ? WHERE role_id = ?", [$newRoleName, $roleId]);
        return $query;
    }

    private function getRoleById($roleId)
    {
        $query = $this->db->query("SELECT * FROM roles WHERE role_id = ?", [$roleId]);
        return $query->getRowArray();
    }
}
