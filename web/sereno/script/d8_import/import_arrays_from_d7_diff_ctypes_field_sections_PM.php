<?php
$d8_nodes[67] = [
  [
    "field_original_fc_id" => "1083",
    "field_original_fc_revision_id" => "73325",
    "field_original_fc_langcode" => "en",
    "field_section_title" => "About IPU",
    "field_section_display_options" => "2",
    "field_section_view_vname" => "publications|multiple_ids",
    "field_section_view_vargs" => "197",
    "field_section_view_arguments" => "197",
  ],
  [
    "field_original_fc_id" => "1085",
    "field_original_fc_revision_id" => "73326",
    "field_original_fc_langcode" => "fr",
    "field_section_title" => "A propos de l\'UIP",
    "field_section_display_options" => "2",
    "field_section_view_vname" => "publications|multiple_ids",
    "field_section_view_vargs" => "197",
    "field_section_view_arguments" => "197",
  ],
];

use Drupal\paragraphs\Entity\Paragraph;  // Don't forget to use a little Class...
use Drupal\node\Entity\Node;

$counter = 0;
$cleardown = FALSE;

foreach ($d8_nodes as $node_id => $all_new_paragraphs) {

  //$node = Node::load($node_id);
  $node = entity_load('node', $node_id);

  $new_paragraphs = [];
  $fr_paragraphs = [];

  foreach ($all_new_paragraphs as $paragraph) {
    if ($paragraph["field_original_fc_langcode"] == "en"){
      $new_paragraphs[] = $paragraph;
    } else {
      $fr_paragraphs[] = $paragraph;
    }
  }

  if ($cleardown == FALSE) {

    // Add the English one, but add the FR version to the field.
    foreach ($new_paragraphs as $k=>$new_paragraph) {

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
        $ary_view = explode('|', $new_paragraph['field_section_view_vname']);
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

        // Now prcoess translatable fields
        $translation = $paragraph->addTranslation('fr');
        $translation->set('field_section_title', ['value' => htmlspecialchars_decode($fr_paragraphs[$k]['field_section_title'])]);

      }
      //    if ($new_paragraph['field_publication_file']) {
      //      $file = file_load($new_paragraph['field_publication_file']);
      //      $paragraph->set('field_publication_file', $file);
      //    }


      $node->field_sections->appendItem($paragraph);
    }
  }
  else {
    if (isset($node->field_sections)) {
      //print_r($node->field_sections);
      print(" - Cleared sections \n");
      $node->set('field_sections', []); // remove all paras from this node
    }
  }
  $counter++;

  $node->save();
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
