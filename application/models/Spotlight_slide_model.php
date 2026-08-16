<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Spotlight_slide_model extends CI_Model
{
    protected $table = 'spotlight_slides';

    public function get_all($search = null)
    {
        $this->db->order_by('sort_order', 'ASC');

        if ($search) {
            $this->db->like('title', $search);
        }

        $slides = $this->db->get($this->table)->result();

        foreach ($slides as $slide) {
            $slide->highlights = $this->decode_highlights($slide->highlights);
        }

        return $slides;
    }

    public function get_by_id($id)
    {
        $slide = $this->db->where('id', $id)->get($this->table)->row();

        if ($slide) {
            $slide->highlights = $this->decode_highlights($slide->highlights);
        }

        return $slide;
    }

    /**
     * $highlights arrives as a plain array of strings from the form;
     * this is what turns it into the JSON the `highlights` column expects
     * (matches the JSON_ARRAY(...) format already used by the seed data).
     */
    public function save($data, $highlights, $id = null)
    {
        $clean = array_values(array_filter(array_map('trim', $highlights), fn($h) => $h !== ''));
        $data['highlights'] = json_encode($clean, JSON_UNESCAPED_UNICODE);

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
        $slide = $this->db->where('id', $id)->get($this->table)->row();
        if (!$slide) return false;

        return $this->db->where('id', $id)
            ->update($this->table, ['is_active' => $slide->is_active ? 0 : 1]);
    }

    private function decode_highlights($raw)
    {
        $decoded = json_decode($raw ?? '[]', true);
        return is_array($decoded) ? $decoded : [];
    }
}
