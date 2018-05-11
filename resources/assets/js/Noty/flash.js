/**
 * Created by Edward Lance Lorilla on 5/11/2018.
 */
export default function Flash(text, type){
    return new Noty({
        timeout: 5000,
        theme: 'relax',
        type: type || 'success',
        layout: 'topRight',
        text: text
    }).show();
}