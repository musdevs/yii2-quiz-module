<?php

namespace gypsyk\quiz\models\questions;

use Yii;
use yii\helpers\Json;

//TO DO: Create an abstract class for question with common methods
class QuestionMultiple
{
    public $variants;
    public $correctAnswers;
    public $userAnswers;
    public $text;
    public $userCorrect;

    private $renderClass = '\gypsyk\quiz\models\renders\qmultiple_render\QuestionMultipleRender';
    private $renderer;

    public function __construct(\gypsyk\quiz\models\AR_QuizQuestion $ar_question)
    {
        $jCorrectAnswers = Json::decode($ar_question->r_answers, false);
        $this->correctAnswers = $jCorrectAnswers;
        $this->text = $ar_question->question;

        foreach (Json::decode($ar_question->answers, false) as $jVariant) {
            $isCorrect = in_array($jVariant->id, $jCorrectAnswers) ? true : false;
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
        $this->userAnswers = $session_answer;
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

        if($this->correctAnswers == $this->userAnswers) {
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