<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Profile_model extends  CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}
	
	/* insert contact details */
	function request_contact($data)
	{
		$this->db->insert('tbl_contact',$data);
		return $this->db->insert_id();
	}
}