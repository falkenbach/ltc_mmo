<style>body, html { overflow:hidden; }</style>
<div class="pane">
        <div class="page-header">
                <a href="<?=base_url('editor/creatures/create')?>" class="btn pull-right">Create Quest</a>
                <h1>All Creatures</h1>
        </div>
        <table class="table">
                <thead>
                        <tr>
                                <th>ID</th>
                                <th>HP</th>
                                <th>Mana</th>
                                <th>Experience</th>
                                <th>Monetary Reward</th>
                                <th>Item Reward</th>
                                <th>Location</th>
				<th>Actions</th>
                        </tr>
                </thead>
                <tbody>
                <?php
                        foreach ($creatures as $creature):
		?>
			<tr>
				<td><?=$creature->id?></td>
				<td><?=$creature->hp?></td>
				<td><?=$creature->mana?></td>
				<td><?=$creature->experience?></td>
				<td><?=$creature->monetary_reward?></td>
				<td><?=$creature->item_reward?></td>
				<td><?=$creature->location?></td>
				<td>
					<a href="<?=base_url('editor/creatures/edit/'.$creature->id)?>"><i class="icon-pencil"></i></a>
                                        <a href="<?=base_url('editor/creatures/delete/'.$creature->id)?>"><i class="icon-trash"></i></a>
				</td>
			</tr>
		<?php endforeach; ?>
		</tbody>
	</table>
</div>

