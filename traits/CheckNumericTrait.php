<?php

namespace glukinov\traits;

use Yii;
use RuntimeException;

trait CheckNumericTrait
{
    /**
     * Checking the basics requirements for numeric values.
     *
     * @param \common\base\Model $model
     * @param string $attribute
     * @return string
     * @throws RuntimeException
     */
    protected function checkNumeric($model, $attribute)
    {
        if (!is_numeric($model->$attribute) || strlen($model->$attribute) != static::LENGTH) {
            $message = Yii::t('glukinov', 'The value of attribute "{attribute} is not {length}-digit number.', [
                'attribute' => $attribute,
                'length' => static::LENGTH,
            ]);
            $this->addError($model, $attribute, $message);
            throw new RuntimeException($message);
        }

        return $model->$attribute;
    }

    /**
     * Checking the number.
     *
     * @param \yii\base\Model $model
     * @param string $attribute
     * @param string $val
     * @return int
     * @throws RuntimeException
     */
    protected function checkInteger($model, $attribute, $val)
    {
        $num = intval(substr($val, 0, static::LENGTH - 1));
        if (!$num) {
            $message = Yii::t('glukinov', 'The value of attribute "{attribute}" is not valid number', [
                'attribute' => $attribute,
            ]);
            $this->addError($model, $attribute, $message);
            return throw new RuntimeException($message);
        }

        return $num;
    }
}
