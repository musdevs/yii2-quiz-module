<?php
use yii\helpers\Html;

/* @var $answers array - Array of json decoded objects from `quiz_question`.`answers ` field  */
/* @var $this yii\web\View */
/* @var $sAnswer array - array of users answer_ids stored in session */
?>
<table class="table">
    <?php foreach($answers as $answer): ?>
        <tr>
            <td class="col-xs-1">
                <?= Html::checkbox(
                    'answer[]',
                    !empty($sAnswer) && in_array($answer->id, $sAnswer),
                    ['value' => $answer->id]
                )?>
            </td>
            <td><?= Html::decode($answer->text) ?></td>
        </tr>
    <?php endforeach; ?>
</table>