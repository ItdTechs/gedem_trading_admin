<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AdminProfile extends MY_Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
    }

    public function index()
    {
        $this->form_validation->set_rules('name', 'Full name', 'required|min_length[2]|max_length[150]');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|max_length[150]');

        if ($this->input->method() === 'post' && $this->form_validation->run() === TRUE) {
            $name = $this->input->post('name', TRUE);
            $email = $this->input->post('email', TRUE);

            if ($this->Admin_model->update_profile($this->admin->id, $name, $email)) {
                $this->session->set_flashdata('admin_success', 'Profile updated successfully.');
                $this->session->set_userdata('admin_name', $name);
                $this->session->set_userdata('admin_email', strtolower(trim($email)));
                redirect('profile');
                return;
            }

            $this->session->set_flashdata('admin_error', 'That email is already in use by another admin.');
        }

        $this->render_admin('admin_profile/index', [
            'page_title' => 'My Profile',
            'active_nav' => 'profile',
            'admin_profile' => $this->admin,
        ]);
    }

    public function change_password()
    {
        $this->form_validation->set_rules('current_password', 'Current password', 'required');
        $this->form_validation->set_rules('new_password', 'New password', 'required|min_length[8]|max_length[128]');
        $this->form_validation->set_rules('confirm_password', 'Confirm password', 'required|matches[new_password]');

        if ($this->input->method() === 'post') {
            if ($this->form_validation->run() === TRUE) {
                $current_password = $this->input->post('current_password');
                $new_password = $this->input->post('new_password');

                if ($this->Admin_model->update_password($this->admin->id, $current_password, $new_password)) {
                    $this->session->set_flashdata('admin_success', 'Password updated successfully.');
                    redirect('profile');
                    return;
                }

                $this->session->set_flashdata('admin_error', 'Current password is incorrect.');
            }

            $this->render_admin('admin_profile/index', [
                'page_title' => 'My Profile',
                'active_nav' => 'profile',
                'admin_profile' => $this->admin,
            ]);
            return;
        }

        redirect('profile');
    }
}
