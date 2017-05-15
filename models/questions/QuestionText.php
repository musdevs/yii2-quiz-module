<?php

namespace gypsyk\quiz\models\questions;

use Yii;
use yii\helpers\Json;
use gypsyk\quiz\models\questions\AbstractQuestion;

class QuestionText extends AbstractQuestion
{
    public function __construct(\gypsyk\quiz\models\AR_QuizQuestion $ar_question)
    {
        $this->renderClass = '\gypsyk\quiz\models\renders\qtext_render\QuestionTextRender'; 
        $jCorrectAnswers = Json::decode($ar_question->answers, false)[0];
        $this->correctAnswer = $jCorrectAnswers->text;
        $this->text = $ar_question->question;
    }

    /**
     * Загрузить сделанный пользователем ответ
     *
     * @param string $session_answer
     */
    public function loadUserAnswer(string $session_answer)
    {
        $this->userAnswer = $session_answer;
    }

    /**
     * Проверка правильности ответа на вопрос
     *
     * @return bool
     */
    public function isUserAnswerIsCorrect()
    {
        if(!empty($this->userCorrect))
            return $this->userCorrect;
        
        if(trim(mb_strtolower($this->correctAnswer)) == trim(mb_strtolower($this->userAnswer))) {
            $this->userCorrect = true;
            return true;
        }

        $this->userCorrect = false;
        return false;
    }


}