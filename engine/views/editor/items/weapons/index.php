<div class="pane">
	<div class="page-header">
		<a href="<?=base_url('editor/items/weapon/create')?>" class="btn pull-right">Create Weapon</a>
		<a href="javascript:$('.info').slideToggle();" class="btn btn-info pull-right"><i class="icon-white icon-info-sign" style="margin-top:3px;"></i> Toggle Info</a>
		<h1>All Weapon</h1>
		<p class="info" style="display:none;">Weapons do damage.  Different classes can use different weapons.</p>
	</div>
	<table class="table">
		<thead>
			<tr>
				<th>Name</th>
				<th>Description</th>
				<th>Level</th>
				<th>Damage</th>
				<th>Body Location </th>
				<th>Attributes</th>
			</tr>
		</thead>
		<tbody>
		<?php 
			foreach ($weapons as $weapon): 
		?>
			<tr>
				<td><?=$weapon->name?></td>
				<td><?=$weapon->description?></td>
				<td><?=$weapon->level?></td>
				<td><?=$weapon->damage?></td>
				<td><?=$weapon->body_location?></td>
				<td><?=$weapon->attributes?></td>
				<td>
					<a href="<?=base_url('editor/items/weapons/edit/'.$weapon->id)?>"><i class="icon-pencil"></i></a>
					<a href="<?=base_url('editor/items/weapons/delete/'.$weapon->id)?>"><i class="icon-trash"></i></a>
				</td>
			</tr>
		<?php endforeach; ?>
		</tbody>
	</table>
</div>