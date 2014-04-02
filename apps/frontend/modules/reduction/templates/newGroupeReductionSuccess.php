<fieldset class="fieldset">
    <form action="<?php echo url_for('tools/'.($form->getObject()->isNew() ? 'create' : 'update').'?model=reduction'.(!$form->getObject()->isNew() ? '&id='.$form->getObject()->getId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
        <ul class="inputs large">
            <li>
                <?php echo $form['name']->renderRow(array('class' => 'input', 'placeholder' => 'Nom du groupe')) ?>
            </li>
            <li>
                <?php echo $form['is_active']->renderRow(array('class' => 'input', 'placeholder' => 'Nom de la catégorie')) ?>
            </li>
        </ul>
        <input type="hidden" name="model" value="<?php echo $model ?>"</input>
        <div id="button_container" class="modal-buttons align-center"></div>
    </form>
</fieldset>