<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>Cloudrealms Editor v3</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="">
		<meta name="author" content="Ronald A. Richardson">
		<!-- Stylesheets -->
		<link href="<?=base_url()?>public/css/bootstrap.css" rel="stylesheet">
		<link href="<?=base_url()?>public/css/editor.css" rel="stylesheet">
		<link href="<?=base_url()?>public/css/bootstrap-responsive.css" rel="stylesheet">
		<link href="<?=base_url()?>public/css/uploader.css" rel="stylesheet">
		<!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
		<!--[if lt IE 9]>
		<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
		<!-- Javascript -->
		<script type="text/javascript" src="<?=base_url('public/js/jquery.js')?>"></script>
		<script type="text/javascript" src="<?=base_url('public/js/jquery-ui.min.js')?>"></script>
		<script type="text/javascript" src="<?=base_url('public/js/jquery.dataTables.min.js')?>"></script>
		<script type="text/javascript" src="<?=base_url('public/js/dataTables.bootstrap.js')?>"></script>
		<script type="text/javascript" src="<?=base_url('public/js/bootstrap.min.js')?>"></script>
		<script type="text/javascript" src="<?=base_url('public/js/map_editor.js')?>"></script>
		<script type="text/javascript" src="<?=base_url('public/js/uploader.js')?>"></script>
		<script>
		$(document).ready(function() {
			$('table').dataTable( {
				"sDom": "<'row-fluid'<'span6'l><'span6'f>r>t<'row-fluid'<'span6'i><'span6'p>>",
				"sPaginationType": "bootstrap",
				"iDisplayLength": 5,
				"oLanguage": {
					"sLengthMenu": "_MENU_ records per page"
				}
			} );
			$.extend( $.fn.dataTableExt.oStdClasses, {
				"sWrapper": "dataTables_wrapper form-inline"
			} );
		});
		</script>
	</head>
	
	<body>
	<div class="navbar navbar-fixed-top" style="z-index:99999999999999999;">
		<div class="navbar-inner">
			<div class="container" style="width:1300px;">
				<a class="brand" href="#">cloudrealms v3 editor</a>
				<div class="nav-collapse">
					<ul class="nav">
						<li <?php if($page==''||$page=='dashboard'){ ?> class="active" <? } ?> id="dashboard"><a href="<?=base_url('editor')?>">Home</a></li>
						<?php if($page=='map'){ ?>
						<li class="dropdown active" id="map_editor">
							<a class="dropdown-toggle" data-toggle="dropdown" href="<?=base_url('editor/map')?>">Map Editor<b class="caret"></b></a>
							<ul class="dropdown-menu" style="z-index:999999;position:absolute;">
								<?php if($page=='map'){ ?>
								<li><a style="cursor:pointer;" onclick="location_properties();">Location Properties</a></li>
								<li><a style="cursor:pointer;" onclick="display_map();">Display Map</a></li>
								<li><a style="cursor:pointer;" onclick="ground_layer();">Ground Layer</a></li>
								<li><a style="cursor:pointer;" onclick="environment_layer();">Environment Layer</a></li>
								<li class="divider"></li>
								<li><a style="cursor:pointer;" onclick="open_tiles();">Tiles</a></li>
								<li><a style="cursor:pointer;" onclick="open_objects();">Objects</a></li>
								<li><a style="cursor:pointer;" onclick="open_monsters();">Monsters</a></li>
								<li><a style="cursor:pointer;" onclick="open_characters();">Characters</a></li>
								<li><a style="cursor:pointer;" onclick="open_characters();">NPCs</a></li>
								<li class="divider"></li>
								<li><a style="cursor:pointer;" href="#" id="initialize_map" class="drop_down_item">Initialize Map</a></li>
								<li><a style="cursor:pointer;" href="<?=base_url('editor/map/delete/'.$this->uri->segment(4))?>">Delete Location</a></li>
								<li><a style="cursor:pointer;" href="<?=base_url('editor/map')?>">Exit</a></li>
								<?php } ?>
							</ul>
						</li>
						<?php } else { ?>
						<li <?php if($page=='map'){ ?> class="active" <? } ?> id="map_editor"><a href="<?=base_url('editor/map')?>">Map Editor</a></li>
						<?php } ?>
						<li <?php if($page=='world_map'){ ?> class="active" <? } ?> id="locations"><a href="<?=base_url('editor/world_map')?>">World Map</a></li>
						<li <?php if($page=='items'){ ?> class="active" <? } ?> id="items"><a href="<?=base_url('editor/items')?>">Items</a></li>
						<li <?php if($page=='creatures'){ ?> class="active" <? } ?> id="creatures"><a href="<?=base_url('editor/creatures')?>">Creatures</a></li>
						<li <?php if($page=='quests'){ ?> class="active" <? } ?> id="quests"><a href="<?=base_url('editor/quests')?>">Quests</a></li>
						<li <?php if($page=='npcs'){ ?> class="active" <? } ?> id="npcs"><a href="<?=base_url('editor/npcs')?>">NPCs</a></li>
						<li <?php if($page=='characters'){ ?> class="active" <? } ?> id="characters"><a href="<?=base_url('editor/characters')?>">Characters</a></li>
						<li <?php if($page=='resources'){ ?> class="active" <? } ?> id="resources"><a href="<?=base_url('editor/resources')?>">Resources</a></li>
						<li class="divider-vertical"></li>
						<li <?php if($page=='app'){ ?> class="dropdown active" <? } else { ?>class="dropdown"<?php } ?> id="app">
							<a class="dropdown-toggle" data-toggle="dropdown" href="<?=base_url('editor/app')?>">App<b class="caret"></b></a>
							<ul class="dropdown-menu" style="z-index:999999;position:absolute;">
								<li><a style="cursor:pointer;" href="<?=base_url('editor/options')?>">Options</a></li>
								<li><a style="cursor:pointer;" href="<?=base_url('editor/permissions')?>">Permissions</a></li>
								<li><a style="cursor:pointer;" href="<?=base_url('editor/players')?>">Players</a></li>
								<li><a style="cursor:pointer;" href="<?=base_url('editor/groups')?>">Groups</a></li>
								<li><a style="cursor:pointer;" href="<?=base_url('editor/ui')?>">User Interface</a></li>
							</ul>
						</li>
						<li><a href="<?=base_url()?>">World</a></li>
						<li><a href="<?=base_url('auth/logout')?>">Logout</a></li>
					</ul>
				</div>
			</div>
		</div>
	</div>
	<div class="container">
		<?php 
		if ( ! empty($folder_name))
		{
			if (file_exists(APPPATH.'views/editor/'.$folder_name.'/subnav.php'))
			{
				echo '<div class="subnav"><ul class="nav nav-pills">';
				$this->load->view('editor/'.$folder_name.'/subnav.php', true);
				echo '</ul></div>';
			}
		}
		?>
		<?php echo showflashmsg(); ?>
		<?=$yield?>
	</div> <!-- /container -->
	</body>
</html>
<div id="notif" class="alert">
	<a class="close" onclick="close_notif();" data-dismiss="alert"><i class="icon-remove"></i></a>
	<strong id="notif-subject"></strong> <span id="notif-body"></span>
</div>
