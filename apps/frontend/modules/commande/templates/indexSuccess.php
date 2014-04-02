<?php use_helper('Thumb'); ?>
<?php use_helper('Accent'); ?>
<?php include_partial('home/optionsCommande') ?>
<!-- affiche le menu pour enregistrer valider et charger une commande -->
<input type="text" id="recherche" placeholder='Recherche' class=" virtual-pad input full-width large">

<div class="with-padding container-boisson">
	<div class="columns">
		<div class="no-margin-bottom twelve-columns twelve-columns-tablet">

			<div class="side-tabs" style="color: #f7f7f7;">
                <!-- // on affiche les catégorie -->
				<ul id="categorie-tabs" class="thin tabs">
					<li  data-current-level="0" data-current-id="0" data-current-parent="0">
						<a class="white" href="#sidetab-0">Top</a>
					</li>
					<?php $i=0; foreach($categories as $category): $i++; ?>
					<li <?php if($category->getLevel()>0) echo "style='display:none;'"; ?>  data-current-level="<?php echo $category->getLevel() ?>" data-current-id="<?php echo $category->getId() ?>" data-current-parent="<?php echo $category->getFatherId() ?>">
						<a class="white" href="#sidetab-<?php echo $i?>"><?php echo $category->getName() ?></a>
					</li>
					<?php endforeach; ?>

				</ul>

               <!--  // on affiche la catégorie top -->
				<div class="tabs-content">
						<div class="sidetab" id="sidetab-0">
							<ul  class="gallery">
								<?php foreach($tops as $article): ?>
								<li style=" " class="mid-margin-right mid-margin-left mid-margin-bottom">
									<figure data-category='<?php echo $article->getCategory()->getId() ?>' data-title="<?php echo $article->getName() ?>"  data-price="<?php echo $article->getPrix() ?>" data-id="<?php echo $article->getId() ?>" >
											<?php echo showThumb($article->getImg(), 'articles', $options = array('alt' => 'Affiche de '.$article->getName().'', 'class' => 'image-commande', 'width' => '170', 'height' => '170','title' => ''.ucfirst($article->getName()).''), $resize = 'fit', $default = 'default.jpg') ?> 
										
										<figcaption><?php echo ucfirst(replaceAccent($article -> getName())) ?> <span class="icon-plus float-right icon-green icon-size3 large-margin-right"></span></figcaption>

									</figure>
								</li>
								<?php endforeach; ?>
							</ul>

						</div>

                    <!--  // on affiche les articles des categories -->
					<?php $i=0; foreach($categories as $category): $i++; ?>
						<div class="sidetab" id="sidetab-<?php echo $i ?>">
							<ul class="gallery">
								<?php foreach($category->Article as $article): ?>
								<li style=" " class="mid-margin-right mid-margin-left mid-margin-bottom">
									<figure data-category='<?php echo $category->getId() ?>' data-price="<?php echo $article->getPrix() ?>" data-id="<?php echo $article->getId() ?>" data-title="<?php echo $article->getName() ?>"  >
										<a class="articles-message" title="<?php echo $article->getName() ?>" href="#">
											<?php echo showThumb($article->getImg(), 'articles', $options = array('alt' => 'Affiche de '.$article->getName().'', 'class' => 'image-commande', 'width' => '170', 'height' => '170','title' => ''.$article->getName().''), $resize = 'fit', $default = 'default.jpg') ?> 
										</a>
										<figcaption><?php echo ucfirst(replaceAccent($article -> getName())) ?> <span class="icon-plus float-right icon-green icon-size3 large-margin-right"></span></figcaption> 	
									</figure>
								</li>
								<?php endforeach; ?>
							</ul>

						</div>
					<?php endforeach; ?>
				</div>

			</div>
		</div>

	</div>
	<div class="gigantic pagination">
	    <a href="#" class="first" data-action="first">&laquo;</a>
	    <a href="#" class="previous" data-action="previous">&lsaquo;</a>
	    <input type="text" readonly="readonly" data-max-page="1" />
	    <a href="#" class="next" data-action="next">&rsaquo;</a>
	    <a href="#" class="last" data-action="last">&raquo;</a>
	</div>


</div>

<script>






function pagination(page) {
    var i = 1;
    if ($.template.viewportWidth >= 952) {
        $('ul.gallery:visible').find('li').each(function () {
            if(i == 1){
                $('ul.gallery').find('li').removeClass('selected');
                $(this).addClass('selected');
            }
            if (page == 1) {
                if (i > page * <?php echo $nombre_articles ?>) {
                    $(this).hide();
                } else {
                    $(this).show();
                }
            } else {
                if (i > page * <?php echo $nombre_articles ?> || i < (page - 1) * <?php echo $nombre_articles ?> + 1) {
                    $(this).hide();
                } else {
                    $(this).show();
                }
            }
            i++;
        });
        $('.pagination').find('input').val(page)
        $('li.selected').removeClass('selected');
        selectArticle(0);
    }
}

// on navigue dans les éléments
function selectArticle(i){

    var test = false;
    // on navigue dans les élements visibles
    $('ul.gallery:visible').find('li:visible').each(function (index) { 
        if(test === false){
            if($(this).hasClass('selected')){
                $('li.selected').removeClass('selected');
                // on selectionne uniquement les index de 0 a 11 (12-1)
                if(index + i < <?php echo $nombre_articles ?>){
                    $('ul.gallery:visible').find('li:visible').eq(index + i).addClass('selected');
                    console.log(index);
                    test = true;
                }
                // on verifier si on doit changer de page.
                var current_page = $('.pagination').find('input').val();

                if(index + i >= <?php echo $nombre_articles ?>){
                    pagination(parseInt(current_page) + 1);
                }else if(index + i < 0 && current_page != 1){
                    pagination(parseInt(current_page) - 1);
                }
            } 
        }
    });
    if(test === false){
        $('li.selected').removeClass('selected');
        // on selectionne le premier article visible
        $('ul.gallery:visible').find('li:visible').eq(0).addClass('selected');
    }
     
}



$(document).ready(function () {
    $(document).on('init-queries', function () {
        $('#main').widthchange(responsiveCommande);
    });
    pagination(1);

    // on initialise le listiner pour les racourcis claviers
    var listener = new window.keypress.Listener();
    listener.simple_combo('shift', function() {
        $('#recherche').focus();
    });

    // on navigue dans articles
    var listener = new window.keypress.Listener();
    listener.simple_combo('right', function() {
        selectArticle(1);
    });

    listener.simple_combo('left', function() {
        selectArticle(-1);
    });
    listener.simple_combo('hyphen', function() {
        var article = $('li.selected').find('figure');
        var id = article.data('id');
        console.log(id);
        var article = app.collections.commande.where({id_article: id});
        app.collections.remove(article);
    });

    listener.simple_combo('up', function() {
        selectArticle(-5);
    });

    listener.simple_combo('down', function() {
        selectArticle(5);
    });
    listener.simple_combo('enter', function() {
        var article = $('li.selected').find('figure');
        var boisson = { 'name': article.data('title'), 'id': article.data('id'), 'prix':  article.data('price')}
        addBoisson(boisson);
    });

    // on désactive la pagination sur les petits écrans;
    function responsiveCommande() {
        if ($.template.viewportWidth < 952) {
            $('ul.gallery:visible > li').show();
            $('.pagination').hide();
            var control = $('#controlleurCommande');
        } else {
            var control = $('#controlleurCommande');
            pagination(1);
        }
    }

    // init pagination
    $('.pagination').jqPagination({
        link_string: '/?page={page_number}',
        max_page: null,
        page_string: '{current_page}',
        paged: function (page) {
            pagination(page);
        }
    });

    //lors du click sur retour, on affiche les catégorie pere
    $('.goStart').live('click', function () {
        $('.tabs li').hide();
        $('li[data-current-level=0]').show();
        $('.goStart').remove();
        var nb_cat = $("#categorie-tabs > li:visible").length;
        $('.side-tabs').css('min-height', 133 * nb_cat);
    });


    // init virtual keypad
    $(document).on('init-queries', function () {
        if (!$.template.touchOs) {
            $('.virtual-pad').keypad({
                keypadOnly: false,
                layout: ['azertyuiop' + $.keypad.CLOSE,
                    'qsdfghjklm' + $.keypad.CLEAR,
                    'wxcvbn' + $.keypad.SPACE + $.keypad.SPACE + $.keypad.BACK
                ]
            });
        }

    })

    // si c'est pas tactile, on active le clavier virtuel
    if (!$.template.touchOs) {
        $('.virtual-pad').keypad({
            keypadOnly: false,
            layout: ['azertyuiop' + $.keypad.CLOSE,
                'qsdfghjklm' + $.keypad.CLEAR,
                'wxcvbn' + $.keypad.SPACE + $.keypad.SPACE + $.keypad.BACK
            ]
        });
    }

    // surcharge methode contains jquery
    $.expr[":"].contains = $.expr.createPseudo(function (arg) {
        return function (elem) {
            return $(elem).text().toUpperCase().indexOf(arg.toUpperCase()) >= 0;
        };
    });

    // lors du click d'une categorie on supprime la recherche courrante
    $('#categorie-tabs > li > a').live('click', function () {
        var nb_page = Math.ceil($('ul.gallery:visible > li').length / 16);
        $('.pagination').jqPagination('option', {
            'current_page': 1,
            'max_page': nb_page
        });

        // on compte le nombre d'élément dans la catégorie active. Si il n'y en pas on revient sur la page de séléction de catégorie    
        var idCat = $(this).attr('href');
        if ($(idCat + ' > ul > li ').length == 0) {
            $('.tab-opened').removeClass('tab-opened');
        }
    });

    // fonction de recherche d'article

    function searchArticle(param) {
        $('.gallery > li').hide();
        var input_content = $.trim(param.val());
        if (!input_content) {
            $('.gallery>li').show();
            pagination(1);
        } else {
            $('.gallery:not(:first)>li').show().not(':contains(' + input_content + ')').hide();
            $('.sidetab').show();
            $('.side-tabs').addClass('tab-opened');
            $('li.selected').removeClass('selected');
            selectArticle(1);
        }
       

    }

    var elem = $('.virtual-pad');
    // Save current value of element
    elem.data('oldVal', elem.val());
    elem.on('change keyup input paste', function () {
        if (elem.data('oldVal') != elem.val()) {

            // Updated stored value
            elem.data('oldVal', elem.val());
            searchArticle($(this));
        }
    });



    // on s'occupe des catégorie et sous-catégorie
    $('.tabs li').live('click', function () {
        var id = $(this).data('current-id');
        var level = $(this).data('current-level') + 1;
        if ($('li[data-current-parent=' + id + '][data-current-level=' + level + ']').length >= 1) {
            // on masque touts les objets
            $('.tabs li').hide();
            //on fait apparaitre les catégorie inférieurs
            $('li[data-current-parent=' + id + '][data-current-level=' + level + ']').show();
            // on rend actif le premier de la sous-catégorie
            $('li[data-current-parent=' + id + '][data-current-level=' + level + ']').first();
            //on masque la catégorie active
            $(this).hide();
            //on set le premier li visible en actif et on retire le bord superieur
            $("#categorie-tabs > li:visible:first").children().css('border', 'none');
            //on insere un bouton retour
            $("#categorie-tabs").prepend('<li class="goStart"><a class="white">Retour</a></li>');
        }
    });

    // reset de la recherche lorsqu'on click dessus
    $('#recherche').on('click', function(){
        $(this).val('');
        pagination(1);
    })

});

</script>

