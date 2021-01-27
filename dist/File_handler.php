<?php
require_once APPPATH . '../vendor/box/spout/src/Spout/Autoloader/autoload.php';

use Box\Spout\Common\Type;
use Box\Spout\Reader\ReaderFactory;
class File_handler extends CI_Controller{

    public function upload_excel(){        
        $arr = [];

        $timestamp = date('dmy_his');
        $file = $this->input->post('file');

        $config['upload_path'] = './assets/upload/';
        $config['file_name'] = $timestamp."-".$_FILES['file']['name'];
        $config['allowed_types'] = 'xlsx|csv|xls';
        $config['max_size'] = 0;

        $this->load->library('upload', $config);
        $this->upload->initialize($config);

        if (!$this->upload->do_upload('file')) {
            $arr['status'] = "ERROR";
            $arr['message'] = $this->upload->display_errors();
        } else {
            $arr_error = [];
            $bulan = 0;
            $tahun = 0;
            $prov = "";
            $id_prov = 0;
            $id_kab = 0;
            $media = $this->upload->data();
            $file_path = APPPATH . "../assets/upload/" . $media['file_name'];
            $fn = $media['file_name'];
            $exp = explode(".", $fn);
            $ext = $exp[1];
            if ($ext == "xlsx") {
                $reader = ReaderFactory::create(Type::XLSX); //set Type file xlsx
            } elseif ($ext == "xls") {
                $reader = ReaderFactory::create(Type::XLS); //set Type file xls
            }
            $checker = 0;

            $reader->open($file_path);
            foreach ($reader->getSheetIterator() as $sheet) {
                foreach ($sheet->getRowIterator() as $rn => $get) {
                    if($rn == 1){
                        if($rn == 1 && strtolower($get[0]) != "bulan"){
                            $arr['status'] = "ERROR";
                            $arr['message'] = "Invalid format";
                            break;
                        }else if($rn == 1 && $get[1] == ""){
                            $arr['status'] = "ERROR";
                            $arr['message'] = "Bulan tidak boleh kosong!";
                            break;
                        }else{
                            $bulan = $get[1];
                        }
                    }else if($rn == 2){
                        if($rn == 2 && strtolower($get[0]) != "tahun"){
                            $arr['status'] = "ERROR";
                            $arr['message'] = "Invalid format";
                        break;
                        }else if($rn == 2 && $get[1] == ""){
                            $arr['status'] = "ERROR";
                            $arr['message'] = "Tahun tidak boleh kosong!";
                        break;
                        }else{
                            $tahun = $get[1];
                        }
                    }else if($rn == 3){
                        if($rn == 3 && strtolower($get[0]) != "provinsi"){
                            $arr['status'] = "ERROR";
                            $arr['message'] = "Invalid format";
                        break;
                        }else if($rn == 3 && $get[1] == ""){
                            $arr['status'] = "ERROR";
                            $arr['message'] = "Provinsi tidak boleh kosong!";
                        break;
                        }else{
                            $prov = $get[1];
                        }
                    }else if($rn == 4 || $rn == 5){
                        continue;
                    }else{
                        $nama_daerah = $get[1];
                        $nama_anggota = $get[3];
                        $thp = $get[4];
                        $tgl_setor = $get[6];
                        $dpp = $get[7];
                        $dpd = $get[8];
                        $dpc = $get[9];

                        $id_kab = null;

                        $exp_daerah = explode(" ", $nama_daerah);

                        // CHECK INSERT OR NOT
                        if($nama_anggota == "" || $tgl_setor == ""){
                            continue;
                        }

                        // GET PROV & KAB ID
                        $id_prov = $this->get_prov_id($prov);
                        if(strtolower($exp_daerah[0]) != "provinsi"){
                            if(strtolower($exp_daerah[0]) != "kota"){
                                unset($exp_daerah[0]);
                            }
                            $name_new = implode(" ", $exp_daerah);
                            $id_kab = $this->get_kab_id($id_prov, $name_new);
                        }

                        if($id_prov == null || $id_kab == null){
                            array_push($arr_error, [
                                "row_number" => $rn,
                                "nama_daerah" => $nama_daerah
                            ]);
                            continue;
                        }

                        // CHECK NAMA ANGGOTA ON MASTER
                        $id_anggota = $this->check_nama_anggota($nama_anggota, $id_prov, $id_kab);
                        if($id_anggota == null){
                            $id_anggota = $this->input_anggota($nama_anggota, $id_prov, $id_kab);
                        }

                        // INPUT KONTRIBUSI
                        $cek = $this->checkData($id_anggota, $bulan, $tahun, $id_prov, $id_kab);

                        if(!$cek){
                            
                            $thp = ($thp != "")?str_replace(".", "", $thp):0;
                            $dpp = ($dpp != "")?str_replace(".", "", $dpp):0;
                            $dpd = ($dpd != "")?str_replace(".", "", $dpd):0;
                            $dpc = ($dpc != "")?str_replace(".", "", $dpc):0;
                            $tgl_setor = date_format(date_create($tgl_setor), "Y-m-d");

                            $data = [
                                "id_bulan" => $bulan,
                                "tahun" => $tahun,
                                "id_prov" => $id_prov,
                                "id_kab" => $id_kab,
                                "nama_anggota" => $id_anggota,
                                "thp" => $thp,
                                "dpp" => $dpp,
                                "dpd" => $dpd,
                                "dpc" => $dpc,
                                "tanggal_setor" => $tgl_setor
                            ];

                            $this->db->insert('tb_kontribusi', $data);

                        }
                    }
                }
            }

            $arr['status'] = "SUCCESS";
            $arr['message'] = "BERHASIL DISIMPAN";
        }

        echo setJson($arr);
    }

    public function check_nama_anggota($nama_anggota, $prov, $kab = null){
        if($kab == null){
            $getData = $this->db->query("SELECT id FROM ms_anggota WHERE id_prov=$prov AND nama_anggota='$nama_anggota'");
        }else{
            $getData = $this->db->query("SELECT id FROM ms_anggota WHERE id_prov=$prov AND id_kab=$kab AND nama_anggota='$nama_anggota'");
        }

        if($getData->num_rows() == 1){
            $row = $getData->row();

            return $row->id;
        }else{
            return null;
        }
    }

    public function get_prov_id($prov){
        $getData = $this->db->query("SELECT * FROM ms_provinsi WHERE provinsi LIKE '$prov'");
        if($getData->num_rows() == 1){
            $row = $getData->row();

            return $row->id;
        }else{
            return null;
        }
    }

    public function get_kab_id($prov, $kab){
        $getData = $this->db->query("SELECT * FROM ms_kab_kota WHERE id_prov='$prov' AND kab_kota LIKE '$kab'");
        if($getData->num_rows() == 1){
            $row = $getData->row();

            return $row->id;
        }else{
            return null;
        }
    }

    public function input_anggota($nama_anggota, $prov, $kab = null){
        if($kab == null){
            $data = [
                "id_prov" => $prov,
                "nama_anggota" => $nama_anggota
            ];
        }else{
            $data = [
                "id_prov" => $prov,
                "id_kab" => $kab,
                "nama_anggota" => $nama_anggota
            ];
        }

        $this->db->insert('ms_anggota', $data);
        return $this->db->insert_id();
    }

    public function checkData($id_anggota, $id_bulan, $tahun, $id_prov, $id_kab = null){
        if($id_kab == null){
            $check = $this->db->query("SELECT id FROM tb_kontribusi WHERE nama_anggota='$id_anggota'
                                AND id_bulan=$id_bulan
                                AND tahun=$tahun
                                AND id_prov=$id_prov");
        }else{
            $check = $this->db->query("SELECT id FROM tb_kontribusi WHERE nama_anggota='$id_anggota'
                                AND id_bulan=$id_bulan
                                AND tahun=$tahun
                                AND id_prov=$id_prov
                                AND id_kab=$id_kab");
        }

        if($check->num_rows() == 1){
            return true;
        }else{
            return false;
        }
    }

    public function migrasi_id_prov(){
        $arr= [];

        $getData = $this->db->get('tb_migrasi_anggota');

        foreach($getData->result() as $get){

            $id_prov = $this->cari_id_prov($get->provinsi);

            if($id_prov != null){
                $this->db->where('id', $get->id)
                        ->update('tb_migrasi_anggota', [
                            'id_prov' => $id_prov
                        ]);
            }else{
                array_push($arr, [
                    "id" => $get->id,
                    "provinsi" => $get->provinsi
                ]);
            }

        }

        echo "<pre>".json_encode($arr, JSON_PRETTY_PRINT)."</pre>";
    }

    public function cari_id_prov($nama_prov){
        
        $getData = $this->db->query("SELECT id FROM ms_provinsi WHERE provinsi='$nama_prov'");

        if($getData->num_rows() == 1){
            $row = $getData->row();

            return $row->id;
        }else{
            return null;
        }

    }

    public function migrasi_id_kab(){
        $arr= [];

        $getData = $this->db->get('tb_migrasi_anggota');

        foreach($getData->result() as $get){

            if($get->id_kab != null){
                continue;
            }

            $kabupaten = $get->kabupaten;
            
            if($get->kab_escaped == null){
                if(preg_match('~[0-9]+~', $kabupaten)){
                    $exp = explode(" ", $kabupaten);
                    array_pop($exp);
    
                    $new_name = implode(" ", $exp);
                }else{
                    $new_name = $kabupaten;
                }
    
                $this->db->where('id', $get->id)
                            ->update('tb_migrasi_anggota', [
                                'kab_escaped' => $new_name
                            ]);
            }else{
                $new_name = $get->kab_escaped;
            }

            $id_kab = $this->cari_id_kab($get->id_prov, $new_name);
            if($id_kab != null){
                $this->db->where('id', $get->id)
                        ->update('tb_migrasi_anggota', [
                            'id_kab' => $id_kab
                        ]);
            }else{
                array_push($arr, [
                    "id" => $get->id,
                    "provinsi" => $get->id_prov,
                    "kabupaten" => $new_name
                ]);
            }

        }

        echo "<pre>".json_encode($arr, JSON_PRETTY_PRINT)."</pre>";
    }

    public function cari_id_kab($id_prov, $nama_kab){
        $getData = $this->db->query("SELECT id FROM ms_kab_kota WHERE id_prov=$id_prov AND kab_kota='$nama_kab'");

        if($getData->num_rows() == 1){
            $row = $getData->row();

            return $row->id;
        }else{
            return null;
        }
    }

    public function insert_master(){
        $arr = [];

        $getData = $this->db->get('tb_migrasi_anggota');

        foreach($getData->result() as $get){
            $check = $this->cek_master($get->id_prov, $get->id_kab, $get->nama);

            if($check == null){
                $this->db->insert('ms_anggota', [
                    "id_prov" => $get->id_prov,
                    "id_kab" => $get->id_kab,
                    "nama_anggota" => $get->nama
                ]);

                array_push($arr, [
                    "id_prov" => $get->id_prov,
                    "id_kab" => $get->id_kab,
                    "nama_anggota" => $get->nama
                ]);
            }else{
                continue;
            }
        }

        echo "<pre>".json_encode($arr, JSON_PRETTY_PRINT)."</pre>";
    }

    public function cek_master($id_prov, $id_kab, $nama){

        $getData = $this->db->query('SELECT id FROM ms_anggota WHERE id_prov='.$id_prov.' AND id_kab='.$id_kab.' AND nama_anggota="'.$nama.'"');

        if($getData->num_rows() == 1){
            $row = $getData->row();
            return $row->id;
        }else{
            return null;
        }

    }

    public function update_row(){

        $getData = $this->db->get('tb_kontribusi_migrate');

        foreach($getData->result() as $get){
            $this->db->where('id', $get->id)
                    ->update('tb_kontribusi', [
                        'nama_anggota' => $get->nama_anggota
                    ]);
        }

        echo "--> ".$this->db->affected_rows();

    }

    public function transferData(){
        $arr = [];

        $getData = $this->db->query("SELECT * FROM tb_bukti_setor_kontribusi GROUP BY id_kontribusi");

        foreach($getData->result() as $get){
            $identifier = $this->getRandIdentifier();

            $this->db
                ->where('id_kontribusi', $get->id_kontribusi)
                ->update('tb_bukti_setor_kontribusi', [
                    "unique_identifier" => $identifier
                ]);
            
            $this->db
                ->where('id', $get->id_kontribusi)
                ->update('tb_kontribusi', [
                    "unique_identifier" => $identifier
                ]);
            
            $this->db
                ->insert('tb_detail_kontribusi', [
                    "id_kontribusi" => $get->id_kontribusi,
                    "unique_identifier" => $identifier
                ]);
        }

        $arr['status'] = true;
        $arr['code'] = 200;
        $arr['message'] = "DONE";

        echo setJson($arr);
    }

    public function getRandIdentifier(){
        $date = date('dmyHis');
        $rand = rand(100, 99999);
        $mili = round(microtime(true)*1000);

		return $date.$mili.$rand;
	}
}

?>