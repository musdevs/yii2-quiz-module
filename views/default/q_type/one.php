<?php
use yii\helpers\Html;

/* @var $answers[] obj */
?>
<table class="table">
    <?php foreach($answers as $answer): ?>
        <tr>
            <td class="col-xs-1">
                <?= Html::radio(
                    'answer',
                    !empty($_SESSION['answers'][Yii::$app->request->get('question')]) && $answer->id == $_SESSION['answers'][Yii::$app->request->get('question')],
                    [
                        'value' => $answer->id,
                        'required' => 'required'
                    ])
                ?>
            </td>
            <td><?= $answer->text ?></td>
        </tr>
    <?php endforeach; ?>
</table>