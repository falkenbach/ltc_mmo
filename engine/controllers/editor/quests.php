<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Quests extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('quests_model','quests');
	}
	
	public function index()
	{
		$this->data['quests'] = $this->quests->get_all();
                $this->data['meta_title'] = 'All Quests';
	}

	public function create()
	{
		$this->form_validation->set_rules('name','Name','required|trim|xss_clean');
		$this->form_validation->set_rules('verbiage','Quest Text','required|trim|xss_clean');
		$this->form_validation->set_rules('giver','Quest Giver','required|trim|xss_clean');
		$this->form_validation->set_rules('turnin','Quest Turnin','required|trim|xss_clean');
		$this->form_validation->set_rules('monetary_reward','Monetary Reward','trim|xss_clean');
		$this->form_validation->set_rules('item_reward','Item Reward','trim|xss_clean');
		$this->form_validation->set_rules('experience','Experience','trim|xss_clean');

		if ($this->form_validation->run() == TRUE && $this->quests->insert($_POST))
                {
                        // Creating the characters was successful, redirect them back to the admin page
                        flashmsg('Quest created successfully.', 'success');
                        redirect('/editor/quests');
                }
		$this->data['meta_title'] = 'Create Quest';
	}

	public function edit()
	{

	}

	public function delete()
	{

	}
}
