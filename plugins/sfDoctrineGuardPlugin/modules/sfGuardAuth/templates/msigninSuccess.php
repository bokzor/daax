<?php use_helper('Thumb'); ?>

<!doctype html>
<html id="fullScreen" class="linen no-js" lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

  <title>LiveOrder</title>
  <meta name="description" content="">
  <meta name="author" content="">

  <!-- http://davidbcalhoun.com/2010/viewport-metatag -->
  <meta name="HandheldFriendly" content="True">
  <meta name="MobileOptimized" content="320">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

  <?php include_partial('home/css') ?>

  <!-- For Modern Browsers -->
  <link rel="shortcut icon" href="/image/favicons/favicon.png">
  <!-- For everything else -->
  <link rel="shortcut icon" href="/image/favicons/favicon.ico">
  <!-- For retina screens -->
  <link rel="apple-touch-icon-precomposed" sizes="114x114" href="/image/favicons/apple-touch-icon-retina.png">
  <!-- For iPad 1-->
  <link rel="apple-touch-icon-precomposed" sizes="72x72" href="/image/favicons/apple-touch-icon-ipad.png">
  <!-- For iPhone 3G, iPod Touch and Android -->
  <link rel="apple-touch-icon-precomposed" href="/image/favicons/apple-touch-icon.png">

  <!-- iOS web-app metas -->
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-status-bar-style" content="black">

  <!-- Startup image for web apps -->
  <link rel="apple-touch-startup-image" href="/image/splash/ipad-landscape.png" media="screen and (min-device-width: 481px) and (max-device-width: 1024px) and (orientation:landscape)">
  <link rel="apple-touch-startup-image" href="/image/splash/ipad-portrait.png" media="screen and (min-device-width: 481px) and (max-device-width: 1024px) and (orientation:portrait)">
  <link rel="apple-touch-startup-image" href="/image/splash/iphone.png" media="screen and (max-device-width: 320px)">

  <!-- Microsoft clear type rendering -->
  <meta http-equiv="cleartype" content="on">


  <!---jQuery Files-->
  <script src="/js/libs/modernizr.custom.js"></script>
  <script src="/js/libs/jquery-1.8.2.min.js"></script>

</head>
<body>

  <div id="container" style="opacity: 0;">
  	<div id="wrapper">

      <div id="header">
    		<!-- <h1>F.M.I.M & Adrien Bokor</h1> -->
      </div>

      <ul class="no-margin-left" id="users">
  	      <li data-name="Café Basse Cour">
  	        <div class="av-overlay"></div><img src="/image/logo/logo.png" class="av">
  	      </li>
  	      <?php foreach($serveurs as $serveur): ?>
  		      <li data-name="<?php echo $serveur->getUsername() ?>">
  		        <div class="av-overlay"></div>
  		        <?php echo showThumb($serveur->getAvatar(), 'avatar', $options = array('alt' => 'Avater de '.$serveur->getFirstName().'', 'class' => 'av', 'width' => '115', 'height' => '115'), $resize = 'fit', $default = 'default.jpg') ?> 
  		        <span class="av-tooltip"><?php echo $serveur->getFirstName() ?></span>
  		      </li>
  	  	<?php endforeach; ?>
        <br class="clear">
      </ul>

   
      
    </div>

    <div style="opacity: 0;" id="lg-overlay">
      <div id="quick-lg">
        <form id="lg-form" method="post" action="dashboard.html">
          <div id="field">
            <p id="placeholder">Entrez votre mot de passe...</p>
            <input type="password" class="virtual-pad" id="quick-input" autocomplete="off">
            <span class="icon"><img src="/image/new_login/img/spinner-sm.gif"></span>
          </div>
          <button type="submit" id="lg-submit" class="button inset submit">LOGIN</button>
          <br class="clear">
        </form>
      </div>
    </div>
</div>
    <span class="no-margin-right no-margin-left" id="load">
      <img src="/image/new_login/img/load.png"><img src="/image/new_login/img/spinner.png" id="spinner">
    </span>
  <!---jQuery Code-->
<script>

</script>
</body>
  <?php include_partial('home/js') ?>
  <script type='text/javascript'>


  $(document).ready(function () {
      // clavier virttuel
      if ($.template.touchOs == false) {
          $('.virtual-pad').keypad({
              keypadOnly: false,
              layout: ['azertyuiop' + $.keypad.CLOSE,
                  'qsdfghjklm' + $.keypad.CLEAR,
                  'wxcvbn' + $.keypad.SPACE + $.keypad.SPACE + $.keypad.BACK
              ]
          });
      }
      // javascript pour le loader
    $('#lg-overlay, #load, #field span img, #forgot-psw, .icon, .notification').hide();
    $('#load').transition({opacity: 1 }, 400);
    $(window).load(function () {
        $('#load').transition({opacity: 0 }, 400, function () {
            $('#container').show().transition({opacity: 1 }, 600, function () {});
        });
    });
  });


    // on fait apparaitre la boite de login lors du clic sur une photo
    $('#users li').live('click', function() {
        $('#users li').removeClass('active');
        $(this).addClass('active');
        $('#lg-overlay').show().transition({opacity: 1}, 400, function () {
            $('#quick-input').focus();
        });
    });
    // on fait disparaitre le modal lors d'un clic
    $('#lg-overlay').live('click', function(e) {
        if ($(e.target).is('#quick-lg, #quick-lg *')) {
            return;
        }
        $(this).hide().transition({opacity: 0}, 300);
    });

    $('#lg-form').live('submit', function(e) {
        $('#field span').html('<img src="/image/new_login/img/spinner-sm.gif">');
        var pswlgt = $('#quick-input').val().length;
        if (pswlgt < 1) {
            e.preventDefault();
            $('#placeholder').text('Entrez votre mot de passe');
            $('#field span').hide().transition({opacity: 0}, 200, function () {
                $(this).text('X').css('color', '#e56969').show().transition({opacity: 1 }, 100);
                $('#quick-input').val('').focus();
            });
            $('#field').removeClass('success').addClass('error');
            $('#forgot-psw').show();
        } else {
            e.preventDefault();
            var login = $('li.active').data('name');
            var pass = $('#quick-input').val();
            $.ajax('<?php echo url_for('@check_login') ?>', {
                    type: 'POST',
                    data: {
                        'signin[username]': login,
                        'signin[password]': pass
                    },
                    success: function (data) {
                        if (data == 'logged') {
                            $('#field span').hide().transition({opacity: 0 }, 200, function () {
                                $('#field span').text('=').css('color', '#9fbf2f').show().transition({opacity: 1}, 100);
                            });
                            document.location.href = '<?php echo url_for('@homepage') ?>';
                        } else {
                            $('#field').removeClass('success').addClass('error');
                            $('#field span').text('X').css('color', '#e56969').show().transition({opacity: 1}, 100);
                        }
                    },
                    error: function () {
                        $('#field').removeClass('success').addClass('error');
                    }
                });
        }
    });

    $('#quick-input').live('change keyup input paste', function () {
        $('#field span').css('color', '#ccc');
        $('#field').removeClass('error', 'success');
        $('#placeholder').text('');
        $('#forgot-psw').hide();
    });
    $('#quick-input').blur(function () {
        $(this).filter(function () {
            return this.value == "";
        })
            .siblings('#placeholder').text('Entrez votre mot de passe...');
    });



    </script>
  
</html>