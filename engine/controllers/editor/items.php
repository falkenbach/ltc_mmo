<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Items extends MY_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('consumables_model', 'items');
		$this->load->model('class_model', 'classes');
		$this->load->model('attribute_model', 'attributes');
		$this->load->model('weapons_model', 'weapons');
		$this->load->model('armor_model', 'armor');
		$this->load->model('relics_model', 'relics');
		$this->load->model('rings_model', 'rings');
		$this->load->model('shields_model', 'shields');
		$this->load->model('amulets_model', 'amulets');
	}
	
	public function index()
	{
		$this->data['items'] = $this->items->get_all();
		$this->data['meta_title'] = 'All Items';
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
		$this->view = 'editor/items/weapons/index';
		
		if($action!=NULL) {
			$this->view = 'editor/items/weapons/'.$action;
		}
		
		if($action=='create') {
			$this->form_validation->set_rules('name', 'Name', 'required|trim|xss_clean');
			$this->form_validation->set_rules('level', 'Level', 'required|trim|xss_clean|integer');
			$this->form_validation->set_rules('damage', 'Damage', 'trim|xss_clean|integer');
			$this->form_validation->set_rules('classes', 'Classes', 'required|trim|xss_clean|integer');
			$this->form_validation->set_rules('body_location', 'Body Location', 'trim|xss_clean|integer');
			$this->form_validation->set_rules('stackable', 'Stackable', 'required|trim');
			$this->form_validation->set_rules('cast_time', 'Cast Time', 'required|trim|xss_clean');
			$this->form_validation->set_rules('image', 'Image', 'required|trim|xss_clean');
			$this->form_validation->set_rules('description', 'Description', 'required|trim|xss_clean');
			
			if ($this->form_validation->run() == TRUE && $this->items->insert(array(
																					'name' => $this->input->post('name'),
																					'description' => $this->input->post('description'),
																					'damage' => $this->input->post('damage'),
																					'body_location' => $this->input->post('body_location'),
																					'classes' => $this->input->post('classes'),
																					'stackable' => $this->input->post('stackable'),
																					'cast_time' => $this->input->post('cast_time'),
																					'image' => $this->input->post('image'),
																					'attributes' => $this->_parse_attributes($_POST))
																					)
			{
				// Creating the attr was successful, redirect them back to the admin page
				flashmsg('Weapon created successfully.', 'success');
				redirect('/editor/items/weapons');
			}
			$all_classes = $this->classes->get_all();
			$classes = array('' => 'Select one');
			foreach ($all_classes as $class)
			{
				$classes[$class->id] = $class->name;
			}
			$this->data['classes'] = $classes;
			
		} else if($action=='edit') {
			$weapon = $this->data['weapons'] = $this->weapons->get($id);
			if (empty($id) || empty($weapon))
			{
				flashmsg('You must specify a weapon to edit.', 'error');
				redirect('/editor/items/weapons');
			}
			$this->form_validation->set_rules('name', 'Name', 'required|trim|xss_clean');
			$this->form_validation->set_rules('level', 'Level', 'required|trim|xss_clean|integer');
			$this->form_validation->set_rules('damage', 'Damage', 'trim|xss_clean|integer');
			$this->form_validation->set_rules('classes', 'Classes', 'required|trim|xss_clean|integer');
			$this->form_validation->set_rules('body_location', 'Body Location', 'trim|xss_clean|integer');
			$this->form_validation->set_rules('stackable', 'Stackable', 'required|trim');
			$this->form_validation->set_rules('cast_time', 'Cast Time', 'required|trim|xss_clean');
			$this->form_validation->set_rules('image', 'Image', 'required|trim|xss_clean');
			$this->form_validation->set_rules('description', 'Description', 'required|trim|xss_clean');
			
			if ($this->form_validation->run() == TRUE && $this->classes->update($id, array(
																					'name' => $this->input->post('name'),
																					'description' => $this->input->post('description'),
																					'damage' => $this->input->post('damage'),
																					'body_location' => $this->input->post('body_location'),
																					'classes' => $this->input->post('classes'),
																					'stackable' => $this->input->post('stackable'),
																					'cast_time' => $this->input->post('cast_time'),
																					'image' => $this->input->post('image'),
																					'attributes' => $this->_parse_attributes($_POST))
																					)
			{
				// Editing the class was successful, redirect them back to the admin page
				flashmsg('Weapon has been updated successfully.', 'success');
				redirect('/editor/items/weapons');
			}
			$all_classes = $this->classes->get_all();
			$classes = array('' => 'Select one');
			foreach ($all_classes as $class)
			{
				$classes[$class->id] = $class->name;
			}
			$this->data['classes'] = $classes;
		} else if($action=='delete') {
			$weapon = $this->data['weapon'] = $this->weapons->get($id);
			if (empty($id) || empty($weapon))
			{
				flashmsg('You must specify a weapon to delete.', 'error');
				redirect('/editor/items/weapons');
			}
			$this->form_validation->set_rules('confirm', 'confirmation', 'required');
			$this->form_validation->set_rules('id', 'weapon ID', 'required|is_natural');
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
						$this->weapons->delete($id);
					}
					
					// Redirect them back to the admin page
					flashmsg('Weapon deleted successfully.', 'success');
					redirect('/editor/items/weapons');
				}
				else
				{
					redirect('/editor/items/weapons');
				}
			}
			$this->data['csrf'] = $this->_get_csrf_nonce();
			
		}

		$this->data['weapons'] = $this->weapons->get_all();
		$this->data['meta_title'] = 'Weapons';
	}
	
	public function armor($action = NULL, $id = NULL)
	{
		$this->view = 'editor/items/armor/index';
		
		if($action!=NULL) {
			$this->view = 'editor/items/armor/'.$action;
		}
		
		if($action=='create') {
			$this->form_validation->set_rules('name', 'Name', 'required|trim|xss_clean');
			$this->form_validation->set_rules('level', 'Level', 'required|trim|xss_clean|integer');
			$this->form_validation->set_rules('defense', 'Defense', 'trim|xss_clean|integer');
			$this->form_validation->set_rules('classes', 'Classes', 'required|trim|xss_clean|integer');
			$this->form_validation->set_rules('body_location', 'Body Location', 'trim|xss_clean|integer');
			$this->form_validation->set_rules('cast_time', 'Cast Time', 'required|trim|xss_clean');
			$this->form_validation->set_rules('image', 'Image', 'required|trim|xss_clean');
			$this->form_validation->set_rules('description', 'Description', 'required|trim|xss_clean');
			
			if ($this->form_validation->run() == TRUE && $this->items->insert(array(
																					'name' => $this->input->post('name'),
																					'description' => $this->input->post('description'),
																					'defense' => $this->input->post('defense'),
																					'body_location' => $this->input->post('body_location'),
																					'classes' => $this->input->post('classes'),
																					'cast_time' => $this->input->post('cast_time'),
																					'image' => $this->input->post('image'),
																					'attributes' => $this->_parse_attributes($_POST))
																					)
			{
				// Creating the attr was successful, redirect them back to the admin page
				flashmsg('Armor created successfully.', 'success');
				redirect('/editor/items/armor');
			}
			$all_classes = $this->classes->get_all();
			$classes = array('' => 'Select one');
			foreach ($all_classes as $class)
			{
				$classes[$class->id] = $class->name;
			}
			$this->data['classes'] = $classes;
			
		} else if($action=='edit') {
			$armor = $this->data['armor'] = $this->armor->get($id);
			if (empty($id) || empty($armor))
			{
				flashmsg('You must specify a armor to edit.', 'error');
				redirect('/editor/items/armor');
			}
			$this->form_validation->set_rules('name', 'Name', 'required|trim|xss_clean');
			$this->form_validation->set_rules('level', 'Level', 'required|trim|xss_clean|integer');
			$this->form_validation->set_rules('defense', 'Defense', 'trim|xss_clean|integer');
			$this->form_validation->set_rules('classes', 'Classes', 'required|trim|xss_clean|integer');
			$this->form_validation->set_rules('body_location', 'Body Location', 'trim|xss_clean|integer');
			$this->form_validation->set_rules('cast_time', 'Cast Time', 'required|trim|xss_clean');
			$this->form_validation->set_rules('image', 'Image', 'required|trim|xss_clean');
			$this->form_validation->set_rules('description', 'Description', 'required|trim|xss_clean');
			
			if ($this->form_validation->run() == TRUE && $this->classes->update($id, array(
																					'name' => $this->input->post('name'),
																					'description' => $this->input->post('description'),
																					'defense' => $this->input->post('defense'),
																					'body_location' => $this->input->post('body_location'),
																					'classes' => $this->input->post('classes'),
																					'cast_time' => $this->input->post('cast_time'),
																					'image' => $this->input->post('image'),
																					'attributes' => $this->_parse_attributes($_POST))
																					)
			{
				// Editing the class was successful, redirect them back to the admin page
				flashmsg('Armor has been updated successfully.', 'success');
				redirect('/editor/items/armor');
			}
			$all_classes = $this->classes->get_all();
			$classes = array('' => 'Select one');
			foreach ($all_classes as $class)
			{
				$classes[$class->id] = $class->name;
			}
			$this->data['classes'] = $classes;
		} else if($action=='delete') {
			$armor = $this->data['armor'] = $this->armor->get($id);
			if (empty($id) || empty($armor))
			{
				flashmsg('You must specify a armor to delete.', 'error');
				redirect('/editor/items/armor');
			}
			$this->form_validation->set_rules('confirm', 'confirmation', 'required');
			$this->form_validation->set_rules('id', 'armor ID', 'required|is_natural');
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
						$this->armor->delete($id);
					}
					
					// Redirect them back to the admin page
					flashmsg('Weapon deleted successfully.', 'success');
					redirect('/editor/items/armor');
				}
				else
				{
					redirect('/editor/items/armor');
				}
			}
			$this->data['csrf'] = $this->_get_csrf_nonce();
			
		}

		$this->data['armor'] = $this->armor->get_all();
		$this->data['meta_title'] = 'Armor';
	}
	
	public function shields($action = NULL, $id = NULL)
	{
		$this->view = 'editor/items/shields/index';
		
		if($action!=NULL) {
			$this->view = 'editor/items/shields/'.$action;
		}
		
		if($action=='create') {
			$this->form_validation->set_rules('name', 'Name', 'required|trim|xss_clean');
			$this->form_validation->set_rules('level', 'Level', 'required|trim|xss_clean|integer');
			$this->form_validation->set_rules('defense', 'Defense', 'trim|xss_clean|integer');
			$this->form_validation->set_rules('classes', 'Classes', 'required|trim|xss_clean|integer');
			$this->form_validation->set_rules('body_location', 'Body Location', 'trim|xss_clean|integer');
			$this->form_validation->set_rules('cast_time', 'Cast Time', 'required|trim|xss_clean');
			$this->form_validation->set_rules('image', 'Image', 'required|trim|xss_clean');
			$this->form_validation->set_rules('description', 'Description', 'required|trim|xss_clean');
			
			if ($this->form_validation->run() == TRUE && $this->items->insert(array(
																					'name' => $this->input->post('name'),
																					'description' => $this->input->post('description'),
																					'defense' => $this->input->post('defense'),
																					'body_location' => $this->input->post('body_location'),
																					'classes' => $this->input->post('classes'),
																					'cast_time' => $this->input->post('cast_time'),
																					'image' => $this->input->post('image'),
																					'attributes' => $this->_parse_attributes($_POST))
																					)
			{
				// Creating the attr was successful, redirect them back to the admin page
				flashmsg('Shield created successfully.', 'success');
				redirect('/editor/items/shields');
			}
			$all_classes = $this->classes->get_all();
			$classes = array('' => 'Select one');
			foreach ($all_classes as $class)
			{
				$classes[$class->id] = $class->name;
			}
			$this->data['classes'] = $classes;
			
		} else if($action=='edit') {
			$shields = $this->data['shields'] = $this->shields->get($id);
			if (empty($id) || empty($shields))
			{
				flashmsg('You must specify a shield to edit.', 'error');
				redirect('/editor/items/shields');
			}
			$this->form_validation->set_rules('name', 'Name', 'required|trim|xss_clean');
			$this->form_validation->set_rules('level', 'Level', 'required|trim|xss_clean|integer');
			$this->form_validation->set_rules('defense', 'Defense', 'trim|xss_clean|integer');
			$this->form_validation->set_rules('classes', 'Classes', 'required|trim|xss_clean|integer');
			$this->form_validation->set_rules('body_location', 'Body Location', 'trim|xss_clean|integer');
			$this->form_validation->set_rules('cast_time', 'Cast Time', 'required|trim|xss_clean');
			$this->form_validation->set_rules('image', 'Image', 'required|trim|xss_clean');
			$this->form_validation->set_rules('description', 'Description', 'required|trim|xss_clean');
			
			if ($this->form_validation->run() == TRUE && $this->classes->update($id, array(
																					'name' => $this->input->post('name'),
																					'description' => $this->input->post('description'),
																					'defense' => $this->input->post('defense'),
																					'body_location' => $this->input->post('body_location'),
																					'classes' => $this->input->post('classes'),
																					'cast_time' => $this->input->post('cast_time'),
																					'image' => $this->input->post('image'),
																					'attributes' => $this->_parse_attributes($_POST))
																					)
			{
				// Editing the class was successful, redirect them back to the admin page
				flashmsg('Shield has been updated successfully.', 'success');
				redirect('/editor/items/shields');
			}
			$all_classes = $this->classes->get_all();
			$classes = array('' => 'Select one');
			foreach ($all_classes as $class)
			{
				$classes[$class->id] = $class->name;
			}
			$this->data['classes'] = $classes;
		} else if($action=='delete') {
			$shields = $this->data['shields'] = $this->shields->get($id);
			if (empty($id) || empty($shields))
			{
				flashmsg('You must specify a shield to delete.', 'error');
				redirect('/editor/items/shields');
			}
			$this->form_validation->set_rules('confirm', 'confirmation', 'required');
			$this->form_validation->set_rules('id', 'shields ID', 'required|is_natural');
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
						$this->shields->delete($id);
					}
					
					// Redirect them back to the admin page
					flashmsg('Shield deleted successfully.', 'success');
					redirect('/editor/items/shields');
				}
				else
				{
					redirect('/editor/items/shields');
				}
			}
			$this->data['csrf'] = $this->_get_csrf_nonce();
			
		}

		$this->data['shields'] = $this->shields->get_all();
		$this->data['meta_title'] = 'Shields';
	}
	
	public function amulets($action = NULL, $id = NULL)
	{
		$this->view = 'editor/items/amulets/index';
		
		if($action!=NULL) {
			$this->view = 'editor/items/amulets/'.$action;
		}
		
		if($action=='create') {
			$this->form_validation->set_rules('name', 'Name', 'required|trim|xss_clean');
			$this->form_validation->set_rules('level', 'Level', 'required|trim|xss_clean|integer');
			$this->form_validation->set_rules('defense', 'Defense', 'trim|xss_clean|integer');
			$this->form_validation->set_rules('classes', 'Classes', 'required|trim|xss_clean|integer');
			$this->form_validation->set_rules('body_location', 'Body Location', 'trim|xss_clean|integer');
			$this->form_validation->set_rules('cast_time', 'Cast Time', 'required|trim|xss_clean');
			$this->form_validation->set_rules('image', 'Image', 'required|trim|xss_clean');
			$this->form_validation->set_rules('description', 'Description', 'required|trim|xss_clean');
			
			if ($this->form_validation->run() == TRUE && $this->items->insert(array(
																					'name' => $this->input->post('name'),
																					'description' => $this->input->post('description'),
																					'defense' => $this->input->post('defense'),
																					'body_location' => $this->input->post('body_location'),
																					'classes' => $this->input->post('classes'),
																					'cast_time' => $this->input->post('cast_time'),
																					'image' => $this->input->post('image'),
																					'attributes' => $this->_parse_attributes($_POST))
																					)
			{
				// Creating the attr was successful, redirect them back to the admin page
				flashmsg('Amulet created successfully.', 'success');
				redirect('/editor/items/amulets');
			}
			$all_classes = $this->classes->get_all();
			$classes = array('' => 'Select one');
			foreach ($all_classes as $class)
			{
				$classes[$class->id] = $class->name;
			}
			$this->data['classes'] = $classes;
			
		} else if($action=='edit') {
			$amulets = $this->data['amulets'] = $this->amulets->get($id);
			if (empty($id) || empty($amulets))
			{
				flashmsg('You must specify a amulet to edit.', 'error');
				redirect('/editor/items/amulets');
			}
			$this->form_validation->set_rules('name', 'Name', 'required|trim|xss_clean');
			$this->form_validation->set_rules('level', 'Level', 'required|trim|xss_clean|integer');
			$this->form_validation->set_rules('defense', 'Defense', 'trim|xss_clean|integer');
			$this->form_validation->set_rules('classes', 'Classes', 'required|trim|xss_clean|integer');
			$this->form_validation->set_rules('body_location', 'Body Location', 'trim|xss_clean|integer');
			$this->form_validation->set_rules('cast_time', 'Cast Time', 'required|trim|xss_clean');
			$this->form_validation->set_rules('image', 'Image', 'required|trim|xss_clean');
			$this->form_validation->set_rules('description', 'Description', 'required|trim|xss_clean');
			
			if ($this->form_validation->run() == TRUE && $this->classes->update($id, array(
																					'name' => $this->input->post('name'),
																					'description' => $this->input->post('description'),
																					'defense' => $this->input->post('defense'),
																					'body_location' => $this->input->post('body_location'),
																					'classes' => $this->input->post('classes'),
																					'cast_time' => $this->input->post('cast_time'),
																					'image' => $this->input->post('image'),
																					'attributes' => $this->_parse_attributes($_POST))
																					)
			{
				// Editing the class was successful, redirect them back to the admin page
				flashmsg('Amulet has been updated successfully.', 'success');
				redirect('/editor/items/amulets');
			}
			$all_classes = $this->classes->get_all();
			$classes = array('' => 'Select one');
			foreach ($all_classes as $class)
			{
				$classes[$class->id] = $class->name;
			}
			$this->data['classes'] = $classes;
		} else if($action=='delete') {
			$amulets = $this->data['amulets'] = $this->amulets->get($id);
			if (empty($id) || empty($amulets))
			{
				flashmsg('You must specify a amulet to delete.', 'error');
				redirect('/editor/items/amulets');
			}
			$this->form_validation->set_rules('confirm', 'confirmation', 'required');
			$this->form_validation->set_rules('id', 'amulets ID', 'required|is_natural');
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
						$this->amulets->delete($id);
					}
					
					// Redirect them back to the admin page
					flashmsg('Amulet deleted successfully.', 'success');
					redirect('/editor/items/amulets');
				}
				else
				{
					redirect('/editor/items/amulets');
				}
			}
			$this->data['csrf'] = $this->_get_csrf_nonce();
			
		}

		$this->data['amulets'] = $this->amulets->get_all();
		$this->data['meta_title'] = 'Amulets';
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
		$this->view = 'editor/items/relics/index';
		
		if($action!=NULL) {
			$this->view = 'editor/items/relics/'.$action;
		}
		
		if($action=='create') {
			$this->form_validation->set_rules('name', 'Name', 'required|trim|xss_clean');
			$this->form_validation->set_rules('level', 'Level', 'required|trim|xss_clean|integer');
			$this->form_validation->set_rules('defense', 'Defense', 'trim|xss_clean|integer');
			$this->form_validation->set_rules('damage', 'Damage', 'trim|xss_clean|integer');
			$this->form_validation->set_rules('classes', 'Classes', 'required|trim|xss_clean|integer');
			$this->form_validation->set_rules('body_location', 'Body Location', 'trim|xss_clean|integer');
			$this->form_validation->set_rules('cast_time', 'Cast Time', 'required|trim|xss_clean');
			$this->form_validation->set_rules('image', 'Image', 'required|trim|xss_clean');
			$this->form_validation->set_rules('description', 'Description', 'required|trim|xss_clean');
			
			if ($this->form_validation->run() == TRUE && $this->items->insert(array(
																					'name' => $this->input->post('name'),
																					'description' => $this->input->post('description'),
																					'defense' => $this->input->post('defense'),
																					'damage' => $this->input->post('damage'),
																					'body_location' => $this->input->post('body_location'),
																					'classes' => $this->input->post('classes'),
																					'cast_time' => $this->input->post('cast_time'),
																					'image' => $this->input->post('image'),
																					'attributes' => $this->_parse_attributes($_POST))
																					)
			{
				// Creating the attr was successful, redirect them back to the admin page
				flashmsg('Relic created successfully.', 'success');
				redirect('/editor/items/relics');
			}
			$all_classes = $this->classes->get_all();
			$classes = array('' => 'Select one');
			foreach ($all_classes as $class)
			{
				$classes[$class->id] = $class->name;
			}
			$this->data['classes'] = $classes;
			
		} else if($action=='edit') {
			$relics = $this->data['relics'] = $this->relics->get($id);
			if (empty($id) || empty($relics))
			{
				flashmsg('You must specify a amulet to edit.', 'error');
				redirect('/editor/items/relics');
			}
			$this->form_validation->set_rules('name', 'Name', 'required|trim|xss_clean');
			$this->form_validation->set_rules('level', 'Level', 'required|trim|xss_clean|integer');
			$this->form_validation->set_rules('defense', 'Defense', 'trim|xss_clean|integer');
			$this->form_validation->set_rules('damage', 'Damage', 'trim|xss_clean|integer');
			$this->form_validation->set_rules('classes', 'Classes', 'required|trim|xss_clean|integer');
			$this->form_validation->set_rules('body_location', 'Body Location', 'trim|xss_clean|integer');
			$this->form_validation->set_rules('cast_time', 'Cast Time', 'required|trim|xss_clean');
			$this->form_validation->set_rules('image', 'Image', 'required|trim|xss_clean');
			$this->form_validation->set_rules('description', 'Description', 'required|trim|xss_clean');
			
			if ($this->form_validation->run() == TRUE && $this->classes->update($id, array(
																					'name' => $this->input->post('name'),
																					'description' => $this->input->post('description'),
																					'defense' => $this->input->post('defense'),
																					'damage' => $this->input->post('damage'),
																					'body_location' => $this->input->post('body_location'),
																					'classes' => $this->input->post('classes'),
																					'cast_time' => $this->input->post('cast_time'),
																					'image' => $this->input->post('image'),
																					'attributes' => $this->_parse_attributes($_POST))
																					)
			{
				// Editing the class was successful, redirect them back to the admin page
				flashmsg('Relic has been updated successfully.', 'success');
				redirect('/editor/items/relics');
			}
			$all_classes = $this->classes->get_all();
			$classes = array('' => 'Select one');
			foreach ($all_classes as $class)
			{
				$classes[$class->id] = $class->name;
			}
			$this->data['classes'] = $classes;
		} else if($action=='delete') {
			$relics = $this->data['relics'] = $this->relics->get($id);
			if (empty($id) || empty($relics))
			{
				flashmsg('You must specify a relic to delete.', 'error');
				redirect('/editor/items/relics');
			}
			$this->form_validation->set_rules('confirm', 'confirmation', 'required');
			$this->form_validation->set_rules('id', 'relics ID', 'required|is_natural');
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
						$this->relics->delete($id);
					}
					
					// Redirect them back to the admin page
					flashmsg('Amulet deleted successfully.', 'success');
					redirect('/editor/items/relics');
				}
				else
				{
					redirect('/editor/items/relics');
				}
			}
			$this->data['csrf'] = $this->_get_csrf_nonce();
			
		}

		$this->data['relics'] = $this->relics->get_all();
		$this->data['meta_title'] = 'Relics';
	}
	
	public function consumables($action = NULL, $id = NULL)
	{
		$this->view = 'editor/items/consumables/index';
		
		if($action!=NULL) {
			$this->view = 'editor/items/consumables/'.$action;
		}
		
		if($action=='create') {
			$this->form_validation->set_rules('name', 'Name', 'required|trim|xss_clean');
			$this->form_validation->set_rules('level', 'Level', 'required|trim|xss_clean|integer');
			$this->form_validation->set_rules('modified_amount', 'Modified Amount', 'trim|xss_clean|integer');
			$this->form_validation->set_rules('stackable', 'Stackable', 'trim|xss_clean|integer');
			$this->form_validation->set_rules('classes', 'Classes', 'required|trim|xss_clean|integer');
			$this->form_validation->set_rules('cast_time', 'Cast Time', 'required|trim|xss_clean');
			$this->form_validation->set_rules('image', 'Image', 'required|trim|xss_clean');
			$this->form_validation->set_rules('description', 'Description', 'required|trim|xss_clean');
			
			if ($this->form_validation->run() == TRUE && $this->items->insert(array(
																					'name' => $this->input->post('name'),
																					'description' => $this->input->post('description'),
																					'modified_amount' => $this->input->post('modified_amount'),
																					'stackable' => $this->input->post('stackable'),
																					'classes' => $this->input->post('classes'),
																					'cast_time' => $this->input->post('cast_time'),
																					'image' => $this->input->post('image'),
																					'attributes' => $this->_parse_attributes($_POST))
																					)
			{
				// Creating the attr was successful, redirect them back to the admin page
				flashmsg('Consumable created successfully.', 'success');
				redirect('/editor/items/consumables');
			}
			$all_classes = $this->classes->get_all();
			$classes = array('' => 'Select one');
			foreach ($all_classes as $class)
			{
				$classes[$class->id] = $class->name;
			}
			$this->data['classes'] = $classes;
			
		} else if($action=='edit') {
			$consumables = $this->data['consumables'] = $this->consumables->get($id);
			if (empty($id) || empty($consumables))
			{
				flashmsg('You must specify a amulet to edit.', 'error');
				redirect('/editor/items/consumables');
			}
			$this->form_validation->set_rules('name', 'Name', 'required|trim|xss_clean');
			$this->form_validation->set_rules('level', 'Level', 'required|trim|xss_clean|integer');
			$this->form_validation->set_rules('modified_amount', 'Modified Amount', 'trim|xss_clean|integer');
			$this->form_validation->set_rules('stackable', 'Stackable', 'trim|xss_clean|integer');
			$this->form_validation->set_rules('classes', 'Classes', 'required|trim|xss_clean|integer');
			$this->form_validation->set_rules('cast_time', 'Cast Time', 'required|trim|xss_clean');
			$this->form_validation->set_rules('image', 'Image', 'required|trim|xss_clean');
			$this->form_validation->set_rules('description', 'Description', 'required|trim|xss_clean');
			
			if ($this->form_validation->run() == TRUE && $this->classes->update($id, array(
																					'name' => $this->input->post('name'),
																					'description' => $this->input->post('description'),
																					'modified_amount' => $this->input->post('modified_amount'),
																					'stackable' => $this->input->post('stackable'),
																					'classes' => $this->input->post('classes'),
																					'cast_time' => $this->input->post('cast_time'),
																					'image' => $this->input->post('image'),
																					'attributes' => $this->_parse_attributes($_POST))
																					)
			{
				// Editing the class was successful, redirect them back to the admin page
				flashmsg('Consumable has been updated successfully.', 'success');
				redirect('/editor/items/consumables');
			}
			$all_classes = $this->classes->get_all();
			$classes = array('' => 'Select one');
			foreach ($all_classes as $class)
			{
				$classes[$class->id] = $class->name;
			}
			$this->data['classes'] = $classes;
		} else if($action=='delete') {
			$consumables = $this->data['consumables'] = $this->consumables->get($id);
			if (empty($id) || empty($consumables))
			{
				flashmsg('You must specify a relic to delete.', 'error');
				redirect('/editor/items/consumables');
			}
			$this->form_validation->set_rules('confirm', 'confirmation', 'required');
			$this->form_validation->set_rules('id', 'consumables ID', 'required|is_natural');
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
						$this->consumables->delete($id);
					}
					
					// Redirect them back to the admin page
					flashmsg('Amulet deleted successfully.', 'success');
					redirect('/editor/items/consumables');
				}
				else
				{
					redirect('/editor/items/consumables');
				}
			}
			$this->data['csrf'] = $this->_get_csrf_nonce();
			
		}

		$this->data['consumables'] = $this->consumables->get_all();
		$this->data['meta_title'] = 'Consumables';
	}
	
	public function rings($action = NULL, $id = NULL)
	{
		$this->view = 'editor/items/rings/index';
		
		if($action!=NULL) {
			$this->view = 'editor/items/rings/'.$action;
		}
		
		if($action=='create') {
			$this->form_validation->set_rules('name', 'Name', 'required|trim|xss_clean');
			$this->form_validation->set_rules('level', 'Level', 'required|trim|xss_clean|integer');
			$this->form_validation->set_rules('defense', 'Defense', 'trim|xss_clean|integer');
			$this->form_validation->set_rules('classes', 'Classes', 'required|trim|xss_clean|integer');
			$this->form_validation->set_rules('body_location', 'Body Location', 'trim|xss_clean|integer');
			$this->form_validation->set_rules('cast_time', 'Cast Time', 'required|trim|xss_clean');
			$this->form_validation->set_rules('image', 'Image', 'required|trim|xss_clean');
			$this->form_validation->set_rules('description', 'Description', 'required|trim|xss_clean');
			
			if ($this->form_validation->run() == TRUE && $this->items->insert(array(
																					'name' => $this->input->post('name'),
																					'description' => $this->input->post('description'),
																					'defense' => $this->input->post('defense'),
																					'body_location' => $this->input->post('body_location'),
																					'classes' => $this->input->post('classes'),
																					'cast_time' => $this->input->post('cast_time'),
																					'image' => $this->input->post('image'),
																					'attributes' => $this->_parse_attributes($_POST))
																					)
			{
				// Creating the attr was successful, redirect them back to the admin page
				flashmsg('Ring created successfully.', 'success');
				redirect('/editor/items/rings');
			}
			$all_classes = $this->classes->get_all();
			$classes = array('' => 'Select one');
			foreach ($all_classes as $class)
			{
				$classes[$class->id] = $class->name;
			}
			$this->data['classes'] = $classes;
			
		} else if($action=='edit') {
			$rings = $this->data['rings'] = $this->rings->get($id);
			if (empty($id) || empty($rings))
			{
				flashmsg('You must specify a ring to edit.', 'error');
				redirect('/editor/items/rings');
			}
			$this->form_validation->set_rules('name', 'Name', 'required|trim|xss_clean');
			$this->form_validation->set_rules('level', 'Level', 'required|trim|xss_clean|integer');
			$this->form_validation->set_rules('defense', 'Defense', 'trim|xss_clean|integer');
			$this->form_validation->set_rules('classes', 'Classes', 'required|trim|xss_clean|integer');
			$this->form_validation->set_rules('body_location', 'Body Location', 'trim|xss_clean|integer');
			$this->form_validation->set_rules('cast_time', 'Cast Time', 'required|trim|xss_clean');
			$this->form_validation->set_rules('image', 'Image', 'required|trim|xss_clean');
			$this->form_validation->set_rules('description', 'Description', 'required|trim|xss_clean');
			
			if ($this->form_validation->run() == TRUE && $this->classes->update($id, array(
																					'name' => $this->input->post('name'),
																					'description' => $this->input->post('description'),
																					'defense' => $this->input->post('defense'),
																					'body_location' => $this->input->post('body_location'),
																					'classes' => $this->input->post('classes'),
																					'cast_time' => $this->input->post('cast_time'),
																					'image' => $this->input->post('image'),
																					'attributes' => $this->_parse_attributes($_POST))
																					)
			{
				// Editing the class was successful, redirect them back to the admin page
				flashmsg('Ring has been updated successfully.', 'success');
				redirect('/editor/items/rings');
			}
			$all_classes = $this->classes->get_all();
			$classes = array('' => 'Select one');
			foreach ($all_classes as $class)
			{
				$classes[$class->id] = $class->name;
			}
			$this->data['classes'] = $classes;
		} else if($action=='delete') {
			$rings = $this->data['rings'] = $this->rings->get($id);
			if (empty($id) || empty($rings))
			{
				flashmsg('You must specify a ring to delete.', 'error');
				redirect('/editor/items/rings');
			}
			$this->form_validation->set_rules('confirm', 'confirmation', 'required');
			$this->form_validation->set_rules('id', 'rings ID', 'required|is_natural');
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
						$this->rings->delete($id);
					}
					
					// Redirect them back to the admin page
					flashmsg('Amulet deleted successfully.', 'success');
					redirect('/editor/items/rings');
				}
				else
				{
					redirect('/editor/items/rings');
				}
			}
			$this->data['csrf'] = $this->_get_csrf_nonce();
			
		}

		$this->data['rings'] = $this->rings->get_all();
		$this->data['meta_title'] = 'Rings';
	}
	
}