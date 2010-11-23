<?php 
	echo $javascript->link('jquery.1.4.js',false);
	echo $javascript->link('jquery.easing.1.3.js',false);
	echo $javascript->link('jquery.showcase.2.0.1.js',false);

	//$imgCount = 11;	
?>
<?php
$jscode = 
<<<EOJAVASCRIPT
 /* DOCUMENTATION: http://www.recoding.it/wp-content/uploads/demos/showcase-documentation-2.0.htm */ 
$(function(){
	$("#showcase1").showcase({
	    css: { width: "574px", height: "431px" },
	    animation: { interval: 4500,
            stopOnHover: true,
            easefunction: "swing",
            speed: 600  },
	    navigator: { position: "bottom-right", orientation: "vertical", autoHide: true,
	                 css: { padding:"6px", margin: "4px 0px 0px 0px" },
	                 item: {
	                	 css: { height:"8px", width:"8px", "-moz-border-radius": "8px", "-webkit-border-radius": "8px",
                         backgroundColor: "#cccccc", borderColor:"#666666" },
                  cssHover: { backgroundColor: "#ffffff", borderColor:"#666666" },
                  cssSelected: { backgroundColor: "#ffffff", borderColor: "#666666" }
	                 }
	    },
	    titleBar: { enabled: false }
	});
});
EOJAVASCRIPT;
echo $javascript->codeBlock($jscode, array('inline'=>false));
?>


<div class="pane_header">
				HEADLINES
</div>
<div id="showcase1">
		<?php foreach ($headlineImages as $image){ ?>
		<a>
	        <?php echo $html->image("{$cartsAdminUrl}c/img/{$image['Upload']['name']}")?>
		</a>
     <?php }?>
</div>
<div style="clear:both"></div>
<div class="pane_footer"></div>