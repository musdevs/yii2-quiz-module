<?php
use yii\helpers\Html;
?>
<table class="table">
    <tr>
        <td>
            <?= Html::textInput('answer', !empty($_SESSION['answers'][Yii::$app->request->get('question')]) ? $_SESSION['answers'][Yii::$app->request->get('question')] : null, ['class' => 'form-control'])?>
        </td>
    </tr>
</table>