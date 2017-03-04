<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Profile extends CI_Controller 
{
	/* class controller */
	public function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->model('Profile_model');
	}
	
	/* index method */
	public function index()
	{
		$this->load->view('profile');
	}
	
	/* contacts */
	public function contact()
	{
		echo '<pre>'; print_r($this->input->post()); exit;
		$this->form_validation->set_rules('name', 'Name', 'trim|required');
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
		$this->form_validation->set_rules('contact', 'Contact', 'trim|required|min_length[10]|max_length[10]');
		$this->form_validation->set_rules('message', 'Message', 'trim|required');
		if ($this->form_validation->run() == FALSE)
		{
			$error = validation_errors();
			$this->load->view('profile');
		}
		else
		{
			/* insert records */
			$data = array(
					'name'=> $this->input->post('name'),
					'email'=> $this->input->post('email'),
					'contact'=> $this->input->post('contact'),
					'message'=> $this->input->post('message'),
					'created'=> date('Y-m-d h:i:s')
			);
			$this->Profile_model->request_contact($data);
			$this->sendmail($to, $from, $subject, $message);
			$this->load->view('profile');
		}
	}
	
	/* smtp mail */
	protected function sendmail($to, $from, $subject, $message) {
		// smtp configuration
		/**
			* NOTE: this will be change while integrating on server
			*/
		$config ['protocol'] = "smtp";
		$config ['smtp_host'] = "mail.omkar.website";
		$config ['smtp_port'] = "587";
		$config ['smtp_user'] = "contact@omkar.website";
		$config ['smtp_pass'] = "{uT3W%Un-W5S";
		$config ['charset'] = "utf-8";
		$config ['mailtype'] = "text";
		$config ['newline'] = "\r\n";
	
		$this->email->initialize ( $config );
		$this->email->from ( $from, 'omkar.website | Contact' );
		$this->email->to ( $to );
		// $this->email->cc('another@another-example.com');
		// $this->email->bcc('another@another-example.com');
	
		$this->email->subject ( $subject );
		$this->email->message ( $message );
	
		if ($this->email->send ()) {
			// Success email Sent
			return true; // $this->email->print_debugger();
		} else {
			// Email Failed To Send
			return false;
			// $this->email->print_debugger();
		}
	}
}