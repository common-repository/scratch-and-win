<?php
namespace SOSIDEE_SAW\SRC;
defined( 'SOSIDEE_SAW' ) or die( 'you were not supposed to be here' );

use \SOSIDEE_SAW\SosPlugin;
use \SOSIDEE_SAW\SOS\WP as SOS_WP;


class Card
{
    private $plugin;
    private $database;

    private $user;

    public $game;
    private $prizes;
    private $tickets; //game tickets
    //private $tags; //user tickets

    private $tokens; //new tickets
    private $ticket;

    public $result;

    public $error;
    public $message;
    public $ended;
    public $overGameTotalMax;
    public $overGameUnitMax;

    public function __construct(  ) {
        $this->plugin = SosPlugin::instance();
        $this->database = $this->plugin->database;

        $this->error = false;
        $this->message = '';

        $this->game = false;
        $this->prizes = [];
        $this->tickets = [];
        $this->tokens = [];

        $this->result = false;
        $this->ended = false;
        $this->overGameTotalMax = false;
        $this->overGameUnitMax = false;

        $this->ticket = false;
    }

    private function canPlay() {
        return !$this->error && !$this->ended && !$this->overGameTotalMax && !$this->overGameUnitMax;
    }

    public function draw( $game_id ) {

        $this->user = SOS_WP\User::get();

        $this->loadData( $game_id );

        if ( $this->canPlay() ) {

            $this->calculate();

            $count = count($this->tokens);
            if ( $count > 0) {

                $prize_id = $this->roll( $count );
                if ( $this->canPlay() ) {

                    if ( $this->game->status == GameStatus::ACTIVE ) {
                        $this->insertTicket( $prize_id );
                    } else {
                        $this->setResult( $prize_id );
                    }

                    if ( $this->canPlay() && $this->result instanceof \stdClass && !$this->game->user_email_disabled ) {
                        $this->sendEmail();
                    }

                }
            } else {
                $this->ended = true;
            }
        }
    }

    private function loadData( $id ) {
        $this->loadGame( $id );

        if ( $this->canPlay() ) {

            $this->loadPrizes();

            if ( $this->canPlay() ) {

                $this->loadTickets();
            }
        }
    }

    private function loadGame( $id ) {
        $game = $this->database->loadGame( $id );
        if ( $game != false ) {
                if ( in_array( $game->status, [ GameStatus::ACTIVE, GameStatus::TEST ] ) ) {
                    if ( $this->user->id > 0 ) {
                        if ( $game->user_max_tot > 0 ) {
                            $tickets = $this->database->countUserTickets( $this->user->id, $game->game_id );
                            if ( is_array( $tickets ) ) {
                                $max = 0;
                                for ( $n=0; $n<count($tickets); $n++ ) {
                                    $max += $tickets[$n]->used;
                                }
                                if ( $max >= $game->user_max_tot ) {
                                    $this->overGameTotalMax = true;
                                }
                            } else {
                                $this->error = true;
                                $this->message = $this->plugin::t_('fe.msg.db.generic.problem');
                                sosidee_log("Card.loadGame($id): database.countUserTickets({$this->user->id},{$game->game_id}) did not return an array.");
                            }
                        }
                        if ( $game->user_unit_max > 0 && $game->user_unit_type > 0 ) {
                            $tickets = $this->database->countUserUnitTickets($this->user->id, $game->game_id, $game->user_unit_type);
                            if ( $tickets !== false ) {
                                $max = 0;
                                for ( $n=0; $n<count($tickets); $n++ ) {
                                    $max += $tickets[$n]->used;
                                }
                                if ( $max >= $game->user_unit_max ) {
                                    $this->overGameUnitMax = true;
                                }
                            } else {
                                $this->error = true;
                                $this->message = $this->plugin::t_('fe.msg.db.generic.problem');
                                sosidee_log("Card.loadGame($id): database.countUserUnitTickets({$this->user->id},{$game->game_id},{$game->user_unit_type}) returned false.");
                            }
                        }
                    } else {
                        if ( !$game->user_anonymous ) {
                            $this->error = true;
                            $this->message = $this->plugin::t_('fe.msg.user.unlogged');
                        }
                    }
                } else {
                    $this->error = true;
                    $this->message = $this->plugin::t_('fe.msg.game.status.invalid');
                    sosidee_log("Card.loadGame($id): game.status=$game->status");
                }
                $this->game = $game;
        } else {
            $this->error = true;
            $this->message = $this->plugin::t_('fe.msg.db.generic.problem');
            sosidee_log("Card.loadGame($id) returned false.");
        }
    }

    private function loadPrizes() {
        $game_id = $this->game->game_id;
        $results = $this->database->loadPrizes( $game_id, true );
        if ( is_array($results) ) {
            for ( $n=0; $n<count($results); $n++ ) {
                $this->prizes[] = $results[$n];
            }
            if ( $this->user->id > 0 ) {
                // add the property 'user_used' to prize and check if exists a user max wins
                $user_max_wins = false;
                for ( $n=0; $n<count( $this->prizes ); $n++) {
                    $this->prizes[$n]->user_used = 0;
                    if ( $this->prizes[$n]->win_user_max > 0 ) {
                        $user_max_wins = true;
                    }
                }
                if ( $user_max_wins == true ) {
                    $user_max_wins = $this->database->countUserTickets($this->user->id, $game_id);
                    if ( is_array($user_max_wins) ) {
                        // add and set property 'user_used' to prize
                        for ( $i=0; $i<count( $this->prizes ); $i++) {
                            $prize = &$this->prizes[$i];
                            for ( $j=0; $j<count( $user_max_wins ); $j++ ) {
                                if ( $prize->prize_id == $user_max_wins[$j]->prize_id ) {
                                    $prize->user_used = $user_max_wins[$j]->used;
                                    break;
                                }
                            }
                            unset($prize);
                        }
                    } else {
                        $this->error = true;
                        $this->message = $this->plugin::t_('fe.msg.db.generic.problem');
                        sosidee_log("Card.loadPrizes(): database.countUserTickets({$this->user->id},{$game_id}) did not return an array.");
                    }
                }
            }
        } else {
            $this->error = true;
            $this->message = $this->plugin::t_('fe.msg.db.generic.problem');
            sosidee_log("Card.loadPrizes(): database.loadPrizes({$game_id},true) did not return an array.");
        }
    }

    private function loadTickets() {

        if ( !$this->game->end_disabled ) {
            $game_id = $this->game->game_id;

            $results = $this->database->countTickets( $game_id );
            if ( is_array($results) ) {
                for ($n=0; $n<count($results); $n++) {
                    $this->tickets[] = $results[$n];
                }
            } else {
                $this->error = true;
                $this->message = $this->plugin::t_('fe.msg.db.generic.problem');
                sosidee_log("Card.loadTickets(): database.countTickets({$game_id}) did not return an array.");
            }

        }

    }

    private function calculate() {

        $game = $this->game;

        $total_used = 0;
        for ( $i=0; $i<count( $this->tickets ); $i++) {
            $total_used += intval( $this->tickets[$i]->used );
        }

        // add and set property 'free' to prize
        for ( $i=0; $i<count( $this->prizes ); $i++) {
            $prize = &$this->prizes[$i];
            $prize->free = $prize->win_ticket;
            for ( $j=0; $j<count( $this->tickets ); $j++ ) {
                $ticket = $this->tickets[$j];
                if ( $ticket->prize_id > 0 ) {
                    if ( $ticket->prize_id == $prize->prize_id ) {
                        $prize->free -= $ticket->used;
                        break;
                    }
                }
            }
            unset($prize);
        }

        // fill the array tokens with prize id (for the draw)
        $ticket_free = $game->ticket_tot - $total_used;
        if ( $ticket_free > 0 ) {
            for ( $n=0; $n<count( $this->prizes ); $n++) {
                $prize = $this->prizes[$n];
                if ( $this->user->id > 0 && $prize->win_user_max > 0 ) {
                    if ( $prize->win_user_max <= $prize->user_used ) {
                        continue; // skip this prize
                    }
                }
                for ( $m=0; $m<$prize->free; $m++) {
                    $this->tokens[] = $prize->prize_id; // add winning ticket
                    if ( count($this->tokens) >= $ticket_free ) {
                        break;
                    }
                }
                if ( count($this->tokens) >= $ticket_free ) {
                    break;
                }
            }
        }

        $residual = $ticket_free - count($this->tokens);
        if ( $residual > 0 ) {
            for ( $n=0; $n<$residual; $n++) {
                $this->tokens[] = 0; //add losing ticket
            }
        }

    }

    private function roll( $max ) {
        $ret = false;
        try {
            $max--;
            $number = random_int( 0 , $max ); // pseudorandom number (!)

            $ret = $this->tokens[$number];

        } catch (\Exception $ex) {
            $this->error = true;
            $this->message = $this->plugin::t_('fe.msg.generic.problem');
            sosidee_log("Card.roll(): arose an exception.");
            sosidee_log($ex);
        }
        return $ret;
    }

    private function insertTicket( $prize_id ) {
        //insert new ticket
        $data = [
            'prize_id' => $prize_id ,
            'game_id' => $this->game->game_id,
            'user_id' => $this->user->id,
            'user_email' => $this->user->email
        ];

        if ( $prize_id > 0 ) {
            // winning ticket
            $prize = $this->getPrize( $prize_id );
            $res = $this->database->insertTicket( $data, $prize->win_ticket );
            if ( is_array( $res ) && count($res) > 1 ) {
                if ( intval($res[0]) == $prize_id ) {
                    $this->result = $prize;
                } else {
                    $this->result = 0;
                }
                $ticket_id = $res[1];
                $ticket_data = $this->database->loadTicket($ticket_id);
                if ($ticket_data !== false ) {
                    $this->ticket = new Ticket( $ticket_data );
                } else {
                    sosidee_log("Card.insertTicket($prize_id): database.loadTicket({$ticket_id}) returned false.");
                }
            } else {
                $this->error = true;
                $this->message = $this->plugin::t_('fe.msg.generic.problem');
                sosidee_log("Card.insertTicket($prize_id): database.insertTicket(" . print_r($data, true) . ",{$prize->win_ticket}) did not return an array.");
            }
        } else {
            // losing ticket
            $res = $this->database->insertTicket( $data );
            if ( is_array( $res ) && count($res) > 1 ) {
                $this->result = 0;
                $ticket_id = $res[1];
                $ticket_data = $this->database->loadTicket($ticket_id);
                if ($ticket_data !== false ) {
                    $this->ticket = new Ticket( $ticket_data );
                } else {
                    sosidee_log("Card.insertTicket($prize_id): database.loadTicket({$ticket_id}) returned false.");
                }
            } else {
                $this->error = true;
                $this->message = $this->plugin::t_('fe.msg.generic.problem');
                sosidee_log("Card.insertTicket($prize_id): database.insertTicket(" . print_r($data, true) . ") returned false.");
            }
        }

    }

    private function setResult( $id ) {
        if ( $id > 0 ) {
            $this->result = $this->getPrize( $id );
        } else {
            $this->result = 0;
        }
    }

    private function getPrize( $id ) {
        $ret = false;
        for ( $n=0; $n<count( $this->prizes ); $n++) {
            $prize = $this->prizes[$n];
            if ( $prize->prize_id == $id ) {
                $ret = $prize;
                break;
            }
        }
        return $ret;
    }

    private function sendEmail() {
        $prize = $this->result;
        $to = $this->user->email;
        $subject = $prize->email_subject;
        $body = $prize->email_body;
        if ( !empty($body) ) {
            if ( $this->game->status == GameStatus::TEST ) {
                $subject = "[TEST] " . $subject;
            }
            $res = SOS_WP\Email::send( $to, $subject, $body );
            if ( !$res ) {
                sosidee_log("Card.sendEmail() :: Email.send($to) returned false.");
            }
        } else {
            sosidee_log("Card.sendEmail() body is empty.");
        }
    }

    public function getLayout() {

        $game = $this->game;

        $rets = [
             'coin' => ''
            ,'thickness' => ''
            ,'foreground' => ''
            ,'background' => ''
            ,'style' => 'display:inline-block;'
            ,'class' => $game->image_css_class
            ,'text' => ''
            ,'url' => ''
            ,'timeout' => $game->timeout_redirect
            ,'percent' => $game->scratch_percentage
            ,'callback' => 'false'
            ,'redirect' => 'false'
            ,'immediate' => 'false'
            ,'msg_class' => 'sos_saw_message'
            ,'key' => ''
        ];


        $rets['coin'] = Image::getUrl( $game->image_coin, 'coin' );
        $sizes = wp_getimagesize( $rets['coin'] );
        $rets['thickness'] = intval( min($sizes[0], $sizes[1]) / 2 );

        $cover = Image::getUrl( $game->image_cover, 'cover' );
        $rets['foreground'] = $cover;

        if ( $game->image_size_auto == true) {
            $sizes = wp_getimagesize( $cover );
            if ( is_array($sizes) && count($sizes) > 1 ) {
                $rets['style'] .= "width:$sizes[0]px; height:$sizes[1]px;";
            }
        }

        if ( !$this->ended && !$this->overGameTotalMax && !$this->overGameUnitMax ) {

            $result = $this->result;

            if ( $result instanceof \stdClass ) {
                $rets['background'] = Image::getUrl( $result->win_image, 'win' );
                $rets['text'] = $result->win_text;
                $rets['url'] = $result->win_url;
                $rets['msg_class'] .= ' sos_saw_message_win';
            } else {
                $rets['background'] = Image::getUrl( $game->image_loss, 'loss' );
                $rets['text'] = $game->loss_text;
                $rets['url'] = $game->loss_url;
                $rets['msg_class'] .= ' sos_saw_message_loss';
            }
            if ( $game->ticket_key_show ) {
                $rets['key'] = $this->ticket->getKey();
            }

        } else {

            $rets['background'] = $cover;
            $rets['immediate'] = 'true';

            $rets['coin'] = '';
            $rets['style'] .= 'cursor:not-allowed;';

            if ( $this->ended ) {
                $rets['percent'] = 0;
                $rets['text'] = $game->end_text;
                $rets['url'] = $game->end_url;
            } else if ( $this->overGameTotalMax ) {
                $rets['text'] = $game->user_max_text;
                $rets['url'] = $game->user_max_url;
            } else if ( $this->overGameUnitMax ) {
                $rets['text'] = $game->user_unit_text;
                $rets['url'] = $game->user_unit_url;
            }
        }

        if ( $rets['text'] != '' || $rets['url'] != '') {
            $rets['callback'] = 'true';
        }

        if ( $rets['url'] != '' ) {
            $rets['redirect'] = 'true';
            if ( !sosidee_str_starts_with($rets['url'], ['https://', 'http://', '//']) ) {
                if ( !sosidee_str_starts_with($rets['url'], '/') ) {
                    $rets['url'] = '/' . $rets['url'];
                }
                $rets['url'] = get_site_url() . $rets['url'];
            }
            // escaping routine
            $rets['url'] = esc_url( $rets['url'] );
            if ( $rets['key'] != '') {
                $rets['url'] = add_query_arg(Ticket::QS_KEY, urlencode($rets['key']), $rets['url'] );
            }
            if ( $game->random_qs_url) {
                $qs_key = 'sos' . strval( random_int(6, 666) );
                $qs_value = base64_encode( bin2hex( random_bytes(12) ) );
                $rets['url'] = add_query_arg( $qs_key, urlencode($qs_value), $rets['url'] );
            }
        }

        // escaping routine
        $rets['coin'] = esc_url( $rets['coin'] );
        $rets['foreground'] = esc_url( $rets['foreground'] );
        $rets['background'] = esc_url( $rets['background'] );
        $rets['text'] = sosidee_kses( $rets['text'] );
        $rets['thickness'] = esc_attr( $rets['thickness'] );
        $rets['percent'] = esc_attr( $rets['percent'] );
        $rets['style'] = esc_attr( $rets['style'] );
        $rets['class'] = esc_attr( $rets['class'] );
        $rets['timeout'] = esc_attr( $rets['timeout'] );

        return $rets;
    }

}