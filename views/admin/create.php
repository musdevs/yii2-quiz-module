<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $testModel gypsyk\quiz\models\AR_QuizTest */
?>

<?php $form = ActiveForm::begin() ?>
    <?= $form->field($testModel, 'name') ?>
    <div class="form-group">
        <div class="pull-right">
            <?= Html::submitButton('Продолжить', ['class' => 'btn btn-primary']) ?>
        </div>
        <div class="clearfix"></div>
    </div>
<?php ActiveForm::end() ?>