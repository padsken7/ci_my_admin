<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Панель администратора</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">


    <!-- Le styles -->
	<link href="/b/css/bootstrap.min.css" rel="stylesheet">
	<link href="/b/css/admin.css" rel="stylesheet">
	
	<style>
	body {
		padding-top: 60px;
	}
	</style>

    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
	
	
  </head>

  <body>
	<div class="navbar navbar-fixed-top">
		<div class="navbar-inner">
			<div class="container">
				<a class="brand" href="/admin/panel">Панель администратора</a>
				<?php if($is_admin): ?>
				<?php if(!isset($table_name_show)) $table_name_show=''; ?>
				<?php $this->admin->create_show_links($table_name_show); ?>
				<ul class="nav pull-right">
					<li><a href="<?=base_url()?>">На сайт</a></li>
					<?php echo $is_admin ? '<li class="pull-left"><a href="/admin/panel/logout">Выйти</a></li>' : ''; ?>
				</ul>
				<?php endif; ?>
			</div>
		</div>
	</div>