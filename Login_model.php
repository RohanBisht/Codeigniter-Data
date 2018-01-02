<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
* 
*/
class Login_model extends CI_model
{
	
	function __construct()
	{
		parent :: __construct();
	}

	public function login($data) {
		$condition = "username =" . "'" . $data['username'] . "' AND " . "password =" . "'" . $data['password'] . "'";
			$this->db->select('*');
			$this->db->from('tbl_login');
			$this->db->where($condition);
			$this->db->limit(1);
			$query = $this->db->get();

			if ($query->num_rows() == 1) {
			return true;
			} else {
			return false;
			}
	}

// Read data from database to show data in admin page
	public function read_user_information($username) {
		$condition = "username =" . "'" . $username . "'";
		$this->db->select('*');
		$this->db->from('tbl_login');
		$this->db->where($condition);
		$this->db->limit(1);
		$query = $this->db->get();
		if ($query->num_rows() == 1) {
		return $query->result();
		} else {
		return false;
		}
}

 public function is_logged_in(){
        if($this->session->userdata['user_logged_in']){
            return true;
        }
        else{
             $this->session->set_flashdata('feedback','Please login!');
             redirect('login');
       }
      }
}
?>