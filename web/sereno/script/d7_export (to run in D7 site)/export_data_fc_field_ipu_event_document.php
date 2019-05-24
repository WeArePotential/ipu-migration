<?php

$tally = 0;
$output = '';

$fc_type = "field_ipu_event_document";


$result = db_query("SELECT item_id FROM field_collection_item WHERE field_name = :nodeType ", array(':nodeType'=>$fc_type)); //<-- change 1

$ids = array();

foreach ($result as $obj) {
  $ids[] = $obj->item_id;
  $id = $obj->item_id;

  $tally++;

  $fc = entity_load_single('field_collection_item', $id);

// "field_event_document_description"=>array("value"=>"&lt;p&gt;The involvement and active commitment of parliaments in maintaining international security and peace through support for a political solution&lt;/p&gt;", "format"=>"full_html"),
// "field_event_document_title"=>"Programme",
// "field_speech"=>0,
// "field_event_document"=>6270,
// "field_original_fc_id"=>5314,

//  echo 'lang';
//  echo entity_language('field_collection_item', $fc);


      $output .= "\r\r" . '$field_ipu_event_document[' . $id . '] = array(';

      if (!empty($fc->field_event_document_title)) {
        foreach ($fc->field_event_document_title as $contents) {
          foreach ($contents as $content) {
            if (!empty($content['value'])) {
              $output .= "\r" . '    "field_event_document_title"=>"' . htmlspecialchars($content['value']) . '", ';
            }
          }
        }
      }

      if (isset($fc->field_speech['und']['0']['value']) && $fc->field_speech['und']['0']['value'] == 1) {
        $output .= "\r" . '    "field_speech"=>1,';
      } else {
        $output .= "\r" . '    "field_speech"=>0,';
      }

      if (!empty($fc->field_event_document_description)) {
        foreach ($fc->field_event_document_description as $contents) {
          debug($contents);
          foreach ($contents as $content) {
            debug($content);
            if (!empty($content['value'])) {
              $output .= "\r" . '    "field_event_document_description"=>array("value"=>"' . htmlspecialchars(trim($content['value'])) . '", "format"=>"' . ($content['format']) . '"), ';
            }
          }
        }
      }

      if (!empty($fc->field_event_document)) {
        foreach ($fc->field_event_document as $contents) {
          foreach ($contents as $content) {
            # print "\n\r";
            #debug($content);
            # print(' - fid:' . $content['fid']);
            if(!empty($content['fid']) && is_numeric($content['fid'])) {
              $output .= "\r" . '    "field_event_document"=>' . $content['fid'] . ', ';
            }
          }
        }
      }

      $output .= "\r" . '    "field_original_fc_id"=>' . $id . ', ';

      $output .= "\r);";
}

debug( $output );

print('number of records: ' . $tally);

