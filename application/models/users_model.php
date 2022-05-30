<?php
defined('BASEPATH')OR exit('No direct script access allowed');

class users_model extends CI_Model{
	public function __construct()
    {
        parent::__construct();
        
    }
    public function encryptPassword($pass)
    {
        $value = "&*^(%456Aaz$@#@#ZDD";
        $password ="";

        for($i = 0;$i<strlen($pass);$i++){
            $password .= $pass[$i].$value;
        }
        // print_r($password);die;
        return $password;
    }
    public function decryptPassword($pass)
    {
        $value = "&*^(%456Aaz$@#@#ZDD";
        $password = implode("",explode($value,$pass));
        // echo strlen($password);
        return $password;
    }
    public function AuthUser($username,$password){
        $pass = $this->encryptPassword($password);
        // $pass = $this->decryptPassword('h&*^(%456Aaz$@#@#ZDDa&*^(%456Aaz$@#@#ZDDr&*^(%456Aaz$@#@#ZDDs&*^(%456Aaz$@#@#ZDDh&*^(%456Aaz$@#@#ZDDs&*^(%456Aaz$@#@#ZDDh&*^(%456Aaz$@#@#ZDDa&*^(%456Aaz$@#@#ZDDr&*^(%456Aaz$@#@#ZDDm&*^(%456Aaz$@#@#ZDDa&*^(%456Aaz$@#@#ZDD');
        // print_r($pass);die;
        $this->db->where(['email_id'=>$username,'password'=>$pass,'active'=>0]);
        $query = $this->db->get('users')->row();
        // print_r($query);die;
        if($query->id)
            return $query->id;
        else
            return 0;
    }
    function insertValues($values,$id=null){
        // $values = [$email,$password,$f_name,$l_name,$m_name,$address,$number,$dob,$picture,$gender]
        // echo sizeof($values);
        // if
        $ciphertext = $this->encryptPassword($values[1]);
        $data = array(
            'f_name' => $values[2],
            'l_name' => $values[3],
            'm_name' => $values[4],
            'email_id' => $values[0],
            'gender' => $values[9],
            'date_of_birth' => $values[7],
            'phone' => $values[6],
            'password' => $ciphertext,
            'address' => $values[5],
            'photo' => $values[8],
        );
        // print_r($data['date']);exit;
        if(empty($id)){
            $result = $this->db->insert('users',$data);
            if($this->db->affected_rows()>0)
                return $this->db->insert_id();
            else
                return 0;
        }
        else{
            // print_r("Inside edit");die;
            $data['dateUpdated'] = date ('Y-m-d H:i:s');
            // print_r($data);die;
            $this->db->where('id',$id);
            $this->db->update('users',$data);
            if($this->db->affected_rows()>0)
                return TRUE;
            else
                return FALSE;           
        }
    }
    public function checkEmail($value)
    {
        // code...
        $this->db->where(['email_id'=>$value,'active'=>0]);
        $query = $this->db->get('users')->row();
        if(count($query) > 0)
            return 1;
        else
            return 0;
    }
    public function checkNumber($value,$id)
    {
        // code...
        $this->db->where(['phone'=>$value,'active'=>0,'id !='=>$id]);
        $query = $this->db->get('users')->row();
        if(count($query) > 0)
            return 1;
        else
            return 0;
    }
    public function getUserId($mail_id)
    {
        $this->db->where(['email_id' => $mail_id]);
        $query = $this->db->get('users')->row();
        if($query->id){
            // print_r($query->id);die;
            return $query->id;
        }
        return 0;
    }
    public function getUserDetail($id)
    {
        $this->db->where(['id' => $id]);
        $query = $this->db->get('users')->row();
        if($query){
            // print_r($query->id);die;
            return $query;
        }
        return 0;
    }
}