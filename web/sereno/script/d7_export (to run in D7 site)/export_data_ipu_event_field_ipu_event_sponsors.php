<?php

$tally = 0;
$output = '';

$node_type = array("ipu_event");
$node_field = 'field_ipu_event_sponsors';

# field collection type = 'ipu_event_sponsors';


$result = db_query("SELECT nid FROM node WHERE type = :nodeType ", array(':nodeType'=>$node_type)); //<-- change 1

$nids = array();

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


  if(empty($items)) {
    continue;
  }

  $output.= "\n\r".' $d8_nodes[' . $nid . '] = array(';


  foreach ($items as $item) {
    #debug($item);

    $fc = field_collection_field_get_entity($item); // Do something.
    #debug($fc);

    $output.= "\r" . '  array(' . "\r";

    if (!empty($fc->field_ipu_event_sponsor_name)) {
      foreach ($fc->field_ipu_event_sponsor_name as $contents) {
        foreach ($contents as $content) {
          #debug($content);
          if (!empty($content['tid'])) {
            $output .= "\r" . '    "field_ipu_event_sponsor_name"=>"' . htmlspecialchars($content['tid']) . '", ';
          }
        }
      }
    }

    $output.= "\r  ),";
  }

  $output.= "\r );";
}

debug( $output );
//print "IDs: " . implode("\n\r", $nids);
//print "\r";
//print $tally . ' NODES OF TYPE: ' . strtoupper($node_type);
