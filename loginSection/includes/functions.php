<?php
	function setHighlight($pageNo){
	$highlight = "";
		if(isset($_GET['page'])) {
			$currentNo = $_GET['page'];
			if($pageNo == $currentNo)
    			$highlight = "highlight";
    		else $highlight = "";
		}
	return $highlight;
	}

?>