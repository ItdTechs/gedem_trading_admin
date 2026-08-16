<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Process_step_model extends CI_Model
{
    protected $table = 'process_steps';

    public function get_all($search = null)
    {
        $this->db->order_by('sort_order', 'ASC');

        if ($search) {
            $this->db->like('title', $search);
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
        $step = $this->get_by_id($id);
        if (!$step) return false;

        return $this->db->where('id', $id)
            ->update($this->table, ['is_active' => $step->is_active ? 0 : 1]);
    }
}
