<?php
/*
Online Users class
@package CodeIgniter
@subpackage Libraries
@category Add-Ons
@author MoShair
@link http://php-max.com/ci
*/
class Onlineusers {
  private $CI;
  public function __construct() {
    $this->Onlineusers();
  }
  function Onlineusers() {
    $CI = & get_instance();
    $CI->config->load('authme');
    $ip = $_SERVER['REMOTE_ADDR'];
    if (stristr($CI->config->item('onlineusers_timeoffset'), '+')) {
      $date = time() + ($CI->config->item('onlineusers_timeoffset') * 60 * 60);
    }
    else {
      $date = time() - ($CI->config->item('onlineusers_timeoffset') * 60 * 60);
    }
    $uri = $_SERVER['REQUEST_URI'];
    $username = 'Guest';
    $user_id = 0;
    $is_bot = 0;
    $agent = strip_tags($_SERVER['HTTP_USER_AGENT']);
    $agent = addslashes($agent);
    if (logged_in()) {
      $user = $CI->session->userdata('user');
      $username = user('username');
      $user_id = user('id');
      $online = $this->_checkuser($username);
    }
    else {
      $online = $this->_checkguest($ip);
    }
    if ($online == 0) {
      if (!logged_in()) {
        if ($CI->session->userdata('username')) {
          $username = $CI->session->userdata('username');
        }
        else {
          if (!isset ($CI->agent)) {
            $CI->load->library('user_agent');
            $class_loaded = true;
          }
          if ($CI->agent->is_robot()) {
            $is_bot = 1;
            $username = $CI->agent->robot();
          }
          if ($class_loaded) {
            unset ($class_loaded, $CI->agent);
          }
        }
      }
      $timeout = $date - $CI->config->item('onlineusers_timeout');
      $CI->db->where('logged <=', $timeout);
      $CI->db->delete('online');
      $arr = array('username' => $username, 'user_id' => $user_id, 'logged' => $date, 'user_ip' => $ip, 'path' => $uri, 'is_bot' => $is_bot, 'agent' => $agent);
      $CI->db->insert('online', $arr);
    }
  }
  function _checkuser($username) {
    $CI = & get_instance();
    $CI->db->select('id,username');
    $CI->db->where('username =', $username);
    return $CI->db->count_all_results('online');
  }
  function _checkguest($ip) {
    $CI = & get_instance();
    $CI->db->select('id,user_ip,user_id');
    $CI->db->where('user_ip =', $ip);
    $CI->db->where('user_id =', 0);
    return $CI->db->count_all_results('online');
  }
  function get_info() {
    $CI = & get_instance();
    $CI->db->select('id,user_ip,username,user_id,is_bot,logged');
    $CI->db->order_by('id', 'desc');
    $CI->db->limit(50);
    $query = $CI->db->get('online');
    return $query->result();
  }
  function total_visit() {
    $CI = & get_instance();
    $CI->db->select('id');
    return $CI->db->count_all_results('online');
  }
  function get_all_info($page) {
    $CI = & get_instance();
    $CI->db->select('id,user_ip,username,logged,user_id,is_bot,agent,path');
    $CI->db->order_by('logged', 'desc');
    $CI->db->limit(15, $page);
    $query = $CI->db->get('online');
    return $query->result();
  }
  function delete_online_user() {
    $CI = & get_instance();
    if (logged_in()) {
      $user = $CI->session->userdata('user');
      $user_id = user('id');
      $CI->db->where('user_id =', $user_id);
    }
    else {
      $CI->db->where('user_ip =', $_SERVER['REMOTE_ADDR']);
      $CI->db->where('user_id =', 0);
    }
    $CI->db->delete('online');
  }
}
