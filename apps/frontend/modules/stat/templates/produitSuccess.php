<?php include_partial('home/optionsStat') ?>
<form method="POST" action="">
<div class="with-padding">

	<div class="columns no-margin">
		
		<div class="margin-right">
			<h6>Selectionnez date de début</h6>
			<span class="input margin-bottom">			
				<span class="icon-calendar"></span>
				<input type="text" name="date-debut" value="<?php echo $dateDebut ?>" id="date-debut" class="datetimepicker input-unstyled datepicker" value="">
			</span>

		</div>
		<div class="margin-right margin-bottom">

			<h6>Selectionnez date de fin</h6>
			<span class="input margin-bottom">			
				<span class="icon-calendar"></span>
				<input type="text" name="date-fin" value="<?php echo $dateFin ?>" id="date-fin" class="datetimepicker input-unstyled datepicker" value="">
			</span>

		</div>
		
	</div>
    <button type="submit" class="button mid-margin-right">
        <span class="green-gradient button-icon"><span class="icon-tick"></span></span>
        Valider
    </button>
</div>
</form>


<div class="with-padding">



	<table class="table responsive-table" id="sorting-advanced">

		<thead>
			<tr>
				<th scope="col" >Nom</th>
				<th scope="col" width="10%" class="align-center ">Vente</th>
			</tr>
		</thead>

		<tfoot>

		</tfoot>

		<tbody>
			<?php foreach($articles as $article): ?>
			<tr id="article-<?php echo $article->getId() ?>">
				<td><?php echo $article->getArticle()->getName() ?></td>
				<td><?php echo $article->getCount() ?></td>							
			</tr>
			<?php endforeach; ?>
		</tbody>

	</table>

</div>
<script>
$(document).ready(function() {
	var options = {'pagination' : -1 };
	options = {'aaSorting' : [[2, 'asc']]}; 
	dataTableInit('sorting-advanced', options);
});
</script>