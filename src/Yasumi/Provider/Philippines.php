<?php
/**
 * This file is part of the Yasumi package.
 *
 * Copyright (c) 2015 - 2019 AzuyaLabs
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Sacha Telgenhof <me@sachatelgenhof.com>
 * @author Angelo Joseph Salvador <angelo8828@gmail.com>
 */

namespace Yasumi\Provider;

use DateInterval;
use DateTime;
use DateTimeZone;
use Yasumi\Holiday;

/**
 * Provider for all holidays in the Philippines.
 */
class Philippines extends AbstractProvider
{
    use CommonHolidays, ChristianHolidays;

    /**
     * Code to identify this Holiday Provider. Typically this is the ISO3166 code corresponding to the respective
     * country or sub-region.
     */
    public const ID = 'PH';

    /**
     * Initialize holidays for the Philippines.
     *
     * @throws \Yasumi\Exception\InvalidDateException
     * @throws \InvalidArgumentException
     * @throws \Yasumi\Exception\UnknownLocaleException
     * @throws \Exception
     */
    public function initialize(): void
    {
        $this->timezone = 'Asia/Manila';

        // Add common holidays
        $this->addHoliday($this->newYearsDay($this->year, $this->timezone, $this->locale));
        $this->addHoliday($this->internationalWorkersDay($this->year, $this->timezone, $this->locale));

        // Add Christian holidays
        $this->addHoliday($this->maundyThursday($this->year, $this->timezone, $this->locale));
        $this->addHoliday($this->goodFriday($this->year, $this->timezone, $this->locale));
        $this->addHoliday($this->allSaintsDay($this->year, $this->timezone, $this->locale));
        $this->addHoliday($this->christmasEve($this->year, $this->timezone, $this->locale));
        $this->addHoliday($this->christmasDay($this->year, $this->timezone, $this->locale));

        // Calculate other holidays
        $this->calculateValorDay();
        $this->calculateIndependenceDay();
        $this->calculateNationalHeroesDay();
        $this->calculateAllSoulsDay();
        $this->calculateBonifacioDay();
        $this->calculateRizalDay();
    }

    /**
     * Valor Day
     *
     * Araw ng Kagitingan (Filipino for Day of Valor), also known as Bataan Day or Bataan and Corregidor Day,
     * is a national observance in the Philippines which commemorates the fall of Bataan during World War II.
     * It falls on April 9, although in 2009 it would have coincided with Maundy Thursday and its celebration
     * for 2009 was moved to April 6.
     *
     * @link https://en.wikipedia.org/wiki/Bataan_Day
     *
     * @throws \Yasumi\Exception\InvalidDateException
     * @throws \InvalidArgumentException
     * @throws \Yasumi\Exception\UnknownLocaleException
     * @throws \Exception
     */
    private function calculateValorDay(): void
    {
        if ($this->year < 1961) {
            return;
        }

        $this->addHoliday(new Holiday('valorDay', [
            'en_US' => 'Valor Day',
            'fil_PH' => 'Araw ng Kagitingan'
        ], new DateTime("$this->year-04-09", new DateTimeZone($this->timezone)), $this->locale));
    }

    /**
     * Independence Day
     *
     * Independence Day (Filipino: Araw ng Kasarinlan; also known as Araw ng Kalayaan, "Day of Freedom") is
     * an annual national holiday in the Philippines observed on June 12, commemorating the independence of
     * the Philippines from Spain. On August 4, 1964, Republic Act No. 4166 renamed July 4 holiday as
     * Republic Day, proclaimed June 12 as Independence Day, and enjoined all citizens of the Philippines
     * to observe the latter with befitting rites.
     *
     * @link https://en.wikipedia.org/wiki/Independence_Day_(Philippines)
     *
     * @throws \Yasumi\Exception\InvalidDateException
     * @throws \InvalidArgumentException
     * @throws \Yasumi\Exception\UnknownLocaleException
     * @throws \Exception
     */
    private function calculateIndependenceDay(): void
    {
        if ($this->year < 1965) {
            return;
        }

        $this->addHoliday(new Holiday('independenceDay', [
            'en_US' => 'Independence Day',
            'fil_PH' => 'Araw ng Kalayaan'
        ], new DateTime("$this->year-06-12", new DateTimeZone($this->timezone)), $this->locale));
    }

    /**
     * National Heroes Day
     *
     * National Heroes Day is a national public holiday in the Philippines and is held on the
     * last Monday of every August to mark the anniversary of the Cry of Pugad Lawin, the
     * beginning of the Philippine Revolution by the Katipunan and its Supremo Andrés Bonifacio
     * in 1896.
     *
     * @link https://en.wikipedia.org/wiki/Heroes%27_Day#Philippines
     *
     * @throws \Yasumi\Exception\InvalidDateException
     * @throws \InvalidArgumentException
     * @throws \Yasumi\Exception\UnknownLocaleException
     * @throws \Exception
     */
    private function calculateNationalHeroesDay(): void
    {
        if ($this->year < 1932) {
            return;
        }

        $date = $this->getDateLastMondayOfAugust();

        $this->addHoliday(new Holiday('nationalHeroesDay', [
            'en_US' => 'National Heroes Day',
            'fil_PH' => 'Araw ng mga Bayani'
        ], new DateTime("$this->year-08-$date", new DateTimeZone($this->timezone)), $this->locale));
    }

    /**
     * All Souls' Day (Philippines)
     *
     * @link https://en.wikipedia.org/wiki/Public_holidays_in_the_Philippines
     *
     * @throws \Yasumi\Exception\InvalidDateException
     * @throws \InvalidArgumentException
     * @throws \Yasumi\Exception\UnknownLocaleException
     * @throws \Exception
     */
    private function calculateAllSoulsDay(): void
    {
        if ($this->year < 1565) {
            return;
        }

        $this->addHoliday(new Holiday('allSoulsDay', [
            'en_US' => "All Souls' Day",
            'fil_PH' => 'Araw ng mga Patay'
        ], new DateTime("$this->year-11-02", new DateTimeZone($this->timezone)), $this->locale));
    }

    /**
     * Bonifacio Day
     *
     * Bonifacio Day is a national holiday in the Philippines, commemorating Andrés Bonifacio,
     * one of the country's national heroes.
     *
     * @link https://en.wikipedia.org/wiki/Bonifacio_Day
     *
     * @throws \Yasumi\Exception\InvalidDateException
     * @throws \InvalidArgumentException
     * @throws \Yasumi\Exception\UnknownLocaleException
     * @throws \Exception
     */
    private function calculateBonifacioDay(): void
    {
        if ($this->year < 1921) {
            return;
        }

        $this->addHoliday(new Holiday('bonifacioDay', [
            'en_US' => 'Bonifacio Day',
            'fil_PH' => 'Araw ni Bonifacio'
        ], new DateTime("$this->year-11-30", new DateTimeZone($this->timezone)), $this->locale));
    }

    /**
     * Rizal Day
     *
     * Rizal Day is a Philippine national holiday commemorating the life and works of José Rizal,
     * a national hero of the Philippines. It is celebrated every December 30, the anniversary of
     * Rizal's 1896 execution at Bagumbayan (present-day Rizal Park) in Manila.
     *
     * @link https://en.wikipedia.org/wiki/Rizal_Day
     *
     * @throws \Yasumi\Exception\InvalidDateException
     * @throws \InvalidArgumentException
     * @throws \Yasumi\Exception\UnknownLocaleException
     * @throws \Exception
     */
    private function calculateRizalDay(): void
    {
        if ($this->year < 1898) {
            return;
        }

        $this->addHoliday(new Holiday('rizalDay', [
            'en_US' => 'Rizal Day',
            'fil_PH' => 'Araw ni Rizal'
        ], new DateTime("$this->year-12-30", new DateTimeZone($this->timezone)), $this->locale));
    }

    /**
     * This method gets the date of the last monday of August
     *
     * @link https://stackoverflow.com/a/7061841/4584535
     *
     * @return int
     */
    private function getDateLastMondayOfAugust()
    {
        $startDate = 'August 25, '.$this->year;
        $endDate = 'August 31, '.$this->year;

        $endDate = strtotime($endDate);

        for ($i = strtotime('Monday', strtotime($startDate)); $i <= $endDate; $i = strtotime('+1 week', $i)) {
            $date = $i;
        }

        return $date;
    }
}
