<?php

namespace gypsyk\quiz\models\renders\qmultiple_render;

use gypsyk\quiz\models\renders\Context;

class QuestionMultipleRender extends \yii\base\View
{
    public $viewFilePath = 'qmultiple_render/views/results';

    public function renderResult()
    {
        return parent::render($this->viewFilePath, [], new Context());
    }
}
