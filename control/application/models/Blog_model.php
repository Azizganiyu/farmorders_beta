<?php 

class Blog_model extends CI_Model
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
     *   @param array $details of category   
     */
    public function add_category($details)
    {
        $values = array(
            'parent_id' => $details['cat_parent'],
            'cat_name' => $details['cat_name'],
            'cat_desc' => $details['cat_desc']
        );
        $insert = $this->db->insert('post_category', $values);
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
            $query = $this->db->get('post_category');
            $result = $query->row_array();
        }
        //get all category if no id provided
        else
        {
            $this->db->order_by('id', 'DESC');
            $query = $this->db->get('post_category');
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
        $this->db->delete('post_category');
        if($this->db->affected_rows() > 0)
        {
            $this->db->where_in('parent_id', $id);
            $this->db->update('post_category',array('parent_id' => 0 ));
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
        $update = $this->db->update('post_category',$update);

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
        $sql = "select cat_name from post_category WHERE id != ? AND cat_name = ?";
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
     *   method to create a new post and add to database
     * 
     *   returns boolean value
     * 
     *   @param array $data of post
     */
    public function new_post($data)
    {
        $category = ''; //initialize category as empty string

        //if post has category, concatenate all category by using '|' as seperator
        if(!empty($data['post_category']))
        {
            foreach($data['post_category'] as $post_category)
            {
                $category .= $post_category.'|';
            }
        }
        //else use set category to 'Uncategorized'
        else
        {
            $category = 'Uncategorized';
        }

        //verify post is set to be vissible
        if(isset($data['visible']))
        {
            $visible = 1;
        }
        else
        {
            $visible = 0;
        }

        //verify post is set to be featured
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
            'post_title' => $data['post_title'],
            'post_author' => $this->session->displayname,
            'last_modified' => time(),
            'post_body' => $data['post_content'],
            'post_image_url' => $data['post_image'],
            'post_category' => $category,
            'visibility' => $visible,
            'featured' => $featured,
            'tags' => $tags
        );

        $insert = $this->db->insert('post', $values);
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
     *   method to count post
     * 
     *   returns the number of all posts or number of serached post
     * 
     *   @param string $search_key of post
     */
    public function count_posts($search_key)
    {
        //if there is a search key count all post like the search key in post title
        if(!empty($search_key))
            {
                $this->db->like('post_title', $search_key, 'both');
                return $this->db->count_all_results('post');
            }
            else
            {
                return $this->db->count_all('post');
            }
    }

    //--------------------------------------------------------------------------------------

    /**
     *   method to get all posts from database
     * 
     *   returns posts or false if no post found
     * 
     *   @param int $limit to number of post to retrieve
     *   @param int $start position of post to retrive
     *   @param string $serach_key to filter retrieved posts
     */
    public function get_all_posts($limit, $start, $search_key)
    {
        $this->db->limit($limit, $start);

        //use the search parameter only if it is not empty
        if(!empty($search_key))
        {
            //search in post title for key match
            $this->db->like('post_title', $search_key, 'both');
        }
        $this->db->order_by('id', 'DESC');
        $query = $this->db->get('post');
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
     *   method to delete post by id
     * 
     *   returns boolean value
     * 
     *   @param int/array $id of post(s) to delete
     */
    public function delete_posts($id)
    {
        $this->db->where_in('id', $id);
        $this->db->delete('post');
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
     *   method to get posts from database by id
     * 
     *   returns post or false if no post found
     * 
     *   @param int $id of post to retrieve
     */
    public function get_post($id)
    {
        $sql = "select * from post WHERE id = ?";
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
     *   method to update posts in database
     * 
     *   returns boolean value
     * 
     *   @param int $id of post to update
     *   @param array $data of post to be updated
     */
    public function update_post($id, $data)
    {
        $category = ''; //initialize category as empty string

        //if post has category, concatenate all category by using '|' as seperator
        if(!empty($data['post_category']))
        {
            foreach($data['post_category'] as $post_category)
            {
                $category .= $post_category.'|';
            }
        }
        //else use set category to 'Uncategorized'
        else
        {
            $category = 'Uncategorized';
        }

        //verify post is set to be vissible
        if(isset($data['visible']))
        {
            $visible = 1;
        }
        else
        {
            $visible = 0;
        }

        //verify post is set to be featured
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
            'post_title' => $data['post_title'],
            'last_modified' => time(),
            'modified_by' => $this->session->displayname,
            'post_body' => $data['post_content'],
            'post_image_url' => $data['post_image'],
            'post_category' => $category,
            'visibility' => $visible,
            'featured' => $featured,
            'featured' => $featured,
            'tags' => $tags
        );

        $this->db->where_in('id', $id);
        $update = $this->db->update('post',$update);

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
     *   method to validate change of post title, to make unique
     * 
     *   returns boolean value
     * 
     *   @param int $id of post to update title
     *   @param string $post_title of post to be updated
     */
    public function validate_change_post_title($post_title, $id)
    {
        //verify no other post uses the same title
        $sql = "select post_title from post WHERE id != ? AND post_title = ?";
        $query = $this->db->query($sql, array($id, $post_title));
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