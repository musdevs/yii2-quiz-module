<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $sAnswer string - user answer stored in session */
?>

<table class="table">
    <tr>
        <td>
            <?= Html::textInput(
                'answer',
                !empty($sAnswer) ? Html::decode($sAnswer) : null,
                ['class' => 'form-control']
            )?>
        </td>
    </tr>
</table>