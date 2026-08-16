<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Content_card_model extends CI_Model
{
    protected $table = 'content_cards';

    public function count_by_section($section_key)
    {
        return $this->db->where('section_key', $section_key)->count_all_results($this->table);
    }

    public function get_all_by_section($section_key, $search = null)
    {
        $this->db->where('section_key', $section_key)->order_by('sort_order', 'ASC');

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
        $card = $this->get_by_id($id);
        if (!$card) return false;

        return $this->db->where('id', $id)
            ->update($this->table, ['is_active' => $card->is_active ? 0 : 1]);
    }
}
