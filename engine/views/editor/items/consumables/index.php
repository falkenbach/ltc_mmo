<div class="pane">
	<div class="page-header">
		<a href="<?=base_url('editor/items/consumables/create')?>" class="btn pull-right">Create Consumable</a>
		<a href="javascript:$('.info').slideToggle();" class="btn btn-info pull-right"><i class="icon-white icon-info-sign" style="margin-top:3px;"></i> Toggle Info</a>
		<h1>All Consumables</h1>
		<p class="info" style="display:none;">Consumables are your health potions, mana potions, antidotes, etc...</p>
	</div>
	<table class="table">
		<thead>
			<tr>
				<th>Name</th>
				<th>Description</th>
				<th>Modified Amount</th>
			</tr>
		</thead>
		<tbody>
		<?php 
			foreach ($consumables as $consumable): 
		?>
			<tr>
				<td><?=$consumable->name?></td>
				<td><?=$consumable->description?></td>
				<td><?=$consumable->modified_amount?></td>
				<td>
					<a href="<?=base_url('editor/items/consumables/edit/'.$consumable->id)?>"><i class="icon-pencil"></i></a>
					<a href="<?=base_url('editor/items/consumables/delete/'.$consumable->id)?>"><i class="icon-trash"></i></a>
				</td>
			</tr>
		<?php endforeach; ?>
		</tbody>
	</table>
</div>