<div id="optionsControlleur">
	<ul  class="access children-tooltip">
		<?php if($sf_user->isAuthenticated() && $sf_user->hasCredential('serveur')): ?>
		<li id="commentaireB">
			<a href="" class="close-menu" onclick="commentaireArticle(); return false;" title="Ajouter un commentaire">
				Commentaire
			</a>
		</li>
		<li id="supplementB">
			<a href="" class="close-menu" onclick="supplementArticle(); return false;" title="Ajouter un supplément">
				+ Suppléments
			</a>
		</li>
		<?php endif; ?>
	</ul>
</div>