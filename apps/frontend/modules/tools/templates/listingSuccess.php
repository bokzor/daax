<?php use_helper('Thumb'); ?>


<hgroup id="main-title" class="thin">
	<h1>Liste des categories</h1>
</hgroup>

<div class="with-padding">
	<button onclick="editRow('category')" class="button right-side mid-margin-bottom green-gradient">New</button>
	<table class="table responsive-table" id="sorting-advanced">
		<thead>
			<tr>
				<th scope="col" >Nom</th>
				<th scope="col" width="80" class="align-center hide-on-mobile">Editer</th>
				<th scope="col" width="80" class="align-center hide-on-mobile">Supprimer</th>
			</tr>
		</thead>
		<tfoot>
		</tfoot>
		<tbody>
			<?php foreach($categories as $category): ?>
			<tr id="category-<?php echo $category->getId() ?>">
				<td><?php echo str_repeat('&nbsp;', ($category -> getLevel() * 4)); echo $category->getName() ?></td>				
				<td class="low-padding align-center"><a href="#" onclick="editRow('category', <?php echo $category->getId() ?>); return false;" class="button compact icon-gear">Edit</a></td>
				<td class="low-padding align-center"><a href="#" onclick="deleteRow('category', <?php echo $category->getId() ?>, 'delete'); return false;" class="button compact icon-gear">Delete</a></td>
			</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
</div>

<hgroup id="main-title" class="thin">
	<h1>Liste des fournisseurs</h1>
</hgroup>
<div class="with-padding">
	<button onclick="editRow('fournisseur')" class="button right-side mid-margin-bottom green-gradient">New</button>
	<table class="table responsive-table" id="sorting-advanced2">
		<thead>
			<tr>
				<th scope="col" >Nom</th>
				<th scope="col" >Téléphone</th>
				<th scope="col" width="80" class="align-center hide-on-mobile">Editer</th>
				<th scope="col" width="80" class="align-center hide-on-mobile">Supprimer</th>
			</tr>
		</thead>
		<tfoot>
		</tfoot>
		<tbody>
			<?php foreach($fournisseurs as $fournisseur): ?>
			<tr id="fournisseur-<?php echo $fournisseur->getId() ?>">
				<td><?php echo $fournisseur->getName() ?></td>
				<td><?php echo $fournisseur->getTel() ?></td>				

				<td class="low-padding align-center"><a href="#" onclick="editRow('fournisseur', <?php echo $fournisseur->getId() ?>); return false;" class="button compact icon-gear">Edit</a></td>
				<td class="low-padding align-center"><a href="#" onclick="deleteRow('fournisseur', <?php echo $fournisseur->getId() ?>, 'delete'); return false;" class="button compact icon-gear">Delete</a></td>
			</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
</div>


<hgroup id="main-title" class="thin">
	<h1>Liste des supplements</h1>
</hgroup>
<div class="with-padding">
	<button onclick="editRow('supplement')" class="button right-side mid-margin-bottom green-gradient">New</button>
	<table class="table responsive-table" id="sorting-advanced3">
		<thead>
			<tr>
				<th scope="col" >Nom</th>
				<th scope="col" width="80" class="align-center hide-on-mobile">Editer</th>
				<th scope="col" width="80" class="align-center hide-on-mobile">Supprimer</th>
			</tr>
		</thead>
		<tfoot>
		</tfoot>
		<tbody>
			<?php foreach($supplements as $supplement): ?>
			<tr id="supplement-<?php echo $supplement->getId() ?>">
				<td><?php echo $supplement->getName() ?></td>				
				<td class="low-padding align-center"><a href="#" onclick="editRow('supplement', <?php echo $supplement->getId() ?>); return false;" class="button compact icon-gear">Edit</a></td>
				<td class="low-padding align-center"><a href="#" onclick="deleteRow('supplement', <?php echo $supplement->getId(); ?>, 'delete'); return false; " class="button compact icon-gear">Delete</a></td>
			</tr>
			<?php endforeach; ?>
		</tbody>

	</table>

</div>


<hgroup id="main-title" class="thin">
	<h1>Liste des imprimantes</h1>
</hgroup>
<div class="with-padding">
	<button onclick="editRow('imprimante')" class="button right-side mid-margin-bottom green-gradient">New</button>
	<table class="table responsive-table" id="sorting-advanced4">
		<thead>
			<tr>
				<th scope="col" >Nom</th>
				<th scope="col" width="80" class="align-center hide-on-mobile">Editer</th>
				<th scope="col" width="80" class="align-center hide-on-mobile">Supprimer</th>
			</tr>
		</thead>
		<tfoot>
		</tfoot>
		<tbody>
			<?php foreach($imprimantes as $imprimante): ?>
			<tr id="imprimante-<?php echo $imprimante->getId() ?>">
				<td><?php echo $imprimante->getName() ?></td>				
				<td class="low-padding align-center"><a href="#" onclick="editRow('imprimante', <?php echo $imprimante->getId() ?>); return false;" class="button compact icon-gear">Edit</a></td>
				<td class="low-padding align-center"><a href="#" onclick="deleteRow('imprimante', <?php echo $imprimante->getId() ?>, 'delete'); return false;" class="button compact icon-gear">Delete</a></td>
			</tr>
			<?php endforeach; ?>
		</tbody>

	</table>

</div>

<script>
$(document).ready(function() {
	dataTableInit('sorting-advanced');
	dataTableInit('sorting-advanced2');
	dataTableInit('sorting-advanced3');
	dataTableInit('sorting-advanced4');

});
</script>