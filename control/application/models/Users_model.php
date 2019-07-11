<?php 

/**
 * User Model Class
 * 
 * This class manages all user data
 * 
 */
class Users_model extends CI_Model
{
    /**
     * Class constructor
     *
     * Loads the database
     * 
     */
    public function __construct()
    {
        $this->load->database();
    }

    //---------------------------------------------------------------------------

    /**
     * Method to verify or validate user before login
     * 
     * returns user data if user verified  or a boolean value of false
     * 
     */
    public function validate_user($data)
    {
        $sql = "select * from users WHERE (user_name = ? OR user_email = ?) AND user_role != ?";
        $query = $this->db->query($sql, array($data['id'], $data['id'], 'User'));
        $result = $query->row_array();

        //if user exist verify password
        if(isset($result))
        {
            //verify password against user password input
            if(password_verify($data['password'], $result['user_password']))
            {
                return $result;
            }
            else
            {
                return False;
            }

        }
        else
        {
            return False;
        }
    }

    //----------------------------------------------------------------------------------------

    /**
     * Method to register user
     * 
     * Inserts user primary info into database
     * 
     * @param array $data user data/input
     * 
     * returns a boolean value if data inserted
     */
    public function register_user($data)
    {
        $values = array(
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'full_name' => $data['first_name'].' '.$data['last_name'],
            'user_name' => $data['user_name'],
            'display_name' => $data['user_name'],
            'user_email' =>  $data['email'],
            'user_password' => password_hash($data['password'], PASSWORD_DEFAULT),
            'image_url' =>  base_url.'images/user.png',
            'user_role' => $data['role']
        );
        $insert = $this->db->insert('users', $values);
        if($insert)
        {
            return True;
        }
        else
        {
            return False;
        }
    }

    //-------------------------------------------------------------------------------------

    /**
     * Method to get a user information
     * 
     * @param int $id user ID
     * 
     * returns user data on success or a boolean value of false
     * 
     */
    public function get_user_data($id)
    {
        $sql = "select * from users WHERE ID = ?";
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
     * Method to update user record with new details
     * 
     * @param array $data new user data to be updated
     * @param int $id user record that should be updated
     * 
     * returns boolean values on success(true) and on fail(false)
     * 
     */
    public function update_user($data, $id)
    {
        $phone = $data['phone'];

        //if phone number starts from zero, remove the leading zero
        if(!empty($phone)  && $phone[0] == '0'){
            $phone = substr($phone, 1);
        }

        $update = array(
            'image_url'=>$data['image_url'],
            'user_role' => $data['role'],
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'display_name' => $data['display_name'],
            'user_phone' => $phone,
            'country_code' => $data['phone_code'],
            'state' => $data['state'],
            'city' => $data['city'],
            'home' => $data['home'],
            'country' => $data['country'],
            'postal_code' => $data['postal_code'],
            'website' => $data['website']

        );

        //add password to $update array only if set by user
        if(!empty($data['password'])){
            $update['user_password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        }

        $this->db->where('ID', $id);
        $query = $this->db->update('users', $update);
        if($query)
        {
            return True;
        }
        else
        {
            return False;
        }

    }

    //---------------------------------------------------------------------------------------------

    /**
     * Method to validate change of email
     * 
     * verifies no other user uses the email
     * 
     * @param string $email new email
     * @param int $id user id
     * 
     * returns boolean values
     * 
     */
    public function validate_change_email($email, $id)
    {
        $sql = "select user_email from users WHERE ID != ? AND user_email = ?";
        $query = $this->db->query($sql, array($id, $email));
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

    //--------------------------------------------------------------------------------------------
    
    /**
     * Method to count all users in table
     * 
     * returns the number of users
     * 
     * @param string $search_key
     */
    public function count_users($search_key)
    {
        if(!empty($search_key))
        {
            //search in name for media match
            $this->db->like('user_name', $search_key, 'both');
            $this->db->or_like('full_name', $search_key, 'both');
            return $this->db->count_all_results('users');
        }
        else
        {
            return $this->db->count_all('users');
        }
    }

    //---------------------------------------------------------------------------------------------

    /**
     * Method to get all users
     * 
     * @param int $limit limit the number of data retrieved
     * @param int $start position to start retrieving data
     * @param string $search_key retrieve users based on search
     * 
     * returns users data array or false if no users found
     * 
     */
    public function get_all_users($limit, $start, $search_key)
    {
        $this->db->limit($limit, $start);

        //use the search parameter only if it is not empty
        if(!empty($search_key))
        {
            //search in username or fullname for user match
            $this->db->like('user_name', $search_key, 'both');
            $this->db->or_like('full_name', $search_key, 'both');
        }
        $this->db->order_by('id', 'DESC');
        $query = $this->db->get('users');
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

    //----------------------------------------------------------------------------------------------

    /**
     * Method to delete user
     * 
     * @param int/array   $id user(s) to delete
     * 
     * returns boolean values
     * 
     */
    public function delete_users($id)
    {
        $this->db->where_in('ID', $id);
        $this->db->delete('users');
        if($this->db->affected_rows() > 0)
        {
            return true;
        }
        else
        {
            return false;   
        }
    }

    //-------------------------------------------------------------------------------------------------
}