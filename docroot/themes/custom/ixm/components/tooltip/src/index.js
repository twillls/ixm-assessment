import "./scss/tooltip.scss";

// Tooltip from bootstrap.
window.Tooltip = require("bootstrap/js/dist/tooltip");

((Drupal, once) => {
  // Hide tooltips after ajax.
  document.addEventListener("drupal.ajax.success", () => {
    document.querySelectorAll("[data-bs-toggle='tooltip']").forEach((element) => {
      // Dismiss tooltips when Ajax request is completed.
      window.Tooltip.getInstance(element).hide();
    });
  });

  /**
   * Attach the tooltips.
   */
  Drupal.behaviors.bootstrapTooltips = {
    attach(context) {
      if (context.parentNode) {
        context = context.parentNode;
      }
      once("bs-tooltips", '[data-bs-toggle="tooltip"]', context).forEach((element) => {
        if (!element.hasAttribute("role")) {
          element.setAttribute("role", "tooltip");
        }
        return new window.Tooltip(element);
      });
    },
  };
})(Drupal, once);
