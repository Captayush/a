<style type="text/css">
    .nav-tabs-custom>.nav-tabs>li.active {
        border-top-color: #faa21c;
    }
</style>
<?php
$currency_symbol = $this->customlib->getSchoolCurrencyFormat();
?>
<div class="content-wrapper" style="min-height: 946px;">
    <section class="content-header">
        <h1><i class="fa fa-sitemap"></i> <?php echo $this->lang->line('human_resource'); ?></h1>
    </section>
    <!-- Main content -->
    <section class="content">
         <?php $this->load->view('reports/_human_resource');?>
        <div class="row">
            <div class="col-md-12">
                <div class="box removeboxmius">
                    <div class="box-header ptbnull"></div>
                      <div class="box-header with-border">
                        <h3 class="box-title"><i class="fa fa-search"></i> <?php echo $this->lang->line('select_criteria'); ?></h3>
                    </div>
                    <div class="box-body">
                       
                           
                                <form role="form" action="<?php echo site_url('admin/payroll/payrollreport') ?>" method="post" class="">
                                    <?php echo $this->customlib->getCSRF(); ?>
                                    <div class="col-sm-12">
                                     <div class="row">
                                        <div class="col-sm-4">
                                          <div class="form-group">  
                                            <label><?php echo $this->lang->line('role'); ?></label>
                                            <select name="role" class="form-control">
                                                <option value="select"><?php
                                                    echo $this->lang->line(
                                                            'select')
                                                    ?></option>
                                                <?php foreach ($role as $rolekey => $rolevalue) { ?>
                                                    <option <?php
                                                        if ($rolevalue["type"] == $role_select) {
                                                            echo "selected";
                                                        }
                                                        ?> value="<?php echo $rolevalue["type"] ?>"><?php echo $rolevalue["type"]; ?></option>
                                                <?php } ?>   
                                            </select>
                                            <span class="text-danger"><?php echo form_error('role'); ?></span>
                                           </div> 
                                        </div>
                                        <div class="col-sm-4">
                                          <div class="form-group">  
                                            <label><?php echo $this->lang->line('month'); ?></label>
                                            <select name="month" class="form-control">
                                                <option value=""><?php
                                                    echo $this->lang->line(
                                                            'select')
?></option>
                                                    <?php foreach ($monthlist as $monthkey => $monthvalue) { ?>
                                                    <option <?php
                                                    if ($month == $monthvalue) {
                                                        echo "selected";
                                                    }
                                                    ?> value="<?php echo $monthvalue ?>"><?php echo $monthvalue; ?></option>
<?php } ?>   
                                            </select>
                                            <span class="text-danger"><?php echo form_error('month'); ?></span>
                                          </div>
                                        </div>
                                        <div class="col-sm-4">
                                          <div class="form-group">   
                                            <label><?php echo $this->lang->line('year'); ?><small class="req"> *</small></label>
                                            <select name="year" class="form-control">
                                                <option value=""><?php
                                                    echo $this->lang->line(
                                                            'select')
                                                    ?></option>
<?php foreach ($yearlist as $yearkey => $yearvalue) { ?>
                                                    <option <?php
    if (($year == $yearvalue["year"]) ) {
        echo "selected";
    }
    ?> value="<?php echo $yearvalue["year"]; ?>"><?php echo $yearvalue["year"]; ?></option>
<?php } ?>   
                                            </select>
                                            <span class="text-danger"><?php echo form_error('year'); ?></span>
                                          </div>  
                                        </div>
                                    
                                   
                                        <div class="col-sm-12"> 
                                            <div class="form-group">
                                            <button type="submit" name="search" value="search_filter" class="btn btn-primary btn-sm checkbox-toggle pull-right"><i class="fa fa-search"></i> <?php echo $this->lang->line('search'); ?></button>
                                        </div>
                                    </div>
                                  </div>  
                                 </div>  
                                </form>
                           
                    </div><!--./box-body--> 
                
                    <?php if (isset($result)) {?>
                    <div class="">
                         <div class="box-header ptbnull"></div>
                        <div class="box-header with-border">
                            <h3 class="box-title"><i class="fa fa-users"></i> <?php echo $this->lang->line('payroll'); ?> <?php echo $this->lang->line('report'); ?></h3>
                        </div>      
                        <div class="box-body table-responsive">     
                            <div class="tab-content">
                                <div class="tab-pane active table-responsive" id="tab_parent">
                                    <div class="download_label"><?php echo $this->lang->line('payroll'); ?> <?php echo $this->lang->line('report_for')."<br>"; $this->customlib->get_postmessage(); ?></div>
                                    <table class="table table-striped table-bordered table-hover example table-fixed-header">
                                        <thead class="header">
                                            <tr>
                                                <th><?php echo $this->lang->line('name'); ?></th>
                                                <th><?php echo $this->lang->line('role'); ?></th>
                                                <th><?php echo $this->lang->line('designation'); ?></th>
                                                <th><?php echo $this->lang->line('month'); ?> - <?php echo $this->lang->line('year') ?></th>

                                                <th><?php echo $this->lang->line('payslip'); ?> #</th>
                                                <th class="text text-right">
                                                    <?php //echo $this->lang->line('basic_salary'); ?> Salary With PF<span><?php echo "(" . $currency_symbol . ")"; ?></span></th>
                                                <th class="text text-right"> Per Day With PF<span><?php echo "(" . $currency_symbol . ")"; ?></span></th>
                                                <th class="text text-right"> Salary Without PF<span><?php echo "(" . $currency_symbol . ")"; ?></span></th>
                                                <th class="text text-right"> Per Day Without PF<span><?php echo "(" . $currency_symbol . ")"; ?></span></th>
                                                <th class="text text-right"> Salary One Side PF<span><?php echo "(" . $currency_symbol . ")"; ?></span></th>
                                                <th class="text text-right"> Per Day One Side PF<span><?php echo "(" . $currency_symbol . ")"; ?></span></th>
                                                <th class="text text-right"> PF Per Day One Side <span><?php echo "(" . $currency_symbol . ")"; ?></span></th>
                                                <th class="text text-right"> PF Per Day Both Side <span><?php echo "(" . $currency_symbol . ")"; ?></span></th>
                                                <th class="text text-right"> Basic<span><?php echo "(" . $currency_symbol . ")"; ?></span></th>
                                                <th class="text text-right"> HRA<span><?php echo "(" . $currency_symbol . ")"; ?></span></th>
                                                <th class="text text-right"> City Allowance<span><?php echo "(" . $currency_symbol . ")"; ?></span></th>
                                                <th class="text text-right"> Conveyance Allowance<span><?php echo "(" . $currency_symbol . ")"; ?></span></th>
                                                <th class="text text-right"> Attendance Allowance<span><?php echo "(" . $currency_symbol . ")"; ?></span></th>
                                                <th class="text text-right"> Gross Salary<span><?php echo "(" . $currency_symbol . ")"; ?></span></th>
                                                <th class="text text-right"> Absent<span></span></th>
                                                <th class="text text-right"> Absent in Rupes<span><?php echo "(" . $currency_symbol . ")"; ?></span></th>
                                                <th class="text text-right"> Over Time<span></span></th>
                                                <th class="text text-right"> Late Time<span></span></th>
                                                <th class="text text-right"> Time in Rupes<span></span></th>
                                                <th class="text text-right"> PF<span></span></th>
                                                <th class="text text-right"> PF Both Side<span></span></th>
                                                <th class="text text-right"> Esi<span></span></th>
                                                <th class="text text-right"> S.F.<span></span></th>
                                                <th class="text text-right"> Advance<span></span></th>
                                                <th class="text text-right"> CL<span></span></th>
                                                <th class="text text-right"><?php echo $this->lang->line('net_salary'); ?> <span><?php echo "(" . $currency_symbol . ")"; ?></span></th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $basic = 0;
                                            $per_day_salary_with_pf = 0;
                                            $salary_without_pf=0;
                                            $per_day_salary_without_pf=0;
                                            $month_salary_with_one_side_pf=0;
                                            $perday_salary_with_one_side_pf=0;
                                            $pf_one_side=0;
                                            $pf=0;
                                            $salary_main=0;
                                            $hra=0;
                                            $city_allowance=0;
                                            $conveyance_allowance=0;
                                            $attendance_allowance=0;
                                            $gross_salary=0;
                                            $absent_day=0;
                                            $absent_rupee=0;
                                            $over_time=0;
                                            $late_time=0;
                                            $time_in_ruppe1=0;
                                            $month_one_pf=0;
                                            $month_both_pf=0;
                                            $salary_esi=0;
                                            $sf=0;
                                            $advance=0;
                                            
                                            $gross = 0;
                                            $net = 0;
                                            $earnings = 0;
                                            $deduction = 0;
                                            $tax = 0;

                                            if (empty($result)) {
                                                ?>
                                           
                                            <?php
                                        } else {
                                            $count = 1;

                                            foreach ($result as $key => $value) {
                                                $basic += $value["basic"];
                                                $per_day_salary_with_pf += $value["per_day_salary_with_pf"];
                                                $salary_without_pf += $value["salary_without_pf"];
                                                $per_day_salary_without_pf += $value["per_day_salary_without_pf"];
                                                $month_salary_with_one_side_pf += $value["month_salary_with_one_side_pf"];
                                                $perday_salary_with_one_side_pf += $value["perday_salary_with_one_side_pf"];
                                                $pf_one_side += $value["pf_one_side"];
                                                $pf += $value["pf"];
                                                $salary_main += $value["salary_main"];
                                                $hra += $value["hra"];
                                                $city_allowance += $value["city_allowance"];
                                                $conveyance_allowance += $value["conveyance_allowance"];
                                                $attendance_allowance += $value["attendance_allowance"];
                                                $gross_salary += $value["gross_salary"];
                                                $absent_day += $value["absent_day"];
                                                $absent_rupee += $value["absent_rupee"];
                                                $over_time += $value["over_time"];
                                                $late_time += $value["late_time"];
                                                $time_in_ruppe = $value['over_time_rupee']-$value['absent_time_rupee'];
                                                $time_in_ruppe1 += $time_in_ruppe;
                                                $month_one_pf += $value["month_one_pf"];
                                                $month_both_pf += $value["month_both_pf"];
                                                $salary_esi += $value["salary_esi"];
                                                $sf += $value["sf"];
                                                $advance += $value["advance"];
                                                $gross += $value["basic"] + $value["total_allowance"];
                                                $net += $value["net_salary"];
                                                $total = 0;
                                                $grd_total = 0;
                                                ?>
                                                <tr>

                                                    <td style="text-transform: capitalize;">
                                                            <span data-toggle="popover" class="detail_popover" data-original-title="" title=""><a href="#"><?php echo $value['name'] . " " . $value['surname']; ?></a></span>
                                                            <div class="fee_detail_popover" style="display: none"><?php echo $this->lang->line('staff_id'); ?><?php echo ": " . $value['employee_id']; ?></div>
                                                    </td>
                                                    
                                                    <td>
                                                            <?php echo $value['user_type']; ?>
                                                    </td>
                                                    
                                                    <td>
                                                        <span  data-original-title="" title=""><?php echo $value['designation']; ?></span>
                                                    </td>
                                                    
                                                    <td>
                                                        <?php echo $value['month'] . " - " . $value['year']; ?>
                                                    </td>
                                                    
                                                    <td>
                                                        <span data-toggle="popover" class="detail_popover" data-original-title="" title=""><a href="#"><?php echo $value['id']; ?></a></span>
                                                        <div class="fee_detail_popover" style="display: none"><?php echo $this->lang->line('mode'); ?>: <?php echo $payment_mode[$value["payment_mode"]] ?></div>
                                                    </td>
                                                    
                                                    <td class="text text-right">
                                                        <?php echo number_format($value['basic'], 2, '.', ''); ?>
                                                    </td>
                                                    
                                                    <td class="text text-right">
                                                        <?php echo number_format($value['per_day_salary_with_pf'], 2, '.', ''); ?>
                                                    </td>
                                                    
                                                    <td class="text text-right">
                                                        <?php echo number_format($value['salary_without_pf'], 2, '.', ''); ?>
                                                    </td>
                                                    
                                                    <td class="text text-right">
                                                        <?php echo number_format($value['per_day_salary_without_pf'], 2, '.', ''); ?>
                                                    </td>
                                                    
                                                    <td class="text text-right">
                                                        <?php echo number_format($value['month_salary_with_one_side_pf'], 2, '.', ''); ?>
                                                    </td>
                                                    
                                                    <td class="text text-right">
                                                        <?php echo number_format($value['perday_salary_with_one_side_pf'], 2, '.', ''); ?>
                                                    </td>
                                                    
                                                    <td class="text text-right">
                                                        <?php echo number_format($value['pf_one_side'], 2, '.', ''); ?>
                                                    </td>
                                                    
                                                    <td class="text text-right">
                                                        <?php echo number_format($value['pf'], 2, '.', ''); ?>
                                                    </td>
                                                    
                                                    <td class="text text-right">
                                                        <?php echo number_format($value['salary_main'], 2, '.', ''); ?>
                                                    </td>
                                                    
                                                    <td class="text text-right">
                                                        <?php echo number_format($value['hra'], 2, '.', ''); ?>
                                                    </td>
                                                    
                                                    <td class="text text-right">
                                                        <?php echo number_format($value['city_allowance'], 2, '.', ''); ?>
                                                    </td>
                                                    
                                                    <td class="text text-right">
                                                        <?php echo number_format($value['conveyance_allowance'], 2, '.', ''); ?>
                                                    </td>
                                                    
                                                    <td class="text text-right">
                                                        <?php echo number_format($value['attendance_allowance'], 2, '.', ''); ?>
                                                    </td>
                                                    
                                                    <td class="text text-right">
                                                        <?php echo number_format($value['gross_salary'], 2, '.', ''); ?>
                                                    </td>
                                                    
                                                    
                                                    <td class="text text-right">
                                                        <?php echo $value['absent_day']; ?>
                                                    </td>
                                                    
                                                     <td class="text text-right">
                                                        <?php echo number_format($value['absent_rupee'], 2, '.', ''); ?>
                                                    </td>
                                                    
                                                    <td class="text text-right">
                                                        <?php echo number_format($value['over_time'], 2, '.', ''); ?>
                                                    </td>
                                                    
                                                    <td class="text text-right">
                                                        <?php echo number_format($value['late_time'], 2, '.', ''); ?>
                                                    </td>
                                                    
                                                    <td class="text text-right">
                                                        <?php echo number_format($time_in_ruppe, 2, '.', ''); ?>
                                                    </td>
                                                    
                                                    <td class="text text-right">
                                                        <?php echo number_format($value['month_one_pf'], 2, '.', ''); ?>
                                                    </td>
                                                    
                                                    <td class="text text-right">
                                                        <?php echo number_format($value['month_both_pf'], 2, '.', ''); ?>
                                                    </td>
                                                    
                                                    <td class="text text-right">
                                                        <?php echo number_format($value['salary_esi'], 2, '.', ''); ?>
                                                    </td>
                                                    
                                                    <td class="text text-right">
                                                        <?php echo number_format($value['sf'], 2, '.', ''); ?>
                                                    </td>
                                                    
                                                    <td class="text text-right">
                                                        <?php echo number_format($value['advance'], 2, '.', ''); ?>
                                                    </td>
                                                    
                                                     <td class="text text-right">
                                                        <?php echo $value['cl']; ?>
                                                    </td>
                                                    
                                                    <td class="text text-right">
                                                                <?php
                                                                $t = ($value['net_salary']);
                                                                echo (number_format($t, 2, '.', ''))
                                                                ?>
                                                    </td>
                                            
                                                    
                                                </tr>
                                            <?php
                                            $count++;
                                        }
                                        ?>
                                            <tr class="box box-solid total-bg">

                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td class="text-right"><?php echo $this->lang->line('grand_total'); ?> </td>
                                                <td class="text text-right"><?php echo ('('.$currency_symbol .')'. number_format($basic, 2, '.', '')); ?></td>
                                                <td class="text text-right"><?php echo ('('.$currency_symbol .')'. number_format($per_day_salary_with_pf, 2, '.', '')); ?></td>
                                                <td class="text text-right"><?php echo ('('.$currency_symbol .')'. number_format($salary_without_pf, 2, '.', '')); ?></td>
                                                <td class="text text-right"><?php echo ('('.$currency_symbol .')'. number_format($per_day_salary_without_pf, 2, '.', '')); ?></td>
                                                <td class="text text-right"><?php echo ('('.$currency_symbol .')'. number_format($month_salary_with_one_side_pf, 2, '.', '')); ?></td>
                                                <td class="text text-right"><?php echo ('('.$currency_symbol .')'. number_format($perday_salary_with_one_side_pf, 2, '.', '')); ?></td>
                                                <td class="text text-right"><?php echo ('('.$currency_symbol .')'. number_format($pf_one_side, 2, '.', '')); ?></td>
                                                <td class="text text-right"><?php echo ('('.$currency_symbol .')'. number_format($pf, 2, '.', '')); ?></td>
                                                <td class="text text-right"><?php echo ('('.$currency_symbol .')'. number_format($salary_main, 2, '.', '')); ?></td>
                                                <td class="text text-right"><?php echo ('('.$currency_symbol .')'. number_format($hra, 2, '.', '')); ?></td>
                                                <td class="text text-right"><?php echo ('('.$currency_symbol .')'. number_format($city_allowance, 2, '.', '')); ?></td>
                                                <td class="text text-right"><?php echo ('('.$currency_symbol .')'. number_format($conveyance_allowance, 2, '.', '')); ?></td>
                                                <td class="text text-right"><?php echo ('('.$currency_symbol .')'. number_format($attendance_allowance, 2, '.', '')); ?></td>
                                                <td class="text text-right"><?php echo ('('.$currency_symbol .')'. number_format($gross_salary, 2, '.', '')); ?></td>
                                                <td class="text text-right"><?php echo ($absent_day); ?></td>
                                                <td class="text text-right"><?php echo ('('.$currency_symbol .')'. number_format($absent_rupee, 2, '.', '')); ?></td>
                                                <td class="text text-right"><?php echo ('('.$currency_symbol .')'. number_format($over_time, 2, '.', '')); ?></td>
                                                <td class="text text-right"><?php echo ('('.$currency_symbol .')'. number_format($late_time, 2, '.', '')); ?></td>
                                                <td class="text text-right"><?php echo ('('.$currency_symbol .')'. number_format($time_in_ruppe1, 2, '.', '')); ?></td>
                                                <td class="text text-right"><?php echo ('('.$currency_symbol .')'. number_format($month_one_pf, 2, '.', '')); ?></td>
                                                <td class="text text-right"><?php echo ('('.$currency_symbol .')'. number_format($month_both_pf, 2, '.', '')); ?></td>
                                                <td class="text text-right"><?php echo ('('.$currency_symbol .')'. number_format($salary_esi, 2, '.', '')); ?></td>
                                                <td class="text text-right"><?php echo ('('.$currency_symbol .')'. number_format($sf, 2, '.', '')); ?></td>
                                                <td class="text text-right"><?php echo ('('.$currency_symbol .')'. number_format($advance, 2, '.', '')); ?></td>
                                                <td class="text text-right"></td>
                                                <td class="text text-right"><?php echo ('('.$currency_symbol .')'.'&nbsp'. number_format($net, 2, '.', '')); ?></td>



                                            </tr>
                    <?php } ?>
                                        </tbody>
                                    </table>
                                </div>    


                            </div>

                        </div>
                    </div><!--./tabs--> 
                  </div><!--./box box-primary-->  
    <?php
}
?>
            </div>  
        </div>

    </section>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        var date_format = '<?php echo $result = strtr($this->customlib->getSchoolDateFormat(), ['d' => 'dd', 'm' => 'mm', 'Y' => 'yyyy',]) ?>';
        $(".date").datepicker({
            format: date_format,
            autoclose: true,
            todayHighlight: true
        });
        $('.detail_popover').popover({
            placement: 'right',
            title: '',
            trigger: 'hover',
            container: 'body',
            html: true,
            content: function () {
                return $(this).closest('td').find('.fee_detail_popover').html();
            }
        });
    });
</script>

<script type="text/javascript">
    $(document).ready(function () {
        $.extend($.fn.dataTable.defaults, {
            ordering: false,
            paging: false,
            bSort: false,
            info: false
        });
    })
    $(document).ready(function () {
        $('.table-fixed-header').fixedHeader();
    });

    (function ($) {

        $.fn.fixedHeader = function (options) {
            var config = {
                topOffset: 50

            };
            if (options) {
                $.extend(config, options);
            }

            return this.each(function () {
                var o = $(this);

                var $win = $(window);
                var $head = $('thead.header', o);
                var isFixed = 0;
                var headTop = $head.length && $head.offset().top - config.topOffset;

                function processScroll() {
                    if (!o.is(':visible')) {
                        return;
                    }
                    if ($('thead.header-copy').size()) {
                        $('thead.header-copy').width($('thead.header').width());
                    }
                    var i;
                    var scrollTop = $win.scrollTop();
                    var t = $head.length && $head.offset().top - config.topOffset;
                    if (!isFixed && headTop !== t) {
                        headTop = t;
                    }
                    if (scrollTop >= headTop && !isFixed) {
                        isFixed = 1;
                    } else if (scrollTop <= headTop && isFixed) {
                        isFixed = 0;
                    }
                    isFixed ? $('thead.header-copy', o).offset({
                        left: $head.offset().left
                    }).removeClass('hide') : $('thead.header-copy', o).addClass('hide');
                }
                $win.on('scroll', processScroll);

                // hack sad times - holdover until rewrite for 2.1
                $head.on('click', function () {
                    if (!isFixed) {
                        setTimeout(function () {
                            $win.scrollTop($win.scrollTop() - 47);
                        }, 10);
                    }
                });

                $head.clone().removeClass('header').addClass('header-copy header-fixed').appendTo(o);
                var header_width = $head.width();
                o.find('thead.header-copy').width(header_width);
                o.find('thead.header > tr:first > th').each(function (i, h) {
                    var w = $(h).width();
                    o.find('thead.header-copy> tr > th:eq(' + i + ')').width(w);
                });
                $head.css({
                    margin: '0 auto',
                    width: o.width(),
                    'background-color': config.bgColor
                });
                processScroll();
            });
        };

    })(jQuery);

</script>
