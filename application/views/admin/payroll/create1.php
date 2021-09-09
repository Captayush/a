<?php
$currency_symbol = $this->customlib->getSchoolCurrencyFormat();
?>

<style>
    .form-horizontal .control-label{
        text-align: left !important;
    }
</style>
<div class="content-wrapper" style="min-height: 393px;">   
    <section class="content-header">
        <h1><i class="fa fa-sitemap"></i> <?php echo $this->lang->line('human_resource'); ?></h1>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header">
                        <div class="row">
                            <div class="col-md-4">
                                <h3 class="box-title"><?php echo $this->lang->line('staff'); ?> <?php echo $this->lang->line('details'); ?></h3>
                            </div>  
                            <div class="col-md-8 ">
                                <div class="btn-group pull-right">
                                    <a href="<?php echo base_url() ?>admin/payroll" type="button" class="btn btn-primary btn-xs">
                                        <i class="fa fa-arrow-left"></i> </a>
                                </div>
                            </div>
                        </div>  
                    </div><!--./box-header-->    
                    <div class="box-body" style="padding-top:0;">
                        <div class="row">
                            <div class="col-md-8 col-sm-12">
                                <div class="sfborder">  
                                    <div class="col-md-2">
                                        <div class="row">
                                            <?php
                                            $image = $result['image'];
                                            if (!empty($image)) {

                                                $file = $result['image'];
                                            } else {

                                                $file = "no_image.png";
                                            }
                                            ?>
                                            <img width="115" height="115" class="round5" src="<?php echo base_url() . "uploads/staff_images/" . $file ?>" alt="No Image">
                                        </div>
                                    </div>  

                                    <div class="col-md-10">
                                        <div class="row">
                                            <table class="table mb0 font13">
                                                <tbody>
                                                    <tr>
                                                        <th class="bozero"><?php echo $this->lang->line("name"); ?></th>
                                                        <td class="bozero"><?php echo $result["name"] . " " . $result["surname"] ?></td>
												
                                                        <th class="bozero"><?php echo $this->lang->line('staff_id'); ?></th>
                                                        <td class="bozero"><?php echo $result["employee_id"] ?></td>
													
                                                    </tr>

                                                    <tr>
														<?php if ($sch_setting->staff_phone) {  ?>
                                                        <th><?php echo $this->lang->line('phone'); ?></th>
														<?php } ?>
                                                        <td><?php echo $result["contact_no"] ?></td>
                                                        <th><?php echo $this->lang->line('email'); ?></th>
                                                        <td><?php echo $result["email"] ?>                                   </td>
                                                    </tr>
                                                    <tr>
														<?php if ($sch_setting->staff_epf_no) {  ?>
                                                        <th><?php echo $this->lang->line('epf_no'); ?></th>
                                                        <td><?php echo $result["epf_no"] ?></td>
														<?php } ?>
                                                        <th><?php echo $this->lang->line('role'); ?></th>
                                                        <td><?php echo $result["user_type"] ?></td>                                  
                                                    </tr>
                                                    <tr>
														<?php if ($sch_setting->staff_department) {  ?>
                                                        <th><?php echo $this->lang->line('department'); ?></th>
                                                        <td><?php echo $result["department"] ?></td>
														<?php } if ($sch_setting->staff_designation) {  ?>
                                                        <th><?php echo $this->lang->line('designation'); ?></th>
                                                        <td><?php echo $result["designation"] ?>   </td>
														<?php } ?>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>


                                </div></div><!--./col-md-8-->
                            <div class="col-md-4 col-sm-12">

                                <div class="sfborder relative overvisible"> 
                                    <div class="letest">
                                        <div class="rotatetest"><?php echo $this->lang->line("attendance") ?></div>
                                    </div> 
                                    <div class="padd-en-rtl33"> 
                                        <table class="table mb0 font13" >
                                            <tr>
                                                <th  class="bozero"><?php echo $this->lang->line('month'); ?></th>
                                                <?php foreach ($attendanceType as $key => $value) { ?>
                                                    <th class="bozero"><span data-toggle="tooltip" title="<?php echo $value["type"]; ?>"><?php echo strip_tags($value["key_value"]); ?></span></th>  
                                                <?php }
                                                ?>

                                                <th class="bozero"><span data-toggle="tooltip" title="<?php echo $this->lang->line('approved'); ?> <?php echo $this->lang->line('leave'); ?>">V</span></th>
                                            </tr>
                                            <?php
                                            foreach ($monthAttendance as $attendence_key => $attendence_value) {
                                                ?><tr>
                                                    <td><?php echo date("F", strtotime($attendence_key)); ?></td>
                                                    <td><?php echo $attendence_value['present'] ?></td>
                                                    <td><?php echo $attendence_value['late']; ?></td> 
                                                    <td><?php echo $attendence_value['absent']; ?></td> 
                                                    <td><?php echo $attendence_value['half_day']; ?></td> 
                                                    <td><?php echo $attendence_value['holiday']; ?></td>
                                                    <td><?php echo $monthLeaves[date("m", strtotime($attendence_key))]; ?></td>                                   
                                                </tr>
                                                <?php
                                            }
                                            ?>
                                            <tr>


                                            </tr>

                                        </table>
                                    </div>
                                </div>

                            </div><!--./col-md-8-->   
                            <div class="col-md-12">
                                <div style="background: #dadada; height: 1px; width: 100%; clear: both; margin-bottom: 10px;"></div>
                            </div>
                        </div>

                    </div>
                    <!-- /.box-body -->
                    <form class="form-horizontal" action="<?php echo site_url('admin/payroll/payslip') ?>" method="post"  id="employeeform">
                        <div class="box-header">
                            <div class="row display-flex">
                                <!--<div class="col-md-4 col-sm-4">-->
                                <!--    <h3 class="box-title"><?php echo $this->lang->line('earning'); ?></h3>-->
                                <!--    <button type="button" onclick="add_more()" class="plusign"><i class="fa fa-plus"></i></button>-->
                                <!--    <div class="sameheight">-->
                                <!--        <div class="feebox">-->
                                <!--            <table class="table3" id="tableID">-->
                                <!--                <tr id="row0">-->
                                <!--                    <td><input type="text" class="form-control" id="allowance_type" name="allowance_type[]" placeholder="Type"></td>-->
                                <!--                    <td><input type="text" id="allowance_amount" name="allowance_amount[]" class="form-control" value="0"></td>-->

                                <!--                </tr>-->
                                <!--            </table>-->
                                <!--        </div>  -->
                                <!--    </div>-->
                                <!--</div>-->
                                <!--./col-md-4-->
                                
                                
                                <!--<div class="col-md-4 col-sm-4">-->

                                <!--    <h3 class="box-title"><?php echo $this->lang->line('deduction'); ?></h3>-->
                                <!--    <button type="button" onclick="add_more_deduction()" class="plusign"><i class="fa fa-plus"></i></button>-->
                                <!--    <div class="sameheight">-->
                                <!--        <div class="feebox">-->
                                <!--            <table class="table3" id="tableID2">-->
                                <!--                <tr id="deduction_row0">-->
                                <!--                    <td><input type="text" id="deduction_type" name="deduction_type[]" class="form-control" placeholder="Type"></td>-->
                                <!--                    <td><input type="text" id="deduction_amount" name="deduction_amount[]" class="form-control" value="0"></td>-->

                                <!--                </tr>-->

                                <!--            </table>-->
                                <!--        </div>-->
                                <!--    </div>  -->
                                <!--</div>-->
                                
                                 <div class="col-md-4 col-sm-4">

                                    <h3 class="box-title"><?php echo $this->lang->line('payroll'); ?> <?php echo $this->lang->line('summary'); ?>(<?php echo $currency_symbol ?>)</h3>
                                    <button type="button" onclick="add_allowance()" class="plusign"><i class="fa fa-calculator"></i> <?php echo $this->lang->line('calculate'); ?></button>
                                    <div class="sameheight" style="height: 96%;padding: 5px;">
                                        <div class="payrollbox feebox">
                                            <div class="form-group">
                                                <label class="col-sm-4 control-label">
                                                    <?php //echo $this->lang->line('basic_salary'); ?>
                                                    Salary With PF
                                                </label>
                                                <div class="col-sm-8">
                                                    <input class="form-control" name="basic" value="<?php
                                                    if (!empty($payrol["basic_salary"])) {
                                                        echo $payrol["basic_salary"];
                                                    } else {
                                                        echo "0";
                                                    }
                                                    ?>" id="basic"  type="text" />
                                                </div>
                                            </div>
                                            
                                            
                                             <div class="form-group">
                                                <label class="col-sm-4 control-label">Salary With PF Per Day</label>
                                                <div class="col-sm-8">
                                                    <input class="form-control" name="per_day_salary_with_pf" id="per_day_salary_with_pf" value="<?php
                                                    if (!empty($payrol["per_day_salary_with_pf"])) {
                                                        echo $payrol["per_day_salary_with_pf"];
                                                    } else {
                                                        echo "0";
                                                    }
                                                    ?>" type="text"/>
                                                </div>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label class="col-sm-4 control-label">Salary With One Side PF</label>
                                                <div class="col-sm-8">
                                                    <input class="form-control" name="month_salary_with_one_side_pf" id="month_salary_with_one_side_pf" value="<?php
                                                    if (!empty($payrol["month_salary_with_one_side_pf"])) {
                                                        echo $payrol["month_salary_with_one_side_pf"];
                                                    } else {
                                                        echo "0";
                                                    }
                                                    ?>" type="text"/>
                                                    
                                                    <input class="form-control" name="total_time" id="total_time" value="<?php
                                                    if (!empty($payrol["total_time"])) {
                                                        echo $payrol["total_time"];
                                                    } else {
                                                        echo "0";
                                                    }
                                                    ?>" type="hidden"/>
                                                </div>
                                            </div>
                                            
                                             <div class="form-group">
                                                <label class="col-sm-4 control-label"> Salary With One Side PF Per Day</label>
                                                <div class="col-sm-8">
                                                    <input class="form-control" name="perday_salary_with_one_side_pf" id="perday_salary_with_one_side_pf" value="<?php
                                                    if (!empty($payrol["perday_salary_with_one_side_pf"])) {
                                                        echo $payrol["perday_salary_with_one_side_pf"];
                                                    } else {
                                                        echo "0";
                                                    }
                                                    ?>" type="text"/>
                                                </div>
                                            </div>
                                        
                                            <div class="form-group">
                                                <label class="col-sm-4 control-label">Salary Without PF</label>
                                                <div class="col-sm-8">
                                                    <input class="form-control" name="salary_without_pf" id="salary_without_pf" value="<?php
                                                    if (!empty($payrol["salary_without_pf"])) {
                                                        echo $payrol["salary_without_pf"];
                                                    } else {
                                                        echo "0";
                                                    }
                                                    ?>" type="text"/>
                                                </div>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label class="col-sm-4 control-label">Salary Without PF Per Day</label>
                                                <div class="col-sm-8">
                                                    <input class="form-control" name="per_day_salary_without_pf" id="per_day_salary_without_pf" value="<?php
                                                    if (!empty($payrol["per_day_salary_without_pf"])) {
                                                        echo $payrol["per_day_salary_without_pf"];
                                                    } else {
                                                        echo "0";
                                                    }
                                                    ?>" type="text"/>
                                                </div>
                                            </div>
       
                                            <div class="form-group">
                                                <label class="col-sm-4 control-label">PF Both Side Per Day</label>
                                                <div class="col-sm-8">
                                                    <input class="form-control" name="pf" id="pf" value="<?php
                                                    if (!empty($payrol["pf"])) {
                                                        echo $payrol["pf"];
                                                    } else {
                                                        echo "0";
                                                    }
                                                    ?>" type="text" />
                                                </div>
                                            </div>
                                            
                                             <div class="form-group">
                                                <label class="col-sm-4 control-label">PF One Side Per day</label>
                                                <div class="col-sm-8">
                                                    <input class="form-control" name="pf_one_side" id="pf_one_side" value="<?php
                                                    if (!empty($payrol["pf_one_side"])) {
                                                        echo $payrol["pf_one_side"];
                                                    } else {
                                                        echo "0";
                                                    }
                                                    ?>" type="text"/>
                                                </div>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label class="col-sm-4 control-label" style="color:red;">Absent (Rupees)</label>
                                                <div class="col-sm-8">
                                                    <input class="form-control" name="absent_rupee" id="absent_rupee" value="0" type="text" style="color:red;"/>
                                                </div>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label class="col-sm-4 control-label" style="color:red;">Late Time (Rupees)</label>
                                                <div class="col-sm-8">
                                                    <input class="form-control" name="absent_time_rupee" id="absent_time_rupee" value="0" type="text"style="color:red;"/>
                                                </div>
                                            </div>
                                            
                                            
                                            <div class="form-group">
                                                <label class="col-sm-4 control-label" style="color:green;">Over Time (Rupees)</label>
                                                <div class="col-sm-8">
                                                    <input class="form-control" name="over_time_rupee" id="over_time_rupee" value="0" type="text" style="color:green;"/>
                                                </div>
                                            </div>
                                            
                                             <div class="form-group">
                                                <label class="col-sm-4 control-label">Monthly PF One Side</label>
                                                <div class="col-sm-8">
                                                    <input class="form-control" id="month_one_pf1" value="<?php
                                                    if (!empty($payrol["month_one_pf"])) {
                                                        echo $payrol["month_one_pf"];
                                                    } else {
                                                        echo "0";
                                                    }
                                                    ?>" type="hidden"/>
                                                    
                                                    <input class="form-control" name="month_one_pf" id="month_one_pf" value="0" type="text"/>
                                                </div>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label class="col-sm-4 control-label">Monthly PF Both Side</label>
                                                <div class="col-sm-8">
                                                    <input class="form-control" id="month_both_pf1" value="<?php
                                                    if (!empty($payrol["month_both_pf"])) {
                                                        echo $payrol["month_both_pf"];
                                                    } else {
                                                        echo "0";
                                                    }
                                                    ?>" type="hidden"/>
                                                    
                                                    <input class="form-control" name="month_both_pf" id="month_both_pf" value="0" type="text"/>
                                                </div>
                                            </div>
                                            
                                            
                                            <div class="form-group" style="display:none;">
                                                <label class="col-sm-4 control-label">Esi</label>
                                                <div class="col-sm-8">
                                                    <input class="form-control" name="esi" id="esi" value="<?php
                                                    if (!empty($payrol["esi"])) {
                                                        echo $payrol["esi"];
                                                    } else {
                                                        echo "0";
                                                    }
                                                    ?>" type="hidden"/>
                                                </div>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label class="col-sm-4 control-label" style="color:red;">ESI</label>
                                                <div class="col-sm-8">
                                                    <input class="form-control" name="salary_esi" id="salary_esi" value="0" type="text" style="color:red;"/>
                                                </div>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label class="col-sm-4 control-label" style="color:red;">Security fund</label>
                                                <div class="col-sm-8">
                                                    <input class="form-control" name="sf" id="sf" value="<?php
                                                    if (!empty($payrol["sf"])) {
                                                        echo $payrol["sf"];
                                                    } else {
                                                        echo "0";
                                                    }
                                                    ?>" type="text" style="color:red;"/>
                                                </div>
                                            </div>
                                            
                                            
                                             <div class="form-group">
                                                <label class="col-sm-4 control-label" style="color:red;">Advance</label>
                                                <div class="col-sm-8">
                                                    <input class="form-control" name="advance_data" id="advance_data" value="0" type="text" style="color:red;"/>
                                                </div>
                                            </div>
                    
                                            <hr/>
                                            <div class="form-group">
                                                <label class="col-sm-4 control-label" style="color:blue;"><?php echo $this->lang->line('gross_salary'); ?></label>
                                                <div class="col-sm-8">
                                                    <input class="form-control" name="gross_salary" id="gross_salary" value="0" type="text" style="color: blue;"/>
                                                </div>
                                            </div>
                                           
                                            <hr/>
                                            <div class="form-group">
                                                <label class="col-sm-4 control-label" style="color:blue;"><?php echo $this->lang->line('net_salary'); ?></label>
                                                <div class="col-sm-8" style="color: blue;">
                                                    <input class="form-control greentest"  name="net_salary" id="net_salary"  type="text" style="color: blue;" />
                                                    <span class="text-danger" id="err"><?php echo form_error('net_salary'); ?></span>

                                                    <input class="form-control" name="staff_id" value="<?php echo $result["id"]; ?>"  type="hidden" />

                                                    <input class="form-control" name="month" value="<?php echo $month; ?>"  type="hidden" />
                                                    <input class="form-control" name="year" value="<?php echo $year; ?>"  type="hidden" />

                                                    <input class="form-control" name="status" value="generated"  type="hidden" />

                                                </div>
                                            </div><!--./form-group-->
                                        </div>
                                    </div> 
                                </div>
                                <div class="col-md-4 col-sm-4">

                                    <h3 class="box-title"><?php // echo $this->lang->line('deduction'); ?>Other Entry</h3>
                                    <!--<button type="button" onclick="add_more_deduction()" class="plusign"><i class="fa fa-plus"></i></button>-->
                                    <div class="sameheight" style="height: 30%;padding: 5px;">
                                        <div class="feebox">
                                            <table class="table3" id="tableID2">
                                                <tr id="deduction_row0">
                                                    <td style="width:40%;">
                                                        <!--<input type="text" class="form-control" value="Late Time">-->
                                                        <p>Late Time</p>
                                                    </td>
                                                    <td style="width:60%;">
                                                        <input type="text" id="late_time" name="late_time" class="form-control" style="width: 100%;" placeholder="Enter Late Time">
                                                    </td>

                                                </tr>
                                                
                                                
                                                <tr id="deduction_row0">
                                                    <td style="width:40%;">
                                                        <!--<input type="text" class="form-control" value="Over Time">-->
                                                        <p>Over Time</p>
                                                    </td>
                                                    <td style="width:60%;">
                                                        <input type="text" id="over_time" name="over_time" class="form-control" style="width: 100%;" placeholder="Enter Over time">
                                                    </td>
                                                </tr>
                                                
                                                <tr id="deduction_row0">
                                                    <td style="width:40%;">
                                                        <p>Absent Day</p>
                                                        <!--<input type="text" class="form-control" value="Over Time">-->
                                                    </td>
                                                    <td style="width:60%;">
                                                        <input type="text" id="absent_day" name="absent_day" class="form-control" style="width: 100%;" placeholder="Enter Absent Day">
                                                    </td>
                                                </tr>
                                                
                                                <tr id="deduction_row0">
                                                    <td style="width:40%;">
                                                        <p>Advance</p>
                                                        <!--<input type="text" class="form-control" value="Over Time">-->
                                                    </td>
                                                    <td style="width:60%;">
                                                        <input type="text" id="advance" name="advance" class="form-control" style="width: 100%;" placeholder="Enter Advance">
                                                    </td>
                                                </tr>
                                                
                                                <tr id="deduction_row0">
                                                    <td style="width:40%;">
                                                    <p>CL</p>
                                                    </td>
                                                    <td style="width:60%;">
                                                        <input type="text" id="cl" name="cl" class="form-control" style="width: 100%;" placeholder="Enter CL">
                                                    </td>
                                                </tr>
                                                
                                        

                                            </table>
                                        </div>
                                         <button type="submit" id="contact_submit" class="btn btn-info pull-right"><?php echo $this->lang->line('save'); ?></button>
                                    </div> 
                                    
                                    <div class="sameheight" style="height: 30%;padding: 5px;">
                                        <div class="feebox">
                                            <table class="table3" id="tableID2">
                                                <tr id="deduction_row0">
                                                    <td style="width:40%;">
                                                        <p>Basic</p>
                                                    </td>
                                                    <td style="width:60%;">
                                                        <input type="text" id="salary_main" name="salary_main" class="form-control" style="width: 100%;" placeholder="Basic">
                                                    </td>

                                                </tr>
                                                
                                                
                                                <tr id="deduction_row0">
                                                    <td style="width:40%;">
                                                        <p>House Rent Allowance(HRA)</p>
                                                    </td>
                                                    <td style="width:60%;">
                                                        <input type="text" id="hra" name="hra" class="form-control" style="width: 100%;" placeholder="House Rent Allowance(HRA)">
                                                    </td>
                                                </tr>
                                                
                                                <tr id="deduction_row0">
                                                    <td style="width:40%;">
                                                        <p>City Allowance</p>
                                                        <!--<input type="text" class="form-control" value="Over Time">-->
                                                    </td>
                                                    <td style="width:60%;">
                                                        <input type="text" id="city_allowance" name="city_allowance" class="form-control" style="width: 100%;" placeholder="City Allowance">
                                                    </td>
                                                </tr>
                                                
                                                <tr id="deduction_row0">
                                                    <td style="width:40%;">
                                                        <p>Conveyance Allowance</p>
                                                    </td>
                                                    <td style="width:60%;">
                                                        <input type="text" id="conveyance_allowance" name="conveyance_allowance" class="form-control" style="width: 100%;" placeholder="Conveyance Allowance">
                                                    </td>
                                                </tr>
                                                
                                                <tr id="deduction_row0">
                                                    <td style="width:40%;">
                                                        <p>Attendance Allowance</p>
                                                    </td>
                                                    <td style="width:60%;">
                                                        <input type="text" id="attendance_allowance" name="attendance_allowance" class="form-control" style="width: 100%;" placeholder="Attendance Allowance">
                                                    </td>
                                                </tr>
                                                
                                                 <tr id="deduction_row0">
                                                     <td style="width:40%;">
                                                        <p>Gross Salary</p>
                                                    </td>
                                                    <td style="width:60%;">
                                                        <input type="text" id="gross_salary_allowance" name="gross_salary_allowance" class="form-control" style="width: 100%;" placeholder="Gross Salary">
                                                    </td>
                                                </tr>
                                                
                                        

                                            </table>
                                        </div>
                                         
                                    </div> 
                                </div>
                                <!--./col-md-4--> 
                               
                                <!--./col-md-4--> 
                                <!--<div class="col-md-12 col-sm-12">-->

                                <!--    <button type="submit" id="contact_submit" class="btn btn-info pull-right"><?php echo $this->lang->line('save'); ?></button>-->
                                <!--</div>-->
                                <!--./col-md-12--> 
                                </form>
                            </div><!--./row-->  
                        </div><!--./box-header-->  
                </div>
            </div>
            <!--/.col (left) -->
        </div>
    </section>
</div>

<script type="text/javascript">

    function round(value, decimals) {
     return Number(Math.round(value+'e'+decimals)+'e-'+decimals);
    }   
    

    function add_allowance() {
        var basic_pay = $("#basic").val();
        var esi = $("#esi").val();
		var late_time = $("#late_time").val();
		var over_time = $("#over_time").val();
		var absent_day = $("#absent_day").val();
		var total_time = $("#total_time").val();
		var perday_salary_with_one_side_pf = $("#perday_salary_with_one_side_pf").val();
		var month_salary_with_one_side_pf = $("#month_salary_with_one_side_pf").val();
	
		var absent_rupee1 = absent_day*perday_salary_with_one_side_pf;
		var absent_rupee = Math.round(absent_rupee1);
		$("#absent_rupee").val(absent_rupee);
		
        // console.log(salary_esi);
		
		var absent_in_time1 = (perday_salary_with_one_side_pf/total_time);
        var absent_in_time_rupee1 = absent_in_time1*late_time;
        
        var absent_in_time_rupee =Math.round(absent_in_time_rupee1);
        $("#absent_time_rupee").val(absent_in_time_rupee);
        
        var absent_in_time_overtime1 =absent_in_time1*over_time;
        var absent_in_time_overtime = Math.round(absent_in_time_overtime1);
        
        $("#over_time_rupee").val(absent_in_time_overtime);
      
        var gross_salary1 = month_salary_with_one_side_pf-absent_rupee-absent_in_time_rupee+absent_in_time_overtime;
      
        // var gross_salary = round(gross_salary1, 2);
        
         var gross_salary = Math.round(gross_salary1, 2);
        
        var salary_esi1 = (gross_salary*esi)/100;
      
        var salary_esi = round(salary_esi1, 2);
        
        $("#salary_esi").val(salary_esi);
        
        var month_one_pf1 = $("#month_one_pf1").val();
        var pf_one_side1 = $("#pf_one_side").val();
        var month_ab_pf = pf_one_side1*absent_day;
        var month_one_pf2 = month_one_pf1-month_ab_pf;
        $("#month_one_pf").val(month_one_pf2);
        
        
        var month_both_pf1 = $("#month_both_pf1").val();
        var pf1 = $("#pf").val();
        var month_ab_both_pf = pf1*absent_day;
        var month_both_pf2 = month_both_pf1-month_ab_both_pf;
        $("#month_both_pf").val(month_both_pf2);
        
        var month_one_pf = $("#month_one_pf").val();
        var advance = $("#advance").val();
        var sf = $("#sf").val();
        
        $("#advance_data").val(advance);
        
        var net_salary = parseInt(gross_salary) - parseInt(month_one_pf) - parseInt(salary_esi) - parseInt(advance) - parseInt(sf) ;

        $("#gross_salary").val(gross_salary);
        $("#net_salary").val(net_salary);
        
        // cal for extra
        
        var basic_main1 = month_one_pf*100/12;
        var basic_main =  Math.round(basic_main1);
        $("#salary_main").val(basic_main);
       
        
        var fif = 50/100;
        var twt = 20/100;
        var ten = 10/100;
        var hra1 = (month_salary_with_one_side_pf-basic_main)*fif-absent_rupee*fif-(absent_in_time_rupee-absent_in_time_overtime)*fif;
        var hra =   Math.round(hra1);
        $("#hra").val(hra);
        
        var city_allowance1 = (month_salary_with_one_side_pf-basic_main)*twt-absent_rupee*twt-(absent_in_time_rupee-absent_in_time_overtime)*twt;
        var city_allowance =   Math.round(city_allowance1);
        $("#city_allowance").val(city_allowance);
        
        var conveyance_allowance1 = (month_salary_with_one_side_pf-basic_main)*twt-absent_rupee*twt-(absent_in_time_rupee-absent_in_time_overtime)*twt;
        var conveyance_allowance =   Math.round(conveyance_allowance1);
        $("#conveyance_allowance").val(conveyance_allowance);
        
        var attendance_allowance1 = (month_salary_with_one_side_pf-basic_main)*ten-absent_rupee*ten-(absent_in_time_rupee-absent_in_time_overtime)*ten;
        var attendance_allowance =   Math.round(attendance_allowance1);
        $("#attendance_allowance").val(attendance_allowance);
        
        var gross_salary_allowance = basic_main+hra+city_allowance+conveyance_allowance+attendance_allowance;
        $("#gross_salary_allowance").val(gross_salary_allowance);
    }
    function add_more() {

        var table = document.getElementById("tableID");
        var table_len = (table.rows.length);
        var id = parseInt(table_len);
        var row = table.insertRow(table_len).outerHTML = "<tr id='row" + id + "'><td><input type='text' class='form-control' id='allowance_type' name='allowance_type[]' placeholder='Type'></td><td><input type='text' class='form-control' id='allowance_amount' name='allowance_amount[]'  value='0'></td><td><button type='button' onclick='delete_row(" + id + ")' class='closebtn'><i class='fa fa-remove'></i></button></td></tr>";
    }

    function delete_row(id) {
        var table = document.getElementById("tableID");
        var rowCount = table.rows.length;
        $("#row" + id).html("");
        //table.deleteRow(id);
    }


    function add_more_deduction() {

        var table = document.getElementById("tableID2");
        var table_len = (table.rows.length);
        var id = parseInt(table_len);
        var row = table.insertRow(table_len).outerHTML = "<tr id='deduction_row" + id + "'><td><input type='text' class='form-control' id='deduction_type' name='deduction_type[]' placeholder='Type'></td><td><input type='text' id='deduction_amount' name='deduction_amount[]' class='form-control' value='0'></td><td><button type='button' onclick='delete_deduction_row(" + id + ")' class='closebtn'><i class='fa fa-remove'></i></button></td></tr>";

    }

    function delete_deduction_row(id) {


        var table = document.getElementById("tableID2");
        var rowCount = table.rows.length;
        $("#deduction_row" + id).html("");
//table.deleteRow(id);
    }
  
  
  
    $("#contact_submit").click(function (event) {

        var net = $("#net_salary").val();
        if (net == "") {

            $("#err").html("<?php echo $this->lang->line('net_salary').' '.$this->lang->line('should_not_be_empty');?>");
            $("#net_salary").focus();
            return false;
            event.preventDefault();
        } else {
            $("#err").html("");
        }
    });
</script>
