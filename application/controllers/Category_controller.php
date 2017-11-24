<?php

class Category_controller extends CI_Controller {

   public function category()
    {
        $this->load->helper('url');
        $this->load->view('pet_category');
    }
 

public function __construct()
    {
        parent::__construct();
        $this->load->model('category_model','Category_controller');
    }
 
 
    public function category_list()
    {
        $list = $this->Category_controller->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $ctgry) {
            $no++;
            $row = array();
            $row[] = $ctgry->pet_type;
            $row[] = $ctgry->pet_type;
            
        
            //add html for action
            $row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="View Information" onclick="view_category('."'".$ctgry->pet_id."'".')"><i class="glyphicon glyphicon-eye-open"></i> View</a>
                  <a class="btn btn-sm btn-warning" href="javascript:void(0)" title="Edit Information" onclick="edit_category('."'".$ctgry->pet_id."'".')"><i class="glyphicon glyphicon-pencil"></i> Edit</a>';
         
            $data[] = $row;
        }
 
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->Category_controller->count_all(),
                        "recordsFiltered" => $this->Category_controller->count_filtered(),
                        "data" => $data
                );
        //output to json format
        echo json_encode($output);
    }
 
    public function category_edit($id)
    {
        $data = $this->Category_controller->get_by_id($id);
        $data->date_registered = ($data->date_registered == '0000-00-00') ? '' : $data->date_registered; // if 0000-00-00 set tu empty for datepicker compatibility
        echo json_encode($data);
    }
     public function category_view($id)
    {
        $data = $this->Category_controller->get_by_id($id);
        $data->date_registered = ($data->date_registered == '0000-00-00') ? '' : $data->date_registered; // if 0000-00-00 set tu empty for datepicker compatibility
        echo json_encode($data);
    }
 
    public function Category_add()
    {
        $this->_validate();
        $data = array(
                'firstName' => $this->input->post('firstName'),
                'lastName' => $this->input->post('lastName'),
                'gender' => $this->input->post('gender'),
                'address' => $this->input->post('address'),
                'dob' => $this->input->post('dob'),
            );
        $insert = $this->Category_model->save($data);
        echo json_encode(array("status" => TRUE));
    }
 
    public function Category_update()
    {
        $this->_validate();
        $data = array(
                'firstName' => $this->input->post('firstName'),
                'lastName' => $this->input->post('lastName'),
                'gender' => $this->input->post('gender'),
                'address' => $this->input->post('address'),
                'dob' => $this->input->post('dob'),
            );
        $this->Category_model->update(array('id' => $this->input->post('id')), $data);
        echo json_encode(array("status" => TRUE));
    }
 
    public function Category_delete($id)
    {
        $this->Category_model->delete_by_id($id);
        echo json_encode(array("status" => TRUE));
    }
 
 
    private function _validateCategory()
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