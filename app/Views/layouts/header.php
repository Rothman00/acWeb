<!DOCTYPE html>
<html lang="en">
<head>
	
	<meta charset="utf-8">
	<meta name="description" content="SAC">
	<meta name="keyword" content="">
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SAC</title>
 
    <!-- start: Css -->
     <link rel="stylesheet" type="text/css" href="<?php echo base_Url()?>/asset/css/bootstrap.min.css">

      <!-- plugins -->
      <link rel="stylesheet" type="text/css" href="<?php echo base_Url()?>/asset/css/plugins/font-awesome.min.css"/>
      <link rel="stylesheet" type="text/css" href="<?php echo base_Url()?>/asset/css/plugins/simple-line-icons.css"/>
      <link rel="stylesheet" type="text/css" href="<?php echo base_Url()?>/asset/css/plugins/animate.min.css"/>
      <link rel="stylesheet" type="text/css" href="<?php echo base_Url()?>/asset/css/plugins/nouislider.min.css" />
      <link rel="stylesheet" type="text/css" href="<?php echo base_Url()?>/asset/css/plugins/fullcalendar.min.css"/>
      <link rel="stylesheet" type="text/css" href="<?php echo base_Url()?>/asset/css/plugins/select2.min.css" />
      <link rel="stylesheet" type="text/css" href="<?php echo base_Url()?>/asset/css/plugins/dropzone.css"/>
      <link rel="stylesheet" type="text/css" href="<?php echo base_Url()?>/asset/css/plugins/ionrangeslider/ion.rangeSlider.css" />
      <link rel="stylesheet" type="text/css" href="<?php echo base_Url()?>/asset/css/plugins/ionrangeslider/ion.rangeSlider.skinFlat.css" />
      <link rel="stylesheet" type="text/css" href="<?php echo base_Url()?>/asset/css/plugins/bootstrap-material-datetimepicker.css" />
	    <link rel="stylesheet" href="<?php echo base_Url()?>/asset/css/style.css">
     <script src="<?php echo base_Url()?>/asset/js/firebase.js"></script>
	  <!-- end: Css -->
    <!--Declarar hora y fecha de Ecuador-->
    <?php setlocale(LC_TIME, 'es_ES.UTF-8');?>  

	<link rel="shortcut icon" href="<?php echo base_Url()?>/asset/img/megaprofer.png">
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

 <body id="mimin" class="dashboard">
  <script src="https://www.gstatic.com/firebasejs/8.6.3/firebase-app.js"></script>
  <script src="https://www.gstatic.com/firebasejs/8.6.3/firebase-analytics.js"></script>
  <script src="https://www.gstatic.com/firebasejs/8.6.3/firebase-database.js"></script>
  <script src="https://www.gstatic.com/firebasejs/8.6.3/firebase-storage.js"></script>
  <script>
    iniciarF();
  </script>

      <!-- start: Header -->
        <nav class="navbar navbar-default header navbar-fixed-top">
          <div class="col-md-12 nav-wrapper">
            <div class="navbar-header" style="width:100%;">
              <div class="opener-left-menu is-open">
                <span class="top"></span>
                <span class="middle"></span>
                <span class="bottom"></span>
              </div>
              <a href="<?php echo base_Url()?>" class="navbar-brand"> 
                <b>SAC</b>
              </a>
               
              <ul class="nav navbar-nav navbar-right user-nav">
                <li class="user-name"><span><?php echo $usuario->USU_NOMBRES?></span></li>
                <li class="dropdown avatar-dropdown">
                    <img src="<?php echo base_Url()?>/asset/img/avatar.jpg" class="img-circle avatar" alt="user name" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"/>
                    <ul class="dropdown-menu user-dropdown">
                        <li><a href=""><span class="fa fa-user"></span> Mi Perfil</a></li>
                        <li><a href="<?php echo base_Url()?>/finSesion"><span class="fa fa-power-off "></span> Cerrar Sesión</a></li>
                        <li role="separator" class="divider"></li>
                        
                    </ul>
                </li>
                <li><a></a></li>
              </ul>
            </div>
          </div>
        </nav>
      <!-- end: Header -->