<fieldset class="fieldset">
	<form action="<?php echo url_for($sf_params->get('module').'/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
		<ul class="inputs large">
			<li>
				<?php echo $form['first_name']->renderRow(array('class' => 'input', 'placeholder' => 'Prenom')) ?>
			</li>
			<li>
				<?php echo $form['last_name']->renderRow(array('class' => 'input', 'placeholder' => 'Nom')) ?>
			</li>
			<li>
				<?php echo $form['email_address']->renderRow(array('class' => 'input', 'placeholder' => 'Email')) ?>
			</li>
			<li>
				<?php echo $form['username']->renderRow(array('class' => 'input', 'placeholder' => 'Username')) ?>
			</li>
			<li>
				<?php echo $form['password']->renderRow(array('class' => 'input', 'placeholder' => 'Mot de passe')) ?>
			</li>
			<li>
				<?php echo $form['password_again']->renderRow(array('class' => 'input', 'placeholder' => 'Mot de passe')) ?>
			</li>
			<li>
				<?php echo $form['avatar']->renderRow(array('class' => 'file', 'placeholder' => 'Image de profil')) ?>
			</li>
			<li>
				<?php echo $form['credit']->renderRow(array('class' => 'input', 'placeholder' => 'Crédit')) ?>
			</li>
			<li>
				<?php echo $form['tel']->renderRow(array('class' => 'input', 'placeholder' => 'Téléphone')) ?>
			</li>
			<li>
				<?php echo $form['country']->renderRow(array('class' => 'input', 'placeholder' => 'Pays')) ?>
			</li>
			<li>
				<?php echo $form['street']->renderRow(array('class' => 'input', 'placeholder' => 'Rue')) ?>
			</li>
			<li>
				<?php echo $form['postal_code']->renderRow(array('class' => 'input', 'placeholder' => 'Code postal')) ?>
			</li>
			<li>
				<?php echo $form['city']->renderRow(array('class' => 'input', 'placeholder' => 'Ville')) ?>
			</li>
			<li>
				<?php echo $form['genre']->renderRow(array('class' => 'select', 'placeholder' => 'Genre')) ?>
			</li>
			<li>
				<?php echo $form['tva']->renderRow(array('class' => 'input', 'placeholder' => 'T.V.A.')) ?>
			</li>
			<li>
				<?php echo $form['groups_list']->renderRow(array('class' => 'select')) ?>
			</li>
			<li>
				<?php echo $form['date_naissance']->renderRow(array('class' => 'input', 'placeholder' => 'Nom du produit')) ?>
			</li>

		</ul>
		<div id="button_container" class="modal-buttons align-center"></div>
	</form>
</fieldset>




