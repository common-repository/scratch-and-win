<?php
namespace SOSIDEE_SAW\SRC\FORM;
defined( 'SOSIDEE_SAW' ) or die( 'you were not supposed to be here' );

use \SOSIDEE_SAW\SOS\WP\DATA as DATA;
use \SOSIDEE_SAW\SRC\Image;
use \SOSIDEE_SAW\SRC as SRC;

class GameEdit extends Base
{
    const QS_ID = 'saw-g';

    public $game;
    public $prizes;


    public $id;
    private $status;
    private $description;
    private $ticket_tot;

    private $loss_text;
    private $loss_url;
    private $end_text;
    private $end_url;
    private $end_disabled;

    public $image_cover;
    public $image_loss;
    public $image_coin;
    private $image_size_auto;
    private $image_css_class;

    private $scratch_percentage;

    private $user_max_tot;
    private $user_max_text;
    private $user_max_url;

    private $user_unit_max;
    private $user_unit_type;
    private $user_unit_text;
    private $user_unit_url;
    private $user_anonymous;
    private $user_email_disabled;

    private $timeout_redirect;
    private $ticket_key_show;
    private $random_qs_url;

    private $creation;

    public function __construct() {
        parent::__construct( 'gameEdit', [$this, 'onSubmit'] );

        $this->reset();
    }

    private function reset() {
        $this->id = $this->addHidden('id', 0);
        $this->status = $this->addSelect('status', SRC\GameStatus::TEST);
        $this->description = $this->addTextBox('description');
        $this->ticket_tot = $this->addNumericBox('ticket_tot', 1000);

        $this->loss_text = $this->addTextArea('loss_text');
        $this->loss_url = $this->addComboBox('loss_url', '');
        $this->end_text = $this->addTextArea('end_text');
        $this->end_url = $this->addComboBox('end_url', '');
        $this->end_disabled = $this->addCheckBox('end_disabled' );

        $this->image_cover = $this->addHidden('image_cover', 0);
        $this->image_loss = $this->addHidden('image_loss', 0);
        $this->image_coin = $this->addHidden('image_coin', 0);
        $this->image_size_auto = $this->addCheckBox('image_size_auto', true);
        $this->image_css_class = $this->addTextBox('image_css_class');

        $this->user_max_tot = $this->addNumericBox('user_max_tot', 0);
        $this->user_max_text = $this->addTextArea('user_max_text');
        $this->user_max_url = $this->addComboBox('user_max_url', '');

        $this->scratch_percentage = $this->addNumericBox('scratch_percentage', 90);

        $this->user_unit_max = $this->addNumericBox('user_unit_max', 0);
        $this->user_unit_type = $this->addSelect('user_unit_type', SRC\TimeUnit::NONE);
        $this->user_unit_text = $this->addTextArea('user_unit_text');
        $this->user_unit_url = $this->addComboBox('user_unit_url', '');
        $this->user_email_disabled = $this->addCheckBox('user_email_disabled' );
        $this->user_anonymous = $this->addCheckBox('user_anonymous' );

        $this->ticket_key_show = $this->addCheckBox('ticket_key_show', false );
        $this->random_qs_url = $this->addCheckBox('random_qs_url', false );

        $this->timeout_redirect = $this->addNumericBox('timeout_redirect', 3);
        $this->creation = $this->addHidden('creation', '');

        $this->game = null;
        $this->prizes = [];
    }

    public function htmlId() {
        $this->id->html();
    }
    public function htmlStatus() {

        $options = SRC\GameStatus::getList( 'form.select.caption.choose' );

        $this->status->html(['options' => $options]);
    }
    public function htmlDescription() {
        $this->description->html( ['maxlength' => 255] );
    }
    public function htmlTicketMax() {
        $this->ticket_tot->html([
             'min' => 1
            ,'max' => 2147483647
        ]);
    }
    public function htmlTextLoss() {
        $this->loss_text->html( ['maxlength' => 512] );
    }
    public function htmlUrlLoss() {
        $options = Base::getUrlList();
        $this->loss_url->html( [ 'options' => $options ] );
    }
    public function htmlTextEnd() {
        $this->end_text->html( ['maxlength' => 512] );
    }
    public function htmlUrlEnd() {
        $options = Base::getUrlList();
        $this->end_url->html( [ 'options' => $options ] );
    }

    public function htmlEndDisabled() {
        $this->end_disabled->html( [
            'label' => $this->_plugin::t_('game.form.field.endless.text')
        ]);
    }

    public function htmlImgCover() {
        Image::htmlPreview( 'cover', $this->image_cover );
        $this->image_cover->html();
    }

    public function htmlImgLoss() {
        Image::htmlPreview( 'loss', $this->image_loss );
        $this->image_loss->html();
    }

    public function htmlImgAutoSize() {
        $this->image_size_auto->html([
            'label' => $this->_plugin::t_('game.form.field.images.size.auto')
        ]);
    }
    public function htmlImgCssClass() {
        $this->image_css_class->html( ['maxlength' => 64] );
    }

    public function htmlImgCoin() {
        Image::htmlPreview( 'coin', $this->image_coin );
        $this->image_coin->html();
    }

    public function htmlScratchPercentage() {
        $this->scratch_percentage->html([
             'min' => 0
            ,'max' => 100
        ]);
    }

    public function htmlUserTotalMax() {
        $this->user_max_tot->html([
             'min' => 0
            ,'max' => 2147483647
        ]);
    }
    public function htmlUserTotalText() {
        $this->user_max_text->html( ['maxlength' => 512] );
    }
    public function htmlUrlUserTotal() {
        $options = Base::getUrlList();
        $this->user_max_url->html( [ 'options' => $options ] );
    }

    public function htmlUserTimeUnit() {
        $this->user_unit_max->html([
             'min' => 0
            ,'max' => 2147483647
        ]);
        $this->_plugin::te('game.form.field.user.plays.time.max.times');
        $options = SRC\TimeUnit::getList( 'form.select.caption.choose' );
        $this->user_unit_type->html( ['options' => $options] );
    }

    public function htmlUserTimeUnitText() {
        $this->user_unit_text->html( ['maxlength' => 512] );
    }

    public function htmlUserTimeUnitUrl() {
        $options = Base::getUrlList();
        $this->user_unit_url->html( [ 'options' => $options ] );
    }

    public function htmlTimeoutRedirect() {
        $this->timeout_redirect->html([
             'min' => 0
            ,'max' => 120
        ]);
    }

    public function htmlUserEmailDisabled() {
        $this->user_email_disabled->html( [ 'label' => $this->_plugin::t_('game.form.field.email.winner.disabled') ] );
    }

    public function htmlUserAnonymousEnabled() {
        $this->user_anonymous->html( [ 'label' => $this->_plugin::t_('game.form.field.anonymous.enabled') ] );
    }

    public function htmlShowTicketKey() {
        $this->ticket_key_show->html( [ 'label' => $this->_plugin::t_('game.form.field.ticket.key.show') ] );
    }

    public function htmlRndQsUrl() {
        $this->random_qs_url->html( [ 'label' => $this->_plugin::t_('game.form.field.url.random.qs.add') ] );
    }

    public function htmlButtonDelete( $msg = 'game.form.button.delete.question', $value = 'form.button.delete.text' ) {
        parent::htmlButtonDelete( $msg );
    }

    public function htmlButtonNew() {
        $this->htmlButtonLink( 0 );
    }
    public function htmlButtonEdit( $id ) {
        $this->htmlButtonLink( $id );
    }

    public function htmlButtonLink( $id ) {
        $url = $this->_plugin->pageGame->getUrl( [self::QS_ID => $id] );
        if ( $id == 0 ) {
            $value = self::t_('form.button.create.text');
            parent::htmlLinkButton( $url, $value );
        } else {
            $value = $this->_plugin::t_('form.button.modify.text');
            parent::htmlLinkButton( $url, $value, DATA\FormButton::STYLE_SUCCESS );
        }
    }

    public function htmlButtonLink2( $id, $label, $style = 'min-width:120px;' ) {
        $url = $this->_plugin->pageGame->getUrl( [self::QS_ID => $id] );
        parent::htmlLinkButton2( $url, $label, $style );
    }

    public function htmlCreatePrize( ) {
        $this->_plugin->formEditPrize->htmlButtonNew( $this->id->value );
    }

    public function htmlEditPrize( $prize_id ) {
        $this->_plugin->formEditPrize->htmlButtonLink( $this->id->value, $prize_id );
    }


    public function loadGame( $id ) {
        if ( $id > 0 ) {
            $game = $this->_database->loadGame( $id );
            if ( $game !== false ) {

                $this->id->value = $game->game_id;
                $this->status->value = $game->status;
                $this->description->value = $game->description;
                $this->ticket_tot->value = $game->ticket_tot;

                $this->loss_text->value = $game->loss_text;
                $this->loss_url->value = $game->loss_url;
                $this->end_text->value = $game->end_text;
                $this->end_url->value = $game->end_url;
                $this->end_disabled->value = $game->end_disabled;

                $this->image_cover->value = $game->image_cover;
                $this->image_loss->value = $game->image_loss;
                $this->image_coin->value = $game->image_coin;
                $this->image_size_auto->value = $game->image_size_auto;
                $this->image_css_class->value = $game->image_css_class;

                $this->scratch_percentage->value = $game->scratch_percentage;

                $this->user_max_tot->value = $game->user_max_tot;
                $this->user_max_text->value = $game->user_max_text;
                $this->user_max_url->value = $game->user_max_url;

                $this->user_unit_max->value = $game->user_unit_max;
                $this->user_unit_type->value = $game->user_unit_type;
                $this->user_unit_text->value = $game->user_unit_text;
                $this->user_unit_url->value = $game->user_unit_url;
                $this->user_email_disabled->value = $game->user_email_disabled;
                $this->user_anonymous->value = $game->user_anonymous;

                $this->ticket_key_show->value = $game->ticket_key_show;
                $this->random_qs_url->value = $game->random_qs_url;

                $this->timeout_redirect->value = $game->timeout_redirect;
                $this->creation->value = $game->creation;

                $this->game = $game;

                $this->loadPrizes( $id );

            } else {
                self::msgErr( 'message.database.generic.problem' );
            }
        } else {
            self::msgErr( 'message.generic.problem' );
            sosidee_log("loadGame($id): id not greater than zero.");
        }
    }

    protected function initialize() {
        if ( !$this->_posted ) {
            $id = sosidee_get_query_var(self::QS_ID, 0);
            if ( $id > 0 ) {
                $this->loadGame( $id );
            }
        }
    }

    public function onSubmit() {
        if ( $this->_action == 'save' ) {
            $save = true;
            $this->description->value = trim( $this->description->value );
            if ( $this->description->value == '' ) {
                $save = false;
                self::msgErr( 'message.game.name.empty' );
            }
            $num = intval( $this->status->value );
            if ( $num == 0 ) {
                $save = false;
                self::msgErr( 'message.game.status.invalid' );
            }
            $num = intval( $this->ticket_tot->value );
            if ( $num <= 0 ) {
                $save = false;
                self::msgErr( 'message.game.ticket.total.invalid' );
            }
            $num = intval( $this->user_max_tot->value );
            if ( $num < 0 ) {
                $save = false;
                self::msgErr( 'message.game.user.max.invalid' );
            }
            $num = intval( $this->user_unit_max->value);
            $num2 = intval( $this->user_unit_type->value);
            if ( $num > 0 && $num2 == 0 ) {
                $save = false;
                self::msgErr( "message.game.user.time.unit.invalid" );
            }
            if ( $num <= 0 && $num2 > 0 ) {
                $save = false;
                self::msgErr( 'message.game.user.time.total.invalid' );
            }

            $num = intval( $this->timeout_redirect->value );
            if ( $num < 0 ) {
                $save = false;
                self::msgErr( 'message.game.redirect.timeout.invalid' );
            }

            $num = intval( $this->scratch_percentage->value);
            if ( $num < 0 && $num2 > 100 ) {
                $save = false;
                self::msgErr( 'message.game.scratch.percentage.invalid' );
            }


            if ( $save ) {

                $data = [
                     'status' => intval( $this->status->value )
                    ,'description' => trim( $this->description->value )
                    ,'ticket_tot' => intval( $this->ticket_tot->value )

                    ,'loss_text' => trim( $this->loss_text->value )
                    ,'loss_url' => trim( $this->loss_url->value )
                    ,'end_text' => trim( $this->end_text->value )
                    ,'end_url' => trim( $this->end_url->value )
                    ,'end_disabled' => boolval( $this->end_disabled->value )

                    ,'image_cover' => intval( $this->image_cover->value )
                    ,'image_loss' => intval( $this->image_loss->value )
                    ,'image_coin' => intval( $this->image_coin->value )
                    ,'image_size_auto' => boolval( $this->image_size_auto->value )
                    ,'image_css_class' => $this->image_css_class->value

                    ,'scratch_percentage' => intval( $this->scratch_percentage->value )

                    ,'user_max_tot' => intval( $this->user_max_tot->value )
                    ,'user_max_text' => trim( $this->user_max_text->value )
                    ,'user_max_url' => trim( $this->user_max_url->value )

                    ,'user_unit_max' => intval( $this->user_unit_max->value )
                    ,'user_unit_type' => intval( $this->user_unit_type->value )
                    ,'user_unit_text' => trim( $this->user_unit_text->value )
                    ,'user_unit_url' => trim( $this->user_unit_url->value )
                    ,'user_email_disabled' => boolval( $this->user_email_disabled->value )
                    ,'user_anonymous' => boolval( $this->user_anonymous->value )

                    ,'ticket_key_show' => boolval( $this->ticket_key_show->value )
                    ,'random_qs_url' => boolval( $this->random_qs_url->value )

                    ,'timeout_redirect' => intval( $this->timeout_redirect->value )
                ];

                $result = $this->_database->saveGame( $data, $this->id->value );

                if ( $result !== false ) {
                    if ( $result === true ) {
                        self::msgOk( 'message.data.saved' );
                        $this->loadGame( $this->id->value );
                    } else {
                        $id = intval($result);
                        if ( $id > 0 ) {
                            self::msgInfo( 'message.data.inserted' );
                            $this->loadGame( $id );
                        } else {
                            self::msgErr( 'message.database.generic.problem' );
                        }
                    }
                } else {
                    self::msgErr( 'message.database.generic.problem' );
                }

            }

        } else if ( $this->_action == 'delete' ) {

            $id = intval( $this->id->value );

            if ( $id > 0 ) {
                $result = $this->_database->deleteGame( $id );
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

    public function loadPrizes( $id )
    {
        $results = $this->_database->loadPrizes( $id );
        if ( is_array($results) ) {
            if ( count($results) > 0 ) {
                for ( $i=0; $i<count($results); $i++) {
                    $item = &$results[$i];
                    $item->win_ticket_perc = $this->getPerc( 100 * $item->win_ticket / $this->game->ticket_tot );
                    $item->ticket_used = 0;
                    $item->status_icon = SRC\PrizeStatus::getIcon( !$item->cancelled );
                    $item->creation_string = sosidee_datetime_format( $item->creation );
                    unset($item);
                }
                $tickets = $this->_database->countTickets( $id );
                if ( is_array($tickets) ) {
                    for ($n=0; $n<count($tickets); $n++) {
                        $ticket = $tickets[$n];
                        if ( $ticket->prize_id > 0 ) {
                            for ( $m=0; $m<count($results); $m++) {
                                if ( $results[$m]->prize_id == $ticket->prize_id ) {
                                    $results[$m]->ticket_used = $ticket->used;
                                    break;
                                }
                            }
                        }
                    }
                } else {
                    self::msgWarn( 'message.database.generic.problem' );
                }
            }
            $this->prizes = $results;
        } else {
            self::msgErr( 'message.database.generic.problem' );
        }
    }

    public function htmlLegend() {
        $this->htmlOpenLegend();
        $this->htmlPrizeLegend();
        $this->htmlCloseLegend();
    }

}