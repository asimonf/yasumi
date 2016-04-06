<?php
/**
 *  This file is part of the Yasumi package.
 *
 *  Copyright (c) 2015 - 2016 AzuyaLabs
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 *
 *  @author Sacha Telgenhof <stelgenhof@gmail.com>
 */

namespace Yasumi\Provider;

use DateTime;
use DateTimeZone;
use Yasumi\Holiday;

/**
 * Provider for all holidays in Sweden.
 */
class Sweden extends AbstractProvider
{
    use CommonHolidays, ChristianHolidays;

    /**
     * Initialize holidays for Sweden.
     */
    public function initialize()
    {
        $this->timezone = 'Europe/Stockholm';

        // Add common holidays
        $this->addHoliday($this->newYearsDay($this->year, $this->timezone, $this->locale));
        $this->addHoliday($this->internationalWorkersDay($this->year, $this->timezone, $this->locale));

        // Add common Christian holidays (common in Sweden)
        $this->addHoliday($this->epiphany($this->year, $this->timezone, $this->locale));
        $this->addHoliday($this->goodFriday($this->year, $this->timezone, $this->locale));
        $this->addHoliday($this->easter($this->year, $this->timezone, $this->locale));
        $this->addHoliday($this->easterMonday($this->year, $this->timezone, $this->locale));
        $this->addHoliday($this->ascensionDay($this->year, $this->timezone, $this->locale));
        $this->addHoliday($this->pentecost($this->year, $this->timezone, $this->locale));
        $this->addHoliday($this->stJohnsDay($this->year, $this->timezone, $this->locale));
        $this->addHoliday($this->allSaintsDay($this->year, $this->timezone, $this->locale));
        $this->addHoliday($this->christmasEve($this->year, $this->timezone, $this->locale, Holiday::TYPE_NATIONAL));
        $this->addHoliday($this->christmasDay($this->year, $this->timezone, $this->locale));
        $this->addHoliday($this->secondChristmasDay($this->year, $this->timezone, $this->locale));

        // Calculate other holidays
        $this->calculateNationalDay();
    }

    /*
     * National Day
     *
     * National Day of Sweden (Sveriges nationaldag) is a national holiday observed in Sweden on 6 June every year.
     * Prior to 1983, the day was celebrated as Svenska flaggans dag (Swedish flag day). At that time, the day was
     * renamed to the national day by the Riksdag. The tradition of celebrating this date began 1916 at the Stockholm
     * Olympic Stadium, in honour of the election of King Gustav Vasa in 1523, as this was considered the foundation of
     * modern Sweden.
     */
    public function calculateNationalDay()
    {
        // Prior to 1983, the day was celebrated as Svenska flaggans dag
        if ($this->year >= 1916 and $this->year < 1983) {
            $this->addHoliday(new Holiday('nationalDay', ['sv_SE' => 'Svenska flaggans dag'],
                new DateTime("$this->year-6-6", new DateTimeZone($this->timezone)), $this->locale));
        }

        // Since 1983 this day was named 'Sveriges nationaldag'
        if ($this->year >= 1983) {
            $this->addHoliday(new Holiday('nationalDay', ['sv_SE' => 'Sveriges nationaldag'],
                new DateTime("$this->year-6-6", new DateTimeZone($this->timezone)), $this->locale));
        }
    }
}