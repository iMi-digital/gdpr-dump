<?php
declare(strict_types=1);

namespace Smile\GdprDump\Converter\Setter;

use Smile\GdprDump\Converter\ConverterInterface;

class SetSuffix implements ConverterInterface
{
    /**
     * @var string
     */
    private $suffix;

    /**
     * @param array $parameters
     */
    public function __construct(array $parameters = [])
    {
        if (!array_key_exists('suffix', $parameters)) {
            throw new \InvalidArgumentException('The setSuffix converter requires a "suffix" parameter.');
        }

        $this->suffix = $parameters['suffix'];
    }

    /**
     * @inheritdoc
     */
    public function convert($value, array $context = [])
    {
        return $value . $this->suffix;
    }
}
