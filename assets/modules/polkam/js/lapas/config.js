
function formatKotakabList(org) {
    return org.kotakab
}

function formatKotakabSelection(org) {
    return org.kotakab || org.text;
}
var kotakab_select_config = {
    ajax: {
        url: base_url + "kotakab/search",
        dataType: 'json',
        delay: 250,
        data: function (params) {
            return {
                term: params.term, // search term
                page: params.page
            };
        },
        processResults: function (data, params) {
            return {
                results: data
            };
        },
        cache: true
    },
    escapeMarkup: function (markup) {
        return markup;
    },
    minimumInputLength: 1, allowClear: true, placeholder: '',
    templateResult: formatKotakabList,
    templateSelection: formatKotakabSelection
};
jQuery(function ($) {
    $('select.kotakab-select2').select2(kotakab_select_config);
})