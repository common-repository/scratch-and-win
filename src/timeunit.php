<?php
namespace SOSIDEE_SAW\SRC;
defined( 'SOSIDEE_SAW' ) or die( 'you were not supposed to be here' );

class TimeUnit
{
    const NONE = 0;
    const HOUR = 1;
    const DAY = 3;
    const WEEK = 5;

    public static function getList($caption = false) {
        $ret = array();

        $plugin = \SOSIDEE_SAW\SosPlugin::instance();
        if ( $caption !== false ) {
            $ret[self::NONE] = $plugin::t_($caption);
        }

        $ret[self::HOUR] = $plugin::t_( self::getDescription(self::HOUR) );
        $ret[self::DAY] = $plugin::t_( self::getDescription(self::DAY) );
        $ret[self::WEEK] = $plugin::t_( self::getDescription(self::WEEK) );

        return $ret;
    }

    public static function getDescription( $value ) {
        $ret = '';
        switch ($value) {
            case self::HOUR:
                $ret = 'game.user.time.max.unit.hour';
                break;
            case self::DAY:
                $ret = 'game.user.time.max.unit.day';
                break;
            case self::WEEK:
                $ret = 'game.user.time.max.unit.week';
                break;
        }
        return $ret;
    }

    public static function getDatetime( $value ) {
        $ret = false;
        switch ($value) {
            case self::HOUR:
                $ret = self::subHour(1);
                break;
            case self::DAY:
                $ret = self::subDay(1);
                break;
            case self::WEEK:
                $ret = self::subDay(7);
                break;
        }
        return $ret;
    }

    private static function _subX($interval) {
        $dt = sosidee_current_datetime();
        return $dt->sub( new \DateInterval($interval) );
    }
    private static function subYear($value) {
        return self::_subX("P{$value}Y");
    }
    private static function subMonth($value) {
        return self::_subX("P{$value}M");
    }
    private static function subDay($value) {
        return self::_subX("P{$value}D");
    }
    private static function subHour($value) {
        return self::_subX("PT{$value}H");
    }
    private static function subMinute($value) {
        return self::_subX("PT{$value}M");
    }
    private static function subSecond($value) {
        return self::_subX("PT{$value}S");
    }

}