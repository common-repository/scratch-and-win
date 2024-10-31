<?php
namespace SOSIDEE_SAW\SRC\FORM;
defined( 'SOSIDEE_SAW' ) or die( 'you were not supposed to be here' );

use \SOSIDEE_SAW\SOS\WP\DATA as DATA;
use \SOSIDEE_SAW\SRC as SRC;

class TicketSearch extends Base
{
    private $game;
    private $result;
    private $dtFrom;
    private $dtTo;
    private $status;
    private $keyValue;
    private $keyEnabled;

    public $tickets;

    private $actionId;

    public function __construct() {
        parent::__construct( 'ticketSearch', [$this, 'onSubmit'] );

        $this->game = $this->addSelect('game', 0);
        $this->game->cached = true;
        $this->status = $this->addSelect('status', '');
        $this->status->cached = true;
        $this->result = $this->addSelect('result', '');
        $this->result->cached = true;
        $this->dtFrom = $this->addDatePicker('from', 'now');
        $this->dtFrom->cached = true;
        $this->dtTo = $this->addDatePicker('to', 'now');
        $this->dtTo->cached = true;

        $this->keyValue = $this->addTextBox('keyValue', '');
        $this->keyEnabled = $this->addCheckBox('keyEnabled', false);

        $this->tickets = [];

        $this->actionId = $this->addHidden('action_id', 0);
    }

    public function htmlGame() {
        $options = [ 0 => $this->_plugin::t_('form.select.caption.any') ];
        $games = $this->_database->loadGames( [
            "{$this->_database->getTable('games')->status->name}[<>]" => SRC\GameStatus::ARCHIVED
        ], ['description'] );
        if ( is_array($games)) {
            for ( $n=0; $n<count($games); $n++) {
                $game = $games[$n];
                $options[$game->game_id] = $game->description;
            }
        }
        $this->game->html( ['options' => $options] );
    }

    public function htmlStatus() {
        $options = [
             SRC\TicketStatus::NONE => $this->_plugin::t_('form.select.caption.any')
            ,SRC\TicketStatus::ACTIVE => $this->_plugin::t_('tickets.status.valid.only')
            ,SRC\TicketStatus::CANCELLED => $this->_plugin::t_('tickets.status.cancelled.only')
        ];
        $this->status->html( ['options' => $options] );
    }

    public function htmlResult() {
        $options = [
            SRC\ResultStatus::NONE => $this->_plugin::t_('form.select.caption.any')
            ,SRC\ResultStatus::WIN => $this->_plugin::t_('tickets.result.win.only')
            ,SRC\ResultStatus::LOSS => $this->_plugin::t_('tickets.result.loss.only')
        ];
        $this->result->html( ['options' => $options] );
    }

    public function htmlFrom() {
        $this->dtFrom->html();
    }
    public function htmlTo() {
        $this->dtTo->html();
    }

    public function htmlKeyValue() {
        $this->keyValue->html( ['maxlength' => SRC\Ticket::KEY_LENGTH, 'size' => 12] );
    }
    public function htmlKeyEnabled() {
        $this->keyEnabled->html([
            'label' => $this->_plugin::t_('tickets.form.filter.key.enable')
        ]);
    }

    public function htmlSearch( ) {
        $action = 'search';
        $value = $this->_plugin::t_('form.button.search.text');
        parent::htmlButton( $action, $value );
    }

    public function htmlAction( $index ) {
        $ticket = $this->tickets[$index];
        if ( $ticket->cancelled ) {
            $action = 'activate';
            $label = $this->_plugin::t_('form.button.activate.text');
            $style = DATA\FormButton::STYLE_SUCCESS;
        } else {
            $action = 'cancel';
            $label = $this->_plugin::t_('form.button.cancel.text');
            $style = DATA\FormButton::STYLE_DANGER;
        }
        $onclick = "return jsSosSawActionTicket($ticket->ticket_id, '{$this->actionId->id}');";
        parent::htmlButton( $action, $label, $style, null, $onclick );
    }

    protected function initialize() {
        if ( !$this->_posted ) {
            if ( $this->_cache_timestamp instanceof \DateTime ) {
                $now = sosidee_current_datetime();
                if ( $this->_cache_timestamp->format('Ymd') != $now->format('Ymd') ) {
                    $this->dtFrom->value = $now->format('Y-m-d');
                    $this->dtTo->value = $now->format('Y-m-d');
                }
            }
        }
    }

    public function onSubmit() {
        if ( in_array($this->_action , ['cancel','activate']) ) {
            $id = intval( $this->actionId->value );
            if ( $this->_action == 'cancel') {
                $data['cancelled'] = true;
            } else {
                $data['cancelled'] = false;
            }
            $result = $this->_database->updateTicket( $data, $id );
            if ($result === true ) {
                self::msgOk( 'message.action.performed' );
            } else {
                self::msgErr( 'message.database.generic.problem' );
            }
        }

        $loadData = false;
        $filters = [];

        if ( $this->keyEnabled->value == false ) {
            $filters = [
                'game' => $this->game->value
                ,'result' => $this->result->value
                ,'status' => $this->status->value
                ,'from' => $this->dtFrom->getValueAsDate()
                ,'to' => $this->dtTo->getValueAsDate( true )
            ];
            $loadData = true;
        } else {
            $key = trim($this->keyValue->value);
            $id = SRC\Ticket::getId($key);
            if ( $id > 0 ) {
                $filters = [
                    'id' => $id
                ];
                $loadData = true;
            } else {
                self::msgErr( 'message.search.invalid.ticket.key' );
            }
        }

        if ( $loadData ) {
            $results = $this->_database->loadTickets( $filters );
            if ( is_array($results) ) {
                if ( count($results) > 0 ) {
                    for ( $n=0; $n<count($results); $n++ ) {
                        $results[$n]->creation_string = sosidee_datetime_format( $results[$n]->creation );
                        $results[$n]->status_icon = SRC\TicketStatus::getIcon( !$results[$n]->cancelled );
                        $results[$n]->key = SRC\Ticket::getCode($results[$n]->ticket_id, $results[$n]->creation);
                    }
                    $this->tickets = $results;
                    if ( $this->_posted ) {
                        $this->saveCache();
                    }
                } else {
                    self::msgInfo( 'message.search.data.not.found' );
                }
            } else {
                self::msgErr( 'message.database.generic.problem' );
            }
        }
    }

    public function htmlClose() {
        $this->actionId->html();
        parent::htmlClose();
    }

    public function htmlLegend() {
        $this->htmlOpenLegend();
        $this->htmlTicketLegend();
        $this->htmlCloseLegend();
    }


}