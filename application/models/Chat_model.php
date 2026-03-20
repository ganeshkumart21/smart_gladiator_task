<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Chat_model extends CI_Model {

    // Save a new message
    public function save_message($sender_id, $message) {
        $data = [
            'user_id'    => $sender_id,   
            'sender_id'  => $sender_id,   
            'message'    => $message,
            'status'     => 0,  
            'active'     => 1,
            'created_by' => $sender_id,
            'created_at' => date('Y-m-d H:i:s')
        ];
        $this->db->insert('messages', $data);
        return $this->db->insert_id();
    }

    // Fetch messages newer than last_id
    public function get_messages($last_id = 0) {
        $this->db->select('messages.id, messages.message, messages.created_at, users.name AS sender_name');
        $this->db->from('messages');
        $this->db->join('users', 'users.id = messages.sender_id', 'left');
        $this->db->where('messages.id >', $last_id);
        $this->db->where('messages.active', 1);
        $this->db->order_by('messages.id', 'ASC');
        return $this->db->get()->result();
    }
}