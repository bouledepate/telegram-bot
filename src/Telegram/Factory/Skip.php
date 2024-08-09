<?php

declare(strict_types=1);

namespace BDP\Telegram\Factory;

use Attribute;

/**
 * Attribute is used to mark properties that should be ignored when building an object in TypeFactory.
 *
 * Example usage:
 *```
 * #[Skip]
 * private string $ignoredProperty;
 * ```
 */
#[Attribute(Attribute::TARGET_PROPERTY)]
final readonly class Skip
{
}