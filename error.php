<?php
require_once('mysql.php');
if(isset($_SESSION['candidate_id']))
{
    header('location:startexam.php');
}

$candidate_id="";
$candidate_password="";
$iserror=false;
if($_SERVER['REQUEST_METHOD']=='POST')
{
	extract($_POST);

	if(Authenticate($candidate_id,$candidate_password))
	{
		$_SESSION['candidate_id']=$candidate_id;
		header("location:startexam.php");
	}
    else
    {
        $iserror=true;
    }
}
?>
<?php include_once('header.php'); ?>
<div class="container">
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <h1>Error!</h1>
            <div class="account-wall" style="padding:30px;">
                <h5>This resource you are looking for is not available at the moment, Please Try Again!</h5>
            </div>
    </div>
</div>

<?php 
include_once('footer.php');
?>