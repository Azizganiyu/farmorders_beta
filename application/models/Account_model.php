<?php 

class Account_model extends CI_Model
{
    public function __construct()
    {
        $this->load->database();
    }
    
    public function get_user_details($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get('users');
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

    public function get_orders($id)
    {
        $this->db->where('user_id', $id);
        $query = $this->db->get('orders');
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

    public function get_invoice($id)
    {
        $this->db->where('user_id', $id);
        $query = $this->db->get('invoice');
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

    public function get_reviews($email)
    {
        $this->db->where('email', $email);
        $query = $this->db->get('product_reviews');
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

    
    public function count_orders($id)
    {
        $this->db->where(array('user_id' => $id, 'payment_status' => 'Unpaid'));
        return $this->db->count_all_results('orders');
    }

    public function count_invoice($id)
    {
        $this->db->where(array('user_id' => $id, 'status' => 'Unpaid'));
        return $this->db->count_all_results('invoice');
    }

    public function count_reviews($email)
    {
        $this->db->where('email', $email);
        return $this->db->count_all_results('product_reviews');
    }

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
            'user_email' => $data['email'],
            'user_password' => password_hash($data['password'], PASSWORD_DEFAULT),
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

    public function verify_password($str, $id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get('users');
        $result = $query->row_array(); 
        //if user exist verify password
        if(isset($result))
        {
            //verify password against user password input
            if(password_verify($str, $result['user_password']))
            {
                return true;
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

}