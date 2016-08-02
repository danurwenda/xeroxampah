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
var male_select_config = {
    ajax: {
        url: base_url + "individu/search",
        dataType: 'json',
        delay: 250,
        data: function (params) {
            return {
                gender: 'Laki-laki',
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
    allowClear:true,
            placeholder:'',
            templateResult: formatIndividuList,
    templateSelection: formatIndividuSelection
};
var female_select_config = {
    ajax: {
        url: base_url + "individu/search",
        dataType: 'json',
        delay: 250,
        data: function (params) {
            return {
                gender: 'Perempuan',
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
    templateSelection: formatIndividuSelection
};
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
    templateSelection: formatIndividuSelection
};
function formatNonTerorList(nt) {
    if (nt.loading)
        return nt.text;
    var markup = "<div class='select2-result-repository clearfix'>" +
            "<div class='select2-result-repository__meta'>" +
            "<div class='select2-result-repository__title'>" + nt.pidana + ' ' + nt.korban + "</div>";

    if (nt.nilai) {
        markup += "<div class='select2-result-repository__description'>Nilai : " + nt.nilai + "</div>";
    }

    markup += "<div class='select2-result-repository__statistics'>" +
            "<div class='select2-result-repository__forks'>" + nt.tempat + ', ' + nt.tanggal + "</div>" +
            "</div>" +
            "</div></div>";

    return markup;
}

function formatNonTerorSelection(nt) {
    return nt.pidana ? (nt.pidana + ' ' + nt.korban) : nt.text;
}
var nonteror_select_config = {
    ajax: {
        url: base_url + "nonteror/search",
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
    templateResult: formatNonTerorList,
    templateSelection: formatNonTerorSelection
};
function formatLatsenList(nt) {
    if (nt.loading)
        return nt.text;
    var markup = "<div class='select2-result-repository clearfix'>" +
            "<div class='select2-result-repository__meta'>" +
            "<div class='select2-result-repository__title'>" + nt.materi + "</div>";



    markup += "<div class='select2-result-repository__statistics'>" +
            "<div class='select2-result-repository__forks'>" + nt.tempat + (nt.kotakab ? ', ' + nt.kotakab : '') + (nt.sejak ? ("," + nt.sejak) : '') + "</div>" +
            "</div>" +
            "</div></div>";

    return markup;
}

function formatLatsenSelection(nt) {
    return nt.materi ? (nt.materi + ' di ' + nt.tempat) : nt.text;
}
var latsen_select_config = {
    ajax: {
        url: base_url + "latsen/search",
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
    templateResult: formatLatsenList,
    templateSelection: formatLatsenSelection
};

function formatLatihanSelection(nt) {
    return nt.materi ? (nt.materi + ' di ' + nt.tempat) : nt.text;
}
var latihan_select_config = {
    ajax: {
        url: base_url + "latihan/search",
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
    templateResult: formatLatsenList,
    templateSelection: formatLatihanSelection
};
function formatTerorList(nt) {
    if (nt.loading)
        return nt.text;
    var markup = "<div class='select2-result-repository clearfix'>" +
            "<div class='select2-result-repository__meta'>" +
            "<div class='select2-result-repository__title'>" + nt.serangan + ' ' + nt.sasaran + "</div>";



    markup += "<div class='select2-result-repository__statistics'>" +
            "<div class='select2-result-repository__forks'>" + nt.tempat + ', ' + nt.tanggal + "</div>" +
            "</div>" +
            "</div></div>";

    return markup;
}

function formatTerorSelection(nt) {
    return nt.serangan ? (nt.serangan + ' ' + nt.sasaran) : nt.text;
}
var teror_select_config = {
    ajax: {
        url: base_url + "teror/search",
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
    templateResult: formatTerorList,
    templateSelection: formatTerorSelection
};
function formatLapasList(l) {
    if (l.loading)
        return l.text;
    var markup = "<div class='select2-result-repository clearfix'>" +
            "<div class='select2-result-repository__meta'>" +
            "<div class='select2-result-repository__title'>" + l.name + "</div>" +
            "<div class='select2-result-repository__statistics'>" +
            "<div class='select2-result-repository__forks'>" + l.address + ', ' + l.kotakab + "</div>" +
            "</div>" +
            "</div></div>";

    return markup;
}
function formatLapasSelection(l) {
    return l.name || l.text;
}
var lapas_select_config = {
    ajax: {
        url: base_url + "lapas/search",
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
    templateResult: formatLapasList,
    templateSelection: formatLapasSelection
};
function formatOrganisasiList(org) {
    if (org.loading)
        return org.text;
    var markup = "<div class='select2-result-repository clearfix'>" +
            "<div class='select2-result-repository__meta'>" +
            "<div class='select2-result-repository__title'>" + org.name + ", " + org.daerah + "</div>" +
            "</div></div>";

    return markup;
}

function formatOrganisasiSelection(org) {
    var r;
    if (org.name) {
        r = org.name;
        if (org.daerah)
            r += ', ' + org.daerah;
    } else
        r = org.text;
    return r
}
var organisasi_select_config = {
    ajax: {
        url: base_url + "organisasi/search",
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
    templateResult: formatOrganisasiList,
    templateSelection: formatOrganisasiSelection
};
function formatPengajianList(ngaji) {
    if (ngaji.loading)
        return ngaji.text;
    var markup = "<div class='select2-result-repository clearfix'>" +
            "<div class='select2-result-repository__meta'>" +
            "<div class='select2-result-repository__title'>" + ngaji.topik + "</div>" +
            (ngaji.lokasi ? ("<div class='select2-result-repository__title'>" + ngaji.lokasi + "</div>") : '') +
            "</div></div>";

    return markup;
}

function formatPengajianSelection(org) {
    return (org.topik ? (org.topik + ' di ' + org.lokasi) : org.text);
}
var pengajian_select_config = {
    ajax: {
        url: base_url + "pengajian/search",
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
    templateResult: formatPengajianList,
    templateSelection: formatPengajianSelection
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
    minimumInputLength: 1, allowClear: true, placeholder: '',
    templateResult: formatSchoolList,
    templateSelection: formatSchoolSelection
};
function formatMasjidList(org) {
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
    minimumInputLength: 1, allowClear: true, placeholder: '',
    templateResult: formatMasjidList,
    templateSelection: formatMasjidSelection
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
jQuery(function ($) {
// AUTO COMPLETES
    // input type di autocomplete ini akan auto-add jika bukan reference
    //individu
    $('select.kotakab-select2').select2(kotakab_select_config);
    $('select.male-select2').select2(male_select_config);
    $('select.female-select2').select2(female_select_config);
    $('select.individu-select2').select2(individu_select_config);
})