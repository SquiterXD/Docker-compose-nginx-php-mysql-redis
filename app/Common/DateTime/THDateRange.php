<?php


namespace App\Common\DateTime;


class THDateRange
{
    /**
     * @var THDate $tfrom
     */
    private $tfrom;
    /**
     * @var THDate $tto
     */
    private $tto;

    /**
     * THDateRange constructor.
     * @param THDate $from
     * @param THDate $to
     */
    private function __construct(THDate $from, THDate $to)
    {
        $this->tfrom = $from;
        $this->tto = $to;
    }

    public static function range(THDate $from, THDate $to)
    {
        return new THDateRange($from, $to);
    }

    public function from(): THDate
    {
        return $this->tfrom;
    }

    public function to(): THDate
    {
        return $this->tto;
    }

}
