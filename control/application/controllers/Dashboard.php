<?php
/**
 * Dashboard Class
 * 
 * Displays to the user an overview of all the recent activities
 * 
 */
class Dashboard extends CI_Controller
{

    /**
     * Class constructor
     * 
     * Loads the session library and the url helper
     * 
     * Checks if user is currently logged in
     * if user is not logged in redirect to login page
     * 
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('url');

        //verify user is logged in
        if($this->session->logged_in != true)
        {
            //get the url the user is trying to acces before being redirected to login page
            $current_url = current_url();
            //redirect user if currently not logged in
            header('location:'.base_url.'index.php/users/login?re_direct='.$current_url);
        }

    }

    //---------------------------------------------------------------------------------------------
    
    /**
     * Class index
     * 
     * Loads the default pages
     */
    public function index()
    {
        $data['title'] = "Dashboard";
        $data['page'] = "dashboard";
        $this->load->view('template/header', $data);
        $this->load->view('users/dashboard');
        $this->load->view('template/footer');
    }
}