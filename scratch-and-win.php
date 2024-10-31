<?php
/*
Plugin Name: Scratch and Win
Version: 1.1.2
Description: Users play your 'Scratch & Win' game and can be redirected to different URLs, depending on the result.
Author: SOSidee.com srl
Author URI: https://sosidee.com
Text Domain: scratch-and-win
Domain Path: /languages
*/
namespace SOSIDEE_SAW;
( defined( 'ABSPATH' ) and defined( 'WPINC' ) ) or die( 'you were not supposed to be here' );
defined('SOSIDEE_SAW') || define( 'SOSIDEE_SAW', true );

require_once "loader.php";

\SOSIDEE_CLASS_LOADER::instance()->add( __NAMESPACE__, __DIR__ );

/**
 * Class of This Plugin *
 *
 * @property $card
 * @property $pgCard
**/
class SosPlugin extends SOS\WP\Plugin
{

    public $database;

    //pages
    public $pageGames;
    public $pageGame;
    public $pagePrize;
    public $pageTickets;
    public $pageStats;

    //forms
    public $formSearchGame;
    public $formEditGame;
    public $formEditPrize;
    public $formSearchTicket;
    public $formStats;


    protected function __construct() {
        parent::__construct();

        //PLUGIN KEY & NAME 
        $this->key = 'sos-scratch-and-win';
        $this->name = 'Scratch & Win';

        //if necessary, enable localization
        $this->internationalize( 'scratch-and-win' ); //Text Domain
    }

    protected function initialize() {
        parent::initialize();

        // database: custom tables for the plugin
        $this->database = new SRC\Database();

    }

    protected function initializeBackend() {
        $this->pageGames = $this->addPage('games' );
        $this->pageGame = $this->addPage('game' );
        $this->pagePrize = $this->addPage('prize' );
        $this->pageTickets = $this->addPage('tickets' );
        $this->pageStats = $this->addPage('stats' );

        //menu
        //$this->menu->color = 'yellow';
        $this->menu->icon = '-money-alt';

        $this->menu->add( $this->pageGames, self::t_('menu.item.games') );
        $this->menu->addHidden( $this->pageGame );
        $this->menu->addHidden( $this->pagePrize );
        $this->menu->add( $this->pageTickets, self::t_('menu.item.tickets') );
        $this->menu->add( $this->pageStats, self::t_('menu.item.stats') );

        $this->formSearchGame = new SRC\FORM\GameSearch();
        $this->formSearchGame->addToPage( $this->pageGames );
        $this->formEditGame = new SRC\FORM\GameEdit();
        $this->formEditGame->addToPage( $this->pageGame );
        $this->formEditPrize = new SRC\FORM\PrizeEdit();
        $this->formEditPrize->addToPage( $this->pagePrize );
        $this->formSearchTicket = new SRC\FORM\TicketSearch();
        $this->formSearchTicket->addToPage( $this->pageTickets );
        $this->formStats = new SRC\FORM\Statistics();
        $this->formStats->addToPage( $this->pageStats );

        $this->addScript('admin')->addToPage( $this->pages );
        $this->addStyle('admin')->addToPage( $this->pages );

        $this->registerLocalizedScript('sos_saw_local', [$this, 'getLocalizedData'], $this->pages );

        $this->addGoogleIcons();

        $this->qsArgs[] = 'saw-g';
        $this->qsArgs[] = 'saw-p';
    }

    public function getLocalizedData() {
        return [
             'cover_ml_title' => esc_html( self::t_('js.media-lib.cover.title') )  //Seleziona l'immagine per la copertina
            ,'cover_image_tag' => $this->formEditGame->image_cover->id
            ,'loss_ml_title' => esc_html( self::t_('js.media-lib.loss.title') ) //Seleziona l'immagine per la perdita
            ,'loss_image_tag' => $this->formEditGame->image_loss->id
            ,'win_ml_title' => esc_html( self::t_('js.media-lib.win.title') ) //Seleziona l'immagine per la vincita
            ,'win_image_tag' => $this->formEditPrize->win_image->id
            ,'coin_ml_title' => esc_html( self::t_('js.media-lib.scratcher.title') ) //Seleziona l'immagine per lo scratcher
            ,'coin_image_tag' => $this->formEditGame->image_coin->id
            ,'message_confirm_action' => esc_html( self::t_('js.message.confirm.action') ) //confermi prima di procedere?
            ,'message_text_copied_clipboard' => esc_html( self::t_('js.message.text.copied.clipboard') )
        ];
    }

    protected function initializeFrontend() {
        $this->addShortCode( 'scratch-win', array($this, 'handleShortcode') );
    }


    protected function hasShortcode( $tag, $attributes ) {
        if ( isset($attributes['game']) ) {
            $this->addScript('scratch.min', true)->html();
        }
    }

    public function handleShortcode($args, $content, $tag) {

        if ( isset($args['game']) ) {
            $id = intval( $args['game'] );
            if ( $id > 0 ) {
                $card = new SRC\Card();
                $card->draw( $id );

                if ( !$card->error ) {
                    return $this->htmlCard( $card );
                } else {
                    return '<p class="sos_saw_message">' . sosidee_kses($card->message) . '</p>';
                }

            } else {
                sosidee_log("Error handling the shortcode :: invalid id game: {$id}");
            }
        }

        if ( isset($args['get']) ) {
            $value = strtolower( trim( $args['get'] ) );

            if ( $value == 'code' ) {
                $key = sosidee_get_query_var(SRC\Ticket::QS_KEY, '');
                if ( strlen($key) == SRC\Ticket::KEY_LENGTH ) {
                    return $key;
                } else {
                    sosidee_log("Error handling the shortcode :: invalid/missing code ('{$key}') in the URL query string.");
                    return "? <!-- scratch-win: INVALID or MISSING QUERY STRING IN THE URL -->";
                }

            } else {
                sosidee_log("Error handling the shortcode :: invalid value for attribute 'get': $value");
            }

        }

        $msg = "invalid attribute(s) a/o value(s): [scratch-win";
        foreach ( $args as $key => $value ) {
            if ( is_numeric($key) ) {
                $msg .= ' ' . $value;
            } else {
                $msg .= ' ' . $key . '=' . $value;
            }
        }
        $msg .= ']';
        sosidee_log($msg);
        // escape output for post content
        return wp_kses_post( "? <!-- $msg -->");

    }

    public function htmlCard( $card ) {
        static $htmlCounter = 0;

        $layouts = $card->getLayout();

        $ticketKey = '';
        if ( $layouts['key'] != '') {
            $ticketKey = '<div id="sos_saw_key_' . $htmlCounter .'" style="font-size: smaller;">' . $layouts['key'] . '</div>';
        }

$js = <<<EOD
<div id="sos_saw_container_{$htmlCounter}" style="text-align:center;">
<div id="sos_saw_card_{$htmlCounter}" style="{$layouts['style']}" class="{$layouts['class']}"></div>
{$ticketKey}
<p id="sos_saw_msg_{$htmlCounter}" class="{$layouts['msg_class']}" style="display:none;">{$layouts['text']}</p>
</div>
<script>
    function jsSaW_Start_{$htmlCounter}() {
        createScratchCard({
            'callback': 'jsSaW_CB_{$htmlCounter}',
            'container': document.getElementById('sos_saw_card_{$htmlCounter}'), 
            'background': '{$layouts['background']}', 
            'foreground': '{$layouts['foreground']}', 
            'coin': '{$layouts['coin']}', 
            'thickness': {$layouts['thickness']},
            'percent': {$layouts['percent']}
        });
    }
    function jsSaW_CB_{$htmlCounter}() {
        if ( {$layouts['callback']} ) {
            let p = self.document.getElementById('sos_saw_msg_{$htmlCounter}');
            if (p) {
                p.style.display = 'block';
            } else {
                alert('A javascript problem occurred in your browser: the message cannot be displayed.');
            }
            if ( {$layouts['redirect']} ) {
                setTimeout( function(){ self.location.href = '{$layouts['url']}'; }, {$layouts['timeout']}*1000);
            }
        }
    }
    if ( {$layouts['immediate']} ) {
        jsSaW_CB_{$htmlCounter}();
    }
if (window.jQuery) {
    (function($){
        'use strict';
        $(document).ready(function(){
            jsSaW_Start_{$htmlCounter}();
        });
    })(jQuery);
} else {
    alert( 'jQuery not found.' );
}
</script>
EOD;

        $htmlCounter++;
        return $js;
    }

    public function htmlTitle( $title = 'Scratch & Win' ) {
        echo '<h1 class="dashicons-before dashicons-money-alt">&nbsp;' . esc_html( self::t_($title) ) . '</h1>';
    }


}


/**
 * DO NOT CHANGE BELOW UNLESS YOU KNOW WHAT YOU DO *
**/
$plugin = SosPlugin::instance(); //the class must be the one defined in this file
$plugin->run();


//this is the end