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
     * Loads the nessesary model class for retrieving and setting user data
     * 
     * Sets the user ID
     * 
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->helper(array('form','url'));
        $this->load->library(array('form_validation','session'));
        $this->load->model(array('users_model','store_model'));
        $this->user_id = $this->session->id;
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

        //if form validation error or input error, redisplay the login page with errors
        if($this->form_validation->run() == FALSE)
        {
            echo validation_errors();
        }

        //if there is no error from form validation, send user input(provided login credential)  to user model class for validation or verification
        else
        {
            //send posted data to validate_user method in users_model,
            // returns user data if credentials match
            //or a boolean value of false if credentials doesnt match after verification
            $login_user = $this->users_model->validate_user($_POST);

            //if credentials provided match
            if(is_array($login_user))
            {
                //set session datas for for user
                $user_data = array(
                    'id' => $login_user['ID'],
                    'logged_in' => true
                );
                $this->session->set_userdata($user_data);

                //if user wants to be remembered next time
                if($this->input->post('remember') == 'yes')
                {
                    $token = bin2hex(random_bytes(64));
                    $this->users_model->set_token($login_user['ID'], $token);
                    setcookie('login_tokens', $token, time() + (10 * 365 * 24 * 60 * 60), "/");
                }

                setcookie('logged_in', 'true', 0, "/");


                foreach($_SESSION['cart'] as $product_id => $details)
                {
                    if($this->store_model->cart_id_exist($product_id, $login_user['ID']) == false)
                    {
                        $this->store_model->cart($product_id, $details, '1');
                    }
                    else
                    {
                        $this->store_model->update_cart($this->session->id, $product_id, $details['quantity']);
                    }
                }

                $db_cart = $this->store_model->get_my_cart($login_user['ID']);
                if($db_cart != false)
                {
                    foreach($db_cart as $cart_item)
                    {
                        $_SESSION['cart'][$cart_item['product_id']] = array(
                            'price' => $cart_item['price'], 'quantity' => $cart_item['quantity']
                        );
                    }
                }
                echo "Success";
            }
            elseif($login_user == 'unconfirmed')
            {
                echo  'Please validate this account';
            }
            //if the provided user credentials does not match, reload the login page with error notice
            else
            {
                echo  'Wrong login details';
            }
        }
    }

    //----------------------------------------------------------------------------------------

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
           echo "sorry you are currently not logged in!";
        }
        else
        {
            //set session data logged_in to false
            $this->session->set_userdata('logged_in', false);
            setcookie('logged_in', 'false', time() - 86400, "/");

            //if user wants to be logged out from every device
            if($this->input->post('od_logout') == 'yes')
            {
                $this->users_model->remove_all_token($this->session->id);
            }

            if(isset($_COOKIE['login_tokens']))
            {
                $this->users_model->remove_token($_COOKIE['login_tokens']);
                setcookie('login_tokens', 'false', time() - 86400, "/");
            }
            echo "Success";
        }
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
        $this->form_validation->set_rules('username', 'Username', 'required|trim|htmlspecialchars|max_length[20]|is_unique[users.user_name]', array(
            'is_unique' => '%s already exist!'
        ));
        $this->form_validation->set_rules('email', 'Email Address', 'required|trim|htmlspecialchars|is_unique[users.user_email]', array(
            'is_unique' => '%s already exist'
        ));
        $this->form_validation->set_rules('password', 'Password', 'required|trim|htmlspecialchars|min_length[8]', array(
            'required' => '%s is not provided'
        ));

        //if form validation error, reload user registeration page
        if($this->form_validation->run() == FALSE)
        {
            echo validation_errors();
        }

        //else send form datas to method register_user in users model class for insertion into database
        else
        {
            //method returns a  boolean value if data was succesfully inserted to database
            $new_user = $this->users_model->register_user($_POST);

            //reload page with a success message if data was successfuy inserted
            if($new_user == True)
            {
                echo 'Success';
            }

            //else reload page with error if not successfully inserted in database
            else
            {
                echo 'Unable to register user at this moment, please try again later';
            }
        }
    }

    //---------------------------------------------------------------------------------------------

}