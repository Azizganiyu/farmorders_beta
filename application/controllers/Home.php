<?php
class Home extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
        $this->load->library(array('form_validation','session'));
        $this->load->helper(array('form','check'));
    }


	public function index()
	{
        $data['page'] = 'home';
        $data['title'] = site_title.' | Home';
        $this->load->view('header', $data);
        $this->load->view('home');
        $this->load->view('footer');
	}
} 