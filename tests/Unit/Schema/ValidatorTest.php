<?php

namespace oat\OneRoster\Tests\Schema;

use oat\OneRoster\Schema\FormatException;
use oat\OneRoster\Schema\RequiredException;
use oat\OneRoster\Schema\Validator;
use PHPUnit\Framework\TestCase;

class ValidatorTest extends TestCase
{

    /**
     * @throws \oat\OneRoster\Schema\FormatException
     * @throws \oat\OneRoster\Schema\RequiredException
     */
    public function testValidateFields()
    {
        $validator = $this->getValidator();

        $result = $validator->validate([
            'string-required' => '12345',
            'string-not-required' => '54321',
            'date-required' => '2017-05-06',
            'boolean-required' => 'TRUE',
        ]);

        $this->assertInternalType('array', $result);
    }

    /**
     * @throws \oat\OneRoster\Schema\FormatException
     * @throws \oat\OneRoster\Schema\RequiredException
     */
    public function testFormatFields()
    {
        $validator = $this->getValidator();

        $result = $validator->validate([
            'string-required' => '12345',
            'string-not-required' => '54321',
            'date-required' => '2017-05-06',
            'boolean-required' => 'TRUE',
        ]);

        $this->assertInternalType('array', $result);
        $this->assertSame('12345', $result['string-required']);
        $this->assertSame('54321', $result['string-not-required']);
        $this->assertSame('2017-05-06', $result['date-required']->format('Y-m-d'));
        $this->assertSame(true, $result['boolean-required']);
    }

    /**
     * @throws \oat\OneRoster\Schema\FormatException
     * @throws \oat\OneRoster\Schema\RequiredException
     */
    public function testRequiredFieldNotPass()
    {
        $this->expectException(RequiredException::class);
        $validator = $this->getValidator();
        $validator->validate([
            'string-not-required' => '54321',
            'date-required' => '2017-05-06',
            'boolean-required' => 'TRUE',
        ]);
    }

    /**
     * @throws \oat\OneRoster\Schema\FormatException
     * @throws \oat\OneRoster\Schema\RequiredException
     */
    public function testFormatInvalid()
    {
        $this->expectException(FormatException::class);

        $validator = $this->getValidator();
        $validator->validate([
            'string-required' => 45698,
            'date-required' => '2017-05-06',
            'boolean-required' => 'TRUE',
        ]);
    }

    protected function getValidator()
    {
        $validator = new Validator([
            [
                'columnId' => 'string-required',
                'required' => true,
                'format' => 'string',
            ],
            [
                'columnId' => 'string-not-required',
                'required' => false,
                'format' => 'string',
            ],
            [
                'columnId' => 'date-required',
                'required' => true,
                'format' => 'date',
            ],
            [
                'columnId' => 'date-not-required',
                'required' => false,
                'format' => 'date',
            ],
            [
                'columnId' => 'boolean-required',
                'required' => true,
                'format' => 'boolean',
            ],
            [
                'columnId' => 'boolean-not-required',
                'required' => false,
                'format' => 'boolean',
            ]
        ]);

        return $validator;
    }
}
