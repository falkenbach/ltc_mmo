<div class="pane">
	<div class="page-header">
		<h1>Edit Ring</h1>
	</div>
	<?=form_open(current_url(), 'class="form-horizontal"')?>
		<legend>Basics</legend>
		<?=bootstrap_input('name', 'Name',$rings->name)?>
		<?=bootstrap_input('description', 'Description',$rings->description)?>
		<?=bootstrap_input('level', 'Level',$rings->level)?>
		<?=bootstrap_input('defense', 'Defense',$rings->defense)?>
		<?=bootstrap_dropdown('classes', 'Classes',$classes)?>
		<?=bootstrap_input('body_location','Body Location',$rings->body_location)?>
		<?=bootstrap_input('image', 'Image',$rings->image)?>
		<legend>Attribute Points</legend>
		<?php 
			$rings_attributes = json_decode($rings->attributes, true);
			foreach($attributes as $attr){ 
		?>
			<?=bootstrap_input(strtolower($attr->acronym), $attr->name.' +', $rings_attributes[strtolower($attr->acronym)])?>
		<?php } ?>
		<div class="form-actions">
			<?=bootstrap_submit('submit', 'Update Ring', 'class="btn btn-primary"')?>
			<a href="<?=base_url('editor/items/rings')?>" class="btn">Cancel</a>
		</div>
	<?=form_close()?>
</div>