<style>body, html { overflow:hidden; }</style>
<div class="pane">
        <div class="page-header">
                <h1>Create Quests</h1>
        </div>
	<?=form_open(current_url(), 'class="form-horizontal"')?>
                <?=bootstrap_input('name', 'Name')?>
                <?=bootstrap_input('verbiage', 'Quest Text')?>
                <?=bootstrap_input('giver', 'Quest Giver')?>
                <?=bootstrap_input('turnin', 'Quest Turnin')?>
                <?=bootstrap_input('monetary_reward', 'Monetary Reward')?>
                <?=bootstrap_input('item_reward', 'Item Reward')?>
                <?=bootstrap_input('experience', 'Experience')?>
                <div class="form-actions">
                        <?=bootstrap_submit('submit', 'Create Quest', 'class="btn btn-primary"')?>
                        <a href="<?=base_url('editor/quests')?>" class="btn">Cancel</a>
                </div>
        <?=form_close()?>
</div>

