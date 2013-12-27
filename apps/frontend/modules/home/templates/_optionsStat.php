<div id="optionsStat">
	<ul  class="access children-tooltip">
		<?php if($sf_user->isAuthenticated() && $sf_user->hasCredential('serveur')): ?>
		<li id="serverStatB">
			<a href="" class="close-menu" onclick="chargerPage('/stat'); return false;" title="Ajouter un commentaire">
				Serveur
			</a>
		</li>
		<li id="produitStatB">
			<a href="" class="close-menu" onclick="chargerPage('/stat/produit'); return false;" title="Ajouter un supplément">
				Produit
			</a>
		</li>
		<li id="categoryStatB">
			<a href="" class="close-menu" onclick="chargerPage('/stat/category'); return false;" title="Ajouter un supplément">
				Catégorie
			</a>
		</li>
		<?php endif; ?>
	</ul>
</div>