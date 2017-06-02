<?php
use yii\helpers\{Html, Url, Json};

/* @var $this yii\web\View */
/* @var $tList array - select options (question types) */
/* @var $testModel \gypsyk\quiz\models\AR_QuizTest */
/* @var $questionModel \gypsyk\quiz\models\AR_QuizQuestion */

$this->title = \Yii::$app->controller->module->t('app', 'Add question.  {testName}.', [
    'testName' => $testModel->name
]);
?>
<?= Html::beginForm() ?>
<div class="row">
    <h4>Edit question</h4>
        <div class="col-xs-6">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="form-group">
                        <?= Html::label(\Yii::$app->controller->module->t('app', 'Question text'))?>
                        <?= Html::textarea('question_text', $questionModel->question, [
                                'class' => 'form-control',
                                'rows' => 7,
                                'placeholder' => \Yii::$app->controller->module->t('app', 'Enter the text of the question')]
                        )?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xs-6">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="form-group">
                        <?= Html::label(\Yii::$app->controller->module->t('app', 'Type of answer'))?>
                        <?= Html::dropDownList('question_type', $questionModel->type, $tList, [
                            'class' => 'form-control',
                            'options'=>['0' => ['disabled' => true]]
                        ])?>
                    </div>

                    <?= \gypsyk\quiz\models\Quiz::renderQuestionEdit(
                        $this,
                        $questionModel->type,
                        Json::decode($questionModel->answers, false),
                        Json::decode($questionModel->r_answers, false)
                    ) ?>
                </div>
            </div>
        </div>
</div>
<?= Html::submitButton(
    \Yii::$app->controller->module->t('app', 'Save'),
    ['class' => 'btn btn-success pull-right g_btn']
)?>
<?= Html::a(
    'Back',
    Url::to(['admin/new-question', 'test_id' => $testModel->getPrimaryKey()]),
    ['class' => 'btn btn-default pull-right g_btn']
)?>
<div class="clearfix"></div>
<?= Html::endForm()?>

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
        
        console.log('Before execution: ' + link.data('state'));
        
        switch(link.data('state')) {
            case 'open': 
                console.log('Closing...');
                link.data('state', 'closed');
                link.html('<i class="glyphicon glyphicon-chevron-up" aria-hidden="false"></i>'); 
                break;
            case 'closed': 
                console.log('Opening...');
                link.data('state', 'open'); 
                link.html('<i class="glyphicon glyphicon-chevron-down" aria-hidden="false"></i>');
                break;
            default:
                break;
        }

        console.log('After execution: ' + link.data('state'));
        $("#g_description_wrapper").toggleClass("g_description_hidden");
    }
JS;
$this->registerJs($script, yii\web\View::POS_END); ?>