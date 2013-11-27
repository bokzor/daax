<?php use_helper('Thumb'); ?>
<noscript class="message black-gradient simpler">
	Your browser does not support JavaScript! Some features won't work as expected...
</noscript>


<div class="with-padding">

	<button onclick="editRow('article')" class="button right-side mid-margin-bottom green-gradient">New</button>


	<table class="table responsive-table" id="sorting-advanced">

		<thead>
			<tr>
				<th scope="col" width=30>Image</th>
				<th scope="col" >Nom</th>
				<th scope="col" width="10%" class="align-center ">Prix</th>
				<th scope="col" width="10%" class="align-center hide-on-mobile">Temps préparation</th>
				<th scope="col" width="15%" class="align-center hide-on-mobile">Catégorie</th>
				<th scope="col" width="70" class="align-center ">Editer</th>
				<th scope="col" width="70" class="align-center hide-on-mobile">Supprimer</th>

			</tr>
		</thead>

		<tfoot>

		</tfoot>

		<tbody>
			<?php foreach($articles as $article): ?>
			<tr id="article-<?php echo $article->getId() ?>">
				<td><?php echo showThumb($article->getImg(), 'articles', $options = array('alt' => 'Affiche de '.$article->getName().'', 'class' => 'framed', 'width' => '40', 'height' => '40','title' => ''.$article->getName().''), $resize = 'fit', $default = 'default.jpg') ?></td>
				<td><?php echo $article->getName() ?></td>				
				<td><?php echo $article->getPrix() ?> €</td>
				<td class="hide-on-mobile"><?php echo $article->getTempsPrepa() ?></td>
				<td class="hide-on-mobile"><small class="tag"><?php echo $article->getCategory() ?></small></td>
				<td class="low-padding align-center"><button onclick="editRow('article', <?php echo $article->getId() ?>)" class="button compact icon-gear">Edit</button></td>
				<td class="hide-on-mobile low-padding align-center"><button onclick="deleteRow('article', <?php echo $article->getId() ?>, 'delete')" class="button compact icon-gear">Delete</button></td>
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