<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Land_model extends CI_Model
{
    // datatables
    function json() {
	    $this->load->library('tabulator');

        $this->tabulator->select("*")->from('land');

        $this->tabulator->add_column("location_target","loc_districts");
        $this->tabulator->add_column("_children",[]);
        //add this line for join
        //$this->datatables->join('table2', 'land_document_type.field = table2.field');
        //$this->tabulator->add_column('action', anchor(site_url('land/update/$1'),'<i class="fa fa-pencil-square-o" aria-hidden="true"></i>', array('class' => 'btn btn-danger btn-sm'))." 
        //        ".anchor(site_url('land/delete/$1'),'<i class="fa fa-trash-o" aria-hidden="true"></i>','class="btn btn-danger btn-sm" onclick="javasciprt: return confirm(\'Are You Sure ?\')"'), 'land_document_type_id');
        return $this->tabulator->generate();
    }

    function get_data_tree(){
        $temp = $this->db->select("
            land_id,
            province_name,
            districts_name,
            sub_district_name,
            village_name,
            land_documents_code,
            land_physics_name,
            land_project_type_name,
            surface_area_by_purchase,
            surface_area_by_doc,
            surface_area_by_purchase_ukur,
            surface_area_by_remeas,
            surface_area_by_geo,
            land_mediator,
            land_di_patok,
            land_di_ptsl,
            owner_initial_name,
            owner_final_name,
            owner_ppjb
        ")->join("land_project_type","land.land_project_id = land_project_type.land_project_type_id")
        ->join("land_physics","land.land_physics_id = land_physics.land_physics_id")
        ->join("loc_province","land.map_province_id = loc_province.province_id")
        ->join("loc_districts","land.map_districts_id = loc_districts.districts_id")
        ->join("loc_sub_district","land.map_sub_district_id = loc_sub_district.sub_district_id")
        ->join("loc_village","land.map_village_id = loc_village.village_id")
        ->get_where('land',"land.land_status_approved<>0")->result_array();
        
        $array = [];
        foreach($temp as $row){
            $array[$row["province_name"]][$row["districts_name"]][$row["sub_district_name"]][$row["village_name"]] = array_merge(
                array_splice($row,5),
                ["action"=>anchor(site_url('land/show_data/'.$row["land_id"]),'<i class="anticon anticon-eye"></i>', array('class' => 'btn btn-success btn-icon btn-sm btn-rounded'))." ".
                    anchor(site_url('land/update/'.$row["land_id"]),'<i class="anticon anticon-edit"></i>', array('class' => 'btn btn-primary btn-icon btn-sm btn-rounded'))." ".
                    anchor(site_url('#'),'<i class="anticon anticon-delete"></i>','class="btn btn-danger btn-icon btn-sm btn-rounded" onclick="javasciprt: return confirm(\'Are You Sure ?\')"')]
            );
        }
        $content = [
            "land_documents_code"=>"",
            "land_physics_name"=>"",
            "land_project_type_name"=>"",
            "surface_area_by_doc"=>0,
            "surface_area_by_remeas"=>0,
            "surface_area_by_geo"=>0
        ];
        $a = 0; $fouler_a=[];
        foreach($array as $id=>$val){
            $b = 0; $fouler_b=[];
            $fouler_a[$a] = array_merge(["location"=>$id],$content);
            foreach($val as $ida=>$vala){
                $c = 0; $fouler_c=[];
                $fouler_b[$b] = array_merge(["location"=>$ida],$content);
                foreach($vala as $idb=>$valb){
                    $fouler_d = [];
                    $fouler_c[$c] = array_merge(["location"=>$idb],$content);
                    foreach($valb as $idc=>$valc){
                        $fouler_d[] = array_merge(["location"=>$idc],$valc);
                        $fouler_c[$c]["surface_area_by_doc"] += $valc["surface_area_by_doc"];
                        $fouler_c[$c]["surface_area_by_remeas"] += $valc["surface_area_by_remeas"];
                        $fouler_c[$c]["surface_area_by_geo"] += $valc["surface_area_by_geo"];
                    }
                    $fouler_c[$c]["_children"] = $fouler_d;
                    $fouler_b[$b]["surface_area_by_doc"] += $fouler_c[$c]["surface_area_by_doc"];
                    $fouler_b[$b]["surface_area_by_remeas"] += $fouler_c[$c]["surface_area_by_remeas"];
                    $fouler_b[$b]["surface_area_by_geo"] += $fouler_c[$c]["surface_area_by_geo"];
                    $c++;
                }
                $fouler_b[$b]["_children"] = $fouler_c;
                $fouler_a[$a]["surface_area_by_doc"] += $fouler_b[$b]["surface_area_by_doc"];
                $fouler_a[$a]["surface_area_by_remeas"] += $fouler_b[$b]["surface_area_by_remeas"];
                $fouler_a[$a]["surface_area_by_geo"] += $fouler_b[$b]["surface_area_by_geo"];
                $b++;
            }
            $fouler_a[$a]["_children"] = $fouler_b;
            $a++;
        }

        return $fouler_a;
    }
    function get_initial_data($id, $show_data=false){
        $tmp = $this->db->select("land_comments_json")
            ->order_by("land_comments_id","DESC")
            ->get_where("land_comments","land_id=".$id)
            ->row_array();
        $data["comments"] = (!empty($tmp["land_comments_json"]))?json_decode($tmp["land_comments_json"], TRUE):[];
        
        if($show_data) {
            $this->db->select("
                land.*,
                land_status_type_name,
                land_physics_name,
                land_project_type_name,
                province_name,
                districts_name,
                sub_district_name,
                village_name,
            ")
            ->join("land_status_type","land.land_status_type_id = land_status_type.land_status_type_id")
            ->join("land_physics","land.land_physics_id = land_physics.land_physics_id")
            ->join("land_project_type","land.land_project_id = land_project_type.land_project_type_id")
            ->join("loc_province","land.map_province_id = loc_province.province_id")
            ->join("loc_districts","land.map_districts_id = loc_districts.districts_id")
            ->join("loc_sub_district","land.map_sub_district_id = loc_sub_district.sub_district_id")
            ->join("loc_village","land.map_village_id = loc_village.village_id");
        }
        $data["land"] = $this->db->get_where("land","land_id=".$id)->row_array();
        
        $tempz = $this->db->get_where("surface_area_price","land_id=".$id)->result_array();
        foreach($tempz as $row){
            $data["surface_area"][$row["surface_area_price_type_id"]][] = [$row["price_per_cubic_meter"],$row["surface_area_price_year"],$row["surface_area_price_id"]];
        }

        if($show_data) {
            $this->db->select('
                land_document.*,
                (CASE
                    WHEN land_document_file_type=0 THEN "ASLI"
                    WHEN land_document_file_type=1 THEN "COPY"
                    WHEN land_document_file_type=2 THEN "N/A"
                END) AS land_document_file_type_name,
                land_document_type_name,
                land_document_type_extra
            ')
            ->join("land_document_type","land_document_type.land_document_type_id = land_document.land_document_type_id");
            //->where("land_document_type.land_document_category_id=1");
        }
        $data["documents"] = [];
        $tempy = $this->db->get_where("land_document","land_id=".$id)->result_array();
        foreach($tempy as $row){
            $data_documents = [
                "document_id" => $row["land_document_id"],
                "file_type" => intval($row["land_document_file_type"]),
                "file_annoations" => $row["land_document_file_annoations"],
            ];
            $file_extra = json_decode($row["land_document_file_extra"], TRUE);
            if($show_data) {
                $type_extra = json_decode($row["land_document_type_extra"], TRUE);
                if(count($type_extra) != count($file_extra))
                    $file_extra = array_fill(0, count($type_extra),"");
                $file_extra = array_combine($type_extra, $file_extra);
                $data_documents["document_name"] = $row["land_document_type_name"];
                $data_documents["file_type_name"] = $row["land_document_file_type_name"];
            }
            $data_documents["file_extra"] = $file_extra;
            if(!in_array($row["land_document_type_id"],[83,84])){
                $data["documents"][$row["land_document_type_id"]] = $data_documents;
            } else {
                $data["documents"][$row["land_document_type_id"]][] = $data_documents;
            }
        }

        $data["history"] = $this->db->get_where("land_user_history", ["land_id"=>$id, "id_users"=>$this->session->userdata('id_users')])->row_array();
        return $data;
    }
    
    function get_districts($province_id){
        $data = $this->db->select("districts_id,districts_name")->get_where("loc_districts",array("province_id"=>$province_id))->result_array();
        $result = [];
        foreach($data as $row){
            $result[$row["districts_id"]] = $row["districts_name"];
        }
        return $result;
    }
    function get_sub_districts($districts_id){
        $data = $this->db->select("sub_district_id,sub_district_name")->get_where("loc_sub_district",array("districts_id"=>$districts_id))->result_array();
        $result = [];
        foreach($data as $row){
            $result[$row["sub_district_id"]] = $row["sub_district_name"];
        }
        return $result;
    }
    function get_village($sub_district_id){
        $data = $this->db->select("village_id,village_name")->get_where("loc_village",array("sub_district_id"=>$sub_district_id))->result_array();
        $result = [];
        foreach($data as $row){
            $result[$row["village_id"]] = $row["village_name"];
        }
        return $result;
    }
}