<?php
namespace SOSIDEE_SAW\SRC;
defined( 'SOSIDEE_SAW' ) or die( 'you were not supposed to be here' );

class TicketStatus
{
    const NONE = '';
    const ACTIVE = 0;
    const CANCELLED = 1;

    public static function getList( $caption = false ) {
        $ret = array();

        $plugin = \SOSIDEE_SAW\SosPlugin::instance();
        if ($caption !== false) {
            $ret[self::NONE] = $plugin::t_($caption);
        }

        $ret[self::ACTIVE] = $plugin::t_( self::getDescription(self::ACTIVE) );
        $ret[self::CANCELLED] = $plugin::t_( self::getDescription(self::CANCELLED) );

        return $ret;
    }

    public static function getDescription( $value ) {
        $ret = '';
        if ( is_bool($value) ){
            $value = $value ? self::ACTIVE : self::CANCELLED;
        }
        switch ( $value ) {
            case self::CANCELLED:
                $ret = 'ticket.status.cancelled';
                break;
            case self::ACTIVE:
                $ret = 'ticket.status.valid';
                break;
        }
        return $ret;
    }

    public static function getIcon($value) {
        $ret = '';
        if ( is_bool($value) ){
            $value = $value ? self::ACTIVE : self::CANCELLED;
        }
        switch ( $value ) {
            case self::ACTIVE:
                $ret = FORM\Base::getIcon('check_circle', '#28a745', self::getDescription($value));
                break;
            case self::CANCELLED:
                $ret = FORM\Base::getIcon('cancel', '#dc3545', self::getDescription($value));
                break;
        }
        return $ret;
    }

}