<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Induction_model extends CI_Model {

    function add($data) {
        $data['status'] = 0;
        $data['target_all'] = 1;
        $this->db->insert('inductions', $data);
        return $this->db->insert_id();
    }

    function update($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('inductions', $data);
    }

    function get($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('inductions');
        return $query->first_row('array');
    }

    function all($active=null) {
        if ($active) {
            $this->db->where('status', 1);
        }
        $query = $this->db->get('inductions');
        return $query->result_array();
    }

    function add_step($data) {
        # First get number of the largest step
        $number = 0;
        $this->db->where('induction_id', $data['induction_id']);
        $this->db->order_by('step_order', 'desc');
        $query = $this->db->get('induction_steps');
        $step = $query->first_row('array');
        if (isset($step['step_order'])) { $number = $step['step_order']; }

        # Increase number by 1
        $number++;

        $data['step_order'] = $number;
        $data['title'] = ucwords($data['type']);
        if ($data['type'] == 'content') {
            $data['title'] = 'Content';
            $data['description'] = 'Click to add description';
        } else if ($data['type'] == 'personal') {
            $data['title'] = 'Personal Details';
            $data['description'] = 'Please update your personal information below and proceed to next step';
        } else if ($data['type'] == 'financial') {
            $data['title'] = 'Financial Details';
            $data['description'] = 'Please update your financial information below and proceed to next step';
        } else if ($data['type'] == 'super') {
            $data['title'] = 'Superannuation Details';
            $data['description'] = 'Please update your superannuation information below and proceed to next step';
        } else if ($data['type'] == 'picture') {
            $data['title'] = 'Picture';
            $data['description'] = 'Please upload photos of yourself so we have a visual reference of you';
        }
        $this->db->insert('induction_steps', $data);
        $data['id'] = $this->db->insert_id();
        return $data;
    }

    function get_step($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get('induction_steps');
        return $query->first_row('array');
    }

    function get_steps($induction_id)
    {
        $this->db->where('induction_id', $induction_id);
        $this->db->order_by('step_order', 'asc');
        $query = $this->db->get('induction_steps');
        return $query->result_array();
    }

    function update_step($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('induction_steps', $data);
    }

    function delete_step($id)
    {
        $this->db->where('step_id', $id);
        $this->db->delete('induction_contents');

        $this->db->where('id', $id);
        return $this->db->delete('induction_steps');
    }

    function add_content($data) {
        $number = 0;
        $this->db->where('step_id', $data['step_id']);
        $this->db->order_by('content_order', 'desc');
        $query = $this->db->get('induction_contents');
        $content = $query->first_row('array');
        if (isset($content['content_order'])) { $number = $content['content_order']; }

        $number++;

        $data['content_order'] = $number;
        $this->db->insert('induction_contents', $data);
        $data['id'] = $this->db->insert_id();
        return $data;
    }

    function get_contents($step_id)
    {
        $this->db->where('step_id', $step_id);
        $this->db->order_by('content_order', 'asc');
        $query = $this->db->get('induction_contents');
        return $query->result_array();
    }

    function update_content($id, $data)
    {
        if (isset($data['html'])) { unset($data['html']); }
        $this->db->where('id', $id);
        return $this->db->update('induction_contents', $data);
    }

    function delete_content($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete('induction_contents');
    }

    function check_user($induction_id, $user_id)
    {
        $row = $this->get_user($induction_id, $user_id);
        if (!$row) {
            $row = array(
                'induction_id' => $induction_id,
                'user_id' => $user_id,
                'status' => 0
            );
            $this->db->insert('inductions_users', $row);
            $row['id'] = $this->db->insert_id();
        }
        return $row;
    }

    function get_user($induction_id, $user_id)
    {
        $this->db->where('induction_id', $induction_id);
        $this->db->where('user_id', $user_id);
        $query = $this->db->get('inductions_users');
        return $query->first_row('array');
    }

    function update_user($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('inductions_users', $data);
    }
}
