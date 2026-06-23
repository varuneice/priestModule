<section class="content-header">
    <h1>
        <?php echo __('booking_statistic'); ?>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo INSTALL_URL; ?>"><i class="fa fa-dashboard"></i> <?php echo __('home'); ?></a></li>
        <li class="active"><?php echo __('booking_statistic'); ?></li>
    </ol>
</section>
<section class="content left width_100">
    <form id="statistic_booking_id" class="frm-class" action="<?php echo INSTALL_URL; ?>Statistic/booking" method="post" name="filter_statistic">
<input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>">
        <input type="hidden" name="controller" value="Statistic" /> 
        <input type="hidden" name="action" value="booking" /> 
        <div class="padding-19 nav-tabs-custom left width_100">
            <fieldset>
                <section class="col-lg-7 connectedSortable">
                    <div class="form-group">
                        <br />
                        <label class="control-label" for="booking_range"><?php echo __('booking_range'); ?>:</label>
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-clock-o"></i>
                            </div>
                            <input id="reservationtime" name="date_range" class="form-control pull-right" type="text" value="<?php echo (!empty($_POST['date_range'])) ? $_POST['date_range'] : ""; ?>">
                        </div>
                    </div>
                    <div class="form-group">       
                        <button id="submit" class="btn btn-primary" autocomplete="off" value="<?php echo __('search'); ?>" name="<?php echo __('search'); ?>" tabindex="9" type="submit"><i class="fa fa-fw fa-search"></i>&nbsp;&nbsp;<?php echo __('search'); ?></button>
                    </div>
                </section>
            </fieldset>
        </div>
    </form>
    <div class="box box-success left">
        <div class="box-header">
            <h3 class="box-title"><?php echo __('reservatio_numbers'); ?></h3>
        </div>
        <div class="box-body chart-responsive">
            <div class="chart" id="bar-chart" style="height: 300px;"></div>
        </div><!-- /.box-body -->
    </div><!-- /.box -->
</section>
<script type="text/javascript">
//BAR CHART

    var bar = new Morris.Bar({
        element: 'bar-chart',
        resize: true,
        data: [
<?php foreach (($tpl['month_chart'] ?? []) as $k => $v) { ?>
                {y: '<?php echo $k ?>', a: <?php echo $v['count']; ?>},
<?php } ?>
        ],
        barColors: ['#00a65a', '#f56954'],
        xkey: 'y',
        ykeys: ['a'],
        labels: ['CPU', 'DISK'],
        hideHover: 'auto'
    });
</script>