<?php
namespace gypsyk\quiz\models\renders\qone_render;

use gypsyk\quiz\models\renders\Context;

class QuestionOneRender extends \yii\base\View
{
    public $viewFilePath = 'qone_render/views/results';

    public function renderResult()
    {
        return parent::render($this->viewFilePath, [], new Context());
    }
}
