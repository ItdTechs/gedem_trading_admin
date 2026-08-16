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
}
