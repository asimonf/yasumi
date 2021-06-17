<?php

declare(strict_types=1);
/*
 * This file is part of the Yasumi package.
 *
 * Copyright (c) 2015 - 2021 AzuyaLabs
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Sacha Telgenhof <me@sachatelgenhof.com>
 */

namespace Yasumi\Provider;

use DateInterval;
use DateTime;
use DateTimeInterface;
use Exception;
use function in_array;
use Yasumi\Holiday;

/**
 * Provider for all holidays in Chile.
 *
 * @author Alberto Simón Francés <alberto@simon.ph>
 */
class Chile extends AbstractProvider
{
    use CommonHolidays;
    use ChristianHolidays;

    /**
     * Code to identify this Holiday Provider. Typically this is the ISO3166 code corresponding to the respective
     * country or sub-region.
     */
    public const ID = 'CL';

    /**
     * Initialize country holidays.
     *
     * @throws Exception
     */
    public function initialize(): void
    {
        $this->timezone = 'America/Santiago';

        $this->calculateNewYearsDay();
        $this->calculateGoodFriday();
        $this->calculateHolySaturday();
        $this->calculateLaborDay();
        $this->calculateNavyDay();
        $this->calculateCorpusChristi();
        $this->calculateOurLadyOfMountCarmelDay();
        $this->calculateStPeterAndStPaul();
        $this->calculateAssumptionOfMary();
        $this->calculateIndependenceHolidays();
        $this->calculateColumbusDay();
        $this->calculateAllSaintsDay();
        $this->calculateImmaculateConception();
        $this->calculateChristmasDay();
        $this->calculateBankHoliday();
    }

    public function getSources(): array
    {
        return [
            'https://feriados.cl/leyes.htm',
        ];
    }

    /**
     * All Sundays are considered a holiday as per Ley 2977.
     */
    public function isHoliday(DateTimeInterface $date): bool
    {
        if (7 == $date->format('N')) {
            return true;
        }

        return parent::isHoliday($date);
    }

    /**
     * Instated by Ley 2977.
     *
     * @throws Exception
     */
    private function calculateNewYearsDay(): void
    {
        if ($this->year > 1915) {
            $holiday = $this->newYearsDay($this->year, $this->timezone, $this->locale);
            if ($this->year >= 2017) {
                $holiday->add(new DateInterval('P1D'));
            }

            $this->addHoliday($holiday);
        }
    }

    /**
     * Instated by Ley 2.977 and suspended by Ley 16.840.
     *
     * @throws Exception
     */
    private function calculateCorpusChristi(): void
    {
        if ($this->year >= 1915 && $this->year < 1968) {
            $this->addHoliday(
                $this->corpusChristi($this->year, $this->timezone, $this->locale, Holiday::TYPE_OFFICIAL)
            );
        }
    }

    /**
     * Instated by Ley 2.977, suspended by Ley 16.840 and reinstated by Ley 18.432. Ley 19.668 moves the holiday.
     *
     * @throws Exception
     */
    private function calculateStPeterAndStPaul(): void
    {
        $year = $this->year;

        if ($year >= 1915 && ($year < 1968 || ($year > 1985 && $year < 2000))) {
            $this->addHoliday(new Holiday(
                'stPeterAndStPaul',
                ['es_CL' => 'San Pedro y San Pablo', 'en_US' => 'St. Peter and St. Paul'],
                new DateTime("$this->year-06-29", DateTimeZoneFactory::getDateTimeZone($this->timezone)),
                $this->locale
            ));
        } elseif ($year >= 2000) {
            $date = new DateTime("$this->year-06-29", DateTimeZoneFactory::getDateTimeZone($this->timezone));
            $this->modifyAccordingToLey19668($date);

            $this->addHoliday(new Holiday(
                'stPeterAndStPaul',
                ['es_CL' => 'San Pedro y San Pablo', 'en_US' => 'St. Peter and St. Paul'],
                $date,
                $this->locale
            ));
        }
    }

    /**
     * Instated by Ley 3810 and modified by Ley 19668.
     *
     * @throws Exception
     */
    private function calculateColumbusDay(): void
    {
        if ($this->year > 1921) {
            $date = new DateTime("$this->year-10-12", DateTimeZoneFactory::getDateTimeZone($this->timezone));
            if ($this->year >= 2000) {
                $this->modifyAccordingToLey19668($date);
            }

            $this->addHoliday(new Holiday(
                'columbusDay',
                ['es_CL' => 'Descubrimiento de América', 'en_US' => 'Columbus Day'],
                $date,
                $this->locale
            ));
        }
    }

    /**
     * @throws Exception
     */
    private function calculateLaborDay(): void
    {
        if ($this->year >= 1932) {
            $name = $this->year < 1982 ?
                'Día de la Fiesta del Trabajo' :
                'Día Nacional del Trabajo';

            $this->addHoliday(new Holiday(
                'laborDay',
                ['es_CL' => $name, 'en_US' => 'Labor day'],
                new DateTime("$this->year-06-29", DateTimeZoneFactory::getDateTimeZone($this->timezone)),
                $this->locale
            ));
        }
    }

    /**
     * Instated by Ley 2977.
     *
     * @throws Exception
     */
    private function calculateOurLadyOfMountCarmelDay(): void
    {
        if ($this->year >= 2007) {
            $this->addHoliday(new Holiday(
                'laborDay',
                ['es_CL' => 'Día de la Virgen del Carmen', 'en_US' => 'Our Lady of Mount Carmel'],
                new DateTime("$this->year-07-16", DateTimeZoneFactory::getDateTimeZone($this->timezone)),
                $this->locale
            ));
        }
    }

    /**
     * @throws Exception
     */
    private function calculateIndependenceHolidays(): void
    {
        if ($this->year > 1915) {
            $timezone = DateTimeZoneFactory::getDateTimeZone($this->timezone);

            $independenceDate = new DateTime("$this->year-09-18", $timezone);
            $weekDay = $independenceDate->format('N');

            $this->addHoliday(new Holiday(
                'independenceDay',
                ['es_CL' => 'Independencia Nacional', 'en_US' => 'Independence Day'],
                $independenceDate,
                $this->locale
            ));

            $this->addHoliday(new Holiday(
                'armyDay',
                ['es_CL' => 'Día de las Glorias del Ejército', 'en_US' => 'Army Day'],
                new DateTime("$this->year-09-19", $timezone),
                $this->locale
            ));

            // Ley 20.215 declares the 17th or the 20th as holidays depending on which day of the week the 18th falls
            if ($this->year >= 2007 && in_array($weekDay, [2, 3])) {
                $day = 2 == $weekDay ? 17 : 20;

                $this->addHoliday(new Holiday(
                    'nationalDay',
                    ['es_CL' => 'Fiestas Patrias', 'en_US' => 'National Day'],
                    new DateTime("$this->year-09-$day", $timezone),
                    $this->locale
                ));
            } elseif ($this->year >= 2017 && 6 == $weekDay) { // Declared by Ley 20.983
                $this->addHoliday(new Holiday(
                    'nationalDay',
                    ['es_CL' => 'Fiestas Patrias', 'en_US' => 'National Day'],
                    new DateTime("$this->year-09-17", $timezone),
                    $this->locale
                ));
            }
        }
    }

    /**
     * @throws Exception
     */
    private function calculateGoodFriday(): void
    {
        if ($this->year >= 1915) {
            $this->addHoliday($this->goodFriday($this->year, $this->timezone, $this->locale));
        }
    }

    /**
     * @throws Exception
     */
    private function calculateHolySaturday(): void
    {
        if ($this->year >= 1915) {
            $this->addHoliday($this->holySaturday($this->year, $this->timezone, $this->locale));
        }
    }

    /**
     * @throws Exception
     */
    private function calculateAssumptionOfMary(): void
    {
        if ($this->year >= 1915) {
            $this->addHoliday($this->assumptionOfMary($this->year, $this->timezone, $this->locale));
        }
    }

    /**
     * @throws Exception
     */
    private function calculateAllSaintsDay(): void
    {
        if ($this->year >= 1915) {
            $this->addHoliday($this->allSaintsDay($this->year, $this->timezone, $this->locale));
        }
    }

    /**
     * @throws Exception
     */
    private function calculateImmaculateConception(): void
    {
        if ($this->year >= 1915) {
            $this->addHoliday($this->immaculateConception($this->year, $this->timezone, $this->locale));
        }
    }

    /**
     * @throws Exception
     */
    private function calculateChristmasDay(): void
    {
        if ($this->year >= 1915) {
            $this->addHoliday($this->christmasDay($this->year, $this->timezone, $this->locale));
        }
    }

    /**
     * @throws Exception
     */
    private function calculateNavyDay(): void
    {
        if ($this->year >= 1915) {
            $this->addHoliday(new Holiday(
                'navyDay',
                ['es_CL' => 'Día de las Glorias Navales', 'en_US' => 'Navy Day'],
                new DateTime("$this->year-05-21", DateTimeZoneFactory::getDateTimeZone($this->timezone)),
                $this->locale
            ));
        }
    }

    /**
     * Instated by Ley General de Bancos.
     *
     * @throws Exception
     */
    private function calculateBankHoliday()
    {
        if ($this->year >= 1997) {
            $this->addHoliday(new Holiday(
                'bankHoliday',
                ['es_CL' => 'Feriado Bancario', 'en_US' => 'Bank Holiday'],
                new DateTime("$this->year-12-31", DateTimeZoneFactory::getDateTimeZone($this->timezone)),
                $this->locale,
                Holiday::TYPE_BANK
            ));
        }
    }

    // Helpers

    private function modifyAccordingToLey19668(DateTime $date): void
    {
        if (in_array($date->format('N'), [2, 3, 4])) {
            // If the day is a Tuesday, Wednesday or Thursday, it must be moved to the Monday of the same week
            $date->modify('previous monday');
        } elseif (5 == $date->format('N')) {
            // If the day is a Friday, it must be moved to the next Monday
            $date->modify('next monday');
        }
    }
}
