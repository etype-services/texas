<?php

/**
 * Implements hook_file_formatter_info()
 */
function soundslides_file_formatter_info() {
  $formatters = array();

  $formatters['soundslides_preview_image'] = array(
    'file types' => array('soundslides'),
    'label' => 'Soundslides Preview',
    'view callback' => 'soundslides_file_formatter_soundslides_preview_image_view',
  );

  $formatters['soundslides_video'] = array(
    'file types' => array('soundslides'),
    'label' => 'Soundslides Player',
    'view callback' => 'soundslides_file_formatter_soundslides_video_view',
  );

  return $formatters;
}

/**
 * View callback for soundslides preview image
 */
function soundslides_file_formatter_soundslides_preview_image_view($file, $display, $langcode) {
  $type = $file->type;
  if ($type == 'soundslides') {
    // $wrapper = file_stream_wrapper_get_instance_by_uri($file->uri);
    $image_style = $display['settings']['image_style'];
    $valid_image_styles = image_style_options(FALSE);
    if (empty($image_style) || !isset($valid_image_styles[$image_style])) {
      $element = array(
        '#theme' => 'image',
        '#path' => soundslides_get_thumbnail_path($file),
      );
    }
    else {
      $element = array(
        '#theme' => 'image_style',
        '#style_name' => $image_style,
        '#path' => soundslides_get_thumbnail_path($file),
      );
    }

    return $element;
  }
}

/**
 * View callback for soundslides video
 */
function soundslides_file_formatter_soundslides_video_view($file, $display, $langcode) {
  $type = $file->type;

  if ($type == 'soundslides') {
    if(isset($file->override['wysiwyg'])) {
      if (empty($image_style) || !isset($valid_image_styles[$image_style])) {
        $element = array(
          '#theme' => 'image',
          '#path' => soundslides_get_thumbnail_path($file),
        );
      }
      else {
        $element = array(
          '#theme' => 'image_style',
          '#style_name' => $image_style,
          '#path' => soundslides_get_thumbnail_path($file),
        );
      }
    }
    else {
      $element = array(
        '#theme' => 'soundslides_video',
        '#uri' => $file->uri,
        '#options' => array(),
      );
    }
    return $element;
  }
}
