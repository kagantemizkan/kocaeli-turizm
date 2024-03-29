<?php

namespace App\Controllers;

use CodeIgniter\API\ResponseTrait;

class TerminalsController extends BaseController
{
    use ResponseTrait;

    protected $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    public function index()
    {
        $query = $this->db->query('SELECT * FROM terminals');
        $data['terminals'] = $query->getResult();

        return view('terminals/index', $data);
    }

    public function create()
    {
        return view('terminals/create');
    }

    public function store()
    {
        $terminalAdi = $this->request->getPost('TerminalAdi');
        $sehirID = $this->request->getPost('SehirID');

        $query = $this->db->query("INSERT INTO terminals (TerminalAdi, SehirID) VALUES ('$terminalAdi', '$sehirID')");

        return redirect()->to('/terminals');
    }

    public function show($id)
    {
        $query = $this->db->query("SELECT * FROM terminals WHERE TerminalID = $id");
        $data['terminal'] = $query->getRow();

        return view('terminals/show', $data);
    }

    public function edit($id)
    {
        $query = $this->db->query("SELECT * FROM terminals WHERE TerminalID = $id");
        $data['terminal'] = $query->getRow();

        return view('terminals/edit', $data);
    }

    public function update($id)
    {
        $terminalAdi = $this->request->getPost('TerminalAdi');
        $sehirID = $this->request->getPost('SehirID');

        $query = $this->db->query("UPDATE terminals SET TerminalAdi = '$terminalAdi', SehirID = '$sehirID' WHERE TerminalID = $id");

        return redirect()->to('/terminals');
    }

    public function delete($id)
    {
        $query = $this->db->query("DELETE FROM terminals WHERE TerminalID = $id");

        return redirect()->to('/terminals');
    }

    public function getAll(){
        
        $query = $this->db->query("SELECT * FROM cities");
        $result = $query->getResult(); // Fetch the query result

        // Convert the result to an associative array
        $data = [];
        foreach ($result as $row) {
            $data[] = [
                'SehirID' => $row->SehirID,
                'SehirAdi' => $row->SehirAdi,
                'PlakaKodu' => $row->PlakaKodu,
                'status' => $row->status,
            ];
        }

        // Encode the data as JSON and return it
        return json_encode($data);
    }
}
