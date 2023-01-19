<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class User_history_model extends CI_Model
{
    // datatables
    function json() {
	    $this->load->library('tabulator');

        $this->tabulator->select("
            land.land_id, 
            land.land_documents_code, 
            land.land_status_approved, 
            (SELECT tbl_user.full_name FROM tbl_user WHERE tbl_user.id_users = land.land_status_approved_user ) as land_status_approved_user,
            land_user_history.land_user_history_date, 
            land_status_type.land_status_type_name,
            land_user_history_type.land_user_history_type_name,
            IFNULL((SELECT land_comments_status FROM land_comments WHERE land_comments.land_id=land.land_id LIMIT 1),3) as land_comments_status,
            (
                SELECT tbl_user.full_name
                FROM land_comments
                INNER JOIN tbl_user ON tbl_user.id_users = land_comments.land_comments_user
                WHERE land_comments.land_id=land.land_id
                ORDER BY land_comments.land_comments_id
                LIMIT 1
            ) AS land_comments_user
        ")
        ->join("land_status_type","land.land_status_type_id = land_status_type.land_status_type_id")
        ->join("land_user_history","land.land_id = land_user_history.land_id")
        ->join("land_user_history_type","land_user_history.land_user_history_type_id = land_user_history_type.land_user_history_type_id")
        //->limit(1)
        ->where("land_user_history.id_users",$this->session->userdata('id_users'))
        ->from('land');

        $this->tabulator->edit_column('land_status_approved','$1','rename_string_is_approved(land_status_approved)');
        //add this line for join
        //$this->datatables->join('table2', 'land_document_type.field = table2.field');
        $this->tabulator->add_column('action', '$1', 'rename_string_to_url(land_id,land_comments_status)');
        return $this->tabulator->generate();
    }

    function json_log(){
        $this->load->library('tabulator');
        
        $this->tabulator->select("
            land.land_id,
            land.land_documents_code, 
            land_user_history_type.land_user_history_type_name,
            tbl_user.full_name,
            land_user_history.land_user_history_was_viewed,
            land_user_history.land_user_history_date
        ")
        //->order_by("land.land_id","desc")
        //->where("land_user_history_was_viewed",0)
        ->where("land_user_history.land_user_history_type_id<>1")
        ->join("land_user_history","land.land_id = land_user_history.land_id")
        ->join("tbl_user","tbl_user.id_users = land_user_history.id_users")
        ->join("land_user_history_type","land_user_history.land_user_history_type_id = land_user_history_type.land_user_history_type_id")
        ->from('land');

        return $this->tabulator->generate();
    }

    function json_submission(){
        $this->load->library('tabulator');
        
        $this->tabulator->select("
            land.land_id,
            land.land_documents_code, 
            tbl_user.full_name,
            land_user_history.land_user_history_was_viewed,
            land_user_history.land_user_history_date
        ")
        //->order_by("land.land_id","desc")
        //->where("land_user_history_was_viewed",0)
        ->where("land.land_status_type_id=2")
        ->join("land_user_history","land.land_id = land_user_history.land_id")
        ->join("tbl_user","tbl_user.id_users = land_user_history.id_users")
        ->join("land_user_history_type","land_user_history.land_user_history_type_id = land_user_history_type.land_user_history_type_id")
        ->from('land');

        $this->tabulator->add_column('action',anchor(site_url('land/show_data/$1'),'<i class="anticon anticon-eye"></i>', array('class' => 'btn btn-success btn-icon btn-sm btn-rounded')), 'land_id');
        return $this->tabulator->generate();
    }
}