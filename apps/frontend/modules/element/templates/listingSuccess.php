<?php use_helper('Thumb'); ?>
<noscript class="message black-gradient simpler">
	Your browser does not support JavaScript! Some features won't work as expected...
</noscript>

<div class="with-padding">

	<button onclick="editRow('element')" class="button right-side mid-margin-bottom green-gradient">New</button>


	<table class="table responsive-table" id="sorting-advanced">

		<thead>
			<tr>
				<th scope="col" >Nom</th>
				<th scope="col" width="15%" class="">Stock</th>
				<th scope="col" width="15%" class="  hide-on-mobile">Conditionnement</th>
				<th scope="col" width="10%" class=" hide-on-mobile">Stock minimum</th>
				<th scope="col" width="10%" class=" hide-on-mobile">Prix achat</th>
				<th scope="col" width="15%" class=" hide-on-mobile">Catégorie</th>
				<th scope="col" width="70" class="">Editer</th>
				<th scope="col" width="70" class=" hide-on-mobile">Supprimer</th>

			</tr>
		</thead>

		<tfoot>

		</tfoot>

		<tbody>
			<?php foreach($elements as $element): ?>
			<tr id="element-<?php echo $element->getId() ?>"<?php if($element->getStockActuel() < $element->getStockMinimum()) echo "style ='color:#F7F7F7; background-color:#E9383F'" ?>>
				<td><?php echo $element->getName() ?></td>
				<td><?php echo $element->getStockActuel(); ?></span></td>
				<td class="  hide-on-mobile"><?php echo $element->getConditionnement(); ?></td>
				<td class=" hide-on-mobile"><?php if($element->getStockMinimum() > 0): ?> <span class="tag orange-bg"><?php echo $element->getStockMinimum() ?><?php endif; ?></td>
				<td class=" hide-on-mobile"><?php echo $element->getPrixAchat() ?> €</td>
				<td class=" hide-on-mobile"><small class="tag"><?php echo $element->getCategory() ?></small></td>
				<td class="low-padding "><button onclick="editRow('element', <?php echo $element->getId() ?>)" class="button compact icon-gear">Edit</button></td>
				<td class="hide-on-mobile low-padding "><button onclick="deleteRow('element', <?php echo $element->getId() ?>, 'delete')" class="button compact icon-gear">Delete</button></td>
			</tr>
			<?php endforeach; ?>
		</tbody>

	</table>

</div>
<script>
$(document).ready(function() {
	var options = {'pagination' : -1 };
	dataTableInit('sorting-advanced', options);
});
</script>