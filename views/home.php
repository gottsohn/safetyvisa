<!doctype html>
<html ng-app="SafetyVisa">
<head>
  <meta name="HandheldFriendly" content="True">
  <meta name="MobileOptimized" content="320">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
  <base href="<?php echo PTH; ?>">
  <script type="text/javascript">
    window.PUBLIC_PATH = '<?php echo PUBLIC_PATH; ?>';
    window.PTH = '<?php echo PTH; ?>';
  </script>
  <!-- CDN provided-->
  <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" type="text/css">
    <?php
    foreach ($stylesArray as $style) {
      echo '<link rel="stylesheet" type="text/css" href="'.PUBLIC_PATH.$style.'.css"/>'."\n";
    }

    foreach ($scriptsArray as $script) {
      echo '<script type="text/javascript" src="'.PUBLIC_PATH.$script.'.js"></script>'."\n";
    }

    ?>
  <title>
    SafetyVisa
  </title>
</head>
<body layout="row" layout-fill>
  <md-content layout="row" layout-fill ui-view class="md-default-theme no-bg">

  </md-content>
</body>
</html>