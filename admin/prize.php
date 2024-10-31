<?php
use \SOSIDEE_SAW\SosPlugin;

$plugin = SosPlugin::instance();
$plugin::addMediaLibrary();
$form = $plugin->formEditPrize;

$plugin->htmlTitle('prize.page.title');
?>

<?php if ( $form->game_id->value <= 0 ) {
    echo "<div class=\"wrap\">";
    echo "<p style='color:red;'><strong>" . $plugin::t_('prize.orphan.message') . "</strong></p>";
    echo "<p><a href='" . esc_attr( $plugin->pageGames->url ) . "'><strong>" . $plugin::t_('common.text.click.here') . "</strong></a></p>";
    echo "</div>";
    exit();
} ?>

<div class="wrap">

<?php
    settings_errors();

    $form->htmlRequired();

    $form->htmlOpen();
?>

<table class="form-table" role="presentation">
    <tr>
        <th scope="row" class="middled" style=""><?php $form->htmlFieldName('prize.form.field.name', true); ?></th>
        <td class="" style="width: 600px;"><?php $form->htmlDescription(); ?></td>
        <td class="note" style=""><?php $form::te('prize.form.help.name',['{cn}' => 512]); ?></td>
    </tr>
    <tr>
        <th scope="row" class="middled" style=""><?php $form->htmlFieldName('prize.form.field.cancelled'); ?></th>
        <td class="" style=""><?php $form->htmlCancelled(); ?></td>
        <td class="note" style=""><?php $form::te('prize.form.help.cancelled'); ?></td>
    </tr>
    <tr>
        <th scope="row" class="middled" style=""><?php $form->htmlFieldName('prize.form.field.ticket.total', true); ?></th>
        <td class="" style="middled"><?php $form->htmlTicketMax(); ?></td>
        <td class="note" style=""><?php $form::te('prize.form.help.ticket.total'); ?></td>
    </tr>
    <tr>
        <th scope="row" class="middled" style=""><?php $form->htmlFieldName('prize.form.field.user.wins.max.number'); ?></th>
        <td class="" style="middled"><?php $form->htmlUserWinMax(); ?></td>
        <td class="note" style=""><?php $form::te('prize.form.help.user.wins.max.number'); ?></td>
    </tr>
    <tr>
        <th scope="row" class="middled" style=""><?php $form->htmlFieldName('prize.form.field.win.image', true); ?></th>
        <td class="" style=""><?php $form->htmlImgWin(); ?></td>
        <td class="note" style=""><?php $form::te('prize.form.help.win.image'); ?></td>
    </tr>
    <tr>
        <th scope="row" class="middled" style=""><?php $form->htmlFieldName('prize.form.field.win.text'); ?></th>
        <td class="" style=""><?php $form->htmlTextWin(); ?></td>
        <td class="note" style=""><?php $form::te('prize.form.help.win.text',['{cn}' => 512]); ?></td>
    </tr>
    <tr>
        <th scope="row" class="middled" style=""><?php $form->htmlFieldName('prize.form.field.win.url'); ?></th>
        <td class="" style=""><?php $form->htmlUrlWin(); ?></td>
        <td class="note" style=""><?php $form::te('prize.form.help.win.url'); ?></td>
    </tr>
    <tr>
        <th scope="row" class="middled" style=""><?php $form->htmlFieldName('prize.form.field.win.email.subject'); ?></th>
        <td class="" style=""><?php $form->htmlEmailSubject(); ?></td>
        <td class="note" style=""><?php $form::te('prize.form.help.win.email.subject',['{cn}' => 512]); ?></td>
    </tr>
    <tr>
        <th scope="row" class="middled" style=""><?php $form->htmlFieldName('prize.form.field.win.email.body'); ?></th>
        <td class="" style=""><?php $form->htmlEmailBody(); ?></td>
        <td class="note" style=""><?php $form::te('prize.form.help.win.email.body',['{cn}' => 1024]); ?></td>
    </tr>
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
$form->htmlGameId();
$form->htmlClose();
?>

<br />
<hr />
<br />
<?php $form->htmlButtonBack(); ?>

</div>