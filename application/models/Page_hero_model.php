<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Page_hero_model extends CI_Model
{
    protected $table = 'page_heroes';

    /**
     * The 6 pages that must have a hero row. Used to render the index
     * even if a row is somehow missing (fresh install, manual DB edit),
     * so the admin never hits a dead end — it just shows an "Not set up
     * yet" state for that page instead of omitting it from the list.
     */
    private $known_pages = [
        'home'     => 'Homepage',
        'about'    => 'About',
        'products' => 'Products',
        'services' => 'Services',
        'partners' => 'Partners',
        'contact'  => 'Contact',
    ];

    public function get_known_pages()
    {
        return $this->known_pages;
    }

    public function get_all()
    {
        $rows = $this->db->get($this->table)->result();
        $by_key = [];
        foreach ($rows as $row) {
            $by_key[$row->page_key] = $row;
        }
        return $by_key;
    }

    public function get_by_key($page_key)
    {
        return $this->db->where('page_key', $page_key)->get($this->table)->row();
    }

    /**
     * Upsert rather than plain update — if a page's row is missing
     * (e.g. a new page added to the site later without a matching
     * migration), saving the form still works instead of silently
     * doing nothing.
     */
    public function save($page_key, $data)
    {
        $existing = $this->get_by_key($page_key);

        if ($existing) {
            return $this->db->where('page_key', $page_key)->update($this->table, $data);
        }

        $data['page_key'] = $page_key;
        return $this->db->insert($this->table, $data);
    }
}
