<form method="POST" action="<?php echo url_for('stat')?>">
<div class="with-padding">

	<div class="columns no-margin">
		<!--
		<div class="margin-right margin-bottom">
			<h6>Selectionnez la periode</h6>
			<span class="button-group">
				<label for="radio-buttons-1" class="button green-active">
					<input onclick="listDay(actualYear, actualMonth, actualWeek)" type="radio" name="radio-buttons" id="radio-buttons-1" value="1">
					Jour
				</label>
				<label for="radio-buttons-2" class="button green-active">
					<input onclick="listMonth(actualYear)" type="radio" name="radio-buttons" id="radio-buttons-2" checked value="2">
					Mois
				</label>
				<label for="radio-buttons-3" class="button green-active">
					<input onclick="listYear()" type="radio" name="radio-buttons" id="radio-buttons-3" value="3">
					Année
				</label>
			</span>
		</div>
	-->
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
		
		<div class="margin-right">
			<h6>Selectionnez date de début</h6>
			<span class="input margin-bottom">			
				<span class="icon-calendar"></span>
				<input type="text" name="date-debut" value="<?php echo $dateDebut ?>" id="date-debut" class="datetimepicker input-unstyled datepicker" value="">
			</span>
			
			<h6>Début créneau horaire</h6>	
			<span class="input margin-bottom ">	
				<span class="icon-clock"></span>		
				<input type="text" name="heure-debut" value="<?php echo $heureDebut ?>"id="date-debut-heure" class="input-unstyled timepicker" value="">
			</span>			
		</div>
		<div class="margin-right margin-bottom">

			<h6>Selectionnez date de fin</h6>
			<span class="input margin-bottom">			
				<span class="icon-calendar"></span>
				<input type="text" name="date-fin" value="<?php echo $dateFin ?>" id="date-fin" class="datetimepicker input-unstyled datepicker" value="">
			</span>
			<h6>Fin créneau horaire</h6>	
			<span class="input margin-bottom ">	
				<span class="icon-clock"></span>		
				<input type="text" name="heure-fin" value="<?php echo $heureFin ?>" id="date-fin-heure" class="input-unstyled timepicker" value="">
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
		function listMonth(year){
			var listeM = '';
			var months = ['Janvier', 'Fevrier', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Aout', 'Septembre', 'Octobre', 'Novembre', 'Decembre'];
			for(var i = 0; i < months.length; i++){
				listeM += '<li><span class="event-date">' + (i+1) + '</span><a onclick="listWeek(' + year + ',' + i + ')" data-year="' + year + '" data-month="'+ i + '" href="#" class="event-description"><h4>' + months[i] + '</h4></a></li>';
			}
			$('#radio-buttons-2').attr('checked', true);
			$('#radio-buttons-2').parent().addClass('active');
			$('#radio-buttons-3').parent().removeClass('active');
			$('#radio-buttons-3').attr('checked', false);
			$('.events').html(listeM);
		}

		function listDay(year, month, week){
			xdate = new XDate();
			xdate.setWeek(1, year);
			xdate.addWeeks(week - 1);
			var listeM = '';
			var days = ['Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'];
			while(xdate.getMonth() != month){
				xdate.addDays(1);
			}
			while(xdate.getWeek() == week && xdate.getMonth() == month){
				listeM += '<li><span class="event-date">' + xdate.getDate() + '</span><a href="#" class="event-description"><h4>' + days[xdate.getDay()] + '</h4></a></li>';
				xdate.addDays(1);
			}
			$('.events').html(listeM);		
		}

		function listWeek(year, month){
			xdate = new XDate(year, month, 1, 0, 0, 0, 0);
			var listeM = '';
			while(xdate.getMonth() == month){
				var week = xdate.getWeek();
				listeM += '<li><span class="event-date">' + week + '</span><a onclick="listDay(' + year + ',' + month + ',' + week + ')" data-year="' + year + '" data-week="' + week +'" href="#" class="event-description"><h4>Semaine</h4></a></li>';
				xdate.addWeeks(1);
			}
			$('.events').html(listeM);
			$('#radio-buttons-1').attr('checked', true);
			$('#radio-buttons-1').parent().addClass('active');
			$('#radio-buttons-2').parent().removeClass('active');
			$('#radio-buttons-2').attr('checked', false);	
		}

		function listYear(){
			xdate = new XDate();
			var listeM = '';
			var year = xdate.getFullYear();
			for(var i = year; i >= year - 4; i--){
				listeM += '<li style="padding-left: 20px;"><a onclick="listMonth(' + i + ')" data-date="' + i + '"  href="#" class="event-description"><h4>' + i + '</h4></a></li>';
			}
			$('.events').html(listeM);	
		}
		//xdate = new XDate();
		//actualYear = xdate.getFullYear();
		//actualMonth = xdate.getMonth();
		//actualWeek = xdate.getWeek();
		//listMonth(actualYear);

        
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
		$(window).load(function(){ 
			var divWidth = $.template.mediaQuery.is('mobile') ? $( window ).width() : $( window ).width() - 450
			$.template.mediaQuery.is('mobile') 
			drawVisitorsChart(divWidth - 30);
			$(document).on('sizechange', function(event) { 
			var divWidth = $.template.mediaQuery.is('mobile') ? $( window ).width() : $( window ).width() - 450
			drawVisitorsChart(divWidth - 30); 
		});


		});


	</script>
