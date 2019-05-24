<?php


$tally = 0;
$output = '';

$fc_type = array("field_ipu_event_section");
#$node_field = 'field_ipu_event_section';


//$result = db_query("SELECT nid FROM node WHERE type = :nodeType ", array(':nodeType' => $node_type)); //<-- change 1
$result = db_query("SELECT item_id FROM field_collection_item WHERE field_name = :fcType ", array(':fcType' => $fc_type)); //<-- change 1

$ids = array();

foreach ($result as $obj) {
  $ids[] = $obj->item_id;
  $id = $obj->item_id;


//  print "\n\r";
//  print "*********************************";
//  print "\n\r";
//  print $nid;

  $tally++;

  $fc = entity_load_single('field_collection_item', $id);

  $output .= "\r\r" . '$field_ipu_event_section[' . $id . '] = array(';

  $output .= "\r" . '    "field_original_fc_id"=>' . $id . ', ';


  if (!empty($fc->field_ie_fc_title)) {
    foreach ($fc->field_ie_fc_title as $contents) {
      foreach ($contents as $content) {
//        print('a ->');
//        print_r($content);
        if (!empty($content['value'])) {
          $output .= "\r" . '    "field_ie_fc_title"=>"' . htmlspecialchars($content['value']) . '", ';
        }
      }
    }
  }

  if (!empty($fc->field_ie_fc_description)) {
    foreach ($fc->field_ie_fc_description as $contents) {
      foreach ($contents as $content) {
        $output .= "\r" . '"field_ie_fc_description"=>"' . htmlspecialchars($content['value']) . '", ';
//            print('b ->');
//           print_r($content);
      }
    }
  }

  if (!empty($fc->field_ie_fc_button_links)) {
    foreach ($fc->field_ie_fc_button_links as $contents) {
      foreach ($contents as $content) {
        print('c ->');
        print_r($content);
        $output.= "\r" . '    "field_ie_fc_button_links"=>array (';
        if(!empty($content['url'])) {
          $output.= "\r" . '    "url"=>"' .  htmlspecialchars($content['url']) . '", ';
        }
        if(!empty($content['title'])) {
          $output.= "\r" . '    "title"=>"' .  htmlspecialchars($content['title']) . '", ';
        }
        $output.= "\r" . '    ),';
      }
    }
  }

  if (!empty($fc->field_ipu_event_document_widget)) {
    foreach ($fc->field_ipu_event_document_widget as $contents) {
      foreach ($contents as $content) {
//            print('d ->');
//            print_r($content);
        if (!empty($content['value'])) {
          $output .= "\r" . '    "field_ipu_event_document_widget"=>"' . htmlspecialchars($content['value']) . '", ';
        }
      }
    }
  }

  $output .= "\r );";
}

debug($output);
//print "IDs: " . implode("\n\r", $nids);
print "\r\r";
print $tally . ' tally of ' . strtoupper($fc_type);
