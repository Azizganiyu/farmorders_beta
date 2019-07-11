<?php
/**
 * Store Class
 * 
 * This class handles all store functions
 * 
 */
class Store extends CI_Controller
{
    /**
     * Class constructor
     * 
     * Loads form_validation and the session library
     * Loads the form and the url helper
     * Loads the store model class for retrieving and setting user data
     * 
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->library(array('form_validation','session'));
        $this->load->model(array('store_model','users_model'));
        $this->load->helper(array('form','url','check'));
        //session_destroy();
    }

    //---------------------------------------------------------------------------------

    /**
     *index method
     * 
     * Displays product page by calling the products() method
     * 
     */
    public function index()
    {
        $this->products();
    }

    //---------------------------------------------------------------------------------

    /**
     * products method
     * 
     * This method loads the store products page
     * 
     */
    public function products($category = 'all')
    {
        $this->load->library('pagination');

        //configure the pagination
        $data['category'] = $category;
        $config = array();
        $config['base_url'] = base_url.'/index.php/store/products/'.$category;  //set the base url
        $config['total_rows'] = $this->store_model->count_products($this->input->post('search_key'), $category);  //get total number of registered users
        $config["per_page"] = 8; //display number of products per page
        $config['uri_segment'] = 4; //uri segment to be used for pagination(parameter)
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

        $page = ($this->uri->segment(4))? $this->uri->segment(4) : 0; //set current page to uri segment(4) if exist or initialize to 0
        $data['links'] = $this->pagination->create_links();
        $data['products'] = $this->store_model->get_all_products($config["per_page"], $page, $this->input->post('search_key'), $category); //get all the products from   database

        $data['search_key'] = $this->input->post('search_key');


        $data['page'] = 'store';
        $data['title'] = 'store | '.site_title;
        if(!empty($data['search_key']))
        {
            $data['item_title'] = 'Search result for "'.$data['search_key'].'"';
        }
        elseif($category != 'all')
        {
            $data['item_title'] = 'Category : '.$category;
        }
        else
        {
            $data['item_title'] = 'Featured Items';
        }
        //send all the data to page and load the page
        $this->load->view('header', $data);
        $this->load->view('store/products');
        $this->load->view('footer');
    }


     //-------------------------------------------------------------------------------------------------------------

    /**
     * cart method
     * 
     * This method adds or remove product in cart session and cart database
     *
     */
    public function cart()
    {
        $id = $this->input->post('id'); //get the id of the posted product
        $status = $this->input->post('status'); //get the status of the posted product
        $price = $this->input->post('price'); //get the id of the posted product
        $qty = $this->input->post('quantity'); //get the status of the posted product
        $details = array('price'=>$price, 'quantity'=>$qty);
        //check if session exist, or create one
        if(!isset($_SESSION['cart']))
		{
            $_SESSION['cart'] = [];
        }

        //add or remove products in cart based on the status 0-remove 1-add
        if($status == '1')
        {
            $_SESSION['cart'][$id] = array(
                'price' => $price, 'quantity' => $qty
            );
            
        }
        elseif($status == '0')
        {
            unset($_SESSION['cart'][$id]);
        }

        //store in database only if user is currently logged in
        if($this->session->logged_in == true)
        {
            //avoid dupplication of product
            $this->form_validation->set_rules('id', 'ID', 'is_unique[cart.product_id]');
            if($this->form_validation->run() != FALSE || $status == '0')
            {
                $this->store_model->cart($id, $details, $status);
            }
            
        }
        header('location:'.base_url.'/index.php/store/view_cart');
    }

    public function view_cart()
    {
        $data['cart_items'] = $this->store_model->get_cart($_SESSION['cart']);
        $data['page'] = 'cart';
        $data['title'] = 'cart | '.site_title;
        $this->load->view('header', $data);
        $this->load->view('store/cart');
        $this->load->view('footer'); 
    }


    public function view_product($name)
    {
        $categories = $this->store_model->get_all_categories(); //get all categories from database
        
        $product_name = str_replace('_', " ", $name);
        $data['item'] = $this->store_model->get_product($product_name);

        $this->load->library('pagination');

        //configure the pagination for reviews
        $config = array();
        $config['base_url'] = base_url.'/index.php/store/'.$name;  //set the base url
        $config['total_rows'] = $this->store_model->count_reviews($data['item']['id']);  //get total number of registered users
        $config["per_page"] = 5; //display number of products per page
        $config['uri_segment'] = 4; //uri segment to be used for pagination(parameter)
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

        $page = ($this->uri->segment(4))? $this->uri->segment(4) : 0; //set current page to uri segment(4) if exist or initialize to 0
        $data['links'] = $this->pagination->create_links();
        $data['reviews'] = $this->store_model->get_reviews($config["per_page"], $page, $data['item']['id']);


        $data['page'] = 'detail';
        $data['title'] = $product_name.' | '.site_title;
        $this->load->view('header', $data);
        $this->load->view('store/detail');
        $this->load->view('footer'); 
    }

    public function reviews()
    {
        $this->form_validation->set_rules('name', 'Name', 'required|trim|htmlspecialchars|max_length[20]');
        $this->form_validation->set_rules('email', 'Email Address', 'required|trim|htmlspecialchars');
        $this->form_validation->set_rules('comment', 'Comment', 'required|trim|htmlspecialchars');

        //if form validation error, reload user registeration page
        if($this->form_validation->run() == FALSE)
        {
            echo validation_errors();
        }

        //else send form datas to method register_user in users model class for insertion into database
        else
        {
            //method returns a  boolean value if data was succesfully inserted to database
            $reviews = $this->store_model->add_reviews($_POST);
            //$reviews = True;
            //reload page with a success message if data was successfuy inserted
            if($reviews == True)
            {
                echo 'Thanks for your review!';
            }

            //else reload page with error if not successfully inserted in database
            else
            {
                echo 'Unable to register user at this moment, please try again later';
            }
        }
    }

    public function checkout()
    {
        
        //set $id if not provided in parameter to currently logged in user id
        $id = NULL;
        if($this->session->logged_in)
        {
            $id = $this->session->id;
        }
        else
        {
           $id = FALSE;
        }

        //retrieve all user data from database with the ID provided
        //method get_user_data returns all user data from database all a boolean value of false
        $data = $this->users_model->get_user_data($id);
          
        $data['cart_items'] = $this->store_model->get_cart($_SESSION['cart']);

        //validate user inputs when updating profile
        $this->form_validation->set_rules('first_name', 'First Name', 'required|trim|htmlspecialchars|max_length[20]');
        $this->form_validation->set_rules('last_name', 'Last Name', 'required|trim|htmlspecialchars|max_length[20]');
        $this->form_validation->set_rules('display_name', 'Display Name', 'required|trim|htmlspecialchars|max_length[20]');
        $this->form_validation->set_rules('email', 'Email', 'required|trim|htmlspecialchars|callback_validate_change_email['.$id.']');
        $this->form_validation->set_rules('phone', 'Phone Number', 'required|trim|htmlspecialchars|max_length[20]|numeric');
        $this->form_validation->set_rules('state', 'State', 'required|trim|htmlspecialchars');
        $this->form_validation->set_rules('city', 'City', 'required|trim|htmlspecialchars');
        $this->form_validation->set_rules('home', 'Home', 'required|trim|htmlspecialchars');
        $this->form_validation->set_rules('postal_code', 'Postal Code', 'required|callback_validate_postal_code['.$this->input->post('country_code').']');
        $this->form_validation->set_rules('payment', 'Payment Mode', 'required');
        $this->form_validation->set_rules('description', 'Order description', 'trim|htmlspecialchars');
        

        //if validation error reload page and display error
        if($this->form_validation->run() == False)
        {
            //set data['info'] only if the user try to update and there was error
            if(isset($_POST['submit']))
            {
                $data['info'] = 'Update Error! <br> Please check fields for corrections';
            }

            $data['page'] = 'checkout';
            $data['title'] = 'checkout | '.site_title;
            $this->load->view('header', $data);
            if($id == FALSE)
            {
                $this->load->view('store/login_error');
            }
            elseif(count($this->session->cart)  == 0)
            {
                $this->load->view('store/cart_empty_error');
            }
            else
            {
                $this->load->view('store/checkout');
            }
            $this->load->view('footer');
        }
        //else Place order and generate invoice
        else
        {
            $items = $data['cart_items'];
            if($items != false)
            {
                $total_order_price = 0;
                $item_list = '';
                $invoice_code = strtoupper(substr(uniqid(), 6)).rand(100, 999);
                $order_codes = '';
                foreach($items as $cart_products)
                {
                    

                    $data = array(
                        'user_id' => $this->session->id,
                        'product_id' => $cart_products['id'],
                        'order_code' => strtoupper(substr(uniqid(), 6)).rand(100, 999),
                        'attached_invoice' => $invoice_code,
                        'username' => $this->input->post('user_name'),
                        'item_name' => $cart_products['product_name'],
                        'qty' => $this->session->cart[$cart_products['id']]['quantity'],
                        'unit_price' => $cart_products['price'],
                        'total_price' => $cart_products['price'] * $this->session->cart[$cart_products['id']]['quantity'],
                        'country' => $this->input->post('country'),
                        'state' => $this->input->post('state'),
                        'city' => $this->input->post('city'),
                        'address' => $this->input->post('home'),
                        'telephone' => $this->input->post('phone_code').$this->input->post('phone'),
                        'email' => $this->input->post('email'),
                        'order_desc' => $this->input->post('description'),
                        'payment_mode' => $this->input->post('payment'),
                        'payment_status' => 'Unpaid',
                        'delivery_status' => 'Pending'
                    );

                    $total_order_price += $data['total_price'];
                    $item_list .= $data['item_name'].',';
                    $order_codes .= $data['order_code'].',';
                    

                    $this->store_model->place_order($data);
                                        
                }
                $invoice_data = array(
                    'invoice_code' => $invoice_code,
                    'user_id' => $this->session->id,
                    'items' => $item_list,
                    'order_codes' => $order_codes,
                    'cost' => $total_order_price,
                    'payment_mode' => $this->input->post('payment'),
                    'date_due' => strtotime(date("Y-m-d H:i:s", strtotime(' + 3 days')))
                );
                $this->store_model->add_invoice($invoice_data);
            }
            unset($_SESSION['cart']);
            $this->store_model->clear_dbcart();
            header('location:'.base_url.'/index.php/account');
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

}