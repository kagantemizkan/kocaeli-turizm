<?php

namespace App\Controllers;

use CodeIgniter\API\ResponseTrait;


class BusRoutesController extends BaseController
{
    use ResponseTrait;
    protected $db;
    

    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    public function getRoutes(){
        $kSehir=$this->request->getVar('kSehir');
        $vSehir=$this->request->getVar('vSehir');
        $date=$this->request->getVar('date');
        if (empty($kSehir) || empty($vSehir) || empty($date)) {
            return $this->respond([
                'success' => false,
                'message' => 'Eksik bilgi.'
            ], 400);
        }
        $query = $this->db->query("SELECT br.*, bc.FirmaAdi AS firma_adi, kalkis.TerminalID AS kalkis, varis.TerminalID AS varis, br.fiyat, br.SeferID
        FROM bus_routes br
        JOIN terminals kalkis ON br.KalkisTerminalID = kalkis.TerminalID
        JOIN terminals varis ON br.VarisTerminalID = varis.TerminalID
        JOIN bus_companies bc ON br.OtobusFirmaID = bc.FirmaID
        WHERE (kalkis.SehirID = ?)
        AND (varis.SehirID = ?)
        AND br.tarih = ?
        ORDER BY br.CikisZamani ASC;
        "
        , [$kSehir,$vSehir,$date]);
        $result = $query->getResult();

        if (!empty($result)) {
            $data = array();
        
            foreach ($result as $row) {
                $OtobusFirmaID = $row->OtobusFirmaID; 
                $CikisZamani = $row->CikisZamani; 
                $VarisZamani = $row->VarisZamani;
                $KoltukSayisi = $row->KoltukSayisi;            
                $bus_plaka = $row->bus_plaka; 
                $firma_adi = $row->firma_adi;
                $varis = $row->varis;
                $kalkis = $row->kalkis;
                $fiyat = $row->fiyat;
                $SeferID=$row->SeferID;
        
                $data[] = array(
                    'OtobusFirmaID' => $OtobusFirmaID,
                    'CikisZamani' => $CikisZamani,
                    'VarisZamani' => $VarisZamani,
                    'KoltukSayisi' => $KoltukSayisi,
                    'bus_plaka' => $bus_plaka,
                    'firma_adi' => $firma_adi,
                    'varis' => $varis,
                    'kalkis' => $kalkis,
                    'fiyat' => $fiyat,
                    'SeferID' => $SeferID

                );
            }
        
            $jsonData = json_encode($data);
            
            return $this->respond($jsonData);
        } else {
            // Kullanıcı bulunamazsa frontende "Kullanıcı bulunamadı." mesajını döndür
            return $this->respond([
                'success' => false,
                'message' => 'Sefer bulunamadı.'
            ], 404);
        }
    }



    public function index()
    {
        $query = $this->db->query("SELECT * FROM bus_routes");
        $data['routes'] = $query->getResultArray();

        return view('bus_routes/index', $data);
    }

    public function create()
    {
        return view('bus_routes/create');
    }

    public function store()
    {
        $data = [
            'KalkisTerminalID' => $this->request->getPost('kalkis_terminal_id'),
            'VarisTerminalID' => $this->request->getPost('varis_terminal_id'),
            'CikisZamani' => $this->request->getPost('cikis_zamani'),
            'VarisZamani' => $this->request->getPost('varis_zamani'),
            'OtobusFirmaID' => $this->request->getPost('otobus_firma_id'),
            'KoltukSayisi' => $this->request->getPost('koltuk_sayisi')
        ];

        $builder = $this->db->table('bus_routes');
        $builder->insert($data);

        return redirect()->to(base_url('bus_routes'));
    }

    public function edit($id)
    {
        $query = $this->db->query("SELECT * FROM bus_routes WHERE SeferID = ?", [$id]);
        $data['route'] = $query->getRowArray();

        return view('bus_routes/edit', $data);
    }

    public function update($id)
    {
        $data = [
            'KalkisTerminalID' => $this->request->getPost('kalkis_terminal_id'),
            'VarisTerminalID' => $this->request->getPost('varis_terminal_id'),
            'CikisZamani' => $this->request->getPost('cikis_zamani'),
            'VarisZamani' => $this->request->getPost('varis_zamani'),
            'OtobusFirmaID' => $this->request->getPost('otobus_firma_id'),
            'KoltukSayisi' => $this->request->getPost('koltuk_sayisi')
        ];

        $builder = $this->db->table('bus_routes');
        $builder->where('SeferID', $id);
        $builder->update($data);

        return redirect()->to(base_url('bus_routes'));
    }

    public function delete($id)
    {
        $builder = $this->db->table('bus_routes');
        $builder->where('SeferID', $id);
        $builder->delete();

        return redirect()->to(base_url('bus_routes'));
    }
}