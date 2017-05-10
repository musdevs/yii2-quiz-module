<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $quizModel gypsyk\quiz\models\Quiz */

?>
<h1>Результаты теста</h1>
<p>Всего вопросов: <?= $quizModel->statistics['maxPoints'] ?></p>
<p>Правильных ответов: <?= $quizModel->statistics['rightAnswersCount'] ?></p>
<p>Неправильных ответов: <?= $quizModel->statistics['wrongAnswersCount'] ?></p>

<h2>Детализация</h2>
<?php foreach ($quizModel->questions as $question): ?>
    <?= $question->getRender()->renderResult($this) ?>
    <hr>
<?php endforeach; ?>