<?php


$d8_nodes[8754] = array(
  array(

    "field_ipu_event_sponsor_name"=>"310",
  ),
  array(

    "field_ipu_event_sponsor_name"=>"313",
  ),
);

$d8_nodes[8755] = array(
  array(

    "field_ipu_event_sponsor_name"=>"314",
  ),
  array(

    "field_ipu_event_sponsor_name"=>"313",
  ),
);

$d8_nodes[8764] = array(
  array(

    "field_ipu_event_sponsor_name"=>"310",
  ),
  array(

    "field_ipu_event_sponsor_name"=>"316",
  ),
);

$d8_nodes[8765] = array(
  array(

    "field_ipu_event_sponsor_name"=>"314",
  ),
  array(

    "field_ipu_event_sponsor_name"=>"316",
  ),
);

$d8_nodes[8770] = array(
  array(

    "field_ipu_event_sponsor_name"=>"310",
  ),
  array(

    "field_ipu_event_sponsor_name"=>"311",
  ),
);

$d8_nodes[8771] = array(
  array(

    "field_ipu_event_sponsor_name"=>"310",
  ),
  array(

    "field_ipu_event_sponsor_name"=>"311",
  ),
);

$d8_nodes[9171] = array(
  array(

    "field_ipu_event_sponsor_name"=>"310",
  ),
  array(

    "field_ipu_event_sponsor_name"=>"335",
  ),
);

$d8_nodes[9482] = array(
  array(

    "field_ipu_event_sponsor_name"=>"310",
  ),
  array(

    "field_ipu_event_sponsor_name"=>"322",
  ),
);

$d8_nodes[9483] = array(
  array(

    "field_ipu_event_sponsor_name"=>"314",
  ),
  array(

    "field_ipu_event_sponsor_name"=>"322",
  ),
);

$d8_nodes[9553] = array(
  array(

    "field_ipu_event_sponsor_name"=>"310",
  ),
  array(

    "field_ipu_event_sponsor_name"=>"311",
  ),
);

$d8_nodes[9591] = array(
  array(

    "field_ipu_event_sponsor_name"=>"331",
  ),
);

$d8_nodes[9592] = array(
  array(

    "field_ipu_event_sponsor_name"=>"331",
  ),
);

$d8_nodes[9593] = array(
  array(

    "field_ipu_event_sponsor_name"=>"331",
  ),
);

$d8_nodes[9594] = array(
  array(

    "field_ipu_event_sponsor_name"=>"331",
  ),
);


/******************************/

$paragraph_type = 'ipu_event_sponsors';
$node_field = 'field_ipu_event_sponsors';


use Drupal\paragraphs\Entity\Paragraph;  // Don't forget to use a little Class...
use Drupal\node\Entity\Node;

$counter = 0;

foreach($d8_nodes as $node_id=>$new_paragraphs) {

 #   debug($node_id);
  #  debug($new_paragraphs);


  $node = Node::load($node_id);

    if(empty($node)) {
      print_r("\rcontinuing ... ");
      continue;
    }
    else {
      print_r("\rnode fine ...");
    }

  foreach($new_paragraphs as $new_paragraph) {

     $paragraph = Paragraph::create(['type' => $paragraph_type,]);
//     debug($new_paragraph);
     debug("-------");
  debug($new_paragraph);
     ### TAXONOMY RELATION TEMPLATE
         if (!empty($new_paragraph['field_ipu_event_sponsor_name'])) {
            $paragraph->set('field_ipu_event_sponsor_name', $new_paragraph['field_ipu_event_sponsor_name']);
         }
         else {
           continue; // if no title, don't save...
         }

     ### TEXT TEMPLATE
     //    if (!empty($new_paragraph['field_fc_session_type_title'])) {
     //      $paragraph->set('field_fc_session_type_title', ['value' => htmlspecialchars_decode($new_paragraph['field_fc_session_type_title'])]);
     //    }
     ////    else {
     ////      continue; // if no title, don't save...
     ////    }

     ### BOOLEAN TEMPLATE
     //    if (!empty($new_paragraph['field_fc_session_closed_session'])) {
     //      $paragraph->set('field_fc_session_closed_session', ['value' => $new_paragraph['field_fc_session_closed_session']]);
     //    }
     //    else {
     //      $paragraph->set('field_fc_session_closed_session', ['value' => 0]);
     //    }

     ### LINK TEMPLATE
     //    if (!empty($new_paragraph['field_external_link'])) {
     //      $paragraph->set('field_external_link',
     //        ["uri" => htmlspecialchars_decode($new_paragraph['field_external_link']['uri']),
     //          "title" => htmlspecialchars_decode($new_paragraph['field_external_link']['title']),
     //        ]
     //      );
     //
     //     # debug($new_paragraph['field_related_link']['title']);
     //    }

     //    if (!empty($new_paragraph['field_event_document_description'])) {
     //      $paragraph->set('field_event_document_description', ['value' => htmlspecialchars_decode($new_paragraph['field_event_document_description']),'format'=>'full_html']);
     //    }

     if(!empty($paragraph) && ! is_null($paragraph)) {

       $paragraph->isNew();

       $node->{$node_field}->appendItem($paragraph);

     }
     //    if(!empty($node)) {
     #      $node->set($node_field, []); // remove all paras from this node
     #      $node->save();
     //    }

     $counter++;
  }

  print("\n - saved node $node->id \n");

  $node->save();
}


print("\n - saved $counter paragraphs");
