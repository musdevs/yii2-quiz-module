<?php

namespace gypsyk\quiz\models;

use Yii;
use gypsyk\quiz\models\helpers\QuestionsTypeMapper;
use gypsyk\quiz\models\AR_QuizQuestion;

/**
 * Class Quiz
 * @package gypsyk\quiz\models
 */
class Quiz
{
    public $questions;
    public $idsMap;
    public $statistics;
    public $testId;

    /**
     * Quiz constructor.
     *
     * @param \gypsyk\quiz\models\AR_QuizQuestion[] $ar_questions
     */
    public function __construct($ar_questions, $id_map)
    {
        $this->idsMap = $id_map;
        $classMap = new QuestionsTypeMapper();

        foreach($ar_questions as $question) {
            $sessionQuestionNumber = array_search($question->getPrimaryKey(), $id_map);
            $this->questions[$sessionQuestionNumber] = Yii::createObject(
                $classMap->getQuestionClassByTypeName($question->type_q->code),
                [$question]
            );
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
            if(!$question->isUserAnswerIsCorrect()) {
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

    /**
     * Save the question to database
     *
     * @param $parameters
     * @param $test_id
     * @return mixed
     */
    public static function saveQuestionToDb($parameters, $test_id)
    {
        $qClass = (new QuestionsTypeMapper())->getQuestionClassByTypeId($parameters['question_type']);

        return forward_static_call([$qClass, 'saveToDb'], Yii::$app->request->post(), $test_id);
    }

    /**
     * Create and return question object 
     * 
     * @param $id
     * @return bool|object
     * @throws \yii\base\InvalidConfigException
     */
    public static function getQuestionObjectById($id)
    {
        $questionModel = AR_QuizQuestion::findOne($id);

        if(empty($questionModel))
            return false;

        $qClass = (new QuestionsTypeMapper())->getQuestionClassByTypeName($questionModel->getTypeCode());

        return Yii::createObject($qClass, [$questionModel]);
    }
    
    public static function renderQuestionCreate($viewObject)
    {
        $questionClassesList = QuestionsTypeMapper::getAllClasses();
        $renderResult = '';

        foreach ($questionClassesList as $questionClass) {
            $render = Yii::createObject($questionClass::getRenderClass());
            $renderResult .= $render->renderCreate($viewObject);
        }
        
        return $renderResult; 
    }
}
