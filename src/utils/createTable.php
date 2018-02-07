<?php
function createTable($array)
{	
	$Counter = 0;
	echo '<table><tr><td>ID</td><td>SYMBOL</td></tr>';
	foreach ($array as $line){
	    echo '<tr>';
		echo '<td>'.$Counter++.'</td>'; 
		echo '<td>'.$line.'</td>'; 		 
	  echo '</tr>';
	}
	echo '</table>';
}

function createTableString($array)
{	
	$Counter = 0;
	echo '<table><tr><td>ID</td><td>STRING</td></tr>';
	foreach ($array as $line){
	    echo '<tr>';
		echo '<td>'.$Counter++.'</td>'; 
		echo '<td>'.$line.'</td>'; 		
	  echo '</tr>';
	}
	echo '</table>';
}

function createTableArray($array)
{	
	$Counter = 0;
	echo '<table><tr><td>ID</td><td>VALUE</td></tr>';
	foreach ($array as $line){
	    echo '<tr>';
		echo '<td>'.$Counter++.'</td>'; 
		echo '<td>'.$line[0].'</td>'; 		
	  echo '</tr>';
	}
	echo '</table>';
}
?>