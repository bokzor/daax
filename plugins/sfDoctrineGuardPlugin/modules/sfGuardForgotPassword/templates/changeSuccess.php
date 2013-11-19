<?php use_helper('I18N')
?>
	<div class="greyblock">
		<div class="blockp_default">
			<div class="blockp_title">
				<h4 class="ttl20"><span class="titr_generic titr_blockp">Modification/Changement de <span style="color: #bee241;">Mot de passe</span>.</span></h4>
			</div>
			<div class="gradientblock" style="height: 288px; width: 670px; margin-left: auto; margin-right: auto;">
				<span class="titr1_fav" style="font-style: italic;"><span style="color: #bee241;">Choisissez</span> un nouveau mot de passe ...</span>
				<br />
				<div class="ens_img_text_compte">
					<div class="ens_img_compte_connect">
						<?php echo image_tag("Cadenas-icon.png", "alt=") ?>
					</div>
					<div class="ens_form_compte_connect">
<div class="bg_connexion1" style="padding: 20px;">
<table>
<form action="<?php echo url_for('@sf_guard_forgot_password_change?unique_key='.$sf_request->getParameter('unique_key')) ?>" method="POST">
	<tr><td style="background-color: transparent;" width=200><?php echo $form['password']->renderLabel("Nouveau Mot de passe ", array('style' => 'color:#bee241; font-size: 12px;', 'class' => 'titr_generic')) ?></td>
    <td style="background-color: transparent;"><?php echo $form['password']->render(array('style' => 'margin-left:5px; height: 20px; width: 160px;')) ?></td></tr>
    <tr><td style="background-color: transparent;"><?php echo $form['password_again']->renderLabel("Retaper le nouveau Mot de passe ", array('style' => 'margin-top:10px; color:#bee241; font-size: 12px;', 'class' => 'titr_generic')) ?></td>
    <td style="background-color: transparent;"><?php echo $form['password_again']->render(array('style' => 'margin-left:5px; margin-top:5px; margin-bottom:5px; height: 20px; width: 160px;')) ?></td>
    <?php echo $form->renderHiddenFields() ?>
    </tr>
</table>

<div style="margin-top: 19px; margin-left: 240px;">
<input class="button orange" type="submit" value="<?php echo __('Valider le nouveau mot de passe', null, 'sf_guard') ?>" />
</form>
</div>
</div>
					</div>
				</div>
			</div>

		</div>
	</div>
