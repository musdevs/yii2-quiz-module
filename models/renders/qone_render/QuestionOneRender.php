<?php
namespace gypsyk\quiz\models\renders\qone_render;

use gypsyk\quiz\models\renders\Context;

class QuestionOneRender extends \yii\base\View
{
    public $viewFilePath = 'qone_render/views/results';
    public $question;

    public function __construct(\gypsyk\quiz\models\questions\QuestionOne $question)
    {
        parent::__construct();
        
        $this->question = $question;
    }

    public function renderResult()
    {
        return parent::render($this->viewFilePath, ['question' => $this->question], new Context());
    }
}
