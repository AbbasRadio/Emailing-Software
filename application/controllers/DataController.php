<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class DataController extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->helper('date');
		$this->load->library('session');
		$this->load->library('encryption');
		$this->load->library('form_validation');
		$this->load->model('users_model');
		$this->load->model('messages_model');
	}
	public function Authenticate()
	{
		$this->load->view('login/login');
		if(isset($_POST['submit'])){
			$this->form_validation->set_rules('email', 'Email', 'trim|required');
			$this->form_validation->set_rules('password', 'Password', 'trim|required');
			if($this->form_validation->run() == TRUE){
				$user_name = $this->input->post('email');
				$password = $this->input->post('password');
				$res = $this->users_model->AuthUser($user_name,$password);
				// print_r($res);die;
				if($res != 0){
					$sessions = array(
						'id' => $res,
				        'user'  => $user_name,
				        'profile'     => 'johndoe@some-site.com'
				        
					);
					// print_r($sessions);die;
					$this->session->set_userdata($sessions);
					$this->session->set_flashdata('Inserted','Logged In Successfully');
					redirect(base_url('DataController/Index'));
				}else{
					$this->session->set_flashdata('Error','Invalid Email or Password');
					redirect(base_url('DataController/Authenticate'));
				}
			}			
		}
	}
	public function LogOut()
	{
		// code...
		$this->session->unset_userdata('user');
		$this->session->set_flashdata('Thank','Logged Out Successfully');
		redirect(base_url('DataController/Authenticate'));
	}
	public function Register()
	{
		$this->load->view('login/register');
		if(isset($_POST['submit'])){
			$this->form_validation->set_rules('email', 'Email', 'trim|required');
			$this->form_validation->set_rules('password', 'Password', 'trim|required');
			$this->form_validation->set_rules('f_name', 'First Name', 'trim|required');
			$this->form_validation->set_rules('l_name', 'Last Name', 'trim');
			$this->form_validation->set_rules('m_name', 'Middle Name', 'trim');
			$this->form_validation->set_rules('address', 'Address', 'trim|required');
			$this->form_validation->set_rules('number', 'Phone Number', 'trim|required');
			$this->form_validation->set_rules('dob', 'Date of Birth', 'trim|required');
			// [$email,$password,$f_name,$l_name,$m_name,$address,$number,$dob,$picture]
			$email = $this->input->post('email');
			$password = $this->input->post('password');
			$f_name = $this->input->post('f_name');
			$l_name = $this->input->post('l_name');
			$m_name = $this->input->post('m_name');
			$address = $this->input->post('address');
			$number = $this->input->post('number');
			$dob = $this->input->post('dob');
			$gender = $this->input->post('gender');
			$picture = $this->input->post('picture');
			if($this->users_model->checkEmail($email) == 0){
				// echo "Successfully Inside";die;
				if($picture == null)
					$picture = null;
				if($l_name == null)
					$l_name = null;
				if($m_name == null)
					$m_name = null;
				
				$insertValue = array($email,$password,$f_name,$l_name,$m_name,$address,$number,$dob,$picture,$gender);
				// print_r($insertValue);die;
				$result = $this->users_model->insertValues($insertValue,null);
				if($result != 0){
					$sessions = array(
						'id' => $result,
				        'user'  => $email,
				        'profile'     => $picture
					);
					$this->session->set_userdata($sessions);
					$this->session->set_flashdata('Inserted','User Added Successfully');
					redirect(base_url('DataController/Index'));			
				}
			}else{
				$this->session->set_flashdata('Email','Email Already Exists...');
				redirect(base_url('DataController/Register'));
			}
		}

	}
	public function Index()
	{	
		if(!$this->session->userdata('user')){
			$this->session->set_flashdata('user','Please Login..');
				redirect(base_url('DataController/Authenticate'));
		}
		// print_r($this->session->userdata());die;
		$data['results'] = $this->messages_model->getMessages($this->session->userdata('id'));
		// print_r($data);die;
		$this->load->view('header/header');
		$this->load->view('pages/index',$data);
		$this->load->view('header/footer');
	}
	function Compose(){
		if(!$this->session->userdata('user')){
			$this->session->set_flashdata('user','Please Login..');
				redirect(base_url('DataController/Authenticate'));
		}
		$this->load->view('header/header');
		$this->load->view('pages/compose');
		$this->load->view('header/footer');
		if(isset($_POST['submit'])){
			/*print_r($this->input->post());
			die;*/
			$this->form_validation->set_rules('mailTo', 'Mail To', 'trim|required');
			$this->form_validation->set_rules('subject', 'Subject', 'trim');
			$this->form_validation->set_rules('mail', 'Message', 'trim|required');
			$mailTo = $this->users_model->getUserId($this->input->post('mailTo'));
			if($mailTo != 0){
				// print_r($this->session->userdata());die;
				$subject = $this->input->post('subject');
				$msg = $this->input->post('mail');
				$attach = $this->input->post('attachment');
				if($attach == null)
					$attach = null;
				$insertValues = array($this->session->userdata('id'),$mailTo,$subject,$msg,$attach);
				$result = $this->messages_model->insertValue($insertValues);
				if($result){
					$this->session->set_flashdata('Sent','Mail Sent Successfully');
					redirect(base_url('DataController/Index'));
				}
				$this->session->set_flashdata('Error','Error Sending Mail');
				redirect(base_url('DataController/Index'));
			}
			$this->session->set_flashdata('Invalid','Email Address Not Found');
			redirect(base_url('DataController/Compose'));
		}
	}
	public function SentMail()
	{
		if(!$this->session->userdata('user')){
			$this->session->set_flashdata('user','Please Login..');
				redirect(base_url('DataController/Authenticate'));
		}
		$data['results'] = $this->messages_model->getSentMessages($this->session->userdata('id'));
		// print_r($data);die;
		$this->load->view('header/header');
		$this->load->view('pages/sentMail',$data);
		$this->load->view('header/footer');
	}
	public function StarredMail()
	{	
		$data['results'] = $this->messages_model->getStarredMessages($this->session->userdata('id'));
		// print_r($data);die;
		$this->load->view('header/header');
		$this->load->view('pages/starMail',$data);
		$this->load->view('header/footer');
	}
	public function UpdateStarredMail()
	{	
		$msg_id =  $this->uri->segment(3);
  		$star_msg_value =  $this->uri->segment(4);
		// print_r($msg_id." ".$star_msg_value);die;
		if(!$this->session->userdata('user')){
			$this->session->set_flashdata('user','Please Login..');
				redirect(base_url('DataController/Authenticate'));
		}
		$res = $this->messages_model->updateStarMsg($msg_id,$star_msg_value);
		if($res){
			$this->session->set_flashdata('Updated','Mail Updated');
			redirect(base_url('DataController/Index'));
		}else{
			$this->session->set_flashdata('Invalid','Something Unexpected Occured');
			redirect(base_url('DataController/Index'));
		}
	}
	public function DeletedMail()
	{	
		$msg_id =  $this->uri->segment(3);
		$deleted_id =  $this->uri->segment(4);
		// print_r($msg_id);die;
		if(!$this->session->userdata('user')){
			$this->session->set_flashdata('user','Please Login..');
				redirect(base_url('DataController/Authenticate'));
		}
		if(!empty($deleted_id)){
			$res = $this->messages_model->UndoDeleteMsg($msg_id);
			if($res){
				$this->session->set_flashdata('Updated','Mail Moved To Inbox Successfully');
				redirect(base_url('DataController/Index'));
			}
		}else{
			$res = $this->messages_model->updateDeleteMsg($msg_id);
		}
		if($res){
			$this->session->set_flashdata('Updated','Mail Moved To Trash Successfully');
			redirect(base_url('DataController/Index'));
		}else{
			$this->session->set_flashdata('Invalid','Something Unexpected Occured');
			redirect(base_url('DataController/Index'));
		}
	}
	public function DeleteMail()
	{
		if(!$this->session->userdata('user')){
			$this->session->set_flashdata('user','Please Login..');
				redirect(base_url('DataController/Authenticate'));
		}
		$data['results'] = $this->messages_model->getDeletedMessages($this->session->userdata('id'));
		// print_r($data);die;
		$this->load->view('header/header');
		$this->load->view('pages/deletedMail',$data);
		$this->load->view('header/footer');
	}
	public function SpamMail()
	{
		if(!$this->session->userdata('user')){
			$this->session->set_flashdata('user','Please Login..');
				redirect(base_url('DataController/Authenticate'));
		}
		$data['results'] = $this->messages_model->getSpamMessages($this->session->userdata('id'));
		// print_r($data);die;
		$this->load->view('header/header');
		$this->load->view('pages/spamMail',$data);
		$this->load->view('header/footer');
	}

	public function Spam_Mail()
	{	
		$msg_id =  $this->uri->segment(3);
		$deleted_id =  $this->uri->segment(4);
		// print_r($msg_id);die;
		if(!$this->session->userdata('user')){
			$this->session->set_flashdata('user','Please Login..');
				redirect(base_url('DataController/Authenticate'));
		}
		if(!empty($deleted_id)){
			$res = $this->messages_model->UndoSpamMsg($msg_id);
			if($res){
				$this->session->set_flashdata('Updated','Mail Moved To Inbox Successfully');
				redirect(base_url('DataController/Index'));
			}
		}else{
			$res = $this->messages_model->updateSpamMsg($msg_id);
		}
		if($res){
			$this->session->set_flashdata('Updated','Mail Moved To Spam Successfully');
			redirect(base_url('DataController/Index'));
		}else{
			$this->session->set_flashdata('Invalid','Something Unexpected Occured');
			redirect(base_url('DataController/Index'));
		}
	}
	public function UpdateProfile()
	{
		if(!$this->session->userdata('user')){
			$this->session->set_flashdata('user','Please Login..');
				redirect(base_url('DataController/Authenticate'));
		}
		// print_r($this->session->userdata('id'));die;
		$data['results'] = $this->users_model->getUserDetail($this->session->userdata('id'));
		$data['password'] = $this->users_model->decryptPassword($data['results']->password);
		$this->load->view('header/header');
		$this->load->view('pages/profileUpdate',$data);
		$this->load->view('header/footer');
	}
	public function Update()
	{
		if(isset($_POST['submit'])){
			// $this->form_validation->set_rules('email', 'Email', 'trim|required');
			$this->form_validation->set_rules('password', 'Password', 'trim|required');
			$this->form_validation->set_rules('f_name', 'First Name', 'trim|required');
			$this->form_validation->set_rules('l_name', 'Last Name', 'trim');
			$this->form_validation->set_rules('m_name', 'Middle Name', 'trim');
			$this->form_validation->set_rules('address', 'Address', 'trim|required');
			$this->form_validation->set_rules('number', 'Phone Number', 'trim|required');
			$this->form_validation->set_rules('dob', 'Date of Birth', 'trim|required');
			$this->form_validation->set_rules('gender', 'Gender', 'trim|required');
			// [$email,$password,$f_name,$l_name,$m_name,$address,$number,$dob,$picture]
			$email = $this->session->userdata('user');
			$password = $this->input->post('password');
			$f_name = $this->input->post('f_name');
			$l_name = $this->input->post('l_name');
			$m_name = $this->input->post('m_name');
			$address = $this->input->post('address');
			$number = $this->input->post('number');
			$dob = $this->input->post('dob');
			$gender = $this->input->post('gender');
			$picture = $this->input->post('picture');
			if($this->users_model->checkNumber($number,$this->session->userdata('id')) == 0){
				// echo "Successfully Inside";die;
				if($picture == null)
					$picture = null;
				if($l_name == null)
					$l_name = null;
				if($m_name == null)
					$m_name = null;
				
				$insertValue = array($email,$password,$f_name,$l_name,$m_name,$address,$number,$dob,$picture,$gender);
				// print_r($insertValue);die;
				$result = $this->users_model->insertValues($insertValue,$this->session->userdata('id'));
				if($result){
					$this->session->set_flashdata('Updated','User Updated Successfully');
					redirect(base_url('DataController/Index'));			
				}else{
					$this->session->set_flashdata('Error','Something Unexpected Occured');
					redirect(base_url('DataController/UpdateProfile'));		
				}
			}else{
				$this->session->set_flashdata('Phone','Number Already Exists...');
				redirect(base_url('DataController/UpdateProfile'));
			}
		}

	}
}
