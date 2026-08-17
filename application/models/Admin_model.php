<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_model extends CI_Model
{
    protected $table = 'admin_users';

    public function __construct()
    {
        $this->load->database();
    }

    public function get_by_email($email)
    {
        return $this->db->where('email', $email)->get($this->table)->row();
    }

    public function get_by_id($id)
    {
        return $this->db->where('id', $id)->get($this->table)->row();
    }

    /**
     * Returns the admin row on success, or false on failure.
     * Never leaks whether it was the email or the password that was wrong.
     */
    public function attempt_login($email, $password)
    {
        $admin = $this->get_by_email($email);

        if (!$admin || !$admin->is_active) {
            return false;
        }

        if (!password_verify($password, $admin->password_hash)) {
            return false;
        }

        $this->db->where('id', $admin->id)
                 ->update($this->table, ['last_login_at' => date('Y-m-d H:i:s')]);

        return $admin;
    }

    /**
     * Helper for creating admin users (run once via CLI/seed, or from a
     * future "manage admins" screen restricted to role='admin').
     */
    public function create($name, $email, $password, $role = 'editor')
    {
        return $this->db->insert($this->table, [
            'name'          => $name,
            'email'         => $email,
            'password_hash' => password_hash($password, PASSWORD_BCRYPT),
            'role'          => $role,
            'is_active'     => 1,
        ]);
    }

    public function email_exists($email, $exclude_id = null)
    {
        $this->db->where('email', strtolower(trim($email)));

        if ($exclude_id !== null) {
            $this->db->where('id !=', (int) $exclude_id);
        }

        return $this->db->get($this->table)->num_rows() > 0;
    }

    public function update_profile($id, $name, $email)
    {
        if ($this->email_exists($email, $id)) {
            return false;
        }

        return $this->db->where('id', (int) $id)
                        ->update($this->table, [
                            'name' => trim($name),
                            'email' => strtolower(trim($email)),
                        ]);
    }

    public function update_password($id, $current_password, $new_password)
    {
        $admin = $this->get_by_id((int) $id);

        if (!$admin || !password_verify($current_password, $admin->password_hash)) {
            return false;
        }

        return $this->db->where('id', (int) $id)
                        ->update($this->table, [
                            'password_hash' => password_hash($new_password, PASSWORD_BCRYPT),
                        ]);
    }
}
