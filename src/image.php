<?php
namespace SOSIDEE_SAW\SRC;
defined( 'SOSIDEE_SAW' ) or die( 'you were not supposed to be here' );

use \SOSIDEE_SAW\SosPlugin;
use \SOSIDEE_SAW\SOS\WP\HtmlTag;

class Image
{

    public static function getUrl( $id, $mode ) {
        if ( $id > 0 ) {
            $ret = wp_get_attachment_image_src($id, 'full');
            if ( is_array($ret) ) {
                return $ret[0]; //0:url 1:width 2:height
            } else {
                return '';
            }
        } else {
            $plugin = SosPlugin::instance();
            $root = $plugin::$url . '/assets/img';
            switch ($mode) {
                case 'cover':
                    return $root . '/cover.jpg';
                case 'loss':
                    return $root. '/loss.jpg';
                case 'win':
                    return $root . '/win.jpg';
                case 'coin':
                    return $root . '/coin.png';
            }
        }
    }

    private static function getPreviewUrl( $id, $mode ) {
        if ( $id > 0 ) {
            $ret = wp_get_attachment_image_src($id, 'thumbnail'); // thumbnail | medium | large | full
            if ( is_array($ret) === false ) {
                $ret = self::getUrl( $id, $mode );
            } else {
                $ret = $ret[0]; //0:url 1:width 2:height
            }
            return $ret;
        } else {
            $plugin = SosPlugin::instance();
            $root = $plugin::$url . '/assets/img';
            switch ($mode) {
                case 'cover':
                    return $root . '/cover.jpg';
                case 'loss':
                    return $root. '/loss.jpg';
                case 'win':
                    return $root . '/win.jpg';
                case 'coin':
                    return $root . '/coin.png';
            }
        }
    }

    public static function htmlPreview( $mode, $field ) {
        $id = $field->id;
        $name = $field->name;
        $value = intval($field->value);
        $url = self::getPreviewUrl( $value, $mode );
        HtmlTag::html( 'img', [
            'id' => "{$id}_pre"
            ,'name' => "{$name}_pre"
            ,'src' => $url
            ,'onclick' => "jsSosSawSelectML('$mode');"
            ,'title' => "clicca per modificare"
            ,'style' => "max-width: 150px; max-height: 150px; cursor: pointer;"
        ]);
    }

}