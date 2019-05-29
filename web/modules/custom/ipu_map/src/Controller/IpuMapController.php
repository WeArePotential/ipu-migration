<?php

namespace Drupal\ipu_map\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\views\Views;
use Drupal\Core\Render\Markup;


/**
 * Defines HelloController class.
 */
class IpuMapController extends ControllerBase {

  private $title = '';
  private $member = false;
  /**
   * Display the markup.
   *
   * @return array
   *   Return markup array.
   */
  public function content() {
    /* We can obtain the countries infornmation here and pass as js settings.
    * Or we can obtain via ajax once the map is loaded.
    * To take advantage of Drupal caching, we'll load here, although this means
    * there's a lot of data to pass through settings.
    */
    $data = '';
    $view = Views::getView('map_data');
    if (is_object($view)) {
      // json or xml. We choose XML
      $view->setDisplay('data_export_countries_json');
      $view->preExecute();
      $view->execute();
      //$data = simplexml_load_string($view->render()['#markup']);
      $data = $view->render()['#markup'];
    }
    $settings = ['data' => $data];

    $markup = '<div id="ipu_map" class="container">' . $this->t('IPU Map demo') . '<div class="row mapcontainer_un"><div class="col-12 map">MAP</div></div></div>';
    //$markup .= '<div><pre>' . print_r($data, TRUE) . '</pre></div>';

    $content = [
      '#type' => 'markup',
      '#markup' => $markup,
    ];

    $content['#attached']['library'][] = 'ipu_map/ipu_map';
    $content['#attached']['drupalSettings']['ipu_map'] = $settings;
    return $content;
  }

  public function countryContent($iso_code) {

    $country = $this->getCountryTerm($iso_code);
    // TODO: Remove styling and add to css. This will mean we can remove the use of #children
    $flag = '<img style="height: 50px; width: auto; position:absolute; right: 0; top: 0;" src="' . ipu_map_get_flag($iso_code) . '" />';
    $markup = Markup::create($flag);
    $content = ipu_map_get_parline_data($iso_code, $this->getMembershipStatus());
    $markup .= \Drupal::service('renderer')->render($content);

    $content = [
      '#type' => 'markup',
      '#children' => $markup,
      '#title' => $this->title,
    ];
    return $content;
  }

  public function getMembershipStatus() {
    return $this->member;
  }

  public function getCountryTitle( $iso_code) {
    // This will set the breadcrumb and html page title. The content title is set
    // in the #title of the content
    $country = $this->getCountryTerm($iso_code);
    return $this->title;
  }

  private function getCountryTerm( $iso_code) {
    $country = Null;
    $langcode = \Drupal::languageManager()->getCurrentLanguage(\Drupal\Core\Language\LanguageInterface::TYPE_CONTENT)->getId();
    $query = \Drupal::entityQuery('taxonomy_term');
    $tids = $query
      ->condition('field_iso_code.value', $iso_code, '=')
      //->condition(langcode)
      ->condition('status', 1)  // Once we have our conditions specified we use the execute() method to run the query
      ->execute();
    $terms = \Drupal::entityTypeManager()->getStorage('taxonomy_term')->loadMultiple($tids);
    foreach ($terms as $term) {
      if($term->hasTranslation($langcode)) {
        $country = \Drupal::service('entity.repository')
          ->getTranslationFromContext($term, $langcode);
      } else {
        $country = $term; //return title of term
      }
    }
    if ($country) {
      $this->member = $country->field_ipu_member->value;
      $this->title = $country->name->value;
      return $country;
    } else {
      $this->title = 'No country found for '.$iso_code;
    }
  }
}