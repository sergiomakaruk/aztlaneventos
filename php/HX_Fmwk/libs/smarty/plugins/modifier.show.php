<?php
function smarty_modifier_show($obj,$dateFormatter=3,$timeFormatter=2){

	return $obj->show($dateFormatter,$timeFormatter);

}
?>