<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <?php include_http_metas() ?>
    <?php include_metas() ?>
    <?php include_title() ?>
    <link rel="shortcut icon" href="/favicon.ico" />
    <?php include_stylesheets() ?>
    <?php include_javascripts() ?>
    <script>
                function erakutsiEzkutatu()
                {
                        if (document.getElementById('aurreratua').style.display == 'none')
                           {
                                document.getElementById('aurreratua').style.display = 'block';
                                document.getElementById('arrunta').style.display = 'none';
                                document.getElementById('aurreratuaB').style.display = 'block';
                           }
                        else if (document.getElementById('aurreratua').style.display == 'block')
                           {
                                document.getElementById('aurreratua').style.display = 'none';
                                document.getElementById('arrunta').style.display = 'block';
                                document.getElementById('aurreratuaB').style.display = 'none';
                           }
                }
    </script>
  </head>
  <body>
    <div id="container">
     <div id="goiburua">
        <div class="logoa">
                <img src="/images/logo2.jpg">
        </div>
        <?php if ($sf_user->isAuthenticated()): ?>
        <div class="post">
                <h2><?php echo $sf_user->getGuardUser()->getFirstName()." ".$sf_user->getGuardUser()->getLastName();  ?><br>
                ( <?php echo $sf_user->getUsername(); ?> )</h2>
                <br><?php echo link_to('Saioa amaitu', 'sf_guard_signout') ?>
        </div>
        <?php endif ?>
     </div>
     <div id="gorputza">
	<br>
        <?php echo $sf_content ?>
     </div>
    </div>
  </body>
</html>

