<?php

declare(strict_types = 1);

/**
 * This file is part of the 'Yasumi' package.
 *
 * The easy PHP Library for calculating holidays.
 *
 * Copyright (c) 2015 - 2025 AzuyaLabs
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Sacha Telgenhof <me at sachatelgenhof dot com>
 */

namespace Yasumi\Exception;

/**
 * Class ProviderNotFoundException.
 *
 * @author Quentin Neyrat <quentin.neyrat@gmail.com>
 */
class ProviderNotFoundException extends \InvalidArgumentException implements Exception
{
}
