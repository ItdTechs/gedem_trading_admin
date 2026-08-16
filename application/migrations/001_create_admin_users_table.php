<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_admin_users_table extends CI_Migration
{
    public function up()
    {
        $this->dbforge->add_field([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => FALSE
            ],
            'email' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => FALSE
            ],
            'password_hash' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => FALSE
            ],
            'role' => [
                'type' => 'ENUM',
                'constraint' => ['admin', 'editor'],
                'default' => 'editor'
            ],
            'is_active' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 1
            ],
            'last_login_at' => [
                'type' => 'DATETIME',
                'null' => TRUE
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => FALSE,
                'default' => 'CURRENT_TIMESTAMP'
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => FALSE,
                'default' => 'CURRENT_TIMESTAMP',
                'on_update' => 'CURRENT_TIMESTAMP'
            ]
        ]);

        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->add_key('email');
        $this->dbforge->add_key('is_active');

        $this->dbforge->create_table('admin_users', TRUE);
    }

    public function down()
    {
        $this->dbforge->drop_table('admin_users', TRUE);
    }
}
