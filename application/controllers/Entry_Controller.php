<?php

class Entry_controller extends CI_Controller {
  
    public function entry()
    {
        $this->load->helper('url');
         $animalType = $this->db->get("pet")->result();
        $this->load->view('pet_entry',array('animalType' => $animalType));
    }


public function __construct()
    {
        parent::__construct();
        $this->load->model('entry_model','Entry_controller');
    }
 
    public function entry_search($id) { 
       $result = $this->db->where("pet_id",$id)->get("breed")->result();
       echo json_encode($result);
   }
 
    public function entry_list()
    {
        $list = $this->Entry_controller->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $ent) {
            $no++;
            $row = array();
            $row[] = $ent->pet_entry_id;
            $row[] = $ent->pet_entry_status;
            
        
            //add html for action
            $row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="View Information" onclick="view_entry('."'".$ent->pet_entry_id."'".')"><i class="glyphicon glyphicon-eye-open"></i> View</a>
                  <a class="btn btn-sm btn-warning" href="javascript:void(0)" title="Edit Information" onclick="edit_entry('."'".$ent->pet_entry_id."'".')"><i class="glyphicon glyphicon-pencil"></i> Edit</a>';
         
            $data[] = $row;
        }
 
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->Entry_controller->count_all(),
                        "recordsFiltered" => $this->Entry_controller->count_filtered(),
                        "data" => $data
                );
        //output to json format
        echo json_encode($output);
    }
 
    public function entry_edit($id)
    {
        $data = $this->Entry_controller->get_by_id($id);
        $data->date_registered = ($data->date_registered == '0000-00-00') ? '' : $data->date_registered; // if 0000-00-00 set tu empty for datepicker compatibility
        echo json_encode($data);
    }
     public function Entry_view($id)
    {
        $data = $this->Entry_controller->get_by_id($id);
        $data->date_registered = ($data->date_registered == '0000-00-00') ? '' : $data->date_registered; // if 0000-00-00 set tu empty for datepicker compatibility
        echo json_encode($data);
    }
 
    public function Entry_add()
    {
        $this->_validateEntry();
        $data = array(
                'fullName' => $this->input->post('fullName'),
                'animalType' => $this->input->post('animalType'),
                'breed' => $this->input->post('breed'),
                'dob' => $this->input->post('dob'),
                'transaction' => $this->input->post('transaction'),
            );
        $insert = $this->Entry_model->save($data);
        echo json_encode(array("status" => TRUE));
    }
 
    public function Entry_update()
    {
        $this->_validateEntry();
        $data = array(
                'firstName' => $this->input->post('firstName'),
                'lastName' => $this->input->post('lastName'),
                'gender' => $this->input->post('gender'),
                'address' => $this->input->post('address'),
                'dob' => $this->input->post('dob'),
            );
        $this->Entry_model->update(array('id' => $this->input->post('id')), $data);
        echo json_encode(array("status" => TRUE));
    }
 
    public function Entry_delete($id)
    {
        $this->Entry_model->delete_by_id($id);
        echo json_encode(array("status" => TRUE));
    }
 
 
    private function _validateEntry()
    {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;
 
        if($this->input->post('fullName') == '')
        {
            $data['inputerror'][] = 'fullName';
            $data['error_string'][] = 'Name of Pet is required';
            $data['status'] = FALSE;
        }
 
        if($this->input->post('animalType') == '')
        {
            $data['inputerror'][] = 'animalType';
            $data['error_string'][] = 'Animal Type is required';
            $data['status'] = FALSE;
        }
 
        if($this->input->post('breed') == '')
        {
            $data['inputerror'][] = 'breed';
            $data['error_string'][] = 'Breed is required';
            $data['status'] = FALSE;
        }
 
        if($this->input->post('dob') == '')
        {
            $data['inputerror'][] = 'dob';
            $data['error_string'][] = 'Date of Birth is required';
            $data['status'] = FALSE;
        }
 
        if($this->input->post('transaction') == '')
        {
            $data['inputerror'][] = 'transaction';
            $data['error_string'][] = 'Transaction is required';
            $data['status'] = FALSE;
        }
 
        if($data['status'] === FALSE)
        {
            echo json_encode($data);
            exit();
        }
    }






}

?>