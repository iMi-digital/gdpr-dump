<?php

declare(strict_types=1);

namespace Smile\GdprDump\Tests\Unit\Converter\Proxy;

use OverflowException;
use Smile\GdprDump\Converter\Generator\SetNull;
use Smile\GdprDump\Converter\Parameters\ValidationException;
use Smile\GdprDump\Converter\Proxy\Unique;
use Smile\GdprDump\Tests\Framework\Mock\Converter\ConverterMock;
use Smile\GdprDump\Tests\Unit\TestCase;
use stdClass;

class UniqueTest extends TestCase
{
    /**
     * Test the converter.
     */
    public function testConverter(): void
    {
        $parameters = [
            'converter' => new ConverterMock(),
        ];

        $converter = new Unique($parameters);
        $value = $converter->convert('1');
        $this->assertSame('test_1', $value);
    }

    /**
     * Test if NULL values are ignored by the converter.
     */
    public function testNullValuesIgnored(): void
    {
        $parameters = [
            'converter' => new SetNull(),
        ];

        $converter = new Unique($parameters);

        $value = $converter->convert('1');
        $this->assertNull($value);

        // Should not throw an exception, the unique converter ignores values converted to null
        $converter->convert('1');
        $converter->convert('1');
    }

    /**
     * Assert that an exception is thrown when the converter fails to generate a unique value.
     */
    public function testFailedUniqueValue(): void
    {
        $parameters = [
            'converter' => new ConverterMock(),
        ];

        $converter = new Unique($parameters);
        $converter->convert('1');
        $this->expectException(OverflowException::class);
        $converter->convert('1');
    }

    /**
     * Assert that an exception is thrown when the converter is not set.
     */
    public function testConverterNotSet(): void
    {
        $this->expectException(ValidationException::class);
        new Unique([]);
    }

    /**
     * Assert that an exception is thrown when the parameter "converter" is not an instance of ConverterInterface.
     */
    public function testConverterNotValid(): void
    {
        $this->expectException(ValidationException::class);
        new Unique(['converter' => new stdClass()]);
    }
}
