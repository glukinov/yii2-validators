<?php

namespace glukinov\tests;

use glukinov\tests\models\TestModel;
use glukinov\validators\OgrnValidator;

use PHPUnit\Framework\TestCase;

class OgrnValidatorTest extends TestCase
{
    /**
     * Testing validation.
     *
     * @param string $value
     * @dataProvider validValues
     */
    public function testValidation($value)
    {
        $model = new TestModel();
        $model->value = $value;
        $validator = new OgrnValidator();
        $this->assertTrue($validator->validateAttribute($model, 'value'));
    }

    /**
     * Testing errors.
     *
     * @param string $value
     * @dataProvider invalidValues
     */
    public function testErrors($value)
    {
        $model = new TestModel();
        $model->value = $value;
        $validator = new OgrnValidator();
        $this->assertFalse($validator->validateAttribute($model, 'value'));
        $this->assertNotEmpty($model->errors);
        $this->assertArrayHasKey('value', $model->errors);
    }

    /**
     * Provides the valid values for testing.
     */
    public static function validValues()
    {
        return [
            ['1027700132195'], // Sber bank
            ['1027700067328'], // Alfa bank
            ['1027739642281'], // T bank
        ];
    }

    /**
     * Provides the invalid values for testing.
     */
    public static function invalidValues()
    {
        return [
            ['0000000000000'],
            ['9999999999999'],
            ['AAAAAAAAAAAAA'],
            ['0'],
        ];
    }
}
