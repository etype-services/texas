<?php

/**
 * @file
 * Definition of MediaBrowserUpload.
 */

/**
 * Media browser plugin for showing the upload form.
 *
 * @deprecated
 */
class MediaSoundslidesUpload extends MediaBrowserPlugin {
  /**
   * Implements MediaBrowserPluginInterface::access().
   */
  public function access($account = NULL) {
    // @todo Replace with file_access().
    return media_access('edit', $account);
  }

  /**
   * Implements MediaBrowserPlugin::view().
   */
  public function view() {
    module_load_include('inc', 'media', 'includes/media.pages');

    $build = array();

    $build['form'] = drupal_get_form('soundslides_upload_add', $this->params);

    return $build;
  }
}
