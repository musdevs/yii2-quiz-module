<?php
use yii\helpers\{Html, Url};

/* @var $this yii\web\View */
/* @var $testModel gypsyk\quiz\models\AR_QuizTest */
/* @var $countQuestion integer */

$this->title = $testModel->name;
?>

<div class="center-block g_desc_wrapper">
    <div class="panel panel-default">
        <div class="panel-heading">
            <?= Html::encode($testModel->name)?>
        </div>
        <div class="panel-body">
            <p>
                <?= Html::encode($testModel->description)?>
            </p>
            <span><?= Yii::$app->controller->module->t('app', 'Questions') ?>: <?= $countQuestion ?></span>
            <?= Html::a(
                Yii::$app->controller->module->t('app', 'Enter'), 
                Url::to(['default/enter', 'test_id' => $testModel->getPrimaryKey()]), 
                ['class' => 'btn btn-primary pull-right']
            )?>
            <div class="clearfix"></div>
        </div>
    </div>
</div>