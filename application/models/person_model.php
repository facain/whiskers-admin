<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Person_model extends CI_Model {
 

    var $table = 'user';
    var $column_order = array('user_id','image_id','address_id','username','user_status','date_registered','first_name','last_name','contact_number','email','password','user_type'); //set column field database for datatable orderable
    var $column_search = array('first_name','last_name','email'); //set column field database for datatable searchable just firstname , lastname , address are searchable
    var $order = array('user_id' => 'desc'); // default order 



    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
 
    private function _get_datatables_query()
    {
         
        $this->db->from($this->table);
 
        $i = 0;
     
        foreach ($this->column_search as $item) // loop column 
        {
            if($_POST['search']['value']) // if datatable send POST for search
            {
                 
                if($i===0) // first loop
                {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                }
                else
                {
                    $this->db->or_like($item, $_POST['search']['value']);
                }
 
                if(count($this->column_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }
         
        if(isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } 
        else if(isset($this->order))
        {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }
 
    function get_datatables()
    {
        $this->_get_datatables_query();
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }
 
    function count_filtered()
    {
        $this->_get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }
 
    public function count_all()
    {
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }
 
    public function get_by_id($user_id)
    {
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->join('address','user.address_id = address.address_id');
        $this->db->where('user_id',$user_id);
        $query = $this->db->get();
 
        return $query->row();
    }
 
    public function save($data, $data2)
    {      
        $this->db->insert('address',$data2);
          $data['address_id']=$this->db->insert_id();
        $this->db->insert('user', $data);
      
     
        return $this->db->insert_id();
    }
 
    public function update($where,$where2, $data,$data2)
    {
        $this->db->update($this->table, $data, $where);
        $this->db->update('address',$data2,$where2);
        return $this->db->affected_rows();
    }

 
}