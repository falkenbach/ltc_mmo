<style>body, html { overflow:hidden; }</style>
<div class="pane">
        <div class="page-header">
                <a href="<?=base_url('editor/npcs/create')?>" class="btn pull-right">Create NPC</a>
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
				<td><?=$npc->id?></td>
				<td><?=$npc->name?></td>
				<td><?=$npc->verbiage?></td>
				<td><?=$npc->location?></td>
				<td>
					<a href="<?=base_url('editor/npcs/edit/'.$npc->id)?>"><i class="icon-pencil"></i></a>
                                        <a href="<?=base_url('editor/npcs/delete/'.$npc->id)?>"><i class="icon-trash"></i></a>
				</td>
			</tr>
		<?php endforeach; ?>
		</tbody>
	</table>
</div>

