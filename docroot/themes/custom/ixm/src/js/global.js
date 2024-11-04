((Drupal, drupalSettings, once) => {
  /**
   * Core/Misc behaviours.
   */
  Drupal.behaviors.ixmMisc = {
    attach: function attach(context, settings) {
      once("example", ".example", context).forEach(() => {
        settings.example = true;
      });
    },
  };
})(Drupal, drupalSettings, once);
