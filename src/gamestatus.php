<?php
namespace SOSIDEE_SAW\SRC;
defined( 'SOSIDEE_SAW' ) or die( 'you were not supposed to be here' );

class GameStatus
{
    const NONE = 0;
    const ACTIVE = 1;
    const TEST = 3;
    const ARCHIVED = 6;


    public static function getList( $caption = false ) {
        $ret = array();

        $plugin = \SOSIDEE_SAW\SosPlugin::instance();
        if ($caption !== false) {
            $ret[self::NONE] = $plugin::t_($caption);
        }

        $ret[self::ACTIVE] = $plugin::t_( self::getDescription(self::ACTIVE) );
        $ret[self::TEST] = $plugin::t_( self::getDescription(self::TEST) );
        $ret[self::ARCHIVED] = $plugin::t_( self::getDescription(self::ARCHIVED) );

        return $ret;
    }

    public static function getDescription( $value ) {
        $ret = '';
        switch ($value) {
            case self::ARCHIVED:
                $ret = 'game.status.archived';
                break;
            case self::TEST:
                $ret = 'game.status.test';
                break;
            case self::ACTIVE:
                $ret = 'game.status.active';
                break;
        }
        return $ret;
    }

    public static function getIcon($value) {
        $ret = '';
        switch ($value) {
            case self::ACTIVE:
                $ret = FORM\Base::getIcon('check_circle', '#28a745', self::getDescription($value));
                break;
            case self::TEST:
                $ret = FORM\Base::getIcon('build_circle', '#2271b1', self::getDescription($value));
                break;
            case self::ARCHIVED:
                $ret = FORM\Base::getIcon('block', '#dc3545', self::getDescription($value));
                break;
        }
        return $ret;
    }


}