<?php use_helper('Thumb'); ?>
<noscript class="message black-gradient simpler">
    Your browser does not support JavaScript! Some features won't work as expected...
</noscript>


<div class="with-padding">

    <button onclick="editRow('GroupeReduction')" class="button right-side mid-margin-bottom green-gradient">New</button>
    <hgroup id="main-title" class="thin"><h1>Liste des groupes de réductions</h1></hgroup>

    <table class="table responsive-table" id="sorting-advanced">

        <thead>
            <tr>
                <th scope="col" >Nom du groupe</th>
                <th scope="col" class="align-center ">Actif</th>
                <th scope="col" class="align-center ">Réduction</th>
                <th scope="col" class="align-center">Editer</th>
                <th scope="col" class="align-center">Supprimer</th>
            </tr>
        </thead>

        <tfoot>

        </tfoot>

        <tbody>
            <?php foreach($groupes as $groupe): ?>
            <tr id="GroupeReduction-<?php echo $groupe->getId() ?>">
                <td><?php echo $groupe->getName() ?></td>
                <td><?php echo ($groupe->getIsActive() == 1) ? 'Oui' : 'Non' ?></td>
                <td class="low-padding align-center">
                    <button onclick="chargerPage('reduction/<?php echo $groupe->getId() ?>')" class="button compact icon-gear">
                    Voir
                    </button>
                </td>
                <td class="low-padding align-center">
                    <button onclick="editRow('GroupeReduction', <?php echo $groupe->getId() ?>)" class="button compact icon-gear">
                    Edit
                    </button>
                </td>
                <td class="hide-on-mobile low-padding align-center">
                    <button onclick="deleteRow('GroupeReduction', <?php echo $groupe->getId() ?>, 'delete')" class="button compact icon-gear">Delete</button>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>

    </table>

</div>
<script>
$(document).ready(function() {
    dataTableInit('sorting-advanced');
    $('input span').on('click', function(){
        alert('click');
    });
});
</script>