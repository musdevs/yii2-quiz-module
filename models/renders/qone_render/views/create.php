<?php
use yii\helpers\Html;
?>
<div data-question="<?= $questionTypeId ?>" class="g_answer_container">
    <?= Html::label('Варианты ответа')?><br/>
    <?= Html::a('<span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Добавить вариант', '#', ['onclick' => 'g_add_one(event);'])?>
    <table class="table">
        <?php for($i = 0; $i < 2; $i++):?>
            <?= $this->render('templates/variant') ?>
        <?php endfor; ?>
    </table>
</div>

<?php
//Little trick to escape new line character
$variantTemplate = json_encode($this->render('templates/variant'));
$js = $this->render('templates/_js', [
    'template' => $variantTemplate,
    'questionTypeId' => $questionTypeId
]);
$parentViewObject->registerJs($js, yii\web\View::POS_END);
?>