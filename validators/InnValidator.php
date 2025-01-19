<?php

namespace glukinov\validators;

use Yii;
use yii\validators\Validator;
use glukinov\traits\CheckNumericTrait;
use Exception;
use RuntimeException;

class InnValidator extends Validator
{
    const LENGTH = 10;
    const DIVIDER = 11;
    const RATIO = [2, 4, 10, 3, 5, 9, 4, 6, 8];

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
     * @param \common\base\Model $model
     * @param string $attribute
     * @param string $val
     * @param int $num
     * @return bool
     * @throws RuntimeException
     */
    protected function checkReminder($model, $attribute, $val, $num)
    {
        $sum = 0;
        $nums = substr($val, 0, static::LENGTH - 1);
        for ($i = 0; $i < strlen($nums); $i++) {
            $sum += intval($nums[$i]) * static::RATIO[$i];
        }

        if ($sum == 0) {
            $message = Yii::t('glukinov', 'The value of attribute "{attribute}" has invalid checksum', [
                'attribute' => $attribute,
            ]);
            $this->addError($model, $attribute, $message);
            return throw new RuntimeException($message);
        }

        $rem = $sum % static::DIVIDER;
        $str = strval($rem);

        if ($str[strlen($str)-1] != $val[strlen($val)-1]) {
            $message = Yii::t('glukinov', 'The value of attribute "{attribute}" has invalid checksum', [
                'attribute' => $attribute,
            ]);
            $this->addError($model, $attribute, $message);
            return throw new RuntimeException($message);
        }

        return true;
    }
}
