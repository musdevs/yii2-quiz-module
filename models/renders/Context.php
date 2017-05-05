<?php
namespace gypsyk\quiz\models\renders;

class Context implements \yii\base\ViewContextInterface
{
    public function getViewPath()
    {
        return __DIR__;
    }
}