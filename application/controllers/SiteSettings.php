<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SiteSettings extends MY_Admin_Controller
{
    /**
     * Every setting the form exposes, grouped for the UI. This list is
     * the source of truth for which keys the form can edit — a setting
     * added directly in the DB won't appear here until it's added to
     * this list too, which is intentional: it keeps the form from
     * growing an unbounded, unlabeled field for every stray key_value row.
     */
    private $groups = [
        'Company Info' => [
            'company_name' => ['label' => 'Company Name', 'rules' => 'required|max_length[150]'],
            'email'        => ['label' => 'Email', 'rules' => 'required|valid_email|max_length[150]'],
            'phone_primary'   => ['label' => 'Primary Phone', 'rules' => 'required|max_length[30]'],
            'phone_secondary' => ['label' => 'Secondary Phone', 'rules' => 'max_length[30]'],
            'address'      => ['label' => 'Address', 'rules' => 'required|max_length[255]'],
        ],
        'Business Hours' => [
            'hours_weekday'  => ['label' => 'Weekday Hours', 'rules' => 'max_length[100]'],
            'hours_saturday' => ['label' => 'Saturday Hours', 'rules' => 'max_length[100]'],
            'hours_sunday'   => ['label' => 'Sunday Hours', 'rules' => 'max_length[100]'],
        ],
        'Social Links' => [
            'social_facebook' => ['label' => 'Facebook URL', 'rules' => 'max_length[255]'],
            'social_linkedin' => ['label' => 'LinkedIn URL', 'rules' => 'max_length[255]'],
            'social_twitter'  => ['label' => 'Twitter / X URL', 'rules' => 'max_length[255]'],
            'social_telegram' => ['label' => 'Telegram URL', 'rules' => 'max_length[255]'],
            'social_whatsapp' => ['label' => 'WhatsApp URL', 'rules' => 'max_length[255]'],
        ],
        'Catalog' => [
            'catalog_pdf_url' => ['label' => 'Catalog PDF URL', 'rules' => 'max_length[255]'],
        ],
    ];

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Site_setting_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        foreach ($this->groups as $fields) {
            foreach ($fields as $key => $meta) {
                $this->form_validation->set_rules($key, $meta['label'], $meta['rules']);
            }
        }

        if ($this->input->method() === 'post' && $this->form_validation->run() === TRUE) {

            $data = [];
            foreach ($this->groups as $fields) {
                foreach ($fields as $key => $meta) {
                    $data[$key] = $this->input->post($key, TRUE);
                }
            }

            if ($this->Site_setting_model->save_all($data)) {
                $this->session->set_flashdata('admin_success', 'Site settings updated.');
                redirect('site-settings');
                return;
            }

            $this->session->set_flashdata('admin_error', 'Something went wrong saving that. Please try again.');
        }

        $values = $this->Site_setting_model->get_all_assoc();

        $this->render_admin('site_settings/index', [
            'page_title' => 'Site Settings',
            'active_nav' => 'site_settings',
            'groups'     => $this->groups,
            'values'     => $values,
        ]);
    }
}
