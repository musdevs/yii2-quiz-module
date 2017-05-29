<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $tList array - select options (question types) */
/* @var $testModel \gypsyk\quiz\models\AR_QuizTest */
/* @var $questionList \gypsyk\quiz\models\AR_QuizQuestion[] */
/* @var $questionViews  string - result of concatenation of all question renderers renderCreate() functions;  */

$this->title = \Yii::$app->controller->module->t('app', 'Add question.  {testName}.', [
    'testName' => $testModel->name
]);
?>

<div class="row">
    <div class="col-xs-6">
        <?= Html::beginForm()?>
            <div class="form-group">
                <?= Html::label(\Yii::$app->controller->module->t('app', 'Question text'))?>
                <?= Html::textarea('question_text', '', [
                    'class' => 'form-control', 
                    'rows' => 7, 
                    'placeholder' => \Yii::$app->controller->module->t('app', 'Enter the text of the question')]
                )?>
            </div>
            <div class="form-group">
                <?= Html::label(\Yii::$app->controller->module->t('app', 'Type of answer'))?>
                <?= Html::dropDownList('question_type', null, $tList, [
                    'class' => 'form-control',
                    'options'=>['0' => ['disabled' => true, 'selected' => true]]
                ])?>
            </div>

            <?= $questionViews ?>
            
            <?= Html::submitButton(
                \Yii::$app->controller->module->t('app', 'Save and add more'),
                ['class' => 'btn btn-success pull-right g_btn']
            )?>
            <?= Html::submitButton(
                \Yii::$app->controller->module->t('app', 'Complete creation'),
                ['class' => 'btn btn-primary pull-right g_btn']
            )?>
            <div class="clearfix"></div>
        <?= Html::endForm()?>
    </div>
    <div class="col-xs-6">
        <h3>
            <small><?= \Yii::$app->controller->module->t('app', 'Test')?>: </small>
            <?= $testModel->name?>
        </h3>
        <ol>
            <?php foreach($questionList as $question): ?>
                <li><?= $question->question ?></li>
            <?php endforeach; ?>
        </ol>
    </div>
</div>

<?php $script = <<< JS
    $('select[name="question_type"]').change(function() {
        g_toogle($(this).val());
    });
JS;
$this->registerJs($script, yii\web\View::POS_READY); ?>

<?php $script = <<< JS
    function g_toogle(value) {
        $('.g_answer_container').hide();
        $('div[data-question="' + value + '"]').show();
    }
JS;
$this->registerJs($script, yii\web\View::POS_END); ?>