<?php

$node_type = array("committee_member");
$node_field = 'field_end_of_mandate';

$result = db_query("SELECT nid FROM node WHERE type = :nodeType ", array(':nodeType'=>$node_type)); //<-- change 1

$nids = array();
$output = '';
$tally = 0;

$output.= '$ary_end_of_mandate=array(';

foreach ($result as $obj) {
  $nids[] = $obj->nid;
  $nid = $obj->nid;

//  print "\n\r";
//  print "*********************************";
//  print "\n\r";
//  print $nid;

  $tally++;

  $node = node_load($nid);
  $items = field_get_items('node', $node, $node_field);

  //here items are having the entity id/itemid
  #print_r($item['from']['year']);
  if (is_array($items)) {
    foreach ($items as $item) {

      $output .= "\r  " . '$d8_nodes[' . $nid . ']=array(';

      if(!empty($item['timestamp'])) {

        $timestamp = strtotime($item['timestamp']);
        $dt = date("Y-m-d\TH:i:s", $timestamp);

        $output .= "\r    \"timestamp\"=>\"" . $dt . "\",";
      }

      if(!empty($item['from']['year'])) {
        $output .= "\r    \"year\"=>\"" . $item['from']['year'] . "\",";
      }

      if(!empty($item['from']['month'])) {
        $output .= "\r    \"month\"=>\"" . $item['from']['month'] . "\",";
      }

      if(!empty($item['from']['day'])) {
        $output .= "\r    \"day\"=>\"" . $item['from']['day'] . "\",";
      }

      $output .= "\r       );";
    }
  }
}

$output.= "\r );";
debug( $output );

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
