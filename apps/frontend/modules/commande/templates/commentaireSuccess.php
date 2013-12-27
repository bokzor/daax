<script>
document.getElementById('commentaire').focus();
</script>
<textarea name="autoexpanding" id="commentaire" class="virtual-pad input full-width autoexpanding" style="overflow: hidden; resize: none; height: 200px;">

</textarea>
<script>
$('#commentaire').val(app.collections.commande.get('<?php echo $cid ?>').get('comment'));
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
        $('.virtual-pad').keypad('show');
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
    $('.virtual-pad').keypad('show');
}

</script>