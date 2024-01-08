<?php


namespace App\Common\DateTime;


use Illuminate\Support\Collection;

class THDate
{

    public const monthInThLong = [
        "มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม",
    ];
    public const monthInThShort = [
        "ม.ค.", "ก.พ.", "มี.ค.", "เม.ย", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค.",
    ];
    public const fortnightStartAtMonthIndex = 9;

    /**
     * @var int $time
     */
    private $time;

    /**
     * THDate constructor.
     * @param int $time
     */
    protected function __construct(int $time)
    {
        $this->time = $time;
    }

    public static function now(): THDate
    {
        return static::time();
    }

    public static function time(int $timestamp = null): THDate
    {
        return new static($timestamp ?? time());
    }

    public static function str(string $dateString): THDate
    {
        return new static(strtotime($dateString));
    }

    public function format(string $dateFormat = 'Y-m-d H:i:s'): string
    {
        return date($dateFormat, $this->time);
    }

    public function next(string $cmd): THDate
    {
        return new static(strtotime($cmd, $this->time));
    }

    // helper

    public function getMonthIndex(): int
    {
        return intval(date('M', $this->time));
    }

    public function getFortnight(): int
    {
        $m = intval(date('M', $this->time));
        $d = intval(date('d', $this->time));
        $f = ($m + 12 - static::fortnightStartAtMonthIndex) % 12;
        return $f * 2 + ($d >= 16 ? 1 : 0);
    }

    public function getMonthTh($fullName = true): string
    {
        $months = $fullName ? static::monthInThLong : static::monthInThShort;
        return $months[intval(date('M', $this->time))];
    }

    public function getEndOfMonthDate(): int
    {
        return intval($this->next('first day of +1 month')->next('-1 day')->format('d'));
    }

    public function generateNextFortnights($n = 12, $includeCurrent = true): array
    {
        $fs = [];
        $cur = $this;

        if (!$includeCurrent) {
            $cur = $cur->next('+1 month');
            $n--;
        }

        foreach (range(1, $n) as $_) {
//            print_r($cur->format());
//            echo "\n";
            $d_1 = $cur->next('first day of month');
            $d_15 = $d_1->next('+14 day');

            $d_16 = $d_15->next('+1 day');
            $diff = $cur->getEndOfMonthDate() - 16;
            $d_end = $d_16->next("+$diff day");

            $fs[] = THDateRange::range($d_1, $d_15);
            $fs[] = THDateRange::range($d_16, $d_end);
            $cur = $cur->next('+1 month');
        }

        return $fs;
    }

}
