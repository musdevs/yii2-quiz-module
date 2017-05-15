<?php
namespace gypsyk\quiz\models\questions;

use Yii;

class AbstractQuestion
{
    public $userCorrect;
    public $text;
    public $correctAnswer;
    public $userAnswer;
    
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
}