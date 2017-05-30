<?php
use yii\helpers\{Html, Url, Json};

/* @var $this yii\web\View */
/* @var $questionText string */
/* @var $questionRender object - object of \gypsyk\quiz\models\renders\* class */
/* @var $testTitle string */
/* @var $questionList array - question numbers map */
/* @var $questionId integer - number of question in current test session */
/* @var $jsonVariants string - Json string from `quiz_question`.`answers` field */
/* @var $sAnswers array - Array of user answers stored in session */

$this->title = \Yii::$app->controller->module->t('app', 'Question № {questionNumber}. {testTitle}', [
    'questionNumber' => $questionId,
    'testTitle' => $testTitle
]);
?>

<p>
    <?= Html::decode($questionText)?>
</p>

<?= Html::beginForm()?>
    <?= $questionRender->renderTesting(Json::decode($jsonVariants, false), $sAnswers[$questionId] ?? null) ?>
    <?= Html::submitButton(
        \Yii::$app->controller->module->t('app', 'Answer'),
        ['class' => 'btn btn-success', 'name' => 'save_btn', 'value' => '1']
    )?>
    <?= Html::a(
        \Yii::$app->controller->module->t('app', 'Finish testing'),
        Url::to(['results']),
        ['class' => 'btn btn-danger', 'id'=>'g_end_test_btn']
    )?>
<?= Html::endForm()?>

<ul class="pagination">
    <?php foreach($questionList as $key => $value): ?>
        <li class="<?= $questionId == $key ? 'active' : ''?>">
            <a href="<?= Url::to(['test', 'question' => $key]) ?>">
                <?=$key?>
                <?php if(!empty($sAnswers[$key])): ?>
                    <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
                <?php endif; ?>
            </a>
        </li>
    <?php endforeach; ?>
</ul>
<?php
$confirmMessage = \Yii::$app->controller->module->t('app', 'Are you sure you want to finish the test? You will not be able to change your answers.');
?>
<?php $script = <<< JS
    $('#g_end_test_btn').click(function(event) {
        var href = this.href;
        event.preventDefault();
        var isOver = confirm("$confirmMessage");
        
        if(isOver)
            window.location = href;
    })
JS;
$this->registerJs($script, yii\web\View::POS_READY); ?>
