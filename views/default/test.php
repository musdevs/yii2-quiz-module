<?php
    use yii\helpers\Html;
    use yii\helpers\Url;

/* @var $questionModel gypsyk\quiz\models\AR_QuizQuestion */
/* @var $questionList[] integer */
/* @var $answers[] obj */
?>
<p>
    <?= $questionText ?>
</p>

<?= Html::beginForm()?>
    <?= $questionRender ?>
    <?= Html::submitButton('Ответить', ['class' => 'btn btn-success', 'name' => 'save_btn', 'value' => '1'])?>
    <?= Html::a('Завершить тест', Url::to(['results']), ['class' => 'btn btn-danger'])?>
<?= Html::endForm()?>

<ul class="pagination">
    <?php foreach($questionList as $key => $value): ?>
        <li class="<?= Yii::$app->request->get('question') == $key ? 'active' : ''?>">
            <a href="<?= Url::to(['test', 'question' => $key]) ?>">
                <?=$key?>
                <?php if(!empty($_SESSION['answers'][$key])): ?>
                    <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
                <?php endif; ?>
            </a>
        </li>
    <?php endforeach; ?>
</ul>

