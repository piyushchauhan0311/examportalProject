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
            <h1 class="text-center login-title" style="color:white">Sign in</h1>
            <div class="account-wall">
                <form class="form-signin" action="" method="post">
                <?php
                if($iserror==true)
                {
                    echo "<p style='color:red'>User Id and/or password is incorrect</p><br>";
                }
                ?>
                <input type="text" class="form-control" name="candidate_id" placeholder="Student Id" required autofocus>
                <input type="password" name="candidate_password" class="form-control" placeholder="Password" required>
                <button class="btn btn-lg btn-primary btn-block" type="submit">
                    Sign in</button>
                </form>
            </div>
            <!--<a href="register.php" class="text-center new-account">Create an account </a>-->
        </div>
    </div>
</div>

<?php 
include_once('footer.php');
?>