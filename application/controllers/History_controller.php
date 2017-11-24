<?php

class History_controller extends CI_Controller {

    public function history(){
            $this->load->helper('url');
            $this->load->view('hist_pet');
        }

public function __construct()
    {
        parent::__construct();
        $this->load->model('history_model','History_controller');
    }
 
 
    public function history_list()
    {
        $list = $this->History_controller->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $hist) {
            $no++;
            $row = array();
            $row[] = $hist->pet_name;
            $row[] = $hist->pet_status;
            
        
            //add html for action
            $row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="View Information" onclick="view_history('."'".$hist->pet_info_id."'".')"><i class="glyphicon glyphicon-eye-open"></i> View</a>';
         
            $data[] = $row;
        }
 
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->History_controller->count_all(),
                        "recordsFiltered" => $this->History_controller->count_filtered(),
                        "data" => $data
                );
        //output to json format
        echo json_encode($output);
    }
 
    
     public function history_view($id)
    {
        $data = $this->Breed_controller->get_by_id($id);
        $data->date_registered = ($data->date_registered == '0000-00-00') ? '' : $data->date_registered; // if 0000-00-00 set tu empty for datepicker compatibility
        echo json_encode($data);
    }
 
    






}

?>