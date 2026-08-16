<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Site_setting_model extends CI_Model
{
    protected $table = 'site_settings';

    /**
     * Returns every setting as a flat [key => value] map, which is what
     * the single settings form is built around. Any key the form knows
     * about that isn't in the DB yet just comes back as an empty string
     * rather than breaking the page.
     */
    public function get_all_assoc()
    {
        $rows = $this->db->get($this->table)->result();
        $map = [];
        foreach ($rows as $row) {
            $map[$row->setting_key] = $row->setting_value;
        }
        return $map;
    }

    /**
     * $data is [setting_key => setting_value, ...]. Upserts each key —
     * settings rows are seeded already, but this doesn't assume that,
     * so a key added to the form later that isn't in the DB yet still
     * saves correctly on first submit.
     */
    public function save_all($data)
    {
        $this->db->trans_start();

        foreach ($data as $key => $value) {
            $exists = $this->db->where('setting_key', $key)->get($this->table)->row();

            if ($exists) {
                $this->db->where('setting_key', $key)->update($this->table, ['setting_value' => $value]);
            } else {
                $this->db->insert($this->table, ['setting_key' => $key, 'setting_value' => $value]);
            }
        }

        $this->db->trans_complete();

        return $this->db->trans_status();
    }
}
