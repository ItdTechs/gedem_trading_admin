<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Dashboard Controller
 *
 * Main admin dashboard - displays overview and statistics.
 * Requires admin authentication via Admin_Controller.
 */
class Dashboard extends MY_Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Service_model');
    }

    /**
     * Main dashboard page
     */
    public function index()
    {
        // Gather dashboard statistics
        $data = [
            'page_title'   => 'Dashboard',
            'active_nav'   => 'dashboard',
            'total_services'    => count($this->Service_model->get_all()),
            // Add more stats as needed
        ];

        $this->render_admin('dashboard/index', $data);
    }
}
