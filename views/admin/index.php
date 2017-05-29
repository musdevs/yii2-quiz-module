<?php
use yii\widgets\LinkPager;
use yii\helpers\{Html, Url};

/* @var $this yii\web\View */
/* @var $testList gypsyk\quiz\models\AR_QuizTest[] */
/* @var $pages integer */

$this->title = \Yii::$app->controller->module->t('app', 'Test list');
?>

<div>
    <div class="pull-left">
        <h2><?= \Yii::$app->controller->module->t('app', 'Test list') ?></h2>
    </div>
    <div class="pull-right">
        <?= Html::a(
            \Yii::$app->controller->module->t('app', 'Create test'),
            Url::to(['admin/create']),
            ['class' => 'btn btn-danger g-heading-btn']
        )?>
    </div>
    <div class="clearfix"></div>
</div>

<div class="g_test_list_table_wrapper">
    <table class="table table-striped">
        <?php foreach($testList as $item): ?>
            <tr>
                <td>
                    <?= $item->name ?>
                </td>
                <td align="right">
                    <?= Html::a(
                        \Yii::$app->controller->module->t('app', 'Edit'),
                        Url::to(['test-index', 'test_id' => $item['id']]),
                        ['class' => 'btn btn-primary btn-small']
                    )?>
                    <?= Html::a(
                        \Yii::$app->controller->module->t('app', 'Enter'),
                        Url::to(['default/test-index', 'test_id' => $item['id']]),
                        ['class' => 'btn btn-primary btn-small']
                    )?>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>
<?= LinkPager::widget(['pagination' => $pages]); ?>