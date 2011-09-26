<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <?php include_http_metas() ?>
    <?php include_metas() ?>
    <?php include_title() ?>
    <link rel="shortcut icon" href="/favicon.png" />
    <?php include_stylesheets() ?>
    <?php include_javascripts() ?>
  </head>
  <body>
    <div id="wrapper">
      <div id="header">
        <h1 class="banner">
          <span class="left"></span>
          <a class="center" href="<?php echo url_for('@homepage') ?>">montrain.fr</a>
          <span class="right"></span>
        </h1>
      </div>
      <div id="container">
        <?php echo $sf_content ?>
      </div>
    </div>
  </body>
</html>
