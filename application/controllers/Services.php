<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Services extends MY_Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Service_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $search = $this->input->get('q', TRUE);

        $this->render_admin('services/index', [
            'page_title'  => 'Services',
            'active_nav'  => 'services',
            'services'    => $this->Service_model->get_all($search),
            'search'      => $search,
        ]);
    }

    public function create()
    {
        $this->save_form();
    }

    public function edit($id)
    {
        $service = $this->Service_model->get_by_id($id);

        if (!$service) {
            $this->session->set_flashdata('admin_error', 'Service not found.');
            redirect('services');
            return;
        }

        $this->save_form($service);
    }
    
    private function save_form($service = null)
    {
        $this->form_validation->set_rules('title', 'Title', 'required|max_length[150]');
        $this->form_validation->set_rules('description', 'Description', 'required|max_length[500]');
        $this->form_validation->set_rules('sort_order', 'Sort Order', 'required|integer');

        if ($this->input->method() === 'post' && $this->form_validation->run() === TRUE) {

            $data = [
                'title'       => $this->input->post('title', TRUE),
                'description' => $this->input->post('description', TRUE),
                'sort_order'  => (int) $this->input->post('sort_order'),
                'is_active'   => $this->input->post('is_active') ? 1 : 0,
            ];

            $features = $this->input->post('features') ?: [];

            $id = $this->Service_model->save($data, $features, $service->id ?? null);

            if ($id) {
                $this->session->set_flashdata('admin_success',
                    $service ? 'Service updated.' : 'Service created.');
                redirect('services');
                return;
            }

            $this->session->set_flashdata('admin_error', 'Something went wrong saving that. Please try again.');
        }

        $this->render_admin('services/form', [
            'page_title' => $service ? 'Edit Service' : 'New Service',
            'active_nav' => 'services',
            'service'    => $service,
        ]);
    }

    public function delete($id)
    {
        $this->require_admin_role();

        $service = $this->Service_model->get_by_id($id);

        if (!$service) {
            $this->session->set_flashdata('admin_error', 'Service not found.');
        } else {
            $this->Service_model->delete($id);
            $this->session->set_flashdata('admin_success', 'Service deleted.');
        }

        redirect('services');
    }

    public function toggle($id)
    {
        $this->Service_model->toggle_active($id);
        redirect('services');
    }
}
