<?php

class Blog extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('blog_model');
        $this->load->library(array('form_validation','session'));
        $this->load->helper(array('form','check'));
    }

    public function index()
    {
        $this->posts();
    }


    public function posts($tag = null)
    {
        if($tag != null)
        {
            $tag = trim(htmlspecialchars($tag));  
        }

        $this->load->library('pagination');

        //configure the pagination
        $config = array();
        $config['base_url'] = base_url.'/index.php/blog/posts';  //set the base url
        $config['total_rows'] = $this->blog_model->count_posts($this->input->post('search_key'), $tag);  //get total number of registered users
        $config["per_page"] = 6; //display number of users per page
        $config['uri_segment'] = 3; //uri segment to be used for pagination(parameter)
        $choice = $config['total_rows'] / $config['per_page'];
        $config['num_links'] = round($choice); //number of pagination links to display
        $config['full_tag_open'] = '<div class="pagination_body col-12">';
        $config['full_tag_close'] = '</div>';
        $config['next_tag_open'] = '<span class="next_link">';
        $config['next_link'] = '>>';
        $config['next_tag_close'] = '</span>';
        $config['prev_tag_open'] = '<span class="prev_link">';
        $config['prev_link'] = '<<';
        $config['prev_tag_close'] = '</span>';
        $config['num_tag_open'] = '<span class="pagination_links">';
        $config['num_tag_close'] = '</span>';
        $config['cur_tag_open'] = '<span class="curr_pagination_link">';
        $config['cur_tag_close'] = '</span>';
        $this->pagination->initialize($config);

        $page = ($this->uri->segment(3))? $this->uri->segment(3) : 0; //set current page to uri segment(3) if exist or initialize to 0
        $data['tag_filter'] = $tag;
        $data['links'] = $this->pagination->create_links();
        $data['search_key'] = $this->input->post('search_key');
        $data['post'] =  $this->blog_model->get_all_posts($config["per_page"], $page, $this->input->post('search_key'), $tag);
        $data['featured'] = $this->blog_model->get_featured_post();
        $data['page'] = 'blog';
        $data['title'] = site_title.' - Blog';
        $this->load->view('header', $data);
        $this->load->view('blog/post');
        $this->load->view('footer');
    }

    public function view($title = null)
    {
        $title = str_replace('_', " ", $title);
        if(isset($_POST['submit_comment']))
        {
            $this->form_validation->set_rules('name', 'Name', 'required|trim|htmlspecialchars');
            $this->form_validation->set_rules('email','Email', 'required|trim|htmlspecialchars');
            $this->form_validation->set_rules('message','Message', 'required|trim|htmlspecialchars');
        }

        if(isset($title))
        {
            if($this->form_validation->run() == FALSE)
            {
                $data['post'] = $this->blog_model->get_single_post($title);
                $data['comments'] = $this->blog_model->get_comments($data['post']['id']);
                $data['next_post'] = $this->blog_model->get_next_post($data['post']['id']);
                $data['prev_post'] = $this->blog_model->get_prev_post($data['post']['id']);
                $data['page'] = 'blog';
                $data['title'] = $data['post']['post_title'];
                $this->load->view('header', $data);
                $this->load->view('blog/view');
                $this->load->view('footer');
            }
            else
            {
                $add_comment = $this->blog_model->add_comment($_POST);
                $data['post'] = $this->blog_model->get_single_post($title);
                $data['comments'] = $this->blog_model->get_comments($data['post']['id']);
                $data['next_post'] = $this->blog_model->get_next_post($data['post']['id']);
                $data['prev_post'] = $this->blog_model->get_prev_post($data['post']['id']);
                $data['page'] = 'blog';
                $data['title'] = $data['post']['post_title'];
                $this->load->view('header', $data);
                $this->load->view('blog/view');
                $this->load->view('footer');
            }
        }
        else
        {
            header('location:'.base_url.'/index.php/blog/');
        }
    }

}