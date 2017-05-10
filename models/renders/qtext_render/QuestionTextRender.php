<?php
namespace gypsyk\quiz\models\renders\qtext_render;

use gypsyk\quiz\models\renders\Context;

class QuestionTextRender extends \yii\base\View
{
    public $viewFilePath = 'qtext_render/views/';
    public $question;

    public function __construct(\gypsyk\quiz\models\questions\QuestionText $question)
    {
        parent::__construct();

        $this->question = $question;
    }

    public function renderResult()
    {
        return parent::render($this->viewFilePath . 'result', ['question' => $this->question], new Context());
    }
}