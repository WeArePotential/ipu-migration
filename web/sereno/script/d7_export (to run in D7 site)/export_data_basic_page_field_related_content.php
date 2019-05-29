<?php

$tally = 0;
$output = '';

$node_type = "basic_page";

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

  //$items = field_get_items('node', $node, 'field_related_content');

  $french_items = field_get_items('node', $node, 'field_related_content', 'fr');
  if ($french_items) {
    foreach ($french_items as &$fritem) {
      $fritem['langcode'] = 'fr';
    }
  }
  $english_items = field_get_items('node', $node, 'field_related_content', 'en');
  if ($english_items) {
    foreach ($english_items as &$enitem) {
      $enitem['langcode'] = 'en';
    }
  }
  $items = array_merge((is_array($english_items) ? $english_items : []), (is_array($french_items) ? $french_items : []));

  $counts[$nid] = [count($english_items), count($french_items)];
  if (is_array($english_items)) {
    if (is_array($french_items)) {
      if (count($english_items) != count($french_items)) {
        $errors[] = 'Node ' . $nid . ' has asymmetric numbers of FCs';
      }
    }
    else {
      $errors[] = 'Node ' . $nid . ' only has English FCs';
    }
  } else {
    if (is_array($french_items)) {
      $errors[] = 'Node ' . $nid . ' only has French FCs';
    }
  }

  if(empty($items)) {
    continue;
  }

  $output.= "\n\r".' $d8_nodes[' . $nid . '] = array(';

//here items are having the entity id/itemid
  foreach ($items as $item) {
    #debug($item);

    $fc = field_collection_field_get_entity($item); // Do something.
    #debug($fc);

    $output.= "\r" . '  array(';
    $output .= "\r" . '    "field_original_fc_id"=>"' . $item['value'] . '", ';
    $output .= "\r" . '    "field_original_fc_revision_id"=>"' . $item['revision_id'] . '", ';
    $output .= "\r" . '    "field_original_fc_langcode"=>"' . $item['langcode'] . '", ';

//    if (!empty($fc->field_related_document)) {
//
//      foreach ($fc->field_related_document as $contents) {
//        foreach ($contents as $content) {
//          # print "\n\r";
//          #debug($content);
//          # print(' - fid:' . $content['fid']);
//          if(!empty($content['target_id']) && is_numeric($content['target_id'])) {
//            $output .= "\r" . '    "field_related_document"=>' . $content['target_id'] . ', ';
//          }
//        }
//      }
//    }

    if (!empty($fc->field_node)) {
      foreach ($fc->field_node as $contents) {
        foreach ($contents as $content) {
          if(!empty($content['target_id'])) {
            $output.= "\r" . '    "field_node"=>"' .  htmlspecialchars($content['target_id']) . '", ';
          }
        }
      }
    }

    if (!empty($fc->field_external_link)) { // only one link allowed in this field, so no need to loop...

      $ary_link = $fc->field_external_link['und'][0];
      if(!empty($ary_link['url'])) {
        $output .= "\r" . '  "field_external_link"=>array(';
        $output .= "\r" . '    "uri"=>"' . htmlspecialchars($ary_link['url']) . '", ';
        $output .= "\r" . '    "title"=>"' . htmlspecialchars($ary_link['title']) . '", ';
        $output .= "\r" . '  ), ';
      }
    }

    $output.= "\r  ),";
  }

  $output.= "\r );";
}

debug( $output );
foreach($errors as $error) {
  drupal_set_message($error);
}

print "IDs: " . implode("\n\r", $nids);
print "\r";
print $tally . ' NODES OF TYPE: ' . strtoupper($node_type);
