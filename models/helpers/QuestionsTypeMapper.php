<?php

namespace gypsyk\quiz\models\helpers;

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
        $this->map['ONE'] = '\gypsyk\quiz\models\questions\QuestionOne';
        $this->map['MULTIPLE'] = '\gypsyk\quiz\models\questions\QuestionMultiple';
        $this->map['TEXT'] = '\gypsyk\quiz\models\questions\QuestionText';
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

        return $this->map[$type_name];
    }

    /**
     * Get question class name by its codes database id
     * 
     * @param $type_id
     * @return bool
     */
    public function getQuestionClassByTypeId($type_id)
    {
        $arType = AR_QuizQuestionType::findOne($type_id);

        if(empty($arType))
            return false;

        return $this->map[$arType->code];
    }

    /**
     * Get all question classes list
     * 
     * @return array
     */
    public static function getAllClasses()
    {
        $classes = new static();

        return array_values($classes->map);
    }
}