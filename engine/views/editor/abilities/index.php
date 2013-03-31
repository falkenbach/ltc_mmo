<style>body, html { overflow:hidden; }</style>
<div class="pane">
        <div class="page-header">
                <a href="<?=base_url('editor/abilities/create')?>" class="btn pull-right">Create Ability</a>
                <h1>All Abilities</h1>
        </div>
        <table class="table">
                <thead>
                        <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Class</th>
                                <th>Damage</th>
                                <th>Heal</th>
                                <th>Modifier</th>
                                <th>Cast Time</th>
                                <th>Action</th>
                        </tr>
                </thead>
                <tbody>
                <?php
                        foreach ($abilities as $ability):
		?>
			<tr>
				<td><?=$ability->id?></td>
				<td><?=$ability->name?></td>
				<td><?=$ability->class?></td>
				<td><?=$ability->damage?></td>
				<td><?=$ability->heal?></td>
				<td><?=$ability->modifier?></td>
				<td><?=$ability->cast_time?></td>
				<td>
					<a href="<?=base_url('editor/abilities/edit/'.$ability->id)?>"><i class="icon-pencil"></i></a>
                                        <a href="<?=base_url('editor/abilities/delete/'.$ability->id)?>"><i class="icon-trash"></i></a>
				</td>
			</tr>
		<?php endforeach; ?>
		</tbody>
	</table>
</div>

