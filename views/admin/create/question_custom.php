<?php
use yii\helpers\Html;
?>
<div data-question="3" class="g_answer_container">
    <p>
        Введите текстовый ответ. Учтите, что ответ будет засчитан пользователю только при полном
        совпадении введенных данных.
        Чтобы помочь пользователям не ошибиться, в тексте вопроса уточните в каком виде неоходимо предоставить ответ.
    </p>
    <div class="form-group">
        <?= Html::textInput('custom', null, ['placeholder' => 'Введите правильный ответ', 'class' => 'form-control'])?>
    </div>
</div>