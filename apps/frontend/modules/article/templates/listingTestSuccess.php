<script>
$(document).ready(function () {

if(app.collections.articles!==undefined){
    grid();
}
});

    document.addEventListener('appInit', function (e) {
      grid();
    }, false); 
</script>
<div id="test">
</div>

