<?php

require_once('mysql.php');


//Save Score
$candidateid=$_SESSION['candidate_id'];
$examid=$_SESSION['examid'];
$subjectid=$_SESSION['subjectid'];
CompleteExam($candidateid,$subjectid);
$score=SaveScore($examid);
extract($score);



?>


<?php include_once('header.php'); ?>

<div class="container" style="margin-top:60px">
	 
	<div class="row">
		<div class="col-sm-6 col-sm-offset-3 col-xs-12 col-md-6 col-md-offset-3">
<h1 class="text-center">Thank You</h1>
	</div>
	

<!--	<div class="col-sm-6 col-sm-offset-3 col-xs-12 col-md-2 col-md-offset-5">
		<a href="startexam.php" class="btn btn-primary btn-block">Continue</a>
	</div> -->

	</div>
</div>
