<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title><?=$settings['game_title']?> <?=$settings['version']?> </title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="">
		<meta name="author" content="<?=$settings['site_name']?>">
		<!-- Stylesheets -->
		<link href="<?=base_url('public/css/bootstrap.css')?>" rel="stylesheet">
		<link href="<?=base_url('public/css/bootstrap-responsive.css')?>" rel="stylesheet">
		<link href="<?=base_url('public/css/auth.css')?>" rel="stylesheet">
		<!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
		<!--[if lt IE 9]>
		<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
		<!-- Javascript -->
		<script type="text/javascript" src="<?=base_url('public/js/jquery.js')?>"></script>
		<script type="text/javascript" src="<?=base_url('public/js/jquery-ui.js')?>"></script>
		<script type="text/javascript" src="<?=base_url('public/js/bootstrap.min.js')?>"></script>
	</head>
	
	<body>
		<h2>Success!</h2>
		<p>You are now in the Users area.</p>
		<?=$yield?>
	</body>
</html>