<style>
  .amd z{display:none;}
  .ab z{display:none;}
#vid{display:none;}

    </style>
<?php
$tpl['option_arr_values'] = array_merge(
    ['time_format' => 'H:i', 'currency' => ''],
    is_array($tpl['option_arr_values'] ?? null) ? $tpl['option_arr_values'] : []
);
?>
<div class="GZBookingContainer">
    <div class="box box-solid box-primary">
        <div class="box-body">
            <table class="table table-bordered table-hover table-striped">
                <thead>
                    <tr>
                        <th>
                            <?php echo __('start_time'); ?>
                        </th>
                        <th>
                            <?php echo __('end_time'); ?>
                        </th>  
                         <th>
                       
                            <?php echo __('Prices'); ?>
                      </th>   
                        <th>
                            <?php echo __('optinal'); ?>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $price = 0;
                    $date = $_POST['date'] ?? '';
                    if (!empty($tpl['custom_dates'])) {
                        $start_time = explode(':', $tpl['custom_dates']['start'] ?? '00:00');
                        $end_time = explode(':', $tpl['custom_dates']['end'] ?? '00:00');

                        $launch_start_time = explode(':', $tpl['custom_dates']['lunch_start'] ?? '00:00');
                        $launch_end_time = explode(':', $tpl['custom_dates']['lunch_end'] ?? '00:00');

                        $launch_start = mktime($launch_start_time[0], $launch_start_time[1], 0, date('n', $date), date('j', $date), date('Y', $date));
                        $launch_end = mktime($launch_end_time[0], $launch_end_time[1], 0, date('n', $date), date('j', $date), date('Y', $date));

                        $slot_lenght = $tpl['custom_dates']['slot_lenght'] ?? '';
                        $price = $tpl['custom_dates']['price'] ?? '';
                        $count = $tpl['custom_dates']['count'] ?? '';
                    } else {
                        switch (date('N', $date)) {
                            case '1':
                                $start_time = explode(':', $tpl['working_time']['monday_start'] ?? '00:00');
                                $end_time = explode(':', $tpl['working_time']['monday_end'] ?? '00:00');

                                $launch_start_time = explode(':', $tpl['working_time']['monday_lunch_start'] ?? '00:00');
                                $launch_end_time = explode(':', $tpl['working_time']['monday_lunch_end'] ?? '00:00');

                                $launch_start = mktime($launch_start_time[0], $launch_start_time[1], 0, date('n', $date), date('j', $date), date('Y', $date));
                                $launch_end = mktime($launch_end_time[0], $launch_end_time[1], 0, date('n', $date), date('j', $date), date('Y', $date));
                              
                                $slot_lenght = $tpl['working_time']['monday_slot_lenght'] ?? '';
                                if (empty($_POST['location']) && ($tpl['prices']['calendars_price'] ?? 0) != 0 )
                                $price = $tpl['working_time']['monday_price'] ?? '';
                                echo '<style>#gz-abc-calendar-container-1 > div > div:nth-child(1) > div > table > thead > tr > th:nth-child(3) { display:none;}
                                #gz-abc-calendar-container-1 > div > div:nth-child(1) > div > table > tbody > tr:nth-child(2) > td:nth-child(3){ display:none;}
  #gz-abc-calendar-container-1 > div > div:nth-child(1) > div > table > tbody > tr:nth-child(3) > td:nth-child(3){ display:none;}
  #gz-abc-calendar-container-1 > div > div:nth-child(1) > div > table > tbody > tr:nth-child(4) > td:nth-child(3){ display:none;}
  #gz-abc-calendar-container-1 > div > div:nth-child(1) > div > table > tbody > tr:nth-child(5) > td:nth-child(3){ display:none;}
  #gz-abc-calendar-container-1 > div > div:nth-child(1) > div > table > tbody > tr:nth-child(6) > td:nth-child(3){
    display:none!important;
}
  #gz-abc-calendar-container-1 > div > div:nth-child(1) > div > table > tbody > tr:nth-child(7) > td:nth-child(3){
    display:none!important;
}
  #gz-abc-calendar-container-1 > div > div:nth-child(1) > div > table > tbody > tr:nth-child(8) > td:nth-child(3){
    display:none!important;
}
  #gz-abc-calendar-container-1 > div > div:nth-child(1) > div > table > tbody > tr:nth-child(9) > td:nth-child(3){
    display:none!important;
}
  #gz-abc-calendar-container-1 > div > div:nth-child(1) > div > table > tbody > tr:nth-child(10) > td:nth-child(3){
    display:none!important;
}
  #gz-abc-calendar-container-1 > div > div:nth-child(1) > div > table > tbody > tr:nth-child(11) > td:nth-child(3){
    display:none!important;
}
  #gz-abc-calendar-container-1 > div > div:nth-child(1) > div > table > tbody > tr:nth-child(12) > td:nth-child(3){
    display:none!important;
}
  #gz-abc-calendar-container-1 > div > div:nth-child(1) > div > table > tbody > tr:nth-child(13) > td:nth-child(3){
    display:none!important;
}
  #gz-abc-calendar-container-1 > div > div:nth-child(1) > div > table > tbody > tr:nth-child(14) > td:nth-child(3)
{
    display:none!important;
}</style>';
                                // echo "<style>#gz-abc-calendar-container-1 > div > div:nth-child(1) > div > table > tbody > tr:nth-child(2) > td:nth-child(3) {display:none;}
                                // #gz-abc-calendar-container-1 > div > div:nth-child(1) > div > table > tbody > tr:nth-child(2) > td:nth-child(4) >{float: right; margin-right: -29px;}</style>";
                                $count = $tpl['working_time']['monday_count'] ?? '';
                               
                                break;
                            case '2':
                                $start_time = explode(':', $tpl['working_time']['tuesday_start'] ?? '00:00');
                                $end_time = explode(':', $tpl['working_time']['tuesday_end'] ?? '00:00');

                                $launch_start_time = explode(':', $tpl['working_time']['tuesday_lunch_start'] ?? '00:00');
                                $launch_end_time = explode(':', $tpl['working_time']['tuesday_lunch_end'] ?? '00:00');

                                $launch_start = mktime($launch_start_time[0], $launch_start_time[1], 0, date('n', $date), date('j', $date), date('Y', $date));
                                $launch_end = mktime($launch_end_time[0], $launch_end_time[1], 0, date('n', $date), date('j', $date), date('Y', $date));

                                $slot_lenght = $tpl['working_time']['tuesday_slot_lenght'] ?? '';
                                if (empty($_POST['location']) && ($tpl['prices']['calendars_price'] ?? 0) != 0 )
                                $price = $tpl['working_time']['tuesday_price'] ?? '';
                                echo '<style>#gz-abc-calendar-container-1 > div > div:nth-child(1) > div > table > thead > tr > th:nth-child(3) { display:none;}
                                #gz-abc-calendar-container-1 > div > div:nth-child(1) > div > table > tbody > tr:nth-child(2) > td:nth-child(3){ display:none;}
  #gz-abc-calendar-container-1 > div > div:nth-child(1) > div > table > tbody > tr:nth-child(3) > td:nth-child(3){ display:none;}
  #gz-abc-calendar-container-1 > div > div:nth-child(1) > div > table > tbody > tr:nth-child(4) > td:nth-child(3){ display:none;}
  #gz-abc-calendar-container-1 > div > div:nth-child(1) > div > table > tbody > tr:nth-child(5) > td:nth-child(3){ display:none;}
  #gz-abc-calendar-container-1 > div > div:nth-child(1) > div > table > tbody > tr:nth-child(6) > td:nth-child(3){
    display:none!important;
}
  #gz-abc-calendar-container-1 > div > div:nth-child(1) > div > table > tbody > tr:nth-child(7) > td:nth-child(3){
    display:none!important;
}
  #gz-abc-calendar-container-1 > div > div:nth-child(1) > div > table > tbody > tr:nth-child(8) > td:nth-child(3){
    display:none!important;
}
  #gz-abc-calendar-container-1 > div > div:nth-child(1) > div > table > tbody > tr:nth-child(9) > td:nth-child(3){
    display:none!important;
}
  #gz-abc-calendar-container-1 > div > div:nth-child(1) > div > table > tbody > tr:nth-child(10) > td:nth-child(3){
    display:none!important;
}
  #gz-abc-calendar-container-1 > div > div:nth-child(1) > div > table > tbody > tr:nth-child(11) > td:nth-child(3){
    display:none!important;
}
  #gz-abc-calendar-container-1 > div > div:nth-child(1) > div > table > tbody > tr:nth-child(12) > td:nth-child(3){
    display:none!important;
}
  #gz-abc-calendar-container-1 > div > div:nth-child(1) > div > table > tbody > tr:nth-child(13) > td:nth-child(3){
    display:none!important;
}
  #gz-abc-calendar-container-1 > div > div:nth-child(1) > div > table > tbody > tr:nth-child(14) > td:nth-child(3)
{
    display:none!important;
}</style>';
                              
                                $count = $tpl['working_time']['tuesday_count'] ?? '';
                                break;
                            case '3':
                                $start_time = explode(':', $tpl['working_time']['wednesday_start'] ?? '00:00');
                                $end_time = explode(':', $tpl['working_time']['wednesday_end'] ?? '00:00');

                                $launch_start_time = explode(':', $tpl['working_time']['wednesday_lunch_start'] ?? '00:00');
                                $launch_end_time = explode(':', $tpl['working_time']['wednesday_lunch_end'] ?? '00:00');

                                $launch_start = mktime($launch_start_time[0], $launch_start_time[1], 0, date('n', $date), date('j', $date), date('Y', $date));
                                $launch_end = mktime($launch_end_time[0], $launch_end_time[1], 0, date('n', $date), date('j', $date), date('Y', $date));

                                $slot_lenght = $tpl['working_time']['wednesday_slot_lenght'] ?? '';
                                if (empty($_POST['location']) && ($tpl['prices']['calendars_price'] ?? 0) != 0 )
                                $price = $tpl['working_time']['wednesday_price'] ?? '';
                                echo '<style>#gz-abc-calendar-container-1 > div > div:nth-child(1) > div > table > thead > tr > th:nth-child(3) { display:none;}
                                #gz-abc-calendar-container-1 > div > div:nth-child(1) > div > table > tbody > tr:nth-child(2) > td:nth-child(3){ display:none;}
  #gz-abc-calendar-container-1 > div > div:nth-child(1) > div > table > tbody > tr:nth-child(3) > td:nth-child(3){ display:none;}
  #gz-abc-calendar-container-1 > div > div:nth-child(1) > div > table > tbody > tr:nth-child(4) > td:nth-child(3){ display:none;}
  #gz-abc-calendar-container-1 > div > div:nth-child(1) > div > table > tbody > tr:nth-child(5) > td:nth-child(3){ display:none;}
  #gz-abc-calendar-container-1 > div > div:nth-child(1) > div > table > tbody > tr:nth-child(6) > td:nth-child(3){
    display:none!important;
}
  #gz-abc-calendar-container-1 > div > div:nth-child(1) > div > table > tbody > tr:nth-child(7) > td:nth-child(3){
    display:none!important;
}
  #gz-abc-calendar-container-1 > div > div:nth-child(1) > div > table > tbody > tr:nth-child(8) > td:nth-child(3){
    display:none!important;
}
  #gz-abc-calendar-container-1 > div > div:nth-child(1) > div > table > tbody > tr:nth-child(9) > td:nth-child(3){
    display:none!important;
}
  #gz-abc-calendar-container-1 > div > div:nth-child(1) > div > table > tbody > tr:nth-child(10) > td:nth-child(3){
    display:none!important;
}
  #gz-abc-calendar-container-1 > div > div:nth-child(1) > div > table > tbody > tr:nth-child(11) > td:nth-child(3){
    display:none!important;
}
  #gz-abc-calendar-container-1 > div > div:nth-child(1) > div > table > tbody > tr:nth-child(12) > td:nth-child(3){
    display:none!important;
}
  #gz-abc-calendar-container-1 > div > div:nth-child(1) > div > table > tbody > tr:nth-child(13) > td:nth-child(3){
    display:none!important;
}
  #gz-abc-calendar-container-1 > div > div:nth-child(1) > div > table > tbody > tr:nth-child(14) > td:nth-child(3)
{
    display:none!important;
}</style>';
                              
                                // echo '<script language="javascript">';
                                //  echo 'alert("$price")';
                                //    echo '</script>';
                                $count = $tpl['working_time']['wednesday_count'] ?? '';
                                break;
                            case '4':
                                $start_time = explode(':', $tpl['working_time']['thursday_start'] ?? '00:00');
                                $end_time = explode(':', $tpl['working_time']['thursday_end'] ?? '00:00');

                                $launch_start_time = explode(':', $tpl['working_time']['thursday_lunch_start'] ?? '00:00');
                                $launch_end_time = explode(':', $tpl['working_time']['thursday_lunch_end'] ?? '00:00');

                                $launch_start = mktime($launch_start_time[0], $launch_start_time[1], 0, date('n', $date), date('j', $date), date('Y', $date));
                                $launch_end = mktime($launch_end_time[0], $launch_end_time[1], 0, date('n', $date), date('j', $date), date('Y', $date));

                                $slot_lenght = $tpl['working_time']['thursday_slot_lenght'] ?? '';
                                if (empty($_POST['location']) && ($tpl['prices']['calendars_price'] ?? 0) != 0 )
                                $price = $tpl['working_time']['thursday_price'] ?? '';
                                echo '<style>#gz-abc-calendar-container-1 > div > div:nth-child(1) > div > table > thead > tr > th:nth-child(3) { display:none;}
                                #gz-abc-calendar-container-1 > div > div:nth-child(1) > div > table > tbody > tr:nth-child(2) > td:nth-child(3){ display:none;}
  #gz-abc-calendar-container-1 > div > div:nth-child(1) > div > table > tbody > tr:nth-child(3) > td:nth-child(3){ display:none;}
  #gz-abc-calendar-container-1 > div > div:nth-child(1) > div > table > tbody > tr:nth-child(4) > td:nth-child(3){ display:none;}
  #gz-abc-calendar-container-1 > div > div:nth-child(1) > div > table > tbody > tr:nth-child(5) > td:nth-child(3){ display:none;}
  #gz-abc-calendar-container-1 > div > div:nth-child(1) > div > table > tbody > tr:nth-child(6) > td:nth-child(3){
    display:none!important;
}
  #gz-abc-calendar-container-1 > div > div:nth-child(1) > div > table > tbody > tr:nth-child(7) > td:nth-child(3){
    display:none!important;
}
  #gz-abc-calendar-container-1 > div > div:nth-child(1) > div > table > tbody > tr:nth-child(8) > td:nth-child(3){
    display:none!important;
}
  #gz-abc-calendar-container-1 > div > div:nth-child(1) > div > table > tbody > tr:nth-child(9) > td:nth-child(3){
    display:none!important;
}
  #gz-abc-calendar-container-1 > div > div:nth-child(1) > div > table > tbody > tr:nth-child(10) > td:nth-child(3){
    display:none!important;
}
  #gz-abc-calendar-container-1 > div > div:nth-child(1) > div > table > tbody > tr:nth-child(11) > td:nth-child(3){
    display:none!important;
}
  #gz-abc-calendar-container-1 > div > div:nth-child(1) > div > table > tbody > tr:nth-child(12) > td:nth-child(3){
    display:none!important;
}
  #gz-abc-calendar-container-1 > div > div:nth-child(1) > div > table > tbody > tr:nth-child(13) > td:nth-child(3){
    display:none!important;
}
  #gz-abc-calendar-container-1 > div > div:nth-child(1) > div > table > tbody > tr:nth-child(14) > td:nth-child(3)
{
    display:none!important;
}</style>';
                               
                                $count = $tpl['working_time']['thursday_count'] ?? '';
                                break;
                            case '5':
                                $start_time = explode(':', $tpl['working_time']['friday_start'] ?? '00:00');
                                $end_time = explode(':', $tpl['working_time']['friday_end'] ?? '00:00');

                                $launch_start_time = explode(':', $tpl['working_time']['friday_lunch_start'] ?? '00:00');
                                $launch_end_time = explode(':', $tpl['working_time']['friday_lunch_end'] ?? '00:00');

                                $launch_start = mktime($launch_start_time[0], $launch_start_time[1], 0, date('n', $date), date('j', $date), date('Y', $date));
                                $launch_end = mktime($launch_end_time[0], $launch_end_time[1], 0, date('n', $date), date('j', $date), date('Y', $date));

                                $slot_lenght = $tpl['working_time']['friday_slot_lenght'] ?? '';
                                if (empty($_POST['location']) && ($tpl['prices']['calendars_price'] ?? 0) != 0 )
                                $price = $tpl['working_time']['friday_price'] ?? '';
                                echo '<style>#gz-abc-calendar-container-1 > div > div:nth-child(1) > div > table > thead > tr > th:nth-child(3) { display:none;}
                                #gz-abc-calendar-container-1 > div > div:nth-child(1) > div > table > tbody > tr:nth-child(2) > td:nth-child(3){ display:none;}
  #gz-abc-calendar-container-1 > div > div:nth-child(1) > div > table > tbody > tr:nth-child(3) > td:nth-child(3){ display:none;}
  #gz-abc-calendar-container-1 > div > div:nth-child(1) > div > table > tbody > tr:nth-child(4) > td:nth-child(3){ display:none;}
  #gz-abc-calendar-container-1 > div > div:nth-child(1) > div > table > tbody > tr:nth-child(5) > td:nth-child(3){ display:none;}
  #gz-abc-calendar-container-1 > div > div:nth-child(1) > div > table > tbody > tr:nth-child(6) > td:nth-child(3){
    display:none!important;
}
  #gz-abc-calendar-container-1 > div > div:nth-child(1) > div > table > tbody > tr:nth-child(7) > td:nth-child(3){
    display:none!important;
}
  #gz-abc-calendar-container-1 > div > div:nth-child(1) > div > table > tbody > tr:nth-child(8) > td:nth-child(3){
    display:none!important;
}
  #gz-abc-calendar-container-1 > div > div:nth-child(1) > div > table > tbody > tr:nth-child(9) > td:nth-child(3){
    display:none!important;
}
  #gz-abc-calendar-container-1 > div > div:nth-child(1) > div > table > tbody > tr:nth-child(10) > td:nth-child(3){
    display:none!important;
}
  #gz-abc-calendar-container-1 > div > div:nth-child(1) > div > table > tbody > tr:nth-child(11) > td:nth-child(3){
    display:none!important;
}
  #gz-abc-calendar-container-1 > div > div:nth-child(1) > div > table > tbody > tr:nth-child(12) > td:nth-child(3){
    display:none!important;
}
  #gz-abc-calendar-container-1 > div > div:nth-child(1) > div > table > tbody > tr:nth-child(13) > td:nth-child(3){
    display:none!important;
}
  #gz-abc-calendar-container-1 > div > div:nth-child(1) > div > table > tbody > tr:nth-child(14) > td:nth-child(3)
{
    display:none!important;
}</style>';
                               
                                $count = $tpl['working_time']['friday_count'] ?? '';
                                break;
                            case '6':
                                $start_time = explode(':', $tpl['working_time']['saturday_start'] ?? '00:00');
                                $end_time = explode(':', $tpl['working_time']['saturday_end'] ?? '00:00');

                                $launch_start_time = explode(':', $tpl['working_time']['saturday_lunch_start'] ?? '00:00');
                                $launch_end_time = explode(':', $tpl['working_time']['saturday_lunch_end'] ?? '00:00');

                                $launch_start = mktime($launch_start_time[0], $launch_start_time[1], 0, date('n', $date), date('j', $date), date('Y', $date));
                                $launch_end = mktime($launch_end_time[0], $launch_end_time[1], 0, date('n', $date), date('j', $date), date('Y', $date));

                                $slot_lenght = $tpl['working_time']['saturday_slot_lenght'] ?? '';
                                if (empty($_POST['location']) && ($tpl['prices']['calendars_price'] ?? 0) != 0 )
                                $price = $tpl['working_time']['saturday_price'] ?? '';
                                echo '<style>#gz-abc-calendar-container-1 > div > div:nth-child(1) > div > table > thead > tr > th:nth-child(3) { display:none;}
                                #gz-abc-calendar-container-1 > div > div:nth-child(1) > div > table > tbody > tr:nth-child(2) > td:nth-child(3){ display:none;}
  #gz-abc-calendar-container-1 > div > div:nth-child(1) > div > table > tbody > tr:nth-child(3) > td:nth-child(3){ display:none;}
  #gz-abc-calendar-container-1 > div > div:nth-child(1) > div > table > tbody > tr:nth-child(4) > td:nth-child(3){ display:none;}
  #gz-abc-calendar-container-1 > div > div:nth-child(1) > div > table > tbody > tr:nth-child(5) > td:nth-child(3){ display:none;}
  #gz-abc-calendar-container-1 > div > div:nth-child(1) > div > table > tbody > tr:nth-child(6) > td:nth-child(3){
    display:none!important;
}
  #gz-abc-calendar-container-1 > div > div:nth-child(1) > div > table > tbody > tr:nth-child(7) > td:nth-child(3){
    display:none!important;
}
  #gz-abc-calendar-container-1 > div > div:nth-child(1) > div > table > tbody > tr:nth-child(8) > td:nth-child(3){
    display:none!important;
}
  #gz-abc-calendar-container-1 > div > div:nth-child(1) > div > table > tbody > tr:nth-child(9) > td:nth-child(3){
    display:none!important;
}
  #gz-abc-calendar-container-1 > div > div:nth-child(1) > div > table > tbody > tr:nth-child(10) > td:nth-child(3){
    display:none!important;
}
  #gz-abc-calendar-container-1 > div > div:nth-child(1) > div > table > tbody > tr:nth-child(11) > td:nth-child(3){
    display:none!important;
}
  #gz-abc-calendar-container-1 > div > div:nth-child(1) > div > table > tbody > tr:nth-child(12) > td:nth-child(3){
    display:none!important;
}
  #gz-abc-calendar-container-1 > div > div:nth-child(1) > div > table > tbody > tr:nth-child(13) > td:nth-child(3){
    display:none!important;
}
  #gz-abc-calendar-container-1 > div > div:nth-child(1) > div > table > tbody > tr:nth-child(14) > td:nth-child(3)
{
    display:none!important;
}</style>';
                            
                                $count = $tpl['working_time']['saturday_count'] ?? '';
                                break;
                            case '7':
                                $start_time = explode(':', $tpl['working_time']['sunday_start'] ?? '00:00');
                                $end_time = explode(':', $tpl['working_time']['sunday_end'] ?? '00:00');

                                $launch_start_time = explode(':', $tpl['working_time']['sunday_lunch_start'] ?? '00:00');
                                $launch_end_time = explode(':', $tpl['working_time']['sunday_lunch_end'] ?? '00:00');

                                $launch_start = mktime($launch_start_time[0], $launch_start_time[1], 0, date('n', $date), date('j', $date), date('Y', $date));
                                $launch_end = mktime($launch_end_time[0], $launch_end_time[1], 0, date('n', $date), date('j', $date), date('Y', $date));

                                $slot_lenght = $tpl['working_time']['sunday_slot_lenght'] ?? '';
                                if (empty($_POST['location']) && ($tpl['prices']['calendars_price'] ?? 0) != 0 )
                                $price = $tpl['working_time']['sunday_price'] ?? '';
                                echo '<style>#gz-abc-calendar-container-1 > div > div:nth-child(1) > div > table > thead > tr > th:nth-child(3) { display:none;}
                                #gz-abc-calendar-container-1 > div > div:nth-child(1) > div > table > tbody > tr:nth-child(2) > td:nth-child(3){ display:none;}
  #gz-abc-calendar-container-1 > div > div:nth-child(1) > div > table > tbody > tr:nth-child(3) > td:nth-child(3){ display:none;}
  #gz-abc-calendar-container-1 > div > div:nth-child(1) > div > table > tbody > tr:nth-child(4) > td:nth-child(3){ display:none;}
  #gz-abc-calendar-container-1 > div > div:nth-child(1) > div > table > tbody > tr:nth-child(5) > td:nth-child(3){ display:none;}
  #gz-abc-calendar-container-1 > div > div:nth-child(1) > div > table > tbody > tr:nth-child(6) > td:nth-child(3){
    display:none!important;
}
  #gz-abc-calendar-container-1 > div > div:nth-child(1) > div > table > tbody > tr:nth-child(7) > td:nth-child(3){
    display:none!important;
}
  #gz-abc-calendar-container-1 > div > div:nth-child(1) > div > table > tbody > tr:nth-child(8) > td:nth-child(3){
    display:none!important;
}
  #gz-abc-calendar-container-1 > div > div:nth-child(1) > div > table > tbody > tr:nth-child(9) > td:nth-child(3){
    display:none!important;
}
  #gz-abc-calendar-container-1 > div > div:nth-child(1) > div > table > tbody > tr:nth-child(10) > td:nth-child(3){
    display:none!important;
}
  #gz-abc-calendar-container-1 > div > div:nth-child(1) > div > table > tbody > tr:nth-child(11) > td:nth-child(3){
    display:none!important;
}
  #gz-abc-calendar-container-1 > div > div:nth-child(1) > div > table > tbody > tr:nth-child(12) > td:nth-child(3){
    display:none!important;
}
  #gz-abc-calendar-container-1 > div > div:nth-child(1) > div > table > tbody > tr:nth-child(13) > td:nth-child(3){
    display:none!important;
}
  #gz-abc-calendar-container-1 > div > div:nth-child(1) > div > table > tbody > tr:nth-child(14) > td:nth-child(3)
{
    display:none!important;
}</style>';
                              
                                $count = $tpl['working_time']['sunday_count'] ?? '';
                                break;
                        }
                    }

                    for ($i = mktime($start_time[0], $start_time[1], 0, date('n', $date), date('j', $date), date('Y', $date)); $i < mktime($end_time[0], $end_time[1], 0, date('n', $date), date('j', $date), date('Y', $date)); $i += $slot_lenght * 60) {
                        if ($i > time()) {
                            if ($i >= $launch_start && $i <= $launch_end) {
                                $i = $launch_end;
                            }
                            $booked = 0;
                            if (!empty($tpl['custom_prices'][date('h:i', $i)])) {
                                $price = $tpl['custom_prices'][date('h:i', $i)];
                            }
                            foreach (($tpl['booked_slots'] ?? []) as $booked_timestamp => $booked_count) {
                                if ($booked_timestamp >= $i && $booked_timestamp < ($i + $slot_lenght * 60)) {
                                    $booked += $booked_count;
                                }
                            }
                            ?>
                            <tr>
                                <td>
                                    <?php echo date($tpl['option_arr_values']['time_format'], $i); ?>
                                </td>
                                <td>
                                    <?php echo date($tpl['option_arr_values']['time_format'], ($i + $slot_lenght * 60)); ?>
                                </td>
                                <td>
                                    <?php echo Util::currenctFormat($tpl['option_arr_values']['currency'], $price); ?>
                                </td>
                                <td>
                                    <?php
                                    if ($count > $booked) {
                                        if ($count > 1) {
                                            ?>
                                            <select name="count" data-date="<?php echo $date; ?>" data-start-time="<?php echo $i; ?>" class="gzTimeSlotDropDownClass">
                                                <option value=""><?php echo __('select_slot'); ?></option>
                                                <?php
                                                for ($c = 1; $c <= ($count - $booked); $c++) {
                                                    ?>
                                                    <option <?php echo (!empty($_SESSION[$this->controller->default_product]['slots'][$_REQUEST['cid']][$i]) && $_SESSION[$this->controller->default_product]['slots'][$_REQUEST['cid']][$i] == $c) ? "selected='selected'" : ""; ?> value="<?php echo $c; ?>"><?php echo $c; ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                            <?php
                                        } else {
                                            if (empty($_SESSION[$this->controller->default_product]['slots'][$_REQUEST['cid']][$i])) {
                                                ?>
                                                <a href="javascript:" data-date="<?php echo $date; ?>" data-start-time="<?php echo $i; ?>" class="gzTimeSlotButtonPlusClass fa fa-fw fa-plus-square"></a>
                                                <?php
                                            } else {
                                                ?>
                                                <div>
                                                    <a href="javascript:" data-date="<?php echo $date; ?>" data-start-time="<?php echo $i; ?>" class="gzTimeSlotButtonMinusClass fa fa-fw fa-minus-square"></a>
                                                </div>
                                                <?php
                                            }
                                        }
                                    } else {
                                        ?>
                                        <strong>
                                            <?php echo __('full_booked'); ?>
                                        </strong>
                                        <?php
                                    }
                                    ?>
                                </td>
                            </tr>
                            <?php
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="box box-solid box-primary">
        <div class="box-body">
            <a data-style="expand-left" href="javascript:" class="btn btn-default btn btn-danger ladda-button" id="back_to_calendar_id" autocomplete="off" value="<?php echo __('back'); ?>" name="back" tabindex="9" type="submit">
                <span class="ladda-label"><?php echo __('back'); ?></span>
                <span class="ladda-spinner"></span>
            </a>
            <a data-style="expand-left" href="javascript:" class="btn btn-warning ladda-button <?php echo (!(count($_SESSION[$this->controller->default_product]['slots'][$_REQUEST['cid']] ?? []) > 0)) ? "disabled" : ""; ?>" id="booking_frm_btn_id" autocomplete="off" value="<?php echo __('booking'); ?>" name="submit" tabindex="9" type="submit">
                <span class="ladda-label"><i class="fa fa-gavel"></i>&nbsp;&nbsp;&nbsp;<?php echo __('booking'); ?></span>
                <span class="ladda-spinner"></span>
            </a>
        </div>
    </div>
</div>
 
