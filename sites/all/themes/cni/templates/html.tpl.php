<!DOCTYPE html>
<html lang="<?php print $language->language; ?>"
      dir="<?php print $language->dir; ?>" <?php print $rdf_namespaces; ?>>
<head>
  <?php print $head; ?>
    <title><?php print $head_title; ?></title>
  <?php print $styles; ?>
  <?php print $scripts; ?>
    <meta name="viewport"
          content="width=device-width, initial-scale=1, maximum-scale=1">
    <link href='//fonts.googleapis.com/css?family=Lato' rel='stylesheet'
          type='text/css'>
    <!--[if lt IE 9]>
    <script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <?php /* include extra dfp file */ if (isset($dfp_file)) include("$dfp_file"); ?>
</head>
<body class="<?php print $classes; ?>"<?php print $attributes; ?>>
<div id="fb-root"></div>
<script>(function (d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s);
        js.id = id;
        js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.5";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>
<div id="skip-link">
    <a href="#main-content"
       class="element-invisible element-focusable"><?php print t('Skip to main content'); ?></a>
</div>
<?php print $page_top; ?>
<?php print $page; ?>
<?php print $page_bottom; ?>
</body>
</html>
