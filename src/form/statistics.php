<?php
namespace SOSIDEE_SAW\SRC\FORM;
defined( 'SOSIDEE_SAW' ) or die( 'you were not supposed to be here' );

use \SOSIDEE_SAW\SRC as SRC;
use \SOSIDEE_SAW\SOS\WP\DATA as DATA;

class Statistics extends Base
{
    private $selectStatus;
    private $hidId;

    private $gameList;

    public $game;
    public $games;

    private $jsFunction;


    public function __construct() {
        parent::__construct('gameStats', [$this, 'onSubmit']);

        $this->selectStatus = $this->addSelect('selectStatus', 0);
        $this->selectStatus->cached = true;

        $this->hidId = $this->addHidden('game_id', 0);

        $this->gameList = [];
        $this->game = false;
        $this->games = false;

        $this->jsFunction = 'jsSosSawSelectFilter';
    }

    public function htmlSelectStatus() {
        $options = [
            SRC\GameStatus::NONE => $this->_plugin::t_('form.select.caption.any')
            ,SRC\GameStatus::ACTIVE => $this->_plugin::t_('stats.game.status.active.only')
            ,SRC\GameStatus::TEST => $this->_plugin::t_('stats.game.status.test.only')
            ,SRC\GameStatus::ARCHIVED => $this->_plugin::t_('stats.game.status.archived.only')
        ];
        $this->selectStatus->html( ['options' => $options] );
    }

    public function htmlId() {
        $this->hidId->html();
    }

    public  function htmlButtonList( $style = 'margin: 0 0 0 2em;' ) {
        $value = self::t_('form.button.list.text');
        $this->htmlButton('list', $value, $style, null, $this->jsFunction . "(-1)");
    }

    public function htmlDetails( $id ) {
        $value = self::t_('form.button.detail.text');
        $this->htmlButton('detail', $value, '', null, $this->jsFunction . "($id)" );
    }

    public function htmlJs() {
        $js = <<<EOD
function {$this->jsFunction}(v) {
    let hid = self.document.getElementById( '{$this->hidId->id}' );
    if ( hid ) {
        hid.value = v;
    } else {
        alert('A javascript problem occurred in your browser.');
    }
}
EOD;

        DATA\FormTag::html( 'script', [
             'type' => 'application/javascript'
            ,'content' => $js
        ]);
    }


    protected function initialize() {
        if ( $this->_plugin->pageStats->isCurrent() ) {
            $this->gameList = $this->_database->loadGames( [], ['description'] );
            if ( count($this->gameList) == 0 ) {
                self::msgInfo( 'message.database.empty' );
            }
            if ( $this->_posted == false ) {
                $this->hidId->value = 0;
                $this->loadGames( $this->selectStatus->value );
            }
        }
    }

    public function onSubmit() {

        if ( $this->_action == 'list' ) {

            $status = $this->selectStatus->value;
            $this->loadGames($status);
            $this->hidId->value = 0;

            if ( $this->_posted ) {
                $this->saveCache();
            }

        } else if ( $this->_action == 'detail' ) {

            $id = intval( $this->hidId->value );
            $this->loadGame( $id );

        }

    }

    protected function loadGame( $id ) {
        $game = $this->_database->loadGameStat( $id );
        if ( $game !== false ) {
            $game->status_icon = SRC\GameStatus::getIcon( $game->status );
            for ( $n=0; $n<count($game->prizes); $n++ ) {
                $game->prizes[$n]->status_icon = SRC\PrizeStatus::getIcon( !$game->prizes[$n]->cancelled );
            }
            $this->game = $game;
        } else {
            self::msgErr( 'message.database.generic.problem' );
        }
    }

    protected function loadGames( $status = SRC\GameStatus::NONE ) {
        $results = $this->_database->loadStatGames( $status );
        if ( is_array($results) ) {
            if ( count($results) > 0 ) {
                for ( $n=0; $n<count($results); $n++ ) {
                    $results[$n]->status_icon = SRC\GameStatus::getIcon( $results[$n]->status );
                }
            } else {
                self::msgInfo( 'message.search.data.not.found' );
            }
            $this->games = $results;
        } else {
            self::msgErr( 'message.database.generic.problem' );
        }
    }

    public function htmlLegend() {
        $this->htmlOpenLegend();
        $this->htmlGameLegend();
        if ( $this->hidId->value > 0) {
            echo '<br>';
            $this->htmlPrizeLegend();
        }
        $this->htmlCloseLegend();
    }

}