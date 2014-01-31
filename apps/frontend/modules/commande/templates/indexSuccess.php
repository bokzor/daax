<?php use_helper('Thumb'); ?>
<?php use_helper('Accent'); ?>

<!-- affiche le menu pour enregistrer valider et charger une commande -->
<?php include_partial('home/optionsCommande') ?>
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


// on revient au dessus de la page
$('.tabs-content > div').on('showtab', function () {
    $('body').animate({
        scrollTop: 0
    }, 'fast');

});

$('.tabs-content > div').on('hidetab', function () {
    $('body').animate({
        scrollTop: 0
    }, 'fast');

});

$('ul.gallery figcaption span').click(function () {
    calculette($(this));
});


function pagination(page) {
    var i = 1;
    if ($.template.viewportWidth >= 952) {
        $('ul.gallery:visible').find('li').each(function () {
            if (page == 1) {
                if (i > page * 16) {
                    $(this).hide();
                } else {
                    $(this).show();
                }
            } else {
                if (i > page * 16 || i < (page - 1) * 16 + 1) {
                    $(this).hide();
                } else {
                    $(this).show();
                }
            }
            i++;
        });
    }
}

function supplementArticle() {
    $('#supplementB').toggleClass('red-gradient');
    if ($('#supplementB').hasClass('red-gradient')) {
        notify('Notification', 'Veuillez choisir un article', {
            closeDelay: 5000
        });
    };
};

function commentaireArticle() {
    $('#commentaireB').toggleClass('red-gradient');
    if ($('#commentaireB').hasClass('red-gradient')) {
        notify('Notification', 'Veuillez choisir un article', {
            closeDelay: 5000
        });
    };
};

$(document).ready(function () {
    $(document).on('init-queries', function () {
        $('#main').widthchange(responsiveCommande);
    });
    // on désactive la pagination sur les petits écrans;

    function responsiveCommande() {
        if ($.template.viewportWidth < 952) {
            $('ul.gallery:visible > li').show();
            $('.pagination').hide();
            var control = $('#controlleurCommande');
            //control.insertAfter('#main');
            //control.css('position', 'fixed');
            //control.css('bottom', '0');
            //control.css('z-index', '100');
            //control.css('padding-bottom', '55px');
        } else {
            var control = $('#controlleurCommande');
            pagination(1);
            //control.insertAfter('#profile');
            //control.css('bottom', '');
            //control.css('position', '');
            //control.show();
            //$('#main').css('padding-bottom', '0px');
        }
    }

    // init pagination
    $('.pagination').jqPagination({
        link_string: '/?page={page_number}',
        max_page: null,
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
        nb_page = Math.ceil($('ul.gallery:visible > li').length / 16);
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
        }
    }

    var elem = $('.virtual-pad');
    // Save current value of element
    elem.data('oldVal', elem.val());
    elem.on('change keyup input paste', function () {
        console.log('change');
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

});

</script>

