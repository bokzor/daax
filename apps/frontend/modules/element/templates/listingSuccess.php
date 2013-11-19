<?php use_helper('Thumb'); ?>
<noscript class="message black-gradient simpler">
	Your browser does not support JavaScript! Some features won't work as expected...
</noscript>

<div class="with-padding">

	<button onclick="editRow('element')" class="button right-side mid-margin-bottom green-gradient">New</button>


	<table class="table responsive-table" id="sorting-advanced">

		<thead>
			<tr>
				<th scope="col" width=30>Image</th>
				<th scope="col" >Nom</th>
				<th scope="col" width="15%" class="">Stock</th>
				<th scope="col" width="15%" class="  hide-on-mobile">Conditionnement</th>
				<th scope="col" width="10%" class=" hide-on-mobile">Stock minimum</th>
				<th scope="col" width="10%" class=" ">Prix achat</th>
				<th scope="col" width="15%" class=" hide-on-mobile">Catégorie</th>
				<th scope="col" width="70" class=" hide-on-mobile">Editer</th>
				<th scope="col" width="70" class=" hide-on-mobile">Supprimer</th>

			</tr>
		</thead>

		<tfoot>

		</tfoot>

		<tbody>
			<?php foreach($elements as $element): ?>
			<tr id="element-<?php echo $element->getId() ?>"<?php if($element->getStockActuel() < $element->getStockMinimum()) echo "style ='color:#F7F7F7; background-color:#E9383F'" ?>>
				<td><?php echo showThumb($element->getImg(), 'elements', $options = array('alt' => 'Affiche de '.$element->getName().'', 'class' => 'framed', 'width' => '40', 'height' => '40','title' => ''.$element->getName().''), $resize = 'fit', $default = 'default.jpg') ?></td>
				<td><?php echo $element->getName() ?></td>
				<td><?php echo $element->getStockActuel(); ?></span></td>
				<td><?php echo $element->getConditionnement(); ?></td>
				<td><?php if($element->getStockMinimum() > 0): ?> <span class="tag orange-bg"><?php echo $element->getStockMinimum() ?><?php endif; ?></td>
				<td><?php echo $element->getPrixAchat() ?> €</td>
				<td><small class="tag"><?php echo $element->getCategory() ?></small></td>
				<td class="low-padding "><a href="#" onclick="editRow('element', <?php echo $element->getId() ?>)" class="button compact icon-gear">Edit</a></td>
				<td class="low-padding "><a href="#" onclick="deleteRow('element', <?php echo $element->getId() ?>, 'delete')" class="button compact icon-gear">Delete</a></td>
			</tr>
			<?php endforeach; ?>
		</tbody>

	</table>

</div>
<script>
$(document).ready(function() {
	dataTableInit('sorting-advanced');
});
</script>