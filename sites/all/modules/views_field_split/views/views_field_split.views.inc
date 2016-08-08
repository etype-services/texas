<?php
/**
* Implements hook_views_plugin()
*/
function views_field_split_views_plugins() {
	$module_path = drupal_get_path('module', 'views_field_split');
	return array(
		'module' => 'views_field_split',
		'style' => array(
			'field_split' => array(
				'title' => t('Fiels split'),
				'handler' => 'views_field_split_plugin_style',
				'path' => $module_path . '/views',
				'theme path' => $module_path . '/theme',
				'theme file' => 'theme.inc',
				'theme' => 'views_field_split_plugin_style',
				'uses row plugin' => TRUE,
        'uses options' => TRUE,
				'uses fields' => TRUE,
        'type' => 'normal',
				'parent' => 'views_plugin_style',
			),
		),
	);
}



