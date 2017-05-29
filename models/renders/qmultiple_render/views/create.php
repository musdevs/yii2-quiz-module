<?php
use yii\helpers\Html;
?>
<div data-question="2" class="g_answer_container">
    <?= Html::label('Варианты ответа')?><br/>
    <?= Html::a('<span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Добавить вариант', '#', ['onclick' => 'g_add_many(event);'])?>
    <table class="table">
        <tr>
            <td class="col-xs-11">
                <div>
                    <?= Html::textInput('wrong_many[]', null, ['placeholder' => 'Введите вариант ответа', 'class' => 'form-control'])?>
                    <span class="help-block">Правильный</span>
                </div>
            </td>
            <td>
                <?= Html::checkbox('question_answers', false, ['data-control' => 'chk_many', 'onclick' => 'g_chkManyClick(this)'])?>
            </td>
        </tr>
        <tr>
            <td class="col-xs-11">
                <div>
                    <?= Html::textInput('wrong_many[]', null, ['placeholder' => 'Введите вариант ответа', 'class' => 'form-control'])?>
                    <span class="help-block">Правильный</span>
                </div>
            </td>
            <td>
                <?= Html::checkbox('question_answers', false, ['data-control' => 'chk_many', 'onclick' => 'g_chkManyClick(this)'])?>
            </td>
        </tr>
    </table>
</div>

<?php
$inputTxt_many = Html::textInput('wrong_many[]', null, ['placeholder' => 'Введите вариант ответа', 'class' => 'form-control']);
$inputChk_many = Html::checkbox('question_answers', false, ['data-control' => 'chk_many', 'onclick' => 'g_chkManyClick(this)']);
?>

<?php $script = <<< JS
    
    function g_add_many() {
        event.preventDefault();
        var in_group = '<tr>';
        in_group = in_group + '<tr>';
        in_group = in_group + '<td class="col-xs-11">';
        in_group = in_group + '<div>';
        in_group = in_group + '$inputTxt_many';
        in_group = in_group + '<span class="help-block">Правильный</span>';
        in_group = in_group + '</div>';
        in_group = in_group + '</td>';
        in_group = in_group + '<td>';
        in_group = in_group + '$inputChk_many';
        in_group = in_group + '</td>';
        in_group = in_group + '</tr>';
                        
        $('.g_answer_container[data-question="2"] table').prepend(in_group);
    }
    
    function g_chkManyClick(elem) {
        var input = $(elem).parents('tr').find('input[type="text"]');
        var other = $('input[data-control="chk_many"]').not(elem);
        
        input.attr('name', 'right_many[]');
        input.parent('div').toggleClass('has-success');
    }
JS;
$parentViewObject->registerJs($script, yii\web\View::POS_END); ?>
