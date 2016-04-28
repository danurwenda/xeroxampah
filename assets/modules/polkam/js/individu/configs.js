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
    return repo.individu_name || repo.alias;
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
    minimumInputLength: 1,
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
    minimumInputLength: 1,
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
    minimumInputLength: 1,
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
    return nt.pidana + ' ' + nt.korban;
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
    minimumInputLength: 1,
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
            "<div class='select2-result-repository__forks'>" + nt.tempat + ', ' + nt.sejak + "</div>" +
            "</div>" +
            "</div></div>";

    return markup;
}

function formatLatsenSelection(nt) {
    return nt.materi + ' di ' + nt.tempat;
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
    minimumInputLength: 1,
    templateResult: formatLatsenList,
    templateSelection: formatLatsenSelection
};
function formatLatihanList(nt) {
    if (nt.loading)
        return nt.text;
    var markup = "<div class='select2-result-repository clearfix'>" +
            "<div class='select2-result-repository__meta'>" +
            "<div class='select2-result-repository__title'>" + nt.materi + "</div>";



    markup += "<div class='select2-result-repository__statistics'>" +
            "<div class='select2-result-repository__forks'>" + nt.tempat + ', ' + nt.sejak + "</div>" +
            "</div>" +
            "</div></div>";

    return markup;
}

function formatLatihanSelection(nt) {
    return nt.materi + ' di ' + nt.tempat;
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
    minimumInputLength: 1,
    templateResult: formatLatihanList,
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
    return nt.serangan + ' ' + nt.sasaran;
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
    minimumInputLength: 1,
    templateResult: formatTerorList,
    templateSelection: formatTerorSelection
};
function formatLapasList(l) {
    if (l.loading)
        return l.text;
    var markup = "<div class='select2-result-repository clearfix'>" +
            "<div class='select2-result-repository__meta'>" +
            "<div class='select2-result-repository__title'>" + l.name + "</div>" +
            "</div></div>";

    return markup;
}

function formatLapasSelection(l) {
    return l.name;
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
    minimumInputLength: 1,
    templateResult: formatLapasList,
    templateSelection: formatLapasSelection
};
function formatOrganisasiList(org) {
    if (org.loading)
        return org.text;
    var markup = "<div class='select2-result-repository clearfix'>" +
            "<div class='select2-result-repository__meta'>" +
            "<div class='select2-result-repository__title'>" + org.org_name + "</div>" +
            "</div></div>";

    return markup;
}

function formatOrganisasiSelection(org) {
    return org.org_name;
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
    minimumInputLength: 1,
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
    return org.topik+' di '+org.lokasi;
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
    minimumInputLength: 1,
    templateResult: formatPengajianList,
    templateSelection: formatPengajianSelection
};
function formatSchoolList(org) {
    if (org.loading)
        return org.text;
    var markup = "<div class='select2-result-repository clearfix'>" +
            "<div class='select2-result-repository__meta'>" +
            "<div class='select2-result-repository__title'>" + org.name + "</div>" +
            "</div></div>";

    return markup;
}

function formatSchoolSelection(org) {
    return org.name;
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
    templateSelection: formatSchoolSelection
};
function formatMasjidList(org) {
    if (org.loading)
        return org.text;
    var markup = "<div class='select2-result-repository clearfix'>" +
            "<div class='select2-result-repository__meta'>" +
            "<div class='select2-result-repository__title'>" + org.name + "</div>" +
            "</div></div>";

    return markup;
}

function formatMasjidSelection(org) {
    return org.name;
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
    templateSelection: formatMasjidSelection
};
var masjid_autocomplete_config = {
    source: base_url + "masjid/search",
    minLength: 4,
    create: function (e) {
        $(this).next('.ui-helper-hidden-accessible').remove();
    },
    select: function (e, ui) {
        $(this).data('reference_id', ui.item.id);
    }
};
var lapas_autocomplete_config = {
    source: base_url + "lapas/search",
    minLength: 4,
    create: function (e) {
        $(this).next('.ui-helper-hidden-accessible').remove();
    },
    select: function (e, ui) {
        $(this).data('reference_id', ui.item.id);
    }
};