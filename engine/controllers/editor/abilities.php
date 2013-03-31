<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Abilities extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('abilities_model','abilities');
	}
	
	public function index()
	{
		$this->data['abilities'] = $this->abilities->get_all();
                $this->data['meta_title'] = 'All Abilities';
	}

	public function create()
	{
		$this->form_validation->set_rules('name','Name','required|trim|xss_clean');
		$this->form_validation->set_rules('class','Class','required|trim|xss_clean');
		$this->form_validation->set_rules('damage','Damage','required|trim|xss_clean');
		$this->form_validation->set_rules('heal','Heal','required|trim|xss_clean');
		$this->form_validation->set_rules('modifier','Modifier','trim|xss_clean');
		$this->form_validation->set_rules('cast_time','Cast Time','trim|xss_clean');

		if ($this->form_validation->run() == TRUE && $this->abilities->insert($_POST))
                {
                        // Creating the abilities was successful, redirect them back to the admin page
                        flashmsg('Ability created successfully.', 'success');
                        redirect('/editor/abilities');
                }
		$this->data['meta_title'] = 'Create Ability';
	}

	public function edit()
	{

	}

	public function delete()
	{

	}
}
