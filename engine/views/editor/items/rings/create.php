<div class="pane">
	<div class="page-header">
		<h1>Create Ring</h1>
	</div>
	<?=form_open(current_url(), 'class="form-horizontal"')?>
		<?=bootstrap_input('name', 'Name')?>
		<?=bootstrap_input('level', 'Level')?>
		<?=bootstrap_input('damage', 'Damage')?>
		<?=bootstrap_input('defense', 'Defense')?>
		<?=bootstrap_input('modified_amount', 'Modified Amount')?>
		<?=bootstrap_input('attributes', 'Attributes')?>
		<?=bootstrap_dropdown('classes', 'Classes',$classes)?>
		<?=bootstrap_input('body_location','Body Location'?>
		<?=bootstrap_input('stackable', 'Stackable')?>
		<?=bootstrap_input('cast_time', 'Cast Time')?>
		<div class="form-actions">
			<?=bootstrap_submit('submit', 'Create Item', 'class="btn btn-primary"')?>
			<a href="<?=base_url('editor/items')?>" class="btn">Cancel</a>
		</div>
	<?=form_close()?>
</div>