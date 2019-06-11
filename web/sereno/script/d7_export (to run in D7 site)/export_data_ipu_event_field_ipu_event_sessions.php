<?php

$tally = 0;
$output = '';

$node_type = array("ipu_event");
$node_field = 'field_ipu_event_sessions';


$result = db_query("SELECT nid FROM node WHERE type = :nodeType ", array(':nodeType'=>$node_type)); //<-- change 1

$nids = array();

foreach ($result as $obj) {
  $nids[] = $obj->nid;
  $nid = $obj->nid;

  //if ($nid == 9174) {
    //  print "\n\r";
    //  print "*********************************";
    //  print "\n\r";
    //  print $nid;


    $tally++;

    $node = node_load($nid);
    $items = field_get_items('node', $node, $node_field);

    //here items are having the entity id/itemid

    /*if (empty($items)) {
      continue;
    }*/

    $output .= "\n\r" . ' $d8_nodes[' . $nid . '] = array(';


    foreach ($items as $item) {

      $fc = field_collection_field_get_entity($item); // Do something.

      $output .= "\r" . '  array(' . "\r";

      //print "Peter\n".print_r($fc->field_fc_sessions_description,TRUE);
      if (!empty($fc->field_fc_sessions_session_title)) {
        foreach ($fc->field_fc_sessions_session_title as $contents) {
          foreach ($contents as $content) {
            print('a ->');
            print_r($content);
            if (!empty($content['value'])) {
              $output .= "\r" . '    "field_fc_sessions_session_title"=>"' . htmlspecialchars($content['value'], ENT_QUOTES) . '", ';
            }
          }
        }
      }

      if (!empty($fc->field_fc_sessions_description)) {
        foreach ($fc->field_fc_sessions_description as $contents) {
          foreach ($contents as $content) {
            $output .= "\r" . '"field_fc_sessions_description"=>"' . htmlspecialchars($content['value'], ENT_QUOTES) . '", ';
            print('b ->');
            print_r($content);
          }
        }
      }

      if (!empty($fc->field_fc_session_type)) {
        foreach ($fc->field_fc_session_type as $contents) {
          $output .= "\r" . ' "field_fc_session_type"=>array(';
          foreach ($contents as $content) {
            if (!empty($content['target_id'])) {
              $output .= htmlspecialchars($content['target_id']) . ', ';
              print('c ->');
              print_r($content);
            }
          }
          $output .= '),' . "\r";
        }
      }

      if (!empty($fc->field_fc_sessions_theme)) {
        foreach ($fc->field_fc_sessions_theme as $contents) {
          $output .= "\r" . ' "field_fc_sessions_theme"=>array(';
          foreach ($contents as $content) {
            if (!empty($content['target_id'])) {
              $output .= htmlspecialchars($content['target_id']) . ', ';
              print('d ->');
              print_r($content);
            }
          }
          $output .= '),' . "\r";
        }
      }

      if (!empty($fc->field_fc_session_governing_body)) {
        foreach ($fc->field_fc_session_governing_body as $contents) {
          $output .= "\r" . ' "field_fc_session_governing_body"=>array(';
          foreach ($contents as $content) {
            if (!empty($content['target_id'])) {
              $output .= htmlspecialchars($content['target_id']) . ', ';
              print('e ->');
              print_r($content);
            }
          }
          $output .= '),' . "\r";
        }
      }

      if (!empty($fc->field_fc_session_room)) {
        foreach ($fc->field_fc_session_room as $contents) {
          foreach ($contents as $content) {
            $output .= "\r" . '"field_fc_session_room"=>"' . htmlspecialchars($content['value'], ENT_QUOTES) . '", ';
            print('f ->');
            print_r($content);
          }
        }
      }

      //    print('$fc->field_fc_sessions_closed_session');
      //    print($fc->field_fc_sessions_closed_session['und']['0']['value']);

      if (isset($fc->field_fc_sessions_closed_session['und']['0']['value']) && $fc->field_fc_sessions_closed_session['und']['0']['value'] == 1) {
        $output .= "\r" . '    "field_fc_sessions_closed_session"=>1,';
      }
      else {
        $output .= "\r" . '    "field_fc_sessions_closed_session"=>0,';
      }

      if (!empty($fc->field_fc_session_date)) {
        foreach ($fc->field_fc_session_date as $contents) {
          foreach ($contents as $content) {
            $output .= "\r" . '"field_fc_session_date_start"=>"' . htmlspecialchars($content['value']) . '", ';
            $output .= "\r" . '"field_fc_session_date_end"=>"' . htmlspecialchars($content['value2']) . '", ';
            print('g ->');
            print_r($content);
          }
        }
      }

      if (!empty($fc->field_fc_sessions_custom_label)) {
        foreach ($fc->field_fc_sessions_custom_label as $contents) {
          foreach ($contents as $content) {
            $output .= "\r" . '"field_fc_sessions_custom_label"=>"' . htmlspecialchars($content['value'], ENT_QUOTES) . '", ';
            print('h ->');
            print_r($content);
          }
        }
      }

      if (!empty($fc->field_fc_sessions_session_order)) {
        foreach ($fc->field_fc_sessions_session_order as $contents) {
          foreach ($contents as $content) {
            $output .= "\r" . '"field_fc_sessions_session_order"=>' . $content['value'] . ', ';
            print('i ->');
            print_r($content);
          }
        }
      }

      if (isset($fc->field_fc_sessions_hide_time['und']['0']['value']) && $fc->field_fc_sessions_hide_time['und']['0']['value'] == 1) {
        $output .= "\r" . '    "field_fc_sessions_hide_time"=>1,';
      }
      else {
        $output .= "\r" . '    "field_fc_sessions_hide_time"=>0,';
      }


      //    if (!empty($fc->field_ipu_event_button)) {
      //      foreach ($fc->field_ipu_event_button as $contents) {
      //        $output .= "\r" . '    "field_ipu_event_button"=>array(';
      //        foreach ($contents as $content) {
      //          print('c ->');
      //          print_r($content);
      //          if(!empty($content['url'])) {
      //            $output .= "\r" . '      array(';
      //            $output .= "\r" . '        ["uri"]=>"' . htmlspecialchars($content['url']) . '", ';
      //            $output .= "\r" . '        ["title"]=>"' . htmlspecialchars($content['title']) . '", ';
      //            $output .= "\r" . '       ), ';
      //         #   $output.= "\r" . '    "field_ipu_event_button"=>"' .  htmlspecialchars($content['value']) . '", ';
      //          }
      //        }
      //        $output .= "\r" . '    ), ';
      //      }
      //    }

      if (!empty($fc->field_ipu_event_document_widget)) {
        foreach ($fc->field_ipu_event_document_widget as $contents) {
          foreach ($contents as $content) {
            //          print('d ->');
            //          print_r($content);
            if (!empty($content['value'])) {
              $output .= "\r" . '    "field_ipu_event_document_widget"=>"' . htmlspecialchars($content['value']) . '", ';
              $output .= "\r" . '    "ipu_event_document_widget_data"=>array( ';


              //            $widget = entity_load('field_collection_item', array($content['value']));

              //            dpm($widget->field_ipu_event_document);
              //            dpm($widget->field_ipu_event_document_r);

              print("\r\r$nid : PID " . $content['value']);
              $collections = field_collection_item_load_multiple([$content['value']]);
              $loadedValues = [];
              //Loop over the array - if you have more than one entity
              $i = 0;
              foreach ($collections as $collection) { // loop through the ...widget fc

                //Iterate over all member vars of the FieldCollectionItemEntity object
                foreach ($collection as $key => $value) {
                  //Look for fields - there are some other class vars, too.
                  if (strpos($key, 'field') !== FALSE) {
                    //Search for textfields
                    if (is_array($value) && isset($value['und']) && is_array($value ['und'])
                      && (isset($value['und'][0]['value']) || isset($value['und'][0]['uri'])
                        || isset($value['und'][0]['target_id']))
                    ) {
                      #                 print "\r  Field " . $key . " " . $value['und'][0]['value'];
                      if (isset($value['und'][0]['value'])) {
                        $loadedValues[$i][$key] = $value['und'][0]['value']; // ..widget -> field_ipu_event_document
                        #                   print ' here';

                        $fc_id = $value['und'][0]['value']; // id for field_ipu_event_document
                        $sale_wrapper = entity_metadata_wrapper('field_collection_item', $fc_id); // field_ipu_event_document

                        if (!empty($sale_wrapper->field_event_document_description->value())) {
                          foreach ($sale_wrapper->field_event_document_description->value() as $key => $title) {
                            print "\r   description = " . $title;
                            print_r($title['value']);

                            if (!empty($title['value'])) {
                              $output .= '   "description_value"=>' . $title['value'] . ", \r";
                            }
                          }
                        }

                        if (!empty($sale_wrapper->field_event_document_title->value())) {
                          foreach ($sale_wrapper->field_event_document_title->value() as $key => $saleitem) {
                            print "\r   title " . $key . ' = ' . $saleitem;
                            if ($key == 'value') {
                              $output .= '   "title_value"=>' . $saleitem . ", \r";
                            }
                          }
                        }

                        if (!empty($sale_wrapper->field_speech->value())) {
                          foreach ($sale_wrapper->field_speech->value() as $key => $saleitem) {
                            print "\r   speech? " . $key . ' = ' . $saleitem;
                            if ($key == 'value') {
                              $output .= '   "speech_value"=>' . $saleitem . ", \r";
                            }
                          }
                        }

                        if (!empty($sale_wrapper->field_event_document->value())) {
                          $output .= "\r\r     \"field_event_document\" => array(";
                          foreach ($sale_wrapper->field_event_document->value() as $key => $saleitem) {
                            print "\r   doc " . $key . ' = ' . $saleitem;
                            if ($key == 'fid') {
                              $output .= '   "fid"=>' . $saleitem . ", \r";
                            }
                          }
                          $output .= "   ),";
                        }

                      }
                      else {
                        if ($value['und'][0]['uri']) {
                          $loadedValues[$i][$key] = $value['und'][0]['uri'];
                          print ' there';
                        }
                      }
                    }
                  }
                }
                $i++;
              }
              $output .= "\r" . '    ),';
            }
          }
        }
      }

      $output .= "\r  ),";
    }

    $output.= "\r );";
  //}
}

debug( $output );
//print "IDs: " . implode("\n\r", $nids);
print "\r\r";
print $tally . ' NODES OF TYPE: ' . strtoupper($node_type);
