<?php
///
///@file 	processInputString.php
///@brief 	Test file for Lexical Analyzer
///@author 	Sachin Ganesh
///
///
/// INCLUDE
	require("src/constants.php");
	require("src/lexicalAnalyzer.class.php");
///TODO : Get input from form
	//TEST : Input from url
	if(isset($_REQUEST["inputstring"])){
		$InputString = $_REQUEST["inputstring"];
	} else{ $InputError = "inputstring"; }
	
	if(isset($InputError)){
		$OutputJSON = array('statusCode' => $INPUT_NOT_SET,'status' => "$InputError Required",'author' => 'SachinGanesh');
		echo json_encode($OutputJSON) . PHP_EOL;
		exit;
	}
	
	/// Lexical Analysis
	/// Creating Client for LexialAnalyzer
	$_LEX_CLIENT =  new lexicalAnalyzer();
	// get Result array
	$LEX_OutputArray = $_LEX_CLIENT->getTokenArray($InputString);
	
	/// get SYMBOL_TABLE
	$SYMBOL_TABLE = $_LEX_CLIENT->getSymbolTable();
	
	/// get Regular Expression
	$RegularExpresson = $_LEX_CLIENT->getRegularExpression();
	//echo "<br>Regular Expression : <br><br>$RegularExpresson";
	
	/// Display Result
	$LEX_Output = $_LEX_CLIENT->getLexFormatedOutput();
	
	/// get KEyword Table
	$KEYWORD_TABLE  = $_LEX_CLIENT->getKeywordsTable();
	
	/// get STRING Table
	$STRING_TABLE  = $_LEX_CLIENT->getStringTable();
	
	///tree Builder
	require("src/utils/print_r_tree.php");
	
	// print('<pre>');
	// print_r_tree($LEX_OutputArray);
	// print('</pre>');					
	
	include('src/utils/createTable.php');
	// echo '<div class="css_Table">';
	// createTable($SYMBOL_TABLE);
	// echo '</div>';
					
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
"http://www.w3.org/TR/html4/strict.dtd">

<html lang="en">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=iso-8859-1">			
		<link href="css/style.css" rel="stylesheet" />
		<!-- Bootstrap core CSS -->
		<link href="css/bootstrap.css" rel="stylesheet" />
		<link href="css/font-awesome.min.css" rel="stylesheet" />		
		<title>Compiler</title>
	</head>
	<body>
		<section class="content-section anim fadeInDown" style="height:100px !important;padding:0 10px 0 0 !important;">
			<div class="container" >
				<h1><i class="fa fa-pencil-square-o"></i>C<span>OMPILER</span></h1>
			</div>
		</section><!-- .content-section -->
		
		<section class="content-section form contact">
			<div class="container ">
			
				<!-- ROW 0-->
				<div class="row ">
					<div class="col-lg-4 sidebar">
						<div class="hline"></div>
					</div>
					<div class="col-lg-4 sidebar" ALIGN=CENTER>
						<h4 class="anim fadeInRight">
									Step 1 : Lexical Analyser
						</h4>
					</div>
					<div class="col-lg-4 sidebar">
						<div class="hline"></div>
					</div>			
				</div>
				
				<!-- ROW 1-->
				<div class="row">	
					<div class="col-lg-8">
						<div class="sidebar BGlightGrey roundCorner" style="padding:10px !important;">
							<h4 class="anim fadeInLeft" ALIGN=CENTER style="padding:10px 0 0 0 !important;">Input String</h4>
							<div class="hline"></div>
							<div class="codeblockHeight" style="overflow: auto !important;" >
								<h5 class="anim fadeInLeft customScroll" style="word-wrap:break-word !important;"><?php print('<pre style="overflow: auto !important;">');echo $InputString;print('</pre>');?></h5>
							</div>
						</div>
					</div>
					<!--<div class="col-lg-1"></div>-->
					<div class="col-lg-4" ALIGN=CENTER >
						<div class="sidebar BGlightGrey roundCorner" style="padding:10px !important;">
							<h4 class="anim fadeInRight" ALIGN=CENTER style="padding:10px 0 0 0 !important;">
										Regular Expression
							</h4>
							<div class="hline"></div>
							<div class="codeblockHeight" style="overflow: auto !important;">
								<h5 class="anim fadeInRight " ALIGN=CENTER style="word-wrap:break-word !important;">
									<?php print('<pre>');echo $RegularExpresson;print('</pre>');?>
								</h5>
							</div>
						</div>
					</div>
				</div>
				
				
				<!-- ROW 2 -->
				<div class="row" style="padding:20px 0 0 0 !important;">	
					<div class="col-lg-8">
						<div class="sidebar BGlightGrey roundCorner " style="padding:10px !important;">
							<h4 class="anim fadeInLeft" ALIGN=CENTER style="padding:10px 0 0 0 !important;">Output from Lexical Analyser</h4>
							<div class="hline"></div>
							<div  class="codeblockHeight" style="overflow: auto !important;">
								<h5 class="anim fadeInLeft customScroll" style="word-wrap:break-word !important;"><?php print('<pre>');echo $LEX_Output;print('</pre>');?></h5>
							</div>
						</div>
					</div>
					<div class="col-lg-4" >
						<div class="sidebar BGlightGrey roundCorner" style="padding:10px !important;">
							<h4 class="anim fadeInRight" ALIGN=CENTER style="padding:10px 0 0 0 !important;">
										Structure
							</h4>
							<div class="hline"></div>
							<div  class="codeblockHeight" style="overflow: auto !important;">
								<h5 class="anim fadeInRight " style="word-wrap:break-word !important;">
									<?php print('<pre>');print_r($LEX_OutputArray); print('</pre>');	?>
								</h5>
							</div>
						</div>
					</div>
				</div>
				
				<!-- ROW 3-->
				<div class="row" style="padding:20px 0 0 0 !important;">	
					<!-- SYMBOL TABLE -->
					<div class="col-lg-4">
						<div class="sidebar BGlightGrey roundCorner" style="padding:10px !important;">
							<h4 class="anim fadeInLeft" ALIGN=CENTER style="padding:10px 0 0 0 !important;">SYMBOL TABLE</h4>
							<div class="hline"></div>
							<div class="codeblockHeight" style="overflow: auto !important;" >
								<h5 class="anim fadeInLeft customScroll" style="word-wrap:break-word !important;">
									<?php  print('<pre>');echo '<div class="css_Table">';createTable($SYMBOL_TABLE);echo '</div>'; print('</pre>');?>
								</h5>
							</div>
						</div>
					</div>	
					<!-- STRING TABLE -->
					<div class="col-lg-4">
						<div class="sidebar BGlightGrey roundCorner" style="padding:10px !important;">
							<h4 class="anim fadeInLeft" ALIGN=CENTER style="padding:10px 0 0 0 !important;">STRING TABLE</h4>
							<div class="hline"></div>
							<div class="codeblockHeight" style="overflow: auto !important;" >
								<h5 class="anim fadeInLeft customScroll" style="word-wrap:break-word !important;">
									<?php  print('<pre>');echo '<div class="css_Table">';createTableString($STRING_TABLE);echo '</div>'; print('</pre>');?>
								</h5>
							</div>
						</div>
					</div>
					<!-- KEYWORD TABLE -->
					<div class="col-lg-4">
						<div class="sidebar BGlightGrey roundCorner" style="padding:10px !important;">
							<h4 class="anim fadeInLeft" ALIGN=CENTER style="padding:10px 0 0 0 !important;">KEYWORD TABLE</h4>
							<div class="hline"></div>
							<div class="codeblockHeight" style="overflow: auto !important;" >
								<h5 class="anim fadeInLeft customScroll" style="word-wrap:break-word !important;">
									<?php  print('<pre>');echo '<div class="css_Table">';createTableArray($KEYWORD_TABLE);echo '</div>'; print('</pre>');?>
								</h5>
							</div>
						</div>
					</div>					
				</div>
				
			</div>
		</section>
	</body>
</html>