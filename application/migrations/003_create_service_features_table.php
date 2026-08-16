<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_service_features_table extends CI_Migration
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
            'service_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
                'null' => FALSE
            ],
            'feature_text' => [
                'type' => 'VARCHAR',
                'constraint' => 200,
                'null' => FALSE
            ],
            'sort_order' => [
                'type' => 'INT',
                'constraint' => 11,
                'default' => 10
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => FALSE,
                'default' => 'CURRENT_TIMESTAMP'
            ]
        ]);

        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->add_key('service_id');
        $this->dbforge->add_foreign_key('service_id', 'services', 'id', 'CASCADE', 'CASCADE');

        $this->dbforge->create_table('service_features', TRUE);
    }

    public function down()
    {
        $this->dbforge->drop_table('service_features', TRUE);
    }
}
