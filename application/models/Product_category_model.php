<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product_category_model extends CI_Model
{
    protected $table = 'product_categories';

    public function get_all($search = null)
    {
        $this->db->order_by('sort_order', 'ASC');

        if ($search) {
            $this->db->like('name', $search);
        }

        $categories = $this->db->get($this->table)->result();

        // Attach a type count per category so the index list can show it
        // without a query-per-row in the view.
        foreach ($categories as $cat) {
            $cat->type_count = $this->db
                ->where('category_id', $cat->id)
                ->count_all_results('product_types');
        }

        return $categories;
    }

    public function get_by_id($id)
    {
        return $this->db->where('id', $id)->get($this->table)->row();
    }

    public function get_by_slug($slug, $exclude_id = null)
    {
        $this->db->where('slug', $slug);
        if ($exclude_id) {
            $this->db->where('id !=', $exclude_id);
        }
        return $this->db->get($this->table)->row();
    }

    public function save($data, $id = null)
    {
        if ($id) {
            $this->db->where('id', $id)->update($this->table, $data);
            return $id;
        }

        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    /**
     * Deleting a category cascades to its product_types (FK ON DELETE
     * CASCADE), which in turn cascades to product_type_items. No manual
     * cleanup needed here.
     */
    public function delete($id)
    {
        return $this->db->where('id', $id)->delete($this->table);
    }

    public function toggle_active($id)
    {
        $cat = $this->get_by_id($id);
        if (!$cat) return false;

        return $this->db->where('id', $id)
            ->update($this->table, ['is_active' => $cat->is_active ? 0 : 1]);
    }
}
