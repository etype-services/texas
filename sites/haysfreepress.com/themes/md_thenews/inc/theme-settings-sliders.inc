<?php

/**
 * @file
 * Theme settings .
 */

function md_thenews_theme_settings_sliders(&$form, &$form_state) {
	$form['md_thenews_settings']['sliders'] = array(
		'#type' 					=> 'fieldset',
		'#weight' 				=> -1,
		'#prefix'  				=> '<div id="md-sliders" class="md-tabcontent clearfix">',
		'#suffix'        => '</div><!-- / #md-sliders -->',
	);
	
	$form['md_thenews_settings']['sliders']['sliders_htmllist'] = array(
		'#markup' 				=> '<div class="md-listleft">
				<ul>
					<li><a href="#sl-cycle">Cycle Slider</a></li>
				</ul>
			</div><div class="md-listcontent">',
		'#weight' 				=> -15,
	);
	
	$form['md_thenews_settings']['sliders']['sliders_htmllistclose'] = array(
		'#markup' 				=> '</div><!-- /.md-listleft -->',
		'#weight' 				=> 15,
	);
	
	/* Cycle Slider
	--------------------------------------------------------------------------*/
	$form['md_thenews_settings']['sliders']['slider_cycle'] = array(
		'#type' 					=> 'fieldset',
		'#weight' 				=> -5,
		'#prefix'  				=> '<div id="sl-cycle" class="md-tabcontent clearfix">',
		'#suffix'        => '</div><!-- / #sl-cycle -->',
	);
	
		$form['md_thenews_settings']['sliders']['slider_cycle']['featured_timeout'] = array(
			'#type' 					=> 'textfield',
			'#title'					=> t('Timeout'),
			'#default_value' 	=>  theme_get_setting('featured_timeout')? theme_get_setting('featured_timeout') : 8000,
			'#field_suffix' => 'milliseconds',
			'#prefix'					=> '<h3>' . t('Featured content') . '</h3>',
		);
		
		$form['md_thenews_settings']['sliders']['slider_cycle']['headlines_pager'] = array(
			'#type' 					=> 'textfield',
			'#title'					=> t('Number items to show per page'),
			'#default_value' 	=>  theme_get_setting('headlines_pager')? theme_get_setting('headlines_pager') : 5,
			'#prefix'					=> '<h3>' . t('Headlines') . '</h3>',
		);
		
		$form['md_thenews_settings']['sliders']['slider_cycle']['ep_timeout'] = array(
			'#type' 					=> 'textfield',
			'#title'					=> t('Timeout'),
			'#default_value' 	=>  theme_get_setting('ep_timeout')? theme_get_setting('ep_timeout') : 8000,
			'#field_suffix' => 'milliseconds',
			'#prefix'					=> '<h3>' . t('Editor\'s pick') . '</h3>',
		);
		
		$form['md_thenews_settings']['sliders']['slider_cycle']['ep_visible'] = array(
			'#type' 					=> 'textfield',
			'#title'					=> t('Carousel visible'),
			'#default_value' 	=>  theme_get_setting('ep_visible')? theme_get_setting('ep_visible') : 5,
		);
		
		$form['md_thenews_settings']['sliders']['slider_cycle']['pg_timeout'] = array(
			'#type' 					=> 'textfield',
			'#title'					=> t('Timeout'),
			'#default_value' 	=>  theme_get_setting('pg_timeout')? theme_get_setting('pg_timeout') : 8000,
			'#field_suffix' => 'milliseconds',
			'#prefix'					=> '<h3>' . t('Photo gallery') . '</h3>',
		);
		
		$form['md_thenews_settings']['sliders']['slider_cycle']['pg_visible'] = array(
			'#type' 					=> 'textfield',
			'#title'					=> t('Carousel visible'),
			'#default_value' 	=>  theme_get_setting('pg_visible')? theme_get_setting('pg_visible') : 4,
		);
}