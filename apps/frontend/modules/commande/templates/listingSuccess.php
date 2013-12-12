<?php use_helper('Date'); ?> 
<hgroup id="main-title" class="thin">
	<h1>Liste des commandes</h1>
</hgroup>

<div class="with-padding">


<?php
// il faut au moins les droits serveurs pour imprimer plusieurs commandes
if($sf_user->isAuthenticated() && $sf_user->hasCredential('serveur')): ?>
<button onclick="imprimerCommandes()" class="button mid-margin-right mid-margin-bottom">
    <span class="green-gradient button-icon"><span class="icon-printer"></span></span>
    Imprimer les commandes sélectionnées
</button>
<button onclick="cloturer()" class="button mid-margin-right mid-margin-bottom">
    <span class="green-gradient button-icon"><span class="icon-drawer"></span></span>
    Cloturer la caisse
</button>
<?php endif; ?>

	<table class="gestion-commande-table table responsive-table" id="sorting-advanced">

		<thead>
			<tr>
				<th scope="col" width="5%"></th>
				<th scope="col" width="20%" class="hide-on-mobile">Nom du serveur</th>
				<th scope="col" width="20%" >Nom du client</th>
				<th scope="col" width="15%" class="align-center hide-on-mobile">Date</th>
				<th scope="col" width="10%" class="align-center">Status</th>
				<th scope="col" width="10%" class="align-center">Numéro de table</th>
				<th scope="col" width="10%" class="hide-on-mobile">Montant</th>
				<?php if($sf_user->isAuthenticated() && $sf_user->hasCredential('manager')): ?>
				<th scope="col" width="100" class="align-right">Actions</th>
				<?php endif; ?>
			</tr>
		</thead>

		<tbody>
			<?php foreach($commandes as $commande): ?>
			<tr id="article-<?php echo $commande->getId() ?>">
				<th scope="row" class="checkbox-cell">
				<input type="checkbox" name="checked[]" value="<?php echo $commande->getId() ?>">
				</th>
				<td><?php echo $commande->getServer() ?></td>
				<td><?php echo $commande->getClient() ?></td>
				<td><?php echo format_date($commande->getCreatedAt(), 'dd-MM-yyyy HH:mm'); ?> </td>
				<td>
				<?php
				if($commande->getStatutId() == 1) {
					echo '<small class="tag red-bg">A payer</small>'; 
				}
				else if ($commande ->getStatutId() == 2) {
					echo '<small class="tag green-bg">Payée</small>';
				}
				else if($commande ->getStatutId() == 5){
					echo '<small class="tag blue-bg">Offerte</small>';
				}
				else if($commande ->getStatutId() == 3){
					echo '<small class="tag orange-bg">En préparation</small>';
				}
				else if($commande ->getStatutId() == 4){
					echo '<small class="tag white-bg">Prête</small>';
				}
				?>

				
				</td>
				<td><?php echo $commande->getTableId() ?></td>
				<td><?php echo $commande->getTotalCommande() ?> €</td>
				<?php if($sf_user->isAuthenticated() && $sf_user->hasCredential('manager')): ?>
				<td class="low-padding align-center"><button onclick="setStatutCommande(<?php echo $commande->getId() ?>, 5); return('false');" class="button compact icon-gear">Offrir</button></td>
				<?php endif; ?>
			</tr>

			<?php endforeach; ?>

		</tbody>

	</table>
	<?php if($sf_user->isAuthenticated() && $sf_user->hasCredential('manager')): ?>
	<table class="table responsive-table" id="sorting-advanced2">
		<thead>
			<tr>
				<th scope="col"></th>
				<th scope="col" width="20%" class="hide-on-mobile">Nom du serveur</th>
				<th scope="col" width="15%" class="align-center hide-on-mobile">Date</th>
				<th scope="col" width="15%" class="align-center">Cash</th>
				<th scope="col" width="10%" class="align-center">Ecb</th>
				<th scope="col" width="15%" class="align-centere">Cb</th>
				<th scope="col" width="15%" class="align-centere">Record</th>
				<th scope="col" width="15%" class="align-centere">Détenteur</th>

			</tr>
		</thead>
		<br />
		<tbody>
			<?php foreach($clotures as $cloture): ?>
			<tr id="cloture-<?php echo $commande->getId() ?>">
				<th scope="row" class="checkbox-cell">
				<input type="checkbox" name="checked[]" value="<?php echo $commande->getId() ?>">
				</th>
				<td><?php echo $cloture->getServerCloture() ?></td>
				<td><?php echo format_date($cloture->getCreatedAt(), 'dd-MM-yyyy HH:mm'); ?> </td>
				<td><?php echo $cloture->getTotalTransactionCash() ?></td>
				<td><?php echo $cloture->getTotalTransactionEcb() ?></td>
				<td><?php echo $cloture->getTotalTransactionCb() ?></td>
				<td><?php echo $cloture->getTotalRecord() ?></td>
				<td><?php echo $cloture->getServerRecord() ?></td>
			</tr>

			<?php endforeach; ?>

		</tbody>

	</table>
<?php endif; ?>
</div>
<script>
$(document).ready(function() {
	dataTableInit('sorting-advanced');
	dataTableInit('sorting-advanced2');

	$('.gestion-commande-table').tablesorter({}).on('click', 'tbody td', function(event) {
	// Do not process if something else has been clicked
	if (event.target !== this) {
		return;
	}
	var tr = $(this).parent(), row = tr.next('.row-drop'), rows;
	var id = tr.find('input').val();
	// If click on a special row
	if (tr.hasClass('row-drop')) {
		return;
	}
	// If there is already a special row
	if (row.length > 0) {
		// Un-style row
		tr.children().removeClass('anthracite-gradient glossy');
		// Remove row
		row.remove();
		return;
	}
	// Remove existing special rows
	rows = tr.siblings('.row-drop');
	if (rows.length > 0) {
		// Un-style previous rows
		rows.prev().children().removeClass('anthracite-gradient glossy');
		// Remove rows
		rows.remove();
	}

	var article = '';
	$.getJSON('/get/commande/id/' + id + '.json', function(data) {
		$.each(data['articles'], function(key1, val) {
			var supplement ='';
			$.each(val['supplements'], function(key2, supp) {
				supp.prix = parseFloat(supp.fois_prix) * parseFloat(val.prix) - parseFloat(val.prix) + parseFloat(supp.plus_prix);
				supplement += '--' + supp.name + ' : ' + supp.prix.toFixed(2) + ' €<br>' ;
			});

			article += '<strong> ' + val['count'] + '</strong> <small class="tag">' + val['name'] + '</small> X ' + val['prix'] + '€<br/>' + supplement;
		});
		// Style row
		tr.children().addClass('anthracite-gradient glossy');
		// Add fake row
		var new_row = $('<tr class="row-drop" id="row-drop-' + id + '">' + '<td colspan="' + tr.children().length + '">' + '<div class="float-right">' + '<button onclick="deleteCommande(\'commande\',' + id + ')" type="submit" class="button glossy">' + '<span class="button-icon red-gradient"><span class="icon-cross"></span></span>' + 'Supprimer' + '</button>' + '</div>' + article + '</td>' + '</tr>');
		new_row.insertAfter(tr);
	});

}); 
	
	
});
</script>
