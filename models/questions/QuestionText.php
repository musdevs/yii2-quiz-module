<?php

namespace gypsyk\quiz\models\questions;

use Yii;
use yii\helpers\Json;

class QuestionText
{
    public $correctAnswer;
    public $userAnswer;
    public $text;
    public $userCorrect;

    private $renderClass = '\gypsyk\quiz\models\renders\qtext_render\QuestionTextRender';
    private $renderer;

    public function __construct(\gypsyk\quiz\models\AR_QuizQuestion $ar_question)
    {
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

    /**
     * Get the question render object
     *
     * @return object
     * @throws \yii\base\InvalidConfigException
     */
    public function getRender()
    {
        if(empty($this->renderer)) {
            $this->renderer = Yii::createObject($this->renderClass, [$this]);
        }

        return $this->renderer;
    }
}