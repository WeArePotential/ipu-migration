<?php

$tally = 0;
$output = '';

$fc_type = "field_ipu_event_document_widget";

$result = db_query("SELECT item_id FROM field_collection_item WHERE field_name = :nodeType ", array(':nodeType'=>$fc_type)); //<-- change 1

$ids = array();

foreach ($result as $obj) {
  $ids[] = $obj->item_id;
  $id = $obj->item_id;

  $tally++;

  $fc = entity_load_single('field_collection_item', $id);

  $output .= "\r\r" . '$field_ipu_event_document_widget[' . $id . '] = array(';

  if (!empty($fc->field_ipu_event_document)) {
    foreach ($fc->field_ipu_event_document as $contents) {
      $output .= "\r" . ' "ary_field_ipu_event_document_original_fc_values"=>array(';
      foreach ($contents as $content) {
        if (!empty($content['value'])) {
          $output .= htmlspecialchars($content['value']) . ', ';
        }
      }
      $output .= '),'."\r";
    }
  }

  if (!empty($fc->field_ipu_event_document_r)) {
    foreach ($fc->field_ipu_event_document_r as $contents) {
      $output .= "\r" . ' "ary_field_ipu_event_document_r_original_fc_target_ids"=>array(';
      foreach ($contents as $content) {
        if (!empty($content['target_id'])) {
          $output .= htmlspecialchars($content['target_id']) . ', ';
        }
      }
      $output .= '),'."\r";
    }
  }


  $output .= "\r" . '    "field_original_fc_id"=>' . $id . ', ';

  $output .= "\r);";
}

debug( $output );
