<?php 

class Blog_model extends CI_Model
{
    public function __construct()
    {
        $this->load->database();
    }


    public function count_posts($search_key,$tag)
    {
        if(!empty($search_key))
            {
                //search in name for media match
                $this->db->like('post_title', $search_key, 'both');
                return $this->db->count_all_results('post');
            }
        elseif($tag != false)
        {
            $this->db->like('tags', $tag, 'both');
            return $this->db->count_all_results('post');
        }
        else
        {
            return $this->db->count_all('post');
        }
    }
    
    public function get_all_posts($limit, $start, $search_key, $tag)
    {
        $this->db->limit($limit, $start);

        //use the search parameter only if it is not empty
        if(!empty($search_key))
        {
            //search in username or fullname for user match
            $this->db->like('post_title', $search_key, 'both');
        }
        if($tag != null)
        {
            $this->db->like('tags', $tag, 'both');
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

    public function get_featured_post()
    {   
        $this->db->limit(1);
        $this->db->order_by('id',  'DESC');
        $this->db->where('featured', 1);
        $query = $this->db->get('post');
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

    public function get_single_post($title)
    {   
        $this->db->where('post_title', $title);
        $query = $this->db->get('post');
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

    public function get_next_post($id)
    {   
        $sql = "select * from post WHERE id > ?  order by id asc limit 1";
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

    public function get_prev_post($id)
    {   
        $sql = "select * from post WHERE id < ?  order by id desc limit 1";
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

    public function add_comment($data)
    {
        $values = array(
            'type' => 'post',
            'type_id' => $data['id'],
            'type_parent_id' => $data['parent_id'],
            'name' => $data['name'],
            'email' => $data['email'],
            'message' => $data['message'],
            'image_url' => base_url.'/images/commenter_image.png'
        );
        $insert = $this->db->insert('comments', $values);
        if($insert)
        {
            return True;
        }
        else
        {
            return False;
        }
    }
    public function get_comments($id)
    {
            $this->db->where('type', 'post');
            $this->db->where('type_id', $id);
            $query = $this->db->get('comments');
            $data = $query->result_array();
            if(isset($data))
            {
                return $data;
            }
            else
            {
                return false;
            }  
    }
}

?>