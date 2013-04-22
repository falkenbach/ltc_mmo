<div class="pane">
	<div class="page-header">
		<h1>Create Ring</h1>
	</div>
	<?=form_open(current_url(), 'class="form-horizontal"')?>
		<?=bootstrap_input('name', 'Name')?>
		<?=bootstrap_input('description', 'Description')?>
		<?=bootstrap_input('level', 'Level')?>
		<?=bootstrap_input('defense', 'Defense')?>
		<?=bootstrap_dropdown('classes', 'Classes',$classes)?>
		<?=bootstrap_input('body_location','Body Location')?>
		<?=bootstrap_input('image', 'Image')?>
		<legend>Attribute Points</legend>
		<?php foreach($attributes as $attr){ ?>
			<?=bootstrap_input(strtolower($attr->acronym), $attr->name.' +')?>
		<?php } ?>
		<div class="form-actions">
			<?=bootstrap_submit('submit', 'Create Item', 'class="btn btn-primary"')?>
			<a href="<?=base_url('editor/items/rings')?>" class="btn">Cancel</a>
		</div>
	<?=form_close()?>
</div>