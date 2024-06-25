<?php

class New_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }  

    function get_price_list($limit=null){
        $this->db->select('*,');
        $this->db->from('price_details');
        if($limit){
            $this->db->limit($limit);
        }
        $this->db->order_by('id','desc');
        $result=$this->db->get()->result();
        return $result;
    }

    function add_price($data){
        if($data){
            $this->db->insert('price_details',$data);
            return $this->db->insert_id();
        }else{
            return false;
        }
    }

    function get_last_api_call() {
        $this->db->select('last_call');
        $this->db->from('api_call_log');
        $this->db->order_by('id', 'desc');
        $this->db->limit(1);
        $result = $this->db->get()->row();
        return $result;
    }

    function update_last_api_call() {
        $data = [
            'last_call' => date("Y-m-d H:i:s")
        ];
        $this->db->insert('api_call_log', $data);
    }
}
