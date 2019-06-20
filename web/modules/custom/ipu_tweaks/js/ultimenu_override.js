/**
 * @file
 * Open ultimenu items with a click rather than the default hover.
 */

(function ($, Drupal, window) {
  Drupal.ultimenuOverrides = Drupal.ultimenuOverrides || {};

  Drupal.behaviors.ultimenuOverrides = {
    attach: function (context) {

      $(document).click(function () {
        // Clears the mega menu if click anywhere on the site.
        $('.ultimenu__flyout').css({
          "visibility":"hidden",
          "opacity":"0",
          "transform":"translateY(-1000%)",
        })
      });

      $('.ultimenu > li > a.ultimenu__link').click(function (event) {
        // This stops the previous statement so that this click works.
        event.stopPropagation();

        event.preventDefault();

        // Clears the megamenu if click another link in the menu.
        $('.ultimenu__flyout').css({
          "visibility":"hidden",
          "opacity":"0",
          "transform":"translateY(-1000%)",
        });

        // Add the CSS to make the megamenu appear.
        $(this).closest('.ultimenu__item').find('.ultimenu__flyout').css({
          "visibility":"visible",
          "opacity":"1",
          "display":"block",
          "transform":"translateY(0)",
          "margin-top": "0",
          "transition-delay": "0s"
        });
      });

    }
  };
})(jQuery, Drupal, this);