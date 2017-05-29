<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $testModel gypsyk\quiz\models\AR_QuizTest */

$this->title = \Yii::$app->controller->module->t('app', 'New test');
?>

<div class="row">
    <div class="col-xs-6 col-xs-offset-3">
        <div class="panel panel-default">
            <div class="panel-body">
                <?php $form = ActiveForm::begin() ?>
                    <?= $form->field($testModel, 'name') ?>
                    <?= $form->field($testModel, 'description')->textarea(['rows' => 3]) ?>
                    <div class="form-group">
                        <div class="pull-right">
                            <?= Html::submitButton(
                                \Yii::$app->controller->module->t('app', 'Create'), 
                                ['class' => 'btn btn-primary']
                            ) ?>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                <?php ActiveForm::end() ?>
            </div>
        </div>
    </div>
</div>
