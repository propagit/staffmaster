<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Induction_model extends CI_Model {

    function add($data) {
        $this->db->insert('inductions', $data);
        return $this->db->insert_id();
    }

    function get($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('inductions');
        return $query->first_row('array');
    }

    function all() {
        $query = $this->db->get('inductions');
        return $query->result_array();
    }

    function add_step($data) {
        # First get number of the largest step
        $number = 0;
        $this->db->where('induction_id', $data['induction_id']);
        $this->db->order_by('number', 'desc');
        $query = $this->db->get('induction_steps');
        $step = $query->first_row('array');
        if (isset($step['number'])) { $number = $step['number']; }

        # Increase number by 1
        $number++;

        $data['number'] = $number;

        $a = $this->db->insert('induction_steps', $data);
        return $a;
        return $this->db->insert_id();
    }

    function get_steps($induction_id)
    {
        $this->db->where('induction_id', $induction_id);
        $this->db->order_by('number', 'asc');
        $query = $this->db->get('induction_steps');
        return $query->result_array();
    }

    function delete_step($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete('induction_steps');
    }
}
