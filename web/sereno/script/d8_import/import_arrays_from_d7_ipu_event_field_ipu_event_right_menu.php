<?php


$d8_nodes[8732] = array(
  array(

    "field_ipu_event_section_title"=>"Website of the host parliament",
    "field_ipu_event_button"=>array(
      array(
        "uri"=>"https://ipu137russia.org/",
        "title"=>"Website",
      ),
    ),
  ),
  array(

    "field_ipu_event_section_title"=>"Translation under the responsibility of the GRULAC Secretariat",
    "field_ipu_event_button"=>array(
      array(
        "uri"=>"http://www.secretariagrulacuip.org/web/",
        "title"=>"DOCUMENTOS EN ESPAÑOL",
      ),
    ),
  ),
);

$d8_nodes[8762] = array(
  array(

    "field_ipu_event_button"=>array(
      array(
        "uri"=>"http://www.surveygizmo.eu/s3/90072706/IPU/",
        "title"=>"Delegates\' Survey",
      ),
      array(
        "uri"=>"https://www.ipu.org/sites/default/files/documents/138_geneva-assembly-e_0.pdf",
        "title"=>"Assembly Guidebook",
      ),
      array(
        "uri"=>"https://www.ipu.org/sites/default/files/documents/convocation-consolidated-a.pdf",
        "title"=>"Convocation",
      ),
    ),
  ),
);

$d8_nodes[8763] = array(
  array(

    "field_ipu_event_button"=>array(
      array(
        "uri"=>"http://www.surveygizmo.eu/s3/90072706/IPU/",
        "title"=>"Enquête auprès des délégués",
      ),
      array(
        "uri"=>"https://www.ipu.org/sites/default/files/documents/138-geneve-assemblee-f_0.pdf",
        "title"=>"Guide de l\'Assemblée",
      ),
      array(
        "uri"=>"https://www.ipu.org/sites/default/files/documents/convocation-consolidated-f.pdf",
        "title"=>"Convocation",
      ),
    ),
  ),
);

$d8_nodes[9157] = array(
  array(

    "field_ipu_event_button"=>array(
      array(
        "uri"=>"https://events.crowdcompass.com/events/lD21FkiMlj/download",
        "title"=>"Download the App",
      ),
      array(
        "uri"=>"https://www.ipu.org/sites/default/files/documents/assemblies_in_your_pocket-en-lowres.pdf",
        "title"=>"Download IPU Assemblies in your Pocket",
      ),
      array(
        "uri"=>"https://www.ipu.org/download/5483",
        "title"=>"Download the 139th IPU Assembly Guidebook",
      ),
    ),
  ),
);

$d8_nodes[9166] = array(
  array(

  ),
);

$d8_nodes[9172] = array(
  array(

    "field_ipu_event_button"=>array(
      array(
        "uri"=>"http://w3.ipu.org/registration/index.php/admin/140/home",
        "title"=>"Register now!",
      ),
    ),
  ),
);

$d8_nodes[9173] = array(
  array(

    "field_ipu_event_button"=>array(
      array(
        "uri"=>"http://w3.ipu.org/registration/index.php/admin/140/home",
        "title"=>"Inscrivez-vous !",
      ),
    ),
  ),
);

$d8_nodes[9179] = array(
  array(

  ),
);

$d8_nodes[9188] = array(
  array(

    "field_ipu_event_button"=>array(
      array(
        "uri"=>"https://crowd.cc/s/208e8",
        "title"=>"Téléchargez l\'application",
      ),
      array(
        "uri"=>"https://www.ipu.org/sites/default/files/documents/assemblies_in_your_pocket-fr-lowres.pdf",
        "title"=>"Téléchargez L’Assemblée de l’UIP en poche",
      ),
      array(
        "uri"=>"https://www.ipu.org/download/5489",
        "title"=>"Téléchargez le Guide à la 139ème Assemblée ",
      ),
    ),
  ),
);

$d8_nodes[9591] = array(
  array(

    "field_ipu_event_button"=>array(
      array(
        "uri"=>"https://www.eventbrite.com/e/vital-voices-and-partnerships-in-sustaining-peace-geneva-peace-week-tickets-50527107940",
        "title"=>"Register!",
      ),
    ),
  ),
);

$d8_nodes[9592] = array(
  array(

    "field_ipu_event_button"=>array(
      array(
        "uri"=>"https://www.eventbrite.com/e/vital-voices-and-partnerships-in-sustaining-peace-geneva-peace-week-tickets-50527107940",
        "title"=>"Inscrivez-vous !",
      ),
    ),
  ),
);

$d8_nodes[9593] = array(
  array(

    "field_ipu_event_button"=>array(
      array(
        "uri"=>"https://www.eventbrite.com/e/inter-faith-dialogue-for-conflict-prevention-resolution-geneva-peace-week-tickets-50528767905",
        "title"=>"Register! ",
      ),
    ),
  ),
);

$d8_nodes[9594] = array(
  array(

    "field_ipu_event_button"=>array(
      array(
        "uri"=>"https://www.eventbrite.com/e/inter-faith-dialogue-for-conflict-prevention-resolution-geneva-peace-week-tickets-50528767905",
        "title"=>"Incrivez-vous !",
      ),
    ),
  ),
);

$d8_nodes[9604] = array(
  array(

    "field_ipu_event_button"=>array(
      array(
        "uri"=>"http://graduateinstitute.ch/home/research/centresandprogrammes/hirschman-centre-on-democracy/events-1/past-events.html/_/events/hirschman-centre-on-democracy/2018/the-new-wave-of-populism-in-the",
        "title"=>"Register!",
      ),
    ),
  ),
);

$d8_nodes[9606] = array(
  array(

    "field_ipu_event_button"=>array(
      array(
        "uri"=>"http://graduateinstitute.ch/fr/home/research/centresandprogrammes/hirschman-centre-on-democracy/events-1/past-events.html/_/events/hirschman-centre-on-democracy/2018/the-new-wave-of-populism-in-the",
        "title"=>"Inscrivez-vous !",
      ),
    ),
  ),
);


/******************************/

$paragraph_type = 'ipu_event_right_menu';
$node_field = 'field_ipu_event_right_menu';


use Drupal\paragraphs\Entity\Paragraph;  // Don't forget to use a little Class...
use Drupal\node\Entity\Node;


$counter = 0;

foreach($d8_nodes as $node_id=>$new_paragraphs) {

  #   debug($node_id);
  #  debug($new_paragraphs);

  $node = Node::load($node_id);

  if(empty($node)) {
    debug(" - no node " . $node_id);
    continue;
  }

  foreach($new_paragraphs as $new_paragraph) {
    $ary_button = array();
    $paragraph = Paragraph::create(['type' => $paragraph_type,]);

    if (!empty($new_paragraph['field_ipu_event_section_title'])) {
      $paragraph->set('field_ipu_event_section_title', ['value' => htmlspecialchars_decode($new_paragraph['field_ipu_event_section_title'])]);
    }

    ### LINK TEMPLATE
    $ary_buttons = array();
    if (!empty($new_paragraph['field_ipu_event_button'])) {
      foreach ($new_paragraph['field_ipu_event_button'] as $button) {
        $ary_buttons[] = array(
            "uri" => htmlspecialchars_decode($button['uri']),
            "title" => htmlspecialchars_decode($button['title']),
        );
      }
      $paragraph->set('field_ipu_event_button', $ary_buttons);
      #debug($ary_buttons);
    }


    if(!empty($paragraph) && ! is_null($paragraph)) {

      $paragraph->isNew();

      $node->{$node_field}->appendItem($paragraph);
      #$node->set($node_field, []); // remove all paras from this node
    }

    $counter++;
  }

  print("\n - saved node $node->id \n");
  #print_r($new_paragraph);

 $node->save();

}

print("\n - saved $counter paragraphs");



     ### TAXONOMY RELATION TEMPLATE
//         if (!empty($new_paragraph['field_ipu_event_sponsor_name'])) {
//            $paragraph->set('field_ipu_event_sponsor_name', $new_paragraph['field_ipu_event_sponsor_name']);
//         }
//         else {
//           continue; // if no title, don't save...
//         }

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

    ### LONG TEXT TEMPLATE
     //    if (!empty($new_paragraph['field_event_document_description'])) {
     //      $paragraph->set('field_event_document_description', ['value' => htmlspecialchars_decode($new_paragraph['field_event_document_description']),'format'=>'full_html']);
     //    }
