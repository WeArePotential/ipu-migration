<?php


// paste fr array here



use Drupal\paragraphs\Entity\Paragraph;  // Don't forget to use a little Class...

$counter = 0;

foreach($d8_nodes as $node_id=>$paragraph) {
  //  print "\n $k";
  //  print "\n";
  //  debug($v);

  $node = entity_load('node', $node_id);

  foreach($new_paragraphs as $new_paragraph) {
    // load the existing D8 paragraph from the field collection item_id in above array (from paragraph on this site)
    // create the translation
    // add field content to this translation

  }

  $node->save();
  print("\n - saved node $node_id \n");
  #print_r($new_paragraph);

  // Grab any existing paragraphs from the node, and add this one
  //  $current = $node->get('NODE_FIELD_NAME')->getValue();
  //  $current[] = array(
  //    'target_id' => $paragraph->id(),
  //    'target_revision_id' => $paragraph->getRevisionId(),
  //  );
  //  $node->set('NODE_FIELD_NAME', $current);
  //  $node->save();

}

print("\n - saved $counter paragraphs");
