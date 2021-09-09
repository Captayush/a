<?php $currency_symbol = $this->customlib->getSchoolCurrencyFormat(); ?>
<style type="text/css">
@media print {
	.page-break	{ display: block; page-break-before: always; }
}
    @media print {
        .page-break	{ display: block; page-break-before: always; }
        .col-sm-1, .col-sm-2, .col-sm-3, .col-sm-4, .col-sm-5, .col-sm-6, .col-sm-7, .col-sm-8, .col-sm-9, .col-sm-10, .col-sm-11, .col-sm-12 {
            float: left;
        }
        .col-sm-12 {
            width: 100%;
        }
        .col-sm-11 {
            width: 91.66666667%;
        }
        .col-sm-10 {
            width: 83.33333333%;
        }
        .col-sm-9 {
            width: 75%;
        }
        .col-sm-8 {
            width: 66.66666667%;
        }
        .col-sm-7 {
            width: 58.33333333%;
        }
        .col-sm-6 {
            width: 50%;
        }
        .col-sm-5 {
            width: 41.66666667%;
        }
        .col-sm-4 {
            width: 33.33333333%;
        }
        .col-sm-3 {
            width: 25%;
        }
        .col-sm-2 {
            width: 16.66666667%;
        }
        .col-sm-1 {
            width: 8.33333333%;
        }
        .col-sm-pull-12 {
            right: 100%;
        }
        .col-sm-pull-11 {
            right: 91.66666667%;
        }
        .col-sm-pull-10 {
            right: 83.33333333%;
        }
        .col-sm-pull-9 {
            right: 75%;
        }
        .col-sm-pull-8 {
            right: 66.66666667%;
        }
        .col-sm-pull-7 {
            right: 58.33333333%;
        }
        .col-sm-pull-6 {
            right: 50%;
        }
        .col-sm-pull-5 {
            right: 41.66666667%;
        }
        .col-sm-pull-4 {
            right: 33.33333333%;
        }
        .col-sm-pull-3 {
            right: 25%;
        }
        .col-sm-pull-2 {
            right: 16.66666667%;
        }
        .col-sm-pull-1 {
            right: 8.33333333%;
        }
        .col-sm-pull-0 {
            right: auto;
        }
        .col-sm-push-12 {
            left: 100%;
        }
        .col-sm-push-11 {
            left: 91.66666667%;
        }
        .col-sm-push-10 {
            left: 83.33333333%;
        }
        .col-sm-push-9 {
            left: 75%;
        }
        .col-sm-push-8 {
            left: 66.66666667%;
        }
        .col-sm-push-7 {
            left: 58.33333333%;
        }
        .col-sm-push-6 {
            left: 50%;
        }
        .col-sm-push-5 {
            left: 41.66666667%;
        }
        .col-sm-push-4 {
            left: 33.33333333%;
        }
        .col-sm-push-3 {
            left: 25%;
        }
        .col-sm-push-2 {
            left: 16.66666667%;
        }
        .col-sm-push-1 {
            left: 8.33333333%;
        }
        .col-sm-push-0 {
            left: auto;
        }
        .col-sm-offset-12 {
            margin-left: 100%;
        }
        .col-sm-offset-11 {
            margin-left: 91.66666667%;
        }
        .col-sm-offset-10 {
            margin-left: 83.33333333%;
        }
        .col-sm-offset-9 {
            margin-left: 75%;
        }
        .col-sm-offset-8 {
            margin-left: 66.66666667%;
        }
        .col-sm-offset-7 {
            margin-left: 58.33333333%;
        }
        .col-sm-offset-6 {
            margin-left: 50%;
        }
        .col-sm-offset-5 {
            margin-left: 41.66666667%;
        }
        .col-sm-offset-4 {
            margin-left: 33.33333333%;
        }
        .col-sm-offset-3 {
            margin-left: 25%;
        }
        .col-sm-offset-2 {
            margin-left: 16.66666667%;
        }
        .col-sm-offset-1 {
            margin-left: 8.33333333%;
        }
        .col-sm-offset-0 {
            margin-left: 0%;
        }
        .visible-xs {
            display: none !important;
        }
        .hidden-xs {
            display: block !important;
        }
        table.hidden-xs {
            display: table;
        }
        tr.hidden-xs {
            display: table-row !important;
        }
        th.hidden-xs,
        td.hidden-xs {
            display: table-cell !important;
        }
        .hidden-xs.hidden-print {
            display: none !important;
        }
        .hidden-sm {
            display: none !important;
        }
        .visible-sm {
            display: block !important;
        }
        table.visible-sm {
            display: table;
        }
        tr.visible-sm {
            display: table-row !important;
        }
        th.visible-sm,
        td.visible-sm {
            display: table-cell !important;
        }
    }
</style>

<html lang="en">
    <head>
        <title><?php echo $this->lang->line('fees_receipt'); ?></title>
        <link rel="stylesheet" href="<?php echo base_url(); ?>backend/bootstrap/css/bootstrap.min.css"> 
        <link rel="stylesheet" href="<?php echo base_url(); ?>backend/dist/css/AdminLTE.min.css">
    </head>
    <body>       
        <div class="container">
            <div class="row">
                <div id="content" class="col-lg-12 col-sm-12 " style="padding: 20px;">
                    <!--<div class="invoice">-->
                        <div class="col-sm-6">
                            <div class="table-responsive">
            					<table class="table table-condensed table-bordered">
            						<thead>
                                        <tr>
                						    <td colspan="3">
                							    <h4><?php echo $settinglist[0]['name']; ?></h4>
                							    <div style="width:20%; float:left;padding:5px;">
                							         <img  src="<?php echo base_url(); ?>uploads/school_content/logo/<?php echo $settinglist[0]['image']; ?>" style="width: 100%;">
                							    </div>
                                                <div style="width:80%; float:left;padding:5px;">
                                                   
                                                   	<span style="font-size: 12px;float: left;width: 100%;font-weight: 500;">
                                        			    <?php echo $settinglist[0]['email']; ?>
                                        			</span>
                                                    <span style="font-size: 11px;float: left;width: 100%;font-weight: 400;">
                                                       <?php echo $settinglist[0]['address']; ?>
                                                    </span>
                                        			
                                        		
                                                </div>
                							</td>
                                        </tr>
                                        
                                        <tr>
                						    <td colspan="3">
                							    <div style="padding: 0px 5px 0 5px;font-size: 11px;"> Admission No. : <b><?php echo $feearray[0]->admission_no; ?></b> </div>
                							    
                							    <div style="padding: 0px 5px 0 5px;font-size: 11px;"> Name : <b><?php echo $feearray[0]->firstname . " " . $feearray[0]->lastname; ?></b></div>
                							    
                							    <div style="padding: 0px 5px 0 5px;font-size: 11px;"> Father Name : <b><?php echo $feearray[0]->father_name; ?></b></div>
                							    
                							    <div style="padding: 0px 5px 0 5px;font-size: 11px;"> Register : <b><?php echo $feearray[0]->register; ?></b></div>
                							    
                							    <div style="padding: 0px 5px 0 5px;font-size: 11px;">Payment Mode : <b>
                							     <?php
                                                $fee_deposits = json_decode(($feearray[0]->amount_detail));
                                                if (is_object($fee_deposits)) {
                                                    foreach ($fee_deposits as $fee_deposits_key => $fee_deposits_value) {
                                                ?><?php 
                                                    echo $fee_deposits_value->payment_mode; 
                                                    }
                                                }
                							    ?></b> </div>
                							    
                							    <div style="width:50%; float:left;padding:5px;font-size: 11px;">Class : <b><?php echo $feearray[0]->class; ?></b></div>
                							    
                							    <div style="width:50%; float:left;padding:5px;font-size: 11px;">Section : <b><?php echo $feearray[0]->section; ?></b> </div>
                                               
                							</td>
                                        </tr>
                                        
                                        <tr>
                						    <td colspan="3">
                							    <div style="width:50%; float:left;padding:10px;font-size: 11px;">
                							         Reciept Number : <?php echo $feearray[0]->student_reciept_no; ?>
                							    </div>
                                                <div style="width:50%; float:left;padding:10px;font-size: 11px;font-weight: 400;">
                                                    Date : <span style="font-size: 11px;font-weight: 400;"><?php $date = date('d-m-Y');
                                                                echo date($this->customlib->getSchoolDateFormat(), $this->customlib->dateyyyymmddTodateformat($date));
                                                                ?> 
                                                            </span>
                                                </div>
                							</td>
                                        </tr>
                                        
                                        <tr>
                						    <td><span style="font-size: 11px;font-weight: 400;">Reciept No</span></td>
                						    <td><span style="font-size: 11px;font-weight: 400;">Fees Group</span></td>
                						    <td><span style="font-size: 11px;font-weight: 400;">Amount</span></td>
                                        </tr>
                                        
                                       
            						</thead>
            						<tbody>
            						<?php
                                        if (!empty($feearray)) {
                                    ?>
                                    
                                    <?php
                                    $total_amount = 0;
                                    $total_deposite_amount = 0;
                                    $total_fine_amount = 0;
                                    $total_discount_amount = 0;
                                    $total_balance_amount = 0;
                                    $alot_fee_discount = 0;
                                    if (empty($feearray)) {
                                        ?>
                                        <tr>
                                            <td colspan="3" class="text-danger text-center" style="font-size: 11px;font-weight: 400;">
                                                <?php echo $this->lang->line('no_transaction_found'); ?>
                                            </td>
                                        </tr>
                                        <?php
                                    } else {



                                        foreach ($feearray as $fee_key => $feeList) {
                                            if ($feeList->is_system) {
                                                $feeList->amount = $feeList->student_fees_master_amount;
                                            }

                                            $fee_discount = 0;
                                            $fee_paid = 0;
                                            $fee_fine = 0;
                                            if (!empty($feeList->amount_detail)) {
                                                $fee_deposits = json_decode(($feeList->amount_detail));

                                                foreach ($fee_deposits as $fee_deposits_key => $fee_deposits_value) {
                                                    $fee_paid = $fee_paid + $fee_deposits_value->amount;
                                                    $fee_discount = $fee_discount + $fee_deposits_value->amount_discount;
                                                    $fee_fine = $fee_fine + $fee_deposits_value->amount_fine;
                                                    $collected_by = $fee_deposits_value->received_by;
                                                }
                                            }
                                            $feetype_balance = $feeList->amount - ($fee_paid + $fee_discount);
                                            $total_amount = $total_amount + $feeList->amount;
                                            $total_discount_amount = $total_discount_amount + $fee_discount;
                                            $total_fine_amount = $total_fine_amount + $fee_fine;
                                            $total_deposite_amount = $total_deposite_amount + $fee_paid;
                                            $total_balance_amount = $total_balance_amount + $feetype_balance;
                                           
                                            ?>
                                            
                                            <tr  class="dark-gray" style="">
                                                <td><div style="width:70%;float: left;font-size: 11px;font-weight: 400;"><?php echo $feeList->student_reciept_no; ?></td>
                                                <td>
                                                    <div style="width:70%;float: left;font-size: 11px;font-weight: 400;">
                                                    <?php 
                                                    //echo $feeList->name; 
                                                    if($feeList->fee_session_group_id=='1'){ echo "Caution Fees"; }else{ echo "Miscellaneous Fees"; }
                                                    ?> 
                                                        (<?php
                                                        if ($feetype_balance == 0) {
                                                            echo $this->lang->line('paid');
                                                        } else if (!empty($feeList->amount_detail)) {
                                                            ?><?php echo $this->lang->line('partial'); ?><?php
                                                        } else {
                                                            echo $this->lang->line('unpaid');
                                                        }
                                                        ?>)
                                                    </div>
                                                    <div style="width:30%;float: left;font-size: 11px;font-weight: 400;"><?php echo $feeList->note; ?></div>
                                                </td>
                                                <td class="text text-left" style="font-size: 11px;font-weight: 400;"><?php echo $currency_symbol . $feeList->amount; ?></td>
                                            </tr>
                                            
                                            <?php
                                        }
                                    }
                                    ?>
                                   
                                    <tr class="dark-gray" style="min-height: 100px;height: 100px;" >
                                      <td colspan="3"> </td>   
                                    </tr>
                                    
                                  
                            
                                    <?php if($fee_fine!=0){ ?>
                                            <tr class="dark-gray" >
                                                <td colspan="2" style="font-size: 11px;font-weight: 400;">Fine : </td>
                                               
                                                <td class="text text-left" style="font-size: 11px;font-weight: 400;"><?php echo ($currency_symbol . number_format($fee_fine, 2, '.', '')); ?></td> 
                                            </tr>
                                    <?php } if($fee_discount!=0){ ?>
                                             <tr class="dark-gray" >
                                                <td colspan="2" style="font-size: 11px;font-weight: 400;">Discount : </td>
                                               
                                                <td class="text text-left" style="font-size: 11px;font-weight: 400;"><?php echo ($currency_symbol . number_format($fee_discount, 2, '.', '')); ?></td> 
                                             </tr>
                                    <?php } ?>
                            
                                    <tr class="success">
                                        <td colspan="2" align="left" class="text text-left" style="font-size: 13px;font-weight: 600;" >
                                            <b>    <?php echo $this->lang->line('grand_total'); ?></b>
                                        </td>
                                        <td class="text text-left" style="font-size: 13px;font-weight: 600;">
                                            <b>    <?php
                                                echo ($currency_symbol . number_format($total_amount, 2, '.', ''));
                                                ?></b>
                                        </td>
                                    </tr>
                                    
                                    <tr class="dark-gray" >
                                        <td colspan="3" style="font-size: 11px;font-weight: 400;"><?php echo getIndianCurrency($total_amount); ?></td>
                                      
                                    </tr>
                                     
                                     <tr class="dark-gray" >
                                        <td colspan="3" style="font-size: 11px;font-weight: 400;">
                                            <div style="width:50%;float: left;"></div>
                                            <div style="width:50%;float: right;text-align: end;font-size:14px; font-wieght:600;">Recievers <br> Signature</div>
                                        </td>
                                      
                                     </tr>
                                    
                                    
                                    <?php
                                    }
                                    ?>
                                    

            						
            							
            						</tbody>
            					</table>
            				</div>
            			</div>
            			
                	     <div class="col-sm-6">
                            <div class="table-responsive">
            					<table class="table table-condensed table-bordered">
            						<thead>
                                        <tr>
                						    <td colspan="3">
                							    <h4><?php echo $settinglist[0]['name']; ?></h4>
                							    <div style="width:20%; float:left;padding:5px;">
                							         <img  src="<?php echo base_url(); ?>uploads/school_content/logo/<?php echo $settinglist[0]['image']; ?>" style="width: 100%;">
                							    </div>
                                                <div style="width:80%; float:left;padding:5px;">
                                                   
                                                   	<span style="font-size: 12px;float: left;width: 100%;font-weight: 500;">
                                        			    <?php echo $settinglist[0]['email']; ?>
                                        			</span>
                                                    <span style="font-size: 11px;float: left;width: 100%;font-weight: 400;">
                                                       <?php echo $settinglist[0]['address']; ?>
                                                    </span>
                                        			
                                        		
                                                </div>
                							</td>
                                        </tr>
                                        
                                        <tr>
                						    <td colspan="3">
                							    <div style="padding: 0px 5px 0 5px;font-size: 11px;"> Admission No. : <b><?php echo $feearray[0]->admission_no; ?></b> </div>
                							    
                							    <div style="padding: 0px 5px 0 5px;font-size: 11px;"> Name : <b><?php echo $feearray[0]->firstname . " " . $feearray[0]->lastname; ?></b></div>
                							    
                							    <div style="padding: 0px 5px 0 5px;font-size: 11px;"> Father Name : <b><?php echo $feearray[0]->father_name; ?></b></div>
                							    
                							    <div style="padding: 0px 5px 0 5px;font-size: 11px;"> Register : <b><?php echo $feearray[0]->register; ?></b></div>
                							    
                							    <div style="padding: 0px 5px 0 5px;font-size: 11px;">Payment Mode : <b>
                							     <?php
                                                $fee_deposits = json_decode(($feearray[0]->amount_detail));
                                                if (is_object($fee_deposits)) {
                                                    foreach ($fee_deposits as $fee_deposits_key => $fee_deposits_value) {
                                                ?><?php 
                                                    echo $fee_deposits_value->payment_mode; 
                                                    }
                                                }
                							    ?></b> </div>
                							    
                							    <div style="width:50%; float:left;padding:5px;font-size: 11px;">Class : <b><?php echo $feearray[0]->class; ?></b></div>
                							    
                							    <div style="width:50%; float:left;padding:5px;font-size: 11px;">Section : <b><?php echo $feearray[0]->section; ?></b> </div>
                                               
                							</td>
                                        </tr>
                                        
                                        <tr>
                						    <td colspan="3">
                							    <div style="width:50%; float:left;padding:10px;font-size: 11px;">
                							         Reciept Number : <?php echo $feearray[0]->student_reciept_no; ?>
                							    </div>
                                                <div style="width:50%; float:left;padding:10px;font-size: 11px;font-weight: 400;">
                                                    Date : <span style="font-size: 11px;font-weight: 400;"><?php $date = date('d-m-Y');
                                                                echo date($this->customlib->getSchoolDateFormat(), $this->customlib->dateyyyymmddTodateformat($date));
                                                                ?> 
                                                            </span>
                                                </div>
                							</td>
                                        </tr>
                                        
                                        <tr>
                						    <td><span style="font-size: 11px;font-weight: 400;">Reciept No</span></td>
                						    <td><span style="font-size: 11px;font-weight: 400;">Fees Group</span></td>
                						    <td><span style="font-size: 11px;font-weight: 400;">Amount</span></td>
                                        </tr>
                                        
                                       
            						</thead>
            						<tbody>
            						<?php
                                        if (!empty($feearray)) {
                                    ?>
                                    
                                    <?php
                                    $total_amount = 0;
                                    $total_deposite_amount = 0;
                                    $total_fine_amount = 0;
                                    $total_discount_amount = 0;
                                    $total_balance_amount = 0;
                                    $alot_fee_discount = 0;
                                    if (empty($feearray)) {
                                        ?>
                                        <tr>
                                            <td colspan="3" class="text-danger text-center" style="font-size: 11px;font-weight: 400;">
                                                <?php echo $this->lang->line('no_transaction_found'); ?>
                                            </td>
                                        </tr>
                                        <?php
                                    } else {



                                        foreach ($feearray as $fee_key => $feeList) {
                                            if ($feeList->is_system) {
                                                $feeList->amount = $feeList->student_fees_master_amount;
                                            }

                                            $fee_discount = 0;
                                            $fee_paid = 0;
                                            $fee_fine = 0;
                                            if (!empty($feeList->amount_detail)) {
                                                $fee_deposits = json_decode(($feeList->amount_detail));

                                                foreach ($fee_deposits as $fee_deposits_key => $fee_deposits_value) {
                                                    $fee_paid = $fee_paid + $fee_deposits_value->amount;
                                                    $fee_discount = $fee_discount + $fee_deposits_value->amount_discount;
                                                    $fee_fine = $fee_fine + $fee_deposits_value->amount_fine;
                                                    $collected_by = $fee_deposits_value->received_by;
                                                }
                                            }
                                            $feetype_balance = $feeList->amount - ($fee_paid + $fee_discount);
                                            $total_amount = $total_amount + $feeList->amount;
                                            $total_discount_amount = $total_discount_amount + $fee_discount;
                                            $total_fine_amount = $total_fine_amount + $fee_fine;
                                            $total_deposite_amount = $total_deposite_amount + $fee_paid;
                                            $total_balance_amount = $total_balance_amount + $feetype_balance;
                                           
                                            ?>
                                            
                                            <tr  class="dark-gray" style="">
                                                <td><div style="width:70%;float: left;font-size: 11px;font-weight: 400;"><?php echo $feeList->student_reciept_no; ?></td>
                                                <td>
                                                    <div style="width:70%;float: left;font-size: 11px;font-weight: 400;">
                                                    <?php 
                                                    //echo $feeList->name; 
                                                    if($feeList->fee_session_group_id=='1'){ echo "Caution Fees"; }else{ echo "Miscellaneous Fees"; }
                                                    ?> 
                                                        (<?php
                                                        if ($feetype_balance == 0) {
                                                            echo $this->lang->line('paid');
                                                        } else if (!empty($feeList->amount_detail)) {
                                                            ?><?php echo $this->lang->line('partial'); ?><?php
                                                        } else {
                                                            echo $this->lang->line('unpaid');
                                                        }
                                                        ?>)
                                                    </div>
                                                    <div style="width:30%;float: left;font-size: 11px;font-weight: 400;"><?php echo $feeList->note; ?></div>
                                                </td>
                                                <td class="text text-left" style="font-size: 11px;font-weight: 400;"><?php echo $currency_symbol . $feeList->amount; ?></td>
                                            </tr>
                                            
                                            <?php
                                        }
                                    }
                                    ?>
                                   
                                    <tr class="dark-gray" style="min-height: 100px;height: 100px;" >
                                      <td colspan="3"> </td>   
                                    </tr>
                                    
                                  
                            
                                    <?php if($fee_fine!=0){ ?>
                                            <tr class="dark-gray" >
                                                <td colspan="2" style="font-size: 11px;font-weight: 400;">Fine : </td>
                                               
                                                <td class="text text-left" style="font-size: 11px;font-weight: 400;"><?php echo ($currency_symbol . number_format($fee_fine, 2, '.', '')); ?></td> 
                                            </tr>
                                    <?php } if($fee_discount!=0){ ?>
                                             <tr class="dark-gray" >
                                                <td colspan="2" style="font-size: 11px;font-weight: 400;">Discount : </td>
                                               
                                                <td class="text text-left" style="font-size: 11px;font-weight: 400;"><?php echo ($currency_symbol . number_format($fee_discount, 2, '.', '')); ?></td> 
                                             </tr>
                                    <?php } ?>
                            
                                    <tr class="success">
                                        <td colspan="2" align="left" class="text text-left" style="font-size: 13px;font-weight: 600;" >
                                            <b>    <?php echo $this->lang->line('grand_total'); ?></b>
                                        </td>
                                        <td class="text text-left" style="font-size: 13px;font-weight: 600;">
                                            <b>    <?php
                                                echo ($currency_symbol . number_format($total_amount, 2, '.', ''));
                                                ?></b>
                                        </td>
                                    </tr>
                                    
                                    <tr class="dark-gray" >
                                        <td colspan="3" style="font-size: 11px;font-weight: 400;"><?php echo getIndianCurrency($total_amount); ?></td>
                                      
                                    </tr>
                                     
                                     <tr class="dark-gray" >
                                        <td colspan="3" style="font-size: 11px;font-weight: 400;">
                                            <div style="width:50%;float: left;"></div>
                                            <div style="width:50%;float: right;text-align: end;font-size:14px; font-wieght:600;">Recievers <br> Signature</div>
                                        </td>
                                      
                                     </tr>
                                    
                                    
                                    <?php
                                    }
                                    ?>
                                    

            						
            							
            						</tbody>
            					</table>
            				</div>
            			</div>
            		<!--</div>-->
                </div>
            </div>
        </div>
       
        <div class="clearfix"></div>

    </body>
</html>