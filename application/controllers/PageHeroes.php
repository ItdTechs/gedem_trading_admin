<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PageHeroes extends MY_Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Page_hero_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $known = $this->Page_hero_model->get_known_pages();
        $existing = $this->Page_hero_model->get_all();

        $rows = [];
        foreach ($known as $key => $label) {
            $rows[] = [
                'key'   => $key,
                'label' => $label,
                'hero'  => $existing[$key] ?? null,
            ];
        }

        $this->render_admin('page_heroes/index', [
            'page_title' => 'Page Heroes',
            'active_nav' => 'page_heroes',
            'rows'       => $rows,
        ]);
    }

    public function edit($page_key)
    {
        $known = $this->Page_hero_model->get_known_pages();

        if (!isset($known[$page_key])) {
            show_404();
        }

        $hero = $this->Page_hero_model->get_by_key($page_key);

        $this->form_validation->set_rules('heading', 'Heading', 'required|max_length[200]');
        $this->form_validation->set_rules('subtext', 'Subtext', 'max_length[500]');
        $this->form_validation->set_rules('image', 'Image Path', 'required|max_length[255]');

        if ($this->input->method() === 'post' && $this->form_validation->run() === TRUE) {

            $data = [
                'heading' => $this->input->post('heading', TRUE),
                'subtext' => $this->input->post('subtext', TRUE),
                'image'   => $this->input->post('image', TRUE),
            ];

            if ($this->Page_hero_model->save($page_key, $data)) {
                $this->session->set_flashdata('admin_success', $known[$page_key] . ' hero updated.');
                redirect('page-heroes');
                return;
            }

            $this->session->set_flashdata('admin_error', 'Something went wrong saving that. Please try again.');
        }

        $this->render_admin('page_heroes/form', [
            'page_title' => 'Edit Hero — ' . $known[$page_key],
            'active_nav' => 'page_heroes',
            'page_key'   => $page_key,
            'page_label' => $known[$page_key],
            'hero'       => $hero,
        ]);
    }
}
