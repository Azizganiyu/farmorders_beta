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
        $sql = "select * from users WHERE user_name = ? OR user_email = ?";
        $query = $this->db->query($sql, array($data['id'], $data['id']));
        $result = $query->row_array();

        //if user exist verify password
        if(isset($result))
        {
            //verify password against user password input
            if(password_verify($data['password'], $result['user_password']))
            {
                if($result['status'] == 'unconfirmed')
                {
                    return 'unconfirmed';
                }
                else
                {
                    return $result;
                }
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
            'user_name' => $data['username'],
            'display_name' => $data['username'],
            'user_email' =>  $data['email'],
            'user_password' => password_hash($data['password'], PASSWORD_DEFAULT),
            'image_url' =>  base_url.'images/user.png',
            'user_role' => 'User'
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
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'display_name' => $data['display_name'],
            'user_phone' => $phone,
            'country_code' => $data['phone_code'],
            'state' => $data['state'],
            'city' => $data['city'],
            'home' => $data['home'],
            'country' => $data['country'],
            'postal_code' => $data['postal_code']

        );

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

    public function set_token($user_id, $token)
    {
        $values = array(
            'user_id' => $user_id,
            'token' => $token
        );
        $this->db->insert('login_tokens', $values);
    }

    public function validate_token($token)
    {
        $this->db->where('token', $token);
        $query = $this->db->get('login_tokens');
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

    public function remove_token($token)
    {
        $this->db->where('token', $token);
        $this->db->delete('login_tokens');
    }

    public function remove_all_token($id)
    {
        $this->db->where('user_id', $id);
        $this->db->delete('login_tokens');
    }

    public function cancel_expired_orders()
    {
        $this->db->where('date_due <', time());
        $this->db->update('invoice', array('status' => 'Canceled'));
    }
}