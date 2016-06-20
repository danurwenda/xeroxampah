
var tagBody = '(?:[^"\'>]|"[^"]*"|\'[^\']*\')*';

var tagOrComment = new RegExp(
        '<(?:'
        // Comment body.
        + '!--(?:(?:-*[^->])*--+|-?)'
        // Special "raw text" elements whose content should be elided.
        + '|script\\b' + tagBody + '>[\\s\\S]*?</script\\s*'
        + '|style\\b' + tagBody + '>[\\s\\S]*?</style\\s*'
        // Regular name
        + '|/?[a-z]'
        + tagBody
        + ')>',
        'gi');
function removeTags(html) {
    var oldHtml;
    do {
        oldHtml = html;
        html = html.replace(tagOrComment, '');
    } while (html !== oldHtml);
    return html.replace(/</g, '&lt;');
}
//enable select2 on bootstrap modal
//https://github.com/select2/select2/issues/1436
jQuery(function ($) {
    $(document)
            .one('focus.textarea', '.autoExpand', function () {
                var savedValue = this.value;
                this.value = '';
                this.baseScrollHeight = this.scrollHeight;
                this.value = savedValue;
            })
            .on('input.textarea', '.autoExpand', function () {
                var minRows = this.getAttribute('data-min-rows') | 0,
                        rows;
                this.rows = minRows;
                console.log(this.scrollHeight, this.baseScrollHeight);
                rows = Math.ceil((this.scrollHeight - this.baseScrollHeight) / 17);
                this.rows = minRows + rows;
            });
    $.fn.modal.Constructor.prototype.enforceFocus = function () {};
})