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

  <!-- For all browsers -->
  <link rel="stylesheet" href="/css/reset.css">
  <link rel="stylesheet" href="/css/style.css">
  <link rel="stylesheet" href="/css/colors.css">

  <link rel="stylesheet" media="print" href="/css/print.css">
  <!-- For progressively larger displays -->
  <link rel="stylesheet" media="only all and (min-width: 480px)" href="/css/480.css">
  <link rel="stylesheet" media="only all and (min-width: 768px)" href="/css/768.css">
  <link rel="stylesheet" media="only all and (min-width: 992px)" href="/css/992.css">
  <link rel="stylesheet" media="only all and (min-width: 1200px)" href="/css/1200.css">
  <!-- For Retina displays -->
  <link rel="stylesheet" media="only all and (-webkit-min-device-pixel-ratio: 1.5), only screen and (-o-min-device-pixel-ratio: 3/2), only screen and (min-device-pixel-ratio: 1.5)" href="/css/2x.css">

  <!-- Additional styles -->
  <link rel="stylesheet" href="/css/styles/form.css?">
  <link rel="stylesheet" href="/css/styles/switches.css?">
    <!-- Additional styles -->
  <link rel="stylesheet" href="/css/styles/dashboard.css">
  <link rel="stylesheet" href="/css/jquery.keypad.css">
  <link rel="stylesheet" href="/css/styles/jqpagination.css">
  <link rel="stylesheet" href="/css/styles/form.css">
  <link rel="stylesheet" href="/css/styles/switches.css">
  <link rel="stylesheet" href="/css/styles/table.css">
  <link rel="stylesheet" href="/css/styles/modal.css">
  <link rel="stylesheet" href="/css/timepicker.css">
  <link rel="stylesheet" href="/css/mobiscroll.css">
  <link rel="stylesheet" href="/js/libs/DataTables/jquery.dataTables.css">
  <link rel="stylesheet" href="/css/new_login/core.css">
      <!-- feuille de style pour les clients -->

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

  <!---CSS Files-->
  <link rel="stylesheet" href="/css/new_login/core.css">
  <link rel="stylesheet" href="/css/new_login/login.css">
  <!---jQuery Files-->
  <script src="/js/libs/modernizr.custom.js"></script>
  <script src="/js/libs/jquery-1.8.2.min.js"></script>
  <script src="/js/libs/quo.js"></script>


  <script src="/js/libs/underscore-min.js"></script>
  <script src="/js/libs/backbone-min.js"></script>

</head>
<body>

  <div id="container" style="display: none">
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

    <div style="display:none" id="lg-overlay">
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
    // javascript pour le loader
  $('#lg-overlay, #load, #field span img, #forgot-psw, .icon, .notification').hide();
  $('#load').fadeIn(400);
  $(window).load(function () {
      $('#load').fadeOut(400, function () {
          $('#container').fadeIn(600, function () {});
      });
  });
</script>
</body>
  <script src="/js/setup.js"></script>

  <!-- Template functions -->
  <script src="/js/libs/jquery.jqpagination.min.js"></script>
  <script src="/js/timepicker-mobiscroll.js"></script>
  <script src="/js/timepicker.js"></script>   
  <script src="/js/developr.input.js"></script>
  <script src="/js/developr.modal.js"></script>
  <script src="/js/developr.message.js"></script>
  <script src="/js/developr.notify.js"></script>
  <script src="/js/developr.scroll.js"></script>
  <script src="/js/developr.tooltip.js"></script>
  <script src="/js/jquery.keypad.js"></script>
  <script src="/js/developr.confirm.js"></script>
  <script src="/js/developr.wizard.js"></script>


  <!-- Must be loaded last -->
  <script src="/js/developr.tabs.js"></script>
  <script src="/js/developr.table.js"></script>

  <!-- Must be loaded last -->
  <script src="/js/libs/jquery.tablesorter.min.js"></script>
  <script src="/js/libs/DataTables/jquery.dataTables.min.js"></script>
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
  });


    // on fait apparaitre la boite de login lors du clic sur une photo
    $('#users li').live('click', function() {
        $('#users li').removeClass('active');
        $(this).addClass('active');
        $('#lg-overlay').fadeIn(400, function () {
            $('#quick-input').focus();
        });
    });
    // on fait disparaitre le modal lors d'un clic
    $('#lg-overlay').live('click', function(e) {
        if ($(e.target).is('#quick-lg, #quick-lg *')) {
            return;
        }
        $(this).fadeOut(300);
    });

    $('#lg-form').live('submit', function(e) {
        $('#field span').html('<img src="/image/new_login/img/spinner-sm.gif">');
        var pswlgt = $('#quick-input').val().length;
        if (pswlgt < 1) {
            e.preventDefault();
            $('#placeholder').text('Entrez votre mot de passe');
            $('#field span').fadeOut(200, function () {
                $(this).text('X').css('color', '#e56969').fadeIn(100);
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
                            $('#field span').fadeOut(200, function () {
                                $('#field span').text('=').css('color', '#9fbf2f').fadeIn(100)
                            });
                            document.location.href = '<?php echo url_for('@homepage') ?>';
                        } else {
                            $('#field').removeClass('success').addClass('error');
                            $('#field span').text('X').css('color', '#e56969').fadeIn(100);
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