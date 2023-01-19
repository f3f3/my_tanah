<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Tbl_pengampu_model extends CI_Model
{

    public $table = 'tbl_pengampu';
    public $id = 'id_pengampu';
    public $order = 'DESC';

    function __construct()
    {
        parent::__construct();
    }

    // datatables
    function json() {
        $this->datatables->select('id_pengampu,nama,matapelajaran,kelas');
        $this->datatables->from('tbl_pengampu');
        $this->datatables->join('tbl_pengajar', 'tbl_pengampu.id_pengajar = tbl_pengajar.id_pengajar');
        $this->datatables->join('tbl_matapelajaran', 'tbl_pengampu.id_matapelajaran = tbl_matapelajaran.id_matapelajaran');
        $this->datatables->join('tbl_kelas', 'tbl_pengampu.id_kelas = tbl_kelas.id_kelas');
        $this->datatables->add_column('action', anchor(site_url('tbl_pengampu/update/$1'),'<i class="fa fa-pencil-square-o" aria-hidden="true"></i>', array('class' => 'btn btn-danger btn-sm'))." 
                ".anchor(site_url('tbl_pengampu/delete/$1'),'<i class="fa fa-trash-o" aria-hidden="true"></i>','class="btn btn-danger btn-sm" onclick="javasciprt: return confirm(\'Are You Sure ?\')"'), 'id_pengampu');
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
        $this->db->like('id_pengampu', $q);
	$this->db->or_like('id_pengajar', $q);
	$this->db->or_like('id_matapelajaran', $q);
	$this->db->or_like('id_kelas', $q);
	$this->db->from($this->table);
        return $this->db->count_all_results();
    }

    // get data with limit and search
    function get_limit_data($limit, $start = 0, $q = NULL) {
        $this->db->order_by($this->id, $this->order);
        $this->db->like('id_pengampu', $q);
	$this->db->or_like('id_pengajar', $q);
	$this->db->or_like('id_matapelajaran', $q);
	$this->db->or_like('id_kelas', $q);
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

/* End of file Tbl_pengampu_model.php */
/* Location: ./application/models/Tbl_pengampu_model.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2019-05-11 03:34:02 */
/* http://harviacode.com */