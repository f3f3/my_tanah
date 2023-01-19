<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

Class Auth extends CI_Controller{
    
    function __construct()
    {
        parent::__construct();
    }

    function index(){
        if( !$this->session->userdata('id_user_level')){
            $this->load->view('auth/login');
        }else{
            redirect("user");
        }        
    }

    function cheklogin(){
        $ids    = $this->input->post('ids');
        $password = $this->input->post('password',TRUE);
        $hashPass = password_hash($password,PASSWORD_DEFAULT);
        $test     = password_verify($password, $hashPass);
        $this->db->where('email',$ids);

        $users    = $this->db->get('tbl_user');
        if($users->num_rows()>0){
            $user = $users->row_array();
            if(password_verify($password,$user['password'])){
                $this->session->set_userdata($user);
                redirect('dashboard');
            }else{
                redirect('auth');
            }
        }else{
            $this->session->set_flashdata('status_login','pastikan email atau password sesuai!');
            redirect('auth');
        }
    }

    function cheklogins(){
        $ids  = $this->input->post('ids', TRUE);
        $password = $this->input->post('password',TRUE);
        $pass = MD5($password);
        $state = true;

        $user = $this->db->get_where("tbl_pelajar","`nis`='".$ids."' AND `password`='".$pass."'", 1)->row_array();
                
        if(is_array($user) && sizeof($user)!=0){
           $user['id_user_level'] = 4;          
        }else{
            $user = $this->db->get_where("tbl_pengajar", "`nip`='".$ids."' AND `password`='".$pass."'", 1)->row_array();
            if (is_array($user) && sizeof($user)!=0) {
                $user['id_user_level'] = 3;
            } else {
                $user = $this->db->get_where("tbl_user","`email`='".$ids."'", 1)->row_array();
                if (is_array($user) && sizeof($user)!=0) {
                    if(!password_verify($password,$user['password'])){
                        $this->session->set_flashdata('status_login','Username atau Password yang anda input salah');
                        $this->load->view('auth/login');
                    }
                } else {
                    $state = false;
                    $this->session->set_flashdata('status_login','Username atau Password yang anda input salah');
                    $this->load->view('auth/login');
                }
            }
        }
        
        if ($state) {
            unset($user['password']);
            $user['full_name'] = !empty($user['full_name'])?$user['full_name']:$user['nama'];
            $user['images'] = !empty($user['images'])?$user['images']:'atomix_user31.png';

            $this->db->insert('login_details',[
                'id_users' => $user['id_users'],
                'last_activity' =>date("Y-m-d H:i:s", STRTOTIME(date('h:i:sa')))
            ]);

            $user['last_id'] = $this->db->insert_id();
            
            if(!empty($user['last_id'])) {
                $this->session->set_userdata($user);
                //$this->onlineusers->set_userdata($user);
                redirect('welcome');
            } else {
                $this->session->set_flashdata('status_login','Error Database !!!');
                $this->load->view('auth/login');
            }
        }
    }
    
    function logout(){
        $this->session->sess_destroy();
        $this->session->set_flashdata('status_login','Anda sudah berhasil keluar dari aplikasi');
        $this->load->view('auth/login');
    }
}
