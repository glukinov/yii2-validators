<?php

namespace glukinov\tests;

use glukinov\tests\models\TestModel;
use glukinov\validators\InnValidator;

use PHPUnit\Framework\TestCase;

class InnValidatorTest extends TestCase
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
        $validator = new InnValidator();
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
        $validator = new InnValidator();
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
            ['7707083893'], // Sber bank
            ['7728168971'], // Alfa bank
            ['7710140679'], // T bank
        ];
    }

    /**
     * Provides the invalid values for testing.
     */
    public static function invalidValues()
    {
        return [
            ['0000000000'],
            ['9999999999'],
            ['AAAAAAAAAA'],
            ['0'],
        ];
    }
}
