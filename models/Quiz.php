<?php

namespace gypsyk\quiz\models;

use Yii;

class Quiz
{
    public $questions;
    public $idsMap;
    public $statistics;    

    protected $classQuestionOne = '\gypsyk\quiz\models\questions\QuestionOne';
    protected $classQuestionMultiple = '\gypsyk\quiz\models\questions\QuestionMultiple';
    protected $classQuestionText = '\gypsyk\quiz\models\questions\QuestionText';

    /**
     * Quiz constructor.
     *
     * @param \gypsyk\quiz\models\AR_QuizQuestion[] $ar_questions
     */
    public function __construct($ar_questions, $id_map)
    {
        $this->idsMap = $id_map;
        foreach($ar_questions as $question) {

            if($question->type_q->code == constant(get_class($question) . '::'. 'TYPE_ONE')) {
                $this->questions[array_search($question->getPrimaryKey(), $id_map)] = Yii::createObject($this->classQuestionOne, [$question]);
            }

            if($question->type_q->code == constant(get_class($question) . '::'. 'TYPE_MULTIPLE')) {
                $this->questions[array_search($question->getPrimaryKey(), $id_map)] = Yii::createObject($this->classQuestionMultiple, [$question]);
            }

            if($question->type_q->code == constant(get_class($question) . '::'. 'TYPE_TEXT')) {
                $this->questions[array_search($question->getPrimaryKey(), $id_map)] = Yii::createObject($this->classQuestionText, [$question]);
            }
        }
    }

    /**
     * Загрузить ответы пользователя
     * 
     * @param $session_answers
     */
    public function loadUserAnswers($session_answers)
    {
        foreach ($session_answers as $key => $value) {
           $this->questions[$key]->loadUserAnswer($value);
        }
    }

    /**
     * Check all user answers
     * 
     * @return mixed
     */
    public function checkAnswers()
    {
        $maxPoints = count($this->questions);
        $points = $maxPoints;
        $rightAnswersCount = 0;
        $wrongAnswersCount = 0;

        foreach ($this->questions as $question) {
            if($question->isUserAnswerIsCorrect()) {
                $wrongAnswersCount++;
                $points--;
            } else {
                $rightAnswersCount++;
            }
        }
        
        $this->statistics['maxPoints'] = $maxPoints;
        $this->statistics['points'] = $points;
        $this->statistics['rightAnswersCount'] = $rightAnswersCount;
        $this->statistics['wrongAnswersCount'] = $wrongAnswersCount;
    }
}
