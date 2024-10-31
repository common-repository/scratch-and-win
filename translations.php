<?php /** @noinspection PhpDuplicateSwitchCaseBodyInspection */
/**
 *
 * THIS FILE MUST BE LOCATED IN THE PLUGIN FOLDER
 *
 *
 * **************************************************************** *
 *                                                                  *
 *  ALL THE STRINGS 'PLUGIN' MUST BE REPLACED WITH THE TEXT DOMAIN  *
 *                                                                  *
 * ******************************************************************
 *
 */
defined( 'SOSIDEE_SAW' ) or die( 'you were not supposed to be here' );

	/** @var string $key is defined in the function SOS\WP\Translation::t_() that includes this file */
	switch( $key ) {
		/*
		case 'example':
            / * translators: [type] description  * /
			return _x( 'key', 'context', 'PLUGIN' );
		*/


    //<editor-fold desc="COMMON">
        case 'common.text.click.here':
            /* translators: [text] text for a button or a link  */
            return _x( 'click here', 'Common', 'scratch-and-win' );

        case 'common.text.legend':
            /* translators: [text] title of the legend  */
            return _x( 'Legend', 'Common', 'scratch-and-win' );

        case 'common.row.count':
            /* translators: [text] title of the legend  */
            return _x( '{count} row(s)', 'Common', 'scratch-and-win' );
    //</editor-fold>

    /*** FRONTEND ***/

    //<editor-fold desc="messages.frontend">

        case 'fe.msg.user.unlogged':
            /* translators: [message] the user is not logged in  */
            return _x( 'You are not logged in. Please sign in to play.', 'Frontend', 'scratch-and-win' );

        case 'fe.msg.game.status.invalid':
            /* translators: [message] invalid game status  */
            return _x( 'The game status is invalid. Please contact the administrator.', 'Frontend', 'scratch-and-win' );

        case 'fe.msg.db.generic.problem':
            /* translators: [message] database generic problem  */
            return _x( 'A problem occurred with the database procedures. Please contact the administrator.', 'Frontend', 'scratch-and-win' );

        case 'fe.msg.generic.problem':
            /* translators: [message] generic problem  */
            return _x( 'A problem occurred. Please contact the administrator.', 'Frontend', 'scratch-and-win' );

    //</editor-fold>


    /*** BACKEND ***/

    //<editor-fold desc="javascript">
        case 'js.message.confirm.action':
            /* translators: [message] user is asked for confirming  */
            return _x( 'Do you confirm to proceed?', 'Backend', 'scratch-and-win' );

        case 'js.message.text.copied.clipboard':
            /* translators: [message] user is asked for confirming  */
            return _x( 'Text copied to the clipboard', 'Backend', 'scratch-and-win' );
    //</editor-fold>

    //<editor-fold desc="media-library">
        case 'js.media-lib.cover.title':
            /* translators: [text] title of WP media library  */
            return _x( 'Select the image for the cover', 'Backend', 'scratch-and-win' );

        case 'js.media-lib.loss.title':
            /* translators: [text] title of WP media library  */
            return _x( 'Select the image for the loss', 'Backend', 'scratch-and-win' );

        case 'js.media-lib.win.title':
            /* translators: [text] title of WP media library  */
            return _x( 'Select the image for the win', 'Backend', 'scratch-and-win' );

        case 'js.media-lib.scratcher.title':
            /* translators: [text] title of WP media library  */
            return _x( 'Select the image for the scratcher', 'Backend', 'scratch-and-win' );
    //</editor-fold>

    //<editor-fold desc="menu">
        case 'menu.item.games':
            /* translators: [text] menu item  */
            return _x( 'Games', 'Backend', 'scratch-and-win' );

        case 'menu.item.tickets':
            /* translators: [text] menu item  */
            return _x( 'Tickets', 'Backend', 'scratch-and-win' );

        case 'menu.item.stats':
            /* translators: [text] menu item  */
            return _x( 'Statistics', 'Backend', 'scratch-and-win' );
    //</editor-fold>

    //<editor-fold desc="pages">
        case 'games.page.title':
            /* translators: [text] title of admin page for searching and listing the games  */
            return _x( 'Games list', 'Backend', 'scratch-and-win' );

        case 'game.page.title':
            /* translators: [text] title of admin page for editing a game  */
            return _x( 'Game', 'Backend', 'scratch-and-win' );

        case 'game.page.title.new':
            /* translators: [text] title of admin page for creating a new game  */
            return _x( 'Game (new)', 'Backend', 'scratch-and-win' );

        case 'prize.page.title':
            /* translators: [text] title of admin page for editing a prize  */
            return _x( 'Prize', 'Backend', 'scratch-and-win' );

        case 'tickets.page.title':
            /* translators: [text] title of admin page for displaying the tickets  */
            return _x( 'Tickets', 'Backend', 'scratch-and-win' );

        case 'stats.page.title':
            /* translators: [text] title of admin page for displaying the statistics  */
            return _x( 'Statistics', 'Backend', 'scratch-and-win' );
    //</editor-fold>


    //<editor-fold desc="messages.admin">
        case 'message.database.empty':
            /* translators: [message] no data found  */
            return _x( 'No data present in the database.', 'Backend', 'scratch-and-win' );

        case 'message.search.data.not.found':
            /* translators: [message] no data found  */
            return _x( 'No results match your search criteria.', 'Backend', 'scratch-and-win' );

        case 'message.search.invalid.ticket.key':
            /* translators: [message] invalid ticket code  */
            return _x( 'Invalid ticket code.', 'Backend', 'scratch-and-win' );

        case 'message.data.saved':
            /* translators: [message] data saved in the database  */
            return _x( 'Data have been successfully saved.', 'Backend', 'scratch-and-win' );

        case 'message.data.inserted':
            /* translators: [message] data inserted in the database  */
            return _x( 'Data have been successfully inserted.', 'Backend', 'scratch-and-win' );

        case 'message.data.deleted':
            /* translators: [message] data deleted from the database  */
            return _x( 'Data have been successfully deleted.', 'Backend', 'scratch-and-win' );

        case 'message.action.performed':
            /* translators: [message] a generic action has been successfully performed  */
            return _x( 'The action has been successfully performed.', 'Backend', 'scratch-and-win' );

        case 'message.generic.problem':
            /* translators: [message] generic problem  */
            return _x( 'A problem occurred.', 'Backend', 'scratch-and-win' );

        case 'message.database.generic.problem':
            /* translators: [message] database generic problem  */
            return _x( 'A problem occurred with the database procedures.', 'Backend', 'scratch-and-win' );

        case 'message.data.delete.virtual':
            /* translators: [message] data impossible to be deleted from the database  */
            return _x( "You can't delete data not present in the database.", 'Backend', 'scratch-and-win' );

        case 'message.game.name.empty':
            /* translators: [message] game field  */
            return _x( "Field 'Name' is empty.", 'Backend', 'scratch-and-win' );

        case 'message.game.status.invalid':
            /* translators: [message] game field  */
            return _x( "Set the 'Status' of the game.", 'Backend', 'scratch-and-win' );

        case 'message.game.ticket.total.invalid':
            /* translators: [message] game field  */
            return _x( 'The total number of tickets must be greater than zero.', 'Backend', 'scratch-and-win' );

        case 'message.game.user.max.invalid':
            /* translators: [message] game field  */
            return _x( 'The maximum number of games per user must be greater than zero.', 'Backend', 'scratch-and-win' );

        case 'message.game.user.time.total.invalid':
            /* translators: [message] game field  */
            return _x( 'The maximum number of games for the selected time unit is invalid: set a number greater than zero.', 'Backend', 'scratch-and-win' );

        case 'message.game.user.time.unit.invalid':
            /* translators: [message] game field  */
            return _x( 'The maximum number of games per time unit is invalid: select the time unit.', 'Backend', 'scratch-and-win' );

        case 'message.game.redirect.timeout.invalid':
            /* translators: [message] game field  */
            return _x( 'Timeout before redirect cannot be less than zero.', 'Backend', 'scratch-and-win' );

        case 'message.game.scratch.percentage.invalid':
            /* translators: [message] game field  */
            return _x( 'The scratch percentage value must be between zero and one hundred.', 'Backend', 'scratch-and-win' );

        case 'message.prize.name.empty':
            /* translators: [message] game field  */
            return _x( "Field 'Name' is empty.", 'Backend', 'scratch-and-win' );

        case 'message.prize.ticket.total.invalid':
            /* translators: [message] invalid number of tickets  */
            return _x( 'The number of winning tickets must be greater than zero.', 'Backend', 'scratch-and-win' );
    //</editor-fold>


    //<editor-fold desc="forms">
        case 'form.button.new.text':
            /* translators: [text] text for a button  */
            return _x( 'new', 'Backend', 'scratch-and-win' );

        case 'form.button.save.text':
            /* translators: [text] text for a button  */
            return _x( 'save', 'Backend', 'scratch-and-win' );

        case 'form.button.search.text':
            /* translators: [text] text for a button  */
            return _x( 'search', 'Backend', 'scratch-and-win' );

        case 'form.button.list.text':
            /* translators: [text] text for a button  */
            return _x( 'list', 'Backend', 'scratch-and-win' );

        case 'form.button.detail.text':
            /* translators: [text] text for a button  */
            return _x( 'details', 'Backend', 'scratch-and-win' );

        case 'form.button.modify.text':
            /* translators: [text] text for a button  */
            return _x( 'modify', 'Backend', 'scratch-and-win' );

        case 'form.button.create.text':
            /* translators: [text] text for a button  */
            return _x( 'create new', 'Backend', 'scratch-and-win' );

        case 'form.button.delete.text':
            /* translators: [text] text for a button  */
            return _x( 'delete', 'Backend', 'scratch-and-win' );

        case 'form.button.delete.question':
            /* translators: [text] text for a button  */
            return _x( 'Deleting?', 'Backend', 'scratch-and-win' );

        case 'form.button.activate.text':
            /* translators: [text] text for a button  */
            return _x( 'activate', 'Backend', 'scratch-and-win' );

        case 'form.button.cancel.text':
            /* translators: [text] text for a button  */
            return _x( 'cancel', 'Backend', 'scratch-and-win' );

        case 'form.field.mandatory':
            /* translators: [text] mandatory field of a form  */
            return _x( 'mandatory field', 'Backend', 'scratch-and-win' );

        case 'form.select.caption.choose':
            /* translators: [text] select items group: pages */
            return _x( '- choose -', 'Backend', 'scratch-and-win' );

        case 'form.select.caption.any':
            /* translators: [text] select items group: pages */
            return _x( '- any -', 'Backend', 'scratch-and-win' );

        case 'form.select.caption.all':
            /* translators: [text] select items group: all  */
            return _x( '- all -', 'Common', 'scratch-and-win' );

        case 'form.select.group.pages':
            /* translators: [text] select items group: pages */
            return _x( 'Pages', 'Backend', 'scratch-and-win' );

        case 'form.select.group.posts':
            /* translators: [text] select items group: posts/articles */
            return _x( 'Posts', 'Backend', 'scratch-and-win' );

        case 'form.field.select.url.customized':
            /* translators: [text] item to select a customized URL  */
            return _x( 'customized URL', 'Backend', 'scratch-and-win' );

        case 'form.message.data.problem':
            /* translators: [message] a problem occurred */
            return _x( 'A problem occurred.', 'Backend', 'scratch-and-win' );

        case 'form.message.data.saved':
            /* translators: [message] data successfully saved */
            return _x( 'Data has been successfully saved.', 'Backend', 'scratch-and-win' );

        case 'form.message.data.inserted':
            /* translators: [message] data successfully inserted */
            return _x( 'Data has been successfully saved.', 'Backend', 'scratch-and-win' );

        case 'form.message.data.not.found':
            /* translators: [message] data not found */
            return _x( 'No data has been found.', 'Backend', 'scratch-and-win' );

        case 'form.message.criteria.unmatched':
            /* translators: [message] data not found */
            return _x( 'No result match your search criteria.', 'Backend', 'scratch-and-win' );
    //</editor-fold>


    //<editor-fold desc="game-searching">
        case 'games.form.filter.status':
            /* translators: [text] form field for game editing */
            return _x( 'Status', 'Backend', 'scratch-and-win' );

        case 'games.table.column.name':
            /* translators: [text] table column of searched games */
            return _x( 'Name', 'Backend', 'scratch-and-win' );

        case 'games.table.column.status':
            /* translators: [text] table column of searched games */
            return _x( 'Status', 'Backend', 'scratch-and-win' );

        case 'games.table.column.creation':
            /* translators: [text] table column of searched games */
            return _x( 'Creation', 'Backend', 'scratch-and-win' );
    //</editor-fold>


    //<editor-fold desc="game-editing">
        case 'game.form.button.delete.question':
            /* translators: [message] question before deleting a game */
            return _x( 'Warning: all the prizes and tickets of this game will be deleted too:\n\nProceed?', 'Backend', 'scratch-and-win' );

        case 'game.form.field.name':
            /* translators: [text] form field for game editing */
            return _x( 'Name', 'Backend', 'scratch-and-win' );

        case 'game.form.field.status':
            /* translators: [text] form field for game editing */
            return _x( 'Status', 'Backend', 'scratch-and-win' );

        case 'game.status.active':
            /* translators: [text] item of game status */
            return _x( 'active', 'Backend', 'scratch-and-win' );

        case 'game.status.test':
            /* translators: [text] item of game status */
            return _x( 'test', 'Backend', 'scratch-and-win' );

        case 'game.status.archived':
            /* translators: [text] item of game status */
            return _x( 'archived', 'Backend', 'scratch-and-win' );

        case 'game.form.field.ticket.total':
            /* translators: [text] form field for game editing */
            return _x( 'Total number of tickets', 'Backend', 'scratch-and-win' );

        case 'game.form.field.end.text':
            /* translators: [text] form field for game editing */
            return _x( 'Game over text', 'Backend', 'scratch-and-win' );

        case 'game.form.field.end.url':
            /* translators: [text] form field for game editing */
            return _x( 'Game over URL', 'Backend', 'scratch-and-win' );

        case 'game.form.field.endless':
            /* translators: [text] form field for game editing */
            return _x( 'Endless game', 'Backend', 'scratch-and-win' );

        case 'game.form.field.endless.text':
            /* translators: [text] form field for game editing */
            return _x( 'disable the end of the game', 'Backend', 'scratch-and-win' );

        case 'game.form.field.cover.image':
            /* translators: [text] form field for game editing */
            return _x( 'Cover image', 'Backend', 'scratch-and-win' );

        case 'game.form.field.loss.image':
            /* translators: [text] form field for game editing */
            return _x( 'Loss image', 'Backend', 'scratch-and-win' );

        case 'game.form.field.loss.text':
            /* translators: [text] form field for game editing */
            return _x( 'Loss text', 'Backend', 'scratch-and-win' );

        case 'game.form.field.loss.url':
            /* translators: [text] form field for game editing */
            return _x( 'Loss URL', 'Backend', 'scratch-and-win' );

        case 'game.form.field.images.size':
            /* translators: [text] form field for game editing */
            return _x( 'Images size', 'Backend', 'scratch-and-win' );

        case 'game.form.field.images.size.auto':
            /* translators: [text] form field for game editing */
            return _x( 'calculate automatically', 'Backend', 'scratch-and-win' );

        case 'game.form.field.images.css':
            /* translators: [text] form field for game editing */
            return _x( 'Images CSS class', 'Backend', 'scratch-and-win' );

        case 'game.form.field.scratcher':
            /* translators: [text] form field for game editing */
            return _x( 'Scratcher', 'Backend', 'scratch-and-win' );

        case 'game.form.field.scratching.percentage':
            /* translators: [text] form field for game editing */
            return _x( 'Scratching percentage', 'Backend', 'scratch-and-win' );

        case 'game.form.field.user.plays.max.number':
            /* translators: [text] form field for game editing */
            return _x( "User's max plays", 'Backend', 'scratch-and-win' );

        case 'game.form.field.user.plays.max.text':
            /* translators: [text] form field for game editing */
            return _x( "Text for user's max plays", 'Backend', 'scratch-and-win' );

        case 'game.form.field.user.plays.max.url':
            /* translators: [text] form field for game editing */
            return _x( "URL for user's max plays", 'Backend', 'scratch-and-win' );

        case 'game.form.field.user.plays.time.max.number':
            /* translators: [text] form field for game editing */
            return _x( "User's max plays by time unit", 'Backend', 'scratch-and-win' );

        case 'game.form.field.user.plays.time.max.text':
            /* translators: [text] form field for game editing */
            return _x( "Text for user's max plays by time unit", 'Backend', 'scratch-and-win' );

        case 'game.form.field.user.plays.time.max.url':
            /* translators: [text] form field for game editing */
            return _x( "URL for user's max plays by time unit", 'Backend', 'scratch-and-win' );

        case 'game.form.field.user.plays.time.max.times':
            /* translators: [text] form field for game editing */
            return _x( '&nbsp; times &nbsp;', 'Backend', 'scratch-and-win' );

        case 'game.user.time.max.unit.hour':
            /* translators: [text] select item for user's max games by time unit */
            return _x( 'per hour', 'Backend', 'scratch-and-win' );

        case 'game.user.time.max.unit.day':
            /* translators: [text] select item for user's max games by time unit */
            return _x( 'per day (24 hours)', 'Backend', 'scratch-and-win' );

        case 'game.user.time.max.unit.week':
            /* translators: [text] select item for user's max games by time unit */
            return _x( 'per week (7 days)', 'Backend', 'scratch-and-win' );

        case 'game.form.field.ticket.key':
            /* translators: [text] form field for game editing */
            return _x( 'Ticket code', 'Backend', 'scratch-and-win' );

        case 'game.form.field.ticket.key.show':
            /* translators: [text] label of the form field for game editing */
            return _x( 'display the code', 'Backend', 'scratch-and-win' );

        case 'game.form.field.url.random.qs':
            /* translators: [text] form field for game editing */
            return _x( 'Random query-string', 'Backend', 'scratch-and-win' );

        case 'game.form.field.url.random.qs.add':
            /* translators: [text] label of the form field for game editing */
            return _x( 'add to redirecting URL(s)', 'Backend', 'scratch-and-win' );

        case 'game.form.field.email.winner':
            /* translators: [text] form field for game editing */
            return _x( 'Email to winner(s)', 'Backend', 'scratch-and-win' );

        case 'game.form.field.email.winner.disabled':
            /* translators: [text] form field for game editing */
            return _x( 'disable', 'Backend', 'scratch-and-win' );

        case 'game.form.field.redirect.timeout':
            /* translators: [text] form field for game editing */
            return _x( 'Timeout before redirecting', 'Backend', 'scratch-and-win' );

        case 'game.form.field.anonymous':
            /* translators: [text] form field for game editing */
            return _x( 'Anonymous users', 'Backend', 'scratch-and-win' );

        case 'game.form.field.anonymous.enabled':
            /* translators: [text] form field for game editing */
            return _x( 'enable to play', 'Backend', 'scratch-and-win' );

        case 'game.form.field.shortcode':
            /* translators: [text] form field for game editing */
            return _x( 'Shortcode', 'Backend', 'scratch-and-win' );

        case 'game.form.field.shortcode.tooltip':
            /* translators: [text] form field for game editing */
            return _x( 'copy to the clipboard', 'Backend', 'scratch-and-win' );

        case 'game.form.help.name':
            /* translators: [text] game field help */
            return _x( 'Game denomination in the administration dashboard.<br>(max {cn} chars)', 'Backend', 'scratch-and-win' );

        case 'game.form.help.status.title':
            /* translators: [text] game field help */
            return _x( 'Status of the game', 'Backend', 'scratch-and-win' );

        case 'game.form.help.status.active':
            /* translators: [text] game field help */
            return _x( 'working game', 'Backend', 'scratch-and-win' );

        case 'game.form.help.status.test':
            /* translators: [text] game field help */
            return _x( 'tickets are drawn but not saved in the database (game simulation)', 'Backend', 'scratch-and-win' );

        case 'game.form.help.status.archived':
            /* translators: [text] game field help */
            return _x( 'disabled game', 'Backend', 'scratch-and-win' );

        case 'game.form.help.ticket.total':
            /* translators: [text] game field help */
            return _x( 'Total (winning + not winning) number of tickets.', 'Backend', 'scratch-and-win' );

        case 'game.form.help.end.text':
            /* translators: [text] game field help */
            return _x( 'Text that appears to users when the game is over (all tickets have been drawn).<br>(max {cn} chars)', 'Backend', 'scratch-and-win' );

        case 'game.form.help.end.url':
            /* translators: [text] game field help */
            return _x( 'URL to which users are redirected when the game is over.', 'Backend', 'scratch-and-win' );

        case 'game.form.help.endless':
            /* translators: [text] game field help */
            return _x( 'The drawn tickets are replaced by new ones, and the game never ends (the probability of winning always remains the same).', 'Backend', 'scratch-and-win' );

        case 'game.form.help.cover.image':
            /* translators: [text] game field help */
            return _x( 'Image displayed at the start of the game, covering either the prize won or the "Loss image".', 'Backend', 'scratch-and-win' );

        case 'game.form.help.loss.image':
            /* translators: [text] game field help */
            return _x( 'Image that is discovered in case of no win.', 'Backend', 'scratch-and-win' );

        case 'game.form.help.loss.text':
            /* translators: [text] game field help */
            return _x( "Text that appears to a user when he hasn't won.<br>(max {cn} chars)", 'Backend', 'scratch-and-win' );

        case 'game.form.help.loss.url':
            /* translators: [text] game field help */
            return _x( "URL to which a user is redirected when he hasn't won.", 'Backend', 'scratch-and-win' );

        case 'game.form.help.images.size':
            /* translators: [text] game field help */
            return _x( 'The height and width of the displayed images are set automatically.<br><strong>N.B.</strong> The "Cover" and "Loss" images must be the same size.', 'Backend', 'scratch-and-win' );

        case 'game.form.help.images.css':
            /* translators: [text] game field help */
            return _x( 'Name of a CSS class that customizes the style (e.g. size, border, etc.) of the "cover", "win" and "loss" images.', 'Backend', 'scratch-and-win' );

        case 'game.form.help.scratcher':
            /* translators: [text] game field help */
            return _x( 'Image that appears as a pointer when the mouse/finger is on the cover image (the scratcher size is calculated automatically).', 'Backend', 'scratch-and-win' );

        case 'game.form.help.scratching.percentage':
            /* translators: [text] game field help */
            return _x( 'Percentage value of the cover image scratched by the user, after which the result (i.e. win or loss) image appears immediately.', 'Backend', 'scratch-and-win' );

        case 'game.form.help.user.plays.max.number':
            /* translators: [text] game field help */
            return _x( 'Maximum number of total plays (winning and not) that a user can make in this game.<br>Set <strong>0</strong> (zero) to mean "no limit".', 'Backend', 'scratch-and-win' );

        case 'game.form.help.user.plays.max.text':
            /* translators: [text] game field help */
            return _x( 'Text that appears when a user has exceeded the maximum number of plays allowed in this game.<br>(max {cn} chars)', 'Backend', 'scratch-and-win' );

        case 'game.form.help.user.plays.max.url':
            /* translators: [text] game field help */
            return _x( 'URL to which a user is redirected when he has exceeded the maximum number of plays allowed in this game.', 'Backend', 'scratch-and-win' );

        case 'game.form.help.user.plays.time.max.number':
            /* translators: [text] game field help */
            return _x( 'Maximum number of times a user can play this game in a given time unit.<br>Set <strong>0</strong> (zero) to mean "no limit".', 'Backend', 'scratch-and-win' );

        case 'game.form.help.user.plays.time.max.text':
            /* translators: [text] game field help */
            return _x( 'Text that appears when a user has exceeded the maximum number of plays allowed in the configured time unit for this game.<br>(max {cn} chars)', 'Backend', 'scratch-and-win' );

        case 'game.form.help.user.plays.time.max.url':
            /* translators: [text] game field help */
            return _x( 'URL to which a user is redirected when he has exceeded the maximum number of plays allowed in the configured time unit for this game.', 'Backend', 'scratch-and-win' );

        case 'game.form.help.email.winner':
            /* translators: [text] game field help */
            return _x( 'Check the box to NOT send the prize email to the winners.', 'Backend', 'scratch-and-win' );

        case 'game.form.help.redirect.timeout':
            /* translators: [text] game field help */
            return _x( 'Number of seconds to wait between the end of the game (fully scratched cover image) and the redirect (if set) to a page URL.', 'Backend', 'scratch-and-win' );

        case 'game.form.help.anonymous':
            /* translators: [text] game field help */
            return _x( 'ATTENTION: the limits on the maximum number of plays do not apply to anonymous (not logged in) users, and the email cannot be sent to winners.', 'Backend', 'scratch-and-win' );

        case 'game.form.help.ticket.key':
            /* translators: [text] game field help */
            return _x( 'The ticket code will be displayed just below the cover.', 'Backend', 'scratch-and-win' );

        case 'game.form.help.url.random.qs':
            /* translators: [text] game field help */
            return _x( 'It should/could help to prevent redirecting to cached pages.', 'Backend', 'scratch-and-win' );

        case 'game.form.help.shortcode':
            /* translators: [text] game field help */
            return _x( 'Click on the {icon} button to copy the <strong>shortcode</strong> to the clipboard and the insert it in the page or article in which to display the game.', 'Backend', 'scratch-and-win' );

    //</editor-fold>


    //<editor-fold desc="prizes-listing">
        case 'game.prizes.table.title':
            /* translators: [text] table column of listed prizes of a game */
            return _x( 'Prizes list', 'Backend', 'scratch-and-win' );

        case 'game.prizes.table.column.name':
            /* translators: [text] table column of listed prizes of a game */
            return _x( 'Name', 'Backend', 'scratch-and-win' );

        case 'game.prizes.table.column.status':
            /* translators: [text] table column of listed prizes of a game */
            return _x( 'Status', 'Backend', 'scratch-and-win' );

        case 'game.prizes.table.column.tickets.total':
            /* translators: [text] table column of listed prizes of a game */
            return _x( 'Tickets', 'Backend', 'scratch-and-win' );

        case 'game.prizes.table.column.tickets.drawn':
            /* translators: [text] table column of listed prizes of a game */
            return _x( 'Drawn', 'Backend', 'scratch-and-win' );

        case 'game.prizes.table.column.creation':
            /* translators: [text] table column of listed prizes of a game */
            return _x( 'Creation', 'Backend', 'scratch-and-win' );

        case 'game.prizes.table.row.total':
            /* translators: [text] table row label for the total values of the prizes columns (edit game page) */
            return _x( 'Total', 'Backend', 'scratch-and-win' );
    //</editor-fold>


    //<editor-fold desc="prize-editing">
        case 'prize.form.button.delete.question':
            /* translators: [message] question before deleting a prize */
            return _x( 'Warning: all the tickets winning this prize will be deleted too:\n\nProceed?', 'Backend', 'scratch-and-win' );

        case 'prize.form.button.back.game':
            /* translators: [text] text for a button  */
            return _x( 'back to the game', 'Backend', 'scratch-and-win' );

        case 'prize.orphan.message':
            /* translators: [message] prize not associated to a game (error) */
            return _x( 'Warning: this prize is not associated to any game.', 'Backend', 'scratch-and-win' );

        case 'prize.form.field.name':
            /* translators: [text] form field for prize editing */
            return _x( 'Name', 'Backend', 'scratch-and-win' );

        case 'prize.form.field.cancelled':
            /* translators: [text] form field for prize editing */
            return _x( 'Disabled', 'Backend', 'scratch-and-win' );

        case 'prize.form.field.cancelled.text':
            /* translators: [text] form field for prize editing */
            return _x( 'disable this prize', 'Backend', 'scratch-and-win' );

        case 'prize.form.field.ticket.total':
            /* translators: [text] form field for prize editing */
            return _x( 'Total number of winning tickets', 'Backend', 'scratch-and-win' );

        case 'prize.form.field.ticket.percentage':
            /* translators: [text] form field for prize editing */
            return _x( 'winning odds', 'Backend', 'scratch-and-win' );

        case 'prize.form.field.user.wins.max.number':
            /* translators: [text] form field for prize editing */
            return _x( "User's max wins", 'Backend', 'scratch-and-win' );

        case 'prize.form.field.win.image':
            /* translators: [text] form field for prize editing */
            return _x( 'Win image', 'Backend', 'scratch-and-win' );

        case 'prize.form.field.win.text':
            /* translators: [text] form field for prize editing */
            return _x( 'Win text', 'Backend', 'scratch-and-win' );

        case 'prize.form.field.win.url':
            /* translators: [text] form field for prize editing */
            return _x( 'Win URL', 'Backend', 'scratch-and-win' );

        case 'prize.form.field.win.email.subject':
            /* translators: [text] form field for prize editing */
            return _x( 'Win email subject', 'Backend', 'scratch-and-win' );

        case 'prize.form.field.win.email.body':
            /* translators: [text] form field for prize editing */
            return _x( 'Win email message', 'Backend', 'scratch-and-win' );


        case 'prize.status.active':
            /* translators: [text] item of prize status */
            return _x( 'enabled', 'Backend', 'scratch-and-win' );

        case 'prize.status.cancelled':
            /* translators: [text] item of prize status */
            return _x( 'disabled', 'Backend', 'scratch-and-win' );

        case 'prize.form.help.name':
            /* translators: [text] prize field help */
            return _x( 'Prize denomination in Wordpress administration console.<br>(max {cn} chars)', 'Backend', 'scratch-and-win' );

        case 'prize.form.help.cancelled':
            /* translators: [text] item of prize status */
            return _x( 'If disabled, this prize will not taken into consideration during the tickets extraction.', 'Backend', 'scratch-and-win' );

        case 'prize.form.help.ticket.total':
            /* translators: [text] item of prize status */
            return _x( 'Number of tickets associated with the prize (it cannot be greater than the total number of tickets in the game). The percentage value represents the probability of winning at the start of the game.', 'Backend', 'scratch-and-win' );

        case 'prize.form.help.user.wins.max.number':
            /* translators: [text] item of prize status */
            return _x( 'Maximum number of times a user can win this prize.<br>Set <strong>0</strong> (zero) to mean "no limit".', 'Backend', 'scratch-and-win' );

        case 'prize.form.help.win.image':
            /* translators: [text] prize field help */
            return _x( 'Image that is discovered in case of no win.<br><strong>NB</strong> Must be the same size as this game\'s "Cover image".', 'Backend', 'scratch-and-win' );

        case 'prize.form.help.win.text':
            /* translators: [text] prize field help */
            return _x( 'Text that appears to a user when he has won and the "Win image" is completely uncovered.<br>(max {cn} chars)', 'Backend', 'scratch-and-win' );

        case 'prize.form.help.win.url':
            /* translators: [text] game field help */
            return _x( 'URL to which a user is redirected when he has won.', 'Backend', 'scratch-and-win' );

        case 'prize.form.help.win.email.subject':
            /* translators: [text] game field help */
            return _x( 'Subject of the email sent to users when they have won.<br>(max {cn} chars)', 'Backend', 'scratch-and-win' );

        case 'prize.form.help.win.email.body':
            /* translators: [text] game field help */
            return _x( 'Message of the email sent to users when they have won.<br>(max {cn} chars)', 'Backend', 'scratch-and-win' );

    //</editor-fold>


    //<editor-fold desc="tickets">

        case 'tickets.form.filter.game':
            /* translators: [text] form field for tickets searching */
            return _x( 'Game', 'Backend', 'scratch-and-win' );

        case 'tickets.form.filter.result':
            /* translators: [text] form field for tickets searching */
            return _x( 'Result', 'Backend', 'scratch-and-win' );

        case 'tickets.form.filter.from':
            /* translators: [text] form field for tickets searching */
            return _x( 'From', 'Backend', 'scratch-and-win' );

        case 'tickets.form.filter.to':
            /* translators: [text] form field for tickets searching */
            return _x( 'To', 'Backend', 'scratch-and-win' );

        case 'tickets.form.filter.status':
            /* translators: [text] form field for tickets searching */
            return _x( 'Status', 'Backend', 'scratch-and-win' );

        case 'tickets.status.valid.only':
            /* translators: [text] select item for tickets searching */
            return _x( 'only valid', 'Backend', 'scratch-and-win' );

        case 'tickets.status.cancelled.only':
            /* translators: [text] item of ticket status */
            return _x( 'only cancelled', 'Backend', 'scratch-and-win' );

        case 'ticket.status.valid':
            /* translators: [text] item of ticket status */
            return _x( 'valid', 'Backend', 'scratch-and-win' );

        case 'ticket.status.cancelled':
            /* translators: [text] item of ticket status */
            return _x( 'cancelled', 'Backend', 'scratch-and-win' );

        case 'tickets.result.win.only':
            /* translators: [text] select item for tickets searching */
            return _x( 'only wins', 'Backend', 'scratch-and-win' );

        case 'tickets.result.loss.only':
            /* translators: [text] item of ticket status */
            return _x( 'only losses', 'Backend', 'scratch-and-win' );

        case 'tickets.table.column.status':
            /* translators: [text] table column of listed tickets  */
            return _x( 'Status', 'Backend', 'scratch-and-win' );

        case 'tickets.table.column.user':
            /* translators: [text] table column of listed tickets  */
            return _x( 'User', 'Backend', 'scratch-and-win' );

        case 'tickets.table.column.game':
            /* translators: [text] table column of listed tickets  */
            return _x( 'Game', 'Backend', 'scratch-and-win' );

        case 'tickets.table.column.prize':
            /* translators: [text] table column of listed tickets  */
            return _x( 'Prize', 'Backend', 'scratch-and-win' );

        case 'tickets.table.column.key':
            /* translators: [text] table column of listed tickets  */
            return _x( 'Code', 'Backend', 'scratch-and-win' );

        case 'tickets.table.column.creation':
            /* translators: [text] table column of listed tickets  */
            return _x( 'Date', 'Backend', 'scratch-and-win' );

        case 'tickets.form.filter.key.enable':
            /* translators: [text] enable this form field for tickets searching */
            return _x( 'filter by ticket code:', 'Backend', 'scratch-and-win' );
    //</editor-fold>


    //<editor-fold desc="stats">
        case 'stats.game.status.active.only':
            /* translators: [text] select item for game stats searching */
            return _x( 'only active', 'Backend', 'scratch-and-win' );

        case 'stats.game.status.test.only':
            /* translators: [text] select item for game stats searching */
            return _x( 'only test', 'Backend', 'scratch-and-win' );

        case 'stats.game.status.archived.only':
            /* translators: [text] select item for game stats searching */
            return _x( 'only archived', 'Backend', 'scratch-and-win' );

        case 'stats.form.filter.game.status':
            /* translators: [text] select item for game stats searching */
            return _x( 'Game status', 'Backend', 'scratch-and-win' );

        case 'stats.table.column.games':
            /* translators: [text] table column of listed games  */
            return _x( 'Games', 'Backend', 'scratch-and-win' );

        case 'stats.table.column.tickets':
            /* translators: [text] table column of listed games  */
            return _x( 'Tickets', 'Backend', 'scratch-and-win' );

        case 'stats.table.column.game.status':
            /* translators: [text] table column of listed games  */
            return _x( 'Status', 'Backend', 'scratch-and-win' );

        case 'stats.table.column.game.name':
            /* translators: [text] table column of listed games  */
            return _x( 'Name', 'Backend', 'scratch-and-win' );

        case 'stats.table.column.ticket.total':
            /* translators: [text] table column of listed games  */
            return _x( 'Total', 'Backend', 'scratch-and-win' );

        case 'stats.table.column.ticket.used':
            /* translators: [text] table column of listed games  */
            return _x( 'Drawn', 'Backend', 'scratch-and-win' );

        case 'stats.table.column.ticket.win':
            /* translators: [text] table column of listed games  */
            return _x( 'Winning', 'Backend', 'scratch-and-win' );

        case 'stats.table.row.game.name':
            /* translators: [text] table row of game  */
            return _x( 'Game', 'Backend', 'scratch-and-win' );

        case 'stats.table.row.game.status':
            /* translators: [text] table row of game  */
            return _x( 'Status', 'Backend', 'scratch-and-win' );

        case 'stats.table.row.ticket.total':
            /* translators: [text] table row of game  */
            return _x( 'Total tickets', 'Backend', 'scratch-and-win' );

        case 'stats.table.row.ticket.prized':
            /* translators: [text] table row of game  */
            return _x( 'Prize tickets', 'Backend', 'scratch-and-win' );

        case 'stats.table.row.ticket.used':
            /* translators: [text] table row of game  */
            return _x( 'Drawn tickets', 'Backend', 'scratch-and-win' );

        case 'stats.table.row.ticket.win':
            /* translators: [text] table row of game  */
            return _x( 'Winning tickets', 'Backend', 'scratch-and-win' );

        case 'stats.table.row.prize.name':
            /* translators: [text] table row of game  */
            return _x( 'Prize', 'Backend', 'scratch-and-win' );

        case 'stats.table.row.prize.status':
            /* translators: [text] table row of game  */
            return _x( 'Status', 'Backend', 'scratch-and-win' );

        case 'stats.table.row.prize.ticket.total':
            /* translators: [text] table row of game  */
            return _x( 'Tickets', 'Backend', 'scratch-and-win' );

        case 'stats.table.row.prize.ticket.used':
            /* translators: [text] table row of game  */
            return _x( 'Drawn', 'Backend', 'scratch-and-win' );



        //</editor-fold>


    //<editor-fold desc="legend">
        case 'legend.game.status':
            /* translators: [text] legend section */
            return _x( 'Game status', 'Backend', 'scratch-and-win' );

        case 'legend.prize.status':
            /* translators: [text] legend section */
            return _x( 'Prize status', 'Backend', 'scratch-and-win' );

        case 'legend.ticket.status':
            /* translators: [text] legend section */
            return _x( 'Ticket status', 'Backend', 'scratch-and-win' );
    //</editor-fold>


    /* DO NOT ELIMINATE THE FOLLOWING CASES */

    //<editor-fold desc="metabox">
        case 'SOSIDEE_SAW\SOS\WP\MetaBox::callbackSave::nonce-empty':
            /* translators: [message] problem (empty nonce) while checking the metabox data */
            return _x('A security problem (empty nonce) occurred while checking a metabox data', 'Backend', 'scratch-and-win');
        case 'SOSIDEE_SAW\SOS\WP\MetaBox::callbackSave::nonce-invalid':
            /* translators: [message] problem (invalid nonce) while checking the metabox data */
            return _x('A security problem (invalid nonce) occurred while checking a metabox data', 'Backend', 'scratch-and-win');
        case 'SOSIDEE_SAW\SOS\WP\MetaBox::callbackSave::user-unauthorized':
            /* translators: [message] the user has insufficient rights to save the metabox data */
            return _x("You're not authorized to modify a metabox data", 'Backend', 'scratch-and-win');

		case 'Translator':
			/* translators: User role for subscribers. */
			return _x( 'Translator', 'User role', 'scratch-and-win' );
    //</editor-fold>

		//DEFAULT DOMAIN

    //<editor-fold desc="user-roles">
		case 'Administrator':
			/* translators: User role for administrators. */
			return _x( 'Administrator', 'User role' );
		case 'Editor':
			/* translators: User role for editors. */
			return _x( 'Editor', 'User role' );
		case 'Author':
			/* translators: User role for authors. */
			return _x( 'Author', 'User role' );
		case 'Contributor':
			/* translators: User role for contributors. */
			return _x( 'Contributor', 'User role' );
		case 'Subscriber':
			/* translators: User role for subscribers. */
			return _x( 'Subscriber', 'User role' );
    //</editor-fold>

		default:
			return $key; //the key has not be handled
	}
