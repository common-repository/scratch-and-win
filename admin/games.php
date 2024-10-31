<?php
use \SOSIDEE_SAW\SosPlugin;

$plugin = SosPlugin::instance();
$form = $plugin->formSearchGame;
$games = $form->games;

$plugin->htmlTitle('games.page.title');
?>

<div class="wrap">

    <?php settings_errors(); ?>

<?php $form->htmlOpen(); ?>

<table class="form-table" style="width: inherit;" role="presentation">
    <thead>
    <tr>
        <th scope="col" class="centered middled" style=""><?php $form::te('games.form.filter.status'); ?></th>
        <th scope="col" class="centered middled" style=""></th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td class="centered middled" style="">
            <?php $form->htmlStatus(); ?>
        </td>
        <td class="centered middled" style="">
            <?php $form->htmlSearch(); ?>
       </td>
    </tr>
    </tbody>
</table>

<br>
<?php $form->htmlRowCount(count($games)); ?>
<table class="form-table saw bordered" role="presentation">
    <thead>
    <tr>
        <th scope="col" class="bordered middled centered" style="width: 60%;"><?php $form::te('games.table.column.name'); ?></th>
        <th scope="col" class="bordered middled centered" style="width: 10%;"><?php $form::te('games.table.column.status'); ?></th>
        <th scope="col" class="bordered middled centered" style="width: 20%;"><?php $form::te('games.table.column.creation'); ?></th>
        <th scope="col" class="bordered middled centered" style="width: 10%; padding: 0;">
            <?php $form->htmlCreate(); ?>
        </th>
    </tr>
    </thead>
    <tbody>
<?php
if ( is_array($games) && count($games)>0 ) {
    for ($n=0; $n<count($games); $n++) {
        $game = $games[$n];
        $description = $game->description;
        $status_icon = $game->status_icon;
        $creation = sosidee_datetime_format($game->creation);
        $id = $game->game_id;
    ?>
        <tr>
            <td class="bordered middled centered"><?php echo esc_html($description); ?></td>
            <td class="bordered middled centered"><?php echo sosidee_kses($status_icon);?></td>
            <td class="bordered middled centered"><?php echo esc_html($creation); ?></td>
            <td class="bordered middled centered" style="padding: 0;"><?php $form->htmlEdit( $id ); ?></td>
        </tr>
    <?php
    }
} ?>
    </tbody>
</table>

<?php
    $form->htmlClose();
    if ( is_array($games) && count($games)>0 ) {
        $form->htmlLegend();
    }
?>

</div>
