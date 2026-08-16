<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ProductTypes extends MY_Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Product_type_model');
        $this->load->model('Product_category_model');
        $this->load->library('form_validation');
    }

    public function index($category_id)
    {
        $category = $this->Product_category_model->get_by_id($category_id);

        if (!$category) {
            $this->session->set_flashdata('admin_error', 'Category not found.');
            redirect('products');
            return;
        }

        $search = $this->input->get('q', TRUE);

        $this->render_admin('product_types/index', [
            'page_title' => $category->name . ' — Product Types',
            'breadcrumb' => 'Product Categories / ' . $category->name,
            'active_nav' => 'products',
            'category'   => $category,
            'types'      => $this->Product_type_model->get_all_by_category($category_id, $search),
            'search'     => $search,
        ]);
    }

    public function create($category_id)
    {
        $category = $this->Product_category_model->get_by_id($category_id);

        if (!$category) {
            $this->session->set_flashdata('admin_error', 'Category not found.');
            redirect('products');
            return;
        }

        $this->save_form($category);
    }

    public function edit($id)
    {
        $type = $this->Product_type_model->get_by_id($id);

        if (!$type) {
            $this->session->set_flashdata('admin_error', 'Product type not found.');
            redirect('products');
            return;
        }

        $category = $this->Product_category_model->get_by_id($type->category_id);
        $this->save_form($category, $type);
    }

    private function save_form($category, $type = null)
    {
        $this->form_validation->set_rules('name', 'Name', 'required|max_length[150]');
        $this->form_validation->set_rules('description', 'Description', 'max_length[500]');
        $this->form_validation->set_rules('badge_text', 'Badge Text', 'max_length[100]');
        $this->form_validation->set_rules('sort_order', 'Sort Order', 'required|integer');

        if ($this->input->method() === 'post' && $this->form_validation->run() === TRUE) {

            $data = [
                'category_id' => $category->id,
                'name'        => $this->input->post('name', TRUE),
                'description' => $this->input->post('description', TRUE),
                'badge_text'  => $this->input->post('badge_text', TRUE),
                'sort_order'  => (int) $this->input->post('sort_order'),
                'is_active'   => $this->input->post('is_active') ? 1 : 0,
            ];

            $items = $this->input->post('items') ?: [];

            $id = $this->Product_type_model->save($data, $items, $type->id ?? null);

            if ($id) {
                $this->session->set_flashdata('admin_success',
                    $type ? 'Product type updated.' : 'Product type created.');
                redirect('products/types/' . $category->id);
                return;
            }

            $this->session->set_flashdata('admin_error', 'Something went wrong saving that. Please try again.');
        }

        $this->render_admin('product_types/form', [
            'page_title' => $type ? 'Edit Product Type' : 'New Product Type',
            'breadcrumb' => 'Product Categories / ' . $category->name,
            'active_nav' => 'products',
            'category'   => $category,
            'type'       => $type,
        ]);
    }

    public function delete($id)
    {
        $this->require_admin_role();

        $type = $this->Product_type_model->get_by_id($id);

        if (!$type) {
            $this->session->set_flashdata('admin_error', 'Product type not found.');
            redirect('products');
            return;
        }

        $category_id = $type->category_id;
        $this->Product_type_model->delete($id);
        $this->session->set_flashdata('admin_success', 'Product type deleted, along with its item list.');
        redirect('products/types/' . $category_id);
    }

    public function toggle($id)
    {
        $type = $this->Product_type_model->get_by_id($id);
        if (!$type) {
            redirect('products');
            return;
        }

        $this->Product_type_model->toggle_active($id);
        redirect('products/types/' . $type->category_id);
    }
}
