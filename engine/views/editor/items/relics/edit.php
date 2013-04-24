<div class="pane">
	<div class="page-header">
		<h1>Edit Relic</h1>
	</div>
	<?=form_open(current_url(), 'class="form-horizontal"')?>
		<legend>Basics</legend>
		<?=bootstrap_input('name', 'Name',$relics->name)?>
		<?=bootstrap_input('description', 'Description',$relics->description)?>
		<?=bootstrap_input('level', 'Level',$relics->level)?>
		<?=bootstrap_input('damage', 'Damage',$relics->damage)?>
		<?=bootstrap_input('defense', 'Defense',$relics->defense)?>
		<?=bootstrap_dropdown('classes', 'Classes',$classes)?>
		<?=bootstrap_input('body_location','Body Location',$relics->body_location)?>
		<?=bootstrap_input('image', 'Image',$relics->image)?>
		<legend>Bonus Attribute Points</legend>
		<?php 
			$relics_attributes = json_decode($relics->attributes, true);
			foreach($attributes as $attr){ 
		?>
			<?=bootstrap_input(strtolower($attr->acronym), $attr->name.' +', $relics_attributes[strtolower($attr->acronym)])?>
		<?php } ?>
		<div class="form-actions">
			<?=bootstrap_submit('submit', 'Update Relic', 'class="btn btn-primary"')?>
			<a href="<?=base_url('editor/items/relics')?>" class="btn">Cancel</a>
		</div>
	<?=form_close()?>
</div>