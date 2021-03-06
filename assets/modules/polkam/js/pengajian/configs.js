function formatIndividuList(individu) {
    if (individu.loading)
        return individu.text;

    var markup = "<div class='select2-result-repository clearfix'>" +
            "<div class='select2-result-repository__meta'>" +
            "<div class='select2-result-repository__title'>" + individu.individu_name + "</div>";

    if (individu.alias) {
        markup += "<div class='select2-result-repository__description'>Alias : " + individu.alias + "</div>";
    }

    markup += "<div class='select2-result-repository__statistics'>" +
            "<div class='select2-result-repository__forks'>TTL : " + individu.born_place + ', ' + individu.born_date + "</div>" +
            "</div>" +
            "</div></div>";

    return markup;
}

function formatIndividuSelection(repo) {
    return repo.individu_name || repo.alias || repo.text;
}
var individu_select_config = {
    ajax: {
        url: base_url + "individu/search",
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
    templateResult: formatIndividuList,
    templateSelection: formatIndividuSelection,
    allowClear: true,
            placeholder: 'Pilih Individu'
};
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
function formatSchoolList(l) {
    if (l.loading)
        return l.text;
    var markup = "<div class='select2-result-repository clearfix'>" +
            "<div class='select2-result-repository__meta'>" +
            "<div class='select2-result-repository__title'>" + l.school_name + "</div>" +
            "<div class='select2-result-repository__statistics'>" +
            "<div class='select2-result-repository__forks'>" + l.address + ', ' + l.kotakab + "</div>" +
            "</div>" +
            "</div></div>";

    return markup;
}

function formatSchoolSelection(org) {
    return org.school_name || org.text;
}
var school_select_config = {
    ajax: {
        url: base_url + "school/search",
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
    minimumInputLength: 1,
    templateResult: formatSchoolList,
    templateSelection: formatSchoolSelection,
    allowClear: true,
    placeholder: 'Pilih Sekolah'
};
function formatMasjidList(l) {
    if (l.loading)
        return l.text;
    var markup = "<div class='select2-result-repository clearfix'>" +
            "<div class='select2-result-repository__meta'>" +
            "<div class='select2-result-repository__title'>" + l.masjid_name + "</div>" +
            "<div class='select2-result-repository__statistics'>" +
            "<div class='select2-result-repository__forks'>" + l.address + ', ' + l.kotakab + "</div>" +
            "</div>" +
            "</div></div>";

    return markup;
}

function formatMasjidSelection(org) {
    return org.masjid_name || org.text;
}
var masjid_select_config = {
    ajax: {
        url: base_url + "masjid/search",
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
    minimumInputLength: 1,
    templateResult: formatMasjidList,
    templateSelection: formatMasjidSelection,
    allowClear: true,
    placeholder: 'Pilih Masjid'
};
jQuery(function ($) {
    //select2
    $('.individu-select2').select2(individu_select_config);
    $('.masjid-select2').select2(masjid_select_config);
    $('.school-select2').select2(school_select_config);
    $('select.kotakab-select2').select2(kotakab_select_config);
})