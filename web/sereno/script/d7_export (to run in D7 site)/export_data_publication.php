<?php

$tally = 0;

$node_type = "publication";

$result = db_query("SELECT nid FROM node WHERE type = :nodeType ", array(':nodeType'=>$node_type)); //<-- change 1

$nids = array();

foreach ($result as $obj) {
  $nids[] = $obj->nid;
  $nid = $obj->nid;

  $output.= "\n\r".' $d8_nodes[' . $nid . '] = array(';
//  print "\n\r";
//  print "*********************************";
//  print "\n\r";
//  print $nid;


  $tally++;

  $node = node_load($nid);
  $items = field_get_items('node', $node, 'field_publication_document');
//here items are having the entity id/itemid
  foreach ($items as $item) {

    $fc = field_collection_field_get_entity($item); // Do something.

    #$output.= "\r" . '  array(' . "\r";

    if (!empty($fc->field_publication_file)) {

      $output.= "\r" . '  array(' . "\r";

      foreach ($fc->field_publication_file as $contents) {
        foreach ($contents as $content) {
          # print "\n\r";
          # print_r($content);
          # print(' - fid:' . $content['fid']);
          if(!empty($content['fid']) && is_numeric($content['fid'])) {
            $output .= '    "field_publication_file"=>' . $content['fid'] . ', ';
          }
        }
      }
    }
    else {
      continue;
    }


    if (!empty($fc->field_publication_file) &&
      !empty($fc->field_publication_languag)) {
      foreach ($fc->field_publication_languag as $contents) {

        foreach ($contents as $content) {
          # print "\n\r";
          # print_r($content);
          # print(' - language:' . $content['fid']);
          $output.= '"field_publication_language"=>"' . $content['value'] . '", ';
        }
      }
    }
    $output.= "\r  ),";
  }

  $output.= "\r );";
}

debug( $output );
#print "IDs: " . implode("\n\r", $nids);
print "\r";
print $tally . ' NODES OF TYPE: ' . strtoupper($node_type);
