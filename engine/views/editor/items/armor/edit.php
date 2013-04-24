<div class="pane">
	<div class="page-header">
		<h1>Edit Aptitude</h1>
	</div>
	<?=form_open(current_url(), 'class="form-horizontal"')?>
		<legend>Basics</legend>
		<?=bootstrap_input('name', 'Name',$armor->name)?>
		<?=bootstrap_input('description', 'Description',$armor->description)?>
		<?=bootstrap_input('level', 'Level',$armor->level)?>
		<?=bootstrap_input('defense', 'Defense',$armor->defense)?>
		<?=bootstrap_dropdown('classes', 'Classes',$classes)?>
		<?=bootstrap_input('body_location','Body Location',$armor->body_location?>
		<?=bootstrap_input('image', 'Image',$armor->image)?>
		<legend>Bonus Attribute Points</legend>
		<?php 
			$armor_attributes = json_decode($armor->attributes, true);
			foreach($attributes as $attr){ 
		?>
			<?=bootstrap_input(strtolower($attr->acronym), $attr->name.' +', $armor_attributes[strtolower($attr->acronym)])?>
		<?php } ?>
		<div class="form-actions">
			<?=bootstrap_submit('submit', 'Update Armor', 'class="btn btn-primary"')?>
			<a href="<?=base_url('editor/items/armor')?>" class="btn">Cancel</a>
		</div>
	<?=form_close()?>
</div>