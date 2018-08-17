<?php


require_once('mysql.php');


$question=array();
$answers=array();
$prevanswer="";


if(!isset($_SESSION['candidate_id']))
{
	header('location:login.php');
}
else if(!isset($_SESSION['subjectid']))
{
	header('location:startexam.php');
}
else if(!isset($_SESSION['examstarted']))
{
	$subjectid=$_SESSION['subjectid'];

	GetQuestions($subjectid);
	$question=LoadNextQuestion();
	$answers=LoadAnswer($question['QuestionBank_id']);

	$_SESSION['examstarted']=true;
}


if($_SERVER['REQUEST_METHOD']=='POST')
{
	$answer=-1;

	$questionid=$_POST['questionid'];
	if(isset($_POST['answer']))
	{
		$questiontype=$_POST['questiontype'];
		if($questiontype==1)
		{
			$answer=$_POST['answer'];
		}
		else
		{
			$answer=implode(",",$_POST['answer']);
		}
	}
	$examid=$_SESSION['examid'];
	

	//Save Result
	SaveResult($examid,$questionid,$answer);

	if($_POST['command']=='Next')
	{
		$question=LoadNextQuestion();
		$answers=LoadAnswer($question['QuestionBank_id']);
	}
	else if($_POST['command']=='Previous')
	{
		$question=LoadPreviousQuestion();
		$answers=LoadAnswer($question['QuestionBank_id']);
	}
	else
	{
		$examid=$_SESSION['examid'];
		$candidateid=$_SESSION['candidate_id'];
		$subjectid=$_SESSION['subjectid'];
		session_unset();
		$_SESSION['examid']=$examid;
		$_SESSION['candidate_id']=$candidateid;
		$_SESSION['subjectid']=$subjectid;
		header('location:result.php');
	}

	//Load Previous Answers
	$questionid=$question['QuestionBank_id'];
	$examid=$_SESSION['examid'];
	$prevanswer=LoadPrevAnswer($examid,$questionid);

	if($question['AnsType_id']==2)
	{
		$prevanswer=explode(",",$prevanswer);
	}
}

function MarkAnswer($qno)
{
	global $prevanswer;
	if($prevanswer!="")
	foreach($prevanswer as $ans)
	{
		if($ans==$qno)
		{
			echo 'checked';
		}
	}
}

?>


<?php include_once('header.php'); ?>

<div class="container" style="margin-top:60px">
	<div class="row">
		<div class="col-sm-6 col-sm-offset-3 col-xs-12 col-md-8 col-md-offset-2">
			<h5 class="pull-left">
			Exam Name : <?php echo GetSubjectName($_SESSION['subjectid']); ?>
			</h5>
			<h5 class="pull-right">		
			Total Questions : <?php echo $_SESSION['totalquestion']; ?>
			</h5>
		</div>
	</div>
    <div class="row">
        <div class="col-sm-6 col-sm-offset-3 col-xs-12 col-md-8 col-md-offset-2">
	<form  action="exam.php" method="post">
		<h3 style="margin-bottom:30px">Q. <?php echo 	$_SESSION['currentquestion']+1; ?> <?php echo $question['question']; ?></h3>
		<input type="hidden" name="questionid" value="<?php echo $question['QuestionBank_id']; ?>">
		<input type="hidden" name="questiontype" value="<?php echo $question['AnsType_id'] ?>">

		<div class="form-group" style="height:120px">
		<?php $qno=1; foreach ($answers as $answer) {
			if($answer['answer']!='')
			{
		?>
		<h5>
		<?php if($question['AnsType_id']==1) { ?>
		
		<input type="radio" class="form-check-input" name="answer" <?php echo $qno==$prevanswer?'checked':''; ?> value="<?php echo $qno++;?>"> <?php echo $answer['answer']; ?> 
		<?php } else { ?>
		<input type="checkbox" class="form-check-input form-check" name="answer[]" <?php MarkAnswer($qno); ?> value="<?php echo $qno++; ?>"> <?php echo $answer['answer']; ?> 	
		</h5>
		<?php } } } ?>
		</div>
		 

		<div class="pull-right">

		<?php if($_SESSION['currentquestion']!=0) { ?>
		<input type="submit" value="Previous" class="btn" name="command">
		<?php }  if($_SESSION['currentquestion'] < $_SESSION['totalquestion']-1) {  ?>
		<input type="submit" value="Next" class="btn" name="command">
		<?php } else {  ?>
		<input type="submit" value="Finish" class="btn" name="command">
		<?php } ?>
		
		</div>
	</form>
</div>
</div>
</div>