<style>
   .event-color {
    background-color: #f56954 !important;
}
.ticket-color {
    background-color: #54f5da !important;
}
.rental-color {
    background-color: #54f57c !important;
}
.newmember-color {
    background-color: #f58a54 !important;
}
.main-color {
    background-color: #92beaa !important;
}
    </style>
<section class="content-header">
    <h1>
        <?php echo __('dashboard'); ?>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo INSTALL_URL; ?>"><i class="fa fa-dashboard"></i><?php echo __('home'); ?></a></li>
    </ol>
</section>
<!-- Main content -->
<section class="content">
    <?php
    require_once VIEWS_PATH . 'Layouts/admin/error_notice.php';
    ?>
    <div class="small-box bg-green">
                <div class="inner">
                    <h3>
                        <?php echo date("Y") .'  YTD Revenue'; ?>
                    </h3>
                    
                </div>
                
            </div>
    <div class="row">
         <?php if ($this->controller->isAdmin() || $this->controller->isEditor()) { ?>
        <div class="<?php echo ($this->controller->isAdmin()) ? "col-lg-3" : "col-lg-4"; ?> col-xs-6">
            <!-- small box -->
            <div class="small-box bg-green">
                <div class="inner">
                    <h3>
                        <?php echo $tpl['today_reservation']['today_reservation'] ?? 0; ?>
                    </h3>
                    <p>
                        <?php echo ($this->controller->isMember()) ? 'My booking' : __('today_resrvations'); ?>
                    </p>
                </div>
                <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                </div>
                <a href="<?php echo INSTALL_URL; ?>?controller=Booking&action=index&today=1" class="small-box-footer">
                    <?php echo __('more_info'); ?> <i class="fa fa-arrow-circle-right"></i>
                </a>
            </div>
        </div><!-- ./col -->
        <?php } ?>
        <?php if ($this->controller->isAdmin() || $this->controller->isEditor()) { ?>
        <div class="<?php echo ($this->controller->isAdmin()) ? "col-lg-3" : "col-lg-4"; ?> col-xs-6">
            <!-- small box -->
            <div class="small-box bg-aqua">
                <div class="inner">
                    <h3>
                        <?php echo $tpl['bookings_this_week']['bookings_this_week'] ?? 0; ?>
                    </h3>
                    <p>
                        <?php echo ($this->controller->isMember()) ? 'My weekly booking' : __('bookings_this_week'); ?>
                    </p>
                </div>
                <div class="icon">
                    <i class="ion ion-bag"></i>
                </div>
                <a href="<?php echo INSTALL_URL; ?>?controller=Booking&action=index&week=1" class="small-box-footer">
                    <?php echo __('more_info'); ?> <i class="fa fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
         <?php } ?>
        <?php if (!$this->controller->isMember()) { ?>
            <div class="<?php echo ($this->controller->isAdmin()) ? "col-lg-3" : "col-lg-4"; ?> col-xs-6" style="display:none;">
                <!-- small box -->
                <div class="small-box bg-red">
                    <div class="inner">
                        <h3>
                            <?php echo count($tpl['calendars'] ?? []) ?>
                        </h3>
                        <p>
                            <?php echo __('calendars'); ?>
                        </p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-android-calendar"></i>
                    </div>
                    <a href="<?php echo INSTALL_URL; ?>Calendar/index" class="small-box-footer">
                        <?php echo __('more_info'); ?> <i class="fa fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div><!-- ./col -->
        <?php } ?>
        <!-- new tile start -->
        <?php if ($this->controller->isAdmin() || $this->controller->isEditor()) { ?>
        <div class="<?php echo ($this->controller->isAdmin()) ? "col-lg-3" : "col-lg-4"; ?> col-xs-6">
            <!-- small box -->
           <div class="small-box bg-yellow">
                <div class="inner">
                    <h3>
                        <?php echo Util::currenctFormat($tpl['option_arr_values']['currency'], $tpl['revenue']) ?>
                    </h3>
                    <p>
                        <?php echo ($this->controller->isMember()) ? 'My total booking' : __('Priest'); ?>
                    </p>
                </div>
                <div class="icon">
                   <i class="fa fa-dollar"></i>
                </div>
                <a href="<?php echo INSTALL_URL; ?>?controller=Booking&action=index" class="small-box-footer">
                    <?php echo __('more_info'); ?> <i class="fa fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
        <?php } ?>
        <!-- new  tile end -->
        <?php if ($this->controller->isAdmin()) { ?>
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-teal">
                    <div class="inner">
                        <h3>
                            <?php echo Util::currenctFormat($tpl['option_arr_values']['currency'], $tpl['misc']) ?>
                           <!--  <?php echo count($tpl['users'] ?? []); ?>-->
                           <!--  <?php echo $tpl['misc']; ?> -->
                        </h3>
                        <p>
                             <!--<?php echo __('users'); ?>-->
                              <?php echo __('Other Payment(GiftShop/Misc)'); ?>
                        </p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-dollar"></i>
                    </div>
                    <a href="<?php echo INSTALL_URL; ?>GiftShop/index" class="small-box-footer">
                        <?php echo __('more_info'); ?> <i class="fa fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div><!-- ./col -->
        <?php } ?>
    </div>
    
<!-- New tiles student member donation start  -->

    <div class="row">
         <!-- new tile start -->
          <?php if ($this->controller->isAdmin()) { ?>
         <div class="<?php echo ($this->controller->isAdmin()) ? "col-lg-3" : "col-lg-4"; ?> col-xs-6">
            <!-- small box -->
           <div class="small-box bg-red">
                <div class="inner">
                    <h3>
                        <?php echo Util::currenctFormat($tpl['option_arr_values']['currency'], $tpl['donation']) ?>
                    </h3>
                    <p>
                        <?php echo ($this->controller->isMember()) ? 'My total booking' : __('Donations'); ?>
                    </p>
                </div>
                <div class="icon">
                   <i class="fa fa-dollar"></i>
                </div>
                <a href="<?php echo INSTALL_URL; ?>?controller=donationdata&action=index" class="small-box-footer">
                    <?php echo __('more_info'); ?> <i class="fa fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
         <?php } ?>
        <!-- new  tile end -->
         <?php if ($this->controller->isAdmin()) { ?>
         <div class="<?php echo ($this->controller->isAdmin()) ? "col-lg-3" : "col-lg-4"; ?> col-xs-6">
            <!-- small box -->
           <div class="small-box bg-blue">
                <div class="inner">
                    <h3>
                        <?php echo Util::currenctFormat($tpl['option_arr_values']['currency'], $tpl['renew']) ?>
                    </h3>
                    <p>
                        <?php echo ($this->controller->isMember()) ? 'My total booking' : __('Member Renewal'); ?>
                    </p>
                </div>
                <div class="icon">
                   <i class="fa fa-dollar"></i>
                </div>
                <a href="<?php echo INSTALL_URL; ?>?controller=Member&action=index" class="small-box-footer">
                    <?php echo __('more_info'); ?> <i class="fa fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
         <?php } ?>
        <!-- new  tile end -->
        <!-- new tile start -->
         <?php if ($this->controller->isAdmin()) { ?>
        <div class="<?php echo ($this->controller->isAdmin()) ? "col-lg-3" : "col-lg-4"; ?> col-xs-6">
            <!-- small box -->
           <div class="small-box main-color">
                <div class="inner">
                    <h3>
                        <?php echo Util::currenctFormat($tpl['option_arr_values']['currency'], $tpl['maintenence']) ?>
                    </h3>
                    <p>
                        <?php echo ($this->controller->isMember()) ? 'My total booking' : __('Member Maintenance'); ?>
                    </p>
                </div>
                <div class="icon">
                   <i class="fa fa-dollar"></i>
                </div>
                <a href="<?php echo INSTALL_URL; ?>?controller=Member&action=index" class="small-box-footer">
                    <?php echo __('more_info'); ?> <i class="fa fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
        <?php } ?>
        <!-- new  tile end -->
        <!-- new tile start -->
         <?php if ($this->controller->isAdmin()) { ?>
        <div class="<?php echo ($this->controller->isAdmin()) ? "col-lg-3" : "col-lg-4"; ?> col-xs-6">
            <!-- small box -->
           <div class="small-box bg-red">
                <div class="inner">
                    <h3>
                        <?php echo Util::currenctFormat($tpl['option_arr_values']['currency'], $tpl['student']) ?>
                    </h3>
                    <p>
                        <?php echo ($this->controller->isMember()) ? 'My total booking' : __('Education'); ?>
                    </p>
                </div>
                <div class="icon">
                   <i class="fa fa-dollar"></i>
                </div>
                <a href="<?php echo INSTALL_URL; ?>?controller=Student&action=index" class="small-box-footer">
                    <?php echo __('more_info'); ?> <i class="fa fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
        <?php } ?>
        <!-- new  tile end -->
    </div>
    <!-- end -->
       <!-- new  rental to event -->
    <div class="row">
         <!-- new tile start -->
         <?php if ($this->controller->isAdmin()) { ?>
         <div class="<?php echo ($this->controller->isAdmin()) ? "col-lg-3" : "col-lg-4"; ?> col-xs-6">
            <!-- small box -->
           <div class="small-box newmember-color">
                <div class="inner">
                    <h3>
                        <?php echo Util::currenctFormat($tpl['option_arr_values']['currency'], $tpl['newMemberCount']) ?>
                    </h3>
                    <p>
                        <?php echo ($this->controller->isMember()) ? 'My total booking' : __('New Member'); ?>
                    </p>
                </div>
                <div class="icon">
                   <i class="fa fa-dollar"></i>
                </div>
                <a href="<?php echo INSTALL_URL; ?>?controller=Member&action=index" class="small-box-footer">
                    <?php echo __('more_info'); ?> <i class="fa fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
        <?php } ?>
        <!-- new  tile end -->
        <?php if ($this->controller->isAdmin()) { ?>
         <div class="<?php echo ($this->controller->isAdmin()) ? "col-lg-3" : "col-lg-4"; ?> col-xs-6">
            <!-- small box -->
           <div onmouseover="otherIN(this)" class="small-box rental-color">
                <div class="inner">
                    <h3>
                        <?php echo Util::currenctFormat($tpl['option_arr_values']['currency'], $tpl['rental']) ?>
                    </h3>
                    <p>
                        <?php echo ($this->controller->isMember()) ? 'My total booking' : __('Rental'); ?>
                    </p>
                </div>
                <div class="icon">
                   <i class="fa fa-dollar"></i>
                </div>
                <a href="<?php echo INSTALL_URL; ?>?controller=RentalBooking&action=index" class="small-box-footer">
                    <?php echo __('more_info'); ?> <i class="fa fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
         <?php } ?>
        <!-- new  tile end -->
        <!-- new tile start -->
        <?php if ($this->controller->isAdmin()) { ?>
        <div class="<?php echo ($this->controller->isAdmin()) ? "col-lg-3" : "col-lg-4"; ?> col-xs-6">
            <!-- small box -->
           <div class="small-box event-color">
                <div class="inner">
                    <h3>
                        <?php echo Util::currenctFormat($tpl['option_arr_values']['currency'], $tpl['event']) ?>
                    </h3>
                    <p>
                        <?php echo ($this->controller->isMember()) ? 'My total booking' : __('Events'); ?>
                    </p>
                </div>
                <div class="icon">
                   <i class="fa fa-dollar"></i>
                </div>
                <a href="<?php echo INSTALL_URL; ?>?controller=Eventadmin&action=index" class="small-box-footer">
                    <?php echo __('more_info'); ?> <i class="fa fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
        <?php } ?>
        <!-- new  tile end -->
        <!-- new tile start -->
        <?php if ($this->controller->isAdmin()) { ?>
        <div class="<?php echo ($this->controller->isAdmin()) ? "col-lg-3" : "col-lg-4"; ?> col-xs-6">
            <!-- small box -->
           <div class="small-box ticket-color">
                <div class="inner">
                    <h3>
                        <?php echo Util::currenctFormat($tpl['option_arr_values']['currency'], $tpl['ticket']) ?>
                    </h3>
                    <p>
                        <?php echo ($this->controller->isMember()) ? 'My total booking' : __('Tickets'); ?>
                    </p>
                </div>
                <div class="icon">
                   <i class="fa fa-dollar"></i>
                </div>
                <a href="<?php echo INSTALL_URL; ?>?controller=Eventadmin&action=index" class="small-box-footer">
                    <?php echo __('more_info'); ?> <i class="fa fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
         <?php } ?>
        <!-- new  tile end -->
     <!-- end  rental to event -->
      </div>
    <?php if (!$this->controller->isMember()) { ?>
        <div class="row">
            <section class="col-lg-6 connectedSortable">   
                <!-- Custom tabs (Charts with tabs)-->
                <div class="box box-info">
                    <div class="box-header">
                        <h3 class="box-title"><?php echo __('reservatio_numbers'); ?></h3>
                    </div>
                    <div class="box-body chart-responsive">
                        <div class="chart" id="bar-chart" style="height: 300px;"></div>
                    </div><!-- /.box-body -->
                </div>
            </section>
            <section class="col-lg-6 connectedSortable">   
                <!-- Custom tabs (Charts with tabs)-->
                <div class="box box-info">
                    <div class="box-header">
                        <h3 class="box-title"><?php echo __('reservatio_revenu'); ?></h3>
                    </div>
                    <div class="box-body chart-responsive">
                        <div class="chart" id="bar-chart1" style="height: 300px;"></div>
                    </div><!-- /.box-body -->
                </div>
            </section>

            <section class="col-lg-6 connectedSortable ui-sortable">
                <div class="box box-info">
                    <div class="box-header">
                        <h3 class="box-title"><?php echo __('last_reservations'); ?></h3>
                    </div>
                    <div class="box-body">
                        <table id="<?php echo (count($tpl['arr'])) ? "gzhotel-booking-booking-id" : ""; ?>" class="gzblog-table" cellpadding="0" cellspacing="0" >
                            <thead>
                                <tr>
                                    <th class="date-th"><?php echo __('date'); ?></th>
                                    <th class="title-th"><?php echo __('client_name'); ?></th>
                                    <th><?php echo __('Puja Type'); ?></th>
                                    <th><?php echo __('amount'); ?>($)</th>
                                    <th><?php echo __('label_status'); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $status_arr = __('status_arr');
                                $count = count($tpl['arr']);
                                if ($count > 0) {
                                    for ($i = 0; $i < $count; $i++) {
                                        ?>
                                        <tr  class="<?php echo $i % 2 === 0 ? 'odd' : 'even'; ?>">
                                            <td><?php echo date($tpl['option_arr_values']['date_format'], $tpl['arr'][$i]['date']); ?></td>
                                            <td><a href="<?php echo INSTALL_URL . 'Booking/edit/' . $tpl['arr'][$i]['id']; ?>"><?php echo $tpl['arr'][$i]['first_name'] . ' ' . $tpl['arr'][$i]['second_name']; ?></a></td>
                                             <td><?php echo $tpl['arr'][$i]['promo_code']; ?></td>
                                            <td><?php echo $tpl['arr'][$i]['total']; ?></td>
                                            <td><?php echo $status_arr[$tpl['arr'][$i]['status'] ?? ''] ?? ''; ?></td>
                                        </tr>
                                        <?php
                                    }
                                } else {
                                    ?>
                                    <tr>
                                        <td colspan="7">
                                            <?php
                                            echo __('no_booking');
                                            ?>
                                        </td>
                                    </tr>
                                    <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                   <div class="box-footer" style ="text-align:center; color:rgba(0, 0, 0, 0.1);" >
                    <a href="<?php echo INSTALL_URL; ?>?controller=Booking&action=index" class="small-box-footer">
                    <?php echo __('more_info'); ?> <i class="fa fa-arrow-circle-right"></i>
                </a>
                    </div>
                </div>
            </section>
           <?php if (!$this->controller->isEditor()) { ?>
            <section class="col-lg-6 connectedSortable ui-sortable" style ="display:none;">
                <div class="box box-info">
                    <div class="box-header">
                        <h3 class="box-title"><?php echo __('updated_membership'); ?></h3>
                    </div>
                    <div class="box-body">
                        <table id="<?php echo (count($tpl['arr'])) ? "gzhotel-booking-booking-id" : ""; ?>" class="gzblog-table" cellpadding="0" cellspacing="0" >
                            <thead>
                                <tr>
                                    <th class="date-th"><?php echo __('date'); ?></th>
                                    <th class="title-th"><?php echo __('member_name'); ?></th>
                                    <th><?php echo __('category'); ?></th>
                                    <th><?php echo __('label_status'); ?></th>
                                    <th>Member ID</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $status_arr = __('member_status_arr');
                                $count = count($tpl['log_arr']);
                                if ($count > 0) {
                                    for ($i = 0; $i < $count; $i++) {
                                        ?>
                                        <tr  class="<?php echo $i % 2 === 0 ? 'odd' : 'even'; ?>">
                                            <td>
                                                <?php echo date($tpl['option_arr_values']['date_format'], isset($tpl['arr'][$i]['date']) ? $tpl['arr'][$i]['date'] : 0); ?>
                                            </td>
                                            <td>
                                                <?php echo $tpl['log_arr'][$i]['F_Name'] . ' ' . $tpl['log_arr'][$i]['L_Name']; ?>    
                                            </td>
                                            <td>
                                                <?php echo $tpl['log_arr'][$i]['Category']; ?>    
                                            </td>
                                            <td><?php
                                            if($tpl['log_arr'][$i]['Status'] == 'P'){
                                                echo 'Payment Confirmed';
                                            }else{
                                                echo $status_arr[$tpl['log_arr'][$i]['Status']] ?? '';
                                            }
                                            ?></td>
                                            <td><?php echo $tpl['log_arr'][$i]['MemberID']; ?></td>
                                        </tr>
                                        <?php
                                    }
                                } else {
                                    ?>
                                    <tr>
                                        <td colspan="7">
                                            <?php
                                            echo __('no_booking');
                                            ?>
                                        </td>
                                    </tr>
                                    <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="box-footer">

                    </div>
                </div>
            </section>
            <section class="col-lg-6 connectedSortable ui-sortable">
                <div class="box box-info">
                    <div class="box-header">
                        <h3 class="box-title">Total Revenue(%)
</h3>
                    </div>
                    <div class="box-body">
            <div id="piechart_3dEvent" style="overflow-x: auto;scroll-behavior: smooth;width: auto!important; height: 325px;"></div>
            </div></div>
            </section>
           
            <section class="col-lg-12 connectedSortable ">
                <div class="box box-info">
                    <div class="box-header">
                        <h3 class="box-title">Monthly Revenue($)</h3>
                    </div>
                    <div class="box-body">
            <div  id="chart_div1" style="overflow-x: auto;scroll-behavior: smooth; width: auto!important; height: 550px;margin-top: 20px;"></div>
            </div>
            </div>
            </section>
             <section class="col-xs-12 col-lg-6 connectedSortable"> 
            
            <div id="chart_div" style="width: auto!important; height: 500px;margin-top: 20px;display:none"></div>
            </section>
            <?php } ?>
        </div>
    <?php } ?>
</section><!-- /.content -->

            
<?php if (!$this->controller->isMember()) { ?>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<script type="text/javascript">
//google.charts.load('current', {packages: ['corechart', 'bar']});
//google.charts.setOnLoadCallback(drawChart);
google.load("visualization", "1", {packages: ["corechart"]});
google.setOnLoadCallback(drawChart);
function drawChart() {

var array = [
    ['Module', 'Donation', 'Renew', 'Maintenance', 'Other Payment','Education', 'Events','Tickets', 'Rental'],
    <?php foreach (($tpl['chartevent'] ?? []) as $k => $v) { ?>
       
                    ['<?php echo date("F", mktime(0, 0, 0, $v['mon'], 10)); ?>', <?php echo $v['Donation']; ?>,<?php echo $v['Renew']; ?>,<?php echo $v['Maintenance']; ?>,<?php echo $v['Misc']; ?>,<?php echo $v['Education']; ?>,<?php echo $v['Event']; ?>,<?php echo $v['Ticket']; ?>,<?php echo $v['Rental']; ?>],
                    
        <?php } ?>
        ['', '','','','','','','','']
		  	];
              
			 
			var data = new google.visualization.arrayToDataTable(array);
			var formatter = new google.visualization.NumberFormat({
			//prefix: '$',
				pattern: 'short'
			  });		
			formatter.format(data, 1);
			formatter.format(data, 2);
            formatter.format(data, 3);
            formatter.format(data, 4);
            formatter.format(data, 5);
            formatter.format(data, 6);
            formatter.format(data, 7);
            formatter.format(data, 8);
			
			var view = new google.visualization.DataView(data);
			view.setColumns([0
				, 1, {  
					calc: "stringify",
					sourceColumn: 1,
					type: "string",
					role: "annotation"
				},				
				2, {
					calc: mystringy.bind(undefined, 2),
					sourceColumn: 2,
					type: "string",
					role: "annotation"
				},
                3, {
					calc: mystringy.bind(undefined, 3),
					sourceColumn: 3,
					type: "string",
					role: "annotation"
				},
                4, {
					calc: mystringy.bind(undefined, 4),
					sourceColumn: 4,
					type: "string",
					role: "annotation"
				},
                5, {
					calc: mystringy.bind(undefined, 5),
					sourceColumn: 5,
					type: "string",
					role: "annotation"
				},
                6, {
					calc: mystringy.bind(undefined, 6),
					sourceColumn: 6,
					type: "string",
					role: "annotation"
				},
				7, {
					calc: mystringy.bind(undefined, 7),
					sourceColumn: 7,
					type: "string",
					role: "annotation"
				},
                8, {
					calc: mystringy.bind(undefined, 8),
					sourceColumn: 8,
					type: "string",
					role: "annotation"
				},
				]
			);
			
			
			var options = {	
                title : '',
                chartArea:{left:5},		
				vAxis: {
						format: 'short',
						title: 'Milestone',
						//viewWindowMode:'explicit',
						//viewWindow: {
						 // max: 50,
						 // min:0
						//},
						gridlines: { count: 9 } 
					},
				chartArea: {left:5, width: "80%", height: "80%" },
				bar: { 
					groupWidth: 250  // Set the width for each bar
				},
				annotations: {  // Setting for font style format of the bar series...  
						textStyle: {
						  fontName: 'Times-Roman',
						  fontSize: 10,
						}
					},
				width:1200, 
				height:500,
				bars: 'vertical',
			  };


			var chart = new google.visualization.ColumnChart(document.getElementById('chart_div1'));			
			//chart.draw(data, options);
			chart.draw(view, options);

}

function mystringy(column, data, row) {
			return ' ' + data.getFormattedValue(row, column);
		}

          </script>

 <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawVisualization);

      function drawVisualization() {
        // Some raw data (not necessarily accurate)
        var data = google.visualization.arrayToDataTable([
            ['Module', 'Donation', 'Renew', 'Maintenance', 'Education', 'Events','Tickets', 'Rental'],
                
                <?php foreach (($tpl['chartevent'] ?? []) as $k => $v) { ?>
                    ['<?php echo date("F", mktime(0, 0, 0, $v['mon'], 10)); ?>', <?php echo $v['Donation']; ?>,<?php echo $v['Renew']; ?>,<?php echo $v['Maintenance']; ?>,<?php echo $v['Education']; ?>,<?php echo $v['Event']; ?>,<?php echo $v['Ticket']; ?>,<?php echo $v['Rental']; ?>],
                    
        <?php } ?>
        ['', '','','','','','','']
              
            ]);
        

        var options = {
          title : 'Monthly Revenue($)',
          vAxis: {title: 'Amount($)'},
          hAxis: {title: 'Month'},
          seriesType: 'bars',
            is3D: true,
          chartArea:{left:5},
          series: {5: {type: 'line'}}
        };

        var chart = new google.visualization.ComboChart(document.getElementById('chart_div'));
        chart.draw(data, options);
      }
      </script>
    <script type="text/javascript">
        
      google.charts.load("current", {packages:["corechart"]});
      google.charts.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
                 ['EventName', 'Revenu'],
                
            <?php foreach (($tpl['Eventarr'] ?? []) as $k => $v) { ?>
                ['<?php echo $v['EventName']; ?>', <?php echo $v['Revenue']; ?>],
                
    <?php } ?>
    ['', '']
          
        ]);

        var options = {
          title: '',
         width:600,
         height:400,
          pieSliceText: 'label',
          is3D: true,
         chartArea:{left:10},
         slices: {  4: {offset: 0.2},
                    12: {offset: 0.3},
                    14: {offset: 0.4},
                    15: {offset: 0.5},
          },
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart_3dEvent'));
        chart.draw(data, options);
      }
      </script>
     
    <script type="text/javascript">
      google.charts.load("current", {packages:["corechart"]});
      google.charts.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
                 ['Member Type', 'Revenue'],
                
            <?php foreach (($tpl['MemberTypearr'] ?? []) as $k => $v) { ?>
                ['<?php echo $v['MemberType']; ?>', <?php echo $v['Revenue']; ?>],
                
    <?php } ?>
    ['', '']
          
        ]);

        var options = {
          title: 'Member Revenue',
          is3D: true,
          chartArea:{left:5}
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart_3dMember'));
        chart.draw(data, options);
      }
    </script>
    <script type="text/javascript">
        (function ($) {
            $(function() {
            var bar = new Morris.Bar({
            element: 'bar-chart',
                    resize: true,
                    data: [
    <?php foreach (($tpl['chart']['booking'] ?? []) as $k => $v) { ?>
                        {y: '<?php echo $k ?>', a: <?php echo $v['count']; ?>},
    <?php } ?>
                    ],
                    barColors: ['#00a65a', '#f56954'],
                    xkey: 'y',
                    ykeys: ['a'],
                    labels: ['CPU', 'DISK'],
                    hideHover: 'auto'
            });
            });
            }
            (jQuery)
            );
            (function ($) {
                $(function () {
                    var bar = new Morris.Bar({
                    element: 'bar-chart1',
                            resize: true,
                            data: [
    <?php foreach (($tpl['chartRevenu']['booking'] ?? []) as $k => $v) { ?>
                                {y: '<?php echo $k ?>', a: <?php echo $v['count']; ?>}
                                ,
    <?php } ?>
                            ],
                    barColors: ['#00a65a', '#f56954'],
                            xkey: 'y',
                    ykeys: ['a'],
                            labels: ['CPU', 'DISK'],
                    hideHover: 'auto'
                });
            });
        }(jQuery));
    </script>
<?php } ?>