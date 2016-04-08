<?php
/**
 * @file
 * Theme setting callbacks for the MD thenews theme.
 */

drupal_add_css(drupal_get_path('theme', 'md_thenews') . '/css/theme-settings.css', array('group' => CSS_THEME));
drupal_add_css(drupal_get_path('theme', 'md_thenews') . '/js/colorpicker/css/colorpicker.css');

drupal_add_js(drupal_get_path('theme', 'md_thenews') . '/js/jquery.cookie.js');

drupal_add_library('system', 'ui.widget');
drupal_add_library('system', 'ui.mouse');
drupal_add_library('system', 'ui.slider');
drupal_add_library('system', 'ui.tabs');

drupal_add_js(drupal_get_path('theme', 'md_thenews') . '/js/colorpicker/js/colorpicker.js');
drupal_add_js(drupal_get_path('theme', 'md_thenews') . '/js/jquery.dropkick-1.0.0.js');
drupal_add_js(drupal_get_path('theme', 'md_thenews') . '/js/jquery.mousewheel.min.js');
drupal_add_js(drupal_get_path('theme', 'md_thenews') . '/js/jquery.jstepper.min.js');
drupal_add_js(drupal_get_path('theme', 'md_thenews') . '/js/jquery.choosefont.js');
drupal_add_js(drupal_get_path('theme', 'md_thenews') . '/js/theme-settings.js');

	require_once DRUPAL_ROOT . '/' . drupal_get_path('theme', 'md_thenews') . '/inc/theme-settings-general.inc';
	require_once DRUPAL_ROOT . '/' . drupal_get_path('theme', 'md_thenews') . '/inc/theme-settings-design.inc';
	require_once DRUPAL_ROOT . '/' . drupal_get_path('theme', 'md_thenews') . '/inc/theme-settings-text.inc';
	require_once DRUPAL_ROOT . '/' . drupal_get_path('theme', 'md_thenews') . '/inc/theme-settings-pages.inc';
	require_once DRUPAL_ROOT . '/' . drupal_get_path('theme', 'md_thenews') . '/inc/theme-settings-nodes.inc';
	require_once DRUPAL_ROOT . '/' . drupal_get_path('theme', 'md_thenews') . '/inc/theme-settings-sliders.inc';
	require_once DRUPAL_ROOT . '/' . drupal_get_path('theme', 'md_thenews') . '/inc/theme-settings-code.inc';

/**
 * Implements hook_form_FORM_ID_alter().
 *
 * @param $form
 *   The form.
 * @param $form_state
 *   The form state.
 */
function md_thenews_form_system_theme_settings_alter(&$form, &$form_state) {

	
	$form['md_thenews_settings']['html_header'] = array(
  	'#markup' => '
<div class="md-links">
<a href="http://megadrupal.com/project/md-thenews" target="_blank">Project Page</a> -
<a href="http://support.megadrupal.com/docs/md-thenews-documentation" target="_blank">Theme Documentation</a> -
<a href="http://support.megadrupal.com/forums/theme-support/md-thenews" target="_blank">Support Forum</a>
</div>
<div class="md-wrap">
  <div id="md-tabs">
		<div class="md-tabs-head"><div class="md-tabs-headcontent">
      <ul class="clearfix">
        <li class="tab-item first clearfix" id="tab-general-settings"> <a class="tab-link" href="#md-general-settings">
          <span class="tab-text">General Settings</span>
          </a> </li>
        <li class="tab-item clearfix" id="tab-design"> <a class="tab-link" href="#md-design">
          <span class="tab-text">Design</span>
          </a> </li>
        <li class="tab-item clearfix" id="tab-text-typography"> <a class="tab-link" href="#md-text-typography">
          <span class="tab-text">Text/Typography</span>
          </a> </li>
        <li class="tab-item clearfix" id="tab-pages"> <a class="tab-link" href="#md-pages">
          <span class="tab-text">Pages</span>
          </a> </li>
        <li class="tab-item clearfix" id="tab-nodes"> <a class="tab-link" href="#md-nodes">
          <span class="tab-text">Node display</span>
          </a> </li>
				<li class="tab-item clearfix" id="tab-sliders"> <a class="tab-link" href="#md-sliders">
          <span class="tab-text">Sliders</span>
          </a> </li>
        <li class="tab-item clearfix" id="tab-custom-code"> <a class="tab-link" href="#md-custom-code">
          <span class="tab-text">Custom code</span>
          </a> </li>
      </ul>
    </div></div><!-- /.md-tabs-head -->',
		'#weight' => -99,
	);
	
	
	md_thenews_theme_settings_generalsettings($form, $form_state);
	
	$fontarray = array(
							'0'   => t('Default'),
							'1'   => t('Arial'),
							'2'   => t('Verdana'),
							'3'   => t('Trebuchet MS'),
							'4'   => t('Georgia'),
							'5'   => t('Times New Roman'),
							'6'   => t('Tahoma'),
                        );
	$fontvars = array(
			'0'	=> array(
           'CSS' 		=>	'',
					 'Weight'	=>	'n4',
      ),
      '1'	=> array(
           'CSS' 		=>	'Arial, sans-serif',
					 'Weight'	=>	'n4, n7, i4, i7',
      ),
			'2'	=> array(
           'CSS' 		=>	'Verdana, Geneva, sans-serif',
					 'Weight'	=>	'n4, n7, i4, i7',
      ),
			'3'	=> array(
           'CSS' 		=>	'Trebuchet MS, Tahoma, sans-serif',
					 'Weight'	=>	'n4, n7, i4, i7',
      ),
			'4'	=> array(
           'CSS' 		=>	'Georgia, serif',
					 'Weight'	=>	'n4, n7, i4, i7',
      ),
			'5'	=> array(
           'CSS' 		=>	'Times New Roman, serif',
					 'Weight'	=>	'n4, n7, i4, i7',
      ),
			'6'	=> array(
           'CSS' 		=>	'Tahoma, Geneva, Verdana, sans-serif',
					 'Weight'	=>	'n4, n7, i4, i7',
      ),
  );
	if (theme_get_setting('typekit_id')) {
		drupal_add_js('http://use.typekit.net/'.theme_get_setting('typekit_id').'.js', 'external');
		drupal_add_js('try{Typekit.load();}catch(e){}', 'inline');
		
		$tk_url = 'http://typekit.com/api/v1/json/kits/'.theme_get_setting('typekit_id').'/published';
		$typekit = json_decode(file_get_contents($tk_url), true); 
	  for($i=0;$i<count($typekit['kit']['families']);$i++){
			$fontarray[$typekit['kit']['families'][$i]['id']] = $typekit['kit']['families'][$i]['name'];
			$fontweight = "";
			for ($j=0;$j < count($typekit['kit']['families'][$i]['variations']);$j++){
				if (($j+1) == count($typekit['kit']['families'][$i]['variations'])) {
					$fontweight .= $typekit['kit']['families'][$i]['variations'][$j];
				} else {
					$fontweight .= $typekit['kit']['families'][$i]['variations'][$j].',';
				}
			}
			$fontvars[$typekit['kit']['families'][$i]['id']] = array(
				'CSS' 		=>	$typekit['kit']['families'][$i]['css_stack'],
				'Weight'	=>	$fontweight,
			);
		}
	}
	
	if (theme_get_setting('googlewebfonts')) {
		$googlewebfonts = theme_get_setting('googlewebfonts');
		if (strpos($googlewebfonts, '@import url(') !== FALSE) {
			preg_match("/http:\/\/\s?[\'|\"]?(.+)[\'|\"]?\s?(\)|\')/Uix", $googlewebfonts, $ggwflink);
			$googlewebfonts = 'http://'.$ggwflink[1];
		}
		drupal_add_css($googlewebfonts, 'external');
		
		preg_match('/([^\?]+)(\?family=)?([^&\']+)/i',$googlewebfonts, $matches);
		$gfonts = explode("|", $matches[3]);

		for ($i = 0; $i < count($gfonts); $i++) {
			$gfontsdetail = explode(":", $gfonts[$i]);
			$gfontname = str_replace("+", " ", $gfontsdetail['0']);
			$fontarray[$gfontsdetail[0]] = $gfontname;
			if (array_key_exists('1', $gfontsdetail)) {
				$tmpft =  explode(",", $gfontsdetail['1']);
				$gfontweigth[$i] = "";
				for ($j = 0; $j < count($tmpft); $j++) {
					if (preg_match("/italic/i", $tmpft[$j])) {
					    $gfontstyle = "i";
					} else {
					    $gfontstyle = "n";
					}
					$tmpw = str_replace("italic", "",$tmpft[$j]);
					$seperator = ",";
					if ($j == (count($tmpft) - 1)) {
						$seperator = "";
					}
					if ($tmpw) {
					  $gfontweigth[$i] .= $gfontstyle.str_replace("00", "",$tmpw).$seperator;
					} else {
						$gfontweigth[$i] .= "n4".$seperator;
					}
				}
			} else {
				$gfontweigth[$i] = "n4";
			}
			$fontvars[$gfontsdetail['0']] = array(
				'CSS' 		=>	'"'.$gfontname.'"',
				'Weight'	=>	$gfontweigth[$i],
			);
		}
	}
	
	drupal_add_js(array('font_array' => $fontarray), 'setting');
	drupal_add_js(array('font_vars' => $fontvars), 'setting');

	md_thenews_theme_settings_design($form, $form_state);
	md_thenews_theme_settings_text($form, $form_state);
	md_thenews_theme_settings_pages($form, $form_state);
	md_thenews_theme_settings_nodes($form, $form_state);
	md_thenews_theme_settings_sliders($form, $form_state);
	md_thenews_theme_settings_code($form, $form_state);

	
	$form['md_thenews_settings']['html_footer'] = array(
  	'#markup' => '
	</div><!-- /#md-tabs -->
</div><!-- /.md-wrap -->',
		'#weight' => 99,
	);
	
	$form['#submit'][]   = 'md_thenews_settings_submit';
}

function md_thenews_settings_submit($form, &$form_state) {
  $settings = array();
 
  // Check for a new uploaded file, and use that if available.
  if ($file = file_save_upload('bg_upload')) {
    $parts = pathinfo($file->filename);
    $destination = 'public://' . $parts['basename'];
    $file->status = FILE_STATUS_PERMANENT;
		if (file_copy($file, $destination, FILE_EXISTS_REPLACE)) {
			$_POST['bg_path'] = $form_state['values']['bg_path'] = $destination;
		}
  }

} 