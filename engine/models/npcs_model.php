<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Npcs_model extends MY_Model 
{

	function __construct()
	{
		parent::__construct();
		$this->_table = 'npcs';
	}

}
