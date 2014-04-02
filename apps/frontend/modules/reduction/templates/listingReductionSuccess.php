<?php use_helper('Thumb'); ?>
<noscript class="message black-gradient simpler">
    Your browser does not support JavaScript! Some features won't work as expected...
</noscript>


<div class="with-padding">

    <button onclick="editRow('reductionArticle/<?php echo $id ?>')" class="button right-side mid-margin-bottom green-gradient">Nouvelle reduction sur un article</button>
    <button onclick="editRow('reductionCommande/<?php echo $id ?>')" class="button right-side mid-margin-bottom green-gradient">Nouvelle reduction sur la commande</button>

        <hgroup id="main-title" class="thin"><h1>Réductions sur articles</h1></hgroup>
        <table class="table responsive-table" id="sorting-advanced2">

        <thead>
            <tr>
                <th scope="col" >Nom de l'article</th>
                <th scope="col" >Actif ?</th>                
                <th scope="col" class="align-center ">Nombre acheté</th>
                <th scope="col" class="align-center ">Nombre offert</th>
                <th scope="col" class="align-center">Nouveau prix</th>
                <th scope="col" class="align-center">% Reduction</th>
                <th scope="col" class="align-center">Editer</th>
                <th scope="col" class="align-center">Supprimer</th>

            </tr>
        </thead>

        <tfoot>

        </tfoot>

        <tbody>
            <?php foreach($reductionsArticle as $reduction): ?>
            <tr id="reduction-<?php echo $reduction->getId() ?>">
                <td><?php if(is_object($reduction->getArticle())) echo $reduction->getArticle()->getName() ?></td>
                <td><?php echo ($reduction->getIsPublish() == 1) ? 'Oui' : 'Non' ?></td>
                <td class="low-padding align-center">
                    <?php echo $reduction->getNbAcheter() ?>
                </td>
                <td class="low-padding align-center">
                    <?php echo $reduction->getNbOffert() ?>
                </td>
                <td class="low-padding align-center">
                    <?php echo $reduction->getNewPrice() ?>
                </td>
                <td class="low-padding align-center">
                    <?php echo $reduction->getPourcentArticle() ?>
                </td>
                <td class="low-padding align-center">
                    <button onclick="editRow('Reduction', <?php echo $reduction->getId() ?>)" class="button compact icon-gear">
                    Edit
                    </button>
                </td>
                <td class="hide-on-mobile low-padding align-center">
                    <button onclick="deleteRow('Reduction', <?php echo $reduction->getId() ?>, 'delete')" class="button compact icon-gear">Delete</button>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>

    </table>

  <hgroup id="main-title" class="thin"><h1>Réductions sur commande</h1></hgroup>
  <table class="table responsive-table" id="sorting-advanced">

        <thead>
            <tr>
                <th scope="col" >Actif ?</th>                
                <th scope="col" class="align-center">% Reduction</th>
                <th scope="col" class="align-center">Editer</th>
                <th scope="col" class="align-center">Supprimer</th>

            </tr>
        </thead>

        <tfoot>

        </tfoot>

        <tbody>
            <?php foreach($reductionsCommande as $reduction): ?>
            <tr id="reduction-<?php echo $reduction->getId() ?>">
                <td><?php echo ($reduction->getIsPublish() == 1) ? 'Oui' : 'Non' ?></td>
                <td class="low-padding align-center">
                    <?php echo $reduction->getPourcentCommande() ?>
                </td>
                <td class="low-padding align-center">
                    <button onclick="editRow('Reduction', <?php echo $reduction->getId() ?>)" class="button compact icon-gear">
                    Edit
                    </button>
                </td>
                <td class="hide-on-mobile low-padding align-center">
                    <button onclick="deleteRow('Reduction', <?php echo $reduction->getId() ?>, 'delete')" class="button compact icon-gear">Delete</button>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>

    </table>

</div>
<script>
$(document).ready(function() {
    dataTableInit('sorting-advanced');
    dataTableInit('sorting-advanced2');

});
</script>