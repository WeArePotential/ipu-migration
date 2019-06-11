<?php

$tally = 0;
$output = '';

$node_type = array("ipu_event");
$node_field = 'field_ipu_event_session_type';

# field collection type = 'ipu_event_session_type';


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
  //$output.= "\n\r".' $d8_nodes[' . $node->title . '] = array(';

  foreach ($items as $item) {
    #debug($item);

    $fc = field_collection_field_get_entity($item); // Do something.
    #debug($fc);

    $output.= "\r" . '  array(' . "\r";

    if (!empty($fc->field_fc_session_type_title)) {
      foreach ($fc->field_fc_session_type_title as $contents) {
        foreach ($contents as $content) {

          if(!empty($content['value'])) {
            $output.= "\r" . '    "field_fc_session_type_title"=>"' .  htmlspecialchars($content['value']) . '", ';
          }
        }
      }
    }
    $output .= "\r" . '    "field_fc_original_id"=>'.$item['value'].',';

    if (isset($fc->field_fc_session_closed_session['und']['0']['value']) && $fc->field_fc_session_closed_session['und']['0']['value'] == 1) {
      $output .= "\r" . '    "field_fc_session_closed_session"=>1,';
    } else {
      $output .= "\r" . '    "field_fc_session_closed_session"=>0,';
    }

    if (isset($fc->field_mark_as_other['und']['0']['value']) && $fc->field_mark_as_other['und']['0']['value'] == 1) {
      $output .= "\r" . '    "field_mark_as_other"=>1,';
    } else {
      $output .= "\r" . '    "field_mark_as_other"=>0,';
    }

    $output.= "\r  ),";
  }

  $output.= "\r );";
}

debug( $output );
print "IDs: " . implode("\n\r", $nids);
print "\r";
print $tally . ' NODES OF TYPE: ' . strtoupper($node_type);
