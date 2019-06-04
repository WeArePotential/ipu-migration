<?php
/**
 * @file
 * Contains \Drupal\ipu_map\Form\IpuCountrySelectForm.
 */
namespace Drupal\ipu_map\Form;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;

class IpuCountrySelectForm extends FormBase {
  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'ipu_map_country_select_form';
  }
  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $options = ['XX'=>t('All parliaments')];
    $country_terms = ipu_map_get_countries();
    $i = 0;
    $language =  \Drupal::languageManager()->getCurrentLanguage()->getId();
    foreach ($country_terms as $country_term) {
      //if ($i++ <2) print_r($country_term->get('field_iso_code')->getValue());
      if ($country_term->hasField('field_iso_code')) {
        if (!$country_term->get('field_iso_code')->isEmpty()) {
          $iso_code = $country_term->get('field_iso_code')
            ->getValue()[0]['value'];
          if ($language != 'en') {
            $translated_term = \Drupal::service('entity.repository')->getTranslationFromContext($country_term, $language);
            $options[$iso_code] = $translated_term->getName();
          } else {
            $options[$iso_code] = $country_term->getName();
          }
        } else {
          // TODO: Decide what to do with countries which have no ISO code
          // $options[$i++] = $country_term->getName();
        }
      }
    }

    $form['isocode'] = array(
      '#type' => 'select',
      '#options'=> $options,
      '#attributes' => array('class' => array('ipu-country-select')), // Add a class if required
      '#title' => t('Parliament'),
      '#chosen' => TRUE,
      '#required' => FALSE,
    );
    $form['actions']['submit'] = array(
      '#type' => 'submit',
      '#value' => t('Go'),
      '#button_type' => 'primary',
    );
    return $form;
  }
  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $isocode = $form_state->getValue('isocode');
    if ($isocode) {
      if ($isocode == 'XX') {
        $path = '/parliament';
      } else {
        $path = '/parliament/'.$isocode;
      }
    } else {
      $path = '/parliament';
    }
    $response = new RedirectResponse($path);
    $response->send();
    return;
    //drupal_set_message($this->t('@emp_name ,Your application is being submitted!', array('@emp_name' => $form_state->getValue('employee_name'))));
  }
}