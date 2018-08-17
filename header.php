<!DOCTYPE html>
<html>
<head>
  <title>Exam Portal 2018</title>

  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  
  <link href="./assets/css/bootstrap.css" rel="stylesheet">
  <link href="./assets/css/login.css" rel="stylesheet">
  <script
  src="https://code.jquery.com/jquery-3.1.1.js"
  integrity="sha256-16cdPddA6VdVInumRGo6IbivbERE8p7CQR3HzTBuELA="
  crossorigin="anonymous"></script>
  <script src="./assets/js/bootstrap.js"></script>
</head>
<body style="background-image:url('./assets/images/background.jpg');background-size:cover;background-repeat:no-repeat">

<nav class="navbar navbar-default">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="#">Guru Nanak Dev Institute of Polytechnic, Rohini</a>
    </div>

    <!-- Admin Menu -->

    <!-- 
    <ul class="nav navbar-nav">
      <li><a href="#">&nbsp;</a></li>
      <li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#">Questions
        <span class="caret"></span></a>
        <ul class="dropdown-menu">
          <li><a href="managequestions.php">Manage Questions</a></li>
          <li><a href="addquestion.php">Add Question</a></li>
          <li><a href="updatequestion.php">Edit Question</a></li>
          <li><a href="deletequestion.php">Delete Question</a></li> 
        </ul>
      </li>
       <li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#">Users
        <span class="caret"></span></a>
        <ul class="dropdown-menu">
          <li><a href="manageusers.php">Manage Users</a></li> 
          <li><a href="#">Edit User</a></li>
          <li><a href="#">Delete User</a></li>
        </ul>
      </li>
       <li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#">Reports
        <span class="caret"></span></a>
        <ul class="dropdown-menu">
          <li><a href="examresults.php">View Results</a></li>
        </ul>
      </li> 
    </ul>
    -->
   


    <ul class="nav navbar-nav navbar-right">
    <?php if(isset($_SESSION['candidate_id'])) { 
    $candidateid=$_SESSION['candidate_id'];
    $user=GetUserDetails($candidateid);
    ?>
      <li><a href="#"><span class="glyphicon glyphicon-user"></span> Welcome <?php echo $user['Candidate_name']; ?></a></li>
      <li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
    <?php } else { ?>
      <li><a href="register.php"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li>
      <li><a href="login.php"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
    <?php } ?>
    </ul>
  </div>
</nav>