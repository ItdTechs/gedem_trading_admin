<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Org_chart_node_model extends CI_Model
{
    protected $table = 'org_chart_nodes';

    /**
     * 'shareholder' and 'manager' are treated as singletons by this admin
     * even though the schema allows multiple rows per level — the public
     * org chart only ever renders one box for each. If more than one row
     * exists for a level (e.g. from manual DB edits), this returns the
     * first by sort_order and leaves the rest alone rather than deleting
     * anything automatically.
     */
    public function get_singleton($level)
    {
        return $this->db->where('level', $level)->order_by('sort_order', 'ASC')->limit(1)->get($this->table)->row();
    }

    public function save_singleton($level, $data, $id = null)
    {
        if ($id) {
            return $this->db->where('id', $id)->update($this->table, $data);
        }

        $data['level'] = $level;
        $data['sort_order'] = 1;
        return $this->db->insert($this->table, $data);
    }

    public function get_departments($search = null)
    {
        $this->db->where('level', 'department')->order_by('sort_order', 'ASC');

        if ($search) {
            $this->db->like('name', $search);
        }

        return $this->db->get($this->table)->result();
    }

    public function get_by_id($id)
    {
        return $this->db->where('id', $id)->get($this->table)->row();
    }

    public function save_department($data, $id = null)
    {
        $data['level'] = 'department';

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
        $node = $this->get_by_id($id);
        if (!$node) return false;

        return $this->db->where('id', $id)
            ->update($this->table, ['is_active' => $node->is_active ? 0 : 1]);
    }
}
