<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Chat extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Chat_model');

        // Block non-logged-in users from every chat method
        if (!$this->session->userdata('logged_in')) {
            redirect('auth/signin');
        }
    }

    // ---- CHAT PAGE ----
    public function index() {
        $data['user_name'] = $this->session->userdata('user_name');
        $this->load->view('chat', $data);
    }

    // ---- SEND MESSAGE (AJAX) ----
    public function send() {
        $sender_id = $this->session->userdata('user_id');
        $message   = trim($this->input->post('message'));

        if (empty($message)) {
            echo json_encode(['status' => 'error', 'message' => 'Empty message']);
            return;
        }

        $this->Chat_model->save_message($sender_id, $message);
        echo json_encode(['status' => 'success']);
    }

    // ---- FETCH NEW MESSAGES (AJAX POLLING) ----
    public function fetch() {
        $last_id  = (int) $this->input->post('last_id');
        $messages = $this->Chat_model->get_messages($last_id);
        echo json_encode($messages);
    }
}