<?php
namespace gypsyk\quiz\models\questions;

use Yii;
use yii\helpers\Html;

abstract class AbstractQuestion
{
    public $userCorrect;
    public $text;
    public $correctAnswer;
    public $userAnswer;
    public $jsonVariants;
    
    protected $renderClass;
    protected $renderer;

    /**
     * Get the question render object. And load question object to it.
     *
     * @return object
     * @throws \yii\base\InvalidConfigException
     */
    public function loadRender()
    {
        if(empty($this->renderer)) {
            $this->renderer = Yii::createObject($this->renderClass);
            $this->renderer->loadQuestion($this);
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

    public abstract static function getRenderClass();
}