<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SpotlightSlides extends MY_Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Spotlight_slide_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $search = $this->input->get('q', TRUE);

        $this->render_admin('spotlight_slides/index', [
            'page_title' => 'Homepage Spotlight',
            'active_nav' => 'spotlight_slides',
            'slides'     => $this->Spotlight_slide_model->get_all($search),
            'search'     => $search,
        ]);
    }

    public function create()
    {
        $this->save_form();
    }

    public function edit($id)
    {
        $slide = $this->Spotlight_slide_model->get_by_id($id);

        if (!$slide) {
            $this->session->set_flashdata('admin_error', 'Slide not found.');
            redirect('spotlight-slides');
            return;
        }

        $this->save_form($slide);
    }

    private function save_form($slide = null)
    {
        $this->form_validation->set_rules('title', 'Title', 'required|max_length[150]');
        $this->form_validation->set_rules('quote', 'Quote', 'required');
        $this->form_validation->set_rules('location', 'Location', 'max_length[150]');
        $this->form_validation->set_rules('image', 'Image Path', 'required|max_length[255]');
        $this->form_validation->set_rules('sort_order', 'Sort Order', 'required|integer');

        if ($this->input->method() === 'post' && $this->form_validation->run() === TRUE) {

            $data = [
                'title'       => $this->input->post('title', TRUE),
                'quote'       => $this->input->post('quote', TRUE),
                'location'    => $this->input->post('location', TRUE) ?: '📍 Addis Ababa, Ethiopia',
                'image'       => $this->input->post('image', TRUE),
                'sort_order'  => (int) $this->input->post('sort_order'),
                'is_active'   => $this->input->post('is_active') ? 1 : 0,
            ];

            $highlights = $this->input->post('highlights') ?: [];

            $id = $this->Spotlight_slide_model->save($data, $highlights, $slide->id ?? null);

            if ($id) {
                $this->session->set_flashdata('admin_success', $slide ? 'Slide updated.' : 'Slide created.');
                redirect('spotlight-slides');
                return;
            }

            $this->session->set_flashdata('admin_error', 'Something went wrong saving that. Please try again.');
        }

        $this->render_admin('spotlight_slides/form', [
            'page_title' => $slide ? 'Edit Slide' : 'New Slide',
            'active_nav' => 'spotlight_slides',
            'slide'      => $slide,
        ]);
    }

    public function delete($id)
    {
        $this->require_admin_role();

        $slide = $this->Spotlight_slide_model->get_by_id($id);

        if (!$slide) {
            $this->session->set_flashdata('admin_error', 'Slide not found.');
        } else {
            $this->Spotlight_slide_model->delete($id);
            $this->session->set_flashdata('admin_success', 'Slide deleted.');
        }

        redirect('spotlight-slides');
    }

    public function toggle($id)
    {
        $this->Spotlight_slide_model->toggle_active($id);
        redirect('spotlight-slides');
    }
}
