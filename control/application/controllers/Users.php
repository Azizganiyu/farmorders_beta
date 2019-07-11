<?php
/**
 * User Class
 * 
 * This class manages all users
 * 
 */
class Users extends CI_Controller
{
    /**
     * Logged in user ID
     * 
     * defined by the class constructor
     * 
     */
    protected $user_id;

    // ------------------------------------------------------------------------

    /**
     * Class constructor
     * 
     * Loads form_validation and the session library
     * Loads the form and the url helper
     * Loads the user model class for retrieving and setting user data
     * 
     * Sets the user ID
     * 
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->library('form_validation');
        $this->load->model('users_model');
        $this->load->library('session');
        $this->user_id = $this->session->id;
    }

    //---------------------------------------------------------------------------------

    /**
     * Class index
     * 
     * Displays user default page
     * 
     */
    public function index()
    {
        //if logged in user is an administrator view all registered users
        if(isset($this->session->role) && $this->session->role == "Administrator")
        {
            $this->view_all_users();
        }

        //if user is not an administrator view users profile
        else
        {
            $this->view_user();
        }
    }

    //-------------------------------------------------------------------------------------------

    /**
     * Login Method
     * 
     * Logs user in
     * 
     * sets user session
     * 
     */
    public function login()
    {
        //validate user input from the login form
        $this->form_validation->set_rules('id', 'username or Email', 'required|trim|htmlspecialchars', array(
            'required' => '%s is not provided'
        ));
        $this->form_validation->set_rules('password', 'Password', 'required|trim|htmlspecialchars', array(
            'required' => '%s is not provided'
        ));
        $this->form_validation->set_rules('redirect', 'Redirect', 'trim|htmlspecialchars');

        //if form validation error or input error, redisplay the login page with errors
        if($this->form_validation->run() == FALSE)
        {
            $data['title'] = "Login Page";
            $data['page'] = "login";
            $this->load->view('users/login', $data);
        }

        //if there is no error from form validation, send user input(provided login credential)  to user model class for validation or verification
        else
        {
            //send posted data to validate_user method in users_model,
            // returns user data if credentials match
            //or a boolean value of false if credentials doesnt match after verification
            $login_user = $this->users_model->validate_user($_POST);

            //if credentials provided match
            if($login_user)
            {
                //set session datas for for user
                $user_data = array(
                    'id' => $login_user['ID'],
                    'username' => $login_user['user_name'],
                    'displayname' => $login_user['display_name'],
                    'logged_in' => true,
                    'role' => $login_user['user_role']
                );
                $this->session->set_userdata($user_data);

                //redirect user to page that required the user must be logged in
                //redirect only if the redirect field was set
                //or redirect to dashboard after login
                if(!empty($this->input->post('redirect')))
                {
                    $url = $this->input->post('redirect');
                }
                else
                {
                    $url = base_url.'index.php/users';
                }
                header('location:'.$url);
            }

            //if the provided user credentials does not match, reload the login page with error notice
            else
            {
                $data['info'] = 'Wrong login details';
                $data['title'] = "Login Page";
                $data['page'] = "login";
                $this->load->view('users/login', $data);
            }
        }
    }

    //----------------------------------------------------------------------------------------

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
     * Method to logout user
     * 
     * sets session logged_in to false
     * 
     * 
     */
    public function logout()
    {
        //verify user is currently logged in before attempting to logout
        if($this->session->logged_in != true)
        {
            //if not logged in redirect to login page
            header('location:'.base_url.'index.php/users/login');
        }

        //set session data logged_in to false
        $this->session->set_userdata('logged_in', false);

        //redirect to login page after logout
        header('location:'.base_url.'index.php/users/login');
    }

    //-------------------------------------------------------------------------------------------

    /**
     * Method to add a new user
     * 
     * validates registration form and insert data into database
     * 
     * 
     */
    public function new_user()
    {
        //verify user is logged in
        if($this->session->logged_in != true)
        {
            $current_url = current_url();
            header('location:'.base_url.'index.php/users/login?re_direct='.$current_url);
        }

        //restrict page to only administrator
        $allowed = ['Administrator'];
        $this->allowed_user($allowed);

        //validate posted user data from registration form
        $this->form_validation->set_rules('first_name', 'First Name', 'trim|htmlspecialchars|max_length[20]', array(
            'regex_match' => '%s must be strictly alphabets'
        ));
        $this->form_validation->set_rules('last_name', 'Last Name', 'trim|htmlspecialchars|max_length[20]', array(
            'regex_match' => '%s must be strictly alphabets'
        ));
        $this->form_validation->set_rules('user_name', 'Username', 'required|trim|htmlspecialchars|max_length[20]|is_unique[users.user_name]', array(
            'is_unique' => '%s already exist!'
        ));
        $this->form_validation->set_rules('email', 'Email Address', 'trim|htmlspecialchars|is_unique[users.user_email]', array(
            'is_unique' => '%s already exist'
        ));
        $this->form_validation->set_rules('password', 'Password', 'required|trim|htmlspecialchars|min_length[8]', array(
            'required' => '%s is not provided'
        ));
        $this->form_validation->set_rules('cpassword', 'Confirm', 'trim|htmlspecialchars|matches[password]');

        //if form validation error, reload user registeration page
        if($this->form_validation->run() == FALSE)
        {
            $data['title'] = "Add New User";
            $data['page'] = "new_user";
            $this->load->view('template/header', $data);
            $this->load->view('users/new_user');
            $this->load->view('template/footer');
        }

        //else send form datas to method register_user in users model class for insertion into database
        else
        {
            //method returns a  boolean value if data was succesfully inserted to database
            $new_user = $this->users_model->register_user($_POST);

            //reload page with a success message if data was successfuy inserted
            if($new_user == True)
            {
                $data['info'] = 'User succesfully registered!';
                $data['title'] = "Add New User";
                $data['page'] = "new_user";
                $this->load->view('template/header', $data);
                $this->load->view('users/new_user');
                $this->load->view('template/footer');
            }

            //else reload page with error if not successfully inserted in database
            else
            {
                $data['info'] = 'Unable to register user at this moment, please try again later';
                $data['title'] = "Add New User";
                $data['page'] = "new_user";
                $this->load->view('template/header', $data);
                $this->load->view('users/new_user');
                $this->load->view('template/footer');
            }
        }
    }

    //----------------------------------------------------------------------------------------------

    /**
     * Method to view users profile
     * 
     * @param   int   $id initialised as a Null vaue
     * 
     * enable user to view and update their profile data
     */
    public function view_user($id = Null)
    {
        //verify user is logged in
        if($this->session->logged_in != true)
        {
            $current_url = current_url();
            header('location:'.base_url.'index.php/users/login?re_direct='.$current_url);
        }

        //set $id if not provided in parameter to currently logged in user id
        $id = isset($id)? $id : $this->session->id;

        //retrieve all user data from database with the ID provided
        //method get_user_data returns all user data from database all a boolean value of false
        $data = $this->users_model->get_user_data($id);

        //if user is not found load profile page with an account_error variable set
        if($data == False){
            $data['account_error'] = 'user not found';
            $data['page'] = "account";
            $data['title'] = "Profile";
            $this->load->view('template/header', $data);
            $this->load->view('users/profile');
            $this->load->view('template/footer');
        }

        //else display all nessesary user data
        else
        {
            //set page name and account owner based on whose profile you are viewing
            $data['id'] = $id;

            //if you are a viewing your own profile
            if($id == $this->session->id)
            {
                $data['page'] = "account";
                $data['account_owner'] = 'Your Account';
            }

            //if you are viewing another persons profile (Administrator)
            else
            {
                $data['page'] ="user_account";
                $data['account_owner'] = $data['user_name']."'s Account";
            }
            
            //validate user inputs when updating profile
            $this->form_validation->set_rules('image_url', 'Profile Image', 'trim|htmlspecialchars');
            $this->form_validation->set_rules('password', 'Password', 'trim|htmlspecialchars');
            $this->form_validation->set_rules('first_name', 'First Name', 'trim|htmlspecialchars|max_length[20]');
            $this->form_validation->set_rules('last_name', 'Last Name', 'trim|htmlspecialchars|max_length[20]');
            $this->form_validation->set_rules('display_name', 'Display Name', 'trim|htmlspecialchars|max_length[20]');
            $this->form_validation->set_rules('email', 'Email', 'trim|htmlspecialchars|callback_validate_change_email['.$id.']');
            $this->form_validation->set_rules('phone', 'Phone Number', 'trim|htmlspecialchars|max_length[20]|numeric');
            $this->form_validation->set_rules('state', 'State', 'trim|htmlspecialchars');
            $this->form_validation->set_rules('city', 'City', 'trim|htmlspecialchars');
            $this->form_validation->set_rules('home', 'Home', 'trim|htmlspecialchars');

            //only validate postal code if the field is not empty
            if(!empty($this->input->post('postal_code')))
            {
                $this->form_validation->set_rules('postal_code', 'Postal Code', 'callback_validate_postal_code['.$this->input->post('country_code').']');
            }

            $this->form_validation->set_rules('website', 'Website', 'trim|htmlspecialchars');

            //if validation error reload page and display error
            if($this->form_validation->run() == False)
            {
                //set data['info'] only if the user try to update and there was error
                if(isset($_POST['submit']))
                {
                    $data['info'] = 'Update Error! <br> Please check fields for corrections';
                }

                $data['title'] = "Profile";
                $this->load->view('template/header', $data);
                $this->load->view('users/profile');
                $this->load->view('template/footer');
            }

            //else update user records on the database
            else
            {
                //update_user method returns a boolean value
                $update_user = $this->users_model->update_user($_POST, $id); 

                //if record is updated get the latest update and dispay to user
                if ($update_user != False)
                {
                    //update $data with new database data
                    $data_update = $this->users_model->get_user_data($id);
                    $data = array_merge($data, $data_update); //merge with old to update data
                    $data['info'] = 'Updated successfully!';
                    $data['title'] = "Profile";
                    $this->load->view('template/header', $data);
                    $this->load->view('users/profile');
                    $this->load->view('template/footer');
                }
            }
        }
    }

    //----------------------------------------------------------------------------------------------------

    /**
     * Method to validate user postal code
     * 
     * @param   string   $str user input postal code
     * @param   string   $country_code user country_code
     * 
     * validates postal code based on user country
     */
    public function validate_postal_code($str, $country_code)
    {
        //load the custom postal code validator library
        $this->load->library('Postal_code_validator');

        //verify postal code with user country using the method "isValid" from the library, returns a boolean value
        $validate = $this->postal_code_validator->isValid($country_code, $str);

        //if postal code does not match country, set error message for form_validation and return false
        if($validate == false)
        {
            $this->form_validation->set_message('validate_postal_code', 'Incorrect Postal Code');
            return false;
        }
        else
        {
            return true;
        }
    }

    //-----------------------------------------------------------------------------------------------------

    /**
     * Method to validate change of email
     * 
     * @param   string   $email new email
     * @param   id   $id user id
     * 
     * enable user to view and update their profile data
     */
    public function validate_change_email($email, $id)
    {
        //verify no other user is using the email
        $verify_email_change = $this->users_model->validate_change_email($email, $id);

        //if the email exist somewhere else, set error message for form_validation and return false
        if($verify_email_change == false)
        {
            $this->form_validation->set_message('validate_change_email', 'Email already exists');
            return false;
        }
        else
        {
            return true;
        }
    }

    //-----------------------------------------------------------------------------------------------------

    /**
     * Method to view all users
     * 
     * display all users with pagination feature
     * 
     * enable view user based on search key
     */
    public function view_all_users()
    {
        //veify user is logged in
        if($this->session->logged_in != true)
        {
            $current_url = current_url();
            header('location:'.base_url.'index.php/users/login?re_direct='.$current_url);
        }

        //restrict page to only administrators
        $allowed = ['Administrator'];
        $this->allowed_user($allowed);

        //validate search key if set
        $this->form_validation->set_rules('search_key','Search', 'trim|htmlspecialchars');

        //load the pagination library class
        $this->load->library("pagination");

        //configure the pagination
        $config = array();
        $config['base_url'] = base_url.'index.php/users/view_all_users';  //set the base url
        $config['total_rows'] = $this->users_model->count_users($this->input->post('search_key'));  //get total number of registered users
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

        //get all users in database or users based on a search key(if set)
        $data['users'] = $this->users_model->get_all_users($config['per_page'], $page, $this->input->post('search_key'));

        //re populate search field with sent query key
        $data['search_key'] = $this->input->post('search_key');

        //variable to hold pagination links
        $data['links'] = $this->pagination->create_links();

        //display page to user
        $data['page'] = "all_users";
        $data['title'] = "All Users";
        $this->load->view('template/header', $data);
        $this->load->view('users/all_users');
        $this->load->view('template/footer');
    }

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Method to delete user(s)
     * 
     * @param   id   $id user initialized to Null
     * 
     * enables Administrator delete user(s) from record
     */
    public function delete_users($id = null)
    {
        //verify user is logged in
        if($this->session->logged_in != true)
        {
            header('location:'.base_url.'index.php/users/login');
        }

        //execute this only if id is set in the argument param
        if(isset($id))
        {
            //remove user from record
            $delete = $this->users_model->delete_users($id);

            //if user is successfuy removed  reload page
            if($delete == true)
            {
                header('location:'.base_url.'index.php/users/view_all_users');
            }
            else 
            {
                echo "Something went wrong!";
            }
        }

        //else if id is not set check if user(s) id is posted for deletion
        elseif(count($this->input->post('item_delete')) > 0)
        {
            //if user(s) id is posted instead, delete from record the user(s)
            $delete = $this->users_model->delete_users($this->input->post('item_delete'));

            //if user is successfuy removed  reload page
            if($delete == true)
            {
                header('location:'.base_url.'index.php/users/view_all_users');
            }
            else 
            {
                echo "Something went wrong!";
            }
        }

        //else if user id is not set and user id(s) are not posted reload page
        else
        {
            header('location:'.base_url.'index.php/users/view_all_users');
        }
    }

    //---------------------------------------------------------------------------------------------

}