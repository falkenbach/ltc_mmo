<style>body, html { overflow:hidden; }</style>
<div class="pane">
        <div class="page-header">
                <a href="<?=base_url('editor/npc/create')?>" class="btn pull-right">Create NPC</a>
                <h1>All NPCs</h1>
        </div>
        <table class="table">
                <thead>
                        <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Text</th>
                                <th>Location</th>
                        </tr>
                </thead>
                <tbody>
                <?php
                        foreach ($npcs as $npc):
		?>
			<tr>
				<td><?=$quest->id?></td>
				<td><?=$quest->name?></td>
				<td><?=$quest->text?></td>
				<td><?=$quest->location?></td>
				<td>
					<a href="<?=base_url('editor/npcs/edit/'.$npc->id)?>"><i class="icon-pencil"></i></a>
                                        <a href="<?=base_url('editor/npcs/delete/'.$npc->id)?>"><i class="icon-trash"></i></a>
				</td>
			</tr>
		<?php endforeach; ?>
		</tbody>
	</table>
</div>

