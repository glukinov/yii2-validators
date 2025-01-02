<?php

namespace glukinov\tests;

use glukinov\tests\models\TestModel;
use glukinov\validators\OgrnipValidator;

use PHPUnit\Framework\TestCase;

class OgrnipValidatorTest extends TestCase
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
        $validator = new OgrnipValidator();
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
        $validator = new OgrnipValidator();
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
            ['316861700133226'],
            ['314505309900027'],
            ['321244848332114'],
        ];
    }

    /**
     * Provides the invalid values for testing.
     */
    public static function invalidValues()
    {
        return [
            ['000000000000000'],
            ['999999999999999'],
            ['AAAAAAAAAAAAAAA'],
            ['0'],
        ];
    }
}
