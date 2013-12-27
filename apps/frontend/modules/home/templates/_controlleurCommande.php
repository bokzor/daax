<ul  class="access children-tooltip">
	<?php if($sf_user->isAuthenticated() && $sf_user->hasCredential('serveur')): ?>
	<li>
		<a href="" class="close-menu" onclick="encaisser(0); return false;" title="Encaisser la commande">
			<span class="icon-green icon-tick"></span>
		</a>
	</li>
	<li>
		<a href="" class="close-menu" onclick="chargerCommande(); return false;" title="Charger une commande">
			<span class="icon-inbox"></span>
		</a>
	</li>
	<?php endif; ?>
	<li>
		<a href="" class="close-menu" onclick="imprimer(); return false;" id="imprimer" title="Enregistrer la commande">
			<span class="icon-outbox"></span>
		</a>
	</li>
	<li>
		<a href="" class="close-menu" onclick="clearCommande(); return false;" id="messages-clear" title="Annuler la commande">
			<span class="icon-cross icon-red"></span>
		</a>
	</li>
</ul>