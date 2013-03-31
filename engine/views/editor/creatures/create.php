<style>body, html { overflow:hidden; }</style>
<div class="pane">
        <div class="page-header">
                <h1>Create Creature</h1>
        </div>
	<?=form_open(current_url(), 'class="form-horizontal"')?>
                <?=bootstrap_input('name', 'Name')?>
                <?=bootstrap_input('hp', 'HP')?>
                <?=bootstrap_input('mana', 'Mana')?>
                <?=bootstrap_input('experience', 'Experience')?>
                <?=bootstrap_input('monetary_reward', 'Monetary Reward')?>
                <?=bootstrap_input('item_reward', 'Item Reward')?>
                <?=bootstrap_input('location', 'Location')?>
                <div class="form-actions">
                        <?=bootstrap_submit('submit', 'Create Creature', 'class="btn btn-primary"')?>
                        <a href="<?=base_url('editor/creatures')?>" class="btn">Cancel</a>
                </div>
        <?=form_close()?>
</div>

