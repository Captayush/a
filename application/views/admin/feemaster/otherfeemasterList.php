<style type="text/css">
    .liststyle1 {
        margin: 0;
        list-style: none;
        line-height: 28px;
    }
</style>
<?php //echo validation_errors(); exit;?>

<?php $currency_symbol = $this->customlib->getSchoolCurrencyFormat(); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

    <section class="content-header">
        <h1>
            <i class="fa fa-money"></i> <?php echo $this->lang->line('fees_collection'); ?></h1>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <?php if ($this->rbac->hasPrivilege('fees_master', 'can_add')) {
                ?>
                <div class="col-md-4">
                    <!-- Horizontal Form -->
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title"><?php echo "Add Others Fees Master" . " : " . $this->setting_model->getCurrentSessionName(); ?></h3>
                        </div><!-- /.box-header -->
                        <form id="form1" action="<?php echo base_url() ?>admin/otherfeemaster"  id="feemasterform" name="feemasterform" method="post" accept-charset="utf-8">
                            <div class="box-body">
                                <?php if ($this->session->flashdata('msg')) { ?>
                                    <?php echo $this->session->flashdata('msg') ?>
                                <?php } ?>

                                <?php echo $this->customlib->getCSRF(); ?>
                                <div class="row">
                                    <div class="col-md-12">
                                        
                                        <div class="form-group">
                                            <label for="fee_type">Fees Type</label> <small class="req">*</small>
                                            <select autofocus="" id="fee_type" name="fee_type" class="form-control" >
                                                <option value="" selected>Select Fees Type</option>
                                                <option value="1" >Caution Fees</option>
                                                <option value="2">Miscellaneous Fees</option>
                                                <option value="3">Form Fees</option>
                                            </select>
                                            <span class="text-danger"><?php echo form_error('fee_type'); ?></span>
                                        </div>

                                       
                                        <div class="form-group">
                                            <label for="exampleInputEmail1"><?php echo $this->lang->line('due_date'); ?></label>
                                            <input id="due_date" name="due_date" placeholder="" type="text" class="form-control date"  value="<?php echo set_value('due_date'); ?>" readonly="readonly"/>
                                            <span class="text-danger"><?php echo form_error('due_date'); ?></span>
                                        </div>


                                        <div class="form-group">
                                            <label for="amount"><?php echo $this->lang->line('amount'); ?></label><small class="req"> *</small>
                                            <input id="amount" name="amount" placeholder="" type="text" class="form-control"  value="<?php echo set_value('amount'); ?>" />
                                            <span class="text-danger"><?php echo form_error('amount'); ?></span>
                                        </div>
                                        
                                         <div class="form-group">
                                            <label for="note">Note</label>
                                            <textarea id="note" name="note" placeholder="" type="text" class="form-control" rows="5"></textarea>
                                            <span class="text-danger"><?php echo form_error('due_date'); ?></span>
                                        </div>
                                        
                                    </div>
                      
                                </div>

                            

                    </div><!-- /.box-body -->

                    <div class="box-footer">

                        <button type="submit" class="btn btn-info pull-right"><?php echo $this->lang->line('save'); ?></button>
                    </div>
                    </form>
                </div>

            </div><!--/.col (right) -->
            <!-- left column -->
        <?php } ?>
        <div class="col-md-<?php
        if ($this->rbac->hasPrivilege('fees_master', 'can_add')) {
            echo "8";
        } else {
            echo "12";
        }
        ?>">
            <!-- Horizontal Form -->
            <div class="box box-primary">
                <div class="box-header ptbnull">
                    <h3 class="box-title titlefix"><?php echo "Others Fees Master List" . " : " . $this->setting_model->getCurrentSessionName(); ?></h3>

                </div><!-- /.box-header -->

                <div class="box-body">
                    <div class="download_label"><?php echo $this->lang->line('fees_master_list') . " : " . $this->setting_model->getCurrentSessionName(); ?></div>
                    <div class="mailbox-messages">
                      <div class="table-responsive">  
                        <table class="table table-striped table-bordered table-hover example">
                            <thead>
                                <tr>
                                    <th>Fees Type</th>
                                    <th>Amount</th>
                                    <th>Note</th>
                                    <th class="text-right"><?php echo $this->lang->line('action'); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($feemasterList as $feegroup) {
                                    ?>
                                    <tr>
                                        <td class="mailbox-name">
                                        <a href="#" data-toggle="popover" class="detail_popover"><?php if($feegroup->f_type=='1'){ echo "Caution Fees"; }elseif($feegroup->f_type=='3'){ echo "Form Fees"; }else{ echo "Miscellaneous Fees"; } ?></a>
                                        </td>

                                        <td class="mailbox-name">
                                            <a href="#" data-toggle="popover" class="detail_popover"><?php echo $feegroup->amount; ?></a>
                                        </td>
                                        
                                        
                                         <td class="mailbox-name">
                                            <a href="#" data-toggle="popover" class="detail_popover"><?php echo $feegroup->note; ?></a>
                                        </td>

                                        <td class="mailbox-date pull-right">
                                            <?php if ($this->rbac->hasPrivilege('fees_group_assign', 'can_view')) { ?>
                                                <a data-placement="left" href="<?php echo base_url(); ?>admin/otherfeemaster/assign/<?php echo $feegroup->id ?>"
                                                   class="btn btn-default btn-xs" data-toggle="tooltip" title="<?php echo $this->lang->line('assign / view'); ?>">
                                                    <i class="fa fa-tag"></i>
                                                </a>
                                                
                                                <!--<a href="<?php echo base_url(); ?>admin/otherfeemaster/edit/<?php echo $feetype_value->id ?>" class="btn btn-default btn-xs"  data-toggle="tooltip" title="<?php echo $this->lang->line('edit'); ?>">-->
                                                <!--    <i class="fa fa-pencil"></i>-->
                                                <!--</a-->
                                                &nbsp;
                                            <?php } ?>
                                            <?php if ($this->rbac->hasPrivilege('fees_master', 'can_delete')) { ?>
                                                <a data-placement="left" href="<?php echo base_url(); ?>admin/otherfeemaster/deletegrp/<?php echo $feegroup->id ?>" class="btn btn-default btn-xs"  data-toggle="tooltip" title="<?php echo $this->lang->line('delete'); ?>" onclick="return confirm('<?php echo $this->lang->line('delete_confirm') ?>');">
                                                    <i class="fa fa-remove"></i>
                                                </a>
                                            <?php } ?>

                                        </td>
                                    </tr>
                                    <?php
                                }
                                ?>

                            </tbody>
                        </table><!-- /.table -->
                      </div>  
                    </div><!-- /.mail-box-messages -->
                </div><!-- /.box-body -->


                </form>
            </div>

        </div><!--/.col (right) -->
        <!-- left column -->


</div>

</section><!-- /.content -->
</div><!-- /.content-wrapper -->


<script type="text/javascript">
    $(document).ready(function () {
        var account_type = "<?php echo set_value('account_type', 0); ?>";
        load_disable(account_type);

        var date_format = '<?php echo $result = strtr($this->customlib->getSchoolDateFormat(), ['d' => 'dd', 'm' => 'mm', 'Y' => 'yyyy']) ?>';

        $('#date').datepicker({
            //  format: "dd-mm-yyyy",
            format: date_format,
            autoclose: true
        });

        $("#btnreset").click(function () {
            $("#form1")[0].reset();
        });

    });

    $(document).on('change', '.finetype', function () {

        calculatefine();
    });


    $(document).on('keyup', '#amount,#fine_percentage', function () {

        calculatefine();
    });


    function load_disable(account_type) {
        if (account_type === "percentage") {
            $('#fine_amount').prop('readonly', true);
            $('#fine_percentage').prop('readonly', false);
        } else if (account_type === "fix") {
            $('#fine_amount').prop('readonly', false);
            $('#fine_percentage').prop('readonly', true);
        } else {
            $('#fine_amount').prop('readonly', true);
            $('#fine_percentage').prop('readonly', true);
        }
    }



    function calculatefine() {
        var amount = $('#amount').val();
        var fine_percentage = $('#fine_percentage').val();

        var finetype = $('input[name=account_type]:checked', '#form1').val();

        if (finetype === "percentage") {
            fine_amount = ((amount * fine_percentage) / 100).toFixed(2);
            $('#fine_amount').val(fine_amount).prop('readonly', true);
            $('#fine_percentage').prop('readonly', false);
        } else if (finetype === "fix") {
            $('#fine_amount').val("").prop('readonly', false);
            $('#fine_percentage').val("").prop('readonly', true);
        } else {
            $('#fine_amount').val("");
            $('#fine_percentage').val("");
            $('#fine_amount').prop('readonly', true);
            $('#fine_percentage').prop('readonly', true);
        }

    }

    $(document).ready(function () {
        $('.detail_popover').popover({
            placement: 'right',
            trigger: 'hover',
            container: 'body',
            html: true,
            content: function () {
                return $(this).closest('td').find('.fee_detail_popover').html();
            }
        });

       
    });
</script>