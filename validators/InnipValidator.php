<?php

namespace glukinov\validators;

use glukinov\traits\CheckNumericTrait;
use Exception;

class InnipValidator extends InnValidator
{
    const LENGTH = 12;
    const RATIO = [7, 2, 4, 10, 3, 5, 9, 4, 6, 8];
    const RATIO2 = [3, 7, 2, 4, 10, 3, 5, 9, 4, 6, 8];

    use CheckNumericTrait;

    /**
     * {@inheritdoc}
     */
    public function validateAttribute($model, $attribute)
    {
        try {
            $val = $this->checkNumeric($model, $attribute);
            $num = $this->checkInteger($model, $attribute, $val);
            return $this->checkReminder($model, $attribute, $val, $num, static::LENGTH - 2, static::RATIO)
                && $this->checkReminder($model, $attribute, $val, $num, static::LENGTH - 1, static::RATIO2);
        } catch (Exception $ex) {
            return false;
        }
    }
}
