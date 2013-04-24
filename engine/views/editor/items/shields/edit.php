<div class="pane">
	<div class="page-header">
		<h1>Edit Shield</h1>
	</div>
	<?=form_open(current_url(), 'class="form-horizontal"')?>
		<?=bootstrap_input('name', 'Name',$shields->name)?>
		<?=bootstrap_input('description', 'Description',$shields->description)?>
		<?=bootstrap_input('level', 'Level',$shields->level)?>
		<?=bootstrap_input('defense', 'Defense',$shields->defense)?>
		<?=bootstrap_dropdown('classes', 'Classes',$classes)?>
		<?=bootstrap_input('body_location','Body Location',$shields->body_location)?>
		<?=bootstrap_input('image', 'Image',$shields->image)?>
		<div class="form-actions">
			<?=bootstrap_submit('submit', 'Update Shield', 'class="btn btn-primary"')?>
			<a href="<?=base_url('editor/items/shields')?>" class="btn">Cancel</a>
		</div>
	<?=form_close()?>
</div>