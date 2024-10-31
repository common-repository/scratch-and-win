<?php
namespace SOSIDEE_SAW\SRC\FORM;
defined( 'SOSIDEE_SAW' ) or die( 'you were not supposed to be here' );

use \SOSIDEE_SAW\SOS\WP\DATA\FormTag;
use \SOSIDEE_SAW\SRC as SRC;

class Base extends \SOSIDEE_SAW\SOS\WP\DATA\Form
{
    private static $root = null;
    private static $urlList = null;

    protected $_database;

    public function __construct($name, $callback = null) {
        parent::__construct( $name, $callback );

        $this->_database = $this->_plugin->database;

    }

    private static function getRoot() {
        if ( is_null(self::$root) ) {
            self::$root = get_site_url();
        }
        return self::$root;
    }

    private function getUrlPath( $value ) {
        $ret = $value;
        if ( strpos($value, self::getRoot() ) !== false ) {
            $index = strlen( self::getRoot() );
            $ret = substr($value, $index );
        }
        return $ret;
    }


    protected function getPageList() {
        $ret = array();
        $pages = get_pages();
        foreach ( $pages as $page ) {
            $url = get_page_link( $page->ID );
            $url = self::getUrlPath( $url );
            $ret[ $url ] = $page->post_title;
        }
        return $ret;
    }

    protected function getPostList() {
        $ret = array();
        $posts = get_posts();
        foreach ( $posts as $post ) {
            $url = get_page_link( $post->ID );
            $url = self::getUrlPath( $url );
            $ret[ $url ] = $post->post_title;
        }
        return $ret;
    }

    protected function getUrlList() {
        if ( is_null(self::$urlList) ) {
            self::$urlList = [
                 '' => self::t_('form.field.select.url.customized')
                ,self::t_('form.select.group.pages') => self::getPageList()
                ,self::t_('form.select.group.posts') => self::getPostList()
            ];
        }
        return self::$urlList;
    }


    private function isDecimal( $value ) {
        if ( strpos( $value, "." ) !== false ) {
            return true;
        }
        return false;
    }

    public function getPerc( $value ) {
        if ( $this->isDecimal($value)  ) {
            $precision = 0;
            if ($value < 1) {
                $str = substr( strval($value), strpos($value, '.') + 1 );
                for ($n=0; $n<strlen($str); $n++) {
                    if ( $str[$n] !== "0" ) {
                        $precision = $n + 1;
                        break;
                    }
                }
            }
            $num = round($value, $precision);
            if ($num - floor($num) == 0) {
                $num = intval($num);
            }
            return $num;
        } else {
            return $value;
        }

    }

    private function getAsterisk() {
        return '<span style="color: red;font-weight: bold;">*</span>';
    }
    public function htmlFieldName($name, $required = false) {
        echo esc_html( self::t_($name) );
        if ($required) {
            echo  sosidee_kses('&nbsp;' . $this->getAsterisk() );
        }
    }

    public function htmlRequired() {
        echo sosidee_kses( '<p><br>&nbsp;' . $this->getAsterisk() . '&nbsp;<em>' . self::t_('form.field.mandatory') . '</em></p>' );
    }

    public static function getIcon( $label, $color = "", $title = "" ) {
        $color = $color != "" ? " color:$color;" : "";
        return '<i title="' . esc_attr($title) .'" class="material-icons" style="vertical-align: bottom; max-width: 1em; font-size: inherit; line-height: inherit;' . esc_attr($color) . '">' . esc_textarea($label) .'</i>';
    }

    public function htmlSave( $value = 'form.button.save.text' ) {
        parent::htmlSave( self::t_($value) );
    }

    public function htmlButtonDelete( $msg = 'form.button.delete.question', $value = 'form.button.delete.text'  ) {
        parent::htmlDelete( self::t_($value), self::t_($msg) );
    }

    public function htmlRowCount( $count ) {
        if ( is_int($count) ) {
            echo '<div style="text-align:right;margin-right:2em;">' . self::t_( 'common.row.count', ['{count}' => $count] ) . '</div>';
        }
    }

    public function htmlOpenLegend() {
        echo '<p style="font-style: italic;">';
        echo self::t_('common.text.legend') . '<br>';
    }

    public function htmlCloseLegend() {
        echo "</p>";
    }

    public function htmlGameLegend() {
        echo ' ' . self::t_('legend.game.status') . ': ';
        foreach ( SRC\GameStatus::getList() as $key => $value ) {
            echo ' &nbsp; ';
            $icon = SRC\GameStatus::getIcon( $key );
            echo sosidee_kses( $icon . ' ' . $value );
        }
    }

    public function htmlPrizeLegend() {
        echo ' ' . self::t_('legend.prize.status') . ': ';
        foreach ( SRC\PrizeStatus::getList() as $key => $value ) {
            echo ' &nbsp; ';
            $icon = SRC\PrizeStatus::getIcon( $key );
            echo sosidee_kses( $icon . ' ' . $value );
        }
    }

    public function htmlTicketLegend() {
        echo ' ' . self::t_('legend.ticket.status') . ': ';
        foreach ( SRC\TicketStatus::getList() as $key => $value ) {
            echo ' &nbsp; ';
            $icon = SRC\TicketStatus::getIcon( $key );
            echo sosidee_kses( $icon . ' ' . $value );
        }
    }

}