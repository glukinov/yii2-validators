<?php

namespace glukinov\validators;

use Yii;
use yii\validators\Validator;
use InvalidArgumentException;

class PhoneValidator extends Validator
{
    const FORMAT_RU_INT = 1; // 7XXXXXXXXXX
    const FORMAT_RU_LOC = 2; // 8XXXXXXXXXX

    /**
     * The format of the phone number.
     *
     * @var string
     */
    public $format;

    /**
     * {@inheritdoc}
     */
    public function validateAttribute($model, $attribute)
    {
        $patterns = $this->patterns();
        if (!isset($patterns[$this->format])) {
            $message = Yii::t('glukinov', 'Incorrect format is specified for the attribute "{attribute}"', [
                'attribute' => $attribute,
            ]);
            throw new InvalidArgumentException($message);
        }

        $value = $model->$attribute;
        $pattern = $patterns[$this->format];
        if (preg_match($pattern, $value) == false) {
            $message = Yii::t('glukinov', 'The value of attribute "{attribute}" does not match the specified format', [
                'attribute' => $attribute,
            ]);
            $this->addError($model, $attribute, $message);
            return false;
        }

        return true;
    }

    /**
     * Provides the patterns for phone formats.
     *
     * @return array
     */
    protected function patterns()
    {
        return [
            self::FORMAT_RU_INT => '/^7\\d{10}$/',
            self::FORMAT_RU_LOC => '/^8\\d{10}$/',
        ];
    }
}
