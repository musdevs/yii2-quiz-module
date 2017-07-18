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
     * @var \gypsyk\quiz\models\questions\QuestionInterface[] - Array of questions
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
     * @param $container \yii\di\Container
     */
    public function __construct($ar_questions, $id_map, $container)
    {
        $this->idsMap = $id_map;

        foreach($ar_questions as $question) {
            $questionDbId = $question->getPrimaryKey();
            $sessionQuestionNumber = array_search($questionDbId, $id_map);
            $this->questions[$sessionQuestionNumber] = $container->get('Question', [$questionDbId]);
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
     * @param $container \yii\di\Container
     * @return mixed
     */
    public static function saveQuestionToDb($parameters, $test_id, $container)
    {
        $qClass = $container->get('Mapper')->getQuestionClassByTypeId($parameters['question_type']);

        return forward_static_call([$qClass, 'saveToDb'], $parameters, $test_id);
    }

    /**
     * Update question in database
     *
     * @param $parameters
     * @param $question_id
     * @param $container \yii\di\Container
     * @return mixed
     */
    public static function updateQuestionInDb($parameters, $question_id, $container)
    {
        $qClass = $container->get('Mapper')->getQuestionClassByTypeId($parameters['question_type']);

        return forward_static_call([$qClass, 'updateInDb'], $parameters, $question_id);
    }

    /**
     * Return the render part contains question create forms
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
