(function ($) { 

/**
 * Custom summary for the module vertical tab.
 */
Drupal.behaviors.vertical_tabs_uc_chase_paymentechFieldsetSummaries = {
  attach: function (context) {
    // Use the fieldset class to identify the vertical tab element
    $('fieldset#edit-ehc-required-settings', context).drupalSetSummary(function (context) {
      // Depending on the checkbox status, the settings will be customized, so
      // update the summary with the custom setting textfield string or a use a
      // default string.
      if ($('#edit-ehc-required-settings', context).attr('checked')) {
        return Drupal.checkPlain($('#edit-ehc-required-settings', context).val());
      }
      else {
        return Drupal.t('Using default');
      }
    });
  }
};

})(jQuery);
