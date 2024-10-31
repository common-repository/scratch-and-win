<?php

use \SOSIDEE_SAW\SosPlugin;

$plugin = SosPlugin::instance();
$form = $plugin->formSearchTicket;
$tickets = $form->tickets;

$rowCount = '';
if ( is_array($tickets) && count($tickets)>0 ) {
    $rowCount = count($tickets) . '';
}

$plugin->htmlTitle('tickets.page.title');
?>

<div class="wrap">

    <?php settings_errors(); ?>

<?php $form->htmlOpen(); ?>
<table class="form-table" role="presentation">
<thead>
<tr>
    <th scope="col" class="centered middled"><?php $plugin::te('tickets.form.filter.game'); ?></th>
    <th scope="col" class="centered middled"><?php $plugin::te('tickets.form.filter.result'); ?></th>
    <th scope="col" class="centered middled"><?php $plugin::te('tickets.form.filter.from'); ?></th>
    <th scope="col" class="centered middled"><?php $plugin::te('tickets.form.filter.to'); ?></th>
    <th scope="col" class="centered middled"><?php $plugin::te('tickets.form.filter.status'); ?></th>
    <th scope="col" class="centered middled"><?php $form->htmlKeyEnabled(); ?></th>
</tr>
</thead>
<tbody>
<tr>
    <td class="centered middled">
        <?php $form->htmlGame(); ?>
    </td>
    <td class="centered middled">
        <?php $form->htmlResult(); ?>
    </td>
    <td class="centered middled">
        <?php $form->htmlFrom(); ?>
    </td>
    <td class="centered middled">
        <?php $form->htmlTo(); ?>
    </td>
    <td class="centered middled">
        <?php $form->htmlStatus(); ?>
    </td>
    <td class="centered middled">
        <?php $form->htmlKeyValue(); ?>
    </td>
</tr>
<tr>
    <td class="righted middled" colspan="5">
    </td>
    <td class="centered middled">
        <?php $form->htmlSearch(); ?>
    </td>
</tr>
</tbody>
</table>

<br><br>
<?php $form->htmlRowCount(count($tickets)); ?>
<table class="form-table saw bordered" role="presentation">
    <thead>
    <tr>
        <th scope="col" class="bordered middled centered" style="width: 5%;"><?php $plugin->te('tickets.table.column.status'); ?></th>
        <th scope="col" class="bordered middled centered" style="width: 20%;"><?php $plugin->te('tickets.table.column.user'); ?></th>
        <th scope="col" class="bordered middled centered" style="width: 20%;"><?php $plugin->te('tickets.table.column.game'); ?></th>
        <th scope="col" class="bordered middled centered" style="width: 20%;"><?php $plugin->te('tickets.table.column.prize'); ?></th>
        <th scope="col" class="bordered middled centered" style="width: 15%;"><?php $plugin->te('tickets.table.column.creation'); ?></th>
        <th scope="col" class="bordered middled centered" style="width: 10%;"><?php $plugin->te('tickets.table.column.key'); ?></th>
        <th scope="col" class="bordered middled centered" style="width: 10%;"></th>
    </tr>
    </thead>
    <tbody>

    <?php
    if ( is_array($tickets) && count($tickets)>0 ) {
        for ($n=0; $n<count($tickets); $n++) {
            $item = $tickets[$n];

            $user_email = $item->user_email;
            $game = $item->game;
            $prize = $item->prize != "" ? $item->prize : "---";
            $creation = $item->creation_string;
            $status_icon = $item->status_icon;
            $key = $item->key;

            ?>
            <tr>
                <td class="bordered middled centered"><?php echo sosidee_kses( $status_icon ); ?></td>
                <td class="bordered middled centered"><?php echo esc_html($user_email); ?></td>
                <td class="bordered middled centered"><?php echo esc_html($game); ?></td>
                <td class="bordered middled centered"><?php echo esc_html($prize); ?></td>
                <td class="bordered middled centered"><?php echo esc_html($creation); ?></td>
                <td class="bordered middled centered"><?php echo esc_html($key); ?></td>
                <td class="bordered middled centered"><?php $form->htmlAction( $n ); ?></td>
            </tr>
            <?php }
    } ?>
    </tbody>
</table>

<?php
    $form->htmlClose();
    if ( is_array($tickets) && count($tickets)>0 ) {
        $form->htmlLegend();
    }
?>

</div>