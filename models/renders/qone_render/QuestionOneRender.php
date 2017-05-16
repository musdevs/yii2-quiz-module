<?php
namespace gypsyk\quiz\models\renders\qone_render;

use gypsyk\quiz\models\renders\Context;

class QuestionOneRender extends \yii\base\View
{
    public $viewFilePath = 'qone_render/views/';
    public $question;

    public function __construct(\gypsyk\quiz\models\questions\QuestionOne $question)
    {
        parent::__construct();
        
        $this->question = $question;
    }

    public function renderResult()
    {
        return parent::render($this->viewFilePath . 'results', ['question' => $this->question], new Context());
    }
    
    public function renderCreate()
    {
        return parent::render($this->viewFilePath . 'create', [], new Context());
    }

    /**
     * Render the view part of question on quiz page
     *
     * @param $answers[] obj - json decoded variants of answers from `quiz_question`.`answers`
     * @return string
     */
    public function renderTesting($answers)
    {
        return parent::render($this->viewFilePath . 'testing', ['answers' => $answers], new Context());
    }
}
