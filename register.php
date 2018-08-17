<?php



require_once('mysql.php');


$candidate_id="";
$candidate_name="";
$candidate_email="";
$candidate_phone="";
$candidate_password="";
$candidate_repeat_password="";


if($_SERVER['REQUEST_METHOD']=='POST')
{
	extract($_POST);

	$query="insert into candidate (id,candidate_id,candidate_name,candidate_phone,candidate_email,candidate_password) values (null,'$candidate_id','$candidate_name','$candidate_phone','$candidate_email','$candidate_password')";
	$result = mysqli_query($con,$query) or die(mysqli_error($con));

	$_SESSION['candidate_id']=$candidate_id;
	header("location:startexam.php");
}

?>

<?php include_once('header.php'); ?>

<div class="container">
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <h1 class="text-center login-title">Create Account</h1>
            <div class="account-wall">
                <form class="form-signin" action="" method="post">
                <input type="text" class="form-control" name="candidate_id" placeholder="Student Id" required autofocus>
                <input type="text" name="candidate_name" class="form-control" placeholder="Student Name" required>
                <input type="email" name="candidate_email" class="form-control" placeholder="Email" required>
                <input type="text" name="candidate_phone" class="form-control" placeholder="Phone" required>
                <input type="password" name="candidate_password" class="form-control" placeholder="Password" required style="margin-bottom:0px">
                <input type="password" name="candidate_repeat_password" class="form-control" placeholder="Repeat Password" required>

                <button class="btn btn-lg btn-primary btn-block" type="submit" name="command">
                    Register</button>
                </form>
            </div>
            <a href="login.php" class="text-center new-account">Login</a>
        </div>
    </div>
</div>

