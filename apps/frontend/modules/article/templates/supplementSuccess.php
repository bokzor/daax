<form>
	<ul class="inputs large">
		<li>
			<label>Nombre d'article</label>
			<span class="number input margin-right">
				<button type="button" class="button number-down">-</button>
				<input type="text" placeholder="1" name="count" size="3" class="virtual-pad-num input-unstyled">
				<button type="button" class="button number-up">+</button>
			</span>
		</li>
		<?php foreach($supplements as $supplement): ?>
		<li>
			<label><?php echo $supplement -> getName() ?></label>
			<input data-id="<?php echo $supplement->getId() ?>" data-fois-prix="<?php echo $supplement->getFoisPrix() ?>" name="<?php echo $supplement -> getName() ?>" data-plus-prix="<?php echo $supplement->getPlusPrix() ?>" type="checkbox" class="switch" data-text-on="Oui" data-text-off="Non">
		</li>
		<?php endforeach ?>

	</ul>
</form>
<script>
	if($.template.touchOs == false){
		$('.virtual-pad-num').keypad({
		    keypadOnly: true,
		});
		$('.virtual-pad-num').keypad('show');
	}
</script>




