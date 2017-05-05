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
<?php endforeach; ?>










<!--    --><?php //foreach($questions as $question): ?>
<!--        <p>--><?//= $question->question ?><!--</p>-->
<!--        <table class="table table-bordered">-->
<!--            <tr>-->
<!--                <th class="col-xs-8">Ответы</th>-->
<!--                <th class="col-xs-2">Правильный</th>-->
<!--                <th class="col-xs-2">Ваш</th>-->
<!--            </tr>-->
<!--            --><?php //foreach($question->variants as $variant): ?>
<!--                <tr>-->
<!--                    <td>--><?//= $variant->text ?><!--</td>-->
<!--                    <td class="text-center">-->
<!--                        --><?php //if($variant->isCorrect): ?>
<!--                            <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>-->
<!--                        --><?php //endif; ?>
<!--                    </td>-->
<!--                    <td class="text-center">-->
<!---->
<!--                    </td>-->
<!--                </tr>-->
<!--            --><?php //endforeach;?>
<!--        </table>-->
<!--        <hr>-->
<!--    --><?php //endforeach; ?>
