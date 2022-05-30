<?php
defined('BASEPATH')OR exit('No direct script access allowed');

class messages_model extends CI_Model{
	public function __construct()
    {
        parent::__construct();
        
    }
    public function insertValue($values,$id=null)
    {
        // $values = [$mailFrom,$mailTo,$subject,$msg,$attach];
        $data = array(
            'msg_from_id' => $values[0],
            'msg_to_id' => $values[1],
            'subject' => $values[2],
            'msg_detail' => $values[3],
            'attachments' => $values[4]
        );
        if(empty($id)){
            $result = $this->db->insert('messages',$data);
            if($this->db->affected_rows()>0)
                return $this->db->insert_id();
            return 0;
        }
        else{
            $this->db->where('id',$id);
            $this->db->update('gst18',$data);
            if($this->db->affected_rows()>0)
                return TRUE;
            return FALSE;           
        }
    }
    public function getMessages($id){
        $this->db->where(['msg_to_id'=>$id,'delete_msg'=>0,'inbox_msg'=>1]);
        $this->db->order_by('id','desc');
        $result = $this->db->get('messages')->result();
        return $result;
    }
    public function getSentMessages($id){
        $this->db->where(['msg_from_id'=>$id,'delete_msg'=>0]);
        $this->db->order_by('id','desc');
        $result = $this->db->get('messages')->result();
        return $result;
    }
    public function getSpamMessages($id){
        $this->db->where(['msg_to_id'=>$id,'spam_msg'=>1,'inbox_msg'=>1]);
        $this->db->order_by('id','desc');
        $result = $this->db->get('messages')->result();
        return $result;
    }
    public function getDeletedMessages($id){
        $this->db->where(['msg_to_id'=>$id,'delete_msg'=>1,'inbox_msg'=>0]);
        $this->db->order_by('id','desc');
        $result = $this->db->get('messages')->result();
        return $result;
    }
    public function getStarredMessages($id){
        $this->db->where(['msg_to_id'=>$id,'starred_msg'=>1,'delete_msg !='=>1]);
        $this->db->order_by('id','desc');
        $result = $this->db->get('messages')->result();
        return $result;
    }
    public function updateStarMsg($msg_id,$star_msg_value){
        if($star_msg_value == 0){
            $data = array(
                'starred_msg' => 1
            );
        }else{
            $data = array(
                'starred_msg' => 0
            );
        }
        $this->db->where(['id'=>$msg_id,'delete_msg !='=>1]);
        $result = $this->db->update('messages',$data);
        return $result;
    }
    public function updateDeleteMsg($msg_id){
        $data = array(
            'delete_msg' => 1,
            'inbox_msg' => 0
        );
        $this->db->where(['id'=>$msg_id]);
        $result = $this->db->update('messages',$data);
        return $result;
    }
    public function UndoDeleteMsg($msg_id){
        $data = array(
            'delete_msg' => 0,
            'inbox_msg' => 1
        );
        $this->db->where(['id'=>$msg_id]);
        $result = $this->db->update('messages',$data);
        return $result;
    }
    public function updateSpamMsg($msg_id){
        $data = array(
            'spam_msg' => 1
        );
        $this->db->where(['id'=>$msg_id]);
        $result = $this->db->update('messages',$data);
        return $result;
    }
    public function UndoSpamMsg($msg_id){
        $data = array(
            'spam_msg' => 0
        );
        $this->db->where(['id'=>$msg_id]);
        $result = $this->db->update('messages',$data);
        return $result;
    }
}