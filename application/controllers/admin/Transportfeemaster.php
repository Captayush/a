<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Transportfeemaster extends Admin_Controller {

    function __construct() {
        parent::__construct();
		$this->sch_setting_detail = $this->setting_model->getSetting();
		$this->load->model('transportfeesessiongroup_model');
		$this->load->model('transportfeegrouptype_model');
		
    }

    function index() {
       
        $this->session->set_userdata('top_menu', 'Fees Collection');
        $this->session->set_userdata('sub_menu', 'admin/transportfeemaster');
        
        $data['title'] = 'Transport Feemaster List';
        $feegroup = $this->feegroup_model->get();
        $data['feegroupList'] = $feegroup;
        $feetype = $this->feetype_model->get();
        $data['feetypeList'] = $feetype;
        
        $feegroup_result = $this->transportfeesessiongroup_model->getFeesByGroup();
        $data['feemasterList'] = $feegroup_result;

        $this->form_validation->set_rules('feetype_id', $this->lang->line('feetype'), 'required');
        $this->form_validation->set_rules('amount', $this->lang->line('amount'), 'required');

        $this->form_validation->set_rules(
                'fee_groups_id', $this->lang->line('feegroup'), array(
            'required',
            array('check_exists', array($this->transportfeesessiongroup_model, 'valid_check_exists'))
                )
        );

        if ($this->form_validation->run() == FALSE) {
            
        } else {

 
            $insert_array = array(
                'fee_groups_id' => $this->input->post('fee_groups_id'),
                'feetype_id' => $this->input->post('feetype_id'),
                'amount' => $this->input->post('amount'),
                'due_date' => date('Y-m-d', $this->customlib->datetostrtotime($this->input->post('due_date'))),
                'session_id' => $this->setting_model->getCurrentSession(),
                'fine_type' => $this->input->post('account_type'),
                'fine_percentage' => $this->input->post('fine_percentage'),
                'fine_amount' => $this->input->post('fine_amount')
            );
            $feegroup_result = $this->transportfeesessiongroup_model->add($insert_array);
            $this->session->set_flashdata('msg', '<div class="alert alert-success text-left">'.$this->lang->line('success_message').'</div>');
            redirect('admin/transportfeemaster/index');
        }
       
        $this->load->view('layout/header', $data);
        $this->load->view('admin/feemaster/transferfeemasterList', $data);
        $this->load->view('layout/footer', $data);
    }

    function delete($id) {
        if (!$this->rbac->hasPrivilege('fees_master', 'can_delete')) {
            access_denied();
        }
        $data['title'] = 'Fees Master List';
        $this->transportfeegrouptype_model->remove($id);
        redirect('admin/transportfeemaster');
    }

    function deletegrp($id) {
        // echo $id;
        // exit;
        $data['title'] = 'Fees Master List';
        $this->transportfeesessiongroup_model->remove($id);
        redirect('admin/transportfeemaster');
    }

    function edit($id) {
        if (!$this->rbac->hasPrivilege('fees_master', 'can_edit')) {
            access_denied();
        }
        $this->session->set_userdata('top_menu', 'Fees Collection');
        $this->session->set_userdata('sub_menu', 'admin/feemaster');
        $data['id'] = $id;
        $feegroup_type = $this->transportfeegrouptype_model->get($id);
        $data['feegroup_type'] = $feegroup_type;

        $feegroup = $this->feegroup_model->get();
        $data['feegroupList'] = $feegroup;
        $feetype = $this->feetype_model->get();
        $data['feetypeList'] = $feetype;
        $feegroup_result = $this->transportfeesessiongroup_model->getFeesByGroup();
        $data['feemasterList'] = $feegroup_result;


        $this->form_validation->set_rules('feetype_id', $this->lang->line('feetype'), 'required');
        $this->form_validation->set_rules('amount', $this->lang->line('amount'), 'required');
        $this->form_validation->set_rules(
                'fee_groups_id', $this->lang->line('feegroup'), array(
            'required',
            array('check_exists', array($this->transportfeesessiongroup_model, 'valid_check_exists'))
                )
        );

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('layout/header', $data);
            $this->load->view('admin/feemaster/feemasterEdit', $data);
            $this->load->view('layout/footer', $data);
        } else {
            $insert_array = array(
                'id' => $this->input->post('id'),
                'feetype_id' => $this->input->post('feetype_id'),
                'due_date' => date('Y-m-d', $this->customlib->datetostrtotime($this->input->post('due_date'))),
                'amount' => $this->input->post('amount'),
                'fine_type' => $this->input->post('account_type'),
                'fine_percentage' => $this->input->post('fine_percentage'),
                'fine_amount' => $this->input->post('fine_amount'),
            );
            $feegroup_result = $this->transportfeegrouptype_model->add($insert_array);

            $this->session->set_flashdata('msg', '<div class="alert alert-success text-left">'.$this->lang->line('update_message').'</div>');
            redirect('admin/feemaster/index');
        }
    }

    function assign($id) {
        // echo $id;
        // exit;
        if (!$this->rbac->hasPrivilege('fees_group_assign', 'can_view')) {
            access_denied();
        }
        $this->session->set_userdata('top_menu', 'Fees Collection');
        $this->session->set_userdata('sub_menu', 'admin/transportfeemaster');
        $data['id'] = $id;
        $data['title'] = 'student fees';
        $class = $this->class_model->get();
        $data['classlist'] = $class;
        $feegroup_result = $this->transportfeesessiongroup_model->getFeesByGroup($id);
        $data['feegroupList'] = $feegroup_result;
		$data['adm_auto_insert']    = $this->sch_setting_detail->adm_auto_insert;
		$data['sch_setting']        = $this->sch_setting_detail;

        $genderList = $this->customlib->getGender();
        $data['genderList'] = $genderList;
        $RTEstatusList = $this->customlib->getRteStatus();
        $data['RTEstatusList'] = $RTEstatusList;

        $category = $this->category_model->get();
        $data['categorylist'] = $category;

        
        // echo "<pre>";
        // print_r($data);
        // exit;
        if ($this->input->server('REQUEST_METHOD') == 'POST') {

            $data['category_id'] = $this->input->post('category_id');
            $data['gender'] = $this->input->post('gender');
            $data['rte_status'] = $this->input->post('rte');
            $data['class_id'] = $this->input->post('class_id');
            $data['section_id'] = $this->input->post('section_id');

            $resultlist = $this->studentfeemaster_model->searchAssignFeeByClassSection1($data['class_id'], $data['section_id'], $id, $data['category_id'], $data['gender'], $data['rte_status']);
            $data['resultlist'] = $resultlist;
        }

        // echo "<pre>";
        // print_r( $data['resultlist']);
        // exit;
        
        $this->load->view('layout/header', $data);
        $this->load->view('admin/feemaster/transport_assign', $data);
        $this->load->view('layout/footer', $data);
    }

}

?>