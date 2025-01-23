<?php

namespace glukinov\tests;

use glukinov\tests\models\TestModel;
use glukinov\validators\InnipValidator;

use PHPUnit\Framework\TestCase;

class InnipValidatorTest extends TestCase
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
        $validator = new InnipValidator();
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
        $validator = new InnipValidator();
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
            ['772331755151'],
            ['132808730606'],
            ['616608929424'],
        ];
    }

    /**
     * Provides the invalid values for testing.
     */
    public static function invalidValues()
    {
        return [
            ['000000000000'],
            ['999999999999'],
            ['AAAAAAAAAAAA'],
            ['0'],
        ];
    }
}
