<?php
use \SOSIDEE_SAW\SosPlugin;
use \SOSIDEE_SAW\SRC as SRC;

$plugin = SosPlugin::instance();
$plugin::addMediaLibrary();
$form = $plugin->formEditGame;
$prizes = $form->prizes;


if ( $form->id->value > 0 ) {
    $plugin->htmlTitle( 'game.page.title' );
} else {
    $plugin->htmlTitle( 'game.page.title.new' );
}
?>

<div class="wrap">

<?php
    $plugin::msgHtml();

    $form->htmlRequired();

    $form->htmlOpen();
?>

    <table class="form-table saw" role="presentation">
    <tbody>
    <tr>
        <th scope="row" class="middled" style=""><?php $form->htmlFieldName('game.form.field.name', true); ?></th>
        <td class="" style="width: 600px;"><?php $form->htmlDescription(); ?></td>
        <td class="note" style=""><?php $form::te('game.form.help.name',['{cn}' => 512]); ?></td>
    </tr>
    <tr>
        <th scope="row" class="middled" style=""><?php $form->htmlFieldName('game.form.field.status', true); ?></th>
        <td class="" style=""><?php $form->htmlStatus(); ?></td>
        <td class="note" style="">
            <?php $form::te('game.form.help.status.title'); ?>:
            <ul>
                <li><strong><?php $form::te('game.status.active'); ?></strong>: <?php $form::te('game.form.help.status.active'); ?></li>
                <li><strong><?php $form::te('game.status.test'); ?></strong>: <?php $form::te('game.form.help.status.test'); ?></li>
                <li><strong><?php $form::te('game.status.archived'); ?></strong>: <?php $form::te('game.form.help.status.archived'); ?></li>
            </ul>
        </td>
    </tr>
    <tr>
        <th scope="row" class="middled" style=""><?php $form->htmlFieldName('game.form.field.ticket.total', true); ?></th>
        <td class="" style=""><?php $form->htmlTicketMax(); ?></td>
        <td class="note" style=""><?php $form::te('game.form.help.ticket.total'); ?></td>
    </tr>
    <tr>
        <th scope="row" class="middled" style=""><?php $form->htmlFieldName('game.form.field.end.text'); ?></th>
        <td class="" style=""><?php $form->htmlTextEnd(); ?></td>
        <td class="note" style=""><?php $form::te('game.form.help.end.text',['{cn}' => 512]); ?></td>
    </tr>
    <tr>
        <th scope="row" class="middled" style=""><?php $form->htmlFieldName('game.form.field.end.url'); ?></th>
        <td class="" style=""><?php $form->htmlUrlEnd(); ?></td>
        <td class="note" style=""><?php $form::te('game.form.help.end.url'); ?></td>
    </tr>
    <tr>
        <th scope="row" class="middled" style=""><?php $form->htmlFieldName('game.form.field.endless'); ?></th>
        <td class="" style=""><?php $form->htmlEndDisabled(); ?></td>
        <td class="note" style=""><?php $form::te('game.form.help.endless'); ?></td>
    </tr>
    <tr>
        <th scope="row" class="middled" style=""><?php $form->htmlFieldName('game.form.field.cover.image', true); ?></th>
        <td class="" style=""><?php $form->htmlImgCover(); ?></td>
        <td class="note" style=""><?php $form::te('game.form.help.cover.image'); ?><td>
    </tr>
    <tr>
        <th scope="row" class="middled" style=""><?php $form->htmlFieldName('game.form.field.loss.image', true); ?></th>
        <td class="" style=""><?php $form->htmlImgLoss(); ?></td>
        <td class="note" style=""><?php $form::te('game.form.help.loss.image'); ?></td>
    </tr>
    <tr>
        <th scope="row" class="middled" style=""><?php $form->htmlFieldName('game.form.field.loss.text'); ?></th>
        <td class="" style=""><?php $form->htmlTextLoss(); ?></td>
        <td class="note" style=""><?php $form::te('game.form.help.loss.text',['{cn}' => 512]); ?></td>
    </tr>
    <tr>
        <th scope="row" class="middled" style=""><?php $form->htmlFieldName('game.form.field.loss.url'); ?></th>
        <td class="" style=""><?php $form->htmlUrlLoss(); ?></td>
        <td class="note" style=""><?php $form::te('game.form.help.loss.url'); ?></td>
    </tr>
    <tr>
        <th scope="row" class="middled" style=""><?php $form->htmlFieldName('game.form.field.images.size'); ?></th>
        <td class="" style=""><?php $form->htmlImgAutoSize(); ?></td>
        <td class="note" style=""><?php $form::te('game.form.help.images.size'); ?></td>
    </tr>
    <tr>
        <th scope="row" class="middled" style=""><?php $form->htmlFieldName('game.form.field.images.css'); ?></th>
        <td class="" style=""><?php $form->htmlImgCssClass(); ?></td>
        <td class="note" style=""><?php $form::te('game.form.help.images.css'); ?></td>
    </tr>
    <tr>
        <th scope="row" class="middled" style=""><?php $form->htmlFieldName('game.form.field.scratcher', true); ?></th>
        <td class="" style=""><?php $form->htmlImgCoin(); ?></td>
        <td class="note" style=""><?php $form::te('game.form.help.scratcher'); ?></td>
    </tr>
    <tr>
        <th scope="row" class="middled" style=""><?php $form->htmlFieldName('game.form.field.scratching.percentage', true); ?></th>
        <td class="" style=""><?php $form->htmlScratchPercentage(); ?></td>
        <td class="note" style=""><?php $form::te('game.form.help.scratching.percentage'); ?></td>
    </tr>
    <tr>
        <th scope="row" class="middled" style=""><?php $form->htmlFieldName('game.form.field.user.plays.max.number'); ?></th>
        <td class="" style=""><?php $form->htmlUserTotalMax(); ?></td>
        <td class="note" style=""><?php $form::te('game.form.help.user.plays.max.number'); ?></td>
    </tr>
    <tr>
        <th scope="row" class="middled" style=""><?php $form->htmlFieldName('game.form.field.user.plays.max.text'); ?></th>
        <td class="" style=""><?php $form->htmlUserTotalText(); ?></td>
        <td class="note" style=""><?php $form::te('game.form.help.user.plays.max.text',['{cn}' => 512]); ?></td>
    </tr>
    <tr>
        <th scope="row" class="middled" style=""><?php $form->htmlFieldName('game.form.field.user.plays.max.url'); ?></th>
        <td class="" style=""><?php $form->htmlUrlUserTotal(); ?></td>
        <td class="note" style=""><?php $form::te('game.form.help.user.plays.max.url'); ?></td>
    </tr>
    <tr>
        <th scope="row" class="middled" style=""><?php $form->htmlFieldName('game.form.field.user.plays.time.max.number'); ?></th>
        <td class="" style=""><?php $form->htmlUserTimeUnit(); ?></td>
        <td class="note" style=""><?php $form::te('game.form.help.user.plays.time.max.number'); ?></td>
    </tr>
    <tr>
        <th scope="row" class="middled" style=""><?php $form->htmlFieldName('game.form.field.user.plays.time.max.text'); ?></th>
        <td class="" style=""><?php $form->htmlUserTimeUnitText(); ?></td>
        <td class="note" style=""><?php $form::te('game.form.help.user.plays.time.max.text',['{cn}' => 512]); ?></td>
    </tr>
    <tr>
        <th scope="row" class="middled" style=""><?php $form->htmlFieldName('game.form.field.user.plays.time.max.url'); ?></th>
        <td class="" style=""><?php $form->htmlUserTimeUnitUrl(); ?></td>
        <td class="note" style=""><?php $form::te('game.form.help.user.plays.time.max.url'); ?></td>
    </tr>
    <tr>
        <th scope="row" class="middled" style=""><?php $form->htmlFieldName('game.form.field.ticket.key'); ?></th>
        <td class="" style=""><?php $form->htmlShowTicketKey(); ?></td>
        <td class="note" style=""><?php $form::te('game.form.help.ticket.key'); ?></td>
    </tr>
    <tr>
        <th scope="row" class="middled" style=""><?php $form->htmlFieldName('game.form.field.email.winner'); ?></th>
        <td class="" style=""><?php $form->htmlUserEmailDisabled(); ?></td>
        <td class="note" style=""><?php $form::te('game.form.help.email.winner'); ?></td>
    </tr>
    <tr>
        <th scope="row" class="middled" style=""><?php $form->htmlFieldName('game.form.field.redirect.timeout'); ?></th>
        <td class="" style=""><?php $form->htmlTimeoutRedirect(); ?></td>
        <td class="note" style=""><?php $form::te('game.form.help.redirect.timeout'); ?></td>
    </tr>
    <tr>
        <th scope="row" class="middled" style=""><?php $form->htmlFieldName('game.form.field.anonymous'); ?></th>
        <td class="" style=""><?php $form->htmlUserAnonymousEnabled(); ?></td>
        <td class="note" style="">
            <?php
                echo SRC\FORM\Base::getIcon( 'warning_amber', '#dc3545' ) . '&nbsp;';
                $form::te('game.form.help.anonymous');
            ?>
        </td>
    </tr>
    <tr>
        <th scope="row" class="middled" style=""><?php $form->htmlFieldName('game.form.field.url.random.qs'); ?></th>
        <td class="" style=""><?php $form->htmlRndQsUrl(); ?></td>
        <td class="note" style=""><?php $form::te('game.form.help.url.random.qs'); ?></td>
    </tr>
    </tbody>
</table>

<table role="presentation" style="margin-top: 1em;">
    <tbody>
    <td style="width: 120px;">
        <?php
        $form->htmlButtonDelete();
        ?>
    </td>
    <td style="width: 120px;">
        <?php $form->htmlButtonNew(); ?>
    </td>
    <td style="width: 120px;">
        <?php $form->htmlSave(); ?>
    </td>
    </tbody>
</table>

<?php

    $form->htmlId();
    $form->htmlClose();

    if ( $form->id->value > 0 ) {

?>
    <br>
    <table class="form-table" role="presentation">
        <tbody>
        <tr>
            <th scope="row" class="" style=""><?php $form->htmlFieldName('game.form.field.shortcode'); ?></th>
            <td class="" style="width: 320px;">
                <input id="saw-game-sc" type="text" value="[scratch-win game=<?php echo esc_attr( $form->id->value ); ?>]" readonly aria-readonly="true" style="_width: 10em; border: none; _color: #2271b1; background-color: #fff; _text-align: center;" onfocus="this.select();" />
                &nbsp;<button onclick="jsSaW_Copy2CB('saw-game-sc');" style="vertical-align: bottom; cursor: pointer;" title="<?php echo esc_attr( $form::t_('game.form.field.shortcode.tooltip') ); ?>"><span class="material-icons" style="vertical-align: bottom; color: #2271b1;">content_copy</span></button>
            </td>
            <td class="note" style="border: 0; line-height: inherit; font-size: 90%;"><?php $form::te('game.form.help.shortcode',['{icon}' => '<span class="material-icons" style="vertical-align: bottom; line-height: inherit;">content_copy</span>']); ?></td>
        </tr>
        </tbody>
    </table>

    <br>
    <h3><?php $plugin->te('game.prizes.table.title'); ?></h3>
    <?php $form->htmlRowCount(count($prizes)); ?>
    <table class="form-table saw bordered" role="presentation">
        <thead>
        <tr>
            <th scope="col" class="bordered medium" style="width: 7%;"><?php $plugin->te('game.prizes.table.column.status'); ?></th>
            <th scope="col" class="bordered medium" style="width: 45%;"><?php $plugin->te('game.prizes.table.column.name'); ?></th>
            <th scope="col" class="bordered medium" style="width: 14%;"><?php $plugin->te('game.prizes.table.column.tickets.total'); ?></th>
            <th scope="col" class="bordered medium" style="width: 7%;"><?php $plugin->te('game.prizes.table.column.tickets.drawn'); ?></th>
            <th scope="col" class="bordered medium" style="width: 15%;"><?php $plugin->te('game.prizes.table.column.creation'); ?></th>
            <th scope="col" class="bordered medium" style="width: 12%; padding: 0;">
                <?php $form->htmlCreatePrize(); ?>
            </th>
        </tr>
        </thead>
        <tbody>
    <?php
    if ( is_array($prizes) && count($prizes) > 0 ) {
        $ticket_win_tot = 0;
        $ticket_used_tot = 0;
        $ticket_win_tot_percentage = '-';
        for ($n = 0; $n < count($prizes); $n++) {
            $item = $prizes[$n];
            $ticket_win_tot += $item->win_ticket;
            $ticket_used_tot += $item->ticket_used;
            $creation = $item->creation_string;
            $status_icon = $item->status_icon;
            $style_ticket = '';
            if ($item->win_ticket_perc > 100) {
                $style_ticket = 'color: red';
            }
            ?>
            <tr>
                <td class="bordered medium"><?php echo sosidee_kses( $status_icon ); ?></td>
                <td class="bordered medium"><?php echo esc_html($item->description); ?></td>
                <td class="bordered medium" style="<?php echo esc_attr($style_ticket); ?>"><?php echo esc_html("$item->win_ticket ({$item->win_ticket_perc}%)"); ?></td>
                <td class="bordered medium"><?php echo esc_html($item->ticket_used); ?></td>
                <td class="bordered medium"><?php echo esc_html($creation); ?></td>
                <td class="bordered medium" style="padding: 0;"><?php $form->htmlEditPrize($item->prize_id); //$plugin->formEditPrize->htmlLinkButton( $item->game_id, $item->prize_id ); ?></td>
            </tr>
    <?php
        }
        if ( count($prizes) > 1 ) {
            $ticket_win_tot_percentage = $form->getPerc( 100 * $ticket_win_tot / $form->game->ticket_tot );
            $style_ticket_tot = '';
            if ($ticket_win_tot_percentage > 100) {
                $style_ticket_tot = 'color: red; font-weight: bold';
            }
            echo '<tr>';
            echo '<td class=""></td>';
            echo '<td class="medium italiced">' . $plugin->t_('game.prizes.table.row.total') . '</td>';
            echo '<td class="medium italiced" style="' . esc_attr($style_ticket_tot) . '">' . esc_html("$ticket_win_tot ({$ticket_win_tot_percentage}%)") . '</td>';
            echo '<td class="medium italiced">' . esc_html($ticket_used_tot) . '</td>';
            echo '<td class="" colspan="2"></td>';
            echo '</tr>';
        }
    }
    ?>
        </tbody>
    </table>

<?php
        if ( is_array($prizes) && count($prizes) > 0 ) {
            $form->htmlLegend();
        }

    }
?>

</div>