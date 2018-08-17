<?php


if(!isset($_SESSION))
{
    session_start();
}

define('Server','localhost');
define('User','root');
define('Password','');
define('Database','examportal');

$con=mysqli_connect(Server,User,Password,Database);


function GetSubjects()
{
    $data=array();
    global $con;

    $query="select * from subjects order by subjects_name";
    $result=mysqli_query($con,$query);

    while($record=mysqli_fetch_assoc($result))
    {
        $data[$record['Subjects_id']] = $record['Subjects_name'];
    }

    return $data;
}


function GetExamSubjects($candidate_id)
{
    $data=array();
    global $con;

   // $query="select * from subjects where Subjects_id in (select subject_id from exammapping where candidate_id='$candidate_id' and iscompleted=0) order by subjects_name";
   $query="select * from subjects  order by subjects_name";

    $result=mysqli_query($con,$query);
   echo mysqli_error($con);
    while($record=mysqli_fetch_assoc($result))
    {
        $data[$record['Subjects_id']] = $record['Subjects_name'];
    }

    return $data;
}



function GetSubjectName($subjectid)
{
    $subjectname="";
    global $con;

    $query="select Subjects_name from subjects where Subjects_id=$subjectid";
    $result=mysqli_query($con,$query);

    $record=mysqli_fetch_assoc($result);
    $subjectname = $record['Subjects_name'];
    
    return $subjectname;	
}

function GetQuestionTypes()
{
    $data=array();
    global $con;

    $query="select * from anstype";
    $result=mysqli_query($con,$query);

    while($record=mysqli_fetch_assoc($result))
    {
        $data[$record['AnsType_id']] = $record['AnsType_type'];
    }

    return $data;
}


function CreateExam($subjectid)
{
    global $con;


    $query = "create table IF NOT EXISTS examquestion as select * from questionbank where Subjects_id=$subjectid order by rand()";
    $result=mysqli_query($con,$query) or mysqli_error($con);
}


function DeleteExam()
{
    global $con;

    $query = "drop table examquestion";
    $result=mysqli_query($con,$query) or mysqli_error($con);
}


function GetQuestions($subjectid)
{  
    $questionbank=array();

    global $con;


    $query = "select * from questionbank where Subjects_id=$subjectid order by rand() limit 35";
    $result=mysqli_query($con,$query) or mysqli_error($con);

    //$_SESSION['questionbank']=$result;
    while($record=mysqli_fetch_assoc($result))
    {
        $questionbank[]=$record;
    }

    $_SESSION['questionbank']=$questionbank;
    $_SESSION['currentquestion']=-1;
    $_SESSION['totalquestion']=count($questionbank);
}

function LoadNextQuestion()
{
    $questionbank=$_SESSION['questionbank'];
    $currentquestion=$_SESSION['currentquestion'];
    $currentquestion++;
    $_SESSION['currentquestion']=$currentquestion;

    return $questionbank[$currentquestion];
}

function LoadPreviousQuestion()
{
    $questionbank=$_SESSION['questionbank'];
    $currentquestion=$_SESSION['currentquestion'];
    $currentquestion--;
    $_SESSION['currentquestion']=$currentquestion;

    return $questionbank[$currentquestion];
}

function LoadAnswer($questionid)
{
    $answerbank=array();

    global $con;

    $query="select * from answerbank where QuestionBank_id=$questionid";
    $result=mysqli_query($con,$query) or mysqli_error($con);

    while($record=mysqli_fetch_assoc($result))
    {
        $answerbank[]=$record;
    }

    return $answerbank;
}


function GetUserDetails($candidateid)
{
    $user=array();

    global $con;

    $query="select * from candidate where candidate_id='$candidateid'";
    $result=mysqli_query($con,$query) or mysqli_error($con);


    if(mysqli_num_rows($result)>0)
    {
    	$user=mysqli_fetch_assoc($result);
    }

    return $user;
}


function SaveResult($examid,$questionid,$answer)
{
	global $con;

	
	//Check if Previous Record Exists
	$query="select * from results where QuestionBank_id=$questionid AND Exams_id=$examid";
	$result = mysqli_query($con,$query);

	//Check Answer
	
	if(mysqli_num_rows($result)==1)
	{
		$record=mysqli_fetch_assoc($result);
		$resultid=$record['resultid'];

		$query="update results set answers='$answer' where resultid=$resultid";
		$result=mysqli_query($con,$query);
	}
	else
	{
		//Record Not Exists Add One
		$query="insert into results values(null,$questionid,$examid,'$answer',0)";
		$result=mysqli_query($con,$query);
	}
	
}


function LoadPrevAnswer($examid,$questionid)
{
	global $con;
	
	//Check if Previous Record Exists
	$query="select * from results where QuestionBank_id=$questionid AND Exams_id=$examid";
	$result = mysqli_query($con,$query);

	
	if(mysqli_num_rows($result)==1)
	{
		$record=mysqli_fetch_assoc($result);
		return $record['answers'];
	}
	else
	{

	}
}


function SaveScore($examid)
{
	global $con;

	//Get Marks Obtained
	$query="select sum(questionbank.marks) from questionbank,results,correctanswers
		where questionbank.QuestionBank_id=results.QuestionBank_id and questionbank.QuestionBank_id=correctanswers.QuestionBank_id and results.Exams_id=$examid and results.answers=correctanswers.answers";
	$result=mysqli_query($con,$query);

	$record=mysqli_fetch_array($result);
	$marksobtained=$record[0];

	//Fetch Total Marks
	$query="select sum(questionbank.marks) from questionbank,results
		where questionbank.QuestionBank_id=results.QuestionBank_id and results.Exams_id=$examid";
	$result=mysqli_query($con,$query);
	$record=mysqli_fetch_array($result);
	$totalmarks=$record[0];

	//Save Score
	$query="insert into score values(null,$marksobtained,$examid,$totalmarks)";
	$result=mysqli_query($con,$query);

	$score=array('totalmarks'=>$totalmarks,
				'marksobtained'=>$marksobtained);

	return $score;
}

function GetResults($subjectid='',$candidateid='',$sort='',$order='')
{
    global $con;
    $results=array();

    //Get Students Results
    $query="";

    if(empty($subjectid) && empty($candidateid))
    {
        $query="select exams.Exams_id,subjects.Subjects_id,candidate.candidate_id,Candidate_name,subjects_name,startdate,enddate,score,total from exams,score,subjects,candidate where exams.Exams_id=score.exam_id and subjects.Subjects_id=exams.Subjects_id and candidate.candidate_id=exams.candidate_id";
    }
    else if(empty($candidateid) && !empty($subjectid))
    {
        $query="select exams.Exams_id,subjects.Subjects_id,candidate.candidate_id,Candidate_name,subjects_name,startdate,enddate,score,total from exams,score,subjects,candidate where exams.Exams_id=score.exam_id and subjects.Subjects_id=exams.Subjects_id and candidate.candidate_id=exams.candidate_id and subjects.Subjects_id=$subjectid";
    }
    else if(empty($subjectid) && !empty($candidateid))
    {
        $query="select exams.Exams_id,subjects.Subjects_id,candidate.candidate_id,Candidate_name,subjects_name,startdate,enddate,score,total from exams,score,subjects,candidate where exams.Exams_id=score.exam_id and subjects.Subjects_id=exams.Subjects_id and candidate.candidate_id=exams.candidate_id and candidate.candidate_id='$candidateid'";   
    }
    else
    {
       $query="select exams.Exams_id,subjects.Subjects_id,candidate.candidate_id,Candidate_name,subjects_name,startdate,enddate,score,total from exams,score,subjects,candidate where exams.Exams_id=score.exam_id and subjects.Subjects_id=exams.Subjects_id and candidate.candidate_id=exams.candidate_id and subjects.Subjects_id=$subjectid and candidate.candidate_id='$candidateid'";
    }
    

    switch ($sort) {
        case 'examid':
            $query = $query . " order by subjects.Subjects_id";
            break;

        case 'studentid':
            $query = $query . " order by Candidate_name";
            break;

        case 'examdate':
            $query = $query . " order by startdate";
            break;

        case 'marksobtained':
            $query = $query . " order by score";
            break;

        case 'totalmarks':
            $query = $query . " order by total";
            break;
        
        default:
            # code...
            break;
    }


    if(!empty($sort) && $order!=1)
    {
        $query = $query . " desc";
    }

    $result=mysqli_query($con,$query);

    while($record=mysqli_fetch_assoc($result))
    {
        $results[]=$record;
    }

    return $results;
}

function GetUsers()
{
    $users=array();

    global $con;

    $query="select * from candidate";
    $result=mysqli_query($con,$query) or mysqli_error($con);

    while($record=mysqli_fetch_assoc($result))
    {
        $users[]=$record;
    }

    return $users;
}


function GetQuestions1($subjectid)
{  
    $questionbank=array();

    global $con;


    $query = "select * from questionbank where Subjects_id=$subjectid";
    $result=mysqli_query($con,$query) or mysqli_error($con);

    //$_SESSION['questionbank']=$result;
    while($record=mysqli_fetch_assoc($result))
    {
        $questionbank[]=$record;
    }

    return $questionbank;
}


function GetAnswerList($examid)
{
    global $con;
    $answerlist=array();

    $query="select questionbank.QuestionBank_id,exams.Exams_id,results.answers,questionbank.question,questionbank.AnsType_id,questionbank.marks,exams.candidate_id,exams.startdate from results,questionbank,exams where results.Exams_id=exams.Exams_id and results.QuestionBank_id=questionbank.QuestionBank_id and exams.Exams_id=$examid";

    $result=mysqli_query($con,$query);

    while($record=mysqli_fetch_assoc($result))
    {
        $answerlist[]=$record;
    }
    return $answerlist;
}

function Authenticate($candidate_id,$candidate_password)
{
    global $con;
    $query="select * from candidate where candidate_id='$candidate_id' and candidate_password='$candidate_password'";
    $result = mysqli_query($con,$query);

    return (mysqli_num_rows($result)>0)?true:false;
}

function CompleteExam($candidate_id,$subjectid)
{
    global $con;
    $query="update exammapping set iscompleted=1 where candidate_id='$candidate_id' and subject_id=$subjectid";
    $result=mysqli_query($con,$query);
    echo mysqli_error($con);
}

?>