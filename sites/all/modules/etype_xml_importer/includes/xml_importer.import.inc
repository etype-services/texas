<?php

/**
 * Create Entity
 * @param array $item
 * @param array $values
 * @param string $entity_type
 */
function etype_xml_importer_entity_create($item = array(), $values = array(), $entity_type = 'node') {

  $entity = entity_create($entity_type, $values);
  $wrapper = entity_metadata_wrapper($entity_type, $entity);
  if (count($item) > 0) {
    foreach ($item as $k => $v) {
      switch ($k) {

        case 'title':
          $wrapper->$k->set($v);
          break;

        case 'body':
          $wrapper->body->set(array(
            'value' => $v,
            'summary' => $item['summary'],
            'format' => 'full_html'
            )
          );
          break;

        case 'summary':
          break;

        case 'images':
          $files = array();
          foreach ($v as $arr) {
            $file = file_save_data(file_get_contents($arr['path']), 'public://' . $arr['name']);
            $file->display = '1';
            $file->description = $arr['caption'];
            $file->image_field_caption = array(
              'value' => $arr['caption'],
              'format' => 'plain_text'
            );
            $file = file_save($file);
            $file = (array) $file;
            $files[] = $file;
          }
          $wrapper->field_image->set($files);
          break;

        default:
          if (field_info_instance('node', "$k", 'article')) {
            $wrapper->$k->set($v);
          }
      }
    }
    $wrapper->save(TRUE);
  }
}

/**
 * Parse Olive XML Files
 */
function etype_xml_importer_olive_import() {

  global $user;
  $import_files = variable_get('etype_xml_import_file');
  if (empty($import_files)) {
    watchdog('etype_xml_importer', "XML import setting empty.", $variables = array(), $severity = WATCHDOG_NOTICE);
    return;
  }
  // $base_import_url = 'http://test.etypegoogle4.com/xml-import/';
  $base_import_url = 'http://olivexml.etypeservices.com/olivexml/';
  $import_file_array = explode(',', $import_files);

  if (count($import_file_array) > 0) {

    $i = 0;
    foreach ($import_file_array as $item) {

      // echo $item;
      $rand = md5(time());
      $zip_file = "/tmp/" . $rand . ".zip";
      $extract_dir = '/tmp/' . $rand . '/';

      /* Copy Zip file from url */
      $import_file = $base_import_url . trim($item);
      if (!file_put_contents($zip_file, file_get_contents($import_file))) {
        watchdog('etype_xml_importer', "Could not import " . $import_file . ".", $variables = array(), $severity = WATCHDOG_WARNING);
        continue;
      }

      /* Extract Zip Archive */
      $zip = new ZipArchive;
      $res = $zip->open($zip_file);
      if ($res === TRUE) {
        $zip->extractTo($extract_dir);
        $zip->close();
      } else {
        watchdog('etype', "eType XML Importer could not open Zip Archive %file", $variables = array('%file' => $zip_file), $severity = WATCHDOG_WARNING);
        exit;
      }

      /* Loop over directory and get the Files */
      $fileSystemIterator = new FilesystemIterator($extract_dir);
      $entries = array();
      foreach ($fileSystemIterator as $fileInfo) {
        $entry = $fileInfo->getFilename();
        if(strpos($entry, 'Section') !== FALSE) {
          $entries[] = $fileInfo->getFilename();
        }
      }

      /* Loop over found files and do the extraction */
      if (count($entries) > 0) {

        $values = array(
          'type' => 'article',
          'uid' => $user->uid,
          'status' => 0,
          'comment' => 0,
          'promote' => 0,
          'language' => LANGUAGE_NONE,
        );

        foreach ($entries as $entry) {
          $xml = file_get_contents($extract_dir . $entry);
          if ($xml !== FALSE) {
            /* parse xml in each file */
            $obj = simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA);
            if (sizeof($obj) > 0) {
              /* loop over items in Section file */
              foreach ($obj as $stub) {
                $item = $stub->item;
                /* xml object processing of stub which contains link, title, and description */
                foreach ($item as $k => $v) {
                  $array = (array) $v;
                  // print_r($array);
                  // title is not an object if the stub is valid
                  if (!is_object($array['title'])) {
                    // full article is in the linked file
                    $ar_file =  $array['link'];
                    $ar_xml = file_get_contents($extract_dir . $ar_file);

                    /* parse article xhtml from link file */
                    preg_match("/<prism:section>([^<]+)/", $ar_xml, $coincidencias);
                    /* ignore classifieds */
                    if ($coincidencias[1] == 'Classifieds') {
                      continue;
                    }
                    $array['section'] = $coincidencias[1];

                    preg_match("/<dc:title>([^<]+)/", $ar_xml, $coincidencias);
                    // echo 'title should be: ' . $coincidencias[1] . "\n";
                    $array['title'] = $coincidencias[1];

                    preg_match("/<prism:coverDate>([^<]+)/", $ar_xml, $coincidencias);
                    $array['pub_date'] = $coincidencias[1];

                    // s flag makes dot match linebreaks as well
                    preg_match("'<body>(.*?)</body>'s", $ar_xml, $coincidencias);
                    $body = $coincidencias[1];
                    $body = preg_replace("'<xhtml:h1>(.*?)</xhtml:h1>'s", "", $body);
                    $body = preg_replace("'<pam:media>(.*?)</pam:media>'s", "", $body);
                    $body = preg_replace("'<xhtml:p prism:class=\"deck\">(.*?)</xhtml:p>'s", "", $body);
                    $body = preg_replace("'<xhtml:p prism:class=\"byline\">(.*?)</xhtml:p>'s", "", $body);
                    $body = preg_replace("/xhtml:([a-z]?)/", "$1", $body); // fix tags
                    $array['body'] = $body;

                    // get the slugline
                    preg_match("'<xhtml:p prism:class=\"deck\">(.*?)</xhtml:p>'s", $ar_xml, $coincidencias);
                    if (isset($coincidencias[1])) {
                      $array['slugline'] = trim(strip_tags($coincidencias[1]));
                    } else {
                      $array['slugline'] = '';
                    }

                    // get the byline
                    preg_match("'<xhtml:p prism:class=\"byline\">(.*?)<xhtml:br />'s", $ar_xml, $coincidencias);
                    if (isset($coincidencias[1])) {
                      $array['byline'] = trim(ucwords(strtolower(strip_tags($coincidencias[1]))));
                    } else {
                      $array['byline'] = '';
                    }

                    // echo $ar_xml;

                    /* Images */
                    $images = array();
                    preg_match_all("'<pam:media>(.*?)</pam:media>'s", $ar_xml, $coincidencias);
                    // loop over matches and extracat data
                    if (! empty($coincidencias[1])) {
                      $matches = $coincidencias[1];
                      foreach ($matches as $item) {
                        preg_match("/<dc:format>([^<]+)/", $item, $imatches);
                        if (isset($imatches[1]) && $imatches[1] == 'image/jpg') {
                          preg_match("'<pam:mediaReference pam:refid=\"(.*)\" />'", $item, $arr);
                          if (isset($arr[1])) {
                            $iarray = array();
                            $iarray['image'] = $arr[1];
                            preg_match("'<pam:caption>(.*?)</pam:caption>'s", $item, $arr);
                            if (isset($arr[1])) {
                              $iarray['caption'] = trim(strip_tags($arr[1]));
                            } else {
                              $iarray['caption'] = '';
                            }
                            $images[] = $iarray;
                          }
                        }
                      }
                    }

                    // print_r ($images);

                    $array['images'] = array();
                    if (count($images) > 0) {
                      foreach ($images as $image) {
                        $ipath = $extract_dir . 'img/' . $image['image'];
                        $array['images'][] = array(
                          'name' => $image['image'],
                          'path' => $ipath,
                          'caption' => $image['caption'],
                        );
                      }
                    }
                    /* Images now part of $array */
                    // print_r ($array);

                    $node = array(
                      'title' => $array['title'],
                      'summary' => strip_tags($array['description']),
                      'body' => $array['body'],
                      'field_kicker' => $array['slugline'],
                      'field_dateline' => $array['byline'],
                      'images' => $array['images'],
                    );
                    // print_r($node);

                    $values['created'] = strtotime($array['pub_date']);
                    etype_xml_importer_entity_create($node, $values);
                    //exit;
                    $i++;
                    // echo $i . ' ';
                  }
                }
              }
            }
          }
        }
      }
    }
    watchdog('etype', "eType XML Importer imported %num stories.", $variables = array('%num' => $i), $severity = WATCHDOG_NOTICE);
  }
}