<?php

namespace gypsyk\quiz\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "quiz_question_type".
 *
 * @property integer $id
 * @property string $description
 * @property string $code
 *
 */
class AR_QuizQuestionType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'quiz_question_type';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['description', 'code'], 'required'],
            [['description', 'code'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'description' => 'Description',
            'code' => 'Code',
        ];
    }
}
