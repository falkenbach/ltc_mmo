<style>body, html { overflow:hidden; }</style>
<div class="pane">
        <div class="page-header">
                <h1>Create Ability</h1>
        </div>
	<?=form_open(current_url(), 'class="form-horizontal"')?>
                <?=bootstrap_input('name', 'Name')?>
                <?=bootstrap_input('class', 'Class')?>
                <?=bootstrap_input('damage', 'Damage')?>
                <?=bootstrap_input('heal', 'Heal')?>
                <?=bootstrap_input('modifier', 'Modifier')?>
                <?=bootstrap_input('cast_time', 'Cast Time')?>
                <div class="form-actions">
                        <?=bootstrap_submit('submit', 'Create Ability', 'class="btn btn-primary"')?>
                        <a href="<?=base_url('editor/abilities')?>" class="btn">Cancel</a>
                </div>
        <?=form_close()?>
</div>

