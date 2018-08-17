<?php

header('location:error.php');

require_once 'mysql.php';
$questions = GetQuestions1(2);
var_dump($questions);
die();

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
	        </select>
		  </div>
		  <div class="form-group">
		    <input type="text" class="form-control" id="employeeid" name="candidate_id" placeholder="Employee Id" value="">
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
		<th><a href="examresults.php?sort=examid&order=<?php echo isset($_GET['order'])?!$_GET['order']:1; ?>">User Id</a></th>
		<th><a href="examresults.php?sort=studentid&order=<?php echo isset($_GET['order'])?!$_GET['order']:1; ?>">Name</a></th>
		<th><a href="examresults.php?sort=examdate&order=<?php echo isset($_GET['order'])?!$_GET['order']:1; ?>">Email</a></th>
		<th><a href="examresults.php?sort=marksobtained&order=<?php echo isset($_GET['order'])?!$_GET['order']:1; ?>">Phone</a></th>
		<th>Edit/Delete</th>
    </tr>
  </thead>
  <tbody>
 	<?php $count=1; foreach($users as $record)  { ?>
    <tr>
      	<th scope="row"><?php echo $count++; ?></th>
		<td><?php echo $record['candidate_id']; ?></td>
		<td><?php echo $record['Candidate_name']; ?></td>
		<td><?php echo $record['Candidate_email']; ?></td>
		<td><?php echo $record['Candidate_phone']; ?></td>
		<td><a href="#"	>Edit</a> | <a href="#">Delete</a></td>
    </tr>
	<?php } ?>
  </tbody>
</table>
</div>


<?php 
include_once('footer.php');
?>