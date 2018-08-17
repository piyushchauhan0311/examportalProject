<?php

//header('location:error.php');

require_once 'mysql.php';

//Get Subjects
$subjects = GetSubjects();
$questiontypes = GetQuestionTypes();


//Global Variables
$questionbank_id="";
$subjectid="";
$question="";
$answer1="";
$answer2="";
$answer3="";
$answer4="";
$answertypeid="";
$marks="";
$correctanswers=array();

//Handle Form Submission
if($_SERVER['REQUEST_METHOD']=='POST')
{
    if($_POST['command']=='Add Question')
    {
        //Extract Form Data
        extract($_POST);

        //Save 'QuestionBank' Table
        $question=htmlspecialchars($question,ENT_QUOTES);        
        $query = "insert into questionbank values(null,$subjectid,'$question',$answertypeid,$marks)";
        $result = mysqli_query($con,$query) or die('Error' . mysqli_error($con));
        $questionbank_id=mysqli_insert_id($con);

        //Save 'AnswerBank' Table
        $answer1=htmlspecialchars($answer1,ENT_QUOTES);        
        $answer2=htmlspecialchars($answer2,ENT_QUOTES);        
        $answer3=htmlspecialchars($answer3,ENT_QUOTES);        
        $answer4=htmlspecialchars($answer4,ENT_QUOTES);        
        $query = "insert into answerbank values(null,$questionbank_id,'$answer1'), (null,$questionbank_id,'$answer2'), (null,$questionbank_id,'$answer3'), (null,$questionbank_id,'$answer4')";
        $result = mysqli_query($con,$query) or die(mysqli_error($con));

        //Save 'CorrectAnswers' Table
        $answer = implode(',',$correctanswers);
        $query = "insert into correctanswers values(null,$questionbank_id,'$answer')";
        $result = mysqli_query($con,$query) or die(mysqli_error($con));
    }
    else
    {
        //Save 'Subjects' Table
        extract($_POST);
        $query="insert into subjects values(null,'$subjectname',25,25)";
        $result=mysqli_query($con,$query) or die(mysqli_error($con));
        header('location:addquestion.php');
    }
}


?>


<?php include_once('header.php'); ?>

<div class="container">
  <form action="" method="post">

    <div class="form-group row">
      <label for="subjectid" class="col-md-2 col-form-label col-md-offset-2">Subject</label>
      <div class="col-md-5">        
        <select name="subjectid" id="subjectid" class="form-control">
                    <option value='0'>Select Subject</option>
                    <?php foreach($subjects as $id=>$subject) { ?>
                        <option value="<?php echo $id; ?>"><?php echo $subject; ?></option>
                    <?php } ?>
        </select>
      </div>
     
<button type="button" class="col-md-1 btn btn-primary" data-toggle="modal" data-target="#loginModal">Add Subject</button> 
  
    </div>

    <div class="form-group row">
      <label for="question" class="col-md-2 col-form-label col-md-offset-2">Question</label>
      <div class="col-md-5">
        <textarea name="question"  class="form-control" id="question"></textarea>
      </div>
    </div>

    <div class="form-group row">
      <label for="question" class="col-md-2 col-form-label col-md-offset-2">Option 1</label>
      <div class="col-md-5">
      <textarea name="answer1" class="form-control" id="answer1"></textarea>
      </div>
    </div>


    <div class="form-group row">
      <label for="question" class="col-md-2 col-form-label col-md-offset-2">Option 2</label>
      <div class="col-md-5">
        <textarea name="answer2"  class="form-control" id="question"></textarea>
      </div>
    </div>

    <div class="form-group row">
      <label for="question" class="col-md-2 col-form-label col-md-offset-2">Option 3</label>
      <div class="col-md-5">
        <textarea name="answer3"  class="form-control" id="question"></textarea>
      </div>
    </div>


    <div class="form-group row">
      <label for="question" class="col-md-2 col-form-label col-md-offset-2">Option 4</label>
      <div class="col-md-5">
        <textarea name="answer4"  class="form-control" id="question"></textarea>
      </div>
    </div>

    <div class="form-group row">
      <label class="col-md-2 col-form-label col-md-offset-2">Answer Type</label>
      <div class="col-md-5">
        <label class="form-check-inline">
            <input class="form-check-input" type="radio" name="answertypeid" id="answertypeid1" value="1"> Single
        </label>
        <label class="form-check-inline">
            <input class="form-check-input" type="radio" name="answertypeid" id="answertypeid2" value="2"> Multiple
        </label>
      </div>
    </div>


    <div class="form-group row">
      <label class="col-md-2 col-form-label col-md-offset-2">Correct Answer(s)</label>
     <div class="col-md-5">
        <div class="form-check">
          <label class="form-check-label">
            <input class="form-check-input" type="checkbox" name="correctanswers[]" id="correctanswer1" value="1">
            1
          </label>
        </div>
        <div class="form-check">
          <label class="form-check-label">
            <input class="form-check-input" type="checkbox" name="correctanswers[]" id="correctanswer2" value="2">
            2
          </label>
        </div>
        <div class="form-check">
          <label class="form-check-label">
            <input class="form-check-input" type="checkbox" name="correctanswers[]" id="correctanswer3" value="3">
            3
          </label>
        </div>
        <div class="form-check">
          <label class="form-check-label">
            <input class="form-check-input" type="checkbox" name="correctanswers[]" id="correctanswer4" value="4">
            4
          </label>
        </div>

      </div>
    </div>

    <div class="form-group row">
      <label for="marks" class="col-md-2 col-form-label col-md-offset-2">Marks</label>
      <div class="col-md-5">
        <input name="marks" value="1" class="form-control" id="marks"></input>
      </div>
    </div>

    <div class="form-group row">
      <div class="col-md-offset-4 col-md-5">
        <button type="submit" class="btn btn-primary" name="command" value="Add Question">Add Question</button>
      </div>
    </div>
  </form>
</div>



  <div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <form action="" method="post">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          <h4 class="modal-title" id="exampleModalLabel">Add New Subject</h4>
        </div>
        <div class="modal-body">
            <div class="form-group">
              <label for="subjectname" class="form-control-label">Subject Name:</label>
              <input type="text" class="form-control" id="subjectname" name="subjectname">
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary" name="command" value="Add Subject">Add Subject</button>
        </div>
      </div>
    </div>
    </form>
  </div>
