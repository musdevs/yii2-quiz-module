<?php
    use yii\widgets\LinkPager;
    use yii\helpers\{Html, Url};
?>
<h2>Список тестов</h2>
<div class="g_test_list_table_wrapper">
    <table class="table table-striped">
        <?php foreach($testList as $item): ?>
            <tr>
                <td>
                    <?= $item->name ?>
                </td>
                <td align="right">
                    <?= Html::a('Перейти', Url::to(['test-index', 'test_id' => $item['id']]), [
                        'class' => 'btn btn-primary btn-small'
                    ])?>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>
<?= LinkPager::widget(['pagination' => $pages]); ?>