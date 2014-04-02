<fieldset class="fieldset">
    <form action="<?php echo url_for('tools/'.($form->getObject()->isNew() ? 'create' : 'update').'?model=reduction'.(!$form->getObject()->isNew() ? '&id='.$form->getObject()->getId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
        <ul class="inputs large">
            <li>
                <?php echo $form['article_id']->renderRow(array('class' => 'input', 'placeholder' => 'Article')) ?>
            </li>
            <li>
                <?php echo $form['is_publish']->renderRow(array('class' => 'input', 'placeholder' => 'Actif ?')) ?>
            </li>
            <li>
                <?php echo $form['nb_acheter']->renderRow(array('class' => 'input', 'placeholder' => 'Nombre acheté')) ?>
            </li>
            <li>
                <?php echo $form['nb_offert']->renderRow(array('class' => 'input', 'placeholder' => 'Nombre offert')) ?>
            </li>
            <li>
                <?php echo $form['new_price']->renderRow(array('class' => 'input', 'placeholder' => 'Nouveau prix')) ?>
            </li>
            <li>
                <?php echo $form['pourcent_article']->renderRow(array('class' => 'input', 'placeholder' => 'Nom de la catégorie')) ?>
            </li>
            <li>
                <?php echo $form['auto_reduction']->renderRow(array('class' => 'input', 'placeholder' => 'Réduction automatique')) ?>
            </li>
            <li>
                <?php echo $form['code']->renderRow(array('class' => 'input', 'placeholder' => 'Code Promo')) ?>
            </li>
            <li>
                <?php echo $form['always_activate']->renderRow(array('class' => 'input', 'placeholder' => 'Toujours actif')) ?>
            </li>

            <li>
                <?php echo $form['start_date']->renderRow(array('class' => 'datePanel input', 'placeholder' => 'Début promo')) ?>
            </li>
            <li>
                <?php echo $form['end_date']->renderRow(array('class' => 'datePanel input', 'placeholder' => 'Fin promo')) ?>
            </li>
            <li>
                <?php echo $form['start_time']->renderRow(array('class' => 'timePanel input', 'placeholder' => 'Début')) ?> <?php echo $form['end_time']->renderRow(array('class' => 'timePanel input', 'placeholder' => 'Fin')) ?>
            </li>
            <li>
                
            </li>
            <?php echo $form->renderHiddenFields() ?>
        </ul>
        <input type="hidden" name="model" value="<?php echo $model ?>"</input>
        <div id="button_container" class="modal-buttons align-center"></div>
    </form>
</fieldset>

<script>
$(document).ready(function() {
    $('.timePanel').datetimepicker({
        datepicker:false,
        format:'H:i',
        lang: 'fr'
    });
    $('.datePanel').datetimepicker({
        timepicker:false,
        lang: 'fr',
        format:'Y-m-d'
    });

    hideInput();
    $('#<?php echo $model ?>_always_activate, #<?php echo $model ?>_auto_reduction').change(function() {
        hideInput();
    });

});

    // check if input have to be hided
    function hideInput() {
        //array with all inputs to change
        var inputs = $('#<?php echo $model ?>_start_date, #<?php echo $model ?>_end_date, #<?php echo $model ?>_start_time, #<?php echo $model ?>_end_time');
        if($('#<?php echo $model ?>_always_activate').is(':checked')){
            inputs.each(function(index, input){
                $(input).parent().hide();
            });
        }else{
            inputs.each(function(index, input){
                $(input).parent().fadeIn();
            });
        }

        var inputs = $('#<?php echo $model ?>_code');
          if($('#<?php echo $model ?>_auto_reduction').is(':checked')){
            inputs.each(function(index, input){
                $(input).parent().hide();
            });
        }else{
            inputs.each(function(index, input){
                $(input).parent().fadeIn();
            });
        }      
    }

    
</script>