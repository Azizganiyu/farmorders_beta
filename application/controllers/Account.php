<?php

class Account extends CI_Controller
{
    public $profile;
    public $orders;
    public $invoice;
    public $reviews;
    public $orders_count;
    public $invoice_count;
    public $reviews_count;

    public function __construct()
    {
        parent::__construct();
        $this->load->library(array('form_validation','session'));
        $this->load->model('account_model');
        $this->load->helper(array('form','url','check'));
        if(!$this->session->logged_in || $this->session->logged_in == false)
        {
            header('location:'.base_url.'/index.php/home');
        }
        $this->profile = $this->account_model->get_user_details($this->session->id);
        $this->orders = $this->account_model->get_orders($this->session->id);
        $this->invoice = $this->account_model->get_invoice($this->session->id);
        $this->reviews = $this->account_model->get_reviews($this->profile['user_email']);
        $this->orders_count = $this->account_model->count_orders($this->session->id);
        $this->invoice_count = $this->account_model->count_invoice($this->session->id);
        $this->reviews_count = $this->account_model->count_reviews($this->profile['user_email']);
    }

    public function index()
    {
        $data['username'] = $this->profile['user_name'];
        $data['orders_count'] = $this->orders_count;
        $data['invoice_count'] = $this->invoice_count;
        $data['reviews_count'] = $this->reviews_count;
        $data['page'] = 'account';
        $data['title'] = site_title.' | Your account';
        $this->load->view('header', $data);
        $this->load->view('account/account');
        $this->load->view('footer');
    }

    public function reviews()
    {
        $data['page'] = 'reviews';
        $data['title'] = site_title.' | Reviews';
        $data['reviews'] = $this->reviews;
        $this->load->view('header', $data);
        $this->load->view('account/reviews');
        $this->load->view('footer');

    }

    public function del_review($id)
    {
        $this->db->delete('product_reviews', array('id' => $id));
        header('location:'.base_url.'/index.php/account/reviews');
    }

    public function invoice()
    {
        $data['page'] = 'invoice';
        $data['title'] = site_title.' | Invoice';
        $data['invoices'] = $this->invoice;
        $this->load->view('header', $data);
        $this->load->view('account/invoice');
        $this->load->view('footer');
    }

    public function orders()
    {
        $data['page'] = 'orders';
        $data['title'] = site_title.' | Orders';
        $data['orders'] = $this->orders;
        $this->load->view('header', $data);
        $this->load->view('account/orders');
        $this->load->view('footer');
    }

    public function profile()
    {
        $data = $this->profile;

        //validate user inputs when updating profile
        $this->form_validation->set_rules('first_name', 'First Name', 'required|trim|htmlspecialchars|max_length[20]');
        $this->form_validation->set_rules('last_name', 'Last Name', 'required|trim|htmlspecialchars|max_length[20]');
        $this->form_validation->set_rules('display_name', 'Display Name', 'required|trim|htmlspecialchars|max_length[20]');
        $this->form_validation->set_rules('email', 'Email', 'required|trim|htmlspecialchars|callback_validate_change_email['.$this->session->id.']');
        $this->form_validation->set_rules('phone', 'Phone Number', 'required|trim|htmlspecialchars|max_length[20]|numeric');
        $this->form_validation->set_rules('state', 'State', 'required|trim|htmlspecialchars');
        $this->form_validation->set_rules('city', 'City', 'required|trim|htmlspecialchars');
        $this->form_validation->set_rules('home', 'Home', 'required|trim|htmlspecialchars');
        $this->form_validation->set_rules('postal_code', 'Postal Code', 'required|callback_validate_postal_code['.$this->input->post('country_code').']');
        if(!empty($this->input->post('old_password')))
        {
            $this->form_validation->set_rules('old_password', 'Old Password', 'trim|htmlspecialchars|callback_validate_old_password['.$this->session->id.']');
        }
        $this->form_validation->set_rules('password', 'Password', 'trim|htmlspecialchars|min_length[8]');

        //if validation error reload page and display error
        if($this->form_validation->run() == False)
        {
            //set data['info'] only if the user try to update and there was error
            if(isset($_POST['submit']))
            {
                $data['info'] = 'Update Error! <br> Please check fields for corrections';
            }

            $data['page'] = 'profile';
            $data['title'] = site_title.' | Profile';
            $this->load->view('header', $data);
            $this->load->view('account/profile');
            $this->load->view('footer');
        }

        //else update user records on the database
        else
        {
            //update_user method returns a boolean value
            $update_user = $this->account_model->update_user($_POST, $this->session->id); 

            //if record is updated get the latest update and dispay to user
            if ($update_user != False)
            {
                //update $data with new database data
                $data_update = $this->account_model->get_user_details($this->session->id);
                $data = array_merge($data, $data_update); //merge with old to update data
                $data['page'] = 'profil';
                $data['info'] = 'Updated successfully!';
                $data['title'] = site_title.' | Profile';
                $this->load->view('header', $data);
                $this->load->view('account/profile');
                $this->load->view('footer');
            }
        
        }
    }

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

    public function validate_old_password($str, $id)
    {
        //verify old password in user database
        $validate = $this->account_model->verify_password($str, $id);

        //if password does not match, set error message for form_validation and return false
        if($validate == false)
        {
            $this->form_validation->set_message('validate_old_password', 'Wrong old password');
            return false;
        }
        else
        {
            return true;
        }
    }
}
