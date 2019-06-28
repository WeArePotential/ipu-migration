/**
 * @file
 * Open ultimenu items with a click rather than the default hover.
 */

(function ($, Drupal, window) {
  Drupal.ultimenuOverrides = Drupal.ultimenuOverrides || {};

  Drupal.behaviors.ultimenuOverrides = {
    attach: function (context) {

      function myFunction(x) {
        if (x.matches) {
          window.addEventListener('click', function(e){
            if (document.getElementsByClassName('ultimenu__flyout')[0].contains(e.target)){
              // Clicked in box
            } else{
              // Clicked outside the box
              $('.ultimenu__flyout').css({
                "visibility":"hidden",
                "opacity":"0",
                "margin-top":"20px",
              });
            }
          });

          $('.ultimenu--mega-menu > li > a.ultimenu__link').click(function (event) {
          // This stops the previous statement so that this click works.
            event.stopPropagation();
            event.preventDefault();

            if ($(this).closest('.ultimenu__item').find('.ultimenu__flyout').css('opacity') == '1') {
              $('.ultimenu__flyout').css({
                "visibility":"hidden",
                "opacity":"0",
                "margin-top":"20px",
              });
            } else{
              // Clears the megamenu if click another link in the menu.
              $('.ultimenu__flyout').css({
                "visibility":"hidden",
                "opacity":"0",
                "margin-top":"20px",
              });

              // Add the CSS to make the megamenu appear.
              $(this).closest('.ultimenu__item').find('.ultimenu__flyout').css({
                "visibility":"visible",
                "opacity":"1",
                "margin-top":"0px",
              });
            }

          });

        }
      }
      var x = window.matchMedia("(min-width: 944px)")
      myFunction(x); // Call listener function at run time
      x.addListener(myFunction); // Attach listener function on state changes

    }
  };
})(jQuery, Drupal, this);