<?php

namespace gypsyk\quiz\models;

use Yii;

/**
 * This is the model class for table "quiz_question_type".
 *
 * @property integer $id
 * @property string $description
 * @property string $code
 *
 * @property QuizQuestion[] $quizQuestions
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuizQuestions()
    {
        return $this->hasMany(QuizQuestion::className(), ['type' => 'id']);
    }
}
