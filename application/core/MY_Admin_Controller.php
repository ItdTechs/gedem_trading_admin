<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * MY_Admin_Controller
 *
 * Every * controller extends this instead of MY_Controller directly.
 * It enforces a valid session before anything else runs, and makes the
 * logged-in admin available to every admin controller/view as $this->admin.
 *
 * If you're adding a new resource (e.g. Products), your new controller is:
 *
 *   class Products extends MY_Admin_Controller { ... }
 *
 * — auth is already handled, you never re-check it per-controller.
 */
class MY_Admin_Controller extends MY_Controller
{
    protected $admin; // holds the logged-in admin_users row

    public function __construct()
    {
        parent::__construct();

        $this->load->library('session');
        $this->load->helper('form');
        $this->load->model('Admin_model');

        $admin_id = $this->session->userdata('admin_id');

        if (!$admin_id) {
            // Remember where they were headed so login can send them back.
            $this->session->set_userdata('redirect_after_login', current_url());
            $this->session->set_flashdata('admin_error', 'Please log in to continue.');
            redirect('login');
            return;
        }

        $this->admin = $this->Admin_model->get_by_id($admin_id);

        if (!$this->admin || !$this->admin->is_active) {
            $this->session->sess_destroy();
            redirect('login');
            return;
        }
    }

    /**
     * Call this at the top of any controller method that deletes data.
     * Editors can create/edit but not delete.
     */
    protected function require_admin_role()
    {
        if ($this->admin->role !== 'admin') {
            $this->session->set_flashdata('admin_error', 'Only admins can do that.');
            redirect($_SERVER['HTTP_REFERER'] ?? 'dashboard');
            exit;
        }
    }

    /**
     * Shared render helper so every admin page loads the sidebar/topbar
     * shell the same way, with the same standard variables available.
     */
    protected function render_admin($view, $data = [])
    {
        $data['admin']          = $this->admin;
        $data['flash_success']  = $this->session->flashdata('admin_success');
        $data['flash_error']    = $this->session->flashdata('admin_error');

        $this->load->view('layout/base', array_merge($data, [
            'inner_view' => $view,
            'inner_data' => $data,
        ]));
    }
}
