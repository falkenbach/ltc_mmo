<div class="pane">
	<div class="page-header">
		<h1>Edit Weapon</h1>
	</div>
	<?=form_open(current_url(), 'class="form-horizontal"')?>
		<legend>Basics</legend>
		<?=bootstrap_input('name', 'Name', $weapon->name)?>
		<?=bootstrap_input('description', 'Description', $weapon->description)?>
		<?=bootstrap_dropdown('class', 'Class', $classes, $weapon->class)?>
		<?=bootstrap_input('level', 'Level Required', $weapon->level)?>
		<legend>Bonus Attribute Points</legend>
		<?php 
			$ability_attributes = json_decode($weapon->attributes, true);
			foreach($attributes as $attr){ 
		?>
			<?=bootstrap_input(strtolower($attr->acronym), $attr->name.' +', $ability_attributes[strtolower($attr->acronym)])?>
		<?php } ?>
		<div class="form-actions">
			<?=bootstrap_submit('submit', 'Update Ability', 'class="btn btn-primary"')?>
			<a href="<?=base_url('editor/items/weapons')?>" class="btn">Cancel</a>
		</div>
	<?=form_close()?>
</div>