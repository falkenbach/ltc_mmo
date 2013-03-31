<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Creatures extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('creatures_model','creatures');
	}
	
	public function index()
	{
		$this->data['creatures'] = $this->creatures->get_all();
                $this->data['meta_title'] = 'All Creatures';
	}

	public function create()
	{
		$this->form_validation->set_rules('name','Name','required|trim|xss_clean');
		$this->form_validation->set_rules('hp','HP','required|trim|xss_clean');
		$this->form_validation->set_rules('mana','Mana','required|trim|xss_clean');
		$this->form_validation->set_rules('experience','Experience','required|trim|xss_clean');
		$this->form_validation->set_rules('monetary_reward','Monetary Reward','trim|xss_clean');
		$this->form_validation->set_rules('item_reward','Item Reward','trim|xss_clean');
		$this->form_validation->set_rules('location','Location','trim|xss_clean');

		if ($this->form_validation->run() == TRUE && $this->creatures->insert($_POST))
                {
                        // Creating the creatures was successful, redirect them back to the admin page
                        flashmsg('Creatures created successfully.', 'success');
                        redirect('/editor/creatures');
                }
		$this->data['meta_title'] = 'Create Creature';
	}

	public function edit()
	{

	}

	public function delete()
	{

	}
}
