<?php

namespace glukinov\validators;

use Yii;
use yii\validators\Validator;
use Exception;
use RuntimeException;

class OgrnValidator extends Validator
{
    const LENGTH = 13;
    const DIVIDER = 11;

    /**
     * {@inheritdoc}
     */
    public function validateAttribute($model, $attribute)
    {
        try {
            $val = $this->checkBasics($model, $attribute);
            $num = $this->checkNumber($model, $attribute, $val);
            return $this->checkReminder($model, $attribute, $val, $num);
        } catch (Exception $ex) {
            return false;
        }
    }

    /**
     * Checking the basics requirements.
     *
     * @param \yii\base\Model $model
     * @param string $attribute
     * @return string
     * @throws RuntimeException
     */
    protected function checkBasics($model, $attribute)
    {
        if (!is_numeric($model->$attribute) || strlen($model->$attribute) != static::LENGTH) {
            $message = Yii::t('glukinov', 'The value of attribute "{attribute}" is not {length}-digit number', [
                'attribute' => $attribute,
                'length' => static::LENGTH,
            ]);
            $this->addError($model, $attribute, $message);
            return throw new RuntimeException($message);
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
    protected function checkNumber($model, $attribute, $val)
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
