<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// Auto-load MY_Admin_Controller for admin routes
require_once APPPATH . 'core/MY_Admin_Controller.php';

class MY_Controller extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->enforce_canonical_url();
    }
    
    protected function enforce_canonical_url() {
        // Skip for CLI requests
        if (is_cli()) return;
        
        $current_url = (isset($_SERVER['HTTPS']) ? 'https://' : 'http://') . 
        $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        
        $canonical_url = $this->get_canonical_url();
        
        // Redirect if current URL doesn't match canonical
        if (rtrim($current_url, '/') != rtrim($canonical_url, '/')) {
            redirect($canonical_url, 'location', 301);
        }
    }
    
    protected function get_canonical_url() {
        $uri = $this->uri->uri_string();
        $base = rtrim($this->config->item('base_url'), '/');
        
        return empty($uri) ? $base.'/' : $base.'/'.$uri;
    }
}