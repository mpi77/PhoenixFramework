<?php

namespace Phoenix\Utils;

/**
 * DateTime utils.
 *
 * @version 1.0
 * @author MPI
 *        
 */
class DateTime extends \DateTime {

    /** minute in seconds */
    const MINUTE = 60;
    /** hour in seconds */
    const HOUR = 3600;
    /** day in seconds */
    const DAY = 86400;
    /** week in seconds */
    const WEEK = 604800;
    /** average month in seconds */
    const MONTH = 2629800;
    /** average year in seconds */
    const YEAR = 31557600;
    
    /**
     * DateTime object factory.
     *
     * @param string|int|\DateTime $time            
     * @return \DateTime
     *
     */
    public static function from($time) {
        if ($time instanceof \DateTime || $time instanceof \DateTimeInterface) {
            return new static($time->format("Y-m-d H:i:s"), $time->getTimezone());
        } elseif (is_numeric($time)) {
            if ($time <= self::YEAR) {
                $time += time();
            }
            $tmp = new static("@" . $time);
            return $tmp->setTimeZone(new \DateTimeZone(date_default_timezone_get()));
        } else {
            return new static($time);
        }
    }

    /**
     * Returns HTTP valid date format.
     * 
     * @param string|int|\DateTime $time
     * @return string in format D, d M Y H:i:s GMT
     */
    public static function formatHttpDate($time) {
        $time = self::from($time);
        $time->setTimezone(new \DateTimeZone("GMT"));
        return $time->format("D, d M Y H:i:s \G\M\T");
    }
}
?>