<?php

namespace gypsyk\quiz\models;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/**
 * This is the model class for table "quiz_test".
 *
 * @property integer $id
 * @property string $name
 *
 */
class AR_QuizTest extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'quiz_test';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Тема теста',
        ];
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
//    public function getQuizQuestions()
//    {
//        return $this->hasMany(QuizQuestion::className(), ['test_id' => 'id']);
//    }
}
