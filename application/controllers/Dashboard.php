<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
    public function json_wall() {
        $parameter = [
            11=>'path01', 12=>'path02', 13=>'path03', 14=>'path04', 15=>'path05',
            16=>'path06', 17=>'path07', 18=>'path08', 19=>'path09', 21=>'path10',
            31=>'path11', 32=>'path12', 33=>'path13', 36=>'path14', 35=>'path15',
            34=>'path16', 51=>'path17', 52=>'path18', 53=>'path19', 61=>'path20',
            62=>'path21', 63=>'path22', 64=>'path23', 65=>'path24', 71=>'path25',
            72=>'path26', 73=>'path27', 74=>'path28', 75=>'path29', 76=>'path30',
            81=>'path31', 82=>'path32', 91=>'path33', 92=>'path34',
        ];

        $data_array = [];
        foreach(array_values($parameter) as $ltr){
            $data_array["value"][$ltr]=0;
            $data_array["child"][$ltr]=[];
        }

        $data_array["sunburst"] = [
            [
                "id"=>'0',
                "parent"=>'',
                "name"=>'Global'
            ]
         ];
        $this->db->select("
            map_province_id, map_districts_id, map_sub_district_id, map_village_id,
            province_name, districts_name, sub_district_name, village_name,
            surface_area_by_doc as surface_area
        ")
        ->where("land_status_type_id=4")
        ->join("loc_province","land.map_province_id = loc_province.province_id")
        ->join("loc_districts","land.map_districts_id = loc_districts.districts_id")
        ->join("loc_sub_district","land.map_sub_district_id = loc_sub_district.sub_district_id")
        ->join("loc_village","land.map_village_id = loc_village.village_id");
        //->group_by("map.province_id");
        $data = $this->db->get('land')->result_array();

        $province = []; $districts = []; $sub_district = [];
        foreach($data as $row){
            $data_array["value"][$parameter[$row["map_province_id"]]]+=$row["surface_area"];
            $data_array["child"][$parameter[$row["map_province_id"]]][$row["districts_name"]]
                [$row["sub_district_name"]][$row["village_name"]]=$row["surface_area"];
            
            if(!in_array($row["map_province_id"],$province)){
                $province[] = $row["map_province_id"];
                $data_array["sunburst"][] = [
                    "id"=>$province[count($province)-1],
                    "parent"=>'0',
                    "name"=>$row["province_name"]
                ];
            }
            if(!in_array(($temp = str_replace($province[count($province)-1],"",$row["map_districts_id"])),$districts)){
                $districts[] = $temp;
                $data_array["sunburst"][] = [
                    "id"=>$districts[count($districts)-1],
                    "parent"=>$province[count($province)-1],
                    "name"=>$row["districts_name"]
                ];
            }
            if(!in_array(($temp = str_replace($province[count($province)-1].$districts[count($districts)-1],"",$row["map_sub_district_id"])),$sub_district)){
                $sub_district[] = $temp;
                $data_array["sunburst"][] = [
                    "id"=>$sub_district[count($sub_district)-1],
                    "parent"=>$districts[count($districts)-1],
                    "name"=>$row["sub_district_name"]
                ];
            }
            $data_array["sunburst"][] = [
                "id"=>str_replace(
                    $province[count($province)-1].$districts[count($districts)-1].
                    $sub_district[count($sub_district)-1],"",$row["map_village_id"]),
                "parent"=>$sub_district[count($sub_district)-1],
                "name"=>$row["village_name"],
                "value"=>intval($row["surface_area"])
            ];
        }

        echo json_encode($data_array);
    }

    public function index() {
        //$this->load->view('table');
        $this->template->load('template', 'welcome');
    }

    public function form() {
        //$this->load->view('table');
        $this->template->load('template', 'form');
    }
    
    function autocomplate(){
        autocomplate_json('tbl_user', 'full_name');
    }

    function __autocomplate() {
        $this->db->like('nama_lengkap', $_GET['term']);
        $this->db->select('nama_lengkap');
        $products = $this->db->get('pegawai')->result();
        foreach ($products as $product) {
            $return_arr[] = $product->nama_lengkap;
        }

        echo json_encode($return_arr);
    }

    function pdf() {
        $this->load->library('pdf');
        $pdf = new FPDF('l', 'mm', 'A5');
        // membuat halaman baru
        $pdf->AddPage();
        // setting jenis font yang akan digunakan
        $pdf->SetFont('Arial', 'B', 16);
        // mencetak string 
        $pdf->Cell(190, 7, 'SEKOLAH MENENGAH KEJURUSAN NEEGRI 2 LANGSA', 0, 1, 'C');
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(190, 7, 'DAFTAR SISWA KELAS IX JURUSAN REKAYASA PERANGKAT LUNAK', 0, 1, 'C');
        $pdf->Output();
    }

}
