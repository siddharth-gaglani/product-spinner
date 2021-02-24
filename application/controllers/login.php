<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Login extends CI_Controller {

    function __construct() {
        parent::__construct();
        //$this->input->is_ajax_request()
        if ($this->uri->segment(2) != "logout") {
            if ($this->session->userdata('isloggedin')) {
                redirect('spin');
            }
        }
    }

    public function index() {
        if ($this->input->post()) {
            $username = $this->input->post('username');
            $password = $this->input->post('password');
            if ($details = $this->spin_model->validateCredentials($username, md5($password))) {
                $this->session->set_userdata('username', $details['email_address']);
                $this->session->set_userdata('userid', $details['id']);
                $this->session->set_userdata('name', $details['name']);
                $this->session->set_userdata('total_points', $details['total_points']);
                $this->session->set_userdata('isloggedin', true);
                redirect('login');
            } else {
                $data['error_message'] = "Invalid Credentials";
                $this->load->view('login', $data);
            }
        } else {
            $this->load->view('login');
        }
    }

    public function logout() {
        $this->session->sess_destroy();
        redirect('login');
    }

}