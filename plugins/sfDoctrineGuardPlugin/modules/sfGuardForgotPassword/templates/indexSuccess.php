<?php use_helper('I18N') ?>


	<div class="greyblock">
		<div class="blockp_default">
			<div class="blockp_title">
				<h4 class="ttl20"><span class="titr_generic titr_blockp"><span style="color: #bee241;">Modification</span> ou <span style="color: #bee241;">perte</span> de Mot de passe !</span></h4>
			</div>
			<div class="gradientblock" style="height: 254px; width: 826px; margin-left: auto; margin-right: auto;">
				<span class="titr1_fav" style="font-style: italic;">Envoyez-nous votre <span style="color: #bee241;">adresse mail</span> pour le modifier/récupérer ...</span>
				<br />
				<div class="ens_img_text_compte">
					<div class="ens_img_compte_connect">
						<?php echo image_tag("mail_icon.png", "alt=") ?>
					</div>
					<div class="ens_form_compte_connect">
						<div class="text1_blockp_compte" style="margin-top: 1px;">
            		<span>
              			Veuillez saisir votre adresse mail dans le champs ci-dessous, vous recevrez un mail de modification/changement de mot de passe.<br />
              			<span style="color: #D33737; font-style: italic; font-size:10px;">Si le mail n'est pas présent dans votre boîte mail, jetez un coup d'œil dans vos spam !</span>
              		</span>
          		</div>
          		<div class="bg_connexion1" style="padding: 20px; width: 585px; margin-left: 15px;">
          			<table>
						<form action="" method="post">

<tr><td width=140><?php echo $form['email_address']->renderLabel("Votre Adresse Email ", array('style' => 'color:#bee241; font-size: 12px;', 'class' => 'titr_generic')) ?></td>
    <td><?php echo $form['email_address']->render(array('style' => 'margin-left:5px; height: 30px; width: 400px; font-size: 16px;')) ?>
    	<?php echo $form -> renderHiddenFields() ?>
    </td></tr>
</table></div><div style="margin-top: 19px; margin-left: 543px;"><input class="button orange" type="submit" name="change" value="<?php echo __('Envoyer', null, 'sf_guard') ?>" /></div></form>
					</div>
				</div>
			</div>
		</div>
	</div>