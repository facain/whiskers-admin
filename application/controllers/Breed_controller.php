<?php

class Breed_controller extends CI_Controller {
  
    public function breed()
    {
        $this->load->helper('url');
        $this->load->view('pet_breed');
    }


public function __construct()
    {
        parent::__construct();
        $this->load->model('breed_model','Breed_controller');
    }
 
  
 
    public function breed_list()
    {
        $list = $this->Breed_controller->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $pet) {
            $no++;
            $row = array();
            $row[] = $pet->breed_name;
            $row[] = $pet->breed_id;
            
        
            //add html for action
            $row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="View Information" onclick="view_breed('."'".$pet->breed_id."'".')"><i class="glyphicon glyphicon-eye-open"></i> View</a>
                  <a class="btn btn-sm btn-warning" href="javascript:void(0)" title="Edit Information" onclick="edit_breed('."'".$pet->breed_id."'".')"><i class="glyphicon glyphicon-pencil"></i> Edit</a>';
         
            $data[] = $row;
        }
 
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->Breed_controller->count_all(),
                        "recordsFiltered" => $this->Breed_controller->count_filtered(),
                        "data" => $data
                );
        //output to json format
        echo json_encode($output);
    }
 
    public function breed_edit($id)
    {
        $data = $this->Breed_controller->get_by_id($id);
        $data->date_registered = ($data->date_registered == '0000-00-00') ? '' : $data->date_registered; // if 0000-00-00 set tu empty for datepicker compatibility
        echo json_encode($data);
    }
     public function breed_view($id)
    {
        $data = $this->Breed_controller->get_by_id($id);
        $data->date_registered = ($data->date_registered == '0000-00-00') ? '' : $data->date_registered; // if 0000-00-00 set tu empty for datepicker compatibility
        echo json_encode($data);
    }
 
    public function breed_add()
    {
        $this->_validate();
        $data = array(
                'firstName' => $this->input->post('firstName'),
                'lastName' => $this->input->post('lastName'),
                'gender' => $this->input->post('gender'),
                'address' => $this->input->post('address'),
                'dob' => $this->input->post('dob'),
            );
        $insert = $this->Breed_model->save($data);
        echo json_encode(array("status" => TRUE));
    }
 
    public function breed_update()
    {
        $this->_validate();
        $data = array(
                'firstName' => $this->input->post('firstName'),
                'lastName' => $this->input->post('lastName'),
                'gender' => $this->input->post('gender'),
                'address' => $this->input->post('address'),
                'dob' => $this->input->post('dob'),
            );
        $this->Breed_model->update(array('id' => $this->input->post('id')), $data);
        echo json_encode(array("status" => TRUE));
    }
 
    public function breed_delete($id)
    {
        $this->Breed_model->delete_by_id($id);
        echo json_encode(array("status" => TRUE));
    }
 
 
    private function _validateBreed()
    {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;
 
        if($this->input->post('firstName') == '')
        {
            $data['inputerror'][] = 'firstName';
            $data['error_string'][] = 'First name is required';
            $data['status'] = FALSE;
        }
 
        if($this->input->post('lastName') == '')
        {
            $data['inputerror'][] = 'lastName';
            $data['error_string'][] = 'Last name is required';
            $data['status'] = FALSE;
        }
 
        if($this->input->post('dob') == '')
        {
            $data['inputerror'][] = 'dob';
            $data['error_string'][] = 'Date of Birth is required';
            $data['status'] = FALSE;
        }
 
        if($this->input->post('gender') == '')
        {
            $data['inputerror'][] = 'gender';
            $data['error_string'][] = 'Please select gender';
            $data['status'] = FALSE;
        }
 
        if($this->input->post('address') == '')
        {
            $data['inputerror'][] = 'address';
            $data['error_string'][] = 'Addess is required';
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