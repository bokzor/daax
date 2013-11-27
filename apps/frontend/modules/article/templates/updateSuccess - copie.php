<form action="<?php echo url_for('tools/'.($form->getObject()->isNew() ? 'create' : 'update').'?model='.$model.(!$form->getObject()->isNew() ? '&id='.$form->getObject()->getId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>

	<ul class="inputs large no-margin-bottom">
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
			<?php echo $form['prix']->renderRow(array('class' => 'input')) ?>
		</li>

		<li>
			<?php echo $form['temps_prepa']->renderRow(array('class' => 'input', 'placeholder' => 'Temps de préparation')) ?>
		</li>
		<li>
			<a id="ajout-stock" href="#">Ajouter une relation avec le stock</a>
		</li>
		<?php if(isset($articleElements)): ?>
		<?php foreach($articleElements as $articleElement): ?>
		<li>
		<label for="id">Décompte le stock :</label>    
		<select name="id[]" class="input" >
		<option value=""></option>	    
		<?php foreach($elements as $element):
			if($element->getId() == $articleElement->getElementId()){
				$selected = 'selected';
			}
			else {
				$selected = '';
			}
		?>
		<option <?php echo $selected ?> value="<?php echo $element->getId() ?>"><?php echo $element->getName() ?></option>
		<?php endforeach; ?>
		
		    </select>
		</li>
		<li>
			<label for="article_temps_prepa">Nombre a décompter:</label>
			<input class="input" type="number" step="0.01" value="<?php echo $articleElement->getADeduire() ?>" placeholder='Quantitée a déduire du stock' name="deduire[]"/> 
		</li>
			
		<?php endforeach; ?>
		<?php endif; ?>
	</ul>
	<div class="columns">
		<div class="six-columns"><button class="huge button full-width">Valider</button></div>
		<div class="six-columns"><button class="goback huge button full-width">Annuler</button></div>
	</div>

</form>
<script>
  function ajoutStock(){
  	var nb_unite = parseFloat($('#article_nombre_unite').val());
  	var stock_actuel = parseFloat($('#article_stock_actuel').val());
  	$('#article_stock_actuel').attr('value', stock_actuel + nb_unite);  	
  }

$('.goback').live('click', function(event){
	event.preventDefault();
	window.history.back();
});

newfieldscount = 0;

function addNewField(num){
  return $.ajax({
    type: 'GET',
    url: '/article_element_form?c='+num,
    async: false
  }).responseText;
}

$(document).ready(function(){
  $('#ajout-stock').click(function(e){
    e.preventDefault();
    $(this).parent().after(addNewField(newfieldscount));
    newfieldscount = newfieldscount + 1;
  });
});
</script>



