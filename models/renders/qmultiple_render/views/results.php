<?php
/* @var $this gypsyk\quiz\models\renders\qmultiple_render\QuestionMultipleRender */
/* @var $question \gypsyk\quiz\models\questions\QuestionMultiple */
?>

<table class="table table-bordered <?= $question->isUserAnswerIsCorrect() ? 'bg-success' : 'bg-danger'  ?>">
    <thead>
    <tr>
        <th><?= $question->text ?></th>
        <th class="col-xs-1">Правильный</th>
        <th class="col-xs-1">Ваш</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($question->variants as $variant): ?>
        <tr>
            <td><?= $variant['text'] ?></td>
            <td class="text-center">
                <?php if($variant['is_correct']): ?>
                    <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
                <?php endif; ?>
            </td>
            <td class="text-center">
                <?php if($variant['is_user_checked']): ?>
                    <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
                <?php endif; ?>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>