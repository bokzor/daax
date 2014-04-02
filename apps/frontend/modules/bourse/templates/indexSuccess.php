<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <style type="text/css">
/*<![CDATA[*/

        body, html  { height: 100%; }
        html, body, div, span, applet, object, iframe,
        /*h1, h2, h3, h4, h5, h6,*/ p, blockquote, pre,
        a, abbr, acronym, address, big, cite, code,
        del, dfn, em, font, img, ins, kbd, q, s, samp,
        small, strike, strong, sub, sup, tt, var,
        b, u, i, center,
        dl, dt, dd, ol, ul, li,
        fieldset, form, label, legend,
        table, caption, tbody, tfoot, thead, tr, th, td {
        margin: 0;
        padding: 0;
        border: 0;
        outline: 0;
        font-size: 115%;
        vertical-align: baseline;
        background: transparent;
        }
        body { line-height: 1; }
        ol, ul { list-style: none; }
        blockquote, q { quotes: none; }
        blockquote:before, blockquote:after, q:before, q:after { content: ''; content: none; }
        :focus { outline: 0; }
        del { text-decoration: line-through; }
        table {border-spacing: 0; } /* IMPORTANT, I REMOVED border-collapse: collapse; FROM THIS LINE IN ORDER TO MAKE THE OUTER BORDER RADIUS WORK */

        /*------------------------------------------------------------------ */

        /*This is not important*/
        body{
        font-family:Arial, Helvetica, sans-serif;
        overflow:hidden; 

        }
        a:link {
        color: #666;
        font-weight: bold;
        text-decoration:none;
        }
        a:visited {
        color: #666;
        font-weight:bold;
        text-decoration:none;
        }
        a:active,
        a:hover {
        color: #bd5a35;
        text-decoration:underline;
        }


        /*
        Table Style - This is what you want
        ------------------------------------------------------------------ */
        table a:link {
        color: #666;
        font-weight: bold;
        text-decoration:none;
        }
        table a:visited {
        color: #999999;
        font-weight:bold;
        text-decoration:none;
        }
        table a:active,
        table a:hover {
        color: #bd5a35;
        text-decoration:underline;
        }
        table {
        font-family:Arial, Helvetica, sans-serif;
        color:#FFF;
        font-size:12px;
        background:#eaebec;
        margin: auto;
        border:#ccc 1px solid;
        width: 100%;

        -moz-border-radius:3px;
        -webkit-border-radius:3px;
        border-radius:3px;

        -moz-box-shadow: 0 1px 2px #d1d1d1;
        -webkit-box-shadow: 0 1px 2px #d1d1d1;
        box-shadow: 0 1px 2px #d1d1d1;
        }
        table th {
        padding:21px 25px 22px 25px;
        border-top:1px solid #fafafa;
        border-bottom:1px solid #e0e0e0;


        background: #ededed;
        background: -webkit-gradient(linear, left top, left bottom, from(#071918), to(#071418));
        background: -moz-linear-gradient(top,  #ededed,  #ebebeb);
        }
        table th:first-child{
        text-align: left;
        padding-left:20px;
        }
        table tr:first-child th:first-child{
        -moz-border-radius-topleft:3px;
        -webkit-border-top-left-radius:3px;
        border-top-left-radius:3px;
        }
        table tr:first-child th:last-child{
        -moz-border-radius-topright:3px;
        -webkit-border-top-right-radius:3px;
        border-top-right-radius:3px;
        }
        table tr{
        text-align: center;
        padding-left:20px;

        }
        table tr td:first-child{
        text-align: left;
        padding-left:20px;
        border-left: 0;
        }
        table tr td {
        padding:18px;
        border-top: 1px solid #ffffff;
        border-bottom:1px solid #e0e0e0;
        border-left: 1px solid #e0e0e0;

        background: #fafafa;
        background: -webkit-gradient(linear, left top, left bottom, from(#071918), to(#071418));
        background: -moz-linear-gradient(top,  #fbfbfb,  #fafafa);
        }
        table tr.even td{
        background: #f6f6f6;
        background: -webkit-gradient(linear, left top, left bottom, from(#424242), to(#071918));
        background: -moz-linear-gradient(top,  #f2f2f2,  #f0f0f0);
        }
        table tr:last-child td{
        border-bottom:0;
        }
        table tr:last-child td:first-child{
        -moz-border-radius-bottomleft:3px;
        -webkit-border-bottom-left-radius:3px;
        border-bottom-left-radius:3px;
        }
        table tr:last-child td:last-child{
        -moz-border-radius-bottomright:3px;
        -webkit-border-bottom-right-radius:3px;
        border-bottom-right-radius:3px;
        }


    .fixed-table-container {
      width: 100%;
      height: 100%;
      /* above is decorative or flexible */
      position: relative; /* could be absolute or relative */
      padding-top: 30px; /* height of header */
    }

    .fixed-table-container-inner {
      overflow-x: hidden;
      overflow-y: auto;
      height: 100%;
    }
     
    .header-background {
      height: 45px; /* height of header */
      position: absolute;
      top: 0px;
      right: 0;
      left: 0;
      border-top:1px solid #fafafa;
      border-bottom:1px solid #e0e0e0;
      background: #ededed;
      background: -webkit-gradient(linear, left top, left bottom, from(#071918), to(#071418));
      background: -moz-linear-gradient(top,  #ededed,  #ebebeb);
    }
    
    table {
      background-color: white;
      width: 100%;
    }

    .th-inner {
      position: absolute;
      top: 5px;
      line-height: 30px; /* height of header */
      text-align: left;
      border-left: 1px solid black;
      padding-left: 5px;
      margin-left: -5px;
    }
    .first .th-inner {
        border-left: none;
        padding-left: 6px;
      }
        

    /* for hidden header hack to calculate widths of dynamic content */
    
    .hidden-head {
      min-width: 530px; /* enough width to show all header text, or bad things happen */
    }
    
    .hidden-header .th-inner {
      position: static;
      overflow-y: hidden;
      height: 0;
      white-space: nowrap;
      padding-right: 5px;
    }
    

    

        /*]]>*/
        </style>
        <script src="/js/libs/modernizr.custom.js"></script>
        <script src="/js/libs/jquery-1.8.2.min.js"></script>
        <script src="/js/libs/backbones/underscore-min.js"></script>
        <script src="/js/libs/backbones/backbone-min.js"></script>
        <script src="/js/bourse/main.js"></script>
        <script src="/js/bourse/models.js"></script>
        <script src="/js/bourse/views.js"></script>

    </head>
    <body>
    <div class="fixed-table-container">
        <div class="header-background"> </div>
        <div class="fixed-table-container-inner">
        <table id="bourseTable" cellspacing='0'>
            <thead>
                <tr>
                    <th class="first"><div class="th-inner">Intitulé</div></th>
                    <th class="second"><div class="th-inner">Prix de base</div></th>
                    <th class="third"><div class="th-inner">Prix actuel</div></th>
                    <th class="fourth"><div class="th-inner">Variation</div></th>
                </tr>
            </thead>
        <tbody id="bourseContainer">

        </tbody>       

        </table>
    </div>
    </div>



<script type="text/template" id="bourse">

        <% _.each(bourse, function (bours, i) { %>
            <% if(bours.prix < bours.prixBase) { 
                var color = 'red';
            }else{
                var color = 'green';
            }
            var classe = '';

            if(i%2==0){
                var classe='even'
                var orange="color: #E18700";
            }else{
                var orange="color: #E18700";
            }
            %>

            <tr class='<%= classe %>'>
                <td><%= bours.name %></td>
                <td><%= bours.prixBase %></td>
                <td style="<%= orange %>"><b><%= bours.prix %></b></td>
                <td><%= bours.variation %> %<img height=20 width=20 src='/image/bourse/<%= color %>.png'/></td>

            </tr>
        <% }); %>
</script>


<script>
// fonction qui met a jour la liste des commandes en cours

function majBourse() {
    var bourse;
    var url = "/bourse.json";
    $.getJSON(url, function(data) {
        if(data != undefined){
            for (var i = 0; i < data.length; i++) {
                var bourse = {
                    id: data[i]['id'],
                    name: data[i]['name'],
                    prixBase: data[i]['prixBase'],
                    prix: data[i]['prix'],
                    variation: data[i]['variation'],
                }

                if (app.collections.bourse.get(data[i]['id']) == undefined) {
                    app.collections.bourse.add(bourse);
                }else{
                    app.collections.bourse.get(data[i]['id']).set('prix', data[i]['prix']);
                    app.collections.bourse.get(data[i]['id']).set('variation', data[i]['variation']);

                }
            }
        }

        var time = 0.5 * app.collections.bourse.length * 1000;
        var height = 64 * app.collections.bourse.length;
        function goDown(time, height){
            $(".fixed-table-container-inner").animate({
                 scrollTop: height
               },
               {
                 easing: 'linear',
                 duration: time,
                 complete: function(){
                    goUp(time, height);
                }
            });

        }
        function goUp(time, height){
            $(".fixed-table-container-inner").animate({
                 scrollTop: 0
               },
               {
                 easing: 'swing',
                 duration: time,
                 complete: function(){
                    goDown(time, height);

                }
            });


        }

        (function($) {
            $.fn.has_scrollbar = function() {
                var divnode = this.get(0);
                if(divnode.scrollHeight > divnode.clientHeight)
                    return true;
            }
        })(jQuery);

        if (Modernizr.touch){
          $('body').css('overflow', 'scroll');
        } else {
            if(activate == 0){
               goDown(time, height);   
               activate = 1; 
            }         
        }


    });

}

$(document).ready(function() {
    activate = 0;
    app.init2();
    new app.Views.bourse({el : $('#bourseContainer'), collection : app.collections.bourse});
    majBourse();
    majBourse = setInterval(majBourse, 1000);



});
</script>


    </body>
</html>
