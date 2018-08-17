<?php
error_reporting(0);
require_once('mysql.php');


if(!isset($_SESSION['candidate_id']))
{
	header('location:login.php');
}

$subjectid="";
$candidateid=$_SESSION['candidate_id'];


//Get Subjects
$subjects = GetExamSubjects($candidateid);

/* if($_SERVER['REQUEST_METHOD']=='POST')
{
	$subjectid=$_POST['subjectid'];

	if($subjectid!=0)
	{
		//Save Exam
		$query="insert into exams values(null,$subjectid,curdate(),null,'$candidateid')";
		$result = mysqli_query($con,$query) or die(mysqli_error($con));

		$examid=mysqli_insert_id($con);

		$_SESSION['subjectid']=$subjectid;
		$_SESSION['examid']=$examid;
		header('location:exam.php');
	}
}
 */
 
 if($_REQUEST["id"]!="" && $_REQUEST["id"]!=null)
 {
	$subjectid=$_REQUEST['id'];

	if($subjectid!=0)
	{
		//Save Exam
		$query="insert into exams values(null,$subjectid,curdate(),null,'$candidateid')";
		$result = mysqli_query($con,$query) or die(mysqli_error($con));

		$examid=mysqli_insert_id($con);

		$_SESSION['subjectid']=$subjectid;
		$_SESSION['examid']=$examid;
		header('location:exam.php');
	} 
 }
?>

<?php include_once('header.php'); ?>
<style>
.nd-box{
	background-color: #ffbb99;
	width:100%;
	border: 1px solid #d6d6d6;
    padding: 5px;
    margin: 10px 1px 2px 1px;
    /*display: inline-flex;*/
    text-align:center;
}
</style>
<div class="container">
	<h1 style="color:white;text-align:center;">Start Your Exam</h1>
    <div class="row">
        <div class="col-md-12">
			
				<?php 
					foreach($subjects as $id=>$subject) 
					{ 
						echo '<a href="startexam.php?id='.$id.'"><div class="col-md-3"><div class="nd-box">'.$subject.'</div></div></a>';
					}
				?>
				<!--
				<form class="form-inline" action="" method="post">
				<div class="form-group">
					<select class="form-control" name="subjectid" style=";">
						<option value='0'>Select Subject</option>
						<?php foreach($subjects as $id=>$subject) { ?>
							<option value="<?php echo $id; ?>"><?php echo $subject; ?></option>
						<?php } ?>
					</select>
					<input class="btn  btn-primary " type="submit" value="Start" name="command">
				</div>
			</form>-->
		</div>
	</div>
</div>


<?php 
include_once('footer.php');
?>