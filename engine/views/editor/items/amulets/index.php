<div class="pane">
	<div class="page-header">
		<a href="<?=base_url('editor/items/amulets/create')?>" class="btn pull-right">Create Amulet</a>
		<h1>All Amulets</h1>
		<p class="info" style="display:none;">In Afterlite amulets main goal is to provide stat boosts.  They also provide small amounts of armor.</p>
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
		<?php foreach ($amulets as $amulet): ?>
			<tr>
				<td><?=$amulet->name?></td>
				<td><?=$amulet->description?></td>
				<td><?=$amulet->attributes?></td>
				<td>
					<a href="<?=base_url('editor/items/amulets/edit/'.$amulet->id)?>"><i class="icon-pencil"></i></a>
					<a href="<?=base_url('editor/items/amulets/delete/'.$amulet->id)?>"><i class="icon-trash"></i></a>
				</td>
			</tr>
		<?php endforeach; ?>
		</tbody>
	</table>
</div>