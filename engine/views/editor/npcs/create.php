<style>body, html { overflow:hidden; }</style>
<div class="pane">
        <div class="page-header">
                <h1>Create Npcs</h1>
        </div>
	<?=form_open(current_url(), 'class="form-horizontal"')?>
                <?=bootstrap_input('name', 'Name')?>
                <?=bootstrap_input('verbiage', 'NPC Text')?>
                <?=bootstrap_input('location', 'NPC Location')?>
                <div class="form-actions">
                        <?=bootstrap_submit('submit', 'Create NPC', 'class="btn btn-primary"')?>
                        <a href="<?=base_url('editor/npcs')?>" class="btn">Cancel</a>
                </div>
        <?=form_close()?>
</div>

