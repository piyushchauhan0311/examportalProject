<?php


require_once 'mysql.php';

$subject_id="";
$candidate_id="";

$subjects = GetSubjects();

if($_SERVER['REQUEST_METHOD']=='POST')
{
	extract($_POST);
	$results=GetResults($subject_id,$candidate_id);
	$_SESSION['filter_subject_id']=$subject_id;
	$_SESSION['filter_candidate_id']=$candidate_id;
}
else if(isset($_GET['sort']))
{
	$sort=$_GET['sort'];
	$order=$_GET['order'];
	$candidate_id=$_SESSION['filter_candidate_id'];
	$subject_id=$_SESSION['filter_subject_id'];
	$results=GetResults($subject_id,$candidate_id,$sort,$order);
}
else
{
	$results=GetResults();
	$_SESSION['filter_subject_id']='';
	$_SESSION['filter_candidate_id']='';
}

?>


<?php include_once('header.php'); ?>

<div class="container">
	<div class="row">
		&nbsp;
	</div>
	<div class="row">
		<div class="col-md-offset-1">
		<form class="form-inline" action="" method="post"> 
		  <label>Add Filters</label>
		  <div class="form-group">
	        <select name="subject_id" id="subjectid" class="form-control">
	                    <option value='0'>Select Subject</option>
	                    <?php foreach($subjects as $id=>$subject) { ?>
	                        <option <?php echo $subject_id==$id?'selected':''; ?> value="<?php echo $id; ?>"><?php echo $subject; ?></option>
	                    <?php } ?>
	        </select>
		  </div>
		  <div class="form-group">
		    <input type="text" class="form-control" id="employeeid" name="candidate_id" placeholder="Candidate Id" value="<?php echo $candidate_id; ?>">
		  </div>
		  <button type="submit" class="btn btn-primary">Apply Filters</button>
		</form>
		</div>
	<div class="row">
		&nbsp;
	</div>
</div>
</div>

<div class="container">
	<table class="table table-bordered table-hover">
  <thead class="thead-default">
    <tr>
    	<th>#</th>
		<th><a href="examresults.php?sort=examid&order=<?php echo isset($_GET['order'])?!$_GET['order']:1; ?>">Exam Name</a></th>
		<th><a href="examresults.php?sort=studentid&order=<?php echo isset($_GET['order'])?!$_GET['order']:1; ?>">Student Name</a></th>
		<th><a href="examresults.php?sort=examdate&order=<?php echo isset($_GET['order'])?!$_GET['order']:1; ?>">Date of Exam</a></th>
		<th><a href="examresults.php?sort=marksobtained&order=<?php echo isset($_GET['order'])?!$_GET['order']:1; ?>">Marks Obtained</a></th>
		<th><a href="examresults.php?sort=totalmarks&order=<?php echo isset($_GET['order'])?!$_GET['order']:1; ?>">Total Marks</a></th>
		<th>Answers List</th>
    </tr>
  </thead>
  <tbody>
 	<?php $count=1; foreach($results as $record)  { ?>
    <tr>
      	<th scope="row"><?php echo $count++; ?></th>
		<td><?php echo $record['subjects_name']; ?></td>
		<td><?php echo $record['Candidate_name']; ?></td>
		<td><?php echo $record['startdate']; ?></td>
		<td><?php echo $record['score']; ?></td>
		<td><?php echo $record['total']; ?></td>
		<td><button class="btn" data-toggle="modal" data-target=".bd-example-modal-lg" onclick="DisplayAnswerList(<?php echo $record['Exams_id'] ?>);">Answer List</button>
		</td>
    </tr>
	<?php } ?>
  </tbody>
</table>
</div>


<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h1 class="modal-title" id="myModalLabel">Answer List</h1>
      </div>
      <div class="modal-body" id="answerlist">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
	function DisplayAnswerList(examid)
	{

		document.getElementById('answerlist').innerHTML=examid;
		var xhr = new XMLHttpRequest();
		xhr.open("get","listresult.php?examid="+examid);
		xhr.send();

		xhr.onreadystatechange=function()
		{
			if(xhr.readyState==4 && xhr.status==200)
			{
				document.getElementById('answerlist').innerHTML=xhr.responseText;
			}
		}
	}
</script>

<?php 
include_once('footer.php');
?>