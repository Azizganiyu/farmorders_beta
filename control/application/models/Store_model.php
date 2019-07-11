<?php 

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

    //--------------------------------------------------------------------------------------

    /**
     *   method add category to  database
     * 
     *   returns boolean value
     * 
     *   @param array $details category   
     */
    public function add_category($details)
    {
        $values = array(
            'parent_id' => $details['cat_parent'],
            'cat_name' => strtolower($details['cat_name']),
            'cat_desc' => $details['cat_desc']
        );
        $insert = $this->db->insert('product_category', $values);
        if($insert)
        {
            return True;
        }
        else
        {
            return False;
        }
    }

    //--------------------------------------------------------------------------------------

    /**
     *   method retrieves category by id or all category from database
     * 
     *   returns the category(ies) or a boolean value(false) if no category found
     * 
     *   @param int $id of category   
     */
    public function get_category($id = null)
    {
         //else get category by id
        if($id != null)
        {
            $this->db->where('id', $id);
            $query = $this->db->get('product_category');
            $result = $query->row_array();
        }
        //get all category if no id provided
        else
        {
            $this->db->order_by('id', 'DESC');
            $query = $this->db->get('product_category');
            $result = $query->result_array();
        }
        if(count($result) > 0)
        {
            
            return $result;
        }
        else
        {
            return false;

        }
    }

    //-----------------------------------------------------------------------------------------------------

    /**
     * Method to delete category
     * 
     * @param int/array   $id category to delete
     * 
     * returns boolean values
     * 
     */
    public function delete_category($id)
    {
        $this->db->where_in('id', $id);
        $this->db->delete('product_category');
        if($this->db->affected_rows() > 0)
        {
            $this->db->where_in('parent_id', $id);
            $this->db->update('product_category',array('parent_id' => 0 ));
            return true;
        }
        else
        {
            return false;   
        }
    }

    //--------------------------------------------------------------------------------------

    /**
     *   method to update category by id
     * 
     *   returns boolean value
     * 
     *   @param int $id of category 
     *   @param array $data to be updated
     */
    public function update_category($id, $data)
    {
        $update = array(
            'cat_name'=>$data['cat_name'],
            'parent_id' => $data['cat_parent'],
            'cat_desc' => $data['cat_desc']
        );
        $this->db->where_in('id', $id);
        $update = $this->db->update('product_category',$update);

        if($this->db->affected_rows() > 0)
        {
            return true;
        }
        else
        {
            return false;   
        }
    }

    //--------------------------------------------------------------------------------------

    /**
     *   method validate change of category name
     * 
     *   returns boolean value
     * 
     *   @param string $cat_name to update to
     *   @param int $id of category
     */
    public function validate_change_cat_name($cat_name, $id)
    {
        //check if no other category uses the name to avoid duplication
        $sql = "select cat_name from product_category WHERE id != ? AND cat_name = ?";
        $query = $this->db->query($sql, array($id, $cat_name));
        $result = $query->row_array();  
        if(isset($result))
        {
            return false;
        }
        else
        {
            return true;
        }
    }

    //--------------------------------------------------------------------------------------

    /**
     *   method to create a new product and add to database
     * 
     *   returns boolean value
     * 
     *   @param array $data of product
     */
    public function add_product($data)
    {
        $category = ''; //initialize category as empty string

        //if product has category, concatenate all category by using '|' as seperator
        if(!empty($data['product_category']))
        {
            foreach($data['product_category'] as $product_category)
            {
                $category .= $product_category.'|';
            }
        }
        //else use set category to 'Uncategorized'
        else
        {
            $category = 'Uncategorized';
        }

        //verify product is set to be vissible
        if(isset($data['visible']))
        {
            $visible = 1;
        }
        else
        {
            $visible = 0;
        }

        //verify product is set to be featured
        if(isset($data['featured']))
        {
            $featured = 1;
        }
        else
        {
            $featured = 0;
        }

        $tags = str_replace(' ', '' , $data['tags']); //remove all white spaces
        $tags = strtolower($tags); //convert tags to lowercase

        $values = array(
            'user_id' => 0,
            'product_name' => $data['product_name'],
            'product_author' => $this->session->displayname,
            'last_modified' => time(),
            'product_desc' => $data['product_desc'],
            'product_image_url' => $data['product_image'],
            'product_category' => $category,
            'owner' => $data['owner'],
            'price' => $data['price'],
            'stock_status' => $data['stock_status'],
            'weight' => $data['weight'],
            'dimension' => $data['dimension'],
            'delivery' => $data['delivery'],
            'product_gallery' => $data['product_gallery'],
            'visibility' => $visible,
            'featured' => $featured,
            'tags' => $tags
        );

        $insert = $this->db->insert('products', $values);
        if($insert)
        {
            return True;
        }
        else
        {
            return False;
        }
    }

    //--------------------------------------------------------------------------------------

    /**
     *   method to count product
     * 
     *   returns the number of all product or number of searched product
     * 
     *   @param string $search_key of product
     */
    public function count_products($search_key)
    {
        if(!empty($search_key))
            {
                //if there is a search key count all product like the search key in product name
                $this->db->like('product_name', $search_key, 'both');
                return $this->db->count_all_results('products');
            }
            else
            {
                return $this->db->count_all('products');
            }
    }

    //--------------------------------------------------------------------------------------

    /**
     *   method to get all products from database
     * 
     *   returns products or false if no products found
     * 
     *   @param int $limit to number of products to retrieve
     *   @param int $start position of product to retrive
     *   @param string $serach_key to filter retrieved products
     */
    public function get_all_products($limit, $start, $search_key)
    {
        $this->db->limit($limit, $start);

        //use the search parameter only if it is not empty
        if(!empty($search_key))
        {
            //search in product name for key match
            $this->db->like('product_name', $search_key, 'both');
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

    //--------------------------------------------------------------------------------------

    /**
     *   method to delete product by id
     * 
     *   returns boolean value
     * 
     *   @param int/array $id of product(s) to delete
     */
    public function delete_products($id)
    {
        $this->db->where_in('id', $id);
        $this->db->delete('products');
        if($this->db->affected_rows() > 0)
        {
            return true;
        }
        else
        {
            return false;   
        }
    }

    //--------------------------------------------------------------------------------------

    /**
     *   method to get products from database by id
     * 
     *   returns product or false if no product found
     * 
     *   @param int $id of product to retrieve
     */
    public function get_product($id)
    {
        $sql = "select * from products WHERE id = ?";
        $query = $this->db->query($sql, array($id));
        $data = $query->row_array();
        if(isset($data))
        {
            return $data;
        }
        else
        {
            return false;
        }
    }

    //--------------------------------------------------------------------------------------

    /**
     *   method to update products in database
     * 
     *   returns boolean value
     * 
     *   @param int $id of product to update
     *   @param array $data of product to be updated
     */
    public function update_product($id, $data)
    {
        $category = ''; //initialize category as empty string

        //if product has category, concatenate all category by using '|' as seperator
        if(!empty($data['product_category']))
        {
            foreach($data['product_category'] as $product_category)
            {
                $category .= $product_category.'|';
            }
        }
        //else use set category to 'Uncategorized'
        else
        {
            $category = 'Uncategorized';
        }

        //verify product is set to be vissible
        if(isset($data['visible']))
        {
            $visible = 1;
        }
        else
        {
            $visible = 0;
        }

        //verify product is set to be featured
        if(isset($data['featured']))
        {
            $featured = 1;
        }
        else
        {
            $featured = 0;
        }

        $tags = str_replace(' ', '' , $data['tags']); //remove all white spaces
        $tags = strtolower($tags); //convert tags to lowercase

        $update = array(
            'user_id' => 0,
            'product_name' => $data['product_name'],
            'modified_by' => $this->session->displayname,
            'product_desc' => $data['product_desc'],
            'product_image_url' => $data['product_image'],
            'product_category' => $category,
            'owner' => $data['owner'],
            'price' => $data['price'],
            'stock_status' => $data['stock_status'],
            'weight' => $data['weight'],
            'dimension' => $data['dimension'],
            'delivery' => $data['delivery'],
            'product_gallery' => $data['product_gallery'],
            'visibility' => $visible,
            'featured' => $featured,
            'tags' => $tags
        );


        $this->db->where_in('id', $id);
        $update = $this->db->update('products',$update);

        if($this->db->affected_rows() > 0)
        {
            return true;
        }
        else
        {
            return false;   
        }
    }

    //--------------------------------------------------------------------------------------

    /**
     *   method to validate change of product name, to make unique
     * 
     *   returns boolean value
     * 
     *   @param int $id of product to update title
     *   @param string $product_name of product to be updated
     */
    public function validate_change_product_name($product_name, $id)
    {
        $sql = "select product_name from products WHERE id != ? AND product_name = ?";
        $query = $this->db->query($sql, array($id, $product_name));
        $result = $query->row_array();  
        if(isset($result))
        {
            return false;
        }
        else
        {
            return true;
        }
    }
}