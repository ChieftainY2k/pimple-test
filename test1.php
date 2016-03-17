<?php
/**
 * Pimple test
 */
//use Pimple\Container;

include(__DIR__ . "/vendor/autoload.php");
date_default_timezone_set("Europe/Warsaw");


class DateFormatter
{
    private $dateFormat = "Y-m-d";

    function __construct()
    {
        echo "\n *** ".__CLASS__." created\n";
    }

    /**
     * @return string
     */
    public function getDateFormat()
    {
        return $this->dateFormat;
    }

    /**
     * @param string $dateFormat
     */
    public function setDateFormat($dateFormat)
    {
        $this->dateFormat = $dateFormat;
    }

    /**
     * @param $timestamp
     * @return bool|string
     */
    public function getFormattedDate($timestamp)
    {
        return date($this->getDateFormat(), $timestamp);
    }

}


class CurrentDate
{
    /**
     * @var DateFormatter
     */
    private $dateFormatter = null;

    function __construct()
    {
        echo "\n *** ".__CLASS__." created\n";
    }

    /**
     * @return DateFormatter
     */
    public function getDateFormatter()
    {
        return $this->dateFormatter;
    }

    /**
     * @param null $dateFormatter
     */
    public function setDateFormatter($dateFormatter)
    {
        $this->dateFormatter = $dateFormatter;
    }

    /**
     *
     */
    public function getCurrentDate()
    {
        return $this->getDateFormatter()->getFormattedDate(time());
    }
}

$container = new Pimple\Container();

$container['date_format'] = "Y-m-d H:i";

$container['date_formatter'] = function ($c) {
    $dateFormatter = new DateFormatter();
    $dateFormatter->setDateFormat($c['date_format']);
    return $dateFormatter;
};

$container['current_date_getter'] = function($c) {
    $currentDate = new CurrentDate();
    $currentDate->setDateFormatter($c['date_formatter']);
    return $currentDate;
};


//print_r($container);

$currentDateGetter = $container['current_date_getter'];
var_dump($currentDateGetter->getCurrentDate());

$currentDateGetter = $container['current_date_getter'];
var_dump($currentDateGetter->getCurrentDate());




