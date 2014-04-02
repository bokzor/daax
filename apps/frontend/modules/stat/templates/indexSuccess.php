<?php include_partial('home/optionsStat') ?>
<form method="POST" action="<?php echo url_for('stat')?>">
<div class="with-padding">

	<div class="columns no-margin">
		<div class="margin-right margin-bottom">
			<h6>Selectionnez les serveurs</h6>
			<p class="button-height">
				<select name="serveur_id[]" class="select multiple-as-single allow-empty easy-multiple-selection check-list" multiple>
					<?php foreach($serveurs as $serveur): ?>
					<option value="<?php echo $serveur->getId()?>"><?php echo $serveur->getFirstName().' '.$serveur->getLastName()?></option>
					<?php endforeach; ?>
				</select>
			</p>
		</div>
		
		<div class="margin-right margin-bottom">
			<h6>Début de la période</h6>
			<span class="input margin-bottom">			
				<span class="icon-calendar"></span>
				<input type="text" name="date-debut" value="<?php echo $dateDebut ?>" id="date-debut" class="datetimepicker input-unstyled datepicker" value="">
			</span>

		</div>
		<div class="margin-right margin-bottom">

			<h6>Fin de la période</h6>
			<span class="input margin-bottom">			
				<span class="icon-calendar"></span>
				<input type="text" name="date-fin" value="<?php echo $dateFin ?>" id="date-fin" class="datetimepicker input-unstyled datepicker" value="">
			</span>

		</div>
		<div class="margin-right margin-bottom">

			<h6>Début du créneau horaire</h6>
			<span class="input margin-bottom">			
				<span class="icon-calendar"></span>
				<input type="text" name="heure-debut" value="<?php echo $heureDebut ?>" id="date-fin" class="timepicker input-unstyled datepicker" value="">
			</span>

		</div>
		<div class="margin-right margin-bottom">

			<h6>Fin du créneau horaire</h6>
			<span class="input margin-bottom">			
				<span class="icon-calendar"></span>
				<input type="text" name="heure-fin" value="<?php echo $heureFin ?>" id="date-fin" class="timepicker input-unstyled datepicker" value="">
			</span>

		</div>		
	</div>
    <button type="submit" class="button mid-margin-right">
        <span class="green-gradient button-icon"><span class="icon-tick"></span></span>
        Valider
    </button>
</div>
</form>

<div id="dashboard" class="dashboard">
	<div class="left-column-200px margin-bottom">
		<div  class="left-column">
			<a style="font-size: 30px; line-height: 30px; height: 30px;" href="#"> <strong><?php echo $chiffreAffaire ?> €</strong></a>
			<br />
			<span style="font-size: 16px; line-height: 16px;" >Chiffre d'affaire</span>
		</div>
		<div  class="right-column">
			<a style="font-size: 30px; line-height: 30px; height: 30px;" href="#"> <strong><?php echo $chiffreAffaire - $prixTotal ?> €</strong></a>
			<br />
			<span style="font-size: 16px; line-height: 16px;" >Bénéfice</span>
		</div>
	</div>
	<div class="columns">
			<div class="threes-columns">
			<ul class="events">
			
			</ul>
		</div>
		<div style="margin-left:0px;" class="nine-columns twelve-columns-mobile" id="demo-chart">

		<!-- This div will hold the chart generated in the footer -->
		</div>



	</div>

</div>


	<script type="text/javascript" src="/js/google_chart_api/01.js"></script>

	<script type="text/javascript" src="/js/google_chart_api/04.js"></script>
	<script>
		

        
		var chartInit = false;
		function drawVisitorsChart(divWidth)
		{ 
			// Create our data table.
			var data = new google.visualization.DataTable();
			var raw_data = [
            <?php foreach($sf_data->getRaw('statValue') as $value): ?>
            	<?php if($value[0]!=''): ?>
                [<?php echo implode($value, ','); ?>],
                <?php endif; ?>
			<?php endforeach; ?>];

		


			var months = [<?php echo $sf_data->getRaw('intervale'); ?>];

			data.addColumn('string', 'Month');
			for (var i = 0; i < raw_data.length; ++i)
			{
				data.addColumn('number', raw_data[i][0]);
			}

			data.addRows(months.length);

			for (var j = 0; j < months.length; ++j)
			{
				data.setValue(j, 0, months[j]);
			}
			for (var i = 0; i < raw_data.length; ++i)
			{
				for (var j = 1; j < raw_data[i].length; ++j)
				{
					data.setValue(j-1, i+1, raw_data[i][j]);
				}
			}

			// Create and draw the visualization.
			// Learn more on configuration for the LineChart: http://code.google.com/apis/chart/interactive/docs/gallery/linechart.html
			var div = $('#demo-chart');
		
			new google.visualization.AreaChart(div.get(0)).draw(data, {
				title: 'Chiffre d\'affaire par serveur',
				width: divWidth,
				height: $.template.mediaQuery.is('mobile') ? 180 : 365,
				//height: 365,
				yAxis: {title: '(thousands)'},
				backgroundColor: ($.template.ie7 || $.template.ie8) ? '#494C50' : 'transparent',	// IE8 and lower do not support transparency
				//backgroundColor: 'transparent',
				legendTextStyle: { color: 'white' },
				titleTextStyle: { color: 'white' },
				hAxis: {
					textStyle: { color: 'white' },
					textPosition: 'none',

				},
				vAxis: {
					textStyle: { color: 'white' },
					baselineColor: '#666666',
				},
				chartArea: {
					top: 35,
					left: 50,
					width: divWidth-150
				},
				legend: 'right'
			});

			// Ready
			chartInit = true;
		};

		// Load the Visualization API and the piechart package.
		google.load('visualization', '1', {
			'packages': ['corechart']
		});


		// Set a callback to run when the Google Visualization API is loaded.
		//google.setOnLoadCallback(drawVisitorsChart);

		// Watch for block resizing
		//$('#demo-chart').widthchange(drawVisitorsChart);

		// Respond.js hook (media query polyfill)
		$(window).ready(function(){ 

		    $('.datetimepicker').datetimepicker({
		        timepicker:false,
		        lang: 'fr',
		        format:'m/d/Y'
		    });
		    $('.timepicker').datetimepicker({
		        datepicker:false,
		        format:'H:i',
		        lang: 'fr'
	    	});
		});

		$(window).load(function(){
			var divWidth = $.template.mediaQuery.is('mobile') ? $( window ).width() : $( window ).width() - 450
			$.template.mediaQuery.is('mobile') 
			drawVisitorsChart(divWidth - 30);
			$(document).on('sizechange', function(event) { 
				var divWidth = $.template.mediaQuery.is('mobile') ? $( window ).width() : $( window ).width() - 450
				drawVisitorsChart(divWidth - 30); 
			});
		})


	</script>
