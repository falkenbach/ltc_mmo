<div class="pane">
	<div class="page-header">
		<a href="<?=base_url('editor/items/relics/create')?>" class="btn pull-right">Create Relic</a>
		<a href="javascript:$('.info').slideToggle();" class="btn btn-info pull-right"><i class="icon-white icon-info-sign" style="margin-top:3px;"></i> Toggle Info</a>
		<h1>All Relic</h1>
		<p class="info" style="display:none;">Relics in Afterlite are mainly for attribute boosts.</p>
	</div>
	<table class="table">
		<thead>
			<tr>
				<th>Name</th>
				<th>Description</th>
				<th>Attributes</th>
			</tr>
		</thead>
		<tbody>
		<?php 
			foreach ($relics as $relic): 
		?>
			<tr>
				<td><?=$relic->name?></td>
				<td><?=$relic->description?></td>
				<td><?=$power->attributes?></td>
				<td>
					<a href="<?=base_url('editor/items/relics/edit/'.$relic->id)?>"><i class="icon-pencil"></i></a>
					<a href="<?=base_url('editor/items/relics/delete/'.$relic->id)?>"><i class="icon-trash"></i></a>
				</td>
			</tr>
		<?php endforeach; ?>
		</tbody>
	</table>
</div>