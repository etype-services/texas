<?php

/* admin settings form */
function etype_xml_importer_admin() {

  $form = array();

  /* e_edition settings */
  $form['etype_xml_importer'] = array(
    '#type' => 'fieldset',
    '#title' => t('Olive XML import configuration'),
  );

  $form['etype_xml_importer']['etype_xml_import_file'] = array(
    '#type' => 'textfield',
    '#title' => t('Filename'),
    '#description' => t('Enter the file name or names to import. Separate multiple files with a comma.'),
    '#size' => 55,
    '#default_value' => variable_get('etype_xml_import_file'),
  );

  $form['etype_xml_importer']['etype_xml_cron_schedule'] = array(
    '#type' => 'textfield',
    '#title' => t('Cron Schedule'),
    '#description' => t('Enter a valid cron schedule'),
    '#size' => 55,
    '#default_value' => variable_get('etype_xml_cron_schedule'),
  );

  return system_settings_form($form);
}