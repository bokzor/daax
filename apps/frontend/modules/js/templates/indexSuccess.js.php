/* fonction qui récupére les erreurs ajax */
$(function() {
    $.ajaxSetup({
	error: function(jqXHR, exception) {
	    if (jqXHR.status === 0) {
		//alert('Not connect.\n Verify Network.');
	    } else if (jqXHR.status == 404) {
		console.log('Requete incorrecte');
	    } else if (jqXHR.status == 401) {
		window.location.reload();
	    } else if (exception === 'parsererror') {
		console.log('Requested JSON parse failed.');
	    } else if (exception === 'timeout') {
		console.log('Time out error.');
	    } else if (exception === 'abort') {
		console.log('Ajax request aborted.');
	    } else {
		//window.location.reload();
	    }
	}
    });
});


// retourne sous forme de tableau les articles dans la commande en cours

function articleJson() {
    var commande = new Object();
    var articles = $('#message-block > .message');
    articles.each(function() {
	var id_boisson = $(this).find('.prix-boisson').data('id');
	var count_boisson = $(this).find('.count').text();
	commande[id_boisson] = count_boisson;
    });
    if (articles.size() == 0) {
	return 0;
    } else {
	return JSON.stringify(commande);
    }
}


// fonction qui envois la commande d'impression

function imprimerCommandes() {
    var matches = [];
    $("input:checked").each(function() {
	matches.push(this.value);
    });
    $.ajax({
	type: 'POST',
	url: '/imprimer/commandes',
	data: {
	    id: matches,
	},
	// Il faudra lancer l'impression du ticket ici
	success: function() {
	    notify('Succès', 'Les commandes vont être imprimées', {
		closeDelay: 3000
	    });
	}
    });

}


// fonction qui envois la commande d'impression

function imprimerCommande(value) {
    var matches = [];
	matches.push(value);
    $.ajax({
	type: 'POST',
	url: '/imprimer/commandes',
	data: {
	    id: matches,
	},
	// Il faudra lancer l'impression du ticket ici
	success: function() {
	    notify('Succès', 'Les commandes vont être imprimées', {
		closeDelay: 3000
	    });
	}
    });

}


// on imprime la commande en cours

function imprimer() {
    var table_id = $('#table-id').val();
    //si on a pas déja chargé la commande, c'est que c'est une nouvelle
    if (isNaN(table_id) || table_id == '') {
	var commande = articleJson();

	// if the list is empty we do nothing
	if (commande == 0) {
	    notify('Erreur', 'La commande est vide', {
		closeDelay: 3000
	    });
	} else {
	    $.modal.prompt('Entrez le numéro de table', function(table_id) {
			// we ask the table's number and we send the list of items
			table_id = parseInt(table_id);
			if (isNaN(table_id)) {
			    $(this).getModalContentBlock().message('Valeur incorrecte', {
				append: false,
				type: 'number',
				classes: ['red-gradient']
			    });
			    return false;
			}

			// we send the list
			$.ajax({
			    type: 'POST',
			    url: '/save/commande/' + table_id,
			    data: {
				table_id: table_id,
						commande: app.collections.commande.toJSON(),
			    },
			    // Il faudra lancer l'impression du ticket ici
			    success: function() {
					notify('Succès', 'La commande va être imprimée', {
				    	closeDelay: 3000
					});
				clearCommande();
			    }
			});
		}, '', { onOpen: '' });
	}
    } else {
	notify('Succès', 'La facture finale va être imprimée', {
	    closeDelay: 3000
	});
	notify('Succès', 'N\'oubliez pas d\'encaisser l\'argent !', {
	    closeDelay: 3000
	});
	chargerPage('payment');
    }

}


// fonction qui

function encaisser(bancontact) {
    var billet = $('#payment-block > p.message').size();
    var cash = 0;
    var table_id = 0;
    var commande_id = false;
    var cashback = 0;
    var commande = '';
    // on compte le nombre de cash
    if (billet > 0) {
		$('#payment-block > p.message').each(function(i) {
		    cash += Math.abs(parseFloat($(this).find(".prix-billet").text()));
		});
    }
    var argent = 0;
    $('#payment-block > .message').each(function(i) {
		nb_billet = 1;
		var prix = parseFloat($('.prix-billet', this).text());
		if ($('.count', this).length) nb_billet = $('.count', this).text();
		argent += prix * nb_billet;
    });

    // fin du compte de cache

    // on set la table_id zero si il n'y en a pas
    if ($('#table-id').val() > 0) {
		var table_id = $('#table-id').val();
		var url = '/commande/archiver/' + table_id;
    } else if ($('#commande-id').val() > 0) {
		var commande_id = $('#commande-id').val();
		var url = '/commande/archiver/commande/' + $('#commande-id').val();
    }else{
		var url = '/save/commande/' + table_id;
    }
    // fin table_id/commande_id



    //on regarde si la commande est vide
    var total = parseFloat($('.total-euro').text());
    var a_rendre = parseFloat($('.rendre-euro').text());
    if (total == 0 && billet == 0) {
		notify('Erreur', 'La commande est vide', {
		    closeDelay: 3000
		});
    } else if ((Math.abs(argent) >= total)  || (bancontact == 1 || bancontact == 2)) {
		// on recupere le montant du cashback
		if ($('.cashback').text()) {
		    var prix = parseFloat($('.cashback').text());
		    cashback = prix;
		}
		if (bancontact == 1) {
		    bancontact = parseFloat($('.total-euro').text()) + cashback
		}
		else if (bancontact == 2) {
		    cash = parseFloat($('.total-euro').text());
		    bancontact = 0;
		}
		// on envoit les données pour enregistrer la commande
		$.ajax({
		    type: 'POST',
		    url: url,
		    data: {
			cashback: cashback,
			bancontact: bancontact,
			cash: cash,
			commande: app.collections.commande.toJSON(),
			table_id: table_id,
			commande_id: commande_id
		    },
		    success: function() {
			notify('Succès', 'La commande va être imprimée', {
			    closeDelay: 3000
			});
			commande = app.collections.commandeLive.get(commande_id);
			app.collections.commandeLive.remove(commande);
			clearCommande();
		    }
		});
		notify('Succès', 'La commande va être archivée', {
		    closeDelay: 3000
		});
		// imprimer ticket + enregistrer le montant reçus + mention déja payé pour les factures payées
		// enregistrer la commande ou mettre a jour
		clearCommande();
    } else if (Math.abs(argent) < total && billet != 0 && bancontact == 0) {
	notify('Erreur', 'Il manque de l\'argent !', {
	    closeDelay: 3000
	});
    } else {
	chargerPage('/payment');
    }

}

// fonction qui charge une commande en fonction du numéro de table

function chargerCommande() {
    var total = parseFloat($('.total-euro').text());
    if (total > 0) {
	notify('Erreur', 'Vous avez déja une commande en cours', {
	    closeDelay: 3000
	});
    } else {
	$.modal.prompt('Entrez le numéro de table', function(value) {
	    value = parseInt(value);
	    if (isNaN(value)) {
		$(this).getModalContentBlock().message('Valeur incorrecte', {
		    append: false,
		    type: 'number',
		    classes: ['red-gradient']
		});
		return false;
	    }
	    jsonCommande('', value);
	    $('#table_id').attr('val', value);
	});
    }
}

function jsonCommande(id, table_id) {
	// si on charge une commande. On vide la commande actuel pour être sur.
	clearCommande();
    var url;
    if (table_id != undefined && table_id !='') {
	url = '/get/commande/table_id/' + table_id + '.json';
    }
    else{
	url = '/get/commande/id/' + id + '.json';
    }
    $.getJSON(url, function(data) {
		$('.total-euro').html(data['total_commande']);
	if (data['total_commande'] == 1) {
	    notify('Erreur', 'Il n\'y a pas de commande en cours pour cette table', {
		closeDelay: 3000
	    });
	} else {
	    $.each(data['articles'], function(key, val) {
			for (i = 0; i < val['count']; i++) {
			    addBoisson(val['prix'], val['name'], val['id'], val['supplements']);
			}					
	    });
	    $('#table-id').attr('value', table_id);
	    $('#commande-id').attr('value', id);
	    chargerPage('payment');
	    $('#imprimer').attr('title', 'Imprimer la facture');
	}
    });
}


// fonction qui ajoute un commentaire a un article

function Commentaire(id) {
    var buttons = {
	'Valider': function(modal) {
	    var comment = $('#autoexpanding').val();
	    findArticle = app.collections.commande.get(id);
	    findArticle.set({
		comment: comment
	    });
	    modal.closeModal();
	},
	'Annuler': function(modal) {
	    modal.closeModal();
	}
    };
    $.modal({
	title: 'Ajoutez un commentaire',
	url: '/commande/commentaire',
	buttonsAlign: 'center',
	buttons: buttons,
    });
}

//fonction qui ajoute les articles a la commande

function payment() {
	$('ul.gallery li figure').unbind('click');
    $('ul.gallery li figure').click(function(event) {
    	if(event.target.tagName =='SPAN')
    		return;
    	// ca veut dire qu'on a cliqué sur supplement
		var title = $(this).data('title');
		var price = $(this).data('price');
		var id_cat = $(this).data('category');
		var idBoisson = $(this).data('id');
    	if($('#supplement').hasClass('red-gradient')){
		  	var buttons = {
		  		// callback lors qu'on click sur valider
			    'Valider': function(modal) {
					$('#supplement').toggleClass('red-gradient white');

				    var inputs = modal.find('span.checked').find('input');
				    var supplements = new Object();
					var count = modal.find('input[name=count]').val();
					if(count<1){
						count = 1;
					}

				    inputs.each(function() {
				    	var name = $(this).attr('name');
						var id_supp = $(this).data('id');
						var fois_prix = $(this).data('fois-prix');
						var plus_prix = $(this).data('plus-prix');					
						var value = $(this).val();
						supplements[id_supp] = { 'id' : id_supp, 'fois_prix': fois_prix, 'plus_prix': plus_prix, 'name': name };
				    });
				    if(inputs.length == 0)
				    	supplements = undefined;
			    	for (i = 0; i < count; i++) {
						addBoisson(price, title, idBoisson, supplements);
				    }
					modal.closeModal();
			    },
			    'Annuler': function(modal) {
					modal.closeModal();
			    }
			};  
		    $.modal({
				title: 'Edition',
				resizable: false,
				url: '/article/supplement/' + id_cat,
				buttonsAlign: 'center',
				buttons: buttons,
		    });
	        return false;
    	}
    	else{
    		addBoisson(price, title, idBoisson, undefined);
    	}

    });

    //lors d'un clic long on peut rajouter plusieurs articles
}

function calculette(param){
	var title = param.parent().parent().data('title');
	var price = param.parent().parent().data('price');
	var idBoisson = param.parent().parent().data('id');
	$.modal.prompt('Entrez le nombre d\'article', function(value) {
	    value = parseInt(value);
	    if (isNaN(value)) {
			$(this).getModalContentBlock().message('Valeur incorrecte', {
			    append: false,
			    type: 'number',
			    classes: ['red-gradient']
			});
			return false;
	    }
	    for (i = 0; i < value; i++) {
			event.preventDefault();
			addBoisson(price, title, idBoisson, undefined);
	    }
	});
};

// fonction qui ajoute un element a la commande

function addBoisson(price, title, id, supplements) {
	var findArticle = undefined;
	notify('Ajout d\'un article', title, {
	    closeDelay: 500 
	});
	if(supplements != undefined) {
		if(supplements.length == 0){
			supplements = undefined;
		}
	}

	var article = {
	name: title,
	prix: price,
	id_article: id,
	supplements: supplements 
    }

    findArticle = app.collections.commande.findWhere({'id_article' : id});
    if(findArticle != undefined && JSON.stringify(findArticle.get('supplements')) == JSON.stringify(supplements)){
		count = findArticle.get('count') + 1;
		findArticle.set({'count' : count});
    }
    else{
    	app.collections.commande.add(article);
    }

    $('#commandeDetails').attr('open', 'open');
    updatePrixTotal();
}

// Function to update the total price

function updatePrixTotal() {
    var total = 0;
	app.collections.commande.each(function(article) {
		var articlePrix =  parseFloat(article.get('prix'));
		var supplements = article.get('supplements');
		var count = article.get('count');
		var prix_supplement = 0;
		if(supplements != undefined){
			$.each(supplements, function(i, supplement) {
				var prix_supplement = parseFloat(supplement['fois_prix']) * parseFloat(articlePrix) - parseFloat(articlePrix) + parseFloat(supplement['plus_prix']);
				articlePrix += prix_supplement;
			});
		}
		total += articlePrix.toFixed(2) * count;
	});    
    $('.total-euro').html(total.toFixed(2));
    var a_rendre = 0;

    $('#payment-block > .message').each(function(i) {
		nb_billet = 1;
		var prix = parseFloat($('.prix-billet', this).text());
		if ($('.count', this).length) nb_billet = $('.count', this).text();
		a_rendre += prix * nb_billet;
    });

   	a_rendre = total + a_rendre;
    if($('#payment-block > .message').length == 0 || a_rendre > 0){
    	a_rendre = 0;
    }
    $('.rendre-euro').html(Math.abs(a_rendre.toFixed(2)));


    var cashback = 0;
    if ($('.cashback').text()) {
	var prix = parseFloat($('.cashback').text());
	cashback = prix;
    }
    $('.cashback-euro').html(cashback.toFixed(2));

}

// supprime la commande actuelle

function clearCommande() {
    app.collections.commande.reset();
    $('p.message').remove();
    chargerPage('/');
    //we reset the table id
    $('#table-id').attr('value', '');
    $('#commande-id').attr('value', '');
    $('#imprimer').attr('title', 'Imprimer la commande');
    updatePrixTotal();
    isReady();
}

// Table sort - DataTables

function dataTableInit(id, options) {
    if(!options){
        var options = {}
    }
    if(!options['pagination']){
         option.pagination = 7;
    }
    var table = $('#' + id);
    table.dataTable({
	'bSort': false,
	'sPaginationType': 'full_numbers',
	'sDom': '<"dataTables_header"lfr>t<"dataTables_footer"ip>',
    "iDisplayLength": option.pagination,
	'bJQueryUI': true,
	'oLanguage': {
	    "sProcessing": "Traitement en cours...",
	    "sSearch": "Rechercher&nbsp;:",
	    "sLengthMenu": "Afficher _MENU_ &eacute;l&eacute;ments",
	    "sInfo": "Affichage de l'&eacute;lement _START_ &agrave; _END_ sur _TOTAL_ &eacute;l&eacute;ments",
	    "sInfoEmpty": "Affichage de l'&eacute;lement 0 &agrave; 0 sur 0 &eacute;l&eacute;ments",
	    "sInfoFiltered": "(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)",
	    "sInfoPostFix": "",
	    "sLoadingRecords": "Chargement en cours...",
	    "sZeroRecords": "Aucun &eacute;l&eacute;ment &agrave; afficher",
	    "sEmptyTable": "Aucune donnée disponible dans le tableau",
	    "oPaginate": {
		"sFirst": "Premier",
		"sPrevious": "Pr&eacute;c&eacute;dent",
		"sNext": "Suivant",
		"sLast": "Dernier"
	    },
	    "oAria": {
		"sSortAscending": ": activer pour trier la colonne par ordre croissant",
		"sSortDescending": ": activer pour trier la colonne par ordre décroissant"
	    }
	},
	'fnInitComplete': function(oSettings) {
	    // Style length select
	    table.closest('.dataTables_wrapper').find('.dataTables_length select').addClass('select glossy').styleSelect();
	    tableStyled = true;
	}
    });
}


// on referme le menu lors du click
$('.close-menu').click(function(event) {
    $('body').removeClass('menu-open');
})

function editRow(model, id) {
    // actions for modal's buttons
    var url;
    var buttons = {
	'Valider': function(modal) {
	    var form = $(this).parent().prev().find('form');
	    if(form.find('input:file').val() === '' || form.find('input:file').length === 0){
	    	validerForm(model, id);
	    }
	    else{
	    	form.submit();
	    }   	
	    modal.closeModal();
	},
	'Annuler': function(modal) {
	    modal.closeModal();
	}
    };
    if (!id) {
		url = '/new/' + model + '';
    } else {
		url = '/edit/' + model + '/' + id;
    }


    //$('#main').load(url);
    // creation modal
    if ($.template.mediaQuery.name === 'mobile-portrait'){
    	$('#main').load(url, function() {
	    	history.pushState(null, null, url);
			var button_cancel = $('<button type="button" class="goback button huge button huge">Annuler</button>');
			var button_ok = $('<button type="button" class="submit button huge blue-gradient mid-margin-left">Valider</button>');
			$('#button_container').append(button_cancel).append(button_ok);
		});
		$('.goback').live('click', function(event){
			event.preventDefault();
			window.history.back();
		});
		$('.submit').live('click', function(event){
			event.preventDefault();
			$('form').submit();
		});

	}else{
	    $.modal({
			title: 'Edition',
			resizable: false,
			scrolling: false,
			url: url,
			buttonsAlign: 'center',
			buttons: buttons,
	    });
	}
	return false;
};

function deleteRow(model, id) {
    var url = '/delete/' + model + '/' + id;
    $.ajax({
	type: 'GET',
	url: url,
    });
    $('#' + model + '-' + id).hide();
}

function deleteCommande(model, id) {
    var url = '/delete/' + model + '/' + id;
    $.ajax({
	type: 'GET',
	url: url,
    });
    $('#article-' + id).hide();
    $('#row-drop-' + id).hide();
    app.collections.commandeLive.remove(id);
}


function cloturer() {
    var url = '/cloture';
    $.ajax({
		type: 'GET',
		url: url,
    });
	notify('Succès', 'La caisse a été cloturée', {
	    closeDelay: 3000
	});
}

// fonction qui modifie des objets de manniere REST

function validerForm(model, id) {
    // validate and update data
    //if null -> create new one
    if (id == null) {
	var method = 'POST';
	var url = '/rest/' + model + '.xml';
    }
    // it's an update
    else {
	var method = 'PUT';
	var url = '/rest/' + model + '/' + id + '.xml';
    }
    // value to send
    var inputs = $('input, select').not('[value=""]').serialize();
    // send value
    $.ajax({
		type: method,
		url: url,
		data: inputs,
    });
    return false;
};


// fonction qui charge les différents modules via ajax
	$('#shortcuts > li > a').live('click', function (event) {
		chargerPage($(this).attr('href'));
		event.preventDefault();
	});


function chargerPage(page) {
    if (page == 'payment') {
	var url = '/payment';
    } else if (page == 'commande') {
	var url = '/';
    } else if (page == 'gestion/utilisateur') {
	var url = '/gestion/utilisateur';
    } else if (page == 'gestion/article') {
	var url = '/gestion/article';
    } else if (page == 'gestion/stock') {
	var url = '/gestion/stock';
    } else if (page == 'gestion/commande') {
	var url = '/gestion/commande';
    } else if (page == 'gestion/outils') {
	var url = '/gestion/outils';
    } else if (page == 'stat') {
	var url = '/stat';
    } else if (page == 'live') {
	var url = '/live';
    }
    $('.shortcuts-open').removeClass('shortcuts-open');
    $('#main').fadeOut(00);
    $('#load').fadeIn(400);
    //$('#main *').off();
    $('#main').load(page, function() {
    	$('#load').fadeOut(100, function () {
			$('#main').fadeIn(600, function () {});
			payment();
			history.pushState(null, null, page);
		});
    });
    $('body').removeClass('menu-hidden');
    return $('#main');
}



// change le statut d'une commande 

function setStatutCommande(id, statut) {
    var url = '/set/statut/commande/' + id + '/' + statut;
    $.ajax({
	type: 'GET',
	url: url,
	success: function() {
	    notify('Succès', 'Le statut de la commande a été modifié', {
		closeDelay: 3000
	    });
	    var commande = app.collections.commandeLive.get(id);
	    if ( commande != undefined) {
	    	commande.set({ statut_id: statut });
	    	if(statut == 4){
	    		//imprimerCommande(id);
	    	}
	    }
	    var commande = app.collections.commandeFullLive.get(id);
	    if ( commande != undefined) {
	    	commande.set({ statut_id: statut });
	    }
	}
    });

}


// retournes les articles d'une commande sous forme json et affiche un pop pour changer le statut de la commande
function getArticlesCommande(id) {
    article ='';
    $.getJSON('/get/commande/id/' + id + '.json', function(data) {
	$.each(data['articles'], function(key, val) {
		var supp ='<ul class="bullet-list">';
		for (var i = 0; i < val['supplements'].length; i++) {
			supp = supp + '<li>' + val['supplements'][i]['name'] +'</li>';
		};
		supp = supp + '</ul>';
	    article += '<h4 class="no-margin-bottom no-margin-top" ><span class="tag">' + val['count'] + '</span> x <strong> ' + val['name'] + ' </strong></h4>' + supp;
	});
    if(data['statut_commande'] == 4){
        var pret = 'Pas prête';
        var new_statut = 1;
    }else{
        var pret = 'Prête';
        var new_statut = 4;       
    }
	var buttons = {
	    'Encaisser': function(modal) {
		jsonCommande(id, '');
		$('.menu-open').removeClass('menu-open');
		modal.closeModal();

	    },
	    'Annuler': function(modal) {
		modal.closeModal();
	    }
	}; 
    buttons[pret] = function(modal) {
        setStatutCommande(id, new_statut);
        modal.closeModal();
        }
	$.modal({
	    content: article,
	    buttonsAlign: 'center',
	    buttons: buttons,
	});
    });    
}

// on supprime l'article et son objet javascript assoscié

function deleteArticleCommande(id) {
    findArticle = app.collections.commande.get(id);
    app.collections.commande.remove(findArticle);
    updatePrixTotal();
}



// on cache le menu sur la version mobile lors d'un clic sur le reste de la page
$('#main').click(function(event) {
    $('.shortcuts-open').removeClass('shortcuts-open');
});

// fonction qui met a jour la liste des commandes en cours

function live() {
	var commande;
	var url = '/live/commande/general';
	
	$.getJSON(url, function(data) {
		//app.collections.commandeLive.reset();
		// on va supprimer toutes les commandes qui ne sont pas présentes dans le flux live
		app.collections.commandeLive.each(function(model){
			var result = $.grep(data, function(e){ return e.id === model.get('id'); });
			if(result.length != 1){
				app.collections.commandeLive.remove(model.get('id'));
			}
		});
	    for (var i = 0; i < data.length; i++) {
			var commande = {
			    id: data[i]['id'],
			    serverPrenom: data[i]['serverPrenom'],
			    serverNom: data[i]['serverNom'],
			    table_id: data[i]['table_id'],
			    clientNom: data[i]['clientNom'],
			    statut_commande: data[i]['statut_commande'],
			    statut_id: data[i]['statut_id'],
			}
			if (app.collections.commandeLive.get(data[i]['id']) == undefined) {
			    app.collections.commandeLive.add(commande);
			    $('#commandeLiveDetails').attr('open', 'open');
			   	var titleNotif = 'Nouvelle commande';
			    notify('Notification', titleNotif, {
					closeDelay: 5000
			    });
			}else{
				commandeLive = app.collections.commandeLive.get(data[i]['id']);
				if(commandeLive.get('statut_id') != data[i]['statut_id']){
		    		var titleNotif = 'Commande prête';
				    notify('Notification', titleNotif, {
						closeDelay: 5000
				    });					
				}
				commandeLive.set({statut_id : data[i]['statut_id'] });

			}
	    }
	});
}

function launchFullScreen(element) {
    
		var e = document.getElementById(element);

		e.onclick = function() {
			$.modal.confirm('Activer le mode plein écran ?', function(){
				if (!RunPrefixMethod(document, "FullScreen") || !RunPrefixMethod(document, "IsFullScreen")) {
					RunPrefixMethod(e, "RequestFullScreen");
				}
			}, function(){});
			
			this.onclick = null;
		}

		var pfx = ["webkit", "moz", "ms", "o", ""];
		function RunPrefixMethod(obj, method) {
			
			var p = 0, m, t;
			while (p < pfx.length && !obj[m]) {
				m = method;
				if (pfx[p] == "") {
					m = m.substr(0,1).toLowerCase() + m.substr(1);
				}
				m = pfx[p] + m;
				t = typeof obj[m];
				if (t != "undefined") {
					pfx = [pfx[p]];
					return (t == "function" ? obj[m]() : obj[m]);
				}
				p++;
			}

		}
}

function isReady(){
	live();
    setInterval(live, 10000);
    // on empeche la selection et le click droit
    //document.oncontextmenu = new Function("return false");
	document.onselectstart = new Function ("return false");
    var first_init = false;
    // on s'occupe de l'historique
	window.addEventListener('popstate', function(e) {
		if(first_init == false){
			first_init = true;
		}
		else if(location.pathname != '/' && location.pathname != '/frontend_dev.php/' && location.pathname.indexOf("#") !== -1){
			chargerPage(location.pathname);
		}
	      
	});

}

$(document).ready(function() {
	//launchFullScreen('fullScreen');
	isReady();
	 
});
