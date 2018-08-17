<?php


require_once 'mysql.php';
$examid=$_GET['examid'];
$answerlist=GetAnswerList($examid);

//var_dump($answerlist);

function MarkAnswer($ano,$prevanswer)
{
	$prevanswer=explode(",",$prevanswer);
	if($prevanswer!="")
	foreach($prevanswer as $ans)
	{
		if($ans==$ano)
		{
			echo 'checked';
		}
	}
}
?>


<?php $qno=1; foreach($answerlist as $question) { ?>
<h3><?php echo "Q " . $qno++ . ". " . $question['question']; ?></h3>
		<?php
			$answers=LoadAnswer($question['QuestionBank_id']); 
			$ano=1; 
			foreach ($answers as $answer) 
			{
				if($answer['answer']!='')
				{
		?>

		<h5>
		<?php if($question['AnsType_id']==1) { ?>		
		<input type="radio" class="form-check-input"  <?php echo $ano==$question['answers']?'checked':''; ?> value="<?php echo $ano++;?>"> <?php echo $answer['answer']; ?> 
		<?php } else { ?>
		<input type="checkbox" class="form-check-input form-check" name="answer[]" <?php MarkAnswer($ano,$question['answers']); ?> value="<?php echo $ano++; ?>"> <?php echo $answer['answer']; ?> 	
		</h5>
		<?php } } } ?>
		<hr>
<?php } ?>