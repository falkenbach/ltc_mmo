<div class="pane">
	<div class="page-header">
		<h1>All Items</h1>
	</div>
	<table class="table">
		<thead>
			<tr>
				<th>Name</th>
				<th>Level</th>
				<th>Damage</th>
				<th>Defense</th>
				<th>Modified Amount</th>
				<th>Attributes</th>
				<th>Classes</th>
				<th>Stackable</th>
				<th>Cast Time</th>
			</tr>
		</thead>
		<tbody>
		<?php 
			foreach ($items as $item): 
		?>
			<tr>
				<td><?=$item->name?></td>
				<td><?=$item->level?></td>
				<td><?=$item->damage?></td>
				<td><?=$item->defense?></td>
				<td><?=$item->modified_amount?></td>
				<td><?=$item->attributes?></td>
				<td><?=$item->classes?></td>
				<td><?=$item->stackable?></td>
				<td><?=$item->cast_time?></td>
				<td>
					<a href="<?=base_url('editor/characters/edit/'.$character->id)?>"><i class="icon-pencil"></i></a>
					<a href="<?=base_url('editor/characters/delete/'.$character->id)?>"><i class="icon-trash"></i></a>
				</td>
			</tr>
		<?php endforeach; ?>
		</tbody>
	</table>
</div>