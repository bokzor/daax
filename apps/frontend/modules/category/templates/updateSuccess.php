<fieldset class="fieldset">
	<form action="<?php echo url_for('tools/'.($form->getObject()->isNew() ? 'create' : 'update').'?model='.$model.(!$form->getObject()->isNew() ? '&id='.$form->getObject()->getId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
		<ul class="inputs large">
			<li>
				<?php echo $form['name']->renderRow(array('class' => 'input', 'placeholder' => 'Nom de la catégorie')) ?>
			</li>
			<li>
				<?php echo $form['parent']->renderRow(array('class' => 'input', 'placeholder' => 'Nom de la catégorie')) ?>
			</li>
			<li>
				<?php echo $form['is_publish']->renderRow(array('class' => 'input', 'placeholder' => 'Nom de la catégorie')) ?>
			</li>
			<li>
				<a id="ajout-imprimante" href="#">Ajouter une imprimante</a>
			</li>
			<?php if(isset($categoryImprimantes)): ?>
				<?php foreach($categoryImprimantes as $categoryImprimante): ?>
					<li>
					<label for="id">Imprimera avec :</label>    
					<select name="id[]" class="input" >
					<option value=""></option>	    
					<?php foreach($imprimantes as $imprimante):
						if($imprimante->getId() == $categoryImprimante->getImprimanteId()){
							$selected = 'selected';
						}
						else {
							$selected = '';
						}
					?>
					<option <?php echo $selected ?> value="<?php echo $imprimante->getId() ?>"><?php echo $imprimante->getName() ?></option>
					<?php endforeach; ?>
					
					    </select>
					</li>
				<?php endforeach; ?>
			<?php endif; ?>
		</ul>
		<div id="button_container" class="modal-buttons align-center"></div>
	</form>
</fieldset>
<script>


newfieldscount = 0;

function addNewField(num){
  return $.ajax({
    type: 'GET',
    url: '/category_imprimante_form?c='+num,
    async: false
  }).responseText;
}

$(document).ready(function(){
  $('#ajout-imprimante').click(function(e){
    e.preventDefault();
    $(this).parent().after(addNewField(newfieldscount));
    newfieldscount = newfieldscount + 1;
  });
});
</script>


