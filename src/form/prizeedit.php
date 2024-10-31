<?php
namespace SOSIDEE_SAW\SRC\FORM;
defined( 'SOSIDEE_SAW' ) or die( 'you were not supposed to be here' );

use \SOSIDEE_SAW\SOS\WP\DATA as DATA;
use \SOSIDEE_SAW\SRC\Image;

class PrizeEdit extends Base
{
    const QS_ID = 'saw-p';
    const QS_ID_GAME = GameEdit::QS_ID;

    public $id;
    public $game_id;
    public $description;

    public $win_ticket;
    public $win_image;
    public $win_text;
    public $win_url;
    public $win_user_max;

    public $email_subject;
    public $email_body;

    public $cancelled;
    public $creation;

    public function __construct()
    {
        parent::__construct('prizeEdit', [$this, 'onSubmit']);

        $this->reset();
        $this->game_id = $this->addHidden('game_id', 0);
    }

    private function reset() {
        $this->id = $this->addHidden('id', 0);
        $this->description = $this->addTextBox('description');

        $this->win_ticket = $this->addNumericBox('win_ticket', 100);
        $this->win_image = $this->addHidden('win_image', 0);
        $this->win_text = $this->addTextArea('win_text');
        $this->win_url = $this->addComboBox('win_url', '');

        $this->win_user_max = $this->addNumericBox('win_user_max', 0);

        $this->email_subject = $this->addTextBox('email_subject');
        $this->email_body = $this->addTextArea('email_body');

        $this->cancelled = $this->addCheckBox('cancelled');
        $this->creation = $this->addHidden('creation', '');
    }

    public function htmlId() {
        $this->id->html();
    }
    public function htmlGameId() {
        $this->game_id->html();
    }
    public function htmlDescription() {
        $this->description->html( ['maxlength' => 255] );
    }
    public function htmlTicketMax() {
        $span_id = 'sos_saw_win_perc';
        $game = $this->_database->loadGame( $this->game_id->value );
        $tot = $game->ticket_tot;
        $js = "jsSosSawPerc(this.value, {$tot}, '{$span_id}');";
        if ($this->id->value > 0) {
            $this->win_ticket->html( ['min' => 1, 'onchange' => $js] ); //'onclick' => $js,
        } else {
            $value = intval($tot / 2);
            $prizes = $this->_database->loadPrizes($this->game_id->value, true);
            if ( is_array($prizes) ) {
                $sub_tot = 0;
                for ($n=0; $n<count($prizes); $n++) {
                    $sub_tot += intval( $prizes[$n]->win_ticket );
                }
                $value = intval( ($game->ticket_tot - $sub_tot) / 2 );
                if ( $value < 0 ) {
                    $value = 0;
                }
            }
            $this->win_ticket->value = $value;
            $this->win_ticket->html( [ 'min' => 1, 'onclick' => $js, 'onchange' => $js] );
        }
        $percentage = $this->getPerc( 100 * $this->win_ticket->value / $tot );
        $style = 'cursor: default;';
        if ( $percentage > 100 ) {
            $style .= ' color: red;';
        }
        $tooltip = $this->_plugin::t_('prize.form.field.ticket.percentage');
        echo ' &nbsp <span id="' . esc_attr($span_id) . '" title="' . esc_attr( $tooltip ) . '" style="' . esc_attr($style) . '">' . esc_html($percentage) . '</span><span title="' . esc_attr( $tooltip ) . '" style="cursor: default;">%</span>';
    }
    public function htmlUserWinMax() {
        $this->win_user_max->html( ['min' => 0] );
    }
    public function htmlImgWin() {
        Image::htmlPreview( 'win', $this->win_image );
        $this->win_image->html();
    }
    public function htmlCancelled() {
        $this->cancelled->html([
            'label' => $this->_plugin::t_('prize.form.field.cancelled.text')
        ]);
    }

    public function htmlTextWin() {
        $this->win_text->html( ['maxlength' => 512] );
    }

    public function htmlUrlWin() {
        $options = Base::getUrlList();
        $this->win_url->html( [ 'options' => $options ] );
    }

    public function htmlEmailSubject() {
        $this->email_subject->html( ['maxlength' => 255] );
    }

    public function htmlEmailBody() {
        $this->email_body->html( ['maxlength' => 1024, 'cols' => '40'] );
    }

    public function htmlButtonDelete( $msg = 'prize.form.button.delete.question', $value = 'form.button.delete.text' ) {
        parent::htmlButtonDelete( $msg );
    }

    public function htmlButtonNew($game_id = 0) {
        if ( $game_id == 0 ) {
            $game_id = $this->game_id->value;
        }
        $this->htmlButtonLink( $game_id, 0);
    }

    public function htmlButtonBack() {
        $value = $this->_plugin::t_('prize.form.button.back.game');
        $this->_plugin->formEditGame->htmlButtonLink2( $this->game_id->value, $value, 'width:150px;' );
    }

    public function htmlButtonLink( $game_id, $id ) {
        $url = $this->_plugin->pagePrize->getUrl( [self::QS_ID => $id, self::QS_ID_GAME => $game_id] );
        if ( $id == 0 ) {
            $value = self::t_('form.button.create.text');
            parent::htmlLinkButton( $url, $value );
        } else {
            $value = $this->_plugin::t_('form.button.modify.text');
            parent::htmlLinkButton( $url, $value, DATA\FormButton::STYLE_SUCCESS );
        }
    }

    public function loadPrize( $id ) {
        if ( $id > 0 ) {
            $prize = $this->_database->loadPrize( $id );
            if ( $prize !== false ) {
                $this->id->value = $prize->prize_id;
                $this->game_id->value = $prize->game_id;
                $this->description->value = $prize->description;

                $this->win_ticket->value = $prize->win_ticket;
                $this->win_image->value = $prize->win_image;
                $this->win_text->value = $prize->win_text;
                $this->win_url->value = $prize->win_url;
                $this->win_user_max->value = $prize->win_user_max;

                $this->email_subject->value = $prize->email_subject;
                $this->email_body->value = $prize->email_body;

                $this->cancelled->value = $prize->cancelled;
                $this->creation->value = $prize->creation;
            } else {
                self::msgErr( 'message.database.generic.problem' );
            }
        } else {
            self::msgErr( 'message.database.generic.problem' );
            sosidee_log("loadPrize($id): id not greater than zero.");
        }
    }

    protected function initialize() {
        if ( !$this->_posted ) {
            $id = sosidee_get_query_var( self::QS_ID, 0 );
            if ( $id > 0 ) {
                $this->loadPrize( $id );
            } else {
                $this->game_id->value = sosidee_get_query_var( GameEdit::QS_ID, 0 );
            }
        }
    }

    public function onSubmit() {
        if ( $this->_action == 'save') {
            $save = true;
            $this->description->value = trim( $this->description->value );
            if ( $this->description->value == '' ) {
                $save = false;
                self::msgErr( 'message.prize.name.empty' );
            }
            $max = intval( $this->win_ticket->value );
            if ( $max <= 0 ) {
                $save = false;
                self::msgErr( 'message.prize.ticket.total.invalid' );
            }

            if ($save) {

                $data = [
                     'game_id' => intval( $this->game_id->value )
                    ,'description' => $this->description->value

                    ,'win_ticket' => intval( $this->win_ticket->value )
                    ,'win_image' => intval( $this->win_image->value )
                    ,'win_text' => trim( $this->win_text->value )
                    ,'win_url' => trim( $this->win_url->value )
                    ,'win_user_max' => intval( $this->win_user_max->value )

                    ,'email_subject' => trim( $this->email_subject->value )
                    ,'email_body' => trim( $this->email_body->value )

                    ,'cancelled' => boolval( $this->cancelled->value )
                ];

                $result = $this->_database->savePrize( $data, $this->id->value );

                if ( $result !== false ) {
                    if ( $result === true ) {
                        self::msgOk( 'message.data.saved' );
                    } else {
                        $id = intval($result);
                        if ( $id > 0 ) {
                            self::msgInfo( 'message.data.inserted' );
                            $this->loadPrize( $id );
                        } else {
                            self::msgErr( 'message.database.generic.problem' );
                        }
                    }
                } else {
                    self::msgErr( 'message.database.generic.problem' );
                }
            }
        } else if ($this->_action == 'delete') {

            $id = intval( $this->id->value );

            if ( $id > 0 ) {
                $result = $this->_database->deletePrize( $id );
                if ( $result !== false ) {
                    $this->reset();
                    self::msgInfo( 'message.data.deleted' );
                } else {
                    self::msgErr( 'message.database.generic.problem' );
                }
            } else {
                self::msgErr( 'message.data.delete.virtual' );
            }

        }
    }
}