function formatSchoolList(l) {
    if (l.loading)
        return l.text;
    var markup = "<div class='select2-result-repository clearfix'>" +
            "<div class='select2-result-repository__meta'>" +
            "<div class='select2-result-repository__title'>" + l.name + "</div>" +
            "<div class='select2-result-repository__statistics'>" +
            "<div class='select2-result-repository__forks'>" + l.address + ', ' + l.city + "</div>" +
            "</div>" +
            "</div></div>";

    return markup;
}

function formatSchoolSelection(org) {
    return org.name||org.text;
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
    allowClear:true,
    placeholder:'Pilih Sekolah'
};
function formatMasjidList(org) {
    return formatSchoolList(org)
}

function formatMasjidSelection(org) {
    return formatSchoolSelection(org)
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
    allowClear:true,
    placeholder:'Pilih Masjid'
};
