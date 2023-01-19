<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Mpdf\Mpdf;

class Land extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        is_login();
        $this->load->model('Land_model');
        $this->load->library('form_validation');        
	    $this->load->library('datatables');
    }
    public function get_data_tree() {
        header('Content-Type: application/json');
        /*$id = $this->input->post("id", TRUE);
        $target = $this->input->post("target", TRUE);
        if(!empty($id)&&!empty($target))*/
        
        echo json_encode($this->Land_model->get_data_tree());
    }

    public function json() {
        header('Content-Type: application/json');
        echo json_encode([
            "data" => $this->Land_model->get_data_tree(),
            "draw" => 0,
            "last_page" => 1,
        ]);
    }

    public function index()
    {
        $this->template->load('template','land/list');
    }

    public function create() 
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('land/create_action')
        );
        $this->template->set('loading',true);
        $this->template->load('template','land/create', $data);
    }

    public function get_code(){
        $code = $this->input->post("code", TRUE);
        echo json_encode([
            "valid"=>($this->db->get_where("land","land_documents_code=".$code)->num_rows()==0)
        ]);
    }

    public function update($id){
        if($this->db->get_where("land","land_id=".$id)->num_rows()!=0){
            $data = array(
                'button' => 'Update',
                'action' => site_url('land/update_action'),
                'land_id' => $id
            );
            $this->template->set('loading',true);
            $this->template->load('template','land/create', $data);
        } else redirect("land/create");
    }

    public function posting(){
        $land_id = $this->input->post("land_id");
        $status = $this->db->update("land_user_history",[
            "land_user_history_type_id"=>2,
        ], "land_id =".$land_id);
        $status &= $this->db->update("land",[
            "land_status_type_id"=>2,
        ], "land_id =".$land_id);
        echo json_encode(["success"=>$status]);
    }

    function select2_data($id=0,$cat=1){
        $this->db->select("land_document_type_id as id")
            ->select("land_document_type_name as text")
            ->select("land_document_type_extra as extra");
        if($cat!=0)
            $this->db->where('land_document_category_id='.$cat);
        
        if($id!=0) $this->db->select("(
                SELECT COUNT(*)
                FROM land_document
                WHERE land_id=$id AND land_document_type_id=id
            )<>0 AS disabled");
        else $this->db->select("0 AS disabled");

        $data[0] = $this->db->get("land_document_type")->result_array();
        foreach($data[0] as &$row){
            $row["id"] = intval($row["id"]);
            $row["disabled"] = boolval($row["disabled"]);
            $row["extra"] = json_decode($row["extra"]);
        }
        echo json_encode($data);
    }
    
    function land_data(){
        $id = $this->input->post("id");
        $show_data = $this->input->post("show_data");
        $data = $this->Land_model->get_initial_data($id, $show_data);
        echo json_encode($data);
    }

    public function update_action(){
        $data = $this->input->post(null, TRUE);
        echo json_encode($data);

        /*[
            "owner"=>"owner_id",
            "surface_area"=>"surface_area_id",
            "map_proof"=>"map_id"
        ]
        [
            "asal_owner"=>"owner",
            "baru_owner"=>"owner",
            "baru_owner"=>"owner",
            "ppjb_owner"=>"owner",
            "keterangan_owner"=>"owner",

            "surface_area"=>"surface_area",
            "price_per_cubic_meter"=>"surface_area",
            "total_price"=>"surface_area",
            "land_id"=>"surface_area",
        ]
        [
            "owner"=>[
                "asal_owner"=>"owner_initial_name",
                "baru_owner"=>"owner_final_name",
                "ppjb_owner"=>"owner_ppjb",
                "keterangan_owner"=>"owner_annotation",
            ],
            "surface_area"=>[
                "surface_area"=>"surface_area",
                "price_per_cubic_meter"=>"price_per_cubic_meter",
                "total_price"=>"total_price",
                "land_id"=>"land_id",
            ],
        ]*/
        /*$status = true;
        $status &= $this->db->update("owner",[
            "owner_initial_name"=>$data["asal_owner"],
            "owner_final_name"=>$data["baru_owner"],
            "owner_ppjb"=>$data["ppjb_owner"],
            "owner_annotation"=>$data["keterangan_owner"]
        ], "owner_id=".$data["owner_id"]);

        $status &= $this->db->update("surface_area",[
            "surface_area"=>$data["surface_area"],
            "price_per_cubic_meter"=>$data["price_per_cubic_meter"],
            "total_price"=>$data["total_price"],
            "land_id"=>$data["land_id"]
        ], "surface_area_id=".$data["surface_area_id"]);

        $map_result = [];
        $map_proof = $this->db->get_where("map_proof",["map_id"=>$data["map_id"]])->result_array();
        foreach($map_proof as $mp){
            $map_result[$mp["file_system_id"]] = $mp[];
        }

        foreach($data["map_type_id"] as $id=>$row){
            foreach(array_slice($row, 1) as $sli){
                $status &= $this->db->insert("map_proof",[
                    "map_id"=>$data["map_id"],
                    "map_proof_number"=>$row[1],
                    "map_proof_type_id"=>$id,
                    "file_system_id"=>$sli,
                ]);
            }
        }
        foreach($data["proof_type_id"] as $id=>$row){
            foreach(array_slice($row, 1) as $sli){
                $status &= $this->db->insert("proof",[
                    "proof_type_id"=>$id,
                    "proof_number"=>$row[1],
                    "file_system_id"=>$sli,
                    "land_id"=>$data["land_id"]
                ]);
            }
        }
        foreach($data["col_doc"] as $id=>$row){
            $option = [
                "land_document_type_id"=>$id,
                "land_document_file_type"=>$row[1],
                "land_document_file_annoations"=>$row[sizeOf($row)-1],
                "land_document_file_extra"=>json_encode(array_slice($row, 1, -1)),
                "land_id"=>$data["land_id"]
            ];
           if(!empty($data["col_file"][$id])){
                foreach($data["col_file"][$id] as $sli){
                    $option["file_system_id"]=$sli;
                    $status &= $this->db->insert("land_document",$option);
                }
            } else $status &= $this->db->insert("land_document",$option);
        }

        $status &= $this->db->update("land_user_history",[
            "land_user_history_status"=>2,
        ], "land_user_history_id =".$data["land_user_history_id"]);

        $status &= $this->db->update("land_status",[
            "land_status_type"=>2,
        ], "land_status_id =".$data["land_status_id"]);

        $status &= $this->db->update("land",[
            "land_documents_code"=>$data["land_documents_code"],
            "land_project_id"=>$data["land_project_type"],
            "land_mediator"=>$data["mediator"],
            "owner_id"=>$owner_id,
            "surface_area_id"=>$surface_area_id,
            "land_status_id"=> $data["land_status_id"],
            "map_id"=> $data["map_id"],
            //"land_date"=>$data["keterangan_owner"]
        ], "land_id =".$data["land_id"]); */

       // echo json_encode([ "status"=>$status ]);
    }

    public function convert() 
    {
        $query = $this->db->query("SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES
            WHERE TABLE_SCHEMA = 'my_tanah' 
            AND ENGINE = 'MyISAM'");
        
        $data = $query->result_array();
        
        var_dump($data);
    }

    public function langsung() 
    {
        $cvb = $this->db->select("
            loc_village.village_id, 
            loc_village.village_name, 
            loc_sub_district.sub_district_name, 
            loc_districts.districts_name, 
            loc_province.province_name")
        ->join("loc_sub_district","loc_village.sub_district_id = loc_sub_district.sub_district_id")
        ->join("loc_districts","loc_sub_district.districts_id = loc_districts.districts_id")
        ->join("loc_province","loc_districts.province_id = loc_province.province_id")
        ->get("loc_village")->result_array();
        
        $result_cvb = [];
        foreach($cvb as $ids=>$row){
            $result_cvb[$row["village_id"]]=str_replace(" ","%20",($row["village_name"]." ".$row["sub_district_name"]." ".$row["districts_name"]." ".$row["province_name"]));
        }
        
        var_dump($result_cvb);
    }
    
    public function show_data($id) 
    {
        if($this->db->get_where('land',["land.land_id"=>$id])->num_rows()!=0)
            $this->template->load('template','land/show_data', ['land_id'=>$id]);
        else redirect("land");
    }

    public function create_action() 
    {
        $data = $this->input->post(null, TRUE);

        //var_dump(json_encode($data));
        //echo json_encode($data);

        /*$data = json_decode('{
            "land_documents_code": "D125/25455",
            "land_project_type": "1",
            "land_physics": "1",
            "mediator": "",
            "loc_province": "11",
            "loc_districts": "1101",
            "loc_sub_district": "110107",
            "loc_village": "1101072011",
            "geolocation": "{\"draw\":{\"type\":\"Feature\",\"properties\":{},\"geometry\":{\"coordinates\":[[[97.09061877415786,3.409441239276333],[97.0917636687787,3.407217276956146],[97.09324893747453,3.408205705288367],[97.09219687214846,3.4103987770255486],[97.09061877415786,3.409441239276333]]],\"type\":\"Polygon\"}},\"view\":{\"center\":[97.08769465141268,3.4073408305541477],\"zoom\":14.47187593232816}}",
            "map_id": "1",
            "land_status_id": "1",
            "land_project_id": "1",
            "land_user_history_id": "1",
            "land_id": "1",
            "asal_owner": "Ardi",
            "baru_owner": "Eko",
            "ppjb_owner": "Guru",
            "keterangan_owner": "taps",
            "proof_type_id": { "1": { "1": "1257" } },
            "by_doc": "5.566",
            "by_remeas": "5.566",
            "by_geo": "5.566",
            "by_purchase": { "1": "5.566", "2": "2020" },
            "by_market": {
              "1": { "1": "5.566", "2": "2020" },
              "2": { "1": "5.567", "2": "2020" },
              "3": { "1": "5.568", "2": "2020" }
            },
            "by_njop": {
              "1": { "1": "5.599", "2": "2020" },
              "2": { "1": "5.768", "2": "2020" },
              "3": { "1": "5.020", "2": "2020" }
            },
            "map_type_id": { "2": { "1": "75668" } },
            "col_doc": {
              "1": { "1": "0", "2": "" },
              "2": { "1": "0", "2": "" },
              "3": { "1": "1", "2": "bolcah", "3": "" },
              "4": { "1": "0", "2": "bolcah", "3": "" },
              "5": { "1": "0", "2": "bolcah", "3": "" }
            }
          }', TRUE);

        $status = true;
        $status &= $this->db->insert("owner",[
            "owner_initial_name"=>$data["asal_owner"],
            "owner_final_name"=>$data["baru_owner"],
            "owner_ppjb"=>$data["ppjb_owner"],
            "owner_annotation"=>$data["keterangan_owner"]
        ]);
        $owner_id = $this->db->insert_id();

        $status &= $this->db->insert("surface_area",[
            "surface_area_by_doc"=>$data["surface_area"],
            "surface_area_by_remeas"=>$data["surface_area"],
            "surface_area_by_geo"=>$data["surface_area"],
            "price_per_cubic_meter"=>$data["price_per_cubic_meter"],
            "total_price"=>$data["total_price"],
            "land_id"=>$data["land_id"]
        ]);
        $surface_area_id = $this->db->insert_id();

        foreach($data["map_type_id"] as $id=>$row){
            foreach(array_slice($row, 1) as $sli){
                $status &= $this->db->insert("map_proof",[
                    "map_id"=>$data["map_id"],
                    "map_proof_number"=>$row[1],
                    "map_proof_type_id"=>$id,
                    "file_system_id"=>$sli,
                ]);
            }
        }
        foreach($data["proof_type_id"] as $id=>$row){
            foreach(array_slice($row, 1) as $sli){
                $status &= $this->db->insert("proof",[
                    "proof_type_id"=>$id,
                    "proof_number"=>$row[1],
                    "file_system_id"=>$sli,
                    "land_id"=>$data["land_id"]
                ]);
            }
        }
        foreach($data["map_type_id"] as $id=>$row){
            foreach(array_slice($row, 1) as $sli){
                $status &= $this->db->insert("map_proof",[
                    "map_id"=>$data["map_id"],
                    "map_proof_number"=>$row[1],
                    "map_proof_type_id"=>$id,
                    "file_system_id"=>$sli,
                ]);
            }
        }
       foreach($data["col_doc"] as $id=>$row){
            $option = [
                "land_document_type_id"=>$id,
                "land_document_file_type"=>$row[1],
                "land_document_file_annoations"=>$row[sizeOf($row)-1],
                "land_document_file_extra"=>json_encode(array_slice($row, 1, -1)),
                "land_id"=>$data["land_id"]
            ];
           if(!empty($data["col_file"][$id])){
                foreach($data["col_file"][$id] as $sli){
                    $option["file_system_id"]=$sli;
                    $status &= $this->db->insert("land_document",$option);
                }
            } else $status &= $this->db->insert("land_document",$option);
        }
        
        $status &= $this->db->update("land_user_history",[
            "land_user_history_status"=>2,
        ], "land_user_history_id =".$data["land_user_history_id"]);

        $status &= $this->db->update("land_status",[
            "land_status_type"=>2,
        ], "land_status_id =".$data["land_status_id"]);

        $status &= $this->db->update("land",[
            "land_documents_code"=>$data["land_documents_code"],
            "land_project_id"=>$data["land_project_type"],
            "land_mediator"=>$data["mediator"],
            "owner_id"=>$owner_id,
            "surface_area_id"=>$surface_area_id,
            "land_status_id"=> $data["land_status_id"],
            "map_id"=> $data["map_id"],
            //"land_date"=>$data["keterangan_owner"]
        ], "land_id =".$data["land_id"]);

        echo json_encode([ "status"=>$status ]);*/
    }
    public function initial_land() 
    {
        $data = $this->input->post(null, TRUE);
        $surface_data = $data["surface_data"]; unset($data["surface_data"]);
        $data = array_merge($data, ["land_created_user"=>$this->session->userdata('id_users')]);
        $status = true;
        $status &= $this->db->insert("land",$data);
        $insert_id = $this->db->insert_id();
        $sd_temp = [];
        foreach($surface_data as $id=>$val){
            foreach($val as $vl){
                $status &= $this->db->insert("surface_area_price",[
                    "price_per_cubic_meter"=>$vl[1],
                    "surface_area_price_type_id"=>$id,
                    "surface_area_price_year"=>$vl[2],
                    "land_id"=>$insert_id,
                ]);
                if($status) $sd_temp[$id][] = $this->db->insert_id();
            }
        }
        $status &= $this->db->insert("land_user_history",[
            "id_users"=>$this->session->userdata('id_users'),
            "land_user_history_type_id"=>1,
            "land_id"=>$insert_id
        ]);
        echo json_encode(["status"=>$status,"log_data"=>["land_id"=>$insert_id],"surface_id"=>$sd_temp]);
        /*$status &= $this->db->insert("land",[
            "land_status_type_id"=>$data["land_status_type_id"],
            "land_status_approved"=>$data["land_status_approved"],
            "land_status_approved_user"=>$data["land_status_approved_user"],
            "land_created_user"=>$data["land_created_user"],
            "land_created_date"=>$data["land_created_date"],
        ]);*/


        /*if(empty($data["map_id"]) && empty($data["land_status_id"]) && empty($data["land_id"])){
            $status = true;
            $status &= $this->db->insert("map",[
                "geolocation"=>$data["geolocation"],
                "districts_id"=>$data["loc_districts"],
                "province_id"=>$data["loc_province"],
                "sub_district_id"=>$data["loc_sub_district"],
                "village_id"=>$data["loc_village"]
            ]);
            $insert_id = $this->db->insert_id();

            $status &= $this->db->insert("land_project",[
                "land_project_type_id"=>$data["land_project_type"],
            ]);
            $land_project_id = $this->db->insert_id();
            
            $status &= $this->db->insert("land_status",[
                "land_status_type"=>1,
                "land_status_user"=>$this->session->userdata('id_users')
            ]);
            $land_status_id = $this->db->insert_id();

            $doc_number = join("_",[
                $data["loc_province"],
                $data["loc_districts"],
                $data["loc_sub_district"],
                $data["loc_village"]
            ])."_".str_pad(rand(0,100000), 8, '0', STR_PAD_LEFT);

            $status &= $this->db->insert("land",[
                "land_documents_code"=>$data["land_documents_code"],
                "land_project_id"=>$land_project_id,
                "land_mediator"=>$data["mediator"],
                "land_physics_id"=>$data["land_physics"],
                "owner_id"=>0,
                "surface_area_id"=>0,
                "land_status_id"=> $land_status_id,
                "map_id"=> $insert_id,
                //"land_date"=>$data["keterangan_owner"]
            ]);
            $land_id = $this->db->insert_id();

            $status &= $this->db->insert("land_user_history",[
                "id_users"=>$this->session->userdata('id_users'),
                "land_user_history_type_id"=>1,
                "land_id"=>$land_id
            ]);
            $land_user_history_id = $this->db->insert_id();

            echo json_encode([
                "status"=>$status,
                "log_data"=>[
                    "map_id"=>$insert_id,
                    "land_status_id"=>$land_status_id,
                    "land_project_id"=>$land_project_id,
                    "land_documents_code"=>$data["land_documents_code"],
                    "land_user_history_id"=>$land_user_history_id,
                    "land_id"=>$land_id
                ]
            ]);
        } else {
            $status = true;
            $status &= $this->db->update("map",[
                "geolocation"=>$data["geolocation"],
                "districts_id"=>$data["loc_districts"],
                "province_id"=>$data["loc_province"],
                "sub_district_id"=>$data["loc_sub_district"],
                "village_id"=>$data["loc_village"]
            ], "map_id =".$data["map_id"]);

            $status &= $this->db->update("land_status",[
                "land_status_type"=>1,
                "land_status_user"=>$this->session->userdata('id_users')
            ], "land_status_id =".$data["land_status_id"]);

            $status &= $this->db->update("land_project",[
                "land_project_type_id"=>$data["land_project_type"],
            ],"land_project_id =".$data["land_project_id"]);

            $status &= $this->db->update("land",[
                "land_documents_code"=>$data["land_documents_code"],
                "land_project_id"=>$data["land_project_type"],
                "land_mediator"=>$data["mediator"],
                "owner_id"=>0,
                "surface_area_id"=>0,
                "land_status_id"=> $data["land_status_id"],
                "map_id"=> $data["map_id"],
                //"land_date"=>$data["keterangan_owner"]
            ], "land_id =".$data["land_id"]);

            echo json_encode([
                "status"=>$status,
                "log_data"=>[]
            ]);
        }*/
        
    }
    private function array_values_recursive($arr)
    {
        foreach ($arr as $key => $value)
        {
            if(is_array($value))
            {
                $arr[$key] = array_values($value);
                $this->array_values_recursive($value);
            }
        }

        return $arr;
    }
    public function update_land() 
    {
        $status = true;
        $data = $this->input->post(null, TRUE);
        $land_id = $data["land_id"]; unset($data["land_id"]);

        if(!empty($data["documents"])){
            $col_doc = $data["documents"]; unset($data["documents"]);
            foreach($col_doc as $row){
                if(!empty($row["id"])){
                    $option = [
                        "land_document_type_id"=>$row["type"],
                        "land_document_file_type"=>$row["data"][0],
                        "land_document_file_annoations"=>$row["data"][sizeOf($row["data"])-1],
                        "land_document_file_extra"=>json_encode(array_slice($row["data"], 1, -1)),
                        "land_id"=>$land_id
                    ];
                    $this->db->update("land_document", $option, "land_document_id=".$row["id"]);
                }
            }
        }

        if(!empty($data["surface_id"])){
            $surface_id = $data["surface_id"]; unset($data["surface_id"]);
        }
        if(!empty($data["surface_data"])){
            $surface_data = $data["surface_data"]; unset($data["surface_data"]);
            $surface_array = ["", "price_per_cubic_meter", "surface_area_price_year"];
            foreach($surface_data as $id=>$val){
                foreach($val as $vl=>$isi){
                    $s_data = [];
                    foreach($isi as $i=>$v)
                        $s_data[$surface_array[$i]] = $v;
                    if(!empty($surface_id[$id][$vl])){
                        if(!empty($s_data))
                            $status &= $this->db->update("surface_area_price", $s_data, [
                                "surface_area_price_id"=>$surface_id[$id][$vl],
                                "land_id"=>$land_id
                            ]);
                    } else {
                        $s_data["surface_area_price_type_id"] = $id;
                        $s_data["land_id"] = $land_id;
                        $status &= $this->db->insert("surface_area_price",$s_data);
                        $surface_id[$id][$vl] = $this->db->insert_id();
                    }
                }
            }

            $area_price_id = $this->db->get_where("surface_area_price",["land_id"=>$land_id])->result_array();
            foreach($area_price_id as $row){
                if(!in_array($row["surface_area_price_id"], $surface_id[$row["surface_area_price_type_id"]])){
                    $this->db->delete("surface_area_price","surface_area_price_id=".$row["surface_area_price_id"]);
                }
            }
        }
        
        $data["land_status_type_id"]=1;
        $status &= $this->db->update("land",$data,["land_id"=>$land_id]);
        $status &= $this->db->update("land_user_history",[
            "land_user_history_type_id"=>2,
        ], "land_id =".$land_id);
        echo json_encode(['success'=>$status]);
    }
    public function approval(){
        $id = $this->input->post("id", TRUE);
        $data = $this->input->post("data", TRUE);
        $land_status_id = $this->input->post("user", TRUE);
        $status = true;
        if(!empty(json_decode($data,true))){
            $status &= $this->db->insert("land_comments",[
                "land_comments_json"=>$data,
                "land_comments_user"=>$this->session->userdata('id_users'),
                "land_id"=>$id
            ]);
            $status &= $this->db->update("land_user_history",[
                "land_user_history_type_id"=>3,
            ], "land_user_history_id =".$land_status_id);
            $status &= $this->db->update("land",[
                "land_status_type_id"=>3,
            ], "land_id =".$id);
        } else {
            $status &= $this->db->update("land_user_history",[
                "land_user_history_type_id"=>4,
            ], "land_user_history_id =".$land_status_id);
            $status &= $this->db->update("land",[
                "land_status_type_id"=>4,
                "land_status_approved"=>1,
                "land_status_approved_user"=>$this->session->userdata('id_users'),
            ], "land_id =".$id);
        }

        echo json_encode(["status"=>$status]);
    }

    private function _rules() 
    {
        $this->form_validation->set_rules('id_pengajar', 'id pengajar', 'trim|required');
        $this->form_validation->set_rules('id_matapelajaran', 'id matapelajaran', 'trim|required');
        $this->form_validation->set_rules('id_kelas', 'id kelas', 'trim|required');

        $this->form_validation->set_rules('id_pengampu', 'id_pengampu', 'trim');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    function get_districts(){
        $province_id = $this->input->post('id', TRUE);
        echo json_encode($this->Land_model->get_districts($province_id));
    }
    function get_sub_districts(){
        $districts_id = $this->input->post('id', TRUE);
        echo json_encode($this->Land_model->get_sub_districts($districts_id));
    }
    function get_village(){
        $sub_district_id = $this->input->post('id', TRUE);
        echo json_encode($this->Land_model->get_village($sub_district_id));
    }
    function pre_upload(){
        $source = $this->input->post(null, TRUE);
        $source["initial"] = json_decode($source["initial"], true);
        $numRows = $this->db->get_where("land_document",[
            "land_id"=>$source["land"],
            "land_document_type_id"=>$source["id"]
        ])->num_rows();
        $data["status"] = true;
        if($numRows==0){
            $data["status"] &= $this->db->insert("land_document",[
                "land_document_type_id"=>$source["id"],
                "land_document_file_type"=>$source["initial"][0],
                "land_document_file_annoations"=>$source["initial"][1],
                "land_document_file_extra"=>$source["optional"],
                "land_id"=>$source["land"],
            ]);
        } else {
            $data["status"] = false;
        }
        $data["key"] = $data["status"]?$this->db->insert_id():-1;
        echo json_encode($data);
    }
    function add_surface(){
        $array = [83=>2,84=>3];
        $source = $this->input->post(null, TRUE);
        $source["initial"] = json_decode($source["initial"], true);
        $data["status"] = true;
        $data["status"] &= $this->db->insert("surface_area_price",[
            "surface_area_price_type_id"=>$array[(int)$source["id"]],
            "price_per_cubic_meter"=>$source["initial"][0],
            "surface_area_price_year"=>$source["initial"][1],
            "land_id"=>$source["land"],
        ]);
        $data["key"] = $data["status"]?$this->db->insert_id():-1;
        echo json_encode($data);
    }

    private function delete($file){
        $status = true;
        try {
            if(!is_writable($file) || !file_exists($file))
                throw new Exception('File not writable or not found');
            unlink($file);
        }
        catch(Exception $e) {
            $status = false;
        }
        return $status;
    }
    function edit_upload(){
        $key = $this->input->post('key', TRUE);
        $name = $this->input->post('name', TRUE);
        $status = $this->db->update("file_system",["file_system_name"=>$name],["file_system_id"=>$key]);
        echo json_encode([
            'success'=>$status,
            'key'=>$key,
        ]);
    }
    function upload_delete(){
        $key = $this->input->post('key', TRUE);
        $location = $this->db->get_where("file_system",["file_system_id"=>$key])->row_array()["file_system_location"];
        $status = $this->delete($location);
        $status &= $this->db->delete("file_system",["file_system_id"=>$key]);
        echo json_encode([
            'success'=>$status,
            'key'=>$key,
        ]);
    }
    function upload_clear(){
        $id = $this->input->post('id', TRUE);
        $docs = $this->db->get_where("file_system",["land_document_id"=>$id]);
        if($docs->num_rows()!=0){
            $status = true;
            foreach($docs->result_array() as $row){
                $status &= $this->delete($row["file_system_location"]);
                $status &= $this->db->delete("file_system",["file_system_id"=>$row["file_system_id"]]);
            }
            $status &= $this->db->delete("land_document",["land_document_id"=>$id]);
        } else $status = false;
        echo json_encode(['success'=>$status]);
    }
    function upload_data($id){
        $array = ["proof_file","map_file","surface_area"];
        $val = !empty($array[$id])?$array[$id]:"";
        $config['upload_path']          = './upload/'.$val;
		$config['allowed_types']        = 'gif|jpg|jpeg|png|pdf';
		$config['encrypt_name']         = true;
		$config['file_ext_tolower']     = true;
        $this->load->library('upload', $config);
 
        $source = $this->input->post(null, TRUE);
		if (!$this->upload->do_upload('x_file')){
            $option['error'] = $this->upload->display_errors();
		}else{
            $file_location = $config['upload_path']."/".$this->upload->data("file_name");
            $status = true;
            $ats = true;
            $initialId = 0;

            $args = [
                "land_id"=>$source["land"],
                "land_document_type_id"=>$source["id"]
            ];
            if(!empty($source["hid"])){
                $args["land_document_file_extra"] = json_encode([(int)$source["hid"]]);
            }

            if($source["operate"]==2){                
                $numRows = $this->db->get_where("land_document", $args)->num_rows();
                if($numRows==0){
                    $hid = !empty($source["hid"])?[(int)$source["hid"]]:[];
                    $status &= $this->db->insert("land_document",[
                        "land_document_type_id"=>$source["id"],
                        "land_document_file_type"=>2,
                        "land_document_file_annoations"=>"",
                        "land_document_file_extra"=>json_encode($hid),
                        "land_id"=>$source["land"],
                    ]);
                    $file_land_id = $this->db->insert_id();
                    $initialId = $file_land_id;
                } else $ats = false;                
            } 
            
            if($source["operate"]==1 || !$ats){
                $file_land_id = $this->db->select("land_document_id")
                    ->get_where("land_document",$args)->row_array()["land_document_id"];
            }

            $status &= $this->db->insert("file_system",[
                "file_system_name"=>!empty($source["name"])?$source["name"]:$source["fileId"],
                "file_system_location"=>$file_location,
                "file_system_is_temp"=>0,
                "land_document_id"=>$file_land_id
            ]);            
            
            if($status){
                $file_system_id = $this->db->insert_id();
                $temp = $this->get_file_info($file_location);
                $urle = base_url("land/show_file/".$file_system_id.".".$temp["ext"]);
                $option["initialPreview"][] = $urle;
                $option["initialPreviewConfig"][] = [
                    'caption' => !empty($source["name"])?$source["name"]:$source["fileId"],
                    "filetype"=>$temp["mime"],
                    "type"=>$temp["type"],
                    'size' => $this->upload->data("file_size"),
                    'key' => $file_system_id,
                    'downloadUrl' => $urle,
                    'url' => base_url('land/upload_delete/'),
                ];
                $option["initialPreviewAsData"] = true;
                $option["uploadExtraData"] = ["id"=>$initialId];
                $option["append"] = true;
            } else {
                $option['error'] = 'Oh snap! We could not upload the "'.$source["name"].
                    '.'.$source["extension"].'" now. Please try again later.';
                unlink($file_location);
            }
        }
        echo json_encode($option);
    }
    function file_list(){
        $file_id = $this->input->post("id", TRUE);
        $file_data = $this->db->get_where("file_system",["land_document_id"=>$file_id])->result_array();
        $option = ["initialPreview"=>[], "initialPreviewConfig"=>[]];
        foreach($file_data as $row){
            $temp = $this->get_file_info($row["file_system_location"]);
            if(!empty($temp)){
                $urle = base_url("land/show_file/".$row["file_system_id"].".".$temp["ext"]);
                $option["initialPreview"][] = $urle;
                $option["initialPreviewConfig"][] = [
                    "caption"=>$row["file_system_name"],
                    "filetype"=>$temp["mime"],
                    "type"=>$temp["type"],
                    "size"=>$temp["size"],
                    "key"=>$row["file_system_id"],
                    "downloadUrl"=> $urle 
                ];
            }
        }
        echo json_encode($option);
    }
    function show_file($id){
        $image_data = $this->db->get_where("file_system",["file_system_id"=>$id])->row_array();
        header('Content-type: ' . mime_content_type($image_data["file_system_location"]));
        header('Content-Disposition: inline; filename='.basename($image_data["file_system_location"]));
        header('Content-Transfer-Encoding: binary');
        header('Accept-Ranges: bytes');
        //readfile(FCPATH. ltrim(str_replace("/","\\",$image_data["file_system_location"]), '.\\'));
        readfile($image_data["file_system_location"]);
    }
    function get_file_info($file_location){
        $filename = basename($file_location);
        $file_extension = strtolower(substr(strrchr($filename,"."),1));

        if(in_array($file_extension,["gif","png","jpeg","jpg","svg"]))
            $type = "image";
        else $type = $file_extension;

        if(file_exists($file_location)){
            $mime = mime_content_type($file_location);
            $size = filesize($file_location);
            return [
                "name" => $filename,
                "type" => $type,
                "mime" => $mime,
                "size" => $size,
                "ext" => $file_extension,
            ];
        } else {
            return [];
        }
    }
    function info_file($id){
        $image_data = $this->db->get_where("file_system",["file_system_id"=>$id])->row_array();
        $data = $this->get_file_info($image_data["file_system_location"]);
        echo json_encode($data);
    }
    function thu($id){
        $image_data = $this->db->get_where("file_system",["file_system_id"=>$id])->row_array();
        $data = $this->get_file_info($image_data["file_system_location"]);
        $data = $this->get_file_info($image_data["file_system_location"]);
            
        if($data["type"]=="pdf"){
            $mpdf = new \Mpdf\Mpdf();
            $pagecount = $mpdf->SetSourceFile($image_data["file_system_location"]);
            for ($loop = 1; $loop <= $pagecount; $loop++) {
                $tplidx = $mpdf->importPage($loop);
                $mpdf->addPage();
                $mpdf->useTemplate($tplidx);
            }
            $mpdf->SetProtection([], '1234567@A', '12345678@A', 128);
            $withoutExt = preg_replace('/\\.[^.\\s]{3,4}$/', '', $image_data["file_system_location"]);
            $mpdf->Output($withoutExt.".thumb.pdf", '');

            $this->load->library('encrypt');
            $content = file_get_contents($withoutExt.".thumb.pdf");
            $encrypted_string = $this->encrypt->encode($content, "X0@oro@0X");
            file_put_contents($withoutExt.".thumbs.pdf", $encrypted_string);
        }
    }
    function encf(){
        $location = '/upload/';
        $this->load->helper("encf");
        $key = random_bytes(32);
        echo encryptFile($location.'input.txt', $location.'cipher.txt', $key);
        decryptFile($location.'cipher.txt', $location.'decrypt.txt', $key);
    }
    function passwd(){
        $mpdf = new Mpdf(['mode' => 'utf-8']);
        $mpdf->SetSourceFile(FCPATH.'/upload/taps.pdf');
        $mpdf->SetProtection([], '1234567', '987654321', 128);
        $mpdf->Output(FCPATH.'/upload/taps.enc.pdf', '');
    }

    function surface_clear(){
        $id = $this->input->post('id', TRUE);
        $hid = $this->input->post('hid', TRUE);
        $surface = $this->db->get_where("surface_area_price",["surface_area_price_id"=>$hid]);
        if($surface->num_rows()!=0){
            $status = true;
            $docs = $this->db->get_where("file_system",["land_document_id"=>$id]);
            if($docs->num_rows()!=0){
                foreach($docs->result_array() as $row){
                    $status &= $this->delete($row["file_system_location"]);
                    $status &= $this->db->delete("file_system",["file_system_id"=>$row["file_system_id"]]);
                }
                $status &= $this->db->delete("land_document",["land_document_id"=>$id]);
            }
            $status &= $this->db->delete("surface_area_price",["surface_area_price_id"=>$hid]);
        } else $status = false;
        echo json_encode(['success'=>$status]);
    }

    public function export() {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->mergeCells("A2:A4");
        $sheet->setCellValue('A2','No.');

        $sheet->mergeCells("B2:G3");
        $sheet->setCellValue('B2','Land Detail');
        $sheet->setCellValue('B4','Code');
        $sheet->setCellValue('C4','Project');
        $sheet->setCellValue('D4','Physic');
        $sheet->setCellValue('E4','Mediator');
        $sheet->setCellValue('F4','Dipatok');
        $sheet->setCellValue('G4','PTSL');

        $sheet->mergeCells("H2:J3");
        $sheet->setCellValue('H2','Owner');
        $sheet->setCellValue('H4','Original');
        $sheet->setCellValue('I4','New');
        $sheet->setCellValue('J4','PPJB');

        $sheet->mergeCells("K2:N3");
        $sheet->setCellValue('K2','Location');
        $sheet->setCellValue('K4','Province');
        $sheet->setCellValue('L4','Districts');
        $sheet->setCellValue('M4','Sub Districts');
        $sheet->setCellValue('N4','Village');

        $sheet->mergeCells("O2:T2");
        $sheet->setCellValue('O2','Surface Area');

        $sheet->mergeCells("O3:Q3");
        $sheet->setCellValue('O3','By System');
        $sheet->setCellValue('O4','Documents');
        $sheet->setCellValue('P4','Remeasurement');
        $sheet->setCellValue('Q4','GPS');

        $sheet->mergeCells("R3:T3");
        $sheet->setCellValue('R3','By Puchase');
        $sheet->setCellValue('R4','Initial');
        $sheet->setCellValue('S4','Remeasurement');
        $sheet->setCellValue('T4','Documents');

        $sheet->mergeCells("U2:V3");
        $sheet->setCellValue('U2','Puchase');
        $sheet->setCellValue('U4','Price');
        $sheet->setCellValue('V4','Year');
        
        $sheet->getStyle("A2:V4")->applyFromArray(
            [
                'font' => [
                    'color' => ['rgb' => '000000'],
                    //'size' => 12,
                    'name' => 'Arial',
                    'bold' => true,
                ],
                'alignment' => [
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                    'horizontal' => "center",
                    //'wrapText' => $wrapText
                ],
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => "thin",
                        'color' => ['rgb' => "000000"],
                    ]
                ]
            ]
        );

        $temp = $this->db->select("
            land_documents_code,
            land_project_type_name,
            land_physics_name,
            land_mediator,
            if(land_di_patok=1, 'Yes', 'No') as land_di_patok,
            if(land_di_ptsl=1, 'Yes', 'No') as land_di_ptsl,
            owner_initial_name,
            owner_final_name,
            owner_ppjb,
            province_name,
            districts_name,
            sub_district_name,
            village_name,
            surface_area_by_doc,
            surface_area_by_remeas,
            surface_area_by_geo,
            surface_area_by_purchase,
            surface_area_by_purchase_doc,
            surface_area_by_purchase_ukur,
            price_per_cubic_meter,
            price_per_cubic_meter,
            surface_area_price_year
        ")->join("land_project_type","land.land_project_id = land_project_type.land_project_type_id")
        ->join("land_physics","land.land_physics_id = land_physics.land_physics_id")
        ->join("loc_province","land.map_province_id = loc_province.province_id")
        ->join("loc_districts","land.map_districts_id = loc_districts.districts_id")
        ->join("loc_sub_district","land.map_sub_district_id = loc_sub_district.sub_district_id")
        ->join("loc_village","land.map_village_id = loc_village.village_id")
        ->join("surface_area_price","land.land_id = surface_area_price.land_id")
        ->get_where('land',"land.land_status_approved<>0 and surface_area_price_type_id=1")->result_array();

        $num = 0;
        foreach($temp as $id=>$row){
            $num = ($id+5);
            $sheet->setCellValue('A'.$num, ($id+1));
            $col = 'B';
            foreach($row as $val){
                $sheet->setCellValue($col.$num, $val);
                $col++;
            }
        }

        $sheet->getStyle("A5:V".$num)->applyFromArray(
            [
                'font' => [
                    'color' => ['rgb' => '000000'],
                    //'size' => 12,
                    'name' => 'Arial',
                ],
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => "thin",
                        'color' => ['rgb' => "000000"],
                    ]
                ]
            ]
        );
        $sheet->getStyle("O5:U".$num)->getNumberFormat()->setFormatCode("#,##0");


        for ($i = 'A'; $i !=  $sheet->getHighestColumn(); $i++) {
            $sheet->getColumnDimension($i)->setAutoSize(TRUE);
        }

        $file_name = 'Land_List_'.time();
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'.$file_name.'.xlsx"');
        header('Cache-Control: max-age=0');
        $objWriter = new Xlsx($spreadsheet);
        $objWriter->save('php://output');
    }
}