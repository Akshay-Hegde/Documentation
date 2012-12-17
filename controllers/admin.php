<?php defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends Admin_Controller
{

	public $directory = '';
	public $data_file = '';

	public function __construct()
    {

        parent::__construct();

		// Load libraries
		$this->lang->load('documentation');
		$this->load->model('documentation_m');
		$this->load->library('form_validation');
		$this->load->helper('markdown');

		// Create data object
		$this->data = new stdClass();

		// Get current directory information and data
		$this->directory = $this->documentation_m->get_directory();
		$this->data_file = $this->directory.'_data';
		$this->_data     = json_decode(file_get_contents($this->data_file), true) or array();

		// Check data is set
		if( ! $this->_data && $this->uri->segment(3) != 'language' )
		{
			// Redirect etc etc.
		}

		// Add metadata
		$this->template->append_css('module::admin.css')
					   ->append_js('module::jquery.ui.nestedSortable.js')
					   ->append_js('module::jquery.autogrow.js')
					   ->append_js('module::admin.js');

		// Set the validation rules
		$this->validation_rules = array(
									array('field' => 'title', 'label' => 'Title', 'rules' => 'trim|max_length[255]|required'),
									array('field' => 'slug', 'label' => 'Slug', 'rules' => 'trim|max_length[255]|required'),
									array('field' => 'parent', 'label' => 'Parent', 'rules' => 'trim|numeric'),
									array('field' => 'keywords', 'label' => 'Keywords', 'rules' => 'trim'),
									array('field' => 'description', 'label' => 'Description', 'rules' => 'trim')
								  );

	}

	public function index()
	{

		// Variables
		$this->data->controller =& $this;
		$this->data->docs       =  $this->documentation_m->generate_doc_tree($this->_data);
		$this->data->dropdown   =  $this->documentation_m->build_dropdown($this->_data);

		// Build the page
		$this->template->title(lang('docs:title'))
					   ->build('admin/index', $this->data);
	}

	public function create()
	{

		// Check for post data
		if( substr($this->input->post('btnAction'), 0, 4) == 'save' )
		{

			// Variables
			$status            = TRUE;
			$this->data->input = $this->input->post();

			// Set validation rules
			$this->form_validation->set_rules($this->validation_rules);

			// Run validation
			if( $this->form_validation->run() )
			{

				// Add to data file
				$input = $this->input->post();
				$id    = ( count($this->_data) + 1 );
				unset($input['btnAction']);
				$this->_data[] = array_merge(array('id' => $id, 'order' => 0), $input);
				file_put_contents($this->data_file, json_encode($this->_data)) or $status = FALSE;

				// Create file
				$file   = $this->directory.$id.'-'.$input['slug'].'.md';
				$handle = fopen($file, 'w') or $status = FALSE;
				fclose($handle);
				chmod($file, 0777);

				// Redirect
				if( $status )
				{
					$this->session->set_flashdata('success', 'New documentation created successfully');
					redirect('admin/documentation');
				}

			}

			// Redirect
			if( ! $status )
			{
				// Redirect
				$this->session->set_flashdata('error', 'There was an error creating the documentation');
				redirect('admin/documentation/create');
			}

		}

		// Add dropdown
		$this->data->dropdown = $this->documentation_m->build_dropdown($this->_data);

		// Build the page
		$this->template->title(lang('docs:title').' '.lang('docs:section:create'))
					   ->build('admin/create', $this->data);

	}

	public function update()
	{

		// Set validation rules
		$this->form_validation->set_rules($this->validation_rules);

		// Run validation
		if( $this->form_validation->run() )
		{

			// Variables
			$input = $this->input->post();
			unset($input['btnAction']);

			// Loop data to find array
			foreach( $this->_data AS &$doc )
			{
				// Find correct file
				if( $doc['id'] == $input['id'] )
				{
					// Rename file
					if( $doc['slug'] != $input['slug'] )
					{
						rename($this->directory.$doc['id'].'-'.$doc['slug'].'.md', $this->directory.$input['slug'].'.md');
					}

					// Update array
					$doc = array_merge($doc, $input);
					break;
				}
			}

			// Write to file
			file_put_contents($this->data_file, json_encode($this->_data));

			// Flashdata
			$this->session->set_flashdata('success', 'Document updated successfully');

		}
		else
		{
			// Flashdata
			$this->session->set_flashdata('error', 'Error updating the document');
			
		}

		// Redirect
		redirect('admin/documentation');
	}

	public function edit($id)
	{

		// Variables
		$document = array();

		// Get data
		foreach( $this->_data AS $doc )
		{
			if( $doc['id'] == $id )
			{
				$document = $doc;
				break;
			}
		}

		// Check for post
		if( $this->input->post('document') )
		{
			$string = str_replace('{tab}', "	", $_POST['document']);
			file_put_contents($this->directory.$document['id'].'-'.$document['slug'].'.md', $string);
			$this->session->set_flashdata('success', 'Document updated successfully');
		}

		// Check document
		if( ! empty($document) )
		{

			// Assign data
			$this->data->title    = $document['title'];
			$this->data->document = file_get_contents($this->directory.$document['id'].'-'.$document['slug'].'.md');
			$this->data->preview  = Markdown($this->data->document);

			// Build the page
			$this->template->title(lang('docs:title').' '.lang('docs:section:edit'))
						   ->build('admin/edit', $this->data);

		}
		else
		{
			$this->session->set_flashdata('error', 'Error updating the documentation');
			redirect('documentation');
		}

	}

	public function delete($id)
	{



	}

	public function order()
	{

		// Variables
		$order		= $this->input->post('order');
		$data		= $this->input->post('data');
		$root_docs	= isset($data['root_docs']) ? $data['root_docs'] : array();
		$keys       = array();
		$tmp        = array();

		// Check order is valid
		if( is_array($order) )
		{

			// Unset all category relationships
			foreach( $this->_data AS $key => &$doc )
			{
				$doc['parent'] = 0;
				$id            = str_replace('doc_', '', $doc['id']);
				$keys[$id]     = $key;
			}

			// Loop each document
			foreach( $order AS $i => $item )
			{

				// Variables
				$id  = str_replace('doc_', '', $item['id']);
				$key = $keys[$id];

				// Update array
				$this->_data[$key]['order'] = $i;
				$tmp[] = $this->_data[$key];

				// Update children
				$this->documentation_m->set_children($item, $keys, $this->_data, $tmp);
			}

			// Write to file
			file_put_contents($this->data_file, json_encode($tmp));
		}

	}

	public function details($id)
	{

		// Find required file
		foreach( $this->_data AS $doc )
		{
			if( $doc['id'] == $id )
			{
				echo json_encode($doc);
				exit();
			}
		}

		// Otherwise
		echo '[]';
		exit();
	}

	public function preview()
	{
		if( $this->input->post('document') )
		{
			echo Markdown($this->input->post('document'));
			exit();
		}
	}

}