<?php

$tally = 0;
$output = '';

$node_type = array("ipu_event");
$node_field = 'field_ipu_event_right_menu';


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

    $fc = field_collection_field_get_entity($item); // Do something.

    $output.= "\r" . '  array(' . "\r";

    if (!empty($fc->field_ipu_event_section_title)) {
      foreach ($fc->field_ipu_event_section_title as $contents) {
        foreach ($contents as $content) {
          print('a ->');
          print_r($content);
          if(!empty($content['value'])) {
            $output.= "\r" . '    "field_ipu_event_section_title"=>"' .  htmlspecialchars($content['value']) . '", ';
          }
        }
      }
    }

    if (!empty($fc->field_ipu_event_section_desc)) {
      foreach ($fc->field_ipu_event_section_desc as $contents) {
        foreach ($contents as $content) {
          $output.= "\r" . '"field_ipu_event_section_desc"=>"' .  htmlspecialchars($content['value']) . '", ';
//          print('b ->');
//          print_r($content);
        }
      }
    }

    if (!empty($fc->field_ipu_event_button)) {
      foreach ($fc->field_ipu_event_button as $contents) {
        $output .= "\r" . '    "field_ipu_event_button"=>array(';
        foreach ($contents as $content) {
          print('c ->');
          print_r($content);
          if(!empty($content['url'])) {
            $output .= "\r" . '      array(';
            $output .= "\r" . '        ["uri"]=>"' . htmlspecialchars($content['url']) . '", ';
            $output .= "\r" . '        ["title"]=>"' . htmlspecialchars($content['title']) . '", ';
            $output .= "\r" . '       ), ';
         #   $output.= "\r" . '    "field_ipu_event_button"=>"' .  htmlspecialchars($content['value']) . '", ';
          }
        }
        $output .= "\r" . '    ), ';
      }
    }

    if (!empty($fc->field_ipu_event_document_widget)) {
      foreach ($fc->field_ipu_event_document_widget as $contents) {
        foreach ($contents as $content) {
//          print('d ->');
//          print_r($content);
          if(!empty($content['value'])) {
            $output.= "\r" . '    "field_ipu_event_document_widget"=>"' .  htmlspecialchars($content['value']) . '", ';


//            $widget = entity_load('field_collection_item', array($content['value']));

//            dpm($widget->field_ipu_event_document);
//            dpm($widget->field_ipu_event_document_r);

            print("\r\r$nid : PID " .$content['value']);
            $collections = field_collection_item_load_multiple(array($content['value']));
            $loadedValues = array();
//Loop over the array - if you have more than one entity
            $i = 0;
            foreach ($collections as $collection) { // loop through the ...widget fc

              //Iterate over all member vars of the FieldCollectionItemEntity object
              foreach($collection as $key => $value) {
                //Look for fields - there are some other class vars, too.
                if (strpos ($key, 'field') !== false) {
                  //Search for textfields
                  if (is_array($value) && isset($value['und']) && is_array($value ['und'])
                    && (isset($value['und'][0]['value'])||isset($value['und'][0]['uri'])
                      ||isset($value['und'][0]['target_id']))
                  ) {
                    #                 print "\r  Field " . $key . " " . $value['und'][0]['value'];
                    if (isset($value['und'][0]['value'])) {
                      $loadedValues[$i][$key] = $value['und'][0]['value']; // ..widget -> field_ipu_event_document
                      #                   print ' here';

                      $fc_id = $value['und'][0]['value']; // id for field_ipu_event_document
                      $sale_wrapper = entity_metadata_wrapper('field_collection_item', $fc_id); // field_ipu_event_document

                      if(!empty($sale_wrapper->field_event_document_description->value())) {
                        foreach ($sale_wrapper->field_event_document_description->value() as $title) {
                          print "\r   description = " . $title;
                        }
                      }

                      if(!empty($sale_wrapper->field_event_document_title->value())) {
                        foreach ($sale_wrapper->field_event_document_title->value() as $key => $saleitem) {
                          print "\r   title " . $key . ' = ' . $saleitem;
//                        if($key == 'fid') {
//                          print "\r   pid = " .$saleitem;
//                        }
                        }
                      }

                      if(!empty($sale_wrapper->field_speech->value())) {
                        foreach ($sale_wrapper->field_speech->value() as $key => $saleitem) {
                          print "\r   speech? " . $key . ' = ' . $saleitem;
//                        if($key == 'fid') {
//                          print "\r   pid = " .$saleitem;
//                        }
                        }
                      }

                      if(!empty($sale_wrapper->field_event_document->value())) {
                        $output .= "\r\r     \"field_event_document\" => array(";
                        foreach ($sale_wrapper->field_event_document->value() as $key => $saleitem) {
                          print "\r   doc " . $key . ' = ' . $saleitem;
                          if ($key == 'fid') {
                            $output.= '   "fid"=>' . $saleitem . ", \r";
                          }
                        }
                        $output .= "   ),";
                      }

                    }
                    else if($value['und'][0]['uri'])
                    {
                      $loadedValues[$i][$key] = $value['und'][0]['uri'];
                      print ' there';
                    }
                  }
                }
              }
              $i++;
            }

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
print "\r\r";
print $tally . ' NODES OF TYPE: ' . strtoupper($node_type);
