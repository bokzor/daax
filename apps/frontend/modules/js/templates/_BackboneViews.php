<!-- template pour afficher les articles de la commande en cours -->
<script type="text/template" id="actualOrder">
	<% _.each(commande, function (article, i) { %>
	<div id="article-<%= article.htmlId %>"  class="message" style="display: block; ">
	<% if(article.comment != undefined && article.comment != ''){
		var color = 'red';
		}
		else{
		var color = '';
		}
	%>
	<div><a href="#" class="icon-chat <%= color %>" onclick="Commentaire('<%= article.htmlId %>')"><%= article.name.substring(0,20) %></a>
		<span class="list-count">
		<span class="prix-boisson"><%= article.prix %></span></span>
		<% if (article.count>1) { %>
			<span class="count left"><%= article.count %></span>
		<%} %>	
	</div>

	<% _.each(article.supplements, function (supplement, key, i) { %>
	<% var prix = parseFloat(supplement.fois_prix) * parseFloat(article.prix) - parseFloat(article.prix) + parseFloat(supplement.plus_prix);

	 %>
	<div>--- <%= supplement.name.substring(0,15) %>
		<span class="list-count">
		<span class="prix-boisson"><%= prix.toFixed(2) %></span></span>
	</div>
	<% }); %>
	<span onclick="deleteArticleCommande('<%= article.htmlId %>')" class="close-article">X</span>		
	</div>

	<% }); %>
</script>

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
		var color = "green-bg";
	}
	else if(commande.statut_id == 3){
		var color = "blue-bg";
	}
	%>
	<div id="commandeLive-<%= commande.id %>"
	<?php if($sf_user->isAuthenticated() && $sf_user->hasCredential('serveur')): ?>
	onclick="getArticlesCommande(<%= commande.id %>)"
	<?php endif; ?>
	class="navigable-ajax big-message">
	<span class="tiny ribbon">
	<span class="<%= color %> ribbon-inner"></span>
	</span>
	<%= commande.serverPrenom %> <%= commande.serverNom %>
	<span class="float-right">Table : <%= commande.table_id %></span></div>
<% }); %>
</script>

<script type="text/template" id="commandeFullLive">
<% _.each(commandesLive, function (commande, i) { %>
	<% if (commande.statut_id == 2) {
		var color = "green-bg";
	}
	else if(commande.statut_id == 1){
		var color = "red-bg";
	}
	else if(commande.statut_id == 4){
		var color = "green-bg";
	}
	else if(commande.statut_id == 3){
		var color = "blue-bg";
	}

	%>
	
	
	<p id="commandeFullLive-<%= commande.id %>" class="thin no-margin-bottom big-text wrapped relative" style="border:2px solid; border-color:#33393d; display: block; ">
		<span class="ribbon">
			<span class="<%= color %> ribbon-inner">Table : <%= commande.table_id %></span>
		</span>
		<span style="display:block; margin-bottom:10px; width:100%; height: 50px;" class="background-beau-gris">
			<span class="margin-left" style="float:left;">
				Serveur : <%= commande.serverPrenom %> <%= commande.serverNom %> <br>
				Client : <%= commande.clientPrenom %> <%= commande.clientNom %>
			</span>
			<span style="margin-right: 65px; float:right;">
				
			</span>
		</span>
		<span class="with-mid-padding" style="display: table;">
		<% _.each(commande.articles, function (article, i) { %>

			<% if (article.count == 1) {
				var color = "green-bg";
			}
			else if(article.count >= 4){
				var color = "red-bg";
			}
			else if(article.count == 3){
				var color = "orange-bg";
			}
			else if(article.count == 2){
				var color = "blue-bg";
			}

			%>
			  <span style="" id='articleCommande-<%= article.article_id %>-<%= article.commande_id %>'>
			  		<span class="tag <%= color %> small-margin-right">
			  			<%= article.count %>
			  		</span> x <span class=""><%= article.name %></span>
					<%  _.each(article.supplements, function (supplement, key, i) { %>
			  			<span> -> <%= supplement.name %></span>
			  		<% }); %>
			  </span>  |
		<% }); %>
		</span>
		<br>
		<span style="display: block;" class="align-center">
			<span onclick="jsonCommande(<%= commande.id %>, '');" class=" button huge">Encaisser</span>
			<span onclick="setStatutCommande(<%= commande.id %>, 4);" class="button huge">Prête</span>
		</span>
	</p>
<% }); %>		
</script>

<script type="text/template" id="totalCommandeFullLive">
	<p class="with-mid-padding smallthin big-text wrapped relative" style="border:2px solid; border-color:#33393d; display: block; ">
		<span style="">
		<% _.each(total, function (article, i) { %>

			<% if (article.count == 1) {
				var color = "green-bg";
			}
			else if(article.count >= 4){
				var color = "red-bg";
			}
			else if(article.count == 3){
				var color = "orange-bg";
			}
			else if(article.count == 2){
				var color = "blue-bg";
			}

			%>
			  <span style="white-space:nowrap; padding-bottom:10px;">
			  		<span class="tag <%= color %> small-margin-right">
			  			<%= article.count %>
			  		</span> x <span class=""><%= article.name %></span>
			  </span> |
		<% }); %>
		</span>

	</p>
</script>
