<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class OrgChart extends MY_Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Org_chart_node_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $this->render_admin('org_chart/index', [
            'page_title'   => 'Organizational Structure',
            'active_nav'   => 'org_chart',
            'shareholder'  => $this->Org_chart_node_model->get_singleton('shareholder'),
            'manager'      => $this->Org_chart_node_model->get_singleton('manager'),
            'departments'  => $this->Org_chart_node_model->get_departments(),
        ]);
    }

    public function edit_shareholder()
    {
        $this->save_singleton_form('shareholder', 'Sole Shareholder');
    }

    public function edit_manager()
    {
        $this->save_singleton_form('manager', 'General Manager');
    }

    private function save_singleton_form($level, $label)
    {
        $node = $this->Org_chart_node_model->get_singleton($level);

        $this->form_validation->set_rules('name', 'Name', 'required|max_length[150]');
        $this->form_validation->set_rules('sub_title', 'Sub Title', 'max_length[150]');

        if ($this->input->method() === 'post' && $this->form_validation->run() === TRUE) {

            $data = [
                'name'      => $this->input->post('name', TRUE),
                'sub_title' => $this->input->post('sub_title', TRUE),
                'is_active' => $this->input->post('is_active') ? 1 : 0,
            ];

            $this->Org_chart_node_model->save_singleton($level, $data, $node->id ?? null);
            $this->session->set_flashdata('admin_success', $label . ' updated.');
            redirect('org-chart');
            return;
        }

        $this->render_admin('org_chart/singleton_form', [
            'page_title' => 'Edit ' . $label,
            'active_nav' => 'org_chart',
            'level'      => $level,
            'label'      => $label,
            'node'       => $node,
        ]);
    }

    public function create_department()
    {
        $this->save_department_form();
    }

    public function edit_department($id)
    {
        $node = $this->Org_chart_node_model->get_by_id($id);

        if (!$node || $node->level !== 'department') {
            $this->session->set_flashdata('admin_error', 'Department not found.');
            redirect('org-chart');
            return;
        }

        $this->save_department_form($node);
    }

    private function save_department_form($node = null)
    {
        $this->form_validation->set_rules('name', 'Department Name', 'required|max_length[150]');
        $this->form_validation->set_rules('sub_title', 'Sub Title', 'max_length[150]');
        $this->form_validation->set_rules('sort_order', 'Sort Order', 'required|integer');

        if ($this->input->method() === 'post' && $this->form_validation->run() === TRUE) {

            $data = [
                'name'       => $this->input->post('name', TRUE),
                'sub_title'  => $this->input->post('sub_title', TRUE),
                'sort_order' => (int) $this->input->post('sort_order'),
                'is_active'  => $this->input->post('is_active') ? 1 : 0,
            ];

            $id = $this->Org_chart_node_model->save_department($data, $node->id ?? null);

            if ($id) {
                $this->session->set_flashdata('admin_success', $node ? 'Department updated.' : 'Department added.');
                redirect('org-chart');
                return;
            }

            $this->session->set_flashdata('admin_error', 'Something went wrong saving that. Please try again.');
        }

        $this->render_admin('org_chart/department_form', [
            'page_title' => $node ? 'Edit Department' : 'New Department',
            'active_nav' => 'org_chart',
            'node'       => $node,
        ]);
    }

    public function delete_department($id)
    {
        $this->require_admin_role();

        $node = $this->Org_chart_node_model->get_by_id($id);

        if (!$node || $node->level !== 'department') {
            $this->session->set_flashdata('admin_error', 'Department not found.');
        } else {
            $this->Org_chart_node_model->delete($id);
            $this->session->set_flashdata('admin_success', 'Department deleted.');
        }

        redirect('org-chart');
    }

    public function toggle_department($id)
    {
        $this->Org_chart_node_model->toggle_active($id);
        redirect('org-chart');
    }
}
