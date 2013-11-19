<?php slot('sousmenu') ?>
<?php end_slot() ?>
<?php slot('404') ?>
<?php end_slot() ?>
 <div class="d-cont rounded">
		<div class="p404">
        	<h1>404 Error</h1>
            <h2>Ohh... You have requested the page that is no longer there. </h2>
            <div class="toolbar404">
           	  <div class="search_bar">
           	    <form id="form1" name="form1" method="post" action="<?php echo url_for('@search')?>">
					<input type="text" name="textfield" id="textfield" class="inp inp_check" title="Search" value="Search" />
					<input type="submit" name="button" id="button" value="" class="btn_search_lt" />
           	    </form>
       	      </div>
                <div class="clear"></div>
          </div>
      </div>
  </div>