/*jshint esversion: 6 */

import 'popper.js';
import 'bootstrap';

(function ($, Drupal) {

  'use strict';

  Drupal.behaviors.override_dropdown = {
    attach: function (context) {
      /*
      * Only go to the link when dropdown is already open (if the dropdown is a link)
      */
      $('.dropdown > a').click(function(){
        if ($(this).data("click-once") != 'true') {
          $(this).data("click-once", true);
        } else {
          $(this).data("click-once", false);
          location.href = $(this).href;
        }
      });
    }
  };

})(jQuery, Drupal);
