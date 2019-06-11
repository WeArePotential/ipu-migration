<?php

$node_type = ["ipu_event"];
$node_field = 'field_event_dates';
$node_field_2 = 'field_event_computed_date';

$result = db_query("SELECT nid FROM node WHERE type = :nodeType ", [':nodeType' => $node_type]); //<-- change 1

$nids = [];
$output = '';
$tally = 0;

//$output.= '$ary_end_of_mandate=array(';

foreach ($result as $obj) {
  $nids[] = $obj->nid;
  $nid = $obj->nid;

  //  print "\n\r";
  //  print "*********************************";
  //  print "\n\r";
  //  print $nid;

  $tally++;

  $node = node_load($nid);
  $output .= "\r  " . '$d8_nodes[' . $nid . ']=array(';

  $items = field_get_items('node', $node, $node_field);


  //here items are having the entity id/itemid
  #print_r($item['from']['year']);
  if (is_array($items)) {
    $output .= "\r  " . "\"" . $node_field . "\"=>array(";

    foreach ($items as $item) {

      //$output .= "\r    \"timestamp\"=>\"" . print_r($item['timestamp'], true) . "\",";
      //$output .= "\r    \"timestamp_to\"=>\"" . print_r($item['timestamp_to'], true) . "\",";

      if (!empty($item['timestamp'])) {
        $ts = $item['timestamp'];
        $output .= "\r    \"timestamp_raw\"=>\"" . $ts . "\",";
        $timestamp = strtotime($ts);
        $dt = date("Y-m-d\TH:i:s", $timestamp);
        $output .= "\r    \"timestamp\"=>\"" . $dt . "\",";
      }

      if (!empty($item['timestamp_to'])) {
        $ts = $item['timestamp_to'];
        $output .= "\r    \"timestamp_to_raw\"=>\"" . $ts . "\",";

        if (substr($ts, -6) == '246060') {
          $ts = (substr($ts, 0, strlen($ts) - 6)) . '010101';
        }
        if (substr($ts, 6, 2) == '32') {
          $ts = substr($ts, 0, 6) . '02' . substr($ts, 8);
        }
        $output .= "\r    \"ts\"=>\"" . $ts . "\",";
        $timestamp_to = strtotime($ts);
        $dt = date("Y-m-d\TH:i:s", $timestamp_to);
        $output .= "\r    \"timestamp_to\"=>\"" . $dt . "\",";
      }

      $granularity = 'year';
      if (!empty($item['from']['year'])) {
        $output .= "\r    \"year\"=>\"" . $item['from']['year'] . "\",";
      }
      if (!empty($item['from']['month'])) {
        $granularity = 'month';
        $output .= "\r    \"month\"=>\"" . $item['from']['month'] . "\",";
      }
      if (!empty($item['from']['day'])) {
        $granularity = 'day';
        $output .= "\r    \"day\"=>\"" . $item['from']['day'] . "\",";
      }

      if (!empty($item['to']['year'])) {
        $output .= "\r    \"year_to\"=>\"" . $item['to']['year'] . "\",";
      }
      if (!empty($item['to']['month'])) {
        $output .= "\r    \"month_to\"=>\"" . $item['to']['month'] . "\",";
      }
      if (!empty($item['to']['day'])) {
        $output .= "\r    \"day_to\"=>\"" . $item['to']['day'] . "\",";
      }

      $output .= "\r    \"granularity\"=>\"" . $granularity . "\",";
      $output .= "\r       ),";
    }

    $items = field_get_items('node', $node, $node_field_2);

    if (is_array($items)) {

      $output .= "\r  " . "\"" . $node_field_2 . "\"=>array(";
      foreach ($items as $item) {

        if (!empty($item)) {

          //$timestamp = print_r($item,true);
          //$dt = date("Y-m-d\TH:i:s", $timestamp);
          $output .= "\r    \"value\"=>\"" . $item['value'] . "\",";
          $output .= "\r    \"value2\"=>\"" . $item['value2'] . "\",";
          $output .= "\r    \"timezone\"=>\"" . $item['timezone'] . "\",";
          $output .= "\r    \"timezone_db\"=>\"" . $item['timezone_db'] . "\",";
        }
        $output .= "\r       ),";
      }
    }
  }
  $output .= "\r       );"; // End of node
}

//$output.= "\r );";
debug($output);

//print "IDs: " . implode("\n\r", $nids);
print "\r\r";
print $tally . ' NODES OF TYPE: ' . strtoupper(implode(',', $node_type));

/*
Array
(
    [timestamp] => 20201002010101
    [txt_short] =>
    [txt_long] =>
    [data] => Array
        (
            [check_approximate] => 0
            [year_estimate] =>
            [year_estimate_from_used] => 0
            [year_estimate_to_used] => 0
            [month_estimate] =>
            [month_estimate_from_used] => 0
            [month_estimate_to_used] => 0
            [day_estimate] =>
            [day_estimate_from_used] => 0
            [day_estimate_to_used] => 0
            [hour_estimate] =>
            [hour_estimate_from_used] => 0
            [hour_estimate_to_used] => 0
            [minute_estimate] =>
            [minute_estimate_from_used] => 0
            [minute_estimate_to_used] => 0
            [second_estimate] =>
            [second_estimate_from_used] => 0
            [second_estimate_to_used] => 0
        )

    [from] => Array
        (
            [year] => 2020
            [year_estimate] =>
            [year_estimate_label] =>
            [year_estimate_value] =>
            [month] => 10
            [month_estimate] =>
            [month_estimate_label] =>
            [month_estimate_value] =>
            [day] =>
            [day_estimate] =>
            [day_estimate_label] =>
            [day_estimate_value] =>
            [hour] =>
            [hour_estimate] =>
            [hour_estimate_label] =>
            [hour_estimate_value] =>
            [minute] =>
            [minute_estimate] =>
            [minute_estimate_label] =>
            [minute_estimate_value] =>
            [second] =>
            [second_estimate] =>
            [second_estimate_label] =>
            [second_estimate_value] =>
            [timezone] =>
        )

    [check_approximate] => 0
)
  */
