<?php


class Payroll extends Admin_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper('file');
        $this->config->load("mailsms");
        $this->config->load("payroll");
        $this->load->library('mailsmsconf');
        $this->config_attendance = $this->config->item('attendence');
        $this->staff_attendance = $this->config->item('staffattendance');
        $this->payment_mode = $this->config->item('payment_mode');
        $this->load->model("payroll_model");
        $this->load->model("staff_model");
        $this->load->model('staffattendancemodel');
        $this->payroll_status = $this->config->item('payroll_status');
		$this->sch_setting_detail = $this->setting_model->getSetting();
    }

    function index() {

        if (!$this->rbac->hasPrivilege('staff_payroll', 'can_view')) {
            access_denied();
        }

        $this->session->set_userdata('top_menu', 'HR');
        $this->session->set_userdata('sub_menu', 'admin/payroll');
        $data["staff_id"] = "";
        $data["name"] = "";
        $data["month"] = date("F", strtotime("-1 month"));
        $data["year"] = date("Y");
        $data["present"] = 0;
        $data["absent"] = 0;
        $data["late"] = 0;
        $data["half_day"] = 0;
        $data["holiday"] = 0;
        $data["leave_count"] = 0;
        $data["alloted_leave"] = 0;
        $data["basic"] = 0;
        $data["payment_mode"] = $this->payment_mode;
        $user_type = $this->staff_model->getStaffRole();
        $data['classlist'] = $user_type;
        $data['monthlist'] = $this->customlib->getMonthDropdown();
		$data['sch_setting']        = $this->sch_setting_detail;
		$data['staffid_auto_insert'] = $this->sch_setting_detail->staffid_auto_insert;
        $submit = $this->input->post("search");
        if (isset($submit) && $submit == "search") {

            $month = $this->input->post("month");
            $year = $this->input->post("year");
            $emp_name = $this->input->post("name");
            $role = $this->input->post("role");

            $searchEmployee = $this->payroll_model->searchEmployee($month, $year, $emp_name, $role);

            $data["resultlist"] = $searchEmployee;
            $data["name"] = $emp_name;
            $data["month"] = $month;
            $data["year"] = $year;
        }
        
        $data["payroll_status"] = $this->payroll_status;
        $this->load->view("layout/header", $data);
        $this->load->view("admin/payroll/stafflist", $data);
        $this->load->view("layout/footer", $data);
    }

    function create($month, $year, $id) {

        $data["staff_id"] = "";
        $data["basic"] = "";
        $data["name"] = "";
        $data["month"] = "";
        $data["year"] = "";
        $data["present"] = 0;
        $data["absent"] = 0;
        $data["late"] = 0;
        $data["half_day"] = 0;
        $data["holiday"] = 0;
        $data["leave_count"] = 0;
        $data["alloted_leave"] = 0;
		$data['sch_setting']        = $this->sch_setting_detail;
		$data['staffid_auto_insert'] = $this->sch_setting_detail->staffid_auto_insert;
        $user_type = $this->staff_model->getStaffRole();
        $data['classlist'] = $user_type;

        $date = $year . "-" . $month;


        $searchEmployee = $this->payroll_model->searchEmployeeById($id);

        $data['result'] = $searchEmployee;
        $data["month"] = $month;
        $data["year"] = $year;

        $alloted_leave = $this->staff_model->alloted_leave($id);

        $newdate = date('Y-m-d', strtotime($date . " +1 month"));

        $data['monthAttendance'] = $this->monthAttendance($newdate, 3, $id);
        $data['monthLeaves'] = $this->monthLeaves($newdate, 3, $id);

        $data["attendanceType"] = $this->staffattendancemodel->getStaffAttendanceType();

        $data["alloted_leave"] = $alloted_leave[0]["alloted_leave"];
        
        // echo "<pre>";
      
        $basic_salary = $searchEmployee['basic_salary'];
        //echo "<br>Basic Salary :".$basic_salary;
        
        
        $pf = $searchEmployee['pf'];
        
        //echo "<br>Pf Both Side :".$pf ;
        
        $pf_one_side = $pf/2;
        //echo "<br>Pf One Side :".$pf_one_side;
        
        $esi = $searchEmployee['esi'];
        //echo "<br>Esi :".$esi;
        
        
        $sf = $searchEmployee['sf'];
        //echo "<br>Securiry Fund :".$sf;
        
        $to_time = strtotime($searchEmployee['in_time']);
        $from_time = strtotime($searchEmployee['out_time']);
        
        $total_time = round(abs($to_time - $from_time) / 60,2);
        
        //echo "<br>Total minut (Total Time) : ". $total_time;
        
        $absent_time_let = '30';
        
        //echo "<br>Absent minut (Absent Time): $absent_time_let";
        
        $over_time = '50';
        
        //echo "<br>over time minut (Over Time): $over_time";
        
        $absent = 2;
        
        //echo "<br>Absent (let absent): $absent"; 
        
        //echo "<br><br>**********************<br>";
        
        
        $month_both_side_pf = $pf*30;
        //echo "<br>Month Both side Pf :".$month_both_side_pf;
        
        
        $month_one_side_pf = $month_both_side_pf/2;
        //echo "<br>Month one side Pf :".$month_one_side_pf;
        
        //echo "<br><br>**********************<br>";
        
        $perday_salary_with_pf1 = ($basic_salary/30);
        $perday_salary_with_pf =  round($perday_salary_with_pf1,2);
       // echo "<br>Per Day Salary with Pf :".$perday_salary_with_pf ;
        
        $perday_salary_without_pf1 = ($basic_salary-$month_both_side_pf)/30;
        $perday_salary_without_pf = round($perday_salary_without_pf1,2);
        //echo "<br>Per Day Salary without Pf :".$perday_salary_without_pf;
        
        $salary_without_pf1 = $perday_salary_without_pf*30;
        
        $salary_without_pf =round($salary_without_pf1);
        //echo "<br>Month Salary without Pf :". $salary_without_pf;
        
        //echo "<br><br>**********************<br>";
        
        $perday_salary_with_one_side_pf1 = $perday_salary_without_pf+$pf_one_side;
        
        $perday_salary_with_one_side_pf= round($perday_salary_with_one_side_pf1,2);
        
        //echo "<br>Per Day Salary with One Side Pf :". $perday_salary_with_one_side_pf ;
        
        $salary_with_one_side_pf1 = ($perday_salary_with_one_side_pf*30);
        
        $salary_with_one_side_pf = round($salary_with_one_side_pf1);
        
        //echo "<br>Month Salary with One Side Pf :". $salary_with_one_side_pf;
        
        $absent_rupee1 = ($absent*$perday_salary_with_one_side_pf);
        
        $absent_rupee = round($absent_rupee1);
        
        //echo "<br>Absent in Rupee :". $absent_rupee;
        
        //echo "<br><br>**********************<br>";
        
        $absent_in_time1 = ($perday_salary_with_one_side_pf/$total_time);
        
        $absent_in_time = $absent_in_time1*$absent_time_let;
        
        $absent_in_time_overtime =$absent_in_time1*$over_time;
        
        //echo "<br>Absent Time in Rupee :". $absent_in_time;
        
        //echo "<br>over time in Rupee :". $absent_in_time_overtime;

        $gross_salary = ($salary_with_one_side_pf-$absent_rupee-$absent_in_time+$absent_in_time_overtime);
         
        //echo "<br>Gross Salary:". $gross_salary;
        
        $salary_esi = ($gross_salary*$esi)/100;
        
        //echo "<br>Esi on Salary :". $salary_esi;
        
        
      
        $payroll_arr = array(
            'basic_salary' => $searchEmployee['basic_salary'],
            'pf' => $searchEmployee['pf'],
            'pf_one_side' => $pf_one_side,
            'esi' => $searchEmployee['esi'],
            'sf' => $searchEmployee['sf'],
            'total_time' => $total_time,
            'month_both_pf' => $month_both_side_pf,
            'month_one_pf' => $month_one_side_pf,
            'per_day_salary_with_pf' => $perday_salary_with_pf,
            'per_day_salary_without_pf' => $perday_salary_without_pf,
            'salary_without_pf' => $salary_without_pf,
            'perday_salary_with_one_side_pf' => $perday_salary_with_one_side_pf,
            'month_salary_with_one_side_pf' => $salary_with_one_side_pf
        );
       
        $data['payrol']=$payroll_arr;
        
        // echo "<pre>";
        // print_r($data['payrol']);
        // exit;
       
        

        $this->load->view("layout/header", $data);
        $this->load->view("admin/payroll/create", $data);
        $this->load->view("layout/footer", $data);
    }

    function monthAttendance($st_month, $no_of_months, $emp) {
        $record = array();
        for ($i = 1; $i <= $no_of_months; $i++) {

            $r = array();
            $month = date('m', strtotime($st_month . " -$i month"));
            $year = date('Y', strtotime($st_month . " -$i month"));


            foreach ($this->staff_attendance as $att_key => $att_value) {

                $s = $this->payroll_model->count_attendance_obj($month, $year, $emp, $att_value);


                $r[$att_key] = $s;
            }

            $record['01-' . $month . '-' . $year] = $r;
        }
        return $record;
    }

    function monthLeaves($st_month, $no_of_months, $emp) {
        $record = array();
        for ($i = 1; $i <= $no_of_months; $i++) {

            $r = array();
            $month = date('m', strtotime($st_month . " -$i month"));
            $year = date('Y', strtotime($st_month . " -$i month"));
            $leave_count = $this->staff_model->count_leave($month, $year, $emp);
            if (!empty($leave_count["tl"])) {
                $l = $leave_count["tl"];
            } else {
                $l = "0";
            }

            $record[$month] = $l;
        }

        return $record;
    }

    function payslip() {
        
        // echo "<pre>";
        // print_r($this->input->post());
        // exit;
        
        if (!$this->rbac->hasPrivilege('staff_payroll', 'can_add')) {
            access_denied();
        }
       // print_r($_POST);die;
        $basic = $this->input->post("basic");
        $late_time = $this->input->post("late_time");
        $over_time = $this->input->post("over_time");
        $absent_day = $this->input->post("absent_day");
        $pf = (!empty($this->input->post("pf"))) ? $this->input->post("pf") : 0;
        $esi = $this->input->post("esi");
        $sf = (!empty($this->input->post("sf"))) ? $this->input->post("sf") : 0;
        $pf_one_side =   (!empty($this->input->post("pf_one_side"))) ? $this->input->post("pf_one_side") : 0;  
        $month_both_pf =  (!empty($this->input->post("month_both_pf"))) ? $this->input->post("month_both_pf") : 0;
        $month_one_pf =  (!empty($this->input->post("month_one_pf"))) ? $this->input->post("month_one_pf") : 0;
        $per_day_salary_with_pf= (!empty($this->input->post("per_day_salary_with_pf"))) ? $this->input->post("per_day_salary_with_pf") : 0;
        $per_day_salary_without_pf = (!empty($this->input->post("per_day_salary_without_pf"))) ? $this->input->post("per_day_salary_without_pf") : 0;
        $salary_without_pf =  (!empty($this->input->post("salary_without_pf"))) ? $this->input->post("salary_without_pf") : 0;
        $perday_salary_with_one_side_pf = (!empty($this->input->post("perday_salary_with_one_side_pf"))) ? $this->input->post("perday_salary_with_one_side_pf") : 0;
        $month_salary_with_one_side_pf = (!empty($this->input->post("month_salary_with_one_side_pf"))) ? $this->input->post("month_salary_with_one_side_pf") : 0;
        $total_time = (!empty($this->input->post("total_time"))) ? $this->input->post("total_time") : 0;
        $absent_rupee = (!empty($this->input->post("absent_rupee"))) ? $this->input->post("absent_rupee") : 0;
        $absent_time_rupee = $this->input->post("absent_time_rupee");
        $over_time_rupee = $this->input->post("over_time_rupee");
        $salary_esi = $this->input->post("salary_esi");
        $gross_salary = $this->input->post("gross_salary");
        $net_salary = $this->input->post("net_salary");
        $advance = $this->input->post("advance");
        $cl = (!empty($this->input->post("cl"))) ? $this->input->post("cl") : 0;;
        $salary_main = $this->input->post("salary_main");
        $hra = $this->input->post("hra");
        $city_allowance = $this->input->post("city_allowance");
        $conveyance_allowance = $this->input->post("conveyance_allowance");
        $attendance_allowance = $this->input->post("attendance_allowance");
        $gross_salary_allowance = $this->input->post("gross_salary_allowance");
        $status = $this->input->post("status");
        $staff_id = $this->input->post("staff_id");
        $month = $this->input->post("month");
        $name = $this->input->post("name");
        $year = $this->input->post("year");

        // $total_allowance = $this->input->post("total_allowance");
        // $total_deduction = $this->input->post("total_deduction");
        // $tax = $this->input->post("tax");
        // $leave_deduction = $this->input->post("leave_deduction");

 

        $this->form_validation->set_rules('net_salary', 'Net Salary', 'trim|required|xss_clean');
        if ($this->form_validation->run() == FALSE) {

            $this->create($month, $year, $staff_id);
        } else {

            $data = array(
                'staff_id' => $staff_id,
                'basic' => $basic,
                'late_time' => $late_time,
                'over_time' => $over_time,
                'absent_day' => $absent_day,
                'pf' => $pf,
                'sf' => $sf, 
                'pf_one_side' => $pf_one_side,
                'month_both_pf' => $month_both_pf,
                'month_one_pf' => $month_one_pf,
                'per_day_salary_with_pf' => $per_day_salary_with_pf,
                'per_day_salary_without_pf' => $per_day_salary_without_pf,
                'salary_without_pf' => $salary_without_pf,
                'perday_salary_with_one_side_pf' => $perday_salary_with_one_side_pf,
                'month_salary_with_one_side_pf' => $month_salary_with_one_side_pf,
                'total_time' => $total_time,
                'absent_rupee' => $absent_rupee,
                'absent_time_rupee' => $absent_time_rupee,
                'over_time_rupee' => $over_time_rupee,
                'salary_esi' => $salary_esi,
                'gross_salary' => $gross_salary,
                // 'total_allowance' => $total_allowance,
                // 'total_deduction' => $total_deduction,
                'net_salary' => $net_salary,
                'advance' => $advance,
                'cl' => $cl,
                'salary_main' => $salary_main,
                'hra' => $hra,
                'city_allowance' => $city_allowance,
                'conveyance_allowance' => $conveyance_allowance,
                'attendance_allowance' => $attendance_allowance,
                'gross_salary_allowance' => $gross_salary_allowance,
                'payment_date' => date("Y-m-d"),
                'status' => $status,
                'month' => $month,
                'year' => $year,
                // 'tax' => $tax,
                // 'leave_deduction' => '0'
            );
            // echo "<pre>";
            // print_r($data);
            // exit;
            
            

            $checkForUpdate = $this->payroll_model->checkPayslip($month, $year, $staff_id);
          
            if ($checkForUpdate == true) {
               // print_r($data);die;
                $insert_id = $this->payroll_model->createPayslip($data);

                $payslipid = $insert_id;
                
                // $allowance_type = $this->input->post("allowance_type");
                // $deduction_type = $this->input->post("deduction_type");

                // $allowance_amount = $this->input->post("allowance_amount");
                // $deduction_amount = $this->input->post("deduction_amount");
                // if (!empty($allowance_type)) {

                //     $i = 0;
                //     foreach ($allowance_type as $key => $all) {

                //         $all_data = array('payslip_id' => $payslipid,
                //             'allowance_type' => $allowance_type[$i],
                //             'amount' => $allowance_amount[$i],
                //             'staff_id' => $staff_id,
                //             'cal_type' => "positive",
                //         );

                //         $insert_payslip_allowance = $this->payroll_model->add_allowance($all_data);

                //         $i++;
                //     }
                // }

                // if (!empty($deduction_type)) {
                //     $j = 0;
                //     foreach ($deduction_type as $key => $type) {

                //         $type_data = array('payslip_id' => $payslipid,
                //             'allowance_type' => $deduction_type[$j],
                //             'amount' => $deduction_amount[$j],
                //             'staff_id' => $staff_id,
                //             'cal_type' => "negative",
                //         );

                //         $insert_payslip_allowance = $this->payroll_model->add_allowance($type_data);

                //         $j++;
                //     }
                // }
                $this->session->set_flashdata("msg", "Payslip Generated Successfully");
                redirect('admin/payroll');
            } else {

                $this->session->set_flashdata("msg", $this->lang->line('payslip_already_generated'));

                redirect('admin/payroll');
            }
        }
    }

   

    function search($month, $year, $role = '') {

        $user_type = $this->staff_model->getStaffRole();
        $data['classlist'] = $user_type;
        $data['monthlist'] = $this->customlib->getMonthDropdown();

        $searchEmployee = $this->payroll_model->searchEmployee($month, $year, $emp_name = '', $role);

        $data["resultlist"] = $searchEmployee;
        $data["name"] = $emp_name;
        $data["month"] = $month;
        $data["year"] = $year;
        $data['sch_setting']        = $this->sch_setting_detail;
        
        $data["payroll_status"] = $this->payroll_status;
        $data["resultlist"] = $searchEmployee;
        $data["payment_mode"] = $this->payment_mode;

        $this->load->view("layout/header", $data);
        $this->load->view("admin/payroll/stafflist", $data);
        $this->load->view("layout/footer", $data);
    }

    function paymentRecord() {

        $month = $this->input->get_post("month");
        $year = $this->input->get_post("year");
        $id = $this->input->get_post("staffid");

        $searchEmployee = $this->payroll_model->searchPayment($id, $month, $year);
        $data['result'] = $searchEmployee;
        $data["month"] = $month;
        $data["year"] = $year;
        echo json_encode($data);
    }

    function paymentStatus($status) {

        $id = $this->input->get('id');

        $updateStaus = $this->payroll_model->updatePaymentStatus($status, $id);

        redirect("admin/payroll");
    }

    function paymentSuccess() {

        $payment_mode = $this->input->post("payment_mode");
        $date = $this->input->post("payment_date");
        $payment_date = date('Y-m-d', strtotime($date));
        $remark = $this->input->post("remarks");
        $status = 'paid';
        $payslipid = $this->input->post("paymentid");
        $this->form_validation->set_rules('payment_mode', $this->lang->line('payment_mode'), 'trim|required|xss_clean');
        if ($this->form_validation->run() == FALSE) {

            $msg = array(
                'payment_mode' => form_error('payment_mode'),
            );
            $array = array('status' => 'fail', 'error' => $msg, 'message' => '');
        } else {

            $data = array('payment_mode' => $payment_mode, 'payment_date' => $payment_date, 'remark' => $remark, 'status' => $status);


            $this->payroll_model->paymentSuccess($data, $payslipid);
            $array = array('status' => 'success', 'error' => '', 'message' => $this->lang->line('success_message'));
        }
        echo json_encode($array);
    }

    function payslipView() {
        if (!$this->rbac->hasPrivilege('staff', 'can_view')) {
            access_denied();
        } 
        $data["payment_mode"] = $this->payment_mode;
        $this->load->model("setting_model");
        $setting_result = $this->setting_model->get();
        $data['settinglist'] = $setting_result[0];
        $id = $this->input->post("payslipid");
        $result = $this->payroll_model->getPayslip($id);
        $data['sch_setting']        = $this->sch_setting_detail;

        $data['staffid_auto_insert'] = $this->sch_setting_detail->staffid_auto_insert;
       if(!empty($result)){ 
        $allowance = $this->payroll_model->getAllowance($result["id"]);
        $data["allowance"] = $allowance;
        $positive_allowance = $this->payroll_model->getAllowance($result["id"], "positive");
        $data["positive_allowance"] = $positive_allowance;
        $negative_allowance = $this->payroll_model->getAllowance($result["id"], "negative");
        $data["negative_allowance"] = $negative_allowance;
        $data["result"] = $result;
         $this->load->view("admin/payroll/payslipview", $data);
        }else{
            echo "<div class='alert alert-info'>No Record Found.</div>";
        }
       
    }

    function payslippdf() {

        $this->load->model("setting_model");
        $setting_result = $this->setting_model->get();
        $data['settinglist'] = $setting_result[0];
        // $id = $this->input->post("payslipid");
        $id = 15;
        $result = $this->payroll_model->getPayslip($id);
        $allowance = $this->payroll_model->getAllowance($result["id"]);
        $data["allowance"] = $allowance;
        $positive_allowance = $this->payroll_model->getAllowance($result["id"], "positive");
        $data["positive_allowance"] = $positive_allowance;
        $negative_allowance = $this->payroll_model->getAllowance($result["id"], "negative");
        $data["negative_allowance"] = $negative_allowance;
        $data["result"] = $result;
        $this->load->view("admin/payroll/payslippdf", $data);
    }

    function payrollreport() {
        if (!$this->rbac->hasPrivilege('payroll_report', 'can_view')) {
            access_denied();
        }
        $this->session->set_userdata('top_menu', 'Reports');
        $this->session->set_userdata('sub_menu', 'Reports/human_resource');
        $this->session->set_userdata('subsub_menu','Reports/attendance/attendance_report');
        $month = $this->input->post("month");
        $year = $this->input->post("year");
        $role = $this->input->post("role");
        $data["month"] = $month;
        $data["year"] = $year;
        $data["role_select"] = $role;
        $data['monthlist'] = $this->customlib->getMonthDropdown();
        $data['yearlist'] = $this->payroll_model->payrollYearCount();
        $staffRole = $this->staff_model->getStaffRole();
        $data["role"] = $staffRole;
        $data["payment_mode"] = $this->payment_mode;

        $this->form_validation->set_rules('year', $this->lang->line('year'), 'trim|required|xss_clean');
        if ($this->form_validation->run() == FALSE) {

            $this->load->view("layout/header", $data);
            $this->load->view("admin/payroll/payrollreport", $data);
            $this->load->view("layout/footer", $data);
            
        }else {

            $result = $this->payroll_model->getpayrollReport($month, $year, $role);
            $data["result"] = $result;

            // echo "<pre>";
            // print_r($data["result"]);
            // exit;
            
            $this->load->view("layout/header", $data);
            $this->load->view("admin/payroll/payrollreport", $data);
            $this->load->view("layout/footer", $data);
        }
    }
    
    function paymentreport() {
        if (!$this->rbac->hasPrivilege('payroll_report', 'can_view')) {
            access_denied();
        }
        $this->session->set_userdata('top_menu', 'Reports');
        $this->session->set_userdata('sub_menu', 'Reports/human_resource');
        $this->session->set_userdata('subsub_menu','Reports/payment/payment_report');
        $month = $this->input->post("month");
        
        $year = $this->input->post("year");
        $role = $this->input->post("role");
        $data["month"] = $month;
        $data["year"] = $year;
        $data["role_select"] = $role;
        $data['monthlist'] = $this->customlib->getMonthDropdown();
        $data['yearlist'] = $this->payroll_model->payrollYearCount();
        $staffRole = $this->staff_model->getStaffRole();
        $data["role"] = $staffRole;
        $data["payment_mode"] = $this->payment_mode;

        $this->form_validation->set_rules('year', $this->lang->line('year'), 'trim|required|xss_clean');
        if ($this->form_validation->run() == FALSE) {

            $this->load->view("layout/header", $data);
            $this->load->view("admin/payroll/paymentreport", $data);
            $this->load->view("layout/footer", $data);
            
        }else {

            //$month1 = implode(",",$month);
            // exit;
            $result = $this->payroll_model->getpayrollReport1($month, $year, $role);
            $data["result"] = $result;

            // echo "<pre>";
            // print_r($data["result"]);
            // exit;
            
            $this->load->view("layout/header", $data);
            $this->load->view("admin/payroll/paymentreport", $data);
            $this->load->view("layout/footer", $data);
        }
    }

    function deletepayroll($payslipid, $month, $year, $role = '') {
        if (!$this->rbac->hasPrivilege('staff_payroll', 'can_delete')) {
            access_denied();
        }
        if (!empty($payslipid)) {

            $this->payroll_model->deletePayslip($payslipid);
        }
        //redirect("admin/payroll");
        redirect('admin/payroll/search/' . $month . "/" . $year . "/" . $role);
    }

    function revertpayroll($payslipid, $month, $year, $role = '') {


        if (!$this->rbac->hasPrivilege('staff_payroll', 'can_delete')) {
            access_denied();
        }
        if (!empty($payslipid)) {

            $this->payroll_model->revertPayslipStatus($payslipid);
        }
        redirect('admin/payroll/search/' . $month . "/" . $year . "/" . $role);
        //$this->search($month,$year,$role);
        //redirect("admin/payroll");
    }

}

?>