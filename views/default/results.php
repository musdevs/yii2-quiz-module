<?php

/* @var $this yii\web\View */
/* @var $quizModel gypsyk\quiz\models\Quiz */

$this->title = \Yii::$app->controller->module->t('app', 'Test results');
?>

<h1><?= \Yii::$app->controller->module->t('app', 'Test results') ?></h1>
<p>
    <?= \Yii::$app->controller->module->t('app', 'Number of questions')?>:
    <?= $quizModel->statistics['maxPoints'] ?>
</p>
<p>
    <?= \Yii::$app->controller->module->t('app', 'Number of correct answers')?>:
    <?= $quizModel->statistics['rightAnswersCount'] ?>
</p>
<p>
    <?= \Yii::$app->controller->module->t('app', 'Number of wrong answers')?>:
    <?= $quizModel->statistics['wrongAnswersCount'] ?>
</p>
    
<h2><?= \Yii::$app->controller->module->t('app', 'Detailing') ?></h2>
<?php foreach ($quizModel->questions as $question): ?>
    <?= $question->loadRender()->renderResult($this) ?>
    <hr>
<?php endforeach; ?>