<?php

namespace gypsyk\quiz\models\questions;

use Yii;
use yii\helpers\Json;
use gypsyk\quiz\models\questions\AbstractQuestion;

class QuestionMultiple extends AbstractQuestion
{
    public $variants;

    public function __construct(\gypsyk\quiz\models\AR_QuizQuestion $ar_question)
    {
        $this->renderClass = '\gypsyk\quiz\models\renders\qmultiple_render\QuestionMultipleRender'; 
        $jcorrectAnswer = Json::decode($ar_question->r_answers, false);
        $this->correctAnswer = $jcorrectAnswer;
        $this->text = $ar_question->question;

        foreach (Json::decode($ar_question->answers, false) as $jVariant) {
            $isCorrect = in_array($jVariant->id, $jcorrectAnswer) ? true : false;
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
     * @param array $session_answer
     */
    public function loadUserAnswer(array $session_answer)
    {
        foreach ($session_answer as $answer) {
            $this->variants[$answer]['is_user_checked'] = true;    
        }
        $this->userAnswer = $session_answer;
    }

    /**
     * Проверка правльности ответа на вопрос
     *
     * @return bool
     */
    public function isUserAnswerIsCorrect()
    {
        if(!empty($this->userCorrect))
            return $this->userCorrect;

        if($this->correctAnswer == $this->userAnswer) {
            $this->userCorrect = true;
            return true;
        }

        $this->userCorrect = false;
        return false;
    }
}