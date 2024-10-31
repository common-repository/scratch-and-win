<?php
namespace SOSIDEE_SAW\SRC;
defined( 'SOSIDEE_SAW' ) or die( 'you were not supposed to be here' );

class Ticket
{
    const QS_KEY = 'saw-key';
    const KEY_LENGTH = 12;

    private $id;
    private $creation;

    public function __construct( $data ) {
        $this->id = $data->ticket_id;
        $this->creation = $data->creation;
    }

    public function getKey() {
        return self::getCode($this->id, $this->creation);
    }

    public static function getId( $key ) {
        $ret = 0;
        if ( strlen($key) == self::KEY_LENGTH ) {
            $len = intval( $key[0] );
            $ret = intval( substr($key, self::KEY_LENGTH - $len, $len) );
        }
        return $ret;
    }

    public static function getCode( $id, $creation ) {
        $lid = strlen($id);
        $dt = $creation->format("Y-m-d H:i:s");
        $ts = strrev( strtotime($dt) );

        $foo = substr($ts, 0, self::KEY_LENGTH - 1 - $lid);

        return $lid . $foo . $id;
    }

}