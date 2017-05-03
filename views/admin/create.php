<?php
use yii\helpers\Html;
?>
<div class="row">
    <div class="col-xs-6">
        <?= Html::beginForm()?>
            <div class="form-group">
                <?= Html::label('Текст вопроса')?>
                <?= Html::textarea('question_text', '', ['class' => 'form-control', 'rows' => 7, 'placeholder' => 'Введите текст вопроса'])?>
            </div>
            <div class="form-group">
                <?= Html::label('Тип ответа')?>
                <?= Html::dropDownList('question_type', null, [
                        0 => 'Выберите тип ответа...',
                        1 => 'Один правильный',
                        2 => 'Несколько правильных',
                        3 => 'Ответ текстом',
                    ], [
                        'class' => 'form-control',
                        'options'=>['0' => ['disabled' => true, 'selected' => true]]
                ])?>
            </div>

            <?= $this->render('create/question_one')?>
            <?= $this->render('create/question_many')?>
            <?= $this->render('create/question_custom')?>
            
            <?= Html::submitButton('Далее', ['class' => 'btn btn-primary pull-right'])?>
        <?= Html::endForm()?>
    </div>
    <div class="col-xs-6">
        <? var_dump(Yii::$app->request->post())?>
    </div>
</div>

<?php $script = <<< JS
    $('select[name="question_type"]').change(function() {
        g_toogle($(this).val());
    });
JS;
$this->registerJs($script, yii\web\View::POS_READY); ?>

<?php $script = <<< JS
    function g_toogle(value) {
        $('.g_answer_container').hide();
        $('div[data-question="' + value + '"]').show();
    }
JS;
$this->registerJs($script, yii\web\View::POS_END); ?>

<?php $script = <<< CSS
    .g_answer_container {
        display: none;
    }
    .right-answers {
        display: none;
    }
    .help-block {
        display: none;    
    }
    .has-success .help-block {
        display: block;
    }
CSS;
$this->registerCss($script); ?>