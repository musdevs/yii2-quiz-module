<?php

namespace gypsyk\quiz\models\questions;

use Yii;
use yii\helpers\Json;

class QuestionOne
{
    public $variants;
    public $correctAnswer;
    public $userAnswer;
    
    private $renderClass = '\gypsyk\quiz\models\renders\qone_render\QuestionOneRender';
    private $renderer;
    
    public function __construct(\gypsyk\quiz\models\AR_QuizQuestion $ar_question)
    {
        $jCorrectAnswer = Json::decode($ar_question->r_answers, false);
        $this->correctAnswer = $jCorrectAnswer;
        
        foreach (Json::decode($ar_question->answers, false) as $jVariant) {
            $isCorrect = ($jCorrectAnswer == $jVariant->id) ? true : false; 
            $this->variants[$jVariant->id] = [
                'text' => $jVariant->text, 
                'is_correct' => $isCorrect,
                'is_user_checked' => false
            ];
        }    
    }

    /**
     * Пометить сделанный пользователем ответ
     * 
     * @param string $session_answer
     */
    public function loadUserAnswer(string $session_answer)
    {
        $this->variants[$session_answer]['is_user_checked'] = true;
        $this->userAnswer = $session_answer;
    }

    /**
     * Проверка правльности ответа на вопрос
     *
     * @return bool
     */
    public function isUserAnswerIsCorrect()
    {
        if($this->correctAnswer == $this->userAnswer)
            return true;

        return false;
    }

    /**
     * Get the question render object
     * 
     * @return object
     * @throws \yii\base\InvalidConfigException
     */
    public function getRender()
    {
        if(empty($this->renderer)) {
            $this->renderer = Yii::createObject($this->renderClass); 
        } 
        
        return $this->renderer;
    }
}