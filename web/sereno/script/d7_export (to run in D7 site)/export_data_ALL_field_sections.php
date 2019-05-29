<?php
$tally = 0;
$output = '';

$node_types = array("basic_page","section_page","page");
$result = db_query("SELECT nid FROM node WHERE type IN (:nodeType) ", [':nodeType' => $node_types]);

$nids = [];
$counts = [];
$errors = [];

foreach ($result as $obj) {
  $nids[] = $obj->nid;
  $nid = $obj->nid;
  //if ($nid == 236) {

  $output .= "\n\r" . ' $d8_nodes[' . $nid . '] = array(';
  //  print "\n\r";
  //  print "*********************************";
  //  print "\n\r";
  //  print $nid;


  $tally++;

  $node = node_load($nid);

  $french_items = field_get_items('node', $node, 'field_sections', 'fr');
  if ($french_items) {
    foreach ($french_items as &$fritem) {
      $fritem['langcode'] = 'fr';
    }
  }
  $english_items = field_get_items('node', $node, 'field_sections', 'en');
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
      $errors[] = 'Node ' . $nid . ' only has Fench FCs';
    }
  }

    //debug($english_items);
    //debug($french_items);

    //here items are having the entity id/itemid

    // $field_info = field_info_field($items);
    // print_r("field_info");
    // print_r($field_info);
    //$lang = $field_info['translatable'] ? entity_language('field_collection', $fc) : LANGUAGE_NONE;

    #echo '>>'.$lang;

    if (empty($items)) {
      continue;
    }

    foreach ($items as $item) {
      //debug($item);

      $fc = field_collection_field_get_entity($item); // Do something.
      //debug($fc);


      $output .= "\r" . '  array(';
      $output .= "\r" . '    "fc_value"=>"' . $item['value'] . '", ';
      $output .= "\r" . '    "fc_revision_id"=>"' . $item['revision_id'] . '", ';
      $output .= "\r" . '    "fc_langcode"=>"' . $item['langcode'] . '", ';

      if (!empty($fc->field_section_title)) {
        foreach ($fc->field_section_title as $contents) {
          foreach ($contents as $content) {
            if (!empty($content['value'])) {
              $output .= "\r" . '    "field_section_title"=>"' . htmlspecialchars($content['value']) . '", ';
            }
            else {
              continue;
            }
          }
        }
      }
      else {
        continue;
      }

      if (!empty($fc->field_section_description)) {
        foreach ($fc->field_section_description as $contents) {
          foreach ($contents as $content) {
            if (!empty($content['value'])) {
              $output .= "\r" . '    "field_section_description"=>"' . htmlspecialchars($content['value']) . '", ';
            }
          }
        }
      }

      if (!empty($fc->field_section_display_options)) {
        foreach ($fc->field_section_display_options as $contents) {
          foreach ($contents as $content) {
            if (!empty($content['value'])) {
              $output .= "\r" . '"field_section_display_options"=>"' . htmlspecialchars($content['value']) . '", ';
            }
          }
        }
      }

      if (!empty($fc->field_section_html)) {
        foreach ($fc->field_section_html as $contents) {
          foreach ($contents as $content) {
            if (!empty($content['value'])) {
              $output .= "\r" . '    "field_section_html"=>"' . htmlspecialchars($content['value']) . '", ';
            }
          }
        }
      }

      if (!empty($fc->field_section_node)) {
        foreach ($fc->field_section_node as $contents) {
          foreach ($contents as $content) {
            if (!empty($content['value'])) {
              $output .= "\r" . '    "field_section_node"=>"' . htmlspecialchars($content['value']) . '", ';
            }
          }
        }
      }

      if (!empty($fc->field_section_view)) {
        foreach ($fc->field_section_view as $contents) {
          foreach ($contents as $content) {
            if (!empty($content['vname'])) {
              $output .= "\r" . '    "field_section_view_vname"=>"' . htmlspecialchars($content['vname']) . '", ';
            }
            if (!empty($content['vdisplay'])) {
              $output .= "\r" . '    "field_section_view_vdisplay"=>"' . htmlspecialchars($content['vdisplay']) . '", ';
            }
          }
        }
      }

      if (!empty($fc->field_section_view)) {
        foreach ($fc->field_section_view as $contents) {
          foreach ($contents as $content) {
            if (!empty($content['vargs'])) {
              $output .= "\r" . '    "field_section_view_vargs"=>"' . htmlspecialchars($content['vargs']) . '", ';
            }
          }
        }
      }

      if (!empty($fc->field_section_view_arguments)) {
        foreach ($fc->field_section_view_arguments as $contents) {
          foreach ($contents as $content) {
            if (!empty($content['target_id'])) {
              $output .= "\r" . '    "field_section_view_arguments"=>"' . htmlspecialchars($content['target_id']) . '", ';
            }
          }
        }
      }

      if (!empty($fc->field_section_block)) {
        foreach ($fc->field_section_block as $contents) {
          foreach ($contents as $content) {
            if (!empty($content['value'])) {
              $output .= "\r" . '    "field_section_block"=>"' . htmlspecialchars($content['value']) . '", ';
            }
          }
        }
      }

      $output .= "\r  ),";
    }

    $output .= "\r );";
  //}
}

debug($counts);
debug($output);
foreach($errors as $error) {
  drupal_set_message($error);
}
//print "IDs: " . implode("\n\r", $nids);
print "\r";
print $tally . ' NODES OF TYPE: ' . strtoupper($node_type);
