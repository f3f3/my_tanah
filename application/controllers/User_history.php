<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class User_history extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        is_login();
        $this->load->model('User_history_model','user_history');
        $this->load->library('form_validation');        
	    $this->load->library('datatables');
    }

    public function json() {
        header('Content-Type: application/json');
        echo $this->user_history->json();
    }

    public function json_log() {
        header('Content-Type: application/json');
        echo $this->user_history->json_log();
    }

    public function json_submission() {
        header('Content-Type: application/json');
        echo $this->user_history->json_submission();
    }
    
    public function log($limit=null,$offset=null)
    {
        $this->db->select("
            land.land_id,
            land.land_documents_code, 
            land_user_history_type.land_user_history_type_name,
            tbl_user.full_name,
            land_user_history.land_user_history_was_viewed
        ")
        ->order_by("land.land_id","desc")
        //->where("land_user_history_was_viewed",0)
        ->where("land_user_history.land_user_history_type_id<>1")
        ->limit(5)
        ->join("land_user_history","land.land_id = land_user_history.land_id")
        ->join("tbl_user","tbl_user.id_users = land_user_history.id_users")
        ->join("land_user_history_type","land_user_history.land_user_history_type_id = land_user_history_type.land_user_history_type_id");

        if(!empty($limit))
            if(!empty($offset)) $this->db->limit($limit,$offset);
                else $this->db->limit($limit);

        if($this->session->userdata('id_user_level')!=1)
            $this->db->where("land_user_history.id_users",$this->session->userdata('id_users'));
        //echo json_encode($this->db->get('land')->result_array());
        $data = []; $translate = ["Submission"=>"Mengajukan","Revision"=>"Merevisi","Done"=>"Menyelesaikan"];
        $icon = ["fa fa-envelope-o","fa fa-envelope-open-o"];
        $first_name = function($full_name){
            return substr(explode(" ",$full_name)[0], 0, 15) . strlen($full_name)>15?"...":"";
        };
        foreach($this->db->get('land')->result_array() as $row){
            $data[] = [
                $row["land_id"],
                $first_name($row["full_name"])." ".
                $translate[$row["land_user_history_type_name"]]." Dokumen No. [..._".
                substr($row["land_documents_code"],-8)."]",
                $icon[$row["land_user_history_was_viewed"]]
            ];
        }

        if($this->session->userdata('id_user_level')!=1)
            $this->db->where("land_user_history.id_users",$this->session->userdata('id_users'));
        $count = $this->db->where("land_user_history_was_viewed",0)->get("land_user_history")->num_rows();

        echo json_encode(["data"=>$data,"count"=>$count]);
    }

    public function index()
    {
        $this->template->load('template','land/user_history');
    }

    public function loging()
    {
        $this->template->load('template','land/user_log');
    }

    public function submission()
    {
        $this->template->load('template','land/user_submission');
    }
}