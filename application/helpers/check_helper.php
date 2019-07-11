<?php

defined('BASEPATH') OR exit('No direct script access allowed');
/**
* Check settings
* 
* This helper checks for prelimanary setting and make nessesary adjustment
* 
*/
        $CI =& get_instance();
        $CI->load->model(array('store_model','users_model'));
        //declares the cart session if not declared
        if(!isset($_SESSION['cart']))
		{
            $_SESSION['cart'] = array();
        }

        //cancel database orders past 3 days
        $CI->users_model->cancel_expired_orders();

        //check if user is not currently logged in
        if(!isset($_SESSION['logged_in']))
        {
            //check if a remember me token is set for auto login
            if(isset($_COOKIE['login_tokens']))
            {
                //if token is set vaidate token and login user
                $validate_token = $CI->users_model->validate_token($_COOKIE['login_tokens']);
                if($validate_token != false)
                {
                    //set session datas for for user
                    $_SESSION['id'] = $validate_token['user_id'];
                    $_SESSION['logged_in'] = true;

                    setcookie('logged_in', 'true', 0, "/");
                    echo 'we remember you Mr. '.$validate_token['user_id'];

                    //get user cart
                    $db_cart = $CI->store_model->get_my_cart($validate_token['user_id']);
                    if($db_cart != false)
                    {
                        foreach($db_cart as $cart_item)
                        {
                            $_SESSION['cart'][$cart_item['product_id']] = array(
                                'price' => $cart_item['price'], 'quantity' => $cart_item['quantity']
                            );
                        }
                    }
                }

            }
        }
        //else if user is logged in
        elseif(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true)
        {
            //make sure the browser knows he is currently logged in
            setcookie('logged_in', 'true', 0, "/"); //expires when browser closes
        }
        
    //-------------------------------------------------------------------------------------------------------------