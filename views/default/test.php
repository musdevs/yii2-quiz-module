<?php
use yii\helpers\Html;
use yii\helpers\Url;
/* @var $questionModel gypsyk\quiz\models\AR_QuizQuestion */
/* @var $questionList[] integer */
/* @var $answers[] obj */
?>
<p>
    <?= $questionModel->question ?>
</p>

<?= Html::beginForm()?>
    <?php if($questionModel->type == 1): ?>
        <?= $this->render('q_type/one', ['answers' => $answers]) ?>
    <?php endif; ?>

    <?php if($questionModel->type == 2): ?>
        <?= $this->render('q_type/many', ['answers' => $answers]) ?>
    <?php endif; ?>

    <?php if($questionModel->type == 3): ?>
        <?= $this->render('q_type/custom') ?>
    <?php endif; ?>

    <?= Html::submitButton('Ответить', ['class' => 'btn btn-success', 'name' => 'save_btn', 'value' => '1'])?>
    <?= Html::submitButton('Завершить тест', ['class' => 'btn btn-danger'])?>
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

