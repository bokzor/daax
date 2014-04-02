<script>
</script>
<button style="margin-bottom: 10px" id="bComment" class="button full-width">Commentaire</button>
<button style="margin-bottom: 10px" id="bSupp" class="button full-width">Suppléments</button>

<div style="display:block; padding-bottom: 15px" class="article-number">
<input style="width: 36px;" id="nb-article" type="" value="" class="input" />
<ul style="float: right; display: inline; width: 100px;" class="plus-minus">
    <li style="float: left; list-style: none; width: 50px; font-size: 40px;"><span class="icon-green icon-minus"></span></li>
    <li style="float: left; list-style: none; width: 50px; font-size: 40px;"><span class="icon-green icon-plus"></span></li>
</div>
</div>
<textarea name="autoexpanding" id="commentaire" class="virtual-pad input full-width autoexpanding" style="overflow: hidden; resize: none; height: 200px; display: none;">
</textarea>
<div id="suppContainer">

</div>



<script>



// si c'est pas tactile, on active le clavier virtuel
if (!$.template.touchOs) {
    var article = app.collections.commande.get('<?php echo $cid ?>');
 
    // set des forms pour l'article courant
    $('#commentaire').val(article.get('comment'));

    // on met le nombre d'article dans le input;
    $('#nb-article').val(app.collections.commande.get('<?php echo $cid ?>').get('count'));

    $(document).ready(function() {
        var id_article =  article.get('id_article');
        var html = $('.gallery > li').find("[data-id='" + id_article + "']");
        var cat_id = html.data('category');   
        $.get('/article/supplement/' + cat_id, function(data){
            $('#suppContainer').html(data);
            $('#suppContainer').hide();
            // on parcours les suppléments pour checker les cases
            if(article.get('supplements') !== undefined){         
                $.each(article.get('supplements'), function(i, supplement) {
                    $('#suppContainer').find("[data-id='" + supplement.id + "']").parent().addClass('checked');
                });      
            }
        });

    });




    //

    // on initialise le clavier virtuel pour les commentaires
    $('.virtual-pad').keypad({
        keypadOnly: false,
        layout: ['azertyuiop' + $.keypad.CLOSE,
            'qsdfghjklm' + $.keypad.CLEAR,
            'wxcvbn' + $.keypad.SPACE + $.keypad.SPACE + $.keypad.BACK
        ]
    });
    //$('.virtual-pad').keypad('show');

    // on initialise le clavier virtuel pour le nombre d'articles
    $('#nb-article').keypad({
        keypadOnly: true,
        onClose: function(value, inst) {
                if(value == '' || isNaN(value)){
                    value = 1;
                }
                article.set({count: parseInt(value)});
        },
        onKeypress: function(key, value, inst) { 
            if(this.press == undefined){
                $('#nb-article').val(key);             
            }
            this.press = true;
        },
    });

    // on affiche le clavier
    $('#nb-article').keypad('show');

    //si on click sur le bouton comment on affiche la textarea
    $('#bComment').on('click', function(){
        $('#commentaire').show();
        $('#suppContainer').hide();
        $('.virtual-pad').keypad('show');
    });

    //on affiche les suppléments
    $('#bSupp').on('click', function(){
            $('#commentaire').hide();
            $('#suppContainer').show();
    });


    // si on clicks sur le moins on decremente
    $('.icon-minus').on('click', function(){
        var val = $('#nb-article').val();
        // if val == 1 , that meant we have to delete the article
        if(val == 1){
            deleteArticleCommande('<?php echo $cid ?>');
            $('#nb-article').keypad('hide');
            $.modal().closeModal();
        }
        if(!isNaN(val) ){
            $('#nb-article').val(val - 1 );
        }
        article.set({count: $('#nb-article').val()});
    });

    // si on clicks sur le plus on incremente
    $('.icon-plus').on('click', function(){
        var val = $('#nb-article').val();
        if(!isNaN(val) && val!=''){
            $('#nb-article').val(parseInt(val) + 1 );
        } else {
            $('#nb-article').val('2');
        }
        article.set({count: $('#nb-article').val()});
    });

    
}

</script>