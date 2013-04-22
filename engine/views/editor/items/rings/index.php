<div class="pane">
	<div class="page-header">
		<a href="<?=base_url('editor/items/rings/create')?>" class="btn pull-right">Create Ring</a>
		<h1>All Ring</h1>
	</div>
	<table class="table">
		<thead>
			<tr>
				<th>Name</th>
				<th>Description</th>
				<th>Attributes</th>
				<th>Actions</th>
			</tr>
		</thead>
		<tbody>
		<?php foreach ($rings as $ring): ?>
			<tr>
				<td><?=$ring->name?></td>
				<td><?=$ring->description?></td>
				<td><?=$ring->attributes?></td>
				<td>
					<a href="<?=base_url('editor/items/rings/edit/'.$ring->id)?>"><i class="icon-pencil"></i></a>
					<a href="<?=base_url('editor/items/rings/delete/'.$ring->id)?>"><i class="icon-trash"></i></a>
				</td>
			</tr>
		<?php endforeach; ?>
		</tbody>
	</table>
</div>