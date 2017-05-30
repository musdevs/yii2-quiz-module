<?php
use yii\helpers\Html;

/* @var $answers array - Array of json decoded objects from `quiz_question`.`answers ` field  */
/* @var $this yii\web\View */
/* @var $sAnswer string - user answer_id stored in session */
?>
<table class="table">
    <?php foreach($answers as $answer): ?>
        <tr>
            <td class="col-xs-1">
                <?= Html::radio(
                    'answer',
                    !empty($sAnswer) && $answer->id == $sAnswer,
                    [
                        'value' => $answer->id,
                        'required' => 'required'
                    ])
                ?>
            </td>
            <td><?= Html::decode($answer->text) ?></td>
        </tr>
    <?php endforeach; ?>
</table>