<?php
use yii\helpers\Html;
?>
<tr>
    <td class="col-xs-11">
        <div class="<?= !empty($hasSuccess) && $hasSuccess ? 'has-success' : ''?>">
            <?= Html::textInput(
                'wrong_many[]',
                $text ?? null,
                ['placeholder' => 'Type variant', 'class' => 'form-control']
            )?>
        </div>
    </td>
    <td>
        <?= Html::checkbox(
            'question_answers', 
            $hasSuccess ?? false,
            ['data-control' => 'chk_many', 'onclick' => 'g_chkManyClick(this)']
        )?>
    </td>
</tr>