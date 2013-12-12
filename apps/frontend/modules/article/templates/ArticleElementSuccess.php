<li>
    <label for="id">Décompte le stock :</label>    
    <select name="rel[articleElement][id][]" class="input" >
        <option value=""></option>
        <?php if(isset($elements)): ?>
        <?php foreach($elements as $element): ?>
            <option value="<?php echo $element->getId() ?>"><?php echo $element->getName() ?></option>
        <?php endforeach; ?>
        <?php endif; ?>
    </select>
</li>
<li>
        <label for="article_temps_prepa">Nombre a décompter:</label>
        <input class="input" type="number" step="0.01" value="0" placeholder='Quantitée a déduire du stock' name="rel[articleElement][deduire][]"/> 
</li>