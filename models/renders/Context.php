<?php
namespace gypsyk\quiz\models\renders;

/**
 * Context for locating the views of render object
 * 
 * Class Context
 * @package gypsyk\quiz\models\renders
 */
class Context implements \yii\base\ViewContextInterface
{
    /**
     * @inheritdoc
     */
    public function getViewPath()
    {
        return __DIR__;
    }
}