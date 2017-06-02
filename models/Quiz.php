<?php

namespace gypsyk\quiz\models;

use Yii;
use gypsyk\quiz\models\AR_QuizQuestion;
use gypsyk\quiz\models\helpers\QuestionsTypeMapper;


/**
 * Class for working with test data
 *
 * Class Quiz
 * @package gypsyk\quiz\models
 */
class Quiz
{
    /**
     * @var array - Array of instances \gypsyk\quiz\models\questions\*
     */
    public $questions;

    /**
     * @var array - Array for mapping question numbers. Example: [1 => 43, 2 => 46, ... {counter} => {db_id}]
     */
    public $idsMap;

    /**
     * @var array - Keeps statistic info. Array keys are: maxPoints, points, rightAnswersCount, wrongAnswersCount
     */
    public $statistics;

    /**
     * @var integer - Test id from database
     */
    public $testId;

    /**
     * Quiz constructor.
     * @param $ar_questions array
     * @param $id_map array
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
     * Load user answers
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

        return forward_static_call([$qClass, 'saveToDb'], $parameters, $test_id);
    }

    /**
     * Update question in database
     * 
     * @param $parameters
     * @param $question_id
     * @return mixed
     */
    public static function updateQuestionInDb($parameters, $question_id)
    {
        $qClass = (new QuestionsTypeMapper())->getQuestionClassByTypeId($parameters['question_type']);

        return forward_static_call([$qClass, 'updateInDb'], $parameters, $question_id);
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

    /**
     * Return the render part contains question create form
     * 
     * @param $viewObject
     * @return string
     * @throws \yii\base\InvalidConfigException
     */
    public static function renderQuestionCreate($viewObject)
    {
        $questionClassesList = QuestionsTypeMapper::getIdMap();
        $renderResult = '';

        foreach ($questionClassesList as $qDbId => $qClassName) {
            $render = Yii::createObject($qClassName::getRenderClass());
            $renderResult .= $render->renderCreate($viewObject, $qDbId);
        }
        
        return $renderResult; 
    }

    public static function renderQuestionEdit($viewObject, $currentQuestionType, $variants, $answers)
    {
        $questionClassesList = QuestionsTypeMapper::getIdMap();
        $renderResult = '';

        foreach ($questionClassesList as $qDbId => $qClassName) {
            $render = Yii::createObject($qClassName::getRenderClass());

            //Mark as active and load data to view
            if($currentQuestionType == $qDbId) {
                $renderResult .= $render->renderEdit(
                    $viewObject,
                    $qDbId,
                    true,
                    $variants,
                    $answers
                );
            } else { //Load view without data
                $renderResult .= $render->renderCreate($viewObject, $qDbId);
            }

        }

        return $renderResult;
    }
}
