<form>
	<ul class="inputs large">
		<?php foreach($supplements as $supplement): ?>
		<li>
			<label><?php echo $supplement -> getName() ?></label>
			<input data-id="<?php echo $supplement->getId() ?>" data-fois-prix="<?php echo $supplement->getFoisPrix() ?>" name="<?php echo $supplement -> getName() ?>" data-plus-prix="<?php echo $supplement->getPlusPrix() ?>" type="checkbox" class="switch" data-text-on="Oui" data-text-off="Non">
		</li>
		<?php endforeach ?>

	</ul>
</form>




