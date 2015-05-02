<!DOCTYPE html>
<html>
  <head>
    <title>GoFundMe Code-Sample</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
    <?php
    foreach ($viewVars['media']['css'] as $css)
    {
      if (file_exists(CSS_DIR.$css.'.css'))
      echo '<link href="'.CSS_URI.dp($css).'.css?'.time().'" type="text/css" rel="stylesheet">';
    }
    ?>
  </head>
  <body>
    <div class="container">
      <div class="page-header"><h1>GoFundMe Code-Sample</h1></div>
