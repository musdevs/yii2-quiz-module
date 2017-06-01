<?php
use yii\helpers\Html;
?>
<p>
    (ПЕРЕВЕСТИ)Введите текстовый ответ. Учтите, что ответ будет засчитан пользователю только при полном
    совпадении введенных данных.
    Чтобы помочь пользователям не ошибиться, в тексте вопроса уточните в каком виде неоходимо предоставить ответ.
</p>
<div class="form-group">
    <?= Html::textInput(
        'custom',
        $text ?? null,
        ['placeholder' => 'Type correct answer', 'class' => 'form-control']
    )?>
</div>