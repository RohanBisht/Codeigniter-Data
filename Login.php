<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

/**
* 
*/
class Login extends CI_Controller
{
	
	function __construct()
	{
		parent :: __construct();
		$this->load->model('Login_model');
	}

	public function index(){
		if (isset($this->session->userdata['user_logged_in'])) {
			redirect('dashboard');
		}
		else{
			 $data['page_title'] = 'Login';
			$this->load->view('admin/login' ,$data);
		}
	}

	public function user_login_process() {
		if (isset($session_set_value['remember']) && $session_set_value['remember'] == "1") {
			redirect('dashboard');
				} else {
					$this->load->library('form_validation');
					$this->form_validation->set_rules('username', 'Username', 'trim|required');
					$this->form_validation->set_rules('password', 'Password', 'trim|required');

					if ($this->form_validation->run() == FALSE) {
					if(isset($this->session->userdata['user_logged_in'])){
					redirect('dashboard');
					}else{
					redirect('login');
					}
					} else {
					$data = array(
					'username' => $this->input->post('username'),
					'password' => md5($this->input->post('password'))
					);
					$result = $this->Login_model->login($data);
					if ($result == TRUE) {
					$remember = $this->input->post('remember');
					if ($remember) {
						$this->session->set_userdata('remember', TRUE);
					}
					$username = $this->input->post('username');
					$result = $this->Login_model->read_user_information($username);
					if ($result != false) {
					$session_data = array(
					'username' => $result[0]->username,
					'admin_id' => $result[0]->login_id
					);
					$this->session->set_userdata('user_logged_in', $session_data);
					redirect('dashboard');
					}
					} else {
					$this->session->set_flashdata('error', 'Invalid Username or Password');
					redirect('login');
					}
					}
				}
					
			}

		public function logout() {
			$sess_array = array(
					'username' => '',
					'admin_id' => ''
				);
			$this->session->unset_userdata('user_logged_in', $sess_array);
			redirect('Login');
		}
}
?>