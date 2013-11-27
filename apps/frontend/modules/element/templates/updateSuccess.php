<fieldset class="fieldset">
	<form action="<?php echo url_for('tools/'.($form->getObject()->isNew() ? 'create' : 'update').'?model='.$model.(!$form->getObject()->isNew() ? '&id='.$form->getObject()->getId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
		<ul class="inputs large">
			<li>
				<?php echo $form['name']->renderRow(array('class' => 'input', 'placeholder' => 'Nom du produit')) ?>
			</li>
			<li>
				<?php echo $form['img']->renderRow(array('class' => 'file', 'placeholder' => 'Image du produit')) ?>
			</li>
			<li>
				<?php echo $form['category_id']->renderRow(array('class' => 'select')) ?>
			</li>
			<li>
				<?php if(isset($form['stock_minimum'])) echo $form['stock_minimum']->renderRow(array('class' => 'input')) ?>
			</li>
			<li>
				<?php if(isset($form['stock_actuel'])) echo $form['stock_actuel']->renderRow(array('class' => 'input')) ?> <img onclick="ajoutStock()" height='20px' width='20px' style="padding-top:10px" src='/image/plus.png' />
			</li>
			<li>
				<?php echo $form['prix_achat']->renderRow(array('class' => 'input')) ?>
			</li>
			<li>
				<?php echo $form['conditionnement_id']->renderRow(array('class' => 'input')) ?>	
			</li>
			<li>
				<?php echo $form['nombre_unite']->renderRow(array('class' => 'input')) ?>
			</li>
			<li>
				<?php echo $form['fournisseur_id']->renderRow(array('class' => 'input')) ?>
			</li>
		</ul>
		<div id="button_container" class="modal-buttons align-center"></div>
	</form>
</fieldset>
<script>
  function ajoutStock(){
  	var nb_unite = parseFloat($('#element_nombre_unite').val());
  	var stock_actuel = parseFloat($('#element_stock_actuel').val());
  	$('#element_stock_actuel').attr('value', stock_actuel + nb_unite);
  	  	
  }
</script>



