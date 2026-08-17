<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ContactMessages extends MY_Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Contact_message_model');
    }

    public function index()
    {
        $status = $this->input->get('status', TRUE); // '', new, read, closed
        $search = $this->input->get('q', TRUE);

        $this->render_admin('contact_messages/index', [
            'page_title'   => 'Contact Messages',
            'active_nav'   => 'contact_messages',
            'messages'     => $this->Contact_message_model->get_all($status ?: null, $search),
            'status'       => $status,
            'search'       => $search,
            'new_count'    => $this->Contact_message_model->count_by_status('new'),
            'read_count'   => $this->Contact_message_model->count_by_status('read'),
            'closed_count' => $this->Contact_message_model->count_by_status('closed'),
        ]);
    }

    public function view($id)
    {
        $message = $this->Contact_message_model->get_by_id($id);

        if (!$message) {
            $this->session->set_flashdata('admin_error', 'Message not found.');
            redirect('messages');
            return;
        }

        // Opening a 'new' message moves it to 'read', same as a normal
        // inbox. Doesn't touch messages already 'read' or 'closed'.
        $this->Contact_message_model->mark_read_if_new($id);
        $message = $this->Contact_message_model->get_by_id($id);

        $this->render_admin('contact_messages/view', [
            'page_title' => 'Message from ' . $message->first_name . ' ' . $message->last_name,
            'active_nav' => 'contact_messages',
            'message'    => $message,
        ]);
    }

    public function update_status($id)
    {
        $message = $this->Contact_message_model->get_by_id($id);

        if (!$message) {
            $this->session->set_flashdata('admin_error', 'Message not found.');
            redirect('messages');
            return;
        }

        $status = $this->input->post('status', TRUE);

        if (!in_array($status, ['new', 'read', 'closed'], true)) {
            $this->session->set_flashdata('admin_error', 'Invalid status.');
            redirect('messages/view/' . $id);
            return;
        }

        $this->Contact_message_model->update_status($id, $status);
        $this->session->set_flashdata('admin_success', 'Status updated to "' . $status . '".');
        redirect('messages/view/' . $id);
    }

    public function delete($id)
    {
        $this->require_admin_role();

        $message = $this->Contact_message_model->get_by_id($id);

        if (!$message) {
            $this->session->set_flashdata('admin_error', 'Message not found.');
        } else {
            $this->Contact_message_model->delete($id);
            $this->session->set_flashdata('admin_success', 'Message deleted.');
        }

        redirect('messages');
    }
}
