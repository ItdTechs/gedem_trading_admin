<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_services_table extends CI_Migration
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
            'title' => [
                'type' => 'VARCHAR',
                'constraint' => 150,
                'null' => FALSE
            ],
            'description' => [
                'type' => 'TEXT',
                'null' => FALSE
            ],
            'sort_order' => [
                'type' => 'INT',
                'constraint' => 11,
                'default' => 10
            ],
            'is_active' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 1
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
        $this->dbforge->add_key('is_active');

        $this->dbforge->create_table('services', TRUE);
    }

    public function down()
    {
        $this->dbforge->drop_table('services', TRUE);
    }
}
