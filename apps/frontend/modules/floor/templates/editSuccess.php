

<div class="mainbody expanded">
		<div id="board">
			<div class="floorselects"></div>
			<div class="scaleselects">
				<div class="zoom in"></div>
				<div class="zoom lv" scale="3"></div>
				<div class="zoom lv" scale="2"></div>
				<div class="zoom lv" scale="1.5"></div>
				<div class="zoom lv" scale="1.4"></div>
				<div class="zoom lv" scale="1.3"></div>
				<div class="zoom lv" scale="1.2"></div>
				<div class="zoom lv" scale="1.1"></div>
				<div class="zoom lv selected" scale="1"></div>
				<div class="zoom lv" scale="0.9"></div>
				<div class="zoom lv" scale="0.8"></div>
				<div class="zoom lv" scale="0.7"></div>
				<div class="zoom lv" scale="0.6"></div>
				<div class="zoom lv" scale="0.5"></div>
				<div class="zoom out"></div>
				<div class="background"></div>
			</div>
			<div id="viewport"></div>
		</div>
		<div id="sidebar">
			<div class="barcontent">
				<div id="elementscontainer">
					<div class="menuaccordion" id="floorImages"><div class="menu"><span i18n="i18n">Floors</span></div><div class="container"><div></div></div></div>
					<div class="menuaccordion" id="tableImages"><div class="menu"><span i18n="i18n">Tables</span></div><div class="container"><div></div></div></div>
					<div class="menuaccordion" id="decorationImages"><div class="menu"><span i18n="i18n">Decoration</span></div><div class="container"><div></div></div></div>
				</div>
				<div id="propertycontainer"></div>
			</div>
			<div class="expander" collapsed="false"></div>
		</div>
	</div>

		<script src="/js/floor/jquery.event.drag-2.2.js"></script>
		<script src="/js/floor/ajaxfileupload.js"></script>
		<script src="/js/floor/utils.js"></script>
		<script src="/js/floor/pageutils2.js?v=11"></script>
		<script src="/js/floor/rpc.js"></script>
		<script src="/js/floor/flooreditor.js"></script>
		<script src="/js/floor/floor.js"></script>
		<script> 
		$(document).ready(function() {
			$('body').addClass('menu-hidden');
			floorEditor.scale = 0.9;
		});
		</script>

