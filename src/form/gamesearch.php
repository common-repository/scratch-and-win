<?php
namespace SOSIDEE_SAW\SRC\FORM;
defined( 'SOSIDEE_SAW' ) or die( 'you were not supposed to be here' );

use \SOSIDEE_SAW\SRC as SRC;

class GameSearch extends Base
{
    public $status;
    public $games;

    public function __construct() {
        parent::__construct( 'gameSearch', [$this, 'onSubmit'] );

        $this->status = $this->addSelect('game_status', SRC\GameStatus::NONE);
        $this->status->cached = true;

        $this->games = [];
    }

    public function htmlStatus() {
        $options = SRC\GameStatus::getList('form.select.caption.choose');
        $this->status->html( ['options' => $options] );
    }

    public function htmlSearch( ) {
        $value = self::t_('form.button.search.text');
        parent::htmlButton( '', $value, 'margin: 0 0 0 2em;' );
    }

    public function htmlEdit( $id ) {
        $this->_plugin->formEditGame->htmlButtonEdit( $id );
    }

    public function htmlCreate( ) {
        $this->_plugin->formEditGame->htmlButtonNew();
    }

    protected function initialize() {
        if ( !$this->_posted ) {
            $this->loadGames();
        }
    }

    public function onSubmit() {
        $this->loadGames();
    }

    public function loadGames() {
        $status = intval( $this->status->value );

        $orders = [ 'creation' => 'DESC' ];
        if ( $status > 0) {
            $orders = [ 'description' ];
        }

        $results = $this->_database->loadGames( [ 'status' => $status ], $orders );

        if ( is_array($results) ) {
            if ( count($results) > 0 ) {
                for ( $n=0; $n<count($results); $n++ ) {
                    //$results[$n]->status_desc = SRC\GameStatus::getDescription( $results[$n]->status );
                    $results[$n]->status_icon = SRC\GameStatus::getIcon( $results[$n]->status );

                    if ( $this->_posted ) {
                        $this->saveCache();
                    }
                }
            } else {
                if ( $this->_posted ) {
                    self::msgInfo( 'message.database.empty' );
                } else {
                    self::msgInfo( 'message.search.data.not.found' );
                }
            }
            $this->games = $results;
        } else {
            self::msgErr( 'message.database.generic.problem' );
        }
    }

    public function htmlLegend() {
        $this->htmlOpenLegend();
        $this->htmlGameLegend();
        $this->htmlCloseLegend();
    }

}