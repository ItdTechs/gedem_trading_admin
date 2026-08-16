<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ProductCategories extends MY_Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Product_category_model');
        $this->load->library('form_validation');
        $this->form_validation->set_message('check_slug_unique', 'That slug is already used by another category.');
    }

    public function index()
    {
        $search = $this->input->get('q', TRUE);

        $this->render_admin('product_categories/index', [
            'page_title' => 'Product Categories',
            'active_nav' => 'products',
            'categories' => $this->Product_category_model->get_all($search),
            'search'     => $search,
        ]);
    }

    public function create()
    {
        $this->save_form();
    }

    public function edit($id)
    {
        $category = $this->Product_category_model->get_by_id($id);

        if (!$category) {
            $this->session->set_flashdata('admin_error', 'Category not found.');
            redirect('products');
            return;
        }

        $this->save_form($category);
    }

    private function save_form($category = null)
    {
        $this->form_validation->set_rules('name', 'Name', 'required|max_length[150]');
        $this->form_validation->set_rules(
            'slug', 'Slug',
            'required|max_length[120]|regex_match[/^[a-z0-9\-]+$/]|callback_check_slug_unique[' . ($category->id ?? 0) . ']'
        );
        $this->form_validation->set_rules('description', 'Description', 'max_length[500]');
        $this->form_validation->set_rules('sort_order', 'Sort Order', 'required|integer');

        if ($this->input->method() === 'post' && $this->form_validation->run() === TRUE) {

            $data = [
                'name'        => $this->input->post('name', TRUE),
                'slug'        => $this->input->post('slug', TRUE),
                'description' => $this->input->post('description', TRUE),
                'sort_order'  => (int) $this->input->post('sort_order'),
                'is_active'   => $this->input->post('is_active') ? 1 : 0,
            ];

            $id = $this->Product_category_model->save($data, $category->id ?? null);

            if ($id) {
                $this->session->set_flashdata('admin_success',
                    $category ? 'Category updated.' : 'Category created.');
                redirect('products');
                return;
            }

            $this->session->set_flashdata('admin_error', 'Something went wrong saving that. Please try again.');
        }

        $this->render_admin('product_categories/form', [
            'page_title' => $category ? 'Edit Category' : 'New Category',
            'active_nav' => 'products',
            'category'   => $category,
        ]);
    }

    public function delete($id)
    {
        $this->require_admin_role();

        $category = $this->Product_category_model->get_by_id($id);

        if (!$category) {
            $this->session->set_flashdata('admin_error', 'Category not found.');
        } else {
            $this->Product_category_model->delete($id);
            $this->session->set_flashdata('admin_success',
                'Category deleted, along with its product types and their items.');
        }

        redirect('products');
    }

    public function toggle($id)
    {
        $this->Product_category_model->toggle_active($id);
        redirect('products');
    }

    /**
     * form_validation callback: slug must be unique across product_categories,
     * excluding the row currently being edited (passed in as $exclude_id).
     */
    public function check_slug_unique($slug, $exclude_id)
    {
        $exclude_id = (int) $exclude_id ?: null;
        $existing = $this->Product_category_model->get_by_slug($slug, $exclude_id);
        return $existing === null;
    }
}
