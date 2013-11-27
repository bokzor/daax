<fieldset class="fieldset">
	<form action="<?php echo url_for('tools/'.($form->getObject()->isNew() ? 'create' : 'update').'?model='.$model.(!$form->getObject()->isNew() ? '&id='.$form->getObject()->getId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>

		<ul class="inputs large">
			<li>
				<?php echo $form['name']->renderRow(array('class' => 'input', 'placeholder' => 'Nom de l\'imprimante')) ?>
			</li>
			<li>
				<?php echo $form['description']->renderRow(array('class' => 'input', 'placeholder' => 'Description')) ?>
			</li>
			<li>
				<?php echo $form['facture']->renderRow(array('class' => 'input', 'placeholder' => 'Description')) ?>
			</li>
		</ul>
		<div id="button_container" class="modal-buttons align-center"></div>
	</form>
</fieldset>




