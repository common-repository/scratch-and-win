<?php

use \SOSIDEE_SAW\SosPlugin;

$plugin = SosPlugin::instance();
$form = $plugin->formStats;

$game = $form->game;
$games = $form->games;

$plugin->htmlTitle('stats.page.title');
?>

<div class="wrap">

<?php
    settings_errors();

    $form->htmlOpen();
    $form->htmlId();
?>

<table class="form-table" style="width: inherit;" role="presentation">
    <thead>
    <tr>
        <th scope="col" class="centered middled" style=""><?php $plugin::te('stats.form.filter.game.status'); ?></th>
        <th scope="col" class="centered middled" style=""></th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td class="centered middled" style="">
            <?php $form->htmlSelectStatus(); ?>
        </td>
        <td class="centered middled" style="">
            <?php $form->htmlButtonList(); ?>
        </td>
    </tr>
    </tbody>
</table>

<br><br>
<?php
    if ( is_array($games) ) {
        $form->htmlRowCount(count($games));
?>
    <table class="form-table saw bordered" role="presentation">
        <thead>
        <tr>
            <th scope="col" class="bordered centered" style="width: 70%" colspan="3"><?php $plugin::te('stats.table.column.games'); ?></th>
            <th scope="col" class="bordered centered" style="width: 30%" colspan="3"><?php $plugin::te('stats.table.column.tickets'); ?></th>
        </tr>
        <tr>
            <th scope="col" class="bordered centered" style="width: 10%"></th>
            <th scope="col" class="bordered centered" style="width: 5%"><?php $plugin::te('stats.table.column.game.status'); ?></th>
            <th scope="col" class="bordered centered" style="width: 55%"><?php $plugin::te('stats.table.column.game.name'); ?></th>
            <th scope="col" class="bordered centered" style="width: 10%"><?php $plugin::te('stats.table.column.ticket.total'); ?></th>
            <th scope="col" class="bordered centered" style="width: 10%"><?php $plugin::te('stats.table.column.ticket.used'); ?></th>
            <th scope="col" class="bordered centered" style="width: 10%"><?php $plugin::te('stats.table.column.ticket.win'); ?></th>
        </tr>
        </thead>
        <tbody>
<?php
        for ($n=0; $n<count($games); $n++) {
            $_game = $games[$n];
            $status_icon = $_game->status_icon;
?>
        <tr>
            <td class="bordered centered"><?php echo $form->htmlDetails( $_game->game_id ) ?></td>
            <td class="bordered centered"><?php echo sosidee_kses( $status_icon ); ?></td>
            <td class="bordered centered"><?php echo esc_html($_game->description); ?></td>
            <td class="bordered centered"><?php echo esc_html($_game->ticket_tot); ?></td>
            <td class="bordered centered"><?php echo esc_html($_game->used); ?></td>
            <td class="bordered centered"><?php echo esc_html($_game->win); ?></td>
        </tr>
<?php } ?>
        </tbody>
    </table>
<?php
}
if ( $game !== false ) {
    $used_tot_percentage = $form->getPerc( 100 * $game->used / $game->ticket_tot );
    $prize_tot = 0;
    $win_tot = 0;
    for ( $n=0; $n<count($game->prizes); $n++ ) {
        $prize_tot += $game->prizes[$n]->win_ticket;
        $win_tot += $game->prizes[$n]->used;
        $game->prizes[$n]->win_perc = $form->getPerc( 100 * $game->prizes[$n]->win_ticket / $game->ticket_tot );
        $game->prizes[$n]->used_perc = $form->getPerc( 100 * $game->prizes[$n]->used / $game->prizes[$n]->win_ticket );
    }
    $prize_tot_percentage = $form->getPerc( 100 * $prize_tot / $game->ticket_tot );
    if ($prize_tot > 0) {
        $win_tot_percentage = $form->getPerc( 100 * $win_tot / $prize_tot );
    } else {
        $win_tot_percentage = "-";
    }

?>
<table class="form-table saw bordered pad1 rounded4" style="width: inherit;" role="presentation">
    <tbody>
    <tr>
        <th scope="row" class="middled" style=""><?php $plugin::te('stats.table.row.game.name'); ?></th>
        <td class="" style=""><?php echo esc_html($game->description); ?></td>
    </tr>
    <tr>
        <th scope="row" class="middled" style=""><?php $plugin::te('stats.table.row.game.status'); ?></th>
        <td class="" style=""><?php echo sosidee_kses($game->status_icon); ?></td>
    </tr>
    <tr>
        <th scope="row" class="middled" style=""><?php $plugin::te('stats.table.row.ticket.total'); ?></th>
        <td class="" style=""><?php echo sosidee_kses("<strong>{$game->ticket_tot}</strong>"); ?></td>
    </tr>
    <tr>
        <th scope="row" class="middled" style=""><?php $plugin::te('stats.table.row.ticket.prized'); ?></th>
        <td class="" style=""><?php echo sosidee_kses("<strong>{$prize_tot}</strong>/{$game->ticket_tot} ({$prize_tot_percentage} %)"); ?></td>
    </tr>
    <tr>
        <th scope="row" class="middled" style=""><?php $plugin::te('stats.table.row.ticket.used'); ?></th>
        <td class="" style=""><?php echo sosidee_kses("<strong>{$game->used}</strong>/{$game->ticket_tot} ({$used_tot_percentage} %)"); ?></td>
    </tr>
    <tr>
        <th scope="row" class="middled" style=""><?php $plugin::te('stats.table.row.ticket.win'); ?></th>
        <td class="" style=""><?php echo sosidee_kses("<strong>{$win_tot}</strong>/{$prize_tot} ({$win_tot_percentage} %)"); ?></td>
    </tr>
    </tbody>
</table>
    <?php
    if ( count($game->prizes) > 0 ) {
        for ( $n=0; $n<count($game->prizes); $n++ ) {
            $prize = $game->prizes[$n];
    ?>
<br>
<table class="form-table saw bordered pad1 rounded4" style="width: inherit;" role="presentation">
<tbody>
        <tr>
            <th scope="row" class="middled" style=""><?php $plugin::te('stats.table.row.prize.name'); ?></th>
            <td class="" style=""><?php echo esc_html($prize->description);  ?></td>
        </tr>
        <tr>
            <th scope="row" class="middled" style=""><?php $plugin::te('stats.table.row.prize.status'); ?></th>
            <td class="" style=""><?php echo sosidee_kses($prize->status_icon);  ?></td>
        </tr>
        <tr>
            <th scope="row" class="middled" style=""><?php $plugin::te('stats.table.row.prize.ticket.total'); ?></th>
            <td class="" style=""><?php echo sosidee_kses("<strong>{$prize->win_ticket}</strong>/{$game->ticket_tot} ({$prize->win_perc} %)"); ?></td>
        </tr>
        <tr>
            <th scope="row" class="middled" style=""><?php $plugin::te('stats.table.row.prize.ticket.used'); ?></th>
            <td class="" style=""><?php echo sosidee_kses("<strong>$prize->used</strong>/$prize->win_ticket ($prize->used_perc %)"); ?></td>
        </tr>
    </tbody>
</table>
<?php
        }
     } else {
?>
<br>
<table class="form-table saw bordered pad1 rounded4" style="width: inherit;" role="presentation">
    <tbody>
        <tr>
            <th scope="row" class="middled" style=""><?php $plugin::te('stats.table.row.prize.name'); ?></th>
            <td class="" style=""><em>---</em></td>
        </tr>
    </tbody>
</table>
    <?php } ?>
<?php } ?>


<?php
    $form->htmlJs();
    $form->htmlClose();
    $form->htmlLegend();
?>

</div>