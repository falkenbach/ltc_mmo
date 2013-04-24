<div class="pane">
	<div class="page-header">
		<h1>Edit Amulets</h1>
	</div>
	<?=form_open(current_url(), 'class="form-horizontal"')?>
		<legend>Basics</legend>
		<?=bootstrap_input('name', 'Name', $amulets->name)?>
		<?=bootstrap_input('description', 'Description', $amulets->description)?>
		<?=bootstrap_input('level', 'Level',$amulets->level)?>
		<?=bootstrap_input('defense', 'Defense',$amulets->defense)?>
		<?=bootstrap_dropdown('classes', 'Classes',$classes)?>
		<?=bootstrap_input('body_location','Body Location',$amulets->body_location)?>
		<?=bootstrap_input('image', 'Image',$amulets->image)?>
		<legend>Attribute Points</legend>
		<?php
			$amulets_attributes = json_decode($amulets->attributes, true);
			foreach($attributes as $attr)
		{ ?>
			<?=bootstrap_input(strtolower($attr->acronym), $attr->name.' +', $amulets_attributes[strtolower($attr->acronym)])?>
		<?php } ?>
		<div class="form-actions">
			<?=bootstrap_submit('submit', 'Update Class', 'class="btn btn-primary"')?>
			<a href="<?=base_url('editor/items/amulets')?>" class="btn">Cancel</a>
		</div>
	<?=form_close()?>
</div>