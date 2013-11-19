<form action="<?php echo url_for('tools/'.($form->getObject()->isNew() ? 'create' : 'update').'?model='.$model.(!$form->getObject()->isNew() ? '&id='.$form->getObject()->getId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>

	<ul class="inputs large">
		<li>
			<?php echo $form['name']->renderRow(array('class' => 'input', 'placeholder' => 'Nom du fournisseur')) ?>
		</li>
		<li>
			<?php echo $form['tel']->renderRow(array('class' => 'input', 'placeholder' => 'Téléphone')) ?>
		</li>
	</ul>
</form>




