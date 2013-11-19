<?php use_helper('I18N') ?>

<span>Vous avez <span style="color: #bee241;">perdu</span> votre mot de passe, veuillez saisir votre adresse Email. Un <span style="color: #bee241;">Email vous sera envoyé</span> !</span>
<form action="<?php echo url_for("sf_guard_forgot") ?>" method="post">

<?php echo $form ?>

<input type="submit" class="button orange small" name="change" value="<?php echo __('Envoyer', null, 'sf_guard') ?>" />
</form>
