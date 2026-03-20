<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {

    // Email already exists
    public function email_exists($email) {
        $query = $this->db->where('email', $email)->where('active', 1)->get('users');
        return $query->num_rows() > 0;
    }

    // Register new user
    public function register($name, $email, $password) {
        $data = [
            'name'         => $name,
            'email'        => $email,
            'password'     => $password,
            'status'       => 1,
            'active'       => 1,
            'created_date' => date('Y-m-d H:i:s')
        ];
        $this->db->insert('users', $data);
        return $this->db->insert_id();
    }

    // Check email and password match
    public function login($email, $password) {
        $query = $this->db->where('email', $email)->where('password', $password)->where('active', 1)->get('users');
        return ($query->num_rows() > 0) ? $query->row() : false;
    }

    // Get user by ID 
    public function get_user_by_id($id) {
        return $this->db->where('id', $id)->get('users')->row();
    }
}