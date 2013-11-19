<!-- template pour afficher les commandes Live -->
<script type="text/template" id="commandeLive">
<% _.each(commandesLive, function (commande, i) { %>
	<% if (commande.statut_id == 2) {
		var color = "green-bg";
	}
	else if(commande.statut_id == 1){
		var color = "red-bg";
	}
	else if(commande.statut_id == 4){
		var color = "orange-bg";
	}
	else if(commande.statut_id == 3){
		var color = "blue-bg";
	}
	%>
	<div id="commandeLive-<%= commande.id %>"
	<?php if($sf_user->isAuthenticated() && $sf_user->hasCredential('serveur')): ?>
	onclick="getArticlesCommande(<%= commande.id %>)"
	<?php endif; ?>
	class="navigable-ajax <%= color %> big-message">
	<%= commande.serverPrenom %> <%= commande.serverNom %>
	<span class="float-right">Table : <%= commande.table_id %></span></div>
<% }); %>
</script>