<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ContentCards extends MY_Admin_Controller
{
    /**
     * Whitelist of valid section_key values and what they mean. Anything
     * not in this list 404s rather than silently creating a new "section"
     * by typo — content_cards has no FK to enforce this at the DB level,
     * so the controller is where that gets enforced.
     */
    private $sections = [
        'home_stats'         => ['label' => 'Homepage Stats',                'hint' => 'The 4 "Trusted / Reliable / Affordable / Professional" cards on the homepage.'],
        'expertise'          => ['label' => 'Expertise Tags',                'hint' => 'About page tag list. Title only — description is not shown for this section.'],
        'milestones'         => ['label' => 'Our Journey / Milestones',      'hint' => 'About page timeline. Use Meta Label for a year if you want one shown.'],
        'core_values'        => ['label' => 'Core Values',                   'hint' => 'About page core values grid.'],
        'partner_benefits'   => ['label' => 'Partner Benefits',              'hint' => 'Partners page — top 3 benefit cards.'],
        'why_partner'        => ['label' => 'Why Partner With Us',           'hint' => 'Partners page — 6 reason cards.'],
        'audience_segments'  => ['label' => 'Who We Serve',                  'hint' => 'Services page — 6 audience cards.'],
    ];

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Content_card_model');
        $this->load->library('form_validation');
    }

    /**
     * Landing page: all 7 sections with their card counts, linking into
     * each one's own list.
     */
    public function overview()
    {
        $rows = [];
        foreach ($this->sections as $key => $meta) {
            $rows[] = [
                'key'   => $key,
                'label' => $meta['label'],
                'hint'  => $meta['hint'],
                'count' => $this->Content_card_model->count_by_section($key),
            ];
        }

        $this->render_admin('content_cards/overview', [
            'page_title' => 'Content Cards',
            'active_nav' => 'content_cards',
            'sections'   => $rows,
        ]);
    }

    public function index($section_key)
    {
        $this->require_valid_section($section_key);

        $search = $this->input->get('q', TRUE);

        $this->render_admin('content_cards/index', [
            'page_title'  => $this->sections[$section_key]['label'],
            'breadcrumb'  => 'Content Cards / ' . $this->sections[$section_key]['label'],
            'active_nav'  => 'content_cards',
            'section_key' => $section_key,
            'section'     => $this->sections[$section_key],
            'cards'       => $this->Content_card_model->get_all_by_section($section_key, $search),
            'search'      => $search,
        ]);
    }

    public function create($section_key)
    {
        $this->require_valid_section($section_key);
        $this->save_form($section_key);
    }

    public function edit($id)
    {
        $card = $this->Content_card_model->get_by_id($id);

        if (!$card) {
            $this->session->set_flashdata('admin_error', 'Card not found.');
            redirect('content');
            return;
        }

        $this->require_valid_section($card->section_key);
        $this->save_form($card->section_key, $card);
    }

    private function save_form($section_key, $card = null)
    {
        $this->form_validation->set_rules('title', 'Title', 'required|max_length[150]');
        $this->form_validation->set_rules('description', 'Description', 'max_length[500]');
        $this->form_validation->set_rules('meta_label', 'Meta Label', 'max_length[50]');
        $this->form_validation->set_rules('icon', 'Icon', 'max_length[50]');
        $this->form_validation->set_rules('sort_order', 'Sort Order', 'required|integer');

        if ($this->input->method() === 'post' && $this->form_validation->run() === TRUE) {

            $data = [
                'section_key' => $section_key,
                'title'       => $this->input->post('title', TRUE),
                'description' => $this->input->post('description', TRUE),
                'meta_label'  => $this->input->post('meta_label', TRUE),
                'icon'        => $this->input->post('icon', TRUE),
                'sort_order'  => (int) $this->input->post('sort_order'),
                'is_active'   => $this->input->post('is_active') ? 1 : 0,
            ];

            $id = $this->Content_card_model->save($data, $card->id ?? null);

            if ($id) {
                $this->session->set_flashdata('admin_success', $card ? 'Card updated.' : 'Card created.');
                redirect('content/' . $section_key);
                return;
            }

            $this->session->set_flashdata('admin_error', 'Something went wrong saving that. Please try again.');
        }

        $this->render_admin('content_cards/form', [
            'page_title'  => $card ? 'Edit Card' : 'New Card',
            'breadcrumb'  => 'Content Cards / ' . $this->sections[$section_key]['label'],
            'active_nav'  => 'content_cards',
            'section_key' => $section_key,
            'section'     => $this->sections[$section_key],
            'card'        => $card,
        ]);
    }

    public function delete($id)
    {
        $this->require_admin_role();

        $card = $this->Content_card_model->get_by_id($id);

        if (!$card) {
            $this->session->set_flashdata('admin_error', 'Card not found.');
            redirect('content');
            return;
        }

        $section_key = $card->section_key;
        $this->Content_card_model->delete($id);
        $this->session->set_flashdata('admin_success', 'Card deleted.');
        redirect('content/' . $section_key);
    }

    public function toggle($id)
    {
        $card = $this->Content_card_model->get_by_id($id);
        if (!$card) {
            redirect('content');
            return;
        }

        $this->Content_card_model->toggle_active($id);
        redirect('content/' . $card->section_key);
    }

    private function require_valid_section($section_key)
    {
        if (!isset($this->sections[$section_key])) {
            show_404();
        }
    }
}
