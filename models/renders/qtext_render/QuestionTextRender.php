<?php
namespace gypsyk\quiz\models\renders\qtext_render;

use gypsyk\quiz\models\renders\Context;

class QuestionTextRender extends \yii\base\View
{
    public $viewFilePath = 'qtext_render/views/';

    public function renderResult()
    {
        return parent::render($this->viewFilePath . 'result', [], new Context());
    }
}