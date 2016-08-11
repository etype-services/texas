<?php
// 

/**
 * Implements hook_form_FORM_ID_alter().
 *
 * Allows the profile to alter the site configuration form.
 */
function mdthenews_form_install_configure_form_alter(&$form, $form_state) {
  $form['site_information']['site_name']['#default_value'] = 'MD Thenews';
  $form['#submit'][] = '_md_profile_install_configure_form_submit';
}

/**
 * Forms API submit for the site configuration form.
 */
function _md_profile_install_configure_form_submit($form, &$form_state) {
  global $user;
  $sql_file = dirname(__FILE__).'/mdthenews.sql';
  $count = _md_profile_import_sql($sql_file);
  drupal_set_message("MD Thenews Installation was a Success! Imported $count queries.");
  drupal_set_message("For security purposes, it's recommended that you delete $sql_file, or it out of your webroot.");
	drupal_set_message("Please ".l(t('clear your cache'), 'admin/config/development/performance')." before use MD Thenews profile");

  variable_set('site_name', $form_state['values']['site_name']);
  variable_set('site_mail', $form_state['values']['site_mail']);
  variable_set('date_default_timezone', $form_state['values']['date_default_timezone']);
  variable_set('site_default_country', $form_state['values']['site_default_country']);

  // Enable update.module if this option was selected.
  if ($form_state['values']['update_status_module'][1]) {
    module_enable(array('update'), FALSE);

    // Add the site maintenance account's email address to the list of
    // addresses to be notified when updates are available, if selected.
    if ($form_state['values']['update_status_module'][2]) {
      variable_set('update_notify_emails', array($form_state['values']['account']['mail']));
    }
  }

  // We precreated user 1 with placeholder values. Let's save the real values.
  $account = user_load(1);
  $merge_data = array('init' => $form_state['values']['account']['mail'], 'roles' => !empty($account->roles) ? $account->roles : array(), 'status' => 1);
  user_save($account, array_merge($form_state['values']['account'], $merge_data));
  // Load global $user and perform final login tasks.
  $user = user_load(1);
  user_login_finalize();

  if (isset($form_state['values']['clean_url'])) {
    variable_set('clean_url', $form_state['values']['clean_url']);
  }

  // Record when this install ran.
  variable_set('install_time', $_SERVER['REQUEST_TIME']);
  //drupal_flush_all_caches();

}

function _md_profile_import_sql($filename){
  global $databases;
  if (@mysql_connect($databases['default']['default']['host'], $databases['default']['default']['username'], $databases['default']['default']['password'])){
    mysql_select_db($databases['default']['default']['database']);
    $buffer='';
    $count=0;
		
		$prefix = $databases['default']['default']['prefix'];
		// get profile from registry file
		$query1 = "SELECT *
								FROM `".$prefix."registry_file`
								WHERE `filename` = 'profiles/mdthenews/mdthenews.profile'
								LIMIT 1";
		$result1 = mysql_query($query1);
		$row1 = mysql_fetch_array($result1);
		$query2 = "SELECT *
								FROM `".$prefix."system`
								WHERE `filename` = 'profiles/mdthenews/mdthenews.profile'
								LIMIT 1";
		$result2 = mysql_query($query2);
		$row2 = mysql_fetch_array($result2);
		
    $handle = @fopen($filename, "r");
    if ($handle) {
      while (!feof($handle)) {
        $line = fgets($handle);
        $buffer.=$line;
        if(preg_match('|;$|', $line)){
          $count++;
          mysql_query(_md_profile_prefixTables($buffer));
          $buffer='';
        }
      }
      fclose($handle);
    }
		$query1a = "INSERT INTO `".$prefix."registry_file` (`filename`, `hash`) VALUES
		('".$row1['filename']."', '".$row1['hash']."');";
		mysql_query($query1a);
		
		$query2a = "INSERT INTO `".$prefix."system` (`filename`, `name`, `type`, `owner`, `status`, `bootstrap`, `schema_version`, `weight`, `info`) VALUES
		('".$row2['filename']."', '".$row2['name']."', '".$row2['type']."', '".$row2['owner']."', ".$row2['status'].", ".$row2['bootstrap'].", ".$row2['schema_version'].", ".$row2['weight'].", '".$row2['info']."');";
		mysql_query($query2a);
		$query2b = "UPDATE ".$prefix."system
								SET `status`=0
								WHERE `filename`='profiles/standard/standard.profile'";
		mysql_query($query2b);
    mysql_close();
  }
  return $count;
}

function _md_profile_prefixTables($sql) {
  global $databases;
  $prefix = $databases['default']['default']['prefix'];
  if (is_array($prefix)) {
    $defaultPrefix = isset($prefix['default']) ? $prefix['default'] : '';
    unset($prefix['default']);
    $prefixes = $prefix;
  } else {
    $defaultPrefix = $prefix;
    $prefixes = array();
  }	
  // Replace specific table prefixes first.
  foreach ($prefixes as $key => $val) {
    $sql = strtr($sql, array('md7_' . $key  => $val . $key));
  }
  // Then replace remaining tables with the default prefix.
  return strtr($sql, array('md7_' => $defaultPrefix ));
}
