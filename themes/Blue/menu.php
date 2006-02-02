<div id="topnav">
	<ul>
		<li><a>Eclipse.org navigation</a></li>
<?php
	$nextclass = "";
	
	for($i = 0; $i < $Menu->getMenuItemCount(); $i++) {
		$MenuItem = $Menu->getMenuItemAt($i);
		$startclass 	= "tabstart";
		$aclass 		= "";
		$separatorclass = "tabseparator";
		
		if($nextclass != "") {
			$startclass = $nextclass;
			$nextclass = "";
		}
		
		
		if(strpos($_SERVER['SCRIPT_FILENAME'], $MenuItem->getURL())) {
			$startclass		="tabstartselected";
			$aclass 		= "tabselected";
			$nextclass 		= "tabseparatorselected";
		}
		
		
?>
		<li class="<?= $startclass ?>">&#160;&#160;&#160;</li>
		<li><a class="<?= $aclass ?>" href="<?= $MenuItem->getURL() ?>" target="<?= $MenuItem->getTarget() ?>"><?= $MenuItem->getText() ?></a></li>
<?php
	}
?>
		<li class="<?= $separatorclass ?>">&#160;&#160;&#160;</li>			
	</ul>
</div>
<div id="topnavsep"></div>