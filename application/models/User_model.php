<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class User_model extends CI_Model
{

    public $table = 'tbl_user';
    public $id = 'id_users';
    public $order = 'DESC';

    function __construct()
    {
        parent::__construct();
    }

    // datatables
    function json() {
        $this->datatables->select('tbl_user.id_users,full_name,email,nama_level,is_aktif, IF(IsNull(login_details.last_activity),0,1) as is_online');
        $this->datatables->from('tbl_user');
        $this->datatables->add_column('is_aktif', '$1', 'rename_string_is_aktif(is_aktif)');
        $this->datatables->add_column('is_online', '$1', 'rename_string_is_online(is_online)');
        //add this line for join
        $this->datatables->join('tbl_user_level', 'tbl_user.id_user_level = tbl_user_level.id_user_level');
        $this->datatables->join('login_details', 'tbl_user.id_users = login_details.id_users
                 AND login_details.last_activity > DATE_SUB(NOW(), INTERVAL 7200 SECOND)','left');
        $this->datatables->add_column('action',anchor(site_url('user/update/$1'),'<i class="anticon anticon-edit" aria-hidden="true"></i>', array('class' => 'btn btn-danger btn-sm'))." 
                ".anchor(site_url('user/delete/$1'),'<i class="anticon anticon-delete" aria-hidden="true"></i>','class="btn btn-danger btn-sm" onclick="javasciprt: return confirm(\'Are You Sure ?\')"'), 'id_users');
        return $this->datatables->generate();
    }

    // get all
    function get_all()
    {
        $this->db->order_by($this->id, $this->order);
        return $this->db->get($this->table)->result();
    }

    // get data by id
    function get_by_id($id)
    {
        $this->db->where($this->id, $id);
        return $this->db->get($this->table)->row();
    }
    
    // get total rows
    function total_rows($q = NULL) {
        $this->db->like('id_users', $q);
	$this->db->or_like('full_name', $q);
	$this->db->or_like('email', $q);
	$this->db->or_like('password', $q);
	$this->db->or_like('images', $q);
	$this->db->or_like('id_user_level', $q);
	$this->db->or_like('is_aktif', $q);
	$this->db->from($this->table);
        return $this->db->count_all_results();
    }

    // get data with limit and search
    function get_limit_data($limit, $start = 0, $q = NULL) {
        $this->db->order_by($this->id, $this->order);
        $this->db->like('id_users', $q);
	$this->db->or_like('full_name', $q);
	$this->db->or_like('email', $q);
	$this->db->or_like('password', $q);
	$this->db->or_like('images', $q);
	$this->db->or_like('id_user_level', $q);
	$this->db->or_like('is_aktif', $q);
	$this->db->limit($limit, $start);
        return $this->db->get($this->table)->result();
    }

    // insert data
    function insert($data)
    {
        $this->db->insert($this->table, $data);
    }

    // update data
    function update($id, $data)
    {
        $this->db->where($this->id, $id);
        $this->db->update($this->table, $data);
    }

    // delete data
    function delete($id)
    {
        $this->db->where($this->id, $id);
        $this->db->delete($this->table);
    }

}

/* End of file User_model.php */
/* Location: ./application/models/User_model.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2017-10-04 06:32:22 */
/* http://harviacode.com */