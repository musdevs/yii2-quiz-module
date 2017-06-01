<?php

namespace gypsyk\quiz\models\helpers;

use yii\helpers\ArrayHelper;
use gypsyk\quiz\models\AR_QuizQuestionType;

/**
 * Class for mapping question class name and code of type 
 * 
 * Class QuestionsTypeMapper
 * @package gypsyk\quiz\models\helpers
 */
class QuestionsTypeMapper
{
    /**
     * Array to store map info
     */
    private $map;

    public function __construct()
    {
        $types = ArrayHelper::map(AR_QuizQuestionType::find()->all(),'id','code');

        $this->map['ONE'] = [
            'dbId' => array_search('ONE', $types),
            'className' => '\gypsyk\quiz\models\questions\QuestionOne'
        ];
        $this->map['MULTIPLE'] = [
            'dbId' => array_search('MULTIPLE', $types),
            'className' => '\gypsyk\quiz\models\questions\QuestionMultiple'
        ];
        $this->map['TEXT'] = [
            'dbId' => array_search('TEXT', $types),
            'className' => '\gypsyk\quiz\models\questions\QuestionText'
        ];
    }

    /**
     * Get question class name by its code name
     * 
     * @param $type_name
     * @return bool
     */
    public function getQuestionClassByTypeName($type_name)
    {
        if(!array_key_exists($type_name, $this->map))
            return false;

        return $this->map[$type_name]['className'];
    }

    /**
     * Get question class name by its codes database id
     * 
     * @param $type_id
     * @return bool
     */
    public function getQuestionClassByTypeId($type_id)
    {
        foreach($this->map as $item) {
            if($item['dbId'] == $type_id)
                return $item['className'];
        }

        return false;
    }

    /**
     * Get all question classes list
     * 
     * @return array
     */
    public static function getAllClasses()
    {
        $mapper = new static();

        $cArray = array_map(function($item) {
            return $item['className'];
        }, $mapper->map);

        return array_values($cArray);
    }

    /**
     * Return class map as [
     *  <dbId> => <className>,
     *  ...
     * ]
     * 
     * @return mixed
     */
    public static function getIdMap()
    {
        $mapper = new static();

        foreach($mapper->map as $item) {
            $rArray[$item['dbId']] = $item['className'];
        }

        return $rArray;
    }
}