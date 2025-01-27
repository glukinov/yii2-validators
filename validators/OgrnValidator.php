<?php

namespace glukinov\validators;

use Yii;
use yii\validators\Validator;
use glukinov\traits\CheckNumericTrait;
use Exception;
use RuntimeException;

class OgrnValidator extends Validator
{
    const LENGTH = 13;
    const DIVIDER = 11;

    use CheckNumericTrait;

    /**
     * {@inheritdoc}
     */
    public function validateAttribute($model, $attribute)
    {
        try {
            $val = $this->checkNumeric($model, $attribute);
            $num = $this->checkInteger($model, $attribute, $val);
            return $this->checkReminder($model, $attribute, $val, $num);
        } catch (Exception $ex) {
            return false;
        }
    }

    /**
     * Checking the reminder of division.
     *
     * @param \yii\base\Model $model
     * @param string $attribute
     * @param string $val
     * @param int $num
     * @return bool
     * @throws RuntimeException
     */
    private function checkReminder($model, $attribute, $val, $num)
    {
        $rem = $num % static::DIVIDER;
        $str = strval($rem);
        $n1 = $str[strlen($str)-1];
        $n2 = $val[strlen($val)-1];

        if ($n1 != $n2) {
            $message = Yii::t('glukinov', 'The value of attribute "{attribute}" has invalid control digit', [
                'attribute' => $attribute,
            ]);
            $this->addError($model, $attribute, $message);
            return throw new RuntimeException($message);
        }

        return true;
    }
}
