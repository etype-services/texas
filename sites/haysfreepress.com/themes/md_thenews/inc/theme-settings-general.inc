<?php

/**
 * @file
 * Theme settings general.
 */

function md_thenews_theme_settings_generalsettings(&$form, &$form_state) {
	
	$form['favicon']['#collapsible'] = FALSE;
	
	$form['md_thenews_settings']['general'] = array(
		'#type' 					=> 'fieldset',
		'#weight' 				=> -5,
		'#prefix'  				=> '<div id="md-general-settings" class="md-tabcontent clearfix">',
		'#suffix'        	=> '</div><!-- / #md-general-settings -->',
	);
	
	$form['md_thenews_settings']['general']['general_htmllist'] = array(
		'#markup' 				=> '<div class="md-listleft">
				<ul>
					<li><a href="#general-settings">Settings</a></li>
					<li><a href="#favicon-webclip">Logo, Favicon &amp; Webclip</a></li>
					<li><a href="#social-media">Social Media Promotion</a></li>
					<li><a href="#custom-font">Custom Font</a></li>
				</ul>
			</div><div class="md-listcontent">',
		'#weight' 				=> -15,
	);
	$form['md_thenews_settings']['general']['general_htmllistclose'] = array(
		'#markup' 				=> '</div><!-- /.md-listleft -->',
		'#weight' 				=> 15,
	);
	
	
	/* 1.	General Settings
	--------------------------------------------------------------------------*/
	$form['md_thenews_settings']['general']['general_settings'] = array(
		'#type' 					=> 'fieldset',
		'#weight' 				=> -5,
		'#prefix'  				=> '<div id="general-settings" class="md-tabcontent clearfix">',
		'#suffix'        => '</div><!-- / #general-settings -->',
	);
	
		$form['md_thenews_settings']['general']['general_settings']['css3_textarea'] = array(
			'#type' => 'checkbox',
			'#title' =>  t('Use the "resize" CSS3 property'),
			'#description'   => t('Check this if you wish to replace Drupal\'s textarea by resize CSS3 property'),
			'#default_value' => theme_get_setting('css3_textarea'),
		);
		
		$form['md_thenews_settings']['general']['general_settings']['responsive'] = array(
			'#type' => 'checkbox',
			'#title' =>  t('Enable responsive'),
			'#default_value' => theme_get_setting('responsive'),
		);
		
		//Breadcrumb settings
		$form['md_thenews_settings']['general']['general_settings']['breadcrumb_settings'] = array(
			'#type'          => 'fieldset',
			'#title'         => t('Breadcrumb settings'),
		);
		$form['md_thenews_settings']['general']['general_settings']['breadcrumb_settings']['breadcrumb_display'] = array(
			'#type'          => 'select',
			'#title'         => t('Display breadcrumb'),
			'#default_value' => theme_get_setting('breadcrumb_display'),
			'#options'       => array(
														'yes'   => t('Yes'),
														'admin' => t('Only in admin section'),
														'no'    => t('No'),
													),
		);
		$form['md_thenews_settings']['general']['general_settings']['breadcrumb_settings']['breadcrumb_separator'] = array(
			'#type'          => 'textfield',
			'#title'         => t('Breadcrumb separator'),
			'#description'   => t('Text only. Don\'t forget to include spaces.'),
			'#default_value' => theme_get_setting('breadcrumb_separator'),
			'#size'          => 5,
			'#maxlength'     => 10,
			'#prefix'        => '<div id="div-breadcrumb-collapse">', // jquery hook to show/hide optional widgets
		);
		$form['md_thenews_settings']['general']['general_settings']['breadcrumb_settings']['breadcrumb_home'] = array(
			'#type'          => 'checkbox',
			'#title'         => t('Show home page link in breadcrumb'),
			'#default_value' => theme_get_setting('breadcrumb_home'),
		);
		$form['md_thenews_settings']['general']['general_settings']['breadcrumb_settings']['breadcrumb_trailing'] = array(
			'#type'          => 'checkbox',
			'#title'         => t('Append a separator to the end of the breadcrumb'),
			'#default_value' => theme_get_setting('breadcrumb_trailing'),
			'#description'   => t('Useful when the breadcrumb is placed just before the title.'),
		);
		$form['md_thenews_settings']['general']['general_settings']['breadcrumb_settings']['breadcrumb_title'] = array(
			'#type'          => 'checkbox',
			'#title'         => t('Append the content title to the end of the breadcrumb'),
			'#default_value' => theme_get_setting('breadcrumb_title'),
			'#description'   => t('Useful when the breadcrumb is not placed just before the title.'),
			'#suffix'        => '</div>', // #div-breadcrumb-collapse
		);
		
		// Search Settings
		if (module_exists('search')) {
			$form['md_thenews_settings']['general']['general_settings']['search_container'] = array(
				'#type' => 'fieldset',
				'#title' => t('Search results'),
				'#description' => t('What additional information should be displayed on your search results page?'),
			);
			$form['md_thenews_settings']['general']['general_settings']['search_container']['search_results']['search_snippet'] = array(
				'#type' => 'checkbox',
				'#title' => t('Display text snippet'),
				'#default_value' => theme_get_setting('search_snippet'),
			);
			$form['md_thenews_settings']['general']['general_settings']['search_container']['search_results']['search_info_type'] = array(
				'#type' => 'checkbox',
				'#title' => t('Display content type'),
				'#default_value' => theme_get_setting('search_info_type'),
			);
			$form['md_thenews_settings']['general']['general_settings']['search_container']['search_results']['search_info_user'] = array(
				'#type' => 'checkbox',
				'#title' => t('Display author name'),
				'#default_value' => theme_get_setting('search_info_user'),
			);
			$form['md_thenews_settings']['general']['general_settings']['search_container']['search_results']['search_info_date'] = array(
				'#type' => 'checkbox',
				'#title' => t('Display posted date'),
				'#default_value' => theme_get_setting('search_info_date'),
			);
			$form['md_thenews_settings']['general']['general_settings']['search_container']['search_results']['search_info_comment'] = array(
				'#type' => 'checkbox',
				'#title' => t('Display comment count'),
				'#default_value' => theme_get_setting('search_info_comment'),
			);
			$form['md_thenews_settings']['general']['general_settings']['search_container']['search_results']['search_info_upload'] = array(
				'#type' => 'checkbox',
				'#title' => t('Display attachment count'),
				'#default_value' => theme_get_setting('search_info_upload'),
			);
		}
	
	/* 2.	Logo, Favicon & Webclip
	--------------------------------------------------------------------------*/
	$form['md_thenews_settings']['general']['favicon_webclip'] = array(
		'#type' 					=> 'fieldset',
		'#weight' 				=> -5,
		'#prefix'  				=> '<div id="favicon-webclip" class="md-tabcontent clearfix">',
		'#suffix'        => '</div><!-- / #favicon-webclip -->',
	);
	
		$webclip_path = theme_get_setting('webclip_path');
		if (file_uri_scheme($webclip_path) == 'public') {
			$webclip_path = file_uri_target($webclip_path);
		}
		 
		$form['md_thenews_settings']['general']['favicon_webclip']['webclip_path'] = array(
			'#type' 					=> 'textfield',
			'#title'					=> t('Path to custom Webclip'),
			'#description'   	=> t('A webclip is the icon that appears on a user\'s iPhone, iPad or Android device if they save your website to their home screen.<br />Upload an image at least <em>114x114px</em>'),
			'#default_value' 	=>  $webclip_path,
			'#prefix'					=> '<h3>Web Clip Settings</h3>',
		);
		
		$form['md_thenews_settings']['general']['favicon_webclip']['webclip_upload'] = array(
			'#type' => 'file',
		);
		
		$form['md_thenews_settings']['general']['favicon_webclip']['webclip_precomp'] = array(
	    '#type' => 'checkbox',
	    '#title' => t('Use the default precomposed iOS touch icon.'),
	    '#default_value' => theme_get_setting('default_touch_icon_precomp'),
	    '#tree' => FALSE,
	    '#description' => t('Using a &apos;precomposed&apos; touch icon allows more control over the icon&apos;s appearance. iOS devices do not apply any special effects to these icons.'),
	  );
	
	/* 3.	Social Media Promotion
	--------------------------------------------------------------------------*/
	$form['md_thenews_settings']['general']['social_media'] = array(
		'#type' 					=> 'fieldset',
		'#weight' 				=> -5,
		'#prefix'  				=> '<div id="social-media" class="md-tabcontent clearfix">',
		'#suffix'        	=> '</div><!-- / #social-media -->',
	);
	
		// Get tweet
		$form['md_thenews_settings']['general']['social_media']['twitter_user'] = array(
			'#type'         	=> 'textfield',
			'#title'					=> 'Twitter username',
			'#description'   	=> t('Enter your twitter user name here'),
			'#default_value' 	=> theme_get_setting('twitter_user'),
			'#prefix'         => '<h3>'.t('Twitter block config').'</h3>',
		);
		
		$form['md_thenews_settings']['general']['social_media']['twitter_num'] = array(
			'#type'          => 'textfield',
			'#title'					=> 'Number of recent tweet to show',
			'#description'   => t('Enter number of recent tweet you want to show'),
			'#default_value' => theme_get_setting('twitter_num'),
		);
		
		// Flickr box
		$form['md_thenews_settings']['general']['social_media']['flickr_id'] = array(
			'#type'         	=> 'textfield',
			'#title'					=> 'Flickr id',
			'#description'   	=> t('Enter your flickr id here'),
			'#default_value' 	=> theme_get_setting('flickr_id'),
			'#prefix'         => '<h3>'.t('Flickr block config').'</h3>',
		);
		
		$form['md_thenews_settings']['general']['social_media']['flickr_limit'] = array(
			'#type'         	=> 'textfield',
			'#title'					=> 'Number of flickr image to show',
			'#default_value' 	=> theme_get_setting('flickr_limit'),
		);
		
		// Facebook like box
		$form['md_thenews_settings']['general']['social_media']['facebook_url'] = array(
			'#type'         	=> 'textfield',
			'#title'					=> 'Facebook Page URL',
			'#description'   	=> t('e.g http://www.facebook.com/megadrupal'),
			'#default_value' 	=> theme_get_setting('facebook_url'),
			'#prefix'         => '<h3>'.t('Facebook like box block config').'</h3>',
		);
		
		$form['md_thenews_settings']['general']['social_media']['facebook_width'] = array(
			'#type'          => 'textfield',
			'#title'					=> 'Width',
			'#default_value' => theme_get_setting('facebook_width'),
		);
		
		$form['md_thenews_settings']['general']['social_media']['facebook_colorscheme'] = array(
	    '#type'          => 'select',
	    '#title'         => t('Color scheme'),
	    '#default_value' => theme_get_setting('facebook_colorscheme'),
	    '#options'       => array(
														'light'   => t('Light'),
														'dark'		=> t('Dark'),
	                        ),
	  );
		
		$form['md_thenews_settings']['general']['social_media']['facebook_face'] = array(
			'#type'          => 'checkbox',
			'#title'         => t('Show faces'),
			'#default_value' => theme_get_setting('facebook_face'),
		);
		
		$form['md_thenews_settings']['general']['social_media']['facebook_bordercolor'] = array(
	    '#type'          => 'textfield',
	    '#title'         => t('Border color'),
	    '#default_value' => theme_get_setting('facebook_bordercolor'),
			'#prefix' => '<div class="form-font-color">',
			'#suffix' => '</div>',
			'#attributes' 		=> array(
													'class' => array(
														'form-colorpicker',
													),
			),
	  );
		
		$form['md_thenews_settings']['general']['social_media']['facebook_stream'] = array(
			'#type'          => 'checkbox',
			'#title'         => t('Show stream'),
			'#default_value' => theme_get_setting('facebook_stream'),
		);
		
		$form['md_thenews_settings']['general']['social_media']['facebook_header'] = array(
			'#type'          => 'checkbox',
			'#title'         => t('Show header'),
			'#default_value' => theme_get_setting('facebook_header'),
		);

	/* 4.	Custom font
	--------------------------------------------------------------------------*/
	$form['md_thenews_settings']['general']['custom_font'] = array(
		'#type' 					=> 'fieldset',
		'#weight' 				=> -5,
		'#prefix'  				=> '<div id="custom-font" class="md-tabcontent clearfix">',
		'#suffix'        => '</div><!-- / #custom-font -->',
	);

		$form['md_thenews_settings']['general']['custom_font']['googlewebfonts'] = array(
			'#type' 					=> 'textarea',
			'#title'         => t('@import'),
			'#resizable' => FALSE,
			'#rows' => 1,
			'#description' => t("For example: &lt;link href='<strong>http://fonts.googleapis.com/css?family=Quando|Kameron:400,700|Droid+Sans:400,700&subset=latin,latin-ext</strong>' rel='stylesheet' type='text/css'&gt"),
			'#default_value' 	=>  theme_get_setting('googlewebfonts'),
			'#prefix'					=> '<h3>Google Web Fonts</h3>
		<ul class="steps">
			<li>Go to <a href="http://www.google.com/webfonts" target="_blank">www.google.com/webfonts</a>, choose your fonts and add to collection</li>
      <li>Click &quot;Use&quot; in the bottom bar after choose fonts</li>
      <li>Find &quot;Add this code to your website&quot;, copy from <strong>http://</strong> to the nearest <strong>\'</strong> and paste it below to activate.</li>
		</ul>',
		);
		
		$form['md_thenews_settings']['general']['custom_font']['typekit_id'] = array(
			'#type' 					=> 'textfield',
			'#title'         => t('Typekit'),
			'#description'   	=> t('<strong>* Note:</strong> Your kit must contain fonts and be published before entering your Typekit ID below. Check out <a href="http://help.typekit.com/customer/portal/articles/6780-adding-fonts-to-your-site" target="_blank">this article at Typekit\'s Help Center</a> for detailed information on how to add fonts to your kit. (Make sure you skip the part about adding CSS selectors, and remember to republish your kit after making any changes.)'),
			'#default_value' 	=>  theme_get_setting('typekit_id'),
			'#prefix'					=> '<h3>Enter Your Typekit ID</h3>
		<ul class="steps">
			<li>Go to <a href="http://typekit.com/" target="_blank">www.typekit.com</a> and Log in to your account</li>
			<li>In the top bar of the Typekit website, click the green &quot;Launch Kit Editor&quot; button.</li>
			<li>In the top bar of the popup that appears, click the &quot;Kit Settings&quot; link and paste your domain. Once you\'ve done this, click &quot;Save Settings.&quot;</li>
			<li>In the same top bar of the popup, click the &quot;embed code&quot; link.</li>
			<li>In the overlay that appears, there is a line at the   bottom that says, &quot;If you are using a plugin or service that asks for a   Typekit ID, use this: ____.&quot; This is your Typekit ID. Paste it below to activate.</li>
		</ul>',
		);
		
		
	/* Hidden input
	--------------------------------------------------------------------------*/
	$form['md_thenews_settings']['general']['savedcolor1'] = array(
		'#type'         	=> 'hidden',
		'#default_value' 	=> theme_get_setting('savedcolor1'),
		'#attributes' => array(
				'id' => 'savedcolor1',
			),
	);

}