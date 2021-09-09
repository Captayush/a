<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Otherfeemaster extends Admin_Controller {

    function __construct() {
        parent::__construct();
		$this->sch_setting_detail = $this->setting_model->getSetting();
		$this->load->model('otherfeesessiongroup_model');
// 		$this->load->model('transportfeegrouptype_model');
		
    }

    function index() {
       
        $this->session->set_userdata('top_menu', 'Fees Collection');
        $this->session->set_userdata('sub_menu', 'admin/otherfeemaster');
        
        $data['title'] = 'Others Feemaster List';
       
        $feetype_result = $this->otherfeesessiongroup_model->getFeesByType();
        $data['feemasterList'] = $feetype_result;
        
        // echo "<pre>";
        // print_r($data['feemasterList']);
        // exit;
        
        $this->form_validation->set_rules('fee_type', "Fees Type", 'required');
        $this->form_validation->set_rules('amount', $this->lang->line('amount'), 'required');

       
        if ($this->form_validation->run() == FALSE) {
            
        } else {

            $insert_array = array(
                'fee_type' => $this->input->post('fee_type'),
                'amount' => $this->input->post('amount'),
                'due_date' => date('Y-m-d', $this->customlib->datetostrtotime($this->input->post('due_date'))),
                'session_id' => $this->setting_model->getCurrentSession(),
                'note' => $this->input->post('note')
            );
           
            $this->otherfeesessiongroup_model->add($insert_array);
          
            $this->session->set_flashdata('msg', '<div class="alert alert-success text-left">'.$this->lang->line('success_message').'</div>');
            redirect('admin/otherfeemaster/index');
        }
        
        // echo "<pre>";
        // print_r($data['feemasterList']);
        // exit;
       
        $this->load->view('layout/header', $data);
        $this->load->view('admin/feemaster/otherfeemasterList', $data);
        $this->load->view('layout/footer', $data);
    }

   

    function deletegrp($id) {
        // echo $id;
        // exit;
        $data['title'] = 'Fees Master List';
        $this->otherfeesessiongroup_model->remove($id);
        redirect('admin/otherfeemaster');
    }

   
    function assign($id) {
        
        if (!$this->rbac->hasPrivilege('fees_group_assign', 'can_view')) {
            access_denied();
        }
        $this->session->set_userdata('top_menu', 'Fees Collection');
        $this->session->set_userdata('sub_menu', 'admin/otherfeemaster');
        $data['id'] = $id;
        $data['title'] = 'student fees';
        $class = $this->class_model->get();
        $data['classlist'] = $class;
        
        $feegroup_result = $this->otherfeesessiongroup_model->getFeesByType($id);
        $data['feegroupList'] = $feegroup_result;
        
        // echo "<pre>";
        // echo $id;
        // print_r($data['feegroupList']);
        // exit;
        
    
		$data['adm_auto_insert']    = $this->sch_setting_detail->adm_auto_insert;
		$data['sch_setting']        = $this->sch_setting_detail;

        $genderList = $this->customlib->getGender();
        $data['genderList'] = $genderList;
        $RTEstatusList = $this->customlib->getRteStatus();
        $data['RTEstatusList'] = $RTEstatusList;

        $category = $this->category_model->get();
        $data['categorylist'] = $category;

 
        if ($this->input->server('REQUEST_METHOD') == 'POST') {

            $data['category_id'] = $this->input->post('category_id');
            $data['gender'] = $this->input->post('gender');
            $data['rte_status'] = $this->input->post('rte');
            $data['class_id'] = $this->input->post('class_id');
            $data['section_id'] = $this->input->post('section_id');

            $resultlist = $this->studentfeemaster_model->searchAssignFeeByClassSection2($data['class_id'], $data['section_id'], $id, $data['category_id'], $data['gender'], $data['rte_status']);
            $data['resultlist'] = $resultlist;
        }

        // echo "<pre>";
        // print_r($data['resultlist']);
        // exit;
        
        $this->load->view('layout/header', $data);
        $this->load->view('admin/feemaster/otherfees_assign', $data);
        $this->load->view('layout/footer', $data);
    }

}

?>