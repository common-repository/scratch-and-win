function jsSaW_Select(id, value) {
    let sel = self.document.getElementById( id );
    let custom = true;
    for ( let i = 1; i < sel.length; i++ ) {
        let opt = sel.options[i];
        if ( opt.value.toUpperCase() == value.toUpperCase() ) {
            opt.selected = true;
            custom = false;
            break;
        }
    }
    if ( custom ) {
        sel.options[0].selected = true;
    }
}
function jsSaW_Text( id, value ) {
    self.document.getElementById(id).value = value;
}

function jsSaW_Copy2CB(id)
{
    let msg = '';
    let txt = document.getElementById(id);
    if (txt)
    {
        txt.select();
        txt.setSelectionRange(0, 99999); /* for mobile devices */
        if ( document.execCommand("copy") )
        {
            msg = sos_saw_local.message_text_copied_clipboard + ':\n\n' + txt.value;
        }
        else
        {
            msg = "Your browser didn't copy the shortcode to the clipboard";
        }
        txt.blur();
    }
    else
    {
        msg = "Your browser couldn't copy the shortcode to the clipboard";
    }
    alert(msg);
}

let sos_saw_ml_items = [];

function jsSosSawOpenML( item ) {
    //e.preventDefault();
    if ( !item.frame ) {
        item.frame = jsSosSawCreateFrameML( item.title );
        item.frame.on( 'select', function() {
            let img = item.frame.state().get('selection').first().toJSON(); //element
            if (img.id) {
                let hid = self.document.getElementById(item.tag);
                let pre = self.document.getElementById(item.tag + '_pre');
                if (hid && pre) {
                    hid.value = img.id;
                    if (img.sizes.thumbnail) {
                        pre.src = img.sizes.thumbnail.url;
                    } else {
                        pre.src = img.sizes.full.url;
                    }
                } else {
                    alert("Your browser got a javascript problem.\nfunction: jsSosSawOpenML()");
                }
            } else {
                alert("Your browser had a javascript problem.\nfunction: jsSosSawOpenML()");
            }
        });
    }
    item.frame.open();
}

function jsSosSawCreateFrameML(title) {
    return wp.media({
        title: title,
        library: { type: 'image' },
        button: {
            text: 'ok'
        },
        multiple: 'false'	// 'true' => allows multiple files to be selected via click+CTRL; 'add' => the same but without CTRL key
    });
}

function jsSosSawSelectML(m) {
    if ( !(m in sos_saw_ml_items) ) {
        switch (m)
        {
            case 'cover':
                sos_saw_ml_items[m] = {
                    frame: null,
                    title: sos_saw_local.cover_ml_title,
                    tag: sos_saw_local.cover_image_tag,
                };
                break;
            case 'loss':
                sos_saw_ml_items[m] = {
                    frame: null,
                    title: sos_saw_local.loss_ml_title,
                    tag: sos_saw_local.loss_image_tag,
                };
                break;
            case 'win':
                sos_saw_ml_items[m] = {
                    frame: null,
                    title: sos_saw_local.win_ml_title,
                    tag: sos_saw_local.win_image_tag,
                };
                break;
            case 'coin':
                sos_saw_ml_items[m] = {
                    frame: null,
                    title: sos_saw_local.coin_ml_title,
                    tag: sos_saw_local.coin_image_tag,
                };
                break;
        }
    }
    jsSosSawOpenML( sos_saw_ml_items[m] );
}

function jsSosSawPerc( part, whole, id) {
    let percentage = 100 * part / whole;
    if ( percentage % 1 !== 0 ) {
        if ( percentage >= 1 ) {
            percentage = percentage.toFixed(0);
        } else {
            let str = percentage.toString();
            let arr = str.match(/^0\.(0*)[\d]+$/);
            let dec = arr[1].length + 1;
            percentage = percentage.toFixed(dec);
        }
    }
    let obj = self.document.getElementById(id);
    obj.innerText = percentage;
    if ( percentage > 100 ) {
        obj.style.color = 'red';
    } else {
        obj.style.color = 'inherit';
    }
}

function jsSosSawActionTicket( value, id ) {
    let hid = self.document.getElementById( id );
    if (hid) {
        if ( self.confirm(sos_saw_local.message_confirm_action) ) {
            hid.value = value;
            return true;
        } else {
            return false;
        }
    } else {
        alert("Your browser had a javascript problem.\nfunction: jsSosSawActionTicket()");
        return false;
    }
}
