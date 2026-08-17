<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Contact_message_model extends CI_Model
{
    protected $table = 'contact_messages';

    public function get_all($status_filter = null, $search = null)
    {
        $this->db->order_by('created_at', 'DESC');

        if ($status_filter) {
            $this->db->where('status', $status_filter);
        }

        if ($search) {
            $this->db->group_start()
                ->like('first_name', $search)
                ->or_like('last_name', $search)
                ->or_like('email', $search)
                ->or_like('subject', $search)
                ->group_end();
        }

        return $this->db->get($this->table)->result();
    }

    public function get_by_id($id)
    {
        return $this->db->where('id', $id)->get($this->table)->row();
    }

    public function count_by_status($status)
    {
        return $this->db->where('status', $status)->count_all_results($this->table);
    }

    public function update_status($id, $status)
    {
        return $this->db->where('id', $id)->update($this->table, ['status' => $status]);
    }

    /**
     * Called when an admin opens a message that's still 'new' — moves it
     * to 'read' automatically, same as most inboxes. Does nothing if the
     * message is already 'read' or 'closed', so opening a closed message
     * to double check something doesn't silently reopen it.
     */
    public function mark_read_if_new($id)
    {
        $message = $this->get_by_id($id);
        if ($message && $message->status === 'new') {
            $this->update_status($id, 'read');
        }
    }

    public function delete($id)
    {
        return $this->db->where('id', $id)->delete($this->table);
    }
}
