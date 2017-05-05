<?php

namespace gypsyk\quiz\models\questions;

use Yii;
use yii\helpers\Json;

class QuestionText
{
    public $correctAnswer;
    public $userAnswer;

    private $renderClass = '\gypsyk\quiz\models\renders\qtext_render\QuestionTextRender';
    private $renderer;

    public function __construct(\gypsyk\quiz\models\AR_QuizQuestion $ar_question)
    {
        $jCorrectAnswers = Json::decode($ar_question->answers, false)[0];
        $this->correctAnswer = $jCorrectAnswers->text;
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
        if(trim(mb_strtolower($this->correctAnswer)) == trim(mb_strtolower($this->userAnswer)))
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