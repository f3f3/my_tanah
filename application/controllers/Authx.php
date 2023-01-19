<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

Class Auths extends CI_Controller{
    
    function __construct()
    {
        parent::__construct();
    }

    function index(){
        $this->load->view('auth/login');
    }
    
    function cheklogin(){
        $ids  = $this->input->post('ids', TRUE);
        $pass = MD5($this->input->post('password',TRUE));
        
        if(sizeof($user = $this->get_auth("`nis`='".$ids."' AND `password`='".$pass."'", "tbl_pelajar")) != 0){
           $user['id_user_level'] = 4;          
        }elseif(sizeof($user = $this->get_auth("`nip`='".$ids."' AND `password`='".$pass."'", "tbl_pengajar")) != 0){
            $user['id_user_level'] = 3;
        }else{
            $users = $this->db->get_where('tbl_user',array('email'=>$ids),1);
            if($users->num_rows()!=0){
                $user = $users->row_array();
                if(password_verify($ids,$user['password'])){
                    $this->session->set_userdata($user);
                    redirect('welcome');
                }
            }
            
            $this->session->set_flashdata('status_login','email atau password yang anda input salah');
            redirect('auth');
        }
        
        $user['full_name'] = $user['nama'];
        $user['images'] = 'atomix_user31.png';
        $this->session->set_userdata($user);
        redirect('welcome');
    }
    
    function logout(){
        $this->session->sess_destroy();
        $this->session->set_flashdata('status_login','Anda sudah berhasil keluar dari aplikasi');
        redirect('auth');
    }

    private function get_auth($where, $table)
    {
       $this->db->where($where);
       return $this->db->get($table)->row_array();
    }
}
