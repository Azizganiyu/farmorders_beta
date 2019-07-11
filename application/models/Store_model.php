<?php
/**
 * Store_model Class
 * 
 * This class handles all store functions
 * 
 */
class Store_model extends CI_Model
{
    /**
     * Class constructor
     * 
     * on class call, automatically load the database
    */  
    public function __construct()
    {
        $this->load->database();
    }

    /**
     * get_all_categories method
     * 
     * This method retrieves all categories from the database
    */  
    public function get_all_categories()
    {
       $query = $this->db->get('product_category');
       $result = $query->result_array();
       if(count($result)>0)
       {
           return $result;
       }
       else
       {
           return false;
       }
    }

    //---------------------------------------------------------------------------------------------------------

    //---------------------------------------------------------------------------------------------------------

    /**
     * count_products method
     * 
     * This method counts all or searched or in-category products from the database 
     * 
     * returns the number of products
    */  
    public function count_products($search_key,$category)
    {
        if(!empty($search_key))
            {
                //search in name for media match
                $this->db->like('product_name', $search_key, 'both');
                return $this->db->count_all_results('products');
            }
        elseif($category != 'all')
        {
            $this->db->like('product_category', $category, 'both');
            return $this->db->count_all_results('products');
        }
        else
        {
            return $this->db->count_all('products');
        }
    }

    //---------------------------------------------------------------------------------------------------------

    /**
     * get_all_products method
     * 
     * This method retrieves all products from the database
     * 
     * returns the products or false if no product found
    */  
    public function get_all_products($limit, $start, $search_key, $category)
    {
        $this->db->limit($limit, $start);

        //use the search parameter only if it is not empty
        if(!empty($search_key))
        {
            //search in username or fullname for user match
            $this->db->like('product_name', $search_key, 'both');
        }
        elseif($category != 'all')
        {
            $this->db->like('product_category', $category, 'both');
        }

        $this->db->order_by('id', 'DESC');
        $query = $this->db->get('products');
        if($query->num_rows() > 0)
        {
            $result = $query->result_array();
            return $result;
        }
        else
        {
            return false;

        }
    }

        //---------------------------------------------------------------------------------------------------------

    /**
     * cart method
     * 
     * This method adds or remove product in the cart table based on the product status
     * 
     * @param int $id of product
     * @param int $status of the product
     * 
    */  
    public function cart($id, $details, $status)
    {
        if($status == '1')
        {
            $values = array(
                'product_id' => $id,
                'user_id' => $this->session->id,
                'quantity' => $details['quantity'],
                'price' => $details['price']
            );
            $this->db->insert('cart', $values);
            
        }
        elseif($status == '0')
        {
            $this->db->delete('cart', array('product_id' => $id, 'user_id' => $this->session->id));
        }
    }

    //---------------------------------------------------------------------------------------------------------

    /**
     * cart_id_exist method
     * 
     * This method checks if a cart id exist in the database of a user
     * 
     * @param int $product_id
     * @param int $user_id
     * 
    */  
    public function cart_id_exist($product_id, $user_id)
    {
        
        $this->db->where('product_id',$product_id);
        $this->db->where('user_id',$user_id);
        $this->db->from('cart');
        if($this->db->count_all_results() > 0)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    //---------------------------------------------------------------------------------------------------------

    
    /**
     * get_my_cart method
     * 
     * This method retrieves all cart items in the database
     * 
     * @param int $id of product
     * 
    */  
    public function get_my_cart($id)
    {
        
        $this->db->where('user_id', $id);
        $query = $this->db->get('cart');
        if($query->num_rows() > 0)
        {
            $result = $query->result_array();
            return $result;
        }
        else
        {
            return false;

        }
    }

    //---------------------------------------------------------------------------------------------------------
    public function get_cart($cart_datas)
    {
        if(count($cart_datas) != 0)
        {
            $this->db->where_in('id',array_keys($cart_datas));
            $query = $this->db->get('products');
            if($query->num_rows() > 0)
            {
                $result = $query->result_array();
                return $result;
            }
            else
            {
                return false;

            }
        }
        else
        {
            return false;
        }
    }

    public function update_cart($user_id, $product_id, $qty)
    {
        $update = array(
           'quantity' => $qty
        );
        $this->db->where_in('user_id', $user_id);
        $this->db->where_in('product_id', $product_id);
        $update = $this->db->update('cart',$update);
    }
    
    public function clear_dbcart()
    {
        $this->db->delete('cart', array('user_id' => $this->session->id));
    }

    public function get_product($name)
    {
        $this->db->where('product_name', $name);
        $query = $this->db->get('products');
        if($query->num_rows() > 0)
            {
                $result = $query->row_array();
                return $result;
            }
        else
        {
            return false;

        }

    }

    public function add_reviews($data)
    {
        $values = array(
            'product_id' => $data['id'],
            'product_name' => $data['p_name'],
            'name' => $data['name'],
            'email' => $data['email'],
            'comment' => $data['comment'],
            'rating' => $data['rating']
        );
        $query = $this->db->insert('product_reviews', $values);
        if($query)
        {
            return true;
        }
        else
        {
            return false;

        }
    }

    public function count_reviews($product_id)
    {
        $this->db->where('product_id', $product_id);
        return $this->db->count_all_results('product_reviews');
    }

    public function get_reviews($limit, $start, $product_id)
    {
        $this->db->limit($limit, $start);
        $this->db->where('product_id', $product_id);
        $query = $this->db->get('product_reviews');
        if($query->num_rows() > 0)
            {
                $result = $query->result_array();
                return $result;
            }
        else
        {
            return false;

        }

    }

    public function add_invoice($data)
    {
        $query = $this->db->insert('invoice', $data);
    }

    public function place_order($data)
    {
        $query = $this->db->insert('orders', $data);
    }
}