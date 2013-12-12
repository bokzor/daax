<li>
    <label for="id">Imprimera avec :</label>    
    <select name="rel[categoryImprimante][id][]" class="input" >
        <option value=""></option>
        <?php if(isset($imprimantes)): ?>
        <?php foreach($imprimantes as $imprimante): ?>
            <option value="<?php echo $imprimante->getId() ?>"><?php echo $imprimante->getName() ?></option>
        <?php endforeach; ?>
        <?php endif; ?>
    </select>
</li>