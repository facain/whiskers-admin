<?php

class Dashboard_controller extends CI_Controller {
	
		public function index(){
            $this->load->view('login_form');
            $this->load->library('form_validation');
            

		}

		public function manageusers(){
			$this->load->view('manage_users');
		}

		public function history(){
			$this->load->view('hist_pet');
		}
		public function category(){
			$this->load->view('pet_category');
		}
		public function breed(){
			$this->load->view('pet_breed');
		}


////////////////////////////// USERSS //////////////////////////////////////////////////////////////////////////////



public function __construct()
    {
        parent::__construct();
        $this->load->model('person_model','Dashboard_controller');
    }
 
    public function user_list()
    {
        $list = $this->Dashboard_controller->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $person) {
            $no++;
            $row = array();
            $row[] = $person->username;
            $row[] = $person->first_name." ".$person->last_name;
            $row[] = $person->user_status;
            $row[] = $person->user_type;
        
            //add html for action
            $row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="View Information" onclick="view_person('."'".$person->user_id."'".')"><i class="glyphicon glyphicon-eye-open"></i> View</a>
                  <a class="btn btn-sm btn-warning" href="javascript:void(0)" title="Edit Information" onclick="edit_person('."'".$person->user_id."'".')"><i class="glyphicon glyphicon-pencil"></i> Edit</a>';
         
            $data[] = $row;
        }
 
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->Dashboard_controller->count_all(),
                        "recordsFiltered" => $this->Dashboard_controller->count_filtered(),
                        "data" => $data
                );
        //output to json format
        echo json_encode($output);
    }
 
    public function user_edit($user_id)
    {
        $data = $this->Dashboard_controller->get_by_id($user_id);
        $data->date_registered = ($data->date_registered == '0000-00-00') ? '' : $data->date_registered; // if 0000-00-00 set tu empty for datepicker compatibility
        echo json_encode($data);
    }
     public function user_view($user_id)
    {
        $data = $this->Dashboard_controller->get_by_id($user_id);
        $data->date_registered = ($data->date_registered == '0000-00-00') ? '' : $data->date_registered; // if 0000-00-00 set tu empty for datepicker compatibility
        echo json_encode($data);
    }
 
    public function user_add()
    {
        $this->_validate();
        $data = array(
                'username' => $this->input->post('username'),
                'address_id' => $this->input->post('address_id'),
                'user_type' => $this->input->post('user_type'),
                'first_name' => $this->input->post('first_name'),
                'last_name' => $this->input->post('last_name'),
                'contact_number' => $this->input->post('contact_number'),
                'email' => $this->input->post('email'),
                'password' => $this->input->post('password'),
            );

        $data2 = array(

            'block_number' => $this->input->post('block_number'),
            'street' => $this->input->post('street'),
            'barangay' => $this->input->post('barangay'),
            'city' => $this->input->post('city'),
        );

        $insert = $this->Dashboard_controller->save($data,$data2);
        echo json_encode(array("status" => TRUE));
    }
 
    public function user_update()
    {
        $this->_validate();
        $data = array(
                'username' => $this->input->post('username'),
                'user_type' => $this->input->post('user_type'),
                'first_name' => $this->input->post('first_name'),
                'last_name' => $this->input->post('last_name'),
                'contact_number' => $this->input->post('contact_number'),
                'email' => $this->input->post('email'),
                'password' => $this->input->post('password'),
                
            );
        $data2 = array(
        		 'block_number' => $this->input->post('block_number'),
                'street' => $this->input->post('street'),
                'barangay' => $this->input->post('barangay'),
                'city' => $this->input->post('city'),
        	);


            
        $this->Dashboard_controller->update(array('user_id' => $this->input->post('user_id')),array('address_id' => $this->input->post('address_id')), $data,$data2);
        echo json_encode(array("status" => TRUE));
    }

 
 
    private function _validate()
    {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;
 
        if($this->input->post('first_name') == '')
        {
            $data['inputerror'][] = 'first_name';
            $data['error_string'][] = 'First name is required';
            $data['status'] = FALSE;
        }
 
          if($this->input->post('last_name') == '')
        {
            $data['inputerror'][] = 'last_name';
            $data['error_string'][] = 'Last name is required';
            $data['status'] = FALSE;
        }
 

        if($this->input->post('contact_number') == '')
        {
            $data['inputerror'][] = 'contact_number';
            $data['error_string'][] = 'Contact Number is required';
            $data['status'] = FALSE;
        }

        if($this->input->post('email') == '')
        {
            $data['inputerror'][] = 'email';
            $data['error_string'][] = 'Email is required';
            $data['status'] = FALSE;
        }

          if($this->input->post('username') == '')
        {
            $data['inputerror'][] = 'username';
            $data['error_string'][] = 'Username is required';
            $data['status'] = FALSE;
        }



          if($this->input->post('password') == '')
        {
            $data['inputerror'][] = 'password';
            $data['error_string'][] = 'Password is required';
            $data['status'] = FALSE;
        }

         if($this->input->post('password') != $this->input->post('confpassword'))
        {
            $data['inputerror'][] = 'confpassword';
            $data['error_string'][] = 'Passwords are not the Same';
            $data['status'] = FALSE;
        }

       if($this->input->post('user_type') == '')
        {
            $data['inputerror'][] = 'user_type';
            $data['error_string'][] = 'User Type is required';
            $data['status'] = FALSE;
        }
       
        if($data['status'] === FALSE)
        {
            echo json_encode($data);
            exit();
        }
    }





    ////////////////////////////////////////////// Pet Breed //////////////////////////////////////////////


}
?>