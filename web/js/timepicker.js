function isTouchDevice() {
  //if ($.template.mediaQuery.isSmallerThan('desktop'))
    return true;
    //return !!('ontouchstart' in window);
}

$(document).ready(function(){
  if(!isTouchDevice()){
    //Mouse powered calendar
    $('#date-debut').datetimepicker({
    	altField: "#date-debut-heure",
    });
   

    $('#date-fin').datetimepicker({
    	altField: "#date-fin-heure",

    });

    //Disable the user from manually entering values on the text field
    $('.datetimepicker').bind('keydown',function(e){
      $(this).attr('readonly', 'readonly');
      //Extra fun for working with backspace
      //we don't want the browser to go back in history if backspace is pressed
      if(e.keyCode == 8){
        e.preventDefault();
      }
    });

    //Remove readonly on keyup, so the form doesn't look weird 
    $('.datetimepicker').bind('keyup',function(){
      $(this).removeAttr('readonly');
    });


  }else{
    //Touch powered calendar
    $('.datetimepicker').scroller({
      preset: 'date',
      dateFormat:' mm/dd/yy',
      lang: 'fr',
      display: 'modal',
      mode: 'scroller'
    }); 
    
     $('.timepicker').scroller({
      preset: 'time',
      dateFormat:' mm/dd/yy',
      lang: 'fr',
      display: 'modal',
      mode: 'scroller'
    }); 
  }
});
