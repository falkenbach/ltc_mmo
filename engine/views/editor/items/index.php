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
			//foreach ($items as $item): 
		?>
			<tr>
				<td><?=//$item->name?></td>
				<td><?=//$item->level?></td>
				<td><?=//$item->damage?></td>
				<td><?=//$item->defense?></td>
				<td><?=//$item->modified_amount?></td>
				<td><?=//$item->attributes?></td>
				<td><?=//$item->classes?></td>
				<td><?=//$item->stackable?></td>
				<td><?=//$item->cast_time?></td>
				<td><?=//($item->active) ? anchor(base_url('editor/items/deactivate/'.$item->id), 'Active') : anchor(base_url('editor/items/activate/'.$item->id), 'Inactive'); ?></td>
				<td>
					<a href="<?=base_url('editor/items/edit/'.$item->id)?>"><i class="icon-pencil"></i></a>
					<a href="<?=base_url('editor/items/delete/'.$item->id)?>"><i class="icon-trash"></i></a>
				</td>
			</tr>
		<?php endforeach; ?>
		</tbody>
	</table>
</div>