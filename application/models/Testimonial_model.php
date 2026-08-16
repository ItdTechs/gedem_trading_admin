<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Testimonial_model extends CI_Model
{
    protected $table = 'testimonials';

    public function get_all($search = null)
    {
        $this->db->order_by('sort_order', 'ASC');

        if ($search) {
            $this->db->group_start()
                ->like('quote', $search)
                ->or_like('author_name', $search)
                ->group_end();
        }

        return $this->db->get($this->table)->result();
    }

    public function get_by_id($id)
    {
        return $this->db->where('id', $id)->get($this->table)->row();
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

    public function delete($id)
    {
        return $this->db->where('id', $id)->delete($this->table);
    }

    public function toggle_active($id)
    {
        $t = $this->get_by_id($id);
        if (!$t) return false;

        return $this->db->where('id', $id)
            ->update($this->table, ['is_active' => $t->is_active ? 0 : 1]);
    }
}
