<?php
$d8_nodes[67] = array(
  array(
    "field_original_fc_id"=>"85",
    "field_original_fc_revision_id"=>"73313",
    "field_original_fc_langcode"=>"en",
    "field_node"=>"68",
  ),
  array(
    "field_original_fc_id"=>"331",
    "field_original_fc_revision_id"=>"73314",
    "field_original_fc_langcode"=>"en",
    "field_node"=>"69",
  ),
  array(
    "field_original_fc_id"=>"332",
    "field_original_fc_revision_id"=>"73315",
    "field_original_fc_langcode"=>"en",
    "field_node"=>"70",
  ),
  array(
    "field_original_fc_id"=>"85",
    "field_original_fc_revision_id"=>"73316",
    "field_original_fc_langcode"=>"fr",
    "field_node"=>"68",
  ),
  array(
    "field_original_fc_id"=>"331",
    "field_original_fc_revision_id"=>"73317",
    "field_original_fc_langcode"=>"fr",
    "field_node"=>"69",
  ),
  array(
    "field_original_fc_id"=>"332",
    "field_original_fc_revision_id"=>"73318",
    "field_original_fc_langcode"=>"fr",
    "field_node"=>"70",
  ),
);



use Drupal\paragraphs\Entity\Paragraph;  // Don't forget to use a little Class...

$counter = 0;

foreach ($d8_nodes as $node_id => $new_paragraphs) {
  //  print "\n $k";
  //  print "\n";
  //  debug($v);

  //$node = entity_load('node', $node_id);

  /*
   * foreach($new_paragraphs as $new_paragraph) {
    $paragraph = Paragraph::create(['type' => 'sections',]);

    if (!empty($new_paragraph['field_section_description'])) {
      $paragraph->set('field_section_description', ['value' => htmlspecialchars_decode($new_paragraph['field_section_description'])]);
    }

    if (!empty($new_paragraph['field_section_display_options'])) {
      $paragraph->set('field_section_display_options', [['value' => htmlspecialchars_decode($new_paragraph['field_section_display_options'])]]);
    }

    if (!empty($new_paragraph['field_section_html'])) {
      $paragraph->set('field_section_html', ['value' => htmlspecialchars_decode($new_paragraph['field_section_html'])]);
    }

    if (!empty($new_paragraph['field_section_node'])) {
      $paragraph->set('field_section_node', ['target_id' => htmlspecialchars_decode($new_paragraph['field_section_node'])]);
    }

    if (!empty($new_paragraph['field_section_title'])) {
      $paragraph->set('field_section_title', ['value' => htmlspecialchars_decode($new_paragraph['field_section_title'])]);
    }

    if (!empty($new_paragraph['field_section_view_vname'])) {

//    "field_section_view_vname"=>"documents|multiple_ids",
//    "field_section_view_vargs"=>"49,286",

      // break up the vname into view name and display
      $ary_view = explode('|',$new_paragraph['field_section_view_vname']);
      $view_name = $ary_view[0];
      $view_display = $ary_view[1];

      $paragraph->set('field_view', [
        'target_id' => $view_name,
        'display_id' => $view_display,
        'view_arguments' => $new_paragraph['field_section_view_vargs'],
      ]);

      // save to the raw text fields, too
      if (!empty($view_name)) {
        $paragraph->set('field_view_target_id', ['value' => $view_name]);
      }

      if (!empty($view_display)) {
        $paragraph->set('field_view_display_id', ['value' => $view_display]);
      }

      if (!empty($new_paragraph['field_section_view_vargs'])) {
        $paragraph->set('field_view_arguments', ['value' => $new_paragraph['field_section_view_vargs']]);
      }
      #field_view_target_id
      #field_view_display_id
      #field_view_arguments


    }
//    if ($new_paragraph['field_publication_file']) {
//      $file = file_load($new_paragraph['field_publication_file']);
//      $paragraph->set('field_publication_file', $file);
//    }


    $node->field_sections->appendItem($paragraph);
    */

  //$node->set('field_sections', []); // remove all paras from this node
  $counter++;

  //$node->save();
  print("\n - saved node $node_id \n");
  //print_r($new_paragraph);

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
