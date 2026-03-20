<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->load->model('User_model');  
        $this->load->library('session');   
        $this->load->helper('url');
    }

    // ---- SIGNUP PAGE ----
    public function signup()
    {
        // If already logged in, go to landing
        if ($this->session->userdata('logged_in')) {
            redirect('auth/landing');
        }
        $this->load->view('signup');
    }

    // ---- HANDLE SIGNUP AJAX ----
    public function register()
    {
        $name     = trim($this->input->post('name'));
        $email    = trim($this->input->post('email'));
        $password = md5(trim($this->input->post('password')));

        if ($this->User_model->email_exists($email)) {
            echo json_encode([
                'status'  => 'error',
                'message' => 'This email is already registered!'
            ]);
        } else {
            $this->User_model->register($name, $email, $password);
            echo json_encode([
                'status'  => 'success',
                'message' => 'Registered successfully! Please sign in.'
            ]);
        }
    }

    // ---- SIGNIN PAGE ----
    public function signin()
    {
        if ($this->session->userdata('logged_in')) {
            redirect('auth/landing');
        }
        $this->load->view('signin');
    }

    // ---- HANDLE SIGNIN AJAX ----
    public function login()
    {
        $email    = trim($this->input->post('email'));
        $password = md5(trim($this->input->post('password')));

        $user = $this->User_model->login($email, $password);

        if ($user) {
            $this->session->set_userdata([
                'user_id'   => $user->id,
                'user_name' => $user->name,
                'user_email' => $user->email,
                'logged_in' => TRUE
            ]);
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode([
                'status'  => 'error',
                'message' => 'Email or password is incorrect!'
            ]);
        }
    }

    // ---- LANDING PAGE ----
    public function landing()
    {
        if (!$this->session->userdata('logged_in')) {
            redirect('auth/signin');
        }
        $data['user_name'] = $this->session->userdata('user_name');
        $this->load->view('landing', $data);
    }

    // ---- LOGOUT ----
    public function logout()
    {
        $this->session->sess_destroy();
        redirect('auth/signin');
    }
}
