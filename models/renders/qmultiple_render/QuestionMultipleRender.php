<?php

namespace gypsyk\quiz\models\renders\qmultiple_render;

use gypsyk\quiz\models\renders\Context;

class QuestionMultipleRender extends \yii\base\View
{
    public $viewFilePath = 'qmultiple_render/views/results';
    public $question;

    public function __construct(\gypsyk\quiz\models\questions\QuestionMultiple $question)
    {
        parent::__construct();

        $this->question = $question;
    }
    
    public function renderResult()
    {
        return parent::render($this->viewFilePath, ['question' => $this->question], new Context());
    }
}
