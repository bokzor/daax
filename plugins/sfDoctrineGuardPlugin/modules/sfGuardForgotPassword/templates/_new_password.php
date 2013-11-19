<?php use_helper('I18N') ?>
<?php echo __('Bonjour %first_name%', array('%first_name%' => $user->getFirstName()), 'sf_guard') ?>,

<?php echo __('Vous venez de changer de mot de passe :') ?> 

<?php echo __('Username', null, 'sf_guard') ?>: <?php echo $user->getUsername() ?> 
<?php echo __('Mot de passe', null, 'sf_guard') ?>: <?php echo $password ?>