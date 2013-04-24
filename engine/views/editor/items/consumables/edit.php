<div class="pane">
	<div class="page-header">
		<h1>Edit Consumable</h1>
	</div>
	<?=form_open(current_url(), 'class="form-horizontal"')?>
		<legend>Basics</legend>
		<?=bootstrap_input('name', 'Name',$consumables->name)?>
		<?=bootstrap_input('description', 'Description',$consumables->description)?>
		<?=bootstrap_input('level', 'Level',$consumables->level)?>
		<?=bootstrap_input('modified_amount', 'Modified Amount',$consumables->modified_amount)?>
		<?=bootstrap_dropdown('classes', 'Classes',$classes)?>
		<?=bootstrap_input('stackable', 'Stackable',$consumables->stackable)?>
		<?=bootstrap_input('image', 'Image',$consumables->image)?>
		<?=bootstrap_input('cast_time', 'Cast Time',$consumables->cast_time)?>
		<div class="form-actions">
			<?=bootstrap_submit('submit', 'Update Consumable', 'class="btn btn-primary"')?>
			<a href="<?=base_url('editor/items/consumables')?>" class="btn">Cancel</a>
		</div>
	<?=form_close()?>
</div>