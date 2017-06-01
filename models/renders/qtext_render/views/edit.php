<div data-question="<?= $questionTypeId ?>" class="g_answer_container <?= $isActive ? 'active' : ''?>">
    <?= $this->render(
        'templates/variant',
        ['text' =>  $variants[0]->text]
    ) ?>
</div>