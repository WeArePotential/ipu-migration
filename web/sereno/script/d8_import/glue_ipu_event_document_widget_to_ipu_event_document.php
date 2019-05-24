<?php


use Drupal\paragraphs\Entity\Paragraph;  // Don't forget to use a little Class...

// load all paragraphs of type
$pids = \Drupal::entityQuery('paragraph')->condition('type','ipu_event_document_widget')->execute();
$paragraphs =  Paragraph::loadMultiple($pids);

$tally = 0;

// loop through each paragraph of given type
foreach($paragraphs as $paragraph) {

  // the id of this paragraph
  $pid = $paragraph->id();

  echo $pid . " <- parent pid \n\r";


  // the fc ids that we need to use as a basis for converting to the D8
  // paragraph ids
  $fc_foreign_keys = $paragraph->get('field_fc_original_reference')->getValue();

  foreach ($fc_foreign_keys as $fc_foreign_key) {
    echo " - " . $fc_foreign_key['value'] . " <- foreign key \n\r";
    // the D7 references to fc ids
    $fc_foreign_key_id = trim($fc_foreign_key['value']);

    echo " - " . $fc_foreign_key_id . " <- fc_foreign_key_id var \n\r";

    // find all the paragraphs with the D7 fc id that matches those in the parent
    // references
    $fc_foreign_ids = \Drupal::entityQuery('paragraph')
      ->condition('field_original_fc_id', $fc_foreign_key_id)
      ->execute();

    #debug($fc_foreign_ids);

    $foreign_paragraphs =  Paragraph::loadMultiple($fc_foreign_ids);

    foreach ($foreign_paragraphs as $foreign_paragraph) {
      echo '    -> foreign found ';
      echo $foreign_paragraph->id();
      echo "\n\r";

      // collect all the paragraph ids in the 'child' that we'll need to link
      // to in the parent...
      if(!empty($foreign_paragraph->id())) {
        echo "\n\r ADDING ITEM TO field_ipu_event_document " . $foreign_paragraph->id() . "\n\r";
        $target_id = $foreign_paragraph->id();
        $p = Paragraph::load( $target_id );
        $paragraph->field_ipu_event_document[] = $p;
      }
    }
  }

  #   field_fc_original_reference - maps to field_ipu_event_document
  # 	field_fc_original_event_document - maps to field_ipu_event_document_r

  $tally++;

  #debug($paragraph->field_ipu_event_document);

  // EMPTY THE RELATIONSHIP
  #$paragraph->field_ipu_event_document = array();

  // save
  $paragraph->save();
}

print("\n - updated $tally paragraphs");

//function getParagraphIdFromOriginalFcId($original_fc_id) {
//
//  $para_storage = \Drupal::entityTypeManager()->getStorage('paragraph');
//  $query = \Drupal::entityQuery('paragraph')
//  ->condition('field_original_fc_id', $original_fc_id);
//  $pids = $query->execute();
//  $paragraphs = $para_storage->loadMultiple($pids);
//
//  print("\rORIGINAL: $original_fc_id");
//
//  foreach ($paragraphs as $p) {
//    print( "\r PARAGRAPH ID: ".$p->id());            // "Lorem Ipsum..."
//  }
//}



