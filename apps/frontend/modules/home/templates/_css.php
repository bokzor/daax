<!-- For all browsers -->
<link rel="stylesheet" href="/css/reset.css">
<link rel="stylesheet" href="/css/style.css">
<link rel="stylesheet" href="/css/colors.css">

<link rel="stylesheet" media="print" href="/css/print.css">

<link rel="stylesheet" href="/js/libs/DataTables/jquery.dataTables.css">
<!-- <link rel="stylesheet" href="/css/optimized.css"> -->


<link rel="stylesheet" media="only all and (min-width: 480px)" href="/css/480.css">
<link rel="stylesheet" media="only all and (min-width: 768px)" href="/css/768.css">
<link rel="stylesheet" media="only all and (min-width: 992px)" href="/css/992.css">
<link rel="stylesheet" media="only all and (min-width: 1200px)" href="/css/1200.css">
<link rel="stylesheet" media="only all and (-webkit-min-device-pixel-ratio: 1.5), only screen and (-o-min-device-pixel-ratio: 3/2), only screen and (min-device-pixel-ratio: 1.5)" href="/css/2x.css">
<link rel="stylesheet" href="/css/styles/dashboard.css">
<link rel="stylesheet" href="/css/jquery.keypad.css">
<link rel="stylesheet" href="/css/styles/jqpagination.css">
<link rel="stylesheet" href="/css/styles/form.css">
<link rel="stylesheet" href="/css/styles/switches.css">
<link rel="stylesheet" href="/css/styles/table.css">
<link rel="stylesheet" href="/css/styles/modal.css">
<link rel="stylesheet" href="/css/timepicker.css">
<link rel="stylesheet" href="/css/mobiscroll.css">
<link rel="stylesheet" href="/css/slidemenu/jquery.sidr.dark.css">
<link rel="stylesheet" href="/css/new_login/core.css">
<link rel="stylesheet" href="/js/libs/DataTables/jquery.dataTables.css">
<link rel="stylesheet" href="/css/libs/backbones/backgrid-filter.css">
<link rel="stylesheet" href="/css/libs/backbones/backgrid-paginator.min.css">
<link rel="stylesheet" href="/css/libs/backbones/backgrid.min.css">

	<!-- feuille de style pour les clients -->
<?php if($sf_user->isAuthenticated() && !$sf_user->hasCredential('manager')): ?>
<link rel="stylesheet" href="/css/client.css">
<?php endif; ?>