<?php
namespace gypsyk\quiz\models\questions;

use Yii;
use yii\helpers\Html;

class AbstractQuestion
{
    public $userCorrect;
    public $text;
    public $correctAnswer;
    public $userAnswer;
    public $jsonVariants;
    
    protected $renderClass;
    protected $renderer;

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

    /**
     * Get the text of the question
     * 
     * @return string
     */
    public function getQuestionText()
    {
        return Html::encode($this->text);
    }
}