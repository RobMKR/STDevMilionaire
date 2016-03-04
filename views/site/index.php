<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\web\Application;
use app\models\Questions;
if (!isset($_GET['question_id']) || !isset($_SESSION["questions"][$_GET['question_id']])){
  $question_id = current(array_keys($_SESSION["questions"]));
} else {
  $question_id = $_GET['question_id'];
}


 ?>
<?php if (Yii::$app->session->hasFlash('final')) :?>
  <?php Questions::getQFlash(); ?>
  <?php echo "<div class='alert alert-success'>".Yii::$app->session->getFlash('final')."<a href='/users/addscores?score=".Yii::$app->session['score']."'> Add to High scores </a> </div>";?>
<?php else :?>
  <div class="row">
    <h1 align="center">Answer a Question</h1>

      <?php $form = ActiveForm::begin([
            'method' => 'get',
            'action' => '?question='.$question_id,
            ]);?>
      <?php $i=1; ?>

      <ol>
        <div class="col-lg-12 question"><?="QUESTION. - ".$_SESSION["questions"][$question_id]['question']?></div>

        <?php foreach($_SESSION["questions"][$question_id]['answers'] as $answer) : ?>
          <div class="col-lg-12 answer"><input type="checkbox" name="answer[]" value="<?=$answer?>"> <?=$i.". ".$answer;?></div><?php $i++; ?>
        <?php endforeach; ?>


      </ol>
      <div class="col-lg-12 answer-submit"><?= Html::submitButton('Submit', ['class' => 'btn btn-primary answer-submit',]) ?></div>

      <?php ActiveForm::end();?>





  </div>

  <?php
    Questions::getQFlash();
  ?>
  <?php endif;?>
