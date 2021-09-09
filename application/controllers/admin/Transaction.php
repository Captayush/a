<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Transaction extends Admin_Controller {

    function __construct() {
        parent::__construct();
         $this->load->model("enquiry_model");
		 $this->sch_setting_detail = $this->setting_model->getSetting();
    }

    function searchtransaction() {

        $this->session->set_userdata('top_menu', 'Reports');
        $this->session->set_userdata('sub_menu', 'Reports/finance');

        $data['title'] = 'Search Expense';
        $data['searchlist'] = $this->customlib->get_searchtype();
        $data['search_type']=$search_type='';
   
       
            $search = $this->input->post('search_type');
          

           if(isset($_POST['search_type']) && $_POST['search_type']!=''){

                $dates=$this->customlib->get_betweendate($_POST['search_type']);
                $data['search_type']=$_POST['search_type'];

            }else{

                $dates=$this->customlib->get_betweendate('this_year');
                $data['search_type']=$search_type='this_year'; 

            }

            $dateformat=$this->customlib->getSchoolDateFormat();
        
            $date_from=$dates['from_date'];
            $date_to=$dates['to_date'];

                $data['collection_title'] = $this->lang->line('collection')." ".$this->lang->line('report')." ".$this->lang->line('from')." ".date($this->customlib->getSchoolDateFormat(),strtotime($date_from)). " To " .date($this->customlib->getSchoolDateFormat(),strtotime($date_to));
                $data['income_title'] = $this->lang->line('income')." ".$this->lang->line('report')." ".$this->lang->line('from')." ".date($this->customlib->getSchoolDateFormat(),strtotime($date_from)). " To " .date($this->customlib->getSchoolDateFormat(),strtotime($date_to));
                $data['expense_title'] = $this->lang->line('expense')." ".$this->lang->line('report')." ".$this->lang->line('from')." ".date($this->customlib->getSchoolDateFormat(),strtotime($date_from)). " To " .date($this->customlib->getSchoolDateFormat(),strtotime($date_to));
                $data['payroll_title'] = $this->lang->line('payroll')." ".$this->lang->line('report')." ".$this->lang->line('from')." ".date($this->customlib->getSchoolDateFormat(),strtotime($date_from)). " To " .date($this->customlib->getSchoolDateFormat(),strtotime($date_to));
                $date_from = date('Y-m-d',strtotime($date_from));
                $date_to = date('Y-m-d',strtotime($date_to));
                $expenseList = $this->expense_model->search("", $date_from, $date_to);
              
                $result = $this->payroll_model->getbetweenpayrollReport($date_from, $date_to);
       
                $incomeList = $this->income_model->search("", $date_from, $date_to);
                $feeList = $this->studentfeemaster_model->getFeeBetweenDate($date_from, $date_to);
                $data['expenseList'] = $expenseList;
                $data['incomeList'] = $incomeList;
                $data['feeList'] = $feeList;
                $data['payrollList']=$result;
                
          

            $this->load->view('layout/header', $data);
            $this->load->view('admin/transaction/searchtransaction', $data);
            $this->load->view('layout/footer', $data);
        
    }

    function studentacademicreport() {
        
        if (!$this->rbac->hasPrivilege('balance_fees_report', 'can_view')) {
            access_denied();
        }

        $this->session->set_userdata('top_menu', 'Reports');
        $this->session->set_userdata('sub_menu', 'Reports/finance');
        $this->session->set_userdata('subsub_menu', 'Reports/finance/studentacademicreport');
        $data['title'] = 'student fee';
        $data['title'] = 'student fee';
        $class = $this->class_model->get();
		$data['sch_setting']        = $this->sch_setting_detail;
		$data['adm_auto_insert']    = $this->sch_setting_detail->adm_auto_insert;
        $data['classlist'] = $class;
        $class_id = $this->input->post('class_id');
        $section_id = $this->input->post('section_id');
        $feetype = $this->input->post('feetype');
        $feetype_arr = $this->input->post('feetype_arr');
        $data['section_list']=$this->section_model->getClassBySection($this->input->post('class_id'));
        $this->form_validation->set_rules('class_id', $this->lang->line('class'), 'trim|required|xss_clean');
      

        if ($this->form_validation->run() == false) {
            $data['student_due_fee'] = array();
                $data['resultarray']=array();
             
                $data['class_id'] = "";
                $data['section_id'] = "";
                $data['feetype'] ="";
                $data['feetype_arr'] = array();
        }else{
         $student_Array = array();
                
                $section=array();

                $classlist=$this->student_model->getAllClassSection($class_id, $section_id);
               
                foreach ($classlist as $key => $value) {
                    $classid=$value['class_id'];
                    $sectionid=$value['section_id'];

                    $studentlist = $this->student_model->reportClassSection($classid,$sectionid);
                 
                       $student_Array=array();
                     if (!empty($studentlist)) {
                    foreach ($studentlist as $key => $eachstudent) {
                        $obj = new stdClass();
                        $obj->name = $eachstudent['firstname'] . " " . $eachstudent['lastname'];
                        $obj->class = $eachstudent['class'];
                        $obj->section = $eachstudent['section'];
                        $obj->admission_no = $eachstudent['admission_no'];
                        $obj->roll_no = $eachstudent['roll_no'];
                        $obj->father_name = $eachstudent['father_name'];
                        $student_session_id = $eachstudent['student_session_id'];
                        $student_total_fees = $this->studentfeemaster_model->getStudentFees($student_session_id);

                        if (!empty($student_total_fees)) {


                            $totalfee = 0;
                            $deposit = 0;
                            $discount = 0;
                            $balance = 0;
                            $fine = 0;
                            foreach ($student_total_fees as $student_total_fees_key => $student_total_fees_value) {


                                if (!empty($student_total_fees_value->fees)) {
                                    foreach ($student_total_fees_value->fees as $each_fee_key => $each_fee_value) {
                                        $totalfee = $totalfee + $each_fee_value->amount;

                                        $amount_detail = json_decode($each_fee_value->amount_detail);
                                       
                                        if (is_object($amount_detail)) {
                                            foreach ($amount_detail as $amount_detail_key => $amount_detail_value) {
                                                $deposit = $deposit + $amount_detail_value->amount;
                                                $fine = $fine + $amount_detail_value->amount_fine;
                                                $discount = $discount + $amount_detail_value->amount_discount;
                                            }
                                        }
                                    }
                                }
                            }

                            $obj->totalfee = $totalfee;
                            $obj->payment_mode = "N/A";
                            $obj->deposit = $deposit;
                            $obj->fine = $fine;
                            $obj->discount = $discount;
                            $obj->balance = $totalfee - ($deposit + $discount);
                        } else {

                            $obj->totalfee = 0;
                            $obj->payment_mode = 0;
                            $obj->deposit = 0;
                            $obj->fine = 0;
                            $obj->balance = 0;
                            $obj->discount = 0;
                      
                        }
                        
                        if($obj->balance>0){
                            $student_Array[] = $obj;
                       }


                        
                    }
                }

                   $classlistdata[$value['class_id']][]=array('class_name'=>$value['class'],'section' =>$value['section_id'],'section_name'=>$value['section'],'result'=>$student_Array);
                }
               
              

                $data['student_due_fee'] = $student_Array;
                $data['resultarray']=$classlistdata;
             
                $data['class_id'] = $class_id;
                $data['section_id'] = $section_id;
                $data['feetype'] = $feetype;
                $data['feetype_arr'] = $feetype_arr;   
        }
        
                $this->load->view('layout/header', $data);
                $this->load->view('admin/transaction/studentAcademicReport', $data);
                $this->load->view('layout/footer', $data);
    }
    
    function studentacademicreport1() {
        
        if (!$this->rbac->hasPrivilege('balance_fees_report', 'can_view')) {
            access_denied();
        }

        $this->session->set_userdata('top_menu', 'Reports');
        $this->session->set_userdata('sub_menu', 'Reports/fees');
        $this->session->set_userdata('subsub_menu', 'Reports/fees/studentacademicreport1');
        $data['title'] = 'student fee';
        $data['title'] = 'student fee';
        $class = $this->class_model->get();
		$data['sch_setting']        = $this->sch_setting_detail;
		$data['adm_auto_insert']    = $this->sch_setting_detail->adm_auto_insert;
        $data['classlist'] = $class;
        $class_id = $this->input->post('class_id');
        $section_id = $this->input->post('section_id');
        $feetype = $this->input->post('feetype');
        $feetype_arr = $this->input->post('feetype_arr');
        
         $register = $this->input->post('register');
         
        $data['section_list']=$this->section_model->getClassBySection($this->input->post('class_id'));
        $this->form_validation->set_rules('register', "Register", 'trim|required|xss_clean');
        // $this->form_validation->set_rules('class_id', $this->lang->line('class'), 'trim|required|xss_clean');
      

        if ($this->form_validation->run() == false) {
            $data['student_due_fee'] = array();
                $data['resultarray']=array();
             
                $data['class_id'] = "";
                $data['section_id'] = "";
                $data['feetype'] ="";
                $data['feetype_arr'] = array();
        }else{
         $student_Array = array();
                
                $section=array();

                $classlist=$this->student_model->getAllClassSection(null, null);
                
                // echo "<pre>";
                // print_r($classlist);
                // exit;
               
                // foreach ($classlist as $key => $value) {

                    $studentlist = $this->student_model->reportClassSectionByregister($register);
                 
                    // echo "<pre>";
                    // print_r($studentlist);
                    // exit;
                    $student_Array=array();
                    if (!empty($studentlist)) {
                        foreach ($studentlist as $key => $eachstudent) {
                            $obj = new stdClass();
                            $obj->class = $eachstudent['class'];
                            $obj->section = $eachstudent['section'];
                           
                            $student_session_id = $eachstudent['student_session_id'];
                            $student_total_fees = $this->studentfeemaster_model->getStudentFees($student_session_id);
    
                            if (!empty($student_total_fees)) {
    
    
                                $totalfee = 0;
                                $deposit = 0;
                                $discount = 0;
                                $balance = 0;
                                $fine = 0;
                                foreach ($student_total_fees as $student_total_fees_key => $student_total_fees_value) {
    
    
                                    if (!empty($student_total_fees_value->fees)) {
                                        foreach ($student_total_fees_value->fees as $each_fee_key => $each_fee_value) {
                                            $totalfee = $totalfee + $each_fee_value->amount;
    
                                            $amount_detail = json_decode($each_fee_value->amount_detail);
                                           
                                            if (is_object($amount_detail)) {
                                                foreach ($amount_detail as $amount_detail_key => $amount_detail_value) {
                                                    $deposit = $deposit + $amount_detail_value->amount;
                                                    $fine = $fine + $amount_detail_value->amount_fine;
                                                    $discount = $discount + $amount_detail_value->amount_discount;
                                                }
                                            }
                                        }
                                    }
                                }
    
                                $obj->totalfee = $totalfee;
                                $obj->payment_mode = "N/A";
                                $obj->deposit = $deposit;
                                $obj->fine = $fine;
                                $obj->discount = $discount;
                                $obj->balance = $totalfee - ($deposit + $discount);
                            } else {
    
                                $obj->totalfee = 0;
                                $obj->payment_mode = 0;
                                $obj->deposit = 0;
                                $obj->fine = 0;
                                $obj->balance = 0;
                                $obj->discount = 0;
                          
                            }
                            
                            if($obj->balance>0){
                                // $student_Array[] = $obj;
                            }
                            
                           
                            $classlistdata[$eachstudent['class_id']][]=array('class_name'=>$eachstudent['class'],'section' =>$eachstudent['section_id'],'section_name'=>$eachstudent['section'],'result'=>$obj);
    
                            
                        }
                    }

                    // if( $eachstudent['class']==$value['class'] && $eachstudent['section']==$value['section']){
                    //   $classlistdata[$value['class_id']][]=array('class_name'=>$value['class'],'section' =>$value['section_id'],'section_name'=>$value['section'],'result'=>$student_Array);
                    // }
                // }
               
              

                $data['student_due_fee'] = $obj;
                $data['resultarray']=$classlistdata;
             
                $data['class_id'] = $class_id;
                $data['section_id'] = $section_id;
                // $data['feetype'] = $feetype;
                // $data['feetype_arr'] = $feetype_arr;   
        }
        
        // echo "<pre>";
        // print_r($data['resultarray']);
        // exit;
        
        
        $this->load->view('layout/header', $data);
        $this->load->view('admin/transaction/studentAcademicReport1', $data);
        $this->load->view('layout/footer', $data);
    }
    
    function studenttransportreport() {
        
        if (!$this->rbac->hasPrivilege('balance_fees_report', 'can_view')) {
            access_denied();
        }

        $this->session->set_userdata('top_menu', 'Reports');
        $this->session->set_userdata('sub_menu', 'Reports/fees');
        $this->session->set_userdata('subsub_menu', 'Reports/fees/studenttransportreport');
        $data['title'] = 'student fee';
        $data['title'] = 'student fee';
        $class = $this->class_model->get();
		$data['sch_setting']        = $this->sch_setting_detail;
		$data['adm_auto_insert']    = $this->sch_setting_detail->adm_auto_insert;
        $data['classlist'] = $class;
        $class_id = $this->input->post('class_id');
        $section_id = $this->input->post('section_id');
        $feetype = $this->input->post('feetype');
        $feetype_arr = $this->input->post('feetype_arr');
        
         $register = $this->input->post('register');
         
        $data['section_list']=$this->section_model->getClassBySection($this->input->post('class_id'));
        $this->form_validation->set_rules('register', "Register", 'trim|required|xss_clean');
        // $this->form_validation->set_rules('class_id', $this->lang->line('class'), 'trim|required|xss_clean');
      

        if ($this->form_validation->run() == false) {
            $data['student_due_fee'] = array();
                $data['resultarray']=array();
             
                $data['class_id'] = "";
                $data['section_id'] = "";
                $data['feetype'] ="";
                $data['feetype_arr'] = array();
        }else{
         $student_Array = array();
                
                $section=array();

                $classlist=$this->student_model->getAllClassSection(null, null);
            
                $studentlist = $this->student_model->reportClassSectionByregister($register);
             
                // echo "<pre>";
                // print_r($studentlist);
                // exit;
                
                $student_Array=array();
                if (!empty($studentlist)) {
                    foreach ($studentlist as $key => $eachstudent) {
                        $obj = new stdClass();
                        $obj->class = $eachstudent['class'];
                        $obj->section = $eachstudent['section'];
                       
                        $student_session_id = $eachstudent['student_session_id'];
                        $student_total_fees = $this->studentfeemaster_model->getStudentTransportFees($student_session_id);

                        if (!empty($student_total_fees)) {
                            
                            $totalfee = 0;
                            $deposit = 0;
                            $discount = 0;
                            $balance = 0;
                            $fine = 0;
                            foreach ($student_total_fees as $student_total_fees_key => $student_total_fees_value) {
                                if (!empty($student_total_fees_value->fees)) {
                                    foreach ($student_total_fees_value->fees as $each_fee_key => $each_fee_value) {
                                        $totalfee = $totalfee + $each_fee_value->amount;

                                        $amount_detail = json_decode($each_fee_value->amount_detail);
                        
                                        if (is_object($amount_detail)) {
                                            foreach ($amount_detail as $amount_detail_key => $amount_detail_value) {
                                                $deposit = $deposit + $amount_detail_value->amount;
                                                $fine = $fine + $amount_detail_value->amount_fine;
                                                $discount = $discount + $amount_detail_value->amount_discount;
                                            }
                                        }
                                    }
                                }
                            }

                            $obj->totalfee = $totalfee;
                            $obj->payment_mode = "N/A";
                            $obj->deposit = $deposit;
                            $obj->fine = $fine;
                            $obj->discount = $discount;
                            $obj->balance = $totalfee - ($deposit + $discount);
                        } else {

                            $obj->totalfee = 0;
                            $obj->payment_mode = 0;
                            $obj->deposit = 0;
                            $obj->fine = 0;
                            $obj->balance = 0;
                            $obj->discount = 0;
                      
                        }
                        
                        if($obj->balance>0){
                            // $student_Array[] = $obj;
                        }
                        
                      
                        $classlistdata[$eachstudent['class_id']][]=array('class_name'=>$eachstudent['class'],'section' =>$eachstudent['section_id'],'section_name'=>$eachstudent['section'],'result'=>$obj);

                    }
                }

                $data['student_due_fee'] = $obj;
                $data['resultarray']=$classlistdata;
             
                $data['class_id'] = $class_id;
                $data['section_id'] = $section_id;
        }
        
        // echo "<pre>";
        // print_r($data['resultarray']);
        // exit;
        
        
        $this->load->view('layout/header', $data);
        $this->load->view('admin/transaction/studentTransportReport', $data);
        $this->load->view('layout/footer', $data);
    }
    
    function studentmiscellaneousreport() {
        
        if (!$this->rbac->hasPrivilege('balance_fees_report', 'can_view')) {
            access_denied();
        }

        $this->session->set_userdata('top_menu', 'Reports');
        $this->session->set_userdata('sub_menu', 'Reports/fees');
        $this->session->set_userdata('subsub_menu', 'Reports/fees/studentmiscellaneousreport');
        $data['title'] = 'student fee';
        $data['title'] = 'student fee';
        $class = $this->class_model->get();
		$data['sch_setting']        = $this->sch_setting_detail;
		$data['adm_auto_insert']    = $this->sch_setting_detail->adm_auto_insert;
        $data['classlist'] = $class;
        $class_id = $this->input->post('class_id');
        $section_id = $this->input->post('section_id');
        $feetype = $this->input->post('feetype');
        $feetype_arr = $this->input->post('feetype_arr');
        
         $register = $this->input->post('register');
         
        $data['section_list']=$this->section_model->getClassBySection($this->input->post('class_id'));
        $this->form_validation->set_rules('register', "Register", 'trim|required|xss_clean');
        // $this->form_validation->set_rules('class_id', $this->lang->line('class'), 'trim|required|xss_clean');
      

        if ($this->form_validation->run() == false) {
            $data['student_due_fee'] = array();
                $data['resultarray']=array();
             
                $data['class_id'] = "";
                $data['section_id'] = "";
                $data['feetype'] ="";
                $data['feetype_arr'] = array();
        }else{
         $student_Array = array();
                
                $section=array();

                $classlist=$this->student_model->getAllClassSection(null, null);
            
                $studentlist = $this->student_model->reportClassSectionByregister($register);
             
                // echo "<pre>";
                // print_r($studentlist);
                // exit;
                
                $student_Array=array();
                if (!empty($studentlist)) {
                    foreach ($studentlist as $key => $eachstudent) {
                        $obj = new stdClass();
                        $obj->class = $eachstudent['class'];
                        $obj->section = $eachstudent['section'];
                       
                        $student_session_id = $eachstudent['student_session_id'];
                        $student_total_fees = $this->studentfeemaster_model->getStudentOtherFeesByType($student_session_id,'2');

                        if (!empty($student_total_fees)) {
                            
                            $totalfee = 0;
                            $deposit = 0;
                            $discount = 0;
                            $balance = 0;
                            $fine = 0;
                            foreach ($student_total_fees as $student_total_fees_key => $student_total_fees_value) {
                                if (!empty($student_total_fees_value->fees)) {
                                    foreach ($student_total_fees_value->fees as $each_fee_key => $each_fee_value) {
                                        $totalfee = $totalfee + $each_fee_value->amount;

                                        $amount_detail = json_decode($each_fee_value->amount_detail);
                        
                                        if (is_object($amount_detail)) {
                                            foreach ($amount_detail as $amount_detail_key => $amount_detail_value) {
                                                $deposit = $deposit + $amount_detail_value->amount;
                                                $fine = $fine + $amount_detail_value->amount_fine;
                                                $discount = $discount + $amount_detail_value->amount_discount;
                                            }
                                        }
                                    }
                                }
                            }

                            $obj->totalfee = $totalfee;
                            $obj->payment_mode = "N/A";
                            $obj->deposit = $deposit;
                            $obj->fine = $fine;
                            $obj->discount = $discount;
                            $obj->balance = $totalfee - ($deposit + $discount);
                        } else {

                            $obj->totalfee = 0;
                            $obj->payment_mode = 0;
                            $obj->deposit = 0;
                            $obj->fine = 0;
                            $obj->balance = 0;
                            $obj->discount = 0;
                      
                        }
                        
                        if($obj->balance>0){
                            // $student_Array[] = $obj;
                        }
                        
                      
                        $classlistdata[$eachstudent['class_id']][]=array('class_name'=>$eachstudent['class'],'section' =>$eachstudent['section_id'],'section_name'=>$eachstudent['section'],'result'=>$obj);

                    }
                }

                $data['student_due_fee'] = $obj;
                $data['resultarray']=$classlistdata;
             
                $data['class_id'] = $class_id;
                $data['section_id'] = $section_id;
        }
        
        // echo "<pre>";
        // print_r($data['resultarray']);
        // exit;
        
        
        $this->load->view('layout/header', $data);
        $this->load->view('admin/transaction/studentMiscellaneousReport', $data);
        $this->load->view('layout/footer', $data);
    }
    
    function studentcautionreport() {
        
        if (!$this->rbac->hasPrivilege('balance_fees_report', 'can_view')) {
            access_denied();
        }

        $this->session->set_userdata('top_menu', 'Reports');
        $this->session->set_userdata('sub_menu', 'Reports/fees');
        $this->session->set_userdata('subsub_menu', 'Reports/fees/studentcautionreport');
        $data['title'] = 'student fee';
        $data['title'] = 'student fee';
        $class = $this->class_model->get();
		$data['sch_setting']        = $this->sch_setting_detail;
		$data['adm_auto_insert']    = $this->sch_setting_detail->adm_auto_insert;
        $data['classlist'] = $class;
        $class_id = $this->input->post('class_id');
        $section_id = $this->input->post('section_id');
        $feetype = $this->input->post('feetype');
        $feetype_arr = $this->input->post('feetype_arr');
        
         $register = $this->input->post('register');
         
        $data['section_list']=$this->section_model->getClassBySection($this->input->post('class_id'));
        $this->form_validation->set_rules('register', "Register", 'trim|required|xss_clean');
        // $this->form_validation->set_rules('class_id', $this->lang->line('class'), 'trim|required|xss_clean');
      

        if ($this->form_validation->run() == false) {
            $data['student_due_fee'] = array();
                $data['resultarray']=array();
             
                $data['class_id'] = "";
                $data['section_id'] = "";
                $data['feetype'] ="";
                $data['feetype_arr'] = array();
        }else{
         $student_Array = array();
                
                $section=array();

                $classlist=$this->student_model->getAllClassSection(null, null);
            
                $studentlist = $this->student_model->reportClassSectionByregister($register);
             
                // echo "<pre>";
                // print_r($studentlist);
                // exit;
                
                $student_Array=array();
                if (!empty($studentlist)) {
                    foreach ($studentlist as $key => $eachstudent) {
                        $obj = new stdClass();
                        $obj->class = $eachstudent['class'];
                        $obj->section = $eachstudent['section'];
                       
                        $student_session_id = $eachstudent['student_session_id'];
                        $student_total_fees = $this->studentfeemaster_model->getStudentOtherFeesByType($student_session_id,'1');

                        if (!empty($student_total_fees)) {
                            
                            $totalfee = 0;
                            $deposit = 0;
                            $discount = 0;
                            $balance = 0;
                            $fine = 0;
                            foreach ($student_total_fees as $student_total_fees_key => $student_total_fees_value) {
                                if (!empty($student_total_fees_value->fees)) {
                                    foreach ($student_total_fees_value->fees as $each_fee_key => $each_fee_value) {
                                        $totalfee = $totalfee + $each_fee_value->amount;

                                        $amount_detail = json_decode($each_fee_value->amount_detail);
                        
                                        if (is_object($amount_detail)) {
                                            foreach ($amount_detail as $amount_detail_key => $amount_detail_value) {
                                                $deposit = $deposit + $amount_detail_value->amount;
                                                $fine = $fine + $amount_detail_value->amount_fine;
                                                $discount = $discount + $amount_detail_value->amount_discount;
                                            }
                                        }
                                    }
                                }
                            }

                            $obj->totalfee = $totalfee;
                            $obj->payment_mode = "N/A";
                            $obj->deposit = $deposit;
                            $obj->fine = $fine;
                            $obj->discount = $discount;
                            $obj->balance = $totalfee - ($deposit + $discount);
                        } else {

                            $obj->totalfee = 0;
                            $obj->payment_mode = 0;
                            $obj->deposit = 0;
                            $obj->fine = 0;
                            $obj->balance = 0;
                            $obj->discount = 0;
                      
                        }
                        
                        if($obj->balance>0){
                            // $student_Array[] = $obj;
                        }
                        
                      
                        $classlistdata[$eachstudent['class_id']][]=array('class_name'=>$eachstudent['class'],'section' =>$eachstudent['section_id'],'section_name'=>$eachstudent['section'],'result'=>$obj);

                    }
                }

                $data['student_due_fee'] = $obj;
                $data['resultarray']=$classlistdata;
             
                $data['class_id'] = $class_id;
                $data['section_id'] = $section_id;
        }
        
        // echo "<pre>";
        // print_r($data['resultarray']);
        // exit;
        
        
        $this->load->view('layout/header', $data);
        $this->load->view('admin/transaction/studentCautionReport', $data);
        $this->load->view('layout/footer', $data);
    }
    
    function studentformreport() {
        
        if (!$this->rbac->hasPrivilege('balance_fees_report', 'can_view')) {
            access_denied();
        }

        $this->session->set_userdata('top_menu', 'Reports');
        $this->session->set_userdata('sub_menu', 'Reports/fees');
        $this->session->set_userdata('subsub_menu', 'Reports/fees/studentformreport');
        $data['title'] = 'student fee';
        $data['title'] = 'student fee';
     
		$data['sch_setting']        = $this->sch_setting_detail;
		$data['adm_auto_insert']    = $this->sch_setting_detail->adm_auto_insert;
      
  
        $studentlist = $this->enquiry_model->getenquiry_list1(null);
     
        // echo "<pre>";
        // print_r($studentlist);
        // exit;
        if (!empty($studentlist)) {
            // echo "<pre>";
            // print_r($studentlist);
            // exit;
            foreach ($studentlist as $key => $eachstudent) {
                $obj = new stdClass();
                $obj->class = $eachstudent['class'];
                // $obj->section = $eachstudent['section'];
               
                $student_session_id = $eachstudent['id'];
                $student_total_fees = $this->studentfeemaster_model->getStudentFormFeesByType($student_session_id,'3');

                if (!empty($student_total_fees)) {
                    
                    $totalfee = 0;
                    $deposit = 0;
                    $discount = 0;
                    $balance = 0;
                    $fine = 0;
                    foreach ($student_total_fees as $student_total_fees_key => $student_total_fees_value) {
                        if (!empty($student_total_fees_value->fees)) {
                            foreach ($student_total_fees_value->fees as $each_fee_key => $each_fee_value) {
                                $totalfee = $totalfee + $each_fee_value->amount;

                                $amount_detail = json_decode($each_fee_value->amount_detail);
                
                                if (is_object($amount_detail)) {
                                    foreach ($amount_detail as $amount_detail_key => $amount_detail_value) {
                                        $deposit = $deposit + $amount_detail_value->amount;
                                        $fine = $fine + $amount_detail_value->amount_fine;
                                        $discount = $discount + $amount_detail_value->amount_discount;
                                    }
                                }
                            }
                        }
                    }

                    $obj->totalfee = $totalfee;
                    $obj->payment_mode = "N/A";
                    $obj->deposit = $deposit;
                    $obj->fine = $fine;
                    $obj->discount = $discount;
                    $obj->balance = $totalfee - ($deposit + $discount);
                } else {

                    $obj->totalfee = 0;
                    $obj->payment_mode = 0;
                    $obj->deposit = 0;
                    $obj->fine = 0;
                    $obj->balance = 0;
                    $obj->discount = 0;
              
                }
                
                $classlistdata[$eachstudent['class']][]=array('class_name'=>$eachstudent['classname'],'name'=>$eachstudent['name'],'result'=>$obj);

            }
        }

        $data['student_due_fee'] = $obj;
        $data['resultarray']=$classlistdata;
     
      
        
        // echo "<pre>";
        // print_r($data['resultarray']);
        // exit;
        
        
        $this->load->view('layout/header', $data);
        $this->load->view('admin/transaction/studentFormReport', $data);
        $this->load->view('layout/footer', $data);
    }
    
    public function StudentDueFeesReport()
    {
        if (!$this->rbac->hasPrivilege('search_due_fees', 'can_view')) {
            access_denied();
        }

        $this->session->set_userdata('top_menu', 'Fees Collection');
        $this->session->set_userdata('sub_menu', 'studentfee/StudentDueFeesReport');
        
        $this->session->set_userdata('top_menu', 'Reports');
        $this->session->set_userdata('sub_menu', 'Reports/fees');
        $this->session->set_userdata('subsub_menu', 'Reports/fees/StudentDueFeesReport');
        $data['title'] = 'student fee';
       
        $class             = $this->class_model->get();
        $data['classlist'] = $class;
        $feesessiongroup   = $this->feesessiongroup_model->getFeesByGroup();

        $data['feesessiongrouplist'] = $feesessiongroup;
        $data['fees_group']          = "";
        
        $class_id = $this->input->post('class_id');
        $data['section_list']=$this->section_model->getClassBySection($this->input->post('class_id'));
        $this->form_validation->set_rules('class_id', $this->lang->line('class'), 'trim|required|xss_clean');
      

        if ($this->form_validation->run() == false) {
            $data['student_due_fee'] = array();
            $data['resultarray']=array();
            
            $data['class_id'] = "";
            $data['section_id'] = "";
                
            $this->load->view('layout/header', $data);
            $this->load->view('admin/transaction/studentDueFeesReport', $data);
            $this->load->view('layout/footer', $data);
        } else {
            $data['student_due_fee'] = array();
            $class_id                = $this->input->post('class_id');
            $student_due_fee         = $this->studentfee_model->getDueStudentFees1($class_id);
            
            
            if (!empty($student_due_fee)) {
                foreach ($student_due_fee as $student_due_fee_key => $student_due_fee_value) {
                    $amt_due                                                  = $student_due_fee_value['amount'];
                    $student_due_fee[$student_due_fee_key]['amount_discount'] = 0;
                    $student_due_fee[$student_due_fee_key]['amount_fine']     = 0;
                    $a                                                        = json_decode($student_due_fee_value['amount_detail']);
                    if (!empty($a)) {
                        $amount          = 0;
                        $amount_discount = 0;
                        $amount_fine     = 0;
                        foreach ($a as $a_key => $a_value) {
                            $amount          = $amount + $a_value->amount;
                            $amount_discount = $amount_discount + $a_value->amount_discount;
                            $amount_fine     = $amount_fine + $a_value->amount_fine;
                        }
                        
                        $student_due_fee[$student_due_fee_key]['amount_detail']   = $amount;
                        $student_due_fee[$student_due_fee_key]['amount_discount'] = $amount_discount;
                        $student_due_fee[$student_due_fee_key]['amount_fine']     = $amount_fine;
                       
                    }
                }
            }
            $result = array();
            foreach ($student_due_fee as $element) {
                $result[$element['roll_no']][] = $element;
            }

            $data['student_due_fee'] = $result;
            
            // echo "<pre>";
            // print_r($data['student_due_fee']);
            // exit;
           
            $this->load->view('layout/header', $data);
            $this->load->view('admin/transaction/studentDueFeesReport', $data);
            $this->load->view('layout/footer', $data);
        }
    }
    
    public function StudentBusDueFeesReport()
    {
        if (!$this->rbac->hasPrivilege('search_due_fees', 'can_view')) {
            access_denied();
        }

        $this->session->set_userdata('top_menu', 'Fees Collection');
        $this->session->set_userdata('sub_menu', 'studentfee/StudentBusDueFeesReport');
        
        $this->session->set_userdata('top_menu', 'Reports');
        $this->session->set_userdata('sub_menu', 'Reports/fees');
        $this->session->set_userdata('subsub_menu', 'Reports/fees/StudentBusDueFeesReport');
        $data['title'] = 'student fee';
       
        $class             = $this->class_model->get();
        $data['classlist'] = $class;
        $feesessiongroup   = $this->feesessiongroup_model->getFeesByGroup();

        $data['feesessiongrouplist'] = $feesessiongroup;
        $data['fees_group']          = "";
        
        $class_id = $this->input->post('class_id');
        $data['section_list']=$this->section_model->getClassBySection($this->input->post('class_id'));
        $this->form_validation->set_rules('class_id', $this->lang->line('class'), 'trim|required|xss_clean');
      
        if ($this->form_validation->run() == false) {
            $data['student_due_fee'] = array();
            $data['resultarray']=array();
            
            $data['class_id'] = "";
            $data['section_id'] = "";
                
            $this->load->view('layout/header', $data);
            $this->load->view('admin/transaction/StudentBusDueFeesReport', $data);
            $this->load->view('layout/footer', $data);
        } else {
     
            $data['student_due_fee'] = array();
            $class_id                = $this->input->post('class_id');
            $student_due_fee         = $this->studentfee_model->getDueStudentBusFees($class_id);
        
            if (!empty($student_due_fee)) {
                foreach ($student_due_fee as $student_due_fee_key => $student_due_fee_value) {
                    $amt_due                                                  = $student_due_fee_value['amount'];
                    $student_due_fee[$student_due_fee_key]['amount_discount'] = 0;
                    $student_due_fee[$student_due_fee_key]['amount_fine']     = 0;
                    $a                                                        = json_decode($student_due_fee_value['amount_detail']);
                    if (!empty($a)) {
                        $amount          = 0;
                        $amount_discount = 0;
                        $amount_fine     = 0;
                        foreach ($a as $a_key => $a_value) {
                            $amount          = $amount + $a_value->amount;
                            $amount_discount = $amount_discount + $a_value->amount_discount;
                            $amount_fine     = $amount_fine + $a_value->amount_fine;
                        }
                        
                        $student_due_fee[$student_due_fee_key]['amount_detail']   = $amount;
                        $student_due_fee[$student_due_fee_key]['amount_discount'] = $amount_discount;
                        $student_due_fee[$student_due_fee_key]['amount_fine']     = $amount_fine;
                       
                    }
                }
            }
            $result = array();
            foreach ($student_due_fee as $element) {
                $result[$element['roll_no']][] = $element;
            }

            $data['student_due_fee'] = $result;
            
            // echo "<pre>";
            // print_r($data['student_due_fee']);
            // exit;
           
            $this->load->view('layout/header', $data);
            $this->load->view('admin/transaction/StudentBusDueFeesReport', $data);
            $this->load->view('layout/footer', $data);
        }
      
        
    }
    
    

}

?>