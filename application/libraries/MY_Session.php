<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Session extends CI_Session {

    public function __construct(array $params = array()) {
        if (session_status() === PHP_SESSION_NONE) {
            parent::__construct($params);
        }
    }
}