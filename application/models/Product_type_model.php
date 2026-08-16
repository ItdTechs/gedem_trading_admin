<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product_type_model extends CI_Model
{
    protected $table = 'product_types';

    public function get_all_by_category($category_id, $search = null)
    {
        $this->db->where('category_id', $category_id)->order_by('sort_order', 'ASC');

        if ($search) {
            $this->db->like('name', $search);
        }

        return $this->db->get($this->table)->result();
    }

    public function get_by_id($id)
    {
        $type = $this->db->where('id', $id)->get($this->table)->row();

        if ($type) {
            $type->items = $this->db
                ->where('product_type_id', $id)
                ->order_by('sort_order', 'ASC')
                ->get('product_type_items')
                ->result();
        }

        return $type;
    }

    /**
     * Same delete+reinsert sync strategy as Service_model::save() for
     * service_features — fine at this scale (a handful of bullet items
     * per product type).
     */
    public function save($data, $items, $id = null)
    {
        $this->db->trans_start();

        if ($id) {
            $this->db->where('id', $id)->update($this->table, $data);
        } else {
            $this->db->insert($this->table, $data);
            $id = $this->db->insert_id();
        }

        $this->db->where('product_type_id', $id)->delete('product_type_items');

        $sort = 1;
        foreach ($items as $item_name) {
            $item_name = trim($item_name);
            if ($item_name === '') continue;

            $this->db->insert('product_type_items', [
                'product_type_id' => $id,
                'item_name'       => $item_name,
                'sort_order'      => $sort++,
            ]);
        }

        $this->db->trans_complete();

        return $this->db->trans_status() ? $id : false;
    }

    public function delete($id)
    {
        // product_type_items has ON DELETE CASCADE, so this alone is enough.
        return $this->db->where('id', $id)->delete($this->table);
    }

    public function toggle_active($id)
    {
        $type = $this->db->where('id', $id)->get($this->table)->row();
        if (!$type) return false;

        return $this->db->where('id', $id)
            ->update($this->table, ['is_active' => $type->is_active ? 0 : 1]);
    }
}
