<!--<div class="align-center"><span class="align-center button-group">
	<?php $i=0; foreach($imprimantes as $imprimante): ?>
		<label for="<?php echo $imprimante->getSlug() ?>" class=" <?php if($i==0) echo 'active';?> button green-active">
			<input type="radio" name="radio-buttons" <?php if($i==0) echo 'selected';?> id="<?php echo $imprimante->getSlug() ?>" value="<?php echo $imprimante->getId() ?>">
			<?php echo $imprimante->getDescription(); $i++; ?>
		</label>
	<?php endforeach; ?>
</span>
</div>
-->
<div id="totalCommandeFullLiveContainer" class="">

</div>
<div id="commandeFullLiveContainer" class="margin-bottom">

</div>

<script>
// fonction qui met a jour la liste des commandes en cours

function majFullLive() {
	var commande;
	//var printer = $('label.active').find('input').val();
	//var url = "/live/" + printer +".json";
	var url = "/live.json";
	$.getJSON(url, function(data) {
		
	    app.collections.commandeFullLive.reset();
	    app.collections.totalCommandeFullLive.reset();
	    if(data['commande'] != undefined){
	    	$('#totalCommandeFullLiveContainer').show();
		    for (var i = 0; i < data['commande'].length; i++) {
				var commande = {
				    id: data['commande'][i]['id'],
				    serverPrenom: data['commande'][i]['serverPrenom'],
				    serverNom: data['commande'][i]['serverNom'],
				    table_id: data['commande'][i]['table_id'],
				    clientNom: data['commande'][i]['clientNom'],
				    clientPrenom: data['commande'][i]['clientPrenom'],
				    statut_commande: data['commande'][i]['statut_commande'],
				    statut_id: data['commande'][i]['statut_id'],
				    articles: data['commande'][i]['ArticleCommandes'],
				    comment: data['commande'][i]['comment'],
				}
				if (app.collections.commandeFullLive.get(data['commande'][i]['id']) == undefined) {
				    app.collections.commandeFullLive.add(commande);
				}
		    }
		}
		else{
			$('#totalCommandeFullLiveContainer').hide();
		}
	    if(data['total'] != undefined){
		    for (var i = 0; i < data['total'].length; i++) {
				var commande = {
				    id: data['total'][i]['id'],
				    count: data['total'][i]['count'],
				    name: data['total'][i]['name'],
				};
				if (app.collections.totalCommandeFullLive.get(data['total'][i]['id']) == undefined) {
				    app.collections.totalCommandeFullLive.add(commande);

				}
		    }
		}
	});
}

$(document).ready(function() {
	new app.Views.commandeFullLive({el : $('#commandeFullLiveContainer'), collection : app.collections.commandeFullLive});
	new app.Views.totalCommandeFullLive({el : $('#totalCommandeFullLiveContainer'), collection : app.collections.totalCommandeFullLive});
	majFullLive();
    majFullLive = setInterval(majFullLive, 3000);
    console.log('ok');
});
</script>