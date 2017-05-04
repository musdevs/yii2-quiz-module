<?php
use yii\helpers\Html;
?>
<div data-question="1" class="g_answer_container">
    <?= Html::label('Варианты ответа')?><br/>
    <?= Html::a('<span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Добавить вариант', '#', ['onclick' => 'g_add_one(event);'])?>
    <table class="table">
        <tr>
            <td class="col-xs-11">
                <div>
                    <?= Html::textInput('wrong_one[]', null, ['placeholder' => 'Введите вариант ответа', 'class' => 'form-control'])?>
                    <span class="help-block">Правильный</span>
                </div>
            </td>
            <td>
                <?= Html::checkbox('question_answers', false, ['data-control' => 'chk_one', 'onclick' => 'g_chkOneClick(this)'])?>
            </td>
        </tr>
        <tr>
            <td class="col-xs-11">
                <div>
                    <?= Html::textInput('wrong_one[]', null, ['placeholder' => 'Введите вариант ответа', 'class' => 'form-control'])?>
                    <span class="help-block">Правильный</span>
                </div>
            </td>
            <td>
                <?= Html::checkbox('question_answers', false, ['data-control' => 'chk_one', 'onclick' => 'g_chkOneClick(this)'])?>
            </td>
        </tr>
    </table>
</div>

<?php
$inputTxt_one = Html::textInput('wrong_one[]', null, ['placeholder' => 'Введите вариант ответа', 'class' => 'form-control']);
$inputChk_one = Html::checkbox('question_answers', false, ['data-control' => 'chk_one', 'onclick' => 'g_chkOneClick(this)']);
?>

<?php $script = <<< JS
    
    function g_add_one(event) {
        event.preventDefault();
        var in_group = '<tr>';
        in_group = in_group + '<tr>';
        in_group = in_group + '<td class="col-xs-11">';
        in_group = in_group + '<div>';
        in_group = in_group + '$inputTxt_one';
        in_group = in_group + '<span class="help-block">Правильный</span>';
        in_group = in_group + '</div>';
        in_group = in_group + '</td>';
        in_group = in_group + '<td>';
        in_group = in_group + '$inputChk_one';
        in_group = in_group + '</td>';
        in_group = in_group + '</tr>';
                        
        $('.g_answer_container[data-question="1"] table').prepend(in_group);
    }
    
    function g_chkOneClick(elem) {
        var input = $(elem).parents('tr').find('input[type="text"]');
        var other = $('input[data-control="chk_one"]').not(elem);
        
        input.attr('name', 'right_one');
        input.parent('div').toggleClass('has-success');

        other.each(function() {
            if($(this)[0].checked) {
                $(this).prop('checked', false);
                g_mark_wrong_one($(this));
            }
        })
    }
    
    function g_mark_wrong_one(chbx_element) {
        var input = chbx_element.parents('tr').find('input[type="text"]');
        
        input.attr('name', 'wrong_one[]');
        input.parent('div').removeClass('has-success');
    }
JS;
$this->registerJs($script, yii\web\View::POS_END); ?>
