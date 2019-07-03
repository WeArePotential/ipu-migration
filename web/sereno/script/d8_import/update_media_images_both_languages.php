<?php
use Drupal\image\Entity\ImageStyle;
use Drupal\Core\Mail\MailFormatHelper;
ini_set("memory_limit",-1);
$tally = 0;
$content_types = ['basic_page', 'page', 'article', 'section_page'];

$nids = \Drupal::entityQuery('node')
  //->condition('nid', 9779)
  ->condition('type',  $content_types, 'IN')
  ->execute();
$nodes = entity_load_multiple('node', $nids, TRUE);
foreach ($nodes as $nid=>$node) {
  print "Process node: $nid\n";
  $image = $node->get('field_media_image')->getValue();
  //$caption = $node->get('field_caption')->getValue();
  //print ('Image: '.print_r($image,true)."\n")  ;
  if (!empty($image)) {
    //print ('Image: '.$image[0]['target_id']."\n");
  } else {
    print ('No EN image'."\n");
    if ($node->hasTranslation('fr')) {
      $tn = $node->getTranslation('fr');
    } else {
      $tn = NULL;
    }
    if (!empty($tn)) {
      $image = $tn->get('field_media_image')->getValue();
      if (!empty($image)) {
        //print ('Image: ' . $image[0]['target_id']."\n");
        //print (ImageStyle::load('large')->buildUrl($tn->get('field_media_image')->entity->getFileUri()));
        if ($tn->hasField('field_caption')) {
          $caption_fr = $tn->get('field_caption')->getValue();
          $alt = MailFormatHelper::htmlToText($caption_fr[0]['value']);
        } else {
          $alt = '';
        }
        /*
         * CAPTION EDITING - Missing English captions postponed
         *
        print_r ($caption_fr[0]['value']);
        if ($caption[0]['value'] == '' && $caption_fr != '') {
          $node->set('field_caption', $caption_fr);
        }
        */


        // Update the
        $node->set('field_media_image', $image[0]['target_id']);
        //print $alt;
        if ($alt != '') {
          $tn->field_media_image->alt = $alt;
        }

        //$node->set('field_media_image->target_id'=> $image[0]['target_id'];
        $node->save();
      } else {
        print ('No FR image'."\n");
      }
    }
  }

 //   $entity = Media::load($image[0]['target_id']);

  //  foreach($images as $key=>$val) {
  //  print $key. ": ".  "\n";
  //}
}
//print("We have ".count($fc_to_para_mapping)." mappings\n");
//print_r($fc_to_para_mapping);


// Get all paragraphs of type ipu_event_document_widget
/*$pids = \Drupal::entityQuery('paragraph')
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
*/




