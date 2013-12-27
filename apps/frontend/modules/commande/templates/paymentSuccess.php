<?php use_helper('Thumb'); ?>

<noscript class="message black-gradient simpler">
	Your browser does not support JavaScript! Some features won't work as expected...
</noscript>

<hgroup id="main-title" class="thin">
	<h1>Encaisser la commande</h1>
</hgroup>

<div class="with-padding">

	<div class="columns">
		<div class="twelve-columns twelve-columns-tablet">

			<div class="side-tabs margin-bottom">
				<ul class="tabs">
					<li class="active">
						<a class="" style="color:#f1f1f1;" href="#sidetab-1">Cash</a>
					</li>
					<li>
						<a class="" style="color:#f1f1f1; border-top: 2px solid #F7F7F7;" href="#sidetab-2">Bancontact</a>
					</li>

				</ul>

				<div class="tabs-content">
					<div id="sidetab-1" class="with-padding">
						<button id="montantPerso" step="any" class="mid-margin-bottom button huge full-width">Montant personnalisé</button>
						<button onclick="encaisser(2)" step="any" class="mid-margin-bottom button huge full-width">Valider</button>
						<button onclick="encaisser(-2)" step="any" class="mid-margin-bottom button huge full-width">Offrir</button>
						<ul class="gallery" >
							<li style="padding: 5px;" class='mid-margin-right'>
								<a data-price="-5" class="payment" data-title="Billet de 5 euros" title="" href="#"> 									<img src="/uploads/payment/5.png" height="100px" width="150px" />
</a>
							</li>
							<li style="padding: 5px;" class='mid-margin-right'>
								<a data-price="-10" class="payment" data-title="Billet de 10 euros" title="" href="#">
								<img src="/uploads/payment/10.jpg" height="100px" width="150px" />
								</a>
							</li>
							<li style="padding: 5px;" class='mid-margin-right'>
								<a data-price="-20" class="payment" data-title="Billet de 20 euros" title="" href="#">
								<img src="/uploads/payment/20.jpeg" height="100px" width="150px" /></a>
							</li>
							<li style="padding: 5px;" class='mid-margin-right'>
								<a data-price="-50" class="payment" data-title="Billet de 50 euros" title="" href="#">								<img src="/uploads/payment/50.png" height="100px" width="150px" />
 </a>
							</li>
							<li style="padding: 5px;" class='mid-margin-right'>
								<a data-price="-100" class="payment" data-title="Billet de 100 euros" title="" href="#">
								<img src="/uploads/payment/100.png" height="100px" width="150px" />
							</li>
							<li style="padding: 5px;" class='mid-margin-right'>
								<a data-price="-2" class="payment" data-title="Pièce de 2 euros" title="" href="#"> 				<img src="/uploads/payment/2.png" height="100px" width="100px" />
 </a>
							</li>
							<li style="padding: 5px;" class='mid-margin-right'>
								<a data-price="-1" class="payment" data-title="Pièce de 1 euros" title="" href="#">
								<img src="/uploads/payment/1.png" height="100px" width="100px" /> </a>
							</li>
							<li style="padding: 5px;" class='mid-margin-right'>
								<a data-price="-0.5" class="payment" data-title="Pièce de 50 cents" title="" href="#"> 									<img src="/uploads/payment/0.5.png" height="100px" width="100px" /> </a>
 </a>
							</li>
							<li style="padding: 5px;" class='mid-margin-right'>
								<a data-price="-0.2" class="payment" data-title="Pièce de 20 cents" title="" href="#"> 								<img src="/uploads/payment/0.2.png" height="100px" width="100px" /> </a>
</a>
							</li>
							<li style="padding: 5px;" class='mid-margin-right'>
								<a data-price="-0.1" class="payment" data-title="Pièce de 10 cents" title="" href="#">						<img src="/uploads/payment/0.1.png" height="100px" width="100px" /> </a>
</a>
							</li>
						</ul>

					</div>
					<div id="sidetab-2" class="with-padding">
						<button onclick="encaisser(1)" id="validerBancontact" class="mid-margin-top button huge full-width">Valider</button>
						<button id="ajoutCashback" class="mid-margin-top button huge full-width">Cashback</button>
					</div>
				</div>
			</div>
		</div>

	</div>

</div>
<script>
	$('ul.gallery li a.payment').click(function(event) {
		var title = $(this).data('title');
		var price = $(this).data('price');
		event.preventDefault();
		// Auto-close delay
		autoCloseDelay = parseInt($('#autoclose-delay').val(), 10) || 0;
		// Gather options
		addPaiement(price, title);
	});

	$('#montantPerso').click(function(event) {
		$.modal.prompt('Entrez le montant', function(value)
		{
			//value.replace(",","."); 
			value = parseFloat('-'+value);

			if (isNaN(value))
			{
				$(this).getModalContentBlock().message('Valeur incorrecte', { append: false, type: 'number', classes: ['red-gradient'] });
				return false;
			}					
			event.preventDefault();
			// Auto-close delay
			autoCloseDelay = parseInt($('#autoclose-delay').val(), 10) || 0;
			// Gather options
			addPaiement(value, 'Montant perso');
			updatePrixTotal();								
		
		});	
	});	

	
	function addPaiement(price, title){
		$('#payment-block').message( title + '<span class="align-right list-count"><span class="prix-billet">' + price + '</span> euros</span>', {
			position : 'top',
			append : $('#append-1').prop('checked'),
			classes : [$('#color').val()],
			arrow : $('#arrow').prop('checked') ? ($('#arrow-direction-top').prop('checked') ? 'top' : 'bottom') : false,
			closable : true,
			showCloseOnHover : false,
			groupSimilar : $('#group-similar').prop('checked'),
		});
		if ($.template.mediaQuery.isSmallerThan('tablet-portrait'))
		{
			notify('Ajout d\'une somme', title, { closeDelay : 1000});
		}
		updatePrixTotal();
	
	}



	$('#ajoutCashback').click(function(event) {
		$.modal.prompt('Entrez le montant', function(value)
		{
			value = parseInt(value);
			if (isNaN(value))
			{
				$(this).getModalContentBlock().message('Valeur incorrecte', { append: false, type: 'number', classes: ['red-gradient'] });
				return false;
			}	
					
				event.preventDefault();
				// Auto-close delay
				autoCloseDelay = parseInt($('#autoclose-delay').val(), 10) || 0;
				// Gather options
				$('#message-block').message('Cashback' + '<span class="align-right list-count"><span class="cashback prix-boisson">' + value + '</span> euros</span>', {
					position : 'top',
					append : $('#append-1').prop('checked'),
					classes : [$('#color').val()],
					arrow : $('#arrow').prop('checked') ? ($('#arrow-direction-top').prop('checked') ? 'top' : 'bottom') : false,
					closable : true,
					showCloseOnHover : false,
					groupSimilar : $('#group-similar').prop('checked'),
				});

				updatePrixTotal();								
		});	
	});
</script>