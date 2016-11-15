var App = (function () {
    App.markdown = function () {
        'use strict'

        function insert_code(selector, tag1, tag2) {
            var $input = jQuery(selector);
            var input = $input[0];
            input.focus();
            if (typeof document.selection != 'undefined') {
                var range = document.selection.createRange();
                var insText = range.text;
                range.text = tag1 + insText + tag2;
                range = document.selection.createRange();
                if (insText.length == 0) {
                    range.move('character', -tag2.length);
                }
                else {
                    range.moveStart('character', tag1.length + insText.length + tag2.length);
                }
                range.select();
            } else if (typeof input.selectionStart != 'undefined') {
                var start = input.selectionStart;
                var end = input.selectionEnd;
                var insText = input.value.substring(start, end);
                input.value = input.value.substr(0, start) + tag1 + insText + tag2 + input.value.substr(end);
                var pos;
                if (insText.length == 0) {
                    pos = start + tag1.length;
                }
                else {
                    pos = start + tag1.length + insText.length + tag2.length;
                }
                input.selectionStart = pos;
                input.selectionEnd = pos;
            } else {
                var pos;
                var re = new RegExp('^[0-9]{0,3}$');
                while (!re.test(pos)) {
                    pos = prompt("Einfügen an Position (0.." + input.value.length + "):", "0");
                }
                if (pos > input.value.length) {
                    pos = input.value.length;
                }
                var insText = prompt("Bitte geben Sie den zu formatierenden Text ein:");
                input.value = input.value.substr(0, pos) + tag1 + insText + tag2 + input.value.substr(pos);
            }
        }

        jQuery('.twemoji.clickable').on('click', function () {
            var $this = jQuery(this);
            insert_code('textarea.markdown', '', ':'+$this.data('alt')+':');
        });

        jQuery('body').on('change keyup keydown paste cut', 'textarea.markdown', function () {
            var $body = jQuery('body');
            var scrollTop = $body.scrollTop();
            jQuery(this).height(0).height(this.scrollHeight);
            $body.scrollTop(scrollTop);
        }).find('textarea.markdown').change();

    };
    return App;
})(App || {});