<?php

namespace glukinov\tests;

use glukinov\tests\models\TestModel;
use glukinov\validators\PhoneValidator;

use PHPUnit\Framework\TestCase;

class PhoneValidatorTest extends TestCase
{
    /**
     * Testing formats.
     *
     * @param string $format
     * @param string $value
     * @dataProvider validValues
     */
    public function testFormat($format, $value)
    {
        $model = new TestModel();
        $model->value = $value;
        $validator = new PhoneValidator();
        $validator->format = $format;
        $this->assertTrue($validator->validateAttribute($model, 'value'));
    }

    /**
     * Testing format errors.
     *
     * @param string $format
     * @param string $value
     * @dataProvider invalidValues
     */
    public function testFormatErrors($format, $value)
    {
        $model = new TestModel();
        $model->value = $value;
        $validator = new PhoneValidator();
        $validator->format = $format;
        $this->assertFalse($validator->validateAttribute($model, 'value'));
        $this->assertNotEmpty($model->errors);
        $this->assertArrayHasKey('value', $model->errors);
    }

    /**
     * Provides the phone formats and valid values for testing.
     *
     * @return array
     */
    public static function validValues()
    {
        return [
            [PhoneValidator::FORMAT_RU_INT, '70000000000'],
            [PhoneValidator::FORMAT_RU_LOC, '80000000000'],
        ];
    }

    /**
     * Provides the phone formats and invalid values for testing.
     *
     * @return array
     */
    public static function invalidValues()
    {
        return [
            [PhoneValidator::FORMAT_RU_INT, '00000000000'],
            [PhoneValidator::FORMAT_RU_LOC, '00000000000'],
        ];
    }
}
