<?php
///
///@file regex.php
///@brief Contains Regular Expressions
///@author Sachin Ganesh

/// PATTERN
	$PREG["DIGITS"] = "[0-9]+";
	$PREG["NUMBER"] = '[0-9]+(.[0-9]+)?([e|E][+|-]?[0-9]+)?';
	$PREG["IDENTIFIER"] = "[a-zA-Z_][a-zA-Z0-9_]*";
	$PREG["STRING"] = '"([^"]+)"';
	///$PREG["STRING"] = '"([^\\"]+)"';
?>