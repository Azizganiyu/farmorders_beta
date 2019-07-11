<?php

/**
 * Blogging Class
 */
class Blog extends CI_Controller
{
    /**
     * construct method
     * loads the form and url helper
     * loads the form validation and session library
     * loads the blog model class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->helper(array('form', 'url'));
        $this->load->library(array('form_validation','session'));
        $this->load->model('blog_model');

        //verify user is logged in
        if($this->session->logged_in != true)
        {
            $current_url = current_url();
            header('location:'.base_url.'index.php/users/login?re_direct='.$current_url);
        }
    }

    //--------------------------------------------------------------------------------

    /**
     * Index method
     * calls the view_all_post method to display all posts
     */
    public function index()
    {
        $this->view_all_posts();
    }

    //---------------------------------------------------------------------------------

    /**
     * Method to limit user page access by roles
     * 
     * @param   array   $array of allowed roles
     * 
     * 
     */
    public function allowed_user($array)
    {
        //checks if logged in user role is is in $array
        if(!in_array($this->session->role, $array))
        {
            //if not in array show a page_restrict page instead
            $this->load->view('users/page_restrict');
        }
    }

    //----------------------------------------------------------------------------------

    /**
     * Category method
     * creates and views all category
     */
    public function category()
    {
        $data['title'] = 'Category';
        $data['page'] = 'category';
        $data['categories'] = $this->blog_model->get_category(); //retrieves all category(ies) from database

        //category form validation
        $this->form_validation->set_rules('cat_name', 'Category Name', 'required|trim|htmlspecialchars|is_unique[post_category.cat_name]', array(
            'required' => '%s is not provided!',
            'is_unique' => '%s Already Exist!'
        ));
        $this->form_validation->set_rules('cat_desc', 'Category Description', 'trim|htmlspecialchars');
        $this->form_validation->set_rules('search_key','Search', 'trim|htmlspecialchars');

        //if error in form validation
        if($this->form_validation->run() == FALSE)
        {
            //set form info to display error message only if the submit button was clicked
            if(isset($_POST['submit']))
            {
                $data['info'] = 'An Error occured!';
            }

            //display page
            $this->load->view('template/header',$data);
            $this->load->view('blog/category');
            $this->load->view('template/footer');
        }
        else //if no error encountered
        {
            
            $store = $this->blog_model->add_category($_POST); //send new category data to database method (model), returns boolean value
            
            //if data was successfully stored update $data['categories'] and display
            if($store == true)
            {
                $data['categories'] = $this->blog_model->get_category();
                $data['info'] = 'Category has been successfully added!';
                $this->load->view('template/header',$data);
                $this->load->view('blog/category');
                $this->load->view('template/footer');
            }
        }
    }

    //-----------------------------------------------------------------------------------------------------------

    /**
     * Method to delete category
     * deletes single or multiple category from database
     * receives an argument or a post data
     * @param int $id of category, default = null
     */
    public function delete_category($id = null)
    {
        //execute this only if id is set in the argument param
        if(isset($id))
        {
            //remove category from record
            $delete = $this->blog_model->delete_category($id);

            //if category is successfuy removed  reload page
            if($delete == true)
            {
                header('location:'.base_url.'index.php/blog/category');
            }
            else 
            {
                echo "Something went wrong!";
            }
        }

        //else if id is not set check if category id is posted for deletion
        elseif(count($this->input->post('category_delete')) > 0)
        {
            //if category id is posted instead, delete from record the category
            $delete = $this->blog_model->delete_category($this->input->post('category_delete'));

            //if category is successfully removed  reload page
            if($delete == true)
            {
                header('location:'.base_url.'index.php/blog/category');
            }
            else 
            {
                echo "Something went wrong!";
            }
        }

        //else if category id is not set and category id(s) are not posted reload page
        else
        {
            header('location:'.base_url.'index.php/blog/category');
        }
    }

    //----------------------------------------------------------------------------------------------------

    /**
     * Method to edit category
     * @param int $id of category, default null
     */
    public function edit_category($id = null)
    { 
        //check if id is set
        if(isset($id))
        {
            $data['category'] = $this->blog_model->get_category($id); //get data of category
            $data['categories'] = $this->blog_model->get_category(); //get all categories from database (for parent purpose)

            //if  category id desn't exist
            if($data['category'] == false)
            {
                $data['category_error'] = 'Category does not exist'; //set category_error variable
                
            }

            //validate form on category update
            $this->form_validation->set_rules('cat_name', 'Category Name', 'required|trim|htmlspecialchars|callback_validate_change_cat_name['.$id.']', array(
                'required' => '%s is not provided!'
            ));
            $this->form_validation->set_rules('cat_desc', 'Category Description', 'trim|htmlspecialchars');

            //if form is not successfully validated
            if($this->form_validation->run() == FALSE)
            {
                if(isset($_POST['submit']))
                {
                    $data['info'] = 'An Error occured!';
                }
                $data['cat_parent'] = $this->blog_model->get_category($data['category']['parent_id']); //get category parent
                $data['title'] = 'Edit Category';
                $data['page'] = 'category';
                $this->load->view('template/header',$data);
                $this->load->view('blog/edit_category');
                $this->load->view('template/footer');
            }
            else
            {
                $update = $this->blog_model->update_category($id, $_POST);
                if($update == true)
                {
                    $data['category'] = $this->blog_model->get_category($id);
                    $data['cat_parent'] = $this->blog_model->get_category($data['category']['parent_id']);
                    $data['title'] = 'Edit Category';
                    $data['page'] = 'category';
                    $data['info'] = 'Category has been successfully updated!';
                    $this->load->view('template/header',$data);
                    $this->load->view('blog/edit_category');
                    $this->load->view('template/footer');
                }
                else
                {
                    $data['category'] = $this->blog_model->get_category($id);
                    $data['cat_parent'] = $this->blog_model->get_category($data['category']['parent_id']);
                    $data['title'] = 'Edit Category';
                    $data['page'] = 'category';
                    $data['info'] = 'You have made no changes!';
                    $this->load->view('template/header',$data);
                    $this->load->view('blog/edit_category');
                    $this->load->view('template/footer');
                }
            }
        }
        else
        {
            header('location:'.base_url.'index.php/blog/category');
        }
    }

    //----------------------------------------------------------------------------------------------------

    /**
     * Method to validate change of category name
     * checks if no other category uses the name
     * @param string $cat_name -category name to be changed to
     * @param int $id category id
     */
    public function validate_change_cat_name($cat_name, $id)
    {
        //verify no other category is using the name
        $verify_cat_name_change = $this->blog_model->validate_change_cat_name($cat_name, $id);

        //if the name exist somewhere else, set error message for form_validation and return false
        if($verify_cat_name_change == false)
        {
            $this->form_validation->set_message('validate_change_cat_name', 'Category name already exists');
            return false;
        }
        else
        {
            return true;
        }
    }

    //-------------------------------------------------------------------------------------------------

    /**
     * Method to create new post
     * 
     */
    public function new_post()
    {
        $data['title'] = 'New Post';
        $data['page'] = 'new_post';
        $data['categories'] = $this->blog_model->get_category();

        $this->form_validation->set_rules('post_title', 'Post Title', 'required|trim|htmlspecialchars|is_unique[post.post_title]', array(
            'required' => '%s is not provided!',
            'is_unique' => '%s Already Exist!'
        ));
        //$this->form_validation->set_rules('post_content', 'Post Content', 'htmlspecialchars');
        $this->form_validation->set_rules('tags', 'Tags', 'trim|htmlspecialchars');


        if($this->form_validation->run() == FALSE)
        {
            if(isset($_POST['submit']))
            {
                $data['info'] = 'An Error occured! Please review fields';
            }
            $this->load->view('template/header',$data);
            $this->load->view('blog/new_post');
            $this->load->view('template/footer');
        }
        else
        {
            
            $store = $this->blog_model->new_post($_POST);
            if($store == true)
            {
                $data['info'] = 'Post has been successfully published!';
                $this->load->view('template/header',$data);
                $this->load->view('blog/new_post');
                $this->load->view('template/footer');
            }
            else
            {
                echo 'Something went wrong';
            }
        }
    }

    //------------------------------------------------------------------------------

    /**
     * Method to view all post
     */
    public function view_all_posts()
    {

        //validate search key if set
        $this->form_validation->set_rules('search_key','Search', 'trim|htmlspecialchars');

        //load the pagination library class
        $this->load->library("pagination");

        //configure the pagination
        $config = array();
        $config['base_url'] = base_url.'index.php/blog/view_all_posts';  //set the base url
        $config['total_rows'] = $this->blog_model->count_posts($this->input->post('search_key'));  //get total number of registered users
        $config["per_page"] = 18; //display number of users per page
        $config['uri_segment'] = 3; //uri segment to be used for pagination(parameter)
        $choice = $config['total_rows'] / $config['per_page'];
        $config['num_links'] = round($choice); //number of pagination links to display
        $config['full_tag_open'] = '<div class="pagination_body col-12">';
        $config['full_tag_close'] = '</div>';
        $config['next_tag_open'] = '<span class="next_link">';
        $config['next_link'] = 'Next';
        $config['next_tag_close'] = '</span>';
        $config['prev_tag_open'] = '<span class="prev_link">';
        $config['prev_link'] = 'Prev';
        $config['prev_tag_close'] = '</span>';
        $config['num_tag_open'] = '<span class="pagination_links">';
        $config['num_tag_close'] = '</span>';
        $config['cur_tag_open'] = '<span class="curr_pagination_link">';
        $config['cur_tag_close'] = '</span>';
        $this->pagination->initialize($config);

        $page = ($this->uri->segment(3))? $this->uri->segment(3) : 0; //set current page to uri segment(3) if exist or initialize to 0

        //get all posts in database or posts based on a search key(if set)
        $data['posts'] = $this->blog_model->get_all_posts($config['per_page'], $page, $this->input->post('search_key'));

        //re populate search field with sent query key
        $data['search_key'] = $this->input->post('search_key');

        //variable to hold pagination links
        $data['links'] = $this->pagination->create_links();

        //display page to user
        $data['page'] = "all_posts";
        $data['title'] = "All Posts";
        $this->load->view('template/header', $data);
        $this->load->view('blog/all_posts');
        $this->load->view('template/footer');
    }

    //---------------------------------------------------------------------------
    /**
     * Method to delete post(s)
     * @param $id of post, default = null
     */
    public function delete_posts($id = null)
    {
        //execute this only if id is set in the argument param
        if(isset($id))
        {
            //remove user from record
            $delete = $this->blog_model->delete_posts($id);

            //if user is successfuy removed  reload page
            if($delete == true)
            {
                header('location:'.base_url.'index.php/blog/view_all_posts');
            }
            else 
            {
                echo "Something went wrong!";
            }
        }

        //else if id is not set check if post(s) id is posted for deletion
        elseif(count($this->input->post('item_delete')) > 0)
        {
            //if post(s) id is posted instead, delete from record the post(s)
            $delete = $this->blog_model->delete_posts($this->input->post('item_delete'));

            //if post(s) is successfuy removed  reload page
            if($delete == true)
            {
                header('location:'.base_url.'index.php/blog/view_all_posts');
            }
            else 
            {
                echo "Something went wrong!";
            }
        }

        //else if post id is not set and post id(s) are not posted reload page
        else
        {
            header('location:'.base_url.'index.php/blog/view_all_posts');
        }
    }

    //-------------------------------------------------------------------------------------

    /**
     * Method to edit post
     * @param int id, default = null
     */
    public function edit_post($id = null)
    {
        if(isset($id))
        {
            $data['post'] = $this->blog_model->get_post($id); // get post data
            $data['categories'] = $this->blog_model->get_category(); //get all categories for post change of category
            
            //if post data not found set post_error variable
            if($data['post'] == false)
            {
                $data['post_error'] = 'Post does not exist';
                
            }

            //validate post data
            $this->form_validation->set_rules('post_title', 'Post Title', 'required|trim|htmlspecialchars|callback_validate_change_post_title['.$id.']', array(
                'required' => '%s is not provided!'
            ));
            //$this->form_validation->set_rules('post_content', 'Post Content', 'trim|htmlspecialchars');
            $this->form_validation->set_rules('tags', 'Tags', 'trim|htmlspecialchars');

            //if form validation fail
            if($this->form_validation->run() == FALSE)
            {
                if(isset($_POST['submit']))
                {
                    $data['info'] = 'An Error occured!';
                }
                $data['title'] = 'Edit Post';
                $data['page'] = 'all_posts';
                $this->load->view('template/header',$data);
                $this->load->view('blog/edit_post');
                $this->load->view('template/footer');
            }
            else
            {
                $update = $this->blog_model->update_post($id, $_POST);
                if($update == true)
                {
                    $data['post'] = $this->blog_model->get_post($id);
                    $data['title'] = 'Edit Post';
                    $data['page'] = 'all_posts';
                    $data['info'] = 'Post has been successfully updated!';
                    $this->load->view('template/header',$data);
                    $this->load->view('blog/edit_post');
                    $this->load->view('template/footer');
                }
                else
                {
                    $data['post'] = $this->blog_model->get_post($id);
                    $data['title'] = 'Edit Post';
                    $data['page'] = 'all_posts';
                    $data['info'] = 'You have made no changes!';
                    $this->load->view('template/header',$data);
                    $this->load->view('blog/edit_post');
                    $this->load->view('template/footer');
                }
            }
        }
        else
        {
            header('location:'.base_url.'index.php/blog/view_all_posts');
        }
    }

    //--------------------------------------------------------------------------------

    /**
     * Method to validate change of post title
     */
    public function validate_change_post_title($post_title, $id)
    {
        //verify no other post is using the title
        $verify_post_title_change = $this->blog_model->validate_change_post_title($post_title, $id);

        //if the title exist somewhere else, set error message for form_validation and return false
        if($verify_post_title_change == false)
        {
            $this->form_validation->set_message('validate_change_post_title', 'Post title already exists');
            return false;
        }
        else
        {
            return true;
        }
    }
}