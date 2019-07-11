<?php
class page extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library(array('form_validation','session'));
        $this->load->helper(array('form','check'));
    }

    public function index()
    {
        header('location:'.base_url.'/index.php/home');
    }

    public function about()
    {
        $data['page'] = 'about';
        $data['title'] = site_title.' | about';
        $this->load->view('header', $data);
        $this->load->view('about');
        $this->load->view('footer');
    }

    public function contact()
    {

        $data['page'] = 'contact';
        $data['title'] = site_title.' | contact';
        $this->load->view('header', $data);
        $this->load->view('contact');
        $this->load->view('footer');
    }

    public function process_mail()
    {
        $this->form_validation->set_rules('name', 'Name', 'required|trim|htmlspecialchars|max_length[20]');
        $this->form_validation->set_rules('email', 'Email Address', 'required|trim|htmlspecialchars');
        $this->form_validation->set_rules('message', 'Message', 'required|trim|htmlspecialchars');

        //if form validation error, reload user registeration page
        if($this->form_validation->run() == FALSE)
        {
            echo validation_errors();
        }
        else
        {
            $this->load->library('email');

            $this->email->from($this->input->post('email'), $this->input->post('name'));
            $this->email->to('farmorders@gmail.com');
            $this->email->cc('');
            $this->email->bcc('');

            $this->email->subject('Mail from farmorders');
            $this->email->message($this->input->post('message'));

            $send = $this->email->send();
            if($send)
            {
                echo "success";
            }
            else
            {
                echo "something went wrong <br>";
                echo "email: ".$this->input->post('email')."<br>";
                echo "name: ".$this->input->post('name')."<br>";
                echo "message: ".$this->input->post('message')."<br>";
            }
        }
        
    }

    public function account()
    {
        $data['page'] = 'account';
        $data['title'] = site_title.' | Your account';
        $this->load->view('header', $data);
        $this->load->view('account');
        $this->load->view('footer');
    }
}