<?php
use yii\widgets\LinkPager;
use yii\helpers\{Html, Url};

/* @var $this yii\web\View */
/* @var $testList gypsyk\quiz\models\AR_QuizTest[] */
/* @var $pages integer */

$this->title = \Yii::$app->controller->module->t('app', 'Test list');
?>
<h2><?= \Yii::$app->controller->module->t('app', 'Test list') ?></h2>
<div class="g_test_list_table_wrapper">
    <table class="table table-striped">
        <?php foreach($testList as $item): ?>
            <tr>
                <td>
                    <?= $item->name ?>
                </td>
                <td align="right">
                    <?= Html::a(
                        \Yii::$app->controller->module->t('app', 'To test'),
                        Url::to(['test-index', 'test_id' => $item['id']]),
                        ['class' => 'btn btn-primary btn-small']
                    )?>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>
<?= LinkPager::widget(['pagination' => $pages]); ?>