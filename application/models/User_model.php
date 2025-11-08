<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_model extends CI_Model
{
    public $username;
    public $email;
    public $password;
    public $insert_by;
    public $update_by;
    public $active;



    public function __construct(){
        // Construct the parent class
        parent::__construct();
    }
    public function getUserByPassword($username, $password){


        // untuk meng enkripsi password agar menjadi sha1
        $password_sha1 = sha1($password);

        log_message('error', 'username '.$username);
        log_message('error', 'password'.$password);

        $this->db->select("*");
        $this->db->from('user_login AS ul');
        $this->db->where('ul.username', $username);
        $this->db->where('ul.password', $password_sha1);
        $this->db->where('ul.active', 1);
        $this ->db->limit(1);
        $temp = $this->db->get();
        return $temp->result_array();

        if($temp->num_rows() == 1)
        {
            $temp=null;

            $temp = $query->result_array();

            $user = $temp[0];

            //date declaration
            
            return $return;
        }
            else
                {
                    return false;
                }


    }
// adalah untuk mendaftar user dan password baru dan mentumpannya pada tabel user_login.
   public function insert()
    {       
        $data=(array)$this;
        $this->db->insert("user_login",$data);
    }

}
