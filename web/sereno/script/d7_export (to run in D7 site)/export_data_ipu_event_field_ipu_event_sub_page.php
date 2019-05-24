<?php

$tally = 0;
$fc_tally = 0;
$output = '';

$node_type = "ipu_event";
$node_field = 'field_event_sub_page';


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
  $items = field_get_items('node', $node, $node_field, 'en');

//here items are having the entity id/itemid


  if (empty($items)) {
    echo " continuing $nid ";
    continue;
  }

  $output .= "\n\r" . ' $d8_nodes[' . $nid . '] = array(';

//  $field_info = field_info_field($items);
//  $lang = $field_info['translatable'] ? entity_language('node', $node) : LANGUAGE_NONE;
//
//  echo $lang . ' ' ;

  foreach ($items as $item) {

    $fc = field_collection_field_get_entity($item); // Do something.
    $fc_tally++;

    $output .= "\r" . '  array(' . "\r";

    $output .= "\r" . '    "fc_original_id"=>"' . $fc->item_id . '", ';

    if (!empty($fc->field_title)) {
      foreach ($fc->field_title as $contents) {
        foreach ($contents as $content) {
//          print('a ->');
//          print_r($content);
          if (!empty($content['value'])) {
            $output .= "\r" . '    "field_title"=>"' . htmlspecialchars($content['value']) . '", ';
          }
        }
      }
    }

    if (!empty($fc->field_order)) {
      foreach ($fc->field_order as $contents) {
        foreach ($contents as $content) {
          $output .= "\r" . '    "field_order"=>"' . $content['value'] . '", ';
//          print('b ->');
//          print_r($content);
        }
      }
    }

    if (isset($fc->field_sub_page_show_print['und']['0']['value']) && $fc->field_sub_page_show_print['und']['0']['value'] == 1) {
      $output .= "\r" . '    "field_sub_page_show_print"=>1,';
    } else {
      $output .= "\r" . '    "field_sub_page_show_print"=>0,';
    }

    if (!empty($fc->field_ipu_event_section)) {
      foreach ($fc->field_ipu_event_section as $contents) {
        $output .= "\r" . '    "fc_original_field_ipu_event_section"=> array( ';
        foreach ($contents as $content) {
//          print('d ->');
//          print_r($content);
          if (!empty($content['value'])) {
            $output .= $content['value'] . ', ';
           # $output .= "\r" . '    "field_ipu_event_section_data"=array( ';
          }
        }
        $output .=  '), ';
      }
    }
    $output .= "\r  ),";
  }
  $output .= "\r );";
}


debug( $output );
//print "IDs: " . implode("\n\r", $nids);
print "\r\r";
print $tally . ' NODES OF TYPE: ' . strtoupper($node_type);
print "\r\r";
print $tally . ' FIELD COLLECTIONS ';
