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
	
}
