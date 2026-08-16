<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Testimonials extends MY_Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Testimonial_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $search = $this->input->get('q', TRUE);

        $this->render_admin('testimonials/index', [
            'page_title'   => 'Testimonials',
            'active_nav'   => 'testimonials',
            'testimonials' => $this->Testimonial_model->get_all($search),
            'search'       => $search,
        ]);
    }

    public function create()
    {
        $this->save_form();
    }

    public function edit($id)
    {
        $testimonial = $this->Testimonial_model->get_by_id($id);

        if (!$testimonial) {
            $this->session->set_flashdata('admin_error', 'Testimonial not found.');
            redirect('testimonials');
            return;
        }

        $this->save_form($testimonial);
    }

    private function save_form($testimonial = null)
    {
        $this->form_validation->set_rules('quote', 'Quote', 'required');
        $this->form_validation->set_rules('author_name', 'Author / Label', 'required|max_length[150]');
        $this->form_validation->set_rules('sort_order', 'Sort Order', 'required|integer');

        if ($this->input->method() === 'post' && $this->form_validation->run() === TRUE) {

            $data = [
                'quote'       => $this->input->post('quote', TRUE),
                'author_name' => $this->input->post('author_name', TRUE),
                'sort_order'  => (int) $this->input->post('sort_order'),
                'is_active'   => $this->input->post('is_active') ? 1 : 0,
            ];

            $id = $this->Testimonial_model->save($data, $testimonial->id ?? null);

            if ($id) {
                $this->session->set_flashdata('admin_success',
                    $testimonial ? 'Testimonial updated.' : 'Testimonial created.');
                redirect('testimonials');
                return;
            }

            $this->session->set_flashdata('admin_error', 'Something went wrong saving that. Please try again.');
        }

        $this->render_admin('testimonials/form', [
            'page_title'  => $testimonial ? 'Edit Testimonial' : 'New Testimonial',
            'active_nav'  => 'testimonials',
            'testimonial' => $testimonial,
        ]);
    }

    public function delete($id)
    {
        $this->require_admin_role();

        $testimonial = $this->Testimonial_model->get_by_id($id);

        if (!$testimonial) {
            $this->session->set_flashdata('admin_error', 'Testimonial not found.');
        } else {
            $this->Testimonial_model->delete($id);
            $this->session->set_flashdata('admin_success', 'Testimonial deleted.');
        }

        redirect('testimonials');
    }

    public function toggle($id)
    {
        $this->Testimonial_model->toggle_active($id);
        redirect('testimonials');
    }
}
