<?php
///
///@file 	index.php
///@brief 	index file for Lexical Analyzer
///@author 	Sachin Ganesh
///

	$UploadHandler = 'processInputString.php';
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
"http://www.w3.org/TR/html4/strict.dtd">

<html lang="en">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=iso-8859-1">	
		<!--<link rel="stylesheet" type="text/css" href="stylesheet.css">-->		
		<link href="css/style.css" rel="stylesheet" />
		<!-- Bootstrap core CSS -->
		<link href="css/bootstrap.css" rel="stylesheet" />
		<link href="css/font-awesome.min.css" rel="stylesheet" />		
		<title>Compiler</title>
	</head>
	
	<body>
		<section class="content-section anim fadeInDown" style="height:100px !important;padding:0 10px 0 0 !important;">
			<div class="container" >
				<!-- <p> **** PHP based compiler prototype **** </p> -->
				<h1><i class="fa fa-pencil-square-o"></i>C<span>OMPILER</span></h1>
			</div>
		</section><!-- .content-section -->
		
		<section class="content-section form contact light">
			<div class="container">	
				<div class="row">	
						
						<form id="Upload" action="<?php echo $UploadHandler ?>" enctype="multipart/form-data" method="post">
							<div class="col-lg-12 anim fadeInLeft">
									<span class="input-group">
											<textarea type="text" name="inputstring" id="inputstring" class="lg"  placeholder="Enter C snippet here"></textarea>
									</span>						
									<span class="input-group">
										<button class="submit" id="submit" type="submit" name="submit">Upload Code!</button>
									</span>
							</div>						
						</form>	
				</div>
			</div>
		</section>
	</body>
</html>