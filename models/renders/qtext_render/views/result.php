<?php
/* @var $this gypsyk\quiz\models\renders\qtext_render\QuestionTextRender */
/* @var $question \gypsyk\quiz\models\questions\QuestionText */
?>

<table class="table table-bordered <?= $question->isUserAnswerIsCorrect() ? 'bg-success' : 'bg-danger'  ?>">
    <thead>
    <tr>
        <th>Вопрос</th>
        <th class="col-xs-1">Правильный</th>
        <th class="col-xs-1">Ваш</th>
    </tr>
    </thead>
    <tbody>
        <tr>
            <td><?= $question->text ?></td>
            <td><?= $question->correctAnswer ?></td>
            <td><?= $question->userAnswer ?></td>
        </tr>
    </tbody>
</table>