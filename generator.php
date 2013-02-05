<?php
$option = '';
foreach(glob('static/fonts/*.ttf') as $key => $value)
{
  preg_match('#([^/]+).ttf$#', $value, $matches);
  $font = $matches[1];
  $option .= '<option value="'.$font.'">'.$font.'</option>';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />

	<title>Fonterator &bull; Generator</title>
	<meta name="author" content="Webarto" />

<style type="text/css">
header,section,footer,aside,nav,article,figure{display:block;}
*{margin:0;padding:0;}
body{background:#fff;color:#333;font-size:16px;font-family:Garamond,Georgia,Times,serif;line-height:1.429;margin:0;padding:0;text-align:left;padding:20px 50px;}
h1,h2,h3{margin-bottom:20px;}
li{margin:5px 0;}
h1{font-size:3em;}
h2{font-size:1.571em;}
a{outline:0;}
a img{border:0;text-decoration:none;}
a:link,a:visited{color:#FD105D;text-decoration:none;}
a:hover,a:active{text-shadow:0 0 1em #FD105D;text-decoration:none;}
strong,b{font-weight:bold;}
em,i{font-style:italic;}
::-moz-selection{background:#FD105D;color:#fff;}
::selection{background:#FD105D;color:#fff;}
.wrapper{width:300px;margin-right:50px;float:left;height:auto;}
.clear{clear:both;visibility:hidden;}
.left{float:left;}
.right{float:right;}
ul{list-style-type:none;}
li{background:transparent url(http://www.site5.com/images/bullet_pink_prices.png) no-repeat left 11px;padding-left:32px;}
input,select{padding:5px;font-size:18px;font-weight:bold;font-family:Garamond,Georgia,Times,serif;margin:5px 0;min-width:290px;}
input[type=checkbox]{min-width:auto !important;}
#image{padding-top:50px;text-align:center;width:300px;}
.color{display:inline-block;padding:5px;border:1px solid #333;margin:1.5px;}
hr{margin:20px 0;}
</style>

<script src="http://code.jquery.com/jquery-1.8.3.min.js"></script>

<script type="text/javascript">

var httpHost = 'http://fonterator.raska.in';

function colorlovers(data)
{
  $.each(data, function(index, value)
  {
    $('<div/>', {'class': 'color'})
    .css('background-color', '#' + value.hex)
    .data('hex', value.hex)
    .attr('title', value.title + ' @colorlovers')
    .appendTo('#colorlovers');
  });
}

$(document).ready(function(){
  
  $('select[name=family] option[value=Lobster]').attr('selected', 'selected');
  
  $('button').click(function(e){
    e.preventDefault();
    
    var image = $('#image img');
    var url = '';

    var font = $('select[name=family] option:selected').attr('value');

    if(font)
    {
      url += '/family/' + font;
    }
    
    $('#params input').each(function(){
      if($(this).val())
        url += '/' + $(this).attr('name') + '/' + $(this).val();  
    });

    if($('input[name=cache]').attr('checked'))
    {
      url += '/cache/0';
    }
    if($('input[name=shadow]').attr('checked'))
    {
      url += '/shadow/1';
    }
      
    if($('input[name=base64]').attr('checked'))
    {
      url = '/' + window.btoa(url) + '.png';
    }
    
    image.attr('src', url);
    $('input[name=url]').val(httpHost + url);
    
  });

$(document).on('click', '.color', function(e){
  $('input[name=color]').val($(this).data('hex'));
});

$.getScript('http://www.colourlovers.com/api/colors/top?numResults=60&format=json&jsonCallback=colorlovers');

});
</script>
</head>
<body>

<div class="wrapper">

<h2>Fonterator</h2>

<form method="GET">

  <div id="params">
    <div><select name="family"><?=$option?></select></div>
    <div><input name="color" value="" placeholder="Color (#ffffff)" /></div>
    <div id="colorlovers"></div>
    <div><input name="gradient_1" value="" placeholder="Gradient color 1"  /></div>
    <div><input name="gradient_2" value="" placeholder="Gradient color 2"  /></div>
    <p>* Color is ignored if gradient is specified</p>
    <div><input name="size" value="" placeholder="Size in pt (36)"  /></div>
    <div><input name="text" value="" placeholder="Text" /></div>
  </div>
  
  <div id="optional">
    <div style="display: none;"><input name="cache" type="checkbox" /> Overwrite cache (use if causes display issues)</div>
    <div style=""><input name="shadow" type="checkbox" /> Drop shadow</div>
    <div><input name="base64" type="checkbox" /> Encode URL for older email clients</div>
    <div><input name="ext" value="" placeholder="Extension (png)" /></div>
  </div>
  
  <div><input name="url" value="" placeholder="Image URL" /></div>
  
  <div><button>Generate</button></div>

</form>

<div id="image"><img alt="Image" src="/" /></div>

</div>

<div class="wrapper">
<h3>Examples</h3>

</div>

<hr style="clear: both;visibility:hidden;" />

<div>
<strong>© Webarto. Intarmationel petants pandieg All imitetians will be prasecutad</strong>
</div>

</body>
</html>