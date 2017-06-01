<?php

/* @var $this yii\web\View */
/* @var $quizModel gypsyk\quiz\models\Quiz */

$this->title = \Yii::$app->controller->module->t('app', 'Test results');
?>

<h1><?= \Yii::$app->controller->module->t('app', 'Test results') ?></h1>
<table class="table table-bordered">
    <thead>
        <tr>
            <th><?= \Yii::$app->controller->module->t('app', 'Number of questions')?>:</th>
            <th class="success"><?= \Yii::$app->controller->module->t('app', 'Number of correct answers')?>:</th>
            <th class="danger"><?= \Yii::$app->controller->module->t('app', 'Number of wrong answers')?>:</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td><?= $quizModel->statistics['maxPoints'] ?></td>
            <td class="success"><?= $quizModel->statistics['rightAnswersCount'] ?></td>
            <td class="danger"><?= $quizModel->statistics['wrongAnswersCount'] ?></td>
        </tr>
    </tbody>
</table>
<h2>
    <?= \Yii::$app->controller->module->t('app', 'Detailing') ?>
</h2>
<?php foreach ($quizModel->questions as $question): ?>
    <?= $question->loadRender()->renderResult($this) ?>
    <hr>
<?php endforeach; ?>