<fieldset class="fieldset">
	<form action="<?php echo url_for('tools/'.($form->getObject()->isNew() ? 'create' : 'update').'?model='.$model.(!$form->getObject()->isNew() ? '&id='.$form->getObject()->getId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>

		<ul class="inputs large">
			<li>
				<?php echo $form['name']->renderRow(array('class' => 'input', 'placeholder' => 'Nom du supplément')) ?>
			</li>
			<li>
				<?php echo $form['fois_prix']->renderRow(array('class' => 'input', 'placeholder' => 'Multiplier le prix de départ')) ?>
			</li>
			<li>
				<?php echo $form['plus_prix']->renderRow(array('class' => 'input', 'placeholder' => 'Ajouter au prix de départ')) ?>
			</li>
			<li>
				<?php echo $form['category_id']->renderRow(array('class' => 'input')) ?>
			</li>
			<li>
				<?php echo $form['visible_user']->renderRow(array('class' => 'input')) ?>
			</li>
		</ul>
		<div id="button_container" class="modal-buttons align-center"></div>
	</form>
</fieldset>




