<?php
    use yii\helpers\Html;
    use yii\helpers\Url;
?>
<p>
    <?= $questionText ?>
</p>

<?= Html::beginForm()?>
    <?= $questionRender ?>
    <?= Html::submitButton('Ответить', ['class' => 'btn btn-success', 'name' => 'save_btn', 'value' => '1'])?>
    <?= Html::a('Завершить тест', Url::to(['results']), ['class' => 'btn btn-danger', 'id'=>'g_end_test_btn'])?>
<?= Html::endForm()?>

<ul class="pagination">
    <?php foreach($questionList as $key => $value): ?>
        <li class="<?= $questionId == $key ? 'active' : ''?>">
            <a href="<?= Url::to(['test', 'question' => $key]) ?>">
                <?=$key?>
                <?php if(!empty($sAnswers[$key])): ?>
                    <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
                <?php endif; ?>
            </a>
        </li>
    <?php endforeach; ?>
</ul>

<?php $script = <<< JS
    $('#g_end_test_btn').click(function(event) {
        var href = this.href;
        event.preventDefault();
        var isOver = confirm("Вы уверены, что хотите завершить тест? Изменить ваши ответы будет невозможно.");
        if(isOver)
            window.location = href;
    })
JS;
$this->registerJs($script, yii\web\View::POS_READY); ?>
