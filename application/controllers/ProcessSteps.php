<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ProcessSteps extends MY_Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Process_step_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $search = $this->input->get('q', TRUE);

        $this->render_admin('process_steps/index', [
            'page_title' => 'How We Work — Process Steps',
            'active_nav' => 'process_steps',
            'steps'      => $this->Process_step_model->get_all($search),
            'search'     => $search,
        ]);
    }

    public function create()
    {
        $this->save_form();
    }

    public function edit($id)
    {
        $step = $this->Process_step_model->get_by_id($id);

        if (!$step) {
            $this->session->set_flashdata('admin_error', 'Step not found.');
            redirect('process-steps');
            return;
        }

        $this->save_form($step);
    }

    private function save_form($step = null)
    {
        $this->form_validation->set_rules('step_number', 'Step Number', 'required|integer|greater_than[0]|less_than[256]');
        $this->form_validation->set_rules('title', 'Title', 'required|max_length[100]');
        $this->form_validation->set_rules('description', 'Description', 'required|max_length[200]');
        $this->form_validation->set_rules('sort_order', 'Sort Order', 'required|integer');

        if ($this->input->method() === 'post' && $this->form_validation->run() === TRUE) {

            $data = [
                'step_number' => (int) $this->input->post('step_number'),
                'title'       => $this->input->post('title', TRUE),
                'description' => $this->input->post('description', TRUE),
                'sort_order'  => (int) $this->input->post('sort_order'),
                'is_active'   => $this->input->post('is_active') ? 1 : 0,
            ];

            $id = $this->Process_step_model->save($data, $step->id ?? null);

            if ($id) {
                $this->session->set_flashdata('admin_success', $step ? 'Step updated.' : 'Step created.');
                redirect('process-steps');
                return;
            }

            $this->session->set_flashdata('admin_error', 'Something went wrong saving that. Please try again.');
        }

        $this->render_admin('process_steps/form', [
            'page_title' => $step ? 'Edit Step' : 'New Step',
            'active_nav' => 'process_steps',
            'step'       => $step,
        ]);
    }

    public function delete($id)
    {
        $this->require_admin_role();

        $step = $this->Process_step_model->get_by_id($id);

        if (!$step) {
            $this->session->set_flashdata('admin_error', 'Step not found.');
        } else {
            $this->Process_step_model->delete($id);
            $this->session->set_flashdata('admin_success', 'Step deleted.');
        }

        redirect('process-steps');
    }

    public function toggle($id)
    {
        $this->Process_step_model->toggle_active($id);
        redirect('process-steps');
    }
}
