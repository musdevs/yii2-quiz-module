<?php
use yii\helpers\{Html, Url};

/* @var $this yii\web\View */
/* @var $tList array - select options (question types) */
/* @var $testModel \gypsyk\quiz\models\AR_QuizTest */
/* @var $questionList \gypsyk\quiz\models\AR_QuizQuestion[] */

$this->title = \Yii::$app->controller->module->t('app', 'Add question.  {testName}.', [
    'testName' => $testModel->name
]);
?>

<div class="row">
    <div class="col-xs-6">
        <div class="panel panel-default">
            <div class="panel-body">
                <h4>Добавить новый вопрос</h4>
                <?= Html::beginForm()?>
                    <div class="form-group">
                        <?= Html::label(\Yii::$app->controller->module->t('app', 'Question text'))?>
                        <?= Html::textarea('question_text', '', [
                            'class' => 'form-control',
                            'rows' => 7,
                            'placeholder' => \Yii::$app->controller->module->t('app', 'Enter the text of the question')]
                        )?>
                    </div>
                    <div class="form-group">
                        <?= Html::label(\Yii::$app->controller->module->t('app', 'Type of answer'))?>
                        <?= Html::dropDownList('question_type', null, $tList, [
                            'class' => 'form-control',
                            'options'=>['0' => ['disabled' => true, 'selected' => true]]
                        ])?>
                    </div>

                    <?= \gypsyk\quiz\models\Quiz::renderQuestionCreate($this) ?>

                    <?= Html::submitButton(
                        \Yii::$app->controller->module->t('app', 'Save and add more'),
                        ['class' => 'btn btn-success pull-right g_btn']
                    )?>
                    <?= Html::submitButton(
                        \Yii::$app->controller->module->t('app', 'Complete creation'),
                        ['class' => 'btn btn-primary pull-right g_btn']
                    )?>
                    <div class="clearfix"></div>
                <?= Html::endForm()?>
            </div>
        </div>
    </div>
    <div class="col-xs-6">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="row">
                    <div class="col-xs-1">
                        <?= Html::a('<i class="glyphicon glyphicon-pencil"></i>', '#', ['class' => 'btn btn-default btn-sm'])?>
                    </div>
                    <div class="col-xs-11">
                        <strong>
                            <small><?= \Yii::$app->controller->module->t('app', 'Test')?>: </small>
                            <?= Html::decode($testModel->name) ?>
                        </strong>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="row">
                    <div class="col-xs-1">
                        <?= Html::a('<i class="glyphicon glyphicon-pencil"></i>', '#', ['class' => 'btn btn-default btn-sm'])?>
                        <br/>
                        <?= Html::a(
                            '<i class="glyphicon glyphicon-chevron-down" aria-hidden="false"></i>',
                            '#',
                            [
                                'class' => 'btn btn-default btn-sm',
                                'onclick' => 'g_toggleDescription(event, this)',
                                'data-state' => 'open'
                            ]
                        )?>
                    </div>
                    <div class="col-xs-11">
                        <div id="g_description_wrapper" class="g_description_hidden">
                            <?= Html::decode($testModel->description) ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <table class="table">
            <?php foreach($questionList as $question): ?>
                <tr>
                    <td width="95">
                        <?= Html::a(
                            '<i class="glyphicon glyphicon-pencil"></i>',
                            Url::to(['admin/edit-question', 'question_id' => $question->getPrimaryKey()]),
                            ['class' => 'btn btn-default btn-sm']
                        )?>
                        <?= Html::a('<i class="glyphicon glyphicon-remove"></i>', '#', ['class' => 'btn btn-danger btn-sm'])?>
                    </td>
                    <td>
                        <?= $question->question ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
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
    
    function g_toggleDescription(e, obj) {
        var link = $(obj);
        e.preventDefault();
        
        switch(link.data('state')) {
            case 'open': 
                link.data('state', 'closed');
                link.html('<i class="glyphicon glyphicon-chevron-up" aria-hidden="false"></i>'); 
                break;
            case 'closed': 
                link.data('state', 'open'); 
                link.html('<i class="glyphicon glyphicon-chevron-down" aria-hidden="false"></i>');
                break;
            default:
                break;
        }

        $("#g_description_wrapper").toggleClass("g_description_hidden");
    }
JS;
$this->registerJs($script, yii\web\View::POS_END); ?>