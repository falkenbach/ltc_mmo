<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Items extends MY_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('items_model', 'items');

	}
	
	public function index()
	{
		$this->data['items'] = $this->items->get_all();
		$this->data['meta_title'] = 'All Items';
	}
	
	public function create()
	{
		$this->form_validation->set_rules('name', 'Name', 'required|trim|xss_clean');
		$this->form_validation->set_rules('level', 'Level', 'required|trim|xss_clean|integer');
		$this->form_validation->set_rules('damage', 'Damage', 'trim|xss_clean|integer');
		$this->form_validation->set_rules('defense', 'Defense', 'trim|xss_clean|integer');
		$this->form_validation->set_rules('modified_amount', 'Modified Amount', 'trim|xss_clean|integer');
		$this->form_validation->set_rules('attributes', 'Attributes', 'trim|xss_clean|integer');
		$this->form_validation->set_rules('classes', 'Classes', 'required|trim|xss_clean|integer');
		$this->form_validation->set_rules('body_location', 'Body Location', 'trim|xss_clean|integer');
		$this->form_validation->set_rules('stackable', 'Stackable', 'required|trim');
		$this->form_validation->set_rules('cast_time', 'Cast Time', 'required|trim|xss_clean');
		
		if ($this->form_validation->run() == TRUE && $this->items->insert($_POST))
		{
			// Creating the characters was successful, redirect them back to the admin page
			flashmsg('Item created successfully.', 'success');
			redirect('/editor/items');
		}
		
		// Display the create user form
		$all_classes = $this->classes->get_all();
		$classes = array('' => 'Select one');
		foreach ($all_classes as $class)
		{
			$classes[$class->id] = $class->name;
		}
		$this->data['classes'] = $classes;
		$this->data['meta_title'] = 'Create Character';
	}
	
	public function edit($id = NULL)
	{
		$item = $this->data['item'] = $this->items->get($id);
		if (empty($id) || empty($item))
		{
			flashmsg('You must specify a item to edit.', 'error');
			redirect('/editor/items');
		}
		
		$this->form_validation->set_rules('name', 'Name', 'required|trim|xss_clean');
		$this->form_validation->set_rules('level', 'Level', 'required|trim|xss_clean|integer');
		$this->form_validation->set_rules('damage', 'Damage', 'trim|xss_clean|integer');
		$this->form_validation->set_rules('defense', 'Defense', 'trim|xss_clean|integer');
		$this->form_validation->set_rules('modified_amount', 'Modified Amount', 'trim|xss_clean|integer');
		$this->form_validation->set_rules('attributes', 'Attributes', 'trim|xss_clean|integer');
		$this->form_validation->set_rules('classes', 'Classes', 'required|trim|xss_clean|integer');
		$this->form_validation->set_rules('stackable', 'Stackable', 'required|trim');
		$this->form_validation->set_rules('cast_time', 'Cast Time', 'required|trim|xss_clean');
		
		if ($this->form_validation->run() === TRUE)
		{
			$data = $this->input->post();
			
			if ($this->items->update($id, $data) === TRUE)
			{
				flashmsg('Item updated successfully.', 'success');
				redirect('/editor/items');
			}
			else
			{
				flashmsg('There was an error while trying to edit the item.', 'error');
			}
		}
		
		// Display the create user form
		$all_classes = $this->classes->get_all();
		$classes = array('' => 'Select one');
		foreach ($all_classes as $class)
		{
			$classes[$class->id] = $class->name;
		}
		$this->data['classes'] = $classes;
		$this->data['meta_title'] = 'Edit Character';
	}

	public function delete($id = NULL)
	{
		$item = $this->data['item'] = $this->items->get($id);
		if (empty($id) || empty($item))
		{
			flashmsg('You must specify a item to delete.', 'error');
			redirect('/editors/items');
		}
		
		$this->form_validation->set_rules('confirm', 'confirmation', 'required');
		$this->form_validation->set_rules('id', 'item ID', 'required|is_natural');

		if ($this->form_validation->run() === TRUE)
		{
			// Do we really want to deactivate?
			if ($this->input->post('confirm') == 'yes')
			{
				// Do we have a valid request?
				if ($this->_valid_csrf_nonce() === FALSE || $id != $this->input->post('id'))
				{
					show_404();
				}

				// Do we have the right userlevel?
				if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin())
				{
					$this->items->delete($id);
				}
				
				// Redirect them back to the admin page
				flashmsg('Item deleted successfully.', 'success');
				redirect('/editor/items');
			}
			else
			{
				redirect('/editor/items');
			}
		}
		
		// Insert csrf check
		$this->data['csrf'] = $this->_get_csrf_nonce();
		//$this->data['user'] = $this->ion_auth->get_user($id);
		$this->data['meta_title'] = 'Delete Item';
	}
	
	function deactivate($id = NULL)
	{
		$item = $this->data['item'] = $this->items->get($id);
		if (empty($id) || empty($item))
		{
			flashmsg('You must specify a item to deactivate.', 'error');
			redirect('/editor/items');
		}

		$this->form_validation->set_rules('confirm', 'confirmation', 'required');
		$this->form_validation->set_rules('id', 'item ID', 'required|is_natural');

		if ($this->form_validation->run() === TRUE)
		{
			// Do we really want to deactivate?
			if ($this->input->post('confirm') == 'yes')
			{
				// Do we have a valid request?
				if ($this->_valid_csrf_nonce() === FALSE || $id != $this->input->post('id'))
				{
					show_404();
				}

				// Do we have the right userlevel?
				if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin())
				{
					$this->items->update($id, array('active' => 0));
				}
				
				// Redirect them back to the admin page
				flashmsg('Item deactivated successfully.', 'success');
				redirect('/editor/items');
			}
			else
			{
				redirect('/editor/items');
			}
		}
		
		// Insert csrf check
		$this->data['csrf'] = $this->_get_csrf_nonce();
		$this->data['meta_title'] = 'Deactivate Item';
	}
	
	function activate($id = NULL)
	{
		$item = $this->data['item'] = $this->items->get($id);
		if (empty($id) || empty($item))
		{
			flashmsg('You must specify a item to activate.', 'error');
			redirect('/editor/items');
		}

		$this->form_validation->set_rules('confirm', 'confirmation', 'required');
		$this->form_validation->set_rules('id', 'item ID', 'required|is_natural');

		if ($this->form_validation->run() === TRUE)
		{
			// Do we really want to activate?
			if ($this->input->post('confirm') == 'yes')
			{
				// Do we have a valid request?
				if ($this->_valid_csrf_nonce() === FALSE || $id != $this->input->post('id'))
				{
					show_404();
				}

				// Do we have the right userlevel?
				if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin())
				{
					$this->items->update($id, array('active' => 1));
				}
				
				// Redirect them back to the admin page
				flashmsg('Item activated successfully.', 'success');
				redirect('/editor/items');
			}
			else
			{
				redirect('/editor/items');
			}
		}
		
		// Insert csrf check
		$this->data['csrf'] = $this->_get_csrf_nonce();
		$this->data['meta_title'] = 'Activate Item';
	}
	
	public function weapons($action = NULL, $id = NULL)
	{
	
		$this->view = 'editor/characters/classes/index';
		if($action!=NULL) {
			$this->view = 'editor/characters/classes/'.$action;
		}
		
		if($action=='create') {
			$this->form_validation->set_rules('name', 'Name', 'required|trim|xss_clean');
			$this->form_validation->set_rules('description', 'Description', 'required|trim|xss_clean');
			
			if ($this->form_validation->run() == TRUE && $this->classes->insert(array(
																					'name' => $this->input->post('name'),
																					'description' => $this->input->post('description'),
																					'attributes' => $this->_parse_attributes($_POST))))
			{
				// Creating the attr was successful, redirect them back to the admin page
				flashmsg('Class created successfully.', 'success');
				redirect('/editor/characters/classes');
			}
			
		} else if($action=='edit') {
			$class = $this->data['class'] = $this->classes->get($id);
			if (empty($id) || empty($class))
			{
				flashmsg('You must specify a class to edit.', 'error');
				redirect('/editor/characters/classes');
			}
			$this->form_validation->set_rules('name', 'Name', 'required|trim|xss_clean');
			$this->form_validation->set_rules('description', 'Description', 'required|trim|xss_clean');
			
			if ($this->form_validation->run() == TRUE && $this->classes->update($id, array(
																					'name' => $this->input->post('name'),
																					'description' => $this->input->post('description'),
																					'attributes' => $this->_parse_attributes($_POST))))
			{
				// Editing the class was successful, redirect them back to the admin page
				flashmsg('Class has been updated successfully.', 'success');
				redirect('/editor/characters/classes');
			}	
		} else if($action=='delete') {
			$class = $this->data['class'] = $this->classes->get($id);
			if (empty($id) || empty($class))
			{
				flashmsg('You must specify a class to delete.', 'error');
				redirect('/editor/characters/classes');
			}
			$this->form_validation->set_rules('confirm', 'confirmation', 'required');
			$this->form_validation->set_rules('id', 'class ID', 'required|is_natural');
			if ($this->form_validation->run() === TRUE)
			{
				// Do we really want to delete?
				if ($this->input->post('confirm') == 'yes')
				{
					// Do we have a valid request?
					if ($this->_valid_csrf_nonce() === FALSE || $id != $this->input->post('id'))
					{
						show_404();
					}

					// Do we have the right userlevel?
					if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin())
					{
						$this->classes->delete($id);
					}
					
					// Redirect them back to the admin page
					flashmsg('Class deleted successfully.', 'success');
					redirect('/editor/characters/classes');
				}
				else
				{
					redirect('/editor/characters/classes');
				}
			}
			$this->data['csrf'] = $this->_get_csrf_nonce();
			
		}
		$this->data['attributes'] = $this->attributes->get_all();
		$this->data['classes'] = $this->classes->get_all();
		$this->data['meta_title'] = 'Character Classes';
	}
	
	public function armor($action = NULL, $id = NULL)
	{
	
		$this->view = 'editor/characters/races/index';
		if($action!=NULL) {
			$this->view = 'editor/characters/races/'.$action;
		}
		
		if($action=='create') {
			$this->form_validation->set_rules('name', 'Name', 'required|trim|xss_clean');
			$this->form_validation->set_rules('description', 'Description', 'required|trim|xss_clean');
			
			if ($this->form_validation->run() == TRUE && $this->races->insert(array(
																					'name' => $this->input->post('name'),
																					'description' => $this->input->post('description'),
																					'attributes' => $this->_parse_attributes($_POST))))
			{
				// Creating the attr was successful, redirect them back to the admin page
				flashmsg('Race created successfully.', 'success');
				redirect('/editor/characters/races');
			}
			
		} else if($action=='edit') {
			$race = $this->data['race'] = $this->races->get($id);
			if (empty($id) || empty($race))
			{
				flashmsg('You must specify a race to edit.', 'error');
				redirect('/editor/characters/races');
			}
			$this->form_validation->set_rules('name', 'Name', 'required|trim|xss_clean');
			$this->form_validation->set_rules('description', 'Description', 'required|trim|xss_clean');
			
			if ($this->form_validation->run() == TRUE && $this->races->update($id, array(
																					'name' => $this->input->post('name'),
																					'description' => $this->input->post('description'),
																					'attributes' => $this->_parse_attributes($_POST))))
			{
				// Editing the race was successful, redirect them back to the admin page
				flashmsg('Race has been updated successfully.', 'success');
				redirect('/editor/characters/races');
			}	
		} else if($action=='delete') {
			$race = $this->data['race'] = $this->races->get($id);
			if (empty($id) || empty($race))
			{
				flashmsg('You must specify a race to delete.', 'error');
				redirect('/editor/characters/races');
			}
			$this->form_validation->set_rules('confirm', 'confirmation', 'required');
			$this->form_validation->set_rules('id', 'race ID', 'required|is_natural');
			if ($this->form_validation->run() === TRUE)
			{
				// Do we really want to delete?
				if ($this->input->post('confirm') == 'yes')
				{
					// Do we have a valid request?
					if ($this->_valid_csrf_nonce() === FALSE || $id != $this->input->post('id'))
					{
						show_404();
					}

					// Do we have the right userlevel?
					if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin())
					{
						$this->races->delete($id);
					}
					
					// Redirect them back to the admin page
					flashmsg('Race deleted successfully.', 'success');
					redirect('/editor/characters/races');
				}
				else
				{
					redirect('/editor/characters/races');
				}
			}
			$this->data['csrf'] = $this->_get_csrf_nonce();
			
		}
		$this->data['attributes'] = $this->attributes->get_all();
		$this->data['races'] = $this->races->get_all();
		$this->data['meta_title'] = 'Character Races';
	}
	
	public function shields($action = NULL, $id = NULL)
	{
		$this->view = 'editor/characters/zodiacs/index';
		if($action!=NULL) {
			$this->view = 'editor/characters/zodiacs/'.$action;
		}
		
		if($action=='create') {
			$this->form_validation->set_rules('name', 'Name', 'required|trim|xss_clean');
			$this->form_validation->set_rules('description', 'Description', 'required|trim|xss_clean');
			
			if ($this->form_validation->run() == TRUE && $this->zodiacs->insert(array(
																					'name' => $this->input->post('name'),
																					'description' => $this->input->post('description'),
																					'attributes' => $this->_parse_attributes($_POST))))
			{
				// Creating the attr was successful, redirect them back to the admin page
				flashmsg('Zodiac created successfully.', 'success');
				redirect('/editor/characters/zodiacs');
			}
			
		} else if($action=='edit') {
			$zodiac = $this->data['zodiac'] = $this->zodiacs->get($id);
			if (empty($id) || empty($zodiac))
			{
				flashmsg('You must specify a zodiac to edit.', 'error');
				redirect('/editor/characters/zodiacs');
			}
			$this->form_validation->set_rules('name', 'Name', 'required|trim|xss_clean');
			$this->form_validation->set_rules('description', 'Description', 'required|trim|xss_clean');
			
			if ($this->form_validation->run() == TRUE && $this->zodiacs->update($id, array(
																					'name' => $this->input->post('name'),
																					'description' => $this->input->post('description'),
																					'attributes' => $this->_parse_attributes($_POST))))
			{
				// Editing the zodiac was successful, redirect them back to the admin page
				flashmsg('Zodiac has been updated successfully.', 'success');
				redirect('/editor/characters/zodiacs');
			}
			
		} else if($action=='delete') {
			$zodiac = $this->data['zodiac'] = $this->zodiacs->get($id);
			if (empty($id) || empty($zodiac))
			{
				flashmsg('You must specify a zodiac to delete.', 'error');
				redirect('/editor/characters/zodiacs');
			}
			$this->form_validation->set_rules('confirm', 'confirmation', 'required');
			$this->form_validation->set_rules('id', 'zodiac ID', 'required|is_natural');
			if ($this->form_validation->run() === TRUE)
			{
				// Do we really want to delete?
				if ($this->input->post('confirm') == 'yes')
				{
					// Do we have a valid request?
					if ($this->_valid_csrf_nonce() === FALSE || $id != $this->input->post('id'))
					{
						show_404();
					}

					// Do we have the right userlevel?
					if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin())
					{
						$this->zodiacs->delete($id);
					}
					
					// Redirect them back to the admin page
					flashmsg('Zodiac deleted successfully.', 'success');
					redirect('/editor/characters/zodiacs');
				}
				else
				{
					redirect('/editor/characters/zodiacs');
				}
			}
			$this->data['csrf'] = $this->_get_csrf_nonce();
		}
		$this->data['attributes'] = $this->attributes->get_all();
		$this->data['zodiacs'] = $this->zodiacs->get_all();
		$this->data['meta_title'] = 'Character Zodiacs';
	}
	
	public function amulets($action = NULL, $id = NULL)
	{
		$this->view = 'editor/characters/attributes/index';
		if($action!=NULL) {
			$this->view = 'editor/characters/attributes/'.$action;
		}
		
		if($action=='create') {
			$this->form_validation->set_rules('name', 'Name', 'required|trim|xss_clean');
			$this->form_validation->set_rules('acronym', 'Acronym', 'required|trim|xss_clean|min_length[2]|max_length[4]');
			$this->form_validation->set_rules('description', 'Description', 'required|trim|xss_clean');
			/* Make sure the acronym is all caps */
			if(isset($_POST['acronym'])){
				$_POST['acronym'] = strtoupper($_POST['acronym']);
			}
			if ($this->form_validation->run() == TRUE && $this->attributes->insert($_POST))
			{
				// Creating the attr was successful, redirect them back to the admin page
				flashmsg('Attribute created successfully.', 'success');
				redirect('/editor/characters/attributes');
			}
			
		} else if($action=='edit') {
			$attr = $this->data['attr'] = $this->attributes->get($id);
			if (empty($id) || empty($attr))
			{
				flashmsg('You must specify a attribute to edit.', 'error');
				redirect('/editor/characters/attributes');
			}
			$this->form_validation->set_rules('name', 'Name', 'required|trim|xss_clean');
			$this->form_validation->set_rules('acronym', 'Acronym', 'required|trim|xss_clean|min_length[2]|max_length[4]');
			$this->form_validation->set_rules('description', 'Description', 'required|trim|xss_clean');
			/* Make sure the acronym is all caps */
			if(isset($_POST['acronym'])){
				$_POST['acronym'] = strtoupper($_POST['acronym']);
			}
			if ($this->form_validation->run() == TRUE && $this->attributes->update($id, $_POST))
			{
				// Creating the attr was successful, redirect them back to the admin page
				flashmsg('Attribute has been updated successfully.', 'success');
				redirect('/editor/characters/attributes');
			}
			
		} else if($action=='delete') {
			$attr = $this->data['attr'] = $this->attributes->get($id);
			if (empty($id) || empty($attr))
			{
				flashmsg('You must specify a attribute to delete.', 'error');
				redirect('/editor/characters/attributes');
			}
			$this->form_validation->set_rules('confirm', 'confirmation', 'required');
			$this->form_validation->set_rules('id', 'attribute ID', 'required|is_natural');
			if ($this->form_validation->run() === TRUE)
			{
				// Do we really want to delete?
				if ($this->input->post('confirm') == 'yes')
				{
					// Do we have a valid request?
					if ($this->_valid_csrf_nonce() === FALSE || $id != $this->input->post('id'))
					{
						show_404();
					}

					// Do we have the right userlevel?
					if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin())
					{
						$this->attributes->delete($id);
					}
					
					// Redirect them back to the admin page
					flashmsg('Attribute deleted successfully.', 'success');
					redirect('/editor/characters/attributes');
				}
				else
				{
					redirect('/editor/characters/attributes');
				}
			}
			$this->data['csrf'] = $this->_get_csrf_nonce();
		}
		$this->data['attributes'] = $this->attributes->get_all();
		$this->data['meta_title'] = 'Character Attributes';
	}
	
	private function _parse_attributes($arr, $attributes = array())
	{
		foreach($arr as $key => $value){
			if(strlen($key)==3){
				$attributes[$key] = $value;
			}
		}
		return json_encode($attributes);
	}
	
	public function relics($action = NULL, $id = NULL)
	{
		$this->view = 'editor/characters/skills/index';
		if($action!=NULL) {
			$this->view = 'editor/characters/skills/'.$action;
		}
		
		if($action=='create') {
			$this->form_validation->set_rules('name', 'Name', 'required|trim|xss_clean');
			$this->form_validation->set_rules('description', 'Description', 'required|trim|xss_clean');
			$this->form_validation->set_rules('class', 'Class', 'required|trim|xss_clean');
			
			if ($this->form_validation->run() == TRUE && $this->skills->insert(array(
																					'name' => $this->input->post('name'),
																					'description' => $this->input->post('description'),
																					'class' => $this->input->post('class'))))
			{
				// Creating the skill was successful, redirect them back to the admin page
				flashmsg('Skill created successfully.', 'success');
				redirect('/editor/characters/skills');
			}
			
			$all_classes = $this->classes->get_all();
			$classes = array('' => 'Select One');
			foreach($all_classes as $class) {
				$classes[$class->id] = $class->name;
			}
			$this->data['classes'] = $classes;
			
		} else if($action=='edit') {
			$skill = $this->data['skill'] = $this->skills->get($id);
			if (empty($id) || empty($skill))
			{
				flashmsg('You must specify a skill to edit.', 'error');
				redirect('/editor/characters/skills');
			}
			$this->form_validation->set_rules('name', 'Name', 'required|trim|xss_clean');
			$this->form_validation->set_rules('description', 'Description', 'required|trim|xss_clean');
			$this->form_validation->set_rules('class', 'Class', 'required|trim|xss_clean');
			
			if ($this->form_validation->run() == TRUE && $this->skills->update($id, array(
																					'name' => $this->input->post('name'),
																					'description' => $this->input->post('description'),
																					'class' => $this->input->post('class'))))
			{
				// Editing the skill was successful, redirect them back to the admin page
				flashmsg('Skill has been updated successfully.', 'success');
				redirect('/editor/characters/skills');
			}
			
			$all_classes = $this->classes->get_all();
			$classes = array('' => 'Select One');
			foreach($all_classes as $class) {
				$classes[$class->id] = $class->name;
			}
			$this->data['classes'] = $classes;
			
		} else if($action=='delete') {
			$skill = $this->data['skill'] = $this->skills->get($id);
			if (empty($id) || empty($skill))
			{
				flashmsg('You must specify a skill to delete.', 'error');
				redirect('/editor/characters/skills');
			}
			$this->form_validation->set_rules('confirm', 'confirmation', 'required');
			$this->form_validation->set_rules('id', 'skill ID', 'required|is_natural');
			if ($this->form_validation->run() === TRUE)
			{
				// Do we really want to delete?
				if ($this->input->post('confirm') == 'yes')
				{
					// Do we have a valid request?
					if ($this->_valid_csrf_nonce() === FALSE || $id != $this->input->post('id'))
					{
						show_404();
					}

					// Do we have the right userlevel?
					if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin())
					{
						$this->skills->delete($id);
					}
					
					// Redirect them back to the admin page
					flashmsg('Skill deleted successfully.', 'success');
					redirect('/editor/characters/skills');
				}
				else
				{
					redirect('/editor/characters/skills');
				}
			}
			$this->data['csrf'] = $this->_get_csrf_nonce();
		}
		
		$this->data['skills'] = $this->skills->get_all();
		$this->data['meta_title'] = 'Character Skills';
	}
	
	public function consumables($action = NULL, $id = NULL)
	{
		$this->view = 'editor/characters/abilities/index';
		if($action!=NULL) {
			$this->view = 'editor/characters/abilities/'.$action;
		}
		
		if($action=='create') {
			$this->form_validation->set_rules('name', 'Name', 'required|trim|xss_clean');
			$this->form_validation->set_rules('description', 'Description', 'required|trim|xss_clean');
			$this->form_validation->set_rules('class', 'Class', 'required|trim|xss_clean');
			$this->form_validation->set_rules('zodiac', 'Zodiac', 'required|trim|xss_clean');
			$this->form_validation->set_rules('race', 'Race', 'required|trim|xss_clean');
			$this->form_validation->set_rules('level', 'Level', 'required|trim|xss_clean');
			
			if ($this->form_validation->run() == TRUE && $this->abilities->insert(array(
																					'name' => $this->input->post('name'),
																					'description' => $this->input->post('description'),
																					'class' => $this->input->post('class'),
																					'zodiac' => $this->input->post('zodiac'),
																					'race' => $this->input->post('race'),
																					'level' => $this->input->post('level'),
																					'attributes' => $this->_parse_attributes($_POST))))
			{
				// Creating the ability was successful, redirect them back to the admin page
				flashmsg('Ability created successfully.', 'success');
				redirect('/editor/characters/abilities');
			}
			
		} else if($action=='edit') {
			$ability = $this->data['ability'] = $this->abilities->get($id);
			if (empty($id) || empty($ability))
			{
				flashmsg('You must specify a ability to edit.', 'error');
				redirect('/editor/characters/abilities');
			}
			$this->form_validation->set_rules('name', 'Name', 'required|trim|xss_clean');
			$this->form_validation->set_rules('description', 'Description', 'required|trim|xss_clean');
			$this->form_validation->set_rules('class', 'Class', 'required|trim|xss_clean');
			$this->form_validation->set_rules('zodiac', 'Zodiac', 'required|trim|xss_clean');
			$this->form_validation->set_rules('race', 'Race', 'required|trim|xss_clean');
			$this->form_validation->set_rules('level', 'Level', 'required|trim|xss_clean');
			
			if ($this->form_validation->run() == TRUE && $this->abilities->update($id, array(
																					'name' => $this->input->post('name'),
																					'description' => $this->input->post('description'),
																					'class' => $this->input->post('class'),
																					'zodiac' => $this->input->post('zodiac'),
																					'race' => $this->input->post('race'),
																					'level' => $this->input->post('level'),
																					'attributes' => $this->_parse_attributes($_POST))))
			{
				// Editing the ability was successful, redirect them back to the admin page
				flashmsg('Ability has been updated successfully.', 'success');
				redirect('/editor/characters/abilities');
			}
			
		} else if($action=='delete') {
			$ability = $this->data['ability'] = $this->abilities->get($id);
			if (empty($id) || empty($ability))
			{
				flashmsg('You must specify a ability to delete.', 'error');
				redirect('/editor/characters/abilities');
			}
			$this->form_validation->set_rules('confirm', 'confirmation', 'required');
			$this->form_validation->set_rules('id', 'ability ID', 'required|is_natural');
			if ($this->form_validation->run() === TRUE)
			{
				// Do we really want to delete?
				if ($this->input->post('confirm') == 'yes')
				{
					// Do we have a valid request?
					if ($this->_valid_csrf_nonce() === FALSE || $id != $this->input->post('id'))
					{
						show_404();
					}

					// Do we have the right userlevel?
					if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin())
					{
						$this->abilities->delete($id);
					}
					
					// Redirect them back to the admin page
					flashmsg('Ability deleted successfully.', 'success');
					redirect('/editor/characters/abilities');
				}
				else
				{
					redirect('/editor/characters/abilities');
				}
			}
			$this->data['csrf'] = $this->_get_csrf_nonce();
		}
		
		$all_classes = $this->classes->get_all();
		$classes = array('*' => 'Any');
		foreach($all_classes as $class) {
			$classes[$class->id] = $class->name;
		}
		$this->data['classes'] = $classes;
		
		$all_zodiacs = $this->zodiacs->get_all();
		$zodiacs = array('*' => 'Any');
		foreach($all_zodiacs as $zodiac) {
			$zodiacs[$zodiac->id] = $zodiac->name;
		}
		$this->data['zodiacs'] = $zodiacs;
		
		$all_races = $this->races->get_all();
		$races = array('*' => 'Any');
		foreach($all_races as $race) {
			$races[$race->id] = $race->name;
		}
		$this->data['races'] = $races;
		$this->data['attributes'] = $this->attributes->get_all();
		$this->data['abilities'] = $this->abilities->get_all();
		$this->data['meta_title'] = 'Character Abilities';
	}
	
	public function rings($action = NULL, $id = NULL)
	{
		$this->view = 'editor/characters/powers/index';
		if($action!=NULL) {
			$this->view = 'editor/characters/powers/'.$action;
		}
		
		if($action=='create') {
			$this->form_validation->set_rules('name', 'Name', 'required|trim|xss_clean');
			$this->form_validation->set_rules('description', 'Description', 'required|trim|xss_clean');
			$this->form_validation->set_rules('class', 'Class', 'required|trim|xss_clean');
			$this->form_validation->set_rules('zodiac', 'Zodiac', 'required|trim|xss_clean');
			$this->form_validation->set_rules('race', 'Race', 'required|trim|xss_clean');
			$this->form_validation->set_rules('level', 'Level', 'required|trim|xss_clean');
			
			if ($this->form_validation->run() == TRUE && $this->powers->insert(array(
																					'name' => $this->input->post('name'),
																					'description' => $this->input->post('description'),
																					'class' => $this->input->post('class'),
																					'zodiac' => $this->input->post('zodiac'),
																					'race' => $this->input->post('race'),
																					'level' => $this->input->post('level'),
																					'attributes' => $this->_parse_attributes($_POST))))
			{
				// Creating the power was successful, redirect them back to the admin page
				flashmsg('Ability created successfully.', 'success');
				redirect('/editor/characters/powers');
			}
			
		} else if($action=='edit') {
			$power = $this->data['power'] = $this->powers->get($id);
			if (empty($id) || empty($power))
			{
				flashmsg('You must specify a power to edit.', 'error');
				redirect('/editor/characters/powers');
			}
			$this->form_validation->set_rules('name', 'Name', 'required|trim|xss_clean');
			$this->form_validation->set_rules('description', 'Description', 'required|trim|xss_clean');
			$this->form_validation->set_rules('class', 'Class', 'required|trim|xss_clean');
			$this->form_validation->set_rules('zodiac', 'Zodiac', 'required|trim|xss_clean');
			$this->form_validation->set_rules('race', 'Race', 'required|trim|xss_clean');
			$this->form_validation->set_rules('level', 'Level', 'required|trim|xss_clean');
			
			if ($this->form_validation->run() == TRUE && $this->powers->update($id, array(
																					'name' => $this->input->post('name'),
																					'description' => $this->input->post('description'),
																					'class' => $this->input->post('class'),
																					'zodiac' => $this->input->post('zodiac'),
																					'race' => $this->input->post('race'),
																					'level' => $this->input->post('level'),
																					'attributes' => $this->_parse_attributes($_POST))))
			{
				// Editing the power was successful, redirect them back to the admin page
				flashmsg('Ability has been updated successfully.', 'success');
				redirect('/editor/characters/powers');
			}
			
		} else if($action=='delete') {
			$power = $this->data['power'] = $this->powers->get($id);
			if (empty($id) || empty($power))
			{
				flashmsg('You must specify a power to delete.', 'error');
				redirect('/editor/characters/powers');
			}
			$this->form_validation->set_rules('confirm', 'confirmation', 'required');
			$this->form_validation->set_rules('id', 'power ID', 'required|is_natural');
			if ($this->form_validation->run() === TRUE)
			{
				// Do we really want to delete?
				if ($this->input->post('confirm') == 'yes')
				{
					// Do we have a valid request?
					if ($this->_valid_csrf_nonce() === FALSE || $id != $this->input->post('id'))
					{
						show_404();
					}

					// Do we have the right userlevel?
					if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin())
					{
						$this->powers->delete($id);
					}
					
					// Redirect them back to the admin page
					flashmsg('Ability deleted successfully.', 'success');
					redirect('/editor/characters/powers');
				}
				else
				{
					redirect('/editor/characters/powers');
				}
			}
			$this->data['csrf'] = $this->_get_csrf_nonce();
		}
		
		$all_classes = $this->classes->get_all();
		$classes = array('*' => 'Any');
		foreach($all_classes as $class) {
			$classes[$class->id] = $class->name;
		}
		$this->data['classes'] = $classes;
		
		$all_zodiacs = $this->zodiacs->get_all();
		$zodiacs = array('*' => 'Any');
		foreach($all_zodiacs as $zodiac) {
			$zodiacs[$zodiac->id] = $zodiac->name;
		}
		$this->data['zodiacs'] = $zodiacs;
		
		$all_races = $this->races->get_all();
		$races = array('*' => 'Any');
		foreach($all_races as $race) {
			$races[$race->id] = $race->name;
		}
		$this->data['races'] = $races;
		$this->data['attributes'] = $this->attributes->get_all();
		$this->data['powers'] = $this->powers->get_all();
		$this->data['meta_title'] = 'Character Powers';
	}
	
}