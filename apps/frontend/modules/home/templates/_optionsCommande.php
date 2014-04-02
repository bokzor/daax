<div id="optionsControlleur">
	<ul  class="access children-tooltip">
		<?php if($sf_user->isAuthenticated() && $sf_user->hasCredential('serveur')): ?>
		<li id="commentaireB">
			<a href="" class="close-menu" onclick="encaisser(2); return false;" title="Ajouter un commentaire">
				Cash
			</a>
		</li>
		<li id="supplementB">
			<a href="" class="close-menu" onclick="encaisser(1); return false;" title="Ajouter un supplément">
				Bancontact
			</a>
		</li>
		<li id="reductionB">
			<a href="" class="close-menu" onclick="encaisser(-2); return false;" title="Ajouter une réduction">
				Offrir
			</a>
		</li>
		<?php endif; ?>
	</ul>
</div>