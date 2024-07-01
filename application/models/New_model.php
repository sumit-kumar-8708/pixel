<?php

class New_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
        
    }

    function get_price_details($id=null){
        if($id){
            $this->db->select('*');
            $this->db->from('price_details');
            $this->db->where('id',$id);
            $result=$this->db->get()->row();
            return $result;
        }else{
            return false;
        }
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

    
}



?>