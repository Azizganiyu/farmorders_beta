<?php
class Media_model extends CI_Model
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
     *   method to store uploaded files data
     * 
     *   the controller class gallery is responsible for sending the data here using the method do_upload()
     * 
     *   @param array $upload_data file details   
     */
    public function store_upload_details($upload_data)
    {
        

            return $this->db->insert('uploads', $upload_data);
            
    
    }

    //-------------------------------------------------------------------------------------------------

    /**
     * method to count requested media
     * 
     * @param string $type of media
     * 
     * @param string $search_key  
     */
    public function count_media($type, $search_key)
    {
        //get all media if type = all_media
        if($type == 'all_media')
        {
            //filter result if search key is provided
            if(!empty($search_key))
            {
                //search in name for media match
                $this->db->like('name', $search_key, 'both');
                return $this->db->count_all_results('uploads');
            }
            else
            {
                return $this->db->count_all('uploads');
            }
        }
        else
        {
            if(!empty($search_key))
            {
                //search in username or fullname for user match
                $this->db->like('name', $search_key, 'both');
                $this->db->where('type', $type);
                return $this->db->count_all_results('uploads');
            }
            else
            {
                $this->db->where('type', $type);
                return $this->db->count_all_results('uploads');
            }
            
        }

    }

    /**
     * method to retrieve uploaded data details from database based on the type requested
     * @param int $limit of retrieve request
     * @param int $start retrieving records from specific row 
     * @param string $type of file request
     * @param string $search_key to filter retrieved records
     */
    public function get_files($limit, $start, $type, $search_key)
    {
        if($type == 'all_media')
        { 
            $this->db->limit($limit, $start);
            $this->db->like('name', $search_key, 'both');
            $this->db->order_by('id', 'DESC');
            $query = $this->db->get('uploads');
            return $query->result_array();
        }
        else
        {
            $this->db->limit($limit, $start);
            $this->db->like('name', $search_key, 'both');
            $this->db->order_by('id', 'DESC');
            $query = $this->db->get_where('uploads', array('type' => $type));
            return $query->result_array();
        }
    }

    //---------------------------------------------------------------------------------------------------

    /**
     * method to remove record from database
     * @param array $upload_data file details   
     * returns boolean value 
     */
    public function delete_image($id)
    {
        $this->db->where_in('Id', $id);
        $this->db->delete('uploads');
        if($this->db->affected_rows() > 0)
        {
            return true;
        }
        else
        {
            return false;   
        }
    }

    //--------------------------------------------------------------------------------------------------
}