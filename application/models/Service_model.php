<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Service_model extends CI_Model
{
    protected $table = 'services';

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
        $service = $this->db->where('id', $id)->get($this->table)->row();

        if ($service) {
            $service->features = $this->db
                ->where('service_id', $id)
                ->order_by('sort_order', 'ASC')
                ->get('service_features')
                ->result();
        }

        return $service;
    }

    /**
     * Creates or updates a service AND replaces its feature list in one
     * transaction. $features is a plain array of strings from the form —
     * simplest possible sync strategy: delete old rows, insert the new set.
     * Fine at this scale (a handful of features per service); if this ever
     * needs to preserve feature IDs (e.g. for external references), switch
     * to a proper diff instead of delete+reinsert.
     */
    public function save($data, $features, $id = null)
    {
        $this->db->trans_start();

        if ($id) {
            $this->db->where('id', $id)->update($this->table, $data);
        } else {
            $this->db->insert($this->table, $data);
            $id = $this->db->insert_id();
        }

        $this->db->where('service_id', $id)->delete('service_features');

        $sort = 1;
        foreach ($features as $feature_text) {
            $feature_text = trim($feature_text);
            if ($feature_text === '') continue;

            $this->db->insert('service_features', [
                'service_id'   => $id,
                'feature_text' => $feature_text,
                'sort_order'   => $sort++,
            ]);
        }

        $this->db->trans_complete();

        return $this->db->trans_status() ? $id : false;
    }

    public function delete($id)
    {
        // service_features has ON DELETE CASCADE, so this alone is enough —
        // no orphaned feature rows left behind.
        return $this->db->where('id', $id)->delete($this->table);
    }

    public function toggle_active($id)
    {
        $service = $this->db->where('id', $id)->get($this->table)->row();
        if (!$service) return false;

        return $this->db->where('id', $id)
            ->update($this->table, ['is_active' => $service->is_active ? 0 : 1]);
    }
}
