<style>body, html { overflow:hidden; }</style>
<div class="pane">
        <div class="page-header">
                <a href="<?=base_url('editor/quests/create')?>" class="btn pull-right">Create Quest</a>
                <h1>All Quests</h1>
        </div>
        <table class="table">
                <thead>
                        <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Giver</th>
                                <th>Turnin</th>
                                <th>Monetary Reward</th>
                                <th>Item Reward</th>
                                <th>Experience</th>
				<th>Actions</th>
                        </tr>
                </thead>
                <tbody>
                <?php
                        foreach ($quests as $quest):
		?>
			<tr>
				<td><?=$quest->id?></td>
				<td><?=$quest->name?></td>
				<td><?=$quest->giver?></td>
				<td><?=$quest->turnin?></td>
				<td><?=$quest->monetary_reward?></td>
				<td><?=$quest->item_reward?></td>
				<td><?=$quest->experience?></td>
				<td>
					<a href="<?=base_url('editor/quests/edit/'.$quest->id)?>"><i class="icon-pencil"></i></a>
                                        <a href="<?=base_url('editor/quests/delete/'.$quest->id)?>"><i class="icon-trash"></i></a>
				</td>
			</tr>
		<?php endforeach; ?>
		</tbody>
	</table>
</div>

