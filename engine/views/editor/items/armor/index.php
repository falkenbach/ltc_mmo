<div class="pane">
	<div class="page-header">
		<a href="<?=base_url('editor/items/armor/create')?>" class="btn pull-right">Create Armor</a>
		<a href="javascript:$('.info').slideToggle();" class="btn btn-info pull-right"><i class="icon-white icon-info-sign" style="margin-top:3px;"></i> Toggle Info</a>
		<h1>All Armor</h1>
		<p class="info" style="display:none;">In Afterlite armor provides a character its main source of defense.</p>
	</div>
	<table class="table">
		<thead>
			<tr>
				<th>Name</th>
				<th>Description</th>
				<th>Level</th>
				<th>Defense</th>
				<th>Body Location</th>
			</tr>
		</thead>
		<tbody>
		<?php 
			foreach ($armor as $a): 
		?>
			<tr>
				<td><?=$a->name?></td>
				<td><?=$a->description?></td>
				<td><?=$a->level?></td>
				<td><?=$a->defense?></td>
				<td><?=$a->body_location?></td>
				<td>
					<a href="<?=base_url('editor/characters/aptitudes/edit/'.$a->id)?>"><i class="icon-pencil"></i></a>
					<a href="<?=base_url('editor/characters/aptitudes/delete/'.$a->id)?>"><i class="icon-trash"></i></a>
				</td>
			</tr>
		<?php endforeach; ?>
		</tbody>
	</table>
</div>