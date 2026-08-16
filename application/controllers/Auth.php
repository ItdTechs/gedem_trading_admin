<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Auth
 *
 * Deliberately extends MY_Controller, NOT Admin_Controller — this is the
 * one admin controller that must be reachable *without* a session, or
 * nobody could ever log in.
 */
class Auth extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library(['session', 'form_validation']);
        $this->load->helper(['url', 'form']);
        $this->load->model('Admin_model');
    }

    /**
     * Default method - redirect to login
     */
    public function index()
    {
        redirect('login');
    }

    public function login()
    {
        // Already logged in? Don't show the login form again.
        if ($this->session->userdata('admin_id')) {
            redirect('dashboard');
            return;
        }

        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if ($this->form_validation->run() === TRUE) {

            $email    = $this->input->post('email', TRUE);
            $password = $this->input->post('password');

            $admin = $this->Admin_model->attempt_login($email, $password);

            if ($admin) {
                $this->session->set_userdata([
                    'admin_id'   => $admin->id,
                    'admin_name' => $admin->name,
                    'admin_role' => $admin->role,
                ]);

                $redirect = $this->session->userdata('redirect_after_login');
                $this->session->unset_userdata('redirect_after_login');

                redirect($redirect ?: 'dashboard');
                return;
            }

            $this->session->set_flashdata('admin_error', 'Incorrect email or password.');
            redirect('login');
            return;
        }

        $this->load->view('auth/login', [
            'flash_error' => $this->session->flashdata('admin_error'),
        ]);
    }

    public function logout()
    {
        $this->session->sess_destroy();
        redirect('login');
    }
}
