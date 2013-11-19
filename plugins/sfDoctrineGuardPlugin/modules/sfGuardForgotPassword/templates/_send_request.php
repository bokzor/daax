<?php use_helper('I18N') ?>
<?php echo __('Bonjour %username%', array('%username%' => $user->getUsername()), 'sf_guard') ?>,<br/><br/>

<?php echo __('Cet email vous a été envoyé parce que vous avez fait une demande de changement de mot de passe.', null, 'sf_guard') ?><br/><br/>

<?php echo __('Pour changer de mot de passe, cliqué sur le lien ci-dessous :', null, 'sf_guard') ?><br/><br/>

<?php echo link_to(__('Changer votre mot de passe', null, 'sf_guard'), '@sf_guard_forgot_password_change?unique_key='.$forgot_password->unique_key, 'absolute=true') ?>

<br/><br/><?php echo __('Le lien expire après 24 heures', null, 'sf_guard') ?><br/>
