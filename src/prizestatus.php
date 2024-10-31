<?php
namespace SOSIDEE_SAW\SRC;
defined( 'SOSIDEE_SAW' ) or die( 'you were not supposed to be here' );

class PrizeStatus
{
    const NONE = 0;
    const ENABLED = 1;
    const DISABLED = -1;

    public static function getList( $caption = false ) {
        $ret = array();

        $plugin = \SOSIDEE_SAW\SosPlugin::instance();
        if ($caption !== false) {
            $ret[self::NONE] = $plugin::t_($caption);
        }
        $ret[self::ENABLED] = $plugin::t_( self::getDescription(self::ENABLED) );
        $ret[self::DISABLED] = $plugin::t_( self::getDescription(self::DISABLED) );

        return $ret;
    }

    public static function getDescription( $value ) {
        $ret = "";
        if ( is_bool($value) ){
            $value = $value ? self::ENABLED : self::DISABLED;
        }
        switch ( $value ) {
            case self::DISABLED:
                $ret = 'prize.status.cancelled';
                break;
            case self::ENABLED:
                $ret = 'prize.status.active';
                break;
        }
        return $ret;
    }

    public static function getIcon($value) {
        $ret = '';
        if ( is_bool($value) ){
            $value = $value ? self::ENABLED : self::DISABLED;
        }
        switch ( $value ) {
            case self::ENABLED:
                $ret = FORM\Base::getIcon('check_circle', '#28a745', self::getDescription($value));
                break;
            case self::DISABLED:
                $ret = FORM\Base::getIcon('block', '#dc3545', self::getDescription($value));
                break;
        }
        return $ret;
    }

}