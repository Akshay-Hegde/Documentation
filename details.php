<?php defined('BASEPATH') or exit('No direct script access allowed');

class Module_Documentation extends Module {
	
	public $version = '0.5.3';
	
	public function __construct()
	{
		parent::__construct();
	}

	public function info()
	{

		$info = array(
			'name' => array(
				'en' => 'Documentation'
			),
			'description' => array(
				'en' => 'Document ALL THE THINGS!!!'
			),
			'frontend' => TRUE,
			'backend'  => TRUE,
			'menu'	   => 'content',
			'author'   => 'Jamie Holdroyd',
			'shortcuts' => array(
				array(
				    'name' 	=> 'docs:shortcut:create',
				    'uri'	=> 'admin/documentation/create',
				    'class' => 'add'
				)
			)
		);

		return $info;
	}

	public function install()
	{

		return TRUE;
	}

	public function uninstall()
	{

		return TRUE;
	}

	public function upgrade($version)
	{

		return TRUE;
	}

	public function help()
	{

		return TRUE;
	}

}