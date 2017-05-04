<?php
use yii\helpers\Html;
use yii\helpers\Url;
/* @var $testModel gypsyk\quiz\models\AR_QuizTest */
?>
    <h1><?= $testModel->name?></h1>

<?= Html::a('Приступить', Url::to(['default/enter', 'test_id' => $testModel->getPrimaryKey()]), ['class' => 'btn btn-danger'])?>