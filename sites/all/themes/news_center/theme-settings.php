<?php
/**
 * Implements hook_form_system_theme_settings_alter().
 *
 * @param $form
 *   Nested array of form elements that comprise the form.
 * @param $form_state
 *   A keyed array containing the current state of the form.
 */
function news_center_form_system_theme_settings_alter(&$form, &$form_state) {

    // Create the form using Forms API: http://api.drupal.org/api/7

    $form['misc_settings'] = array(
        '#type' => 'fieldset',
        '#title' => t('eType Settings'),
        '#collapsible' => TRUE,
        '#collapsed' => FALSE,
    );

    $form['misc_settings']['nav_color'] = array(
        '#type' => 'textfield',
        '#title' => t('Navigation Color'),
        '#size' => 20,
        '#default_value' => theme_get_setting('nav_color'),
    );

    $form['misc_settings']['body_background'] = array(
        '#type' => 'textfield',
        '#title' => t('Body Background'),
        '#size' => 20,
        '#default_value' => theme_get_setting('body_background'),
    );

    // Remove some of the base theme's settings.
    unset($form['themedev']['zen_layout']); // We don't need to select the layout stylesheet.

    // We are editing the $form in place, so we don't need to return anything.
}
