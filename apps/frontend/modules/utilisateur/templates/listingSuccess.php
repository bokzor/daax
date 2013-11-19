<?php use_helper('Thumb'); ?>
<noscript class="message black-gradient simpler">
	Your browser does not support JavaScript! Some features won't work as expected...
</noscript>

<hgroup id="main-title" class="thin">
	<h1>Liste des utilisateurs</h1>
</hgroup>

<div class="with-padding">

	<button onclick="editRow('utilisateur')" class="button right-side mid-margin-bottom green-gradient">New</button>

	<table class="table responsive-table" id="sorting-advanced">

		<thead>
			<tr>

				<th scope="col" width=30>Image</th>
				<th scope="col" class="hide-on-mobile-portrait">Username</th>
				<th scope="col" width="15%" class="align-center">Nom</th>
				<th scope="col" width="15%" class="align-center hide-on-mobile-portrait">Prénom</th>
				<th scope="col" width="15%" class="align-center hide-on-mobile-portrait">Tel</th>
				<th scope="col" width="15%" class="align-center hide-on-mobile-portrait">Permissions</th>
				<th scope="col" width="70" class="align-center">Editer</th>
				<th scope="col" width="70" class="align-center">Supprimer</th>

			</tr>
		</thead>

		<tfoot>

		</tfoot>

		<tbody>
			<?php foreach($utilisateurs as $utilisateur): ?>
			<tr id="utilisateur-<?php echo $utilisateur->getId() ?>">
				<?php //$group = $utilisateur->getGroups()->toArray() ?>
				<td><?php echo showThumb($utilisateur->getAvatar(), 'avatar', $options = array('alt' => 'Avatar de '.$utilisateur->getUsername().'', 'class' => 'framed', 'width' => '40', 'height' => '40','title' => ''.$utilisateur->getUsername().''), $resize = 'fit', $default = 'default.png') ?></td>
				<td><?php echo $utilisateur->getUsername() ?></td>
				<td><?php echo $utilisateur->getFirstName() ?></td>
				<td><?php echo $utilisateur->getLastName() ?></td>
				<td><?php echo $utilisateur->getTel() ?></td>
				<td><?php foreach($utilisateur->getGroups() as $group) echo "$group<br />";  ?></td>
				<td class="low-padding align-center"><a href="#" onclick="editRow('utilisateur', <?php echo $utilisateur->getId() ?>)" class="button compact icon-gear">Edit</a></td>
				<td class="low-padding align-center"><a href="#" onclick="deleteRow('utilisateur', <?php echo $utilisateur->getId() ?>, 'delete')" class="button compact icon-gear">Delete</a></td>			</tr>
			<?php endforeach; ?>
		</tbody>

	</table>

</div>
<script>
$(document).ready(function() {
	dataTableInit('sorting-advanced');
});
</script>