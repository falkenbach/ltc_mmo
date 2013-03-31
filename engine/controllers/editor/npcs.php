<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Npcs extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('npcs_model','npcs');
	}
	
	public function index()
	{
		$this->data['npcs'] = $this->npcs->get_all();
                $this->data['meta_title'] = 'All NPCs';
	}

	public function create()
	{
		$this->form_validation->set_rules('name','Name','required|trim|xss_clean');
		$this->form_validation->set_rules('verbiage','Text','required|trim|xss_clean');
		$this->form_validation->set_rules('location','Location','required|trim|xss_clean');

		if ($this->form_validation->run() == TRUE && $this->npcs->insert($_POST))
                {
                        // Creating the npcs was successful, redirect them back to the admin page
                        flashmsg('NPC created successfully.', 'success');
                        redirect('/editor/npcs');
                }
		$this->data['meta_title'] = 'Create NPC';
	}

	public function edit()
	{

	}

	public function delete()
	{

	}
}
