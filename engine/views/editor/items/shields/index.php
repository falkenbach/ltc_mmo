<div class="pane">
	<div class="page-header">
		<a href="<?=base_url('editor/items/shields/create')?>" class="btn pull-right">Create Shield</a>
		<h1>All Shields</h1>
	</div>
	<table class="table">
		<thead>
			<tr>
				<th>Name</th>
				<th>Level</th>
				<th>Description</th>
				<th>Actions</th>
			</tr>
		</thead>
		<tbody>
		<?php foreach ($shields as $shield): ?>
			<tr>
				<td><?=$shield->name?></td>
				<td><?=$shield->acronym?></td>
				<td><?=$shield->description?></td>
				<td>
					<a href="<?=base_url('editor/items/shields/edit/'.$shield->id)?>"><i class="icon-pencil"></i></a>
					<a href="<?=base_url('editor/items/shields/delete/'.$shield->id)?>"><i class="icon-trash"></i></a>
				</td>
			</tr>
		<?php endforeach; ?>
		</tbody>
	</table>
</div>