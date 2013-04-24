<div class="pane">
	<div class="page-header">
		<h1>Edit Weapon</h1>
	</div>
	<?=form_open(current_url(), 'class="form-horizontal"')?>
		<legend>Basics</legend>
		<?=bootstrap_input('name', 'Name',$weapons->name)?>
		<?=bootstrap_input('description', 'Description',$weapons->description)?>
		<?=bootstrap_input('level', 'Level',$weapons->level)?>
		<?=bootstrap_input('damage', 'Damage',$weapons->damage)?>
		<?=bootstrap_dropdown('classes', 'Classes',$classes)?>
		<?=bootstrap_input('body_location','Body Location',$weapons->body_location)?>
		<?=bootstrap_input('stackable', 'Stackable',$weapons->stackable)?>
		<?=bootstrap_input('image', 'Image',$weapons->image)?>
		<?=bootstrap_input('cast_time', 'Cast Time',$weapons->cast_time)?>
		<legend>Bonus Attribute Points</legend>
		<?php 
			$weapons_attributes = json_decode($weapons->attributes, true);
			foreach($attributes as $attr){ 
		?>
			<?=bootstrap_input(strtolower($attr->acronym), $attr->name.' +', $weapons_attributes[strtolower($attr->acronym)])?>
		<?php } ?>
		<div class="form-actions">
			<?=bootstrap_submit('submit', 'Update Weapon', 'class="btn btn-primary"')?>
			<a href="<?=base_url('editor/items/weapons')?>" class="btn">Cancel</a>
		</div>
	<?=form_close()?>
</div>