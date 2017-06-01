<?php
use yii\helpers\Html;
?>
<div data-question="<?= $questionTypeId ?>" class="g_answer_container <?= $isActive ? 'active' : ''?>">
    <?= Html::label('Variants of answer')?><br/>
    <?= Html::a(
        '<span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Add variant', 
        '#',
        ['onclick' => 'g_add_many(event);']
    )?>
    <table class="table">
        <?php foreach($variants as $variant): ?>
            <?= $this->render(
                'templates/variant',
                ['text' => $variant->text, 'hasSuccess' => in_array($variant->id, $answers)]
            ) ?>
        <?php endforeach; ?>
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

