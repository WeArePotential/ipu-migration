<?php
ini_set("memory_limit",-1);
use Drupal\paragraphs\Entity\Paragraph;  // Don't forget to use a little Class...
$tally = 0;

// Get all paragraphs of type ipu_event_document
// and build an array of $pid and field_original_fc_id
$fc_to_para_mapping = array();
$pids = \Drupal::entityQuery('paragraph')
  //->condition('id', 14190)
  ->condition('type', 'ipu_event_document')
  ->execute();
$paragraphs = entity_load_multiple('paragraph', $pids, TRUE);
foreach ($paragraphs as $pid=>$paragraph) {
  $paras = $paragraph->toArray();
  $pid = $paras['id'][0]['value'];
  foreach($paras as $y=>$field_original_fc_ids) {
    if ($y == "field_original_fc_id") {
      //print "$y:\n". print_r($field_original_fc_ids, true)."\n";
      foreach ($field_original_fc_ids as $target_fc_id) {
        $fc_to_para_mapping[$target_fc_id['value']] = $pid;
      }
    }
  }
}
print("We have ".count($fc_to_para_mapping)." mappings\n");
//print_r($fc_to_para_mapping);


// Get all paragraphs of type ipu_event_document_widget
$pids = \Drupal::entityQuery('paragraph')
  ->condition('type', 'ipu_event_document_widget')
  ->execute();

print ("Found ".count($pids)." paragraphs\n");
foreach ($pids as $pid) {
  //print ("$key:\n");
  //print_r($pid, true);
}
//$pids = array(15373);
$paragraphs = entity_load_multiple('paragraph', $pids, TRUE);
foreach ($paragraphs as $pid => $paragraph) {
  print ("Process $pid:\n");
  //
  //debug($paragraph->field_fc_original_reference);

  $paras = $paragraph->toArray();
  $update = FALSE;
  foreach ($paras as $y => $fc_original_references) {
    if ($y == "field_fc_original_reference") {
      print "$y:\n" . print_r($fc_original_references, TRUE) . "\n";
      foreach ($fc_original_references as $target_fc_id) {
        // Find para with this fc id
        $new_pid = $fc_to_para_mapping[$target_fc_id['value']];
        print "New ref: " . print_r($new_pid, TRUE) . "\n";
        $match = FALSE;
        foreach ($paras['field_ipu_event_document'] as $ref) {
          if ($ref['target_id'] == $new_pid) {
            $match = TRUE;
          }
        }
        if ($match == FALSE) {
          $p = Paragraph::load($new_pid);
          $paragraph->field_ipu_event_document[] = $p;
          $update = TRUE;
        } else {
          print "Ref exists\n";
        }
      }
    }
  }
  if ($update) {
    $tally++;
    $paragraph->save();
  }

}

print("\n - Updsted $tally paragraphs");





