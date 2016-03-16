function load_individu(id) {
    $.getJSON(base_url + 'individu/get_cascade/' + id, function (data) {

        $('select[name="source_id"]').val(data.source_id);
        $('input[name="name"]').val(data.individu_name);
        $('input[name="religion"]').val(data.religion);
        $('input[name="alias"]').val(data.alias);
        $('input[name="born_place"]').val(data.born_place);
        $('input[name="born_date"]').datepicker("setDate", new Date(data.born_date));
        $('input[name="nationality"]').val(data.nationality);
        $('input[name="address"]').val(data.address);
        $('input[name="recent_job"]').val(data.recent_job);
        $('input[name="recent_edu"]').val(data.recent_edu);
        $('input[name="strata"]').val(data.strata);
        $('input[name="majlis"]').val(data.majlis);
        $('#relasi-editor').html(data.relation);
        $('#military-editor').html(data.edu_military);
        $('#radikal-editor').html(data.radicalized);
        $('#perbuatan-editor').html(data.perbuatan);
        $('#teror-editor').html(data.peristiwa);
        $('#organisasi-editor').html(data.organization_history);
        $('#job-editor').html(data.job_history);
        $('#formaledu-editor').html(data.edu_formal);
        $('#nonformaledu-editor').html(data.edu_non_formal);
        if (data.network) {
            $('input[name="jaringan"]').val(data.network.net_name).data('reference_id', data.network.net_id);
        }
        if (data.wife) {
            $('input[name="wife"]').val(data.wife.wife_name).data('reference_id', data.wife.wife_id);
        }
        if (data.father) {
            $('input[name="father"]').val(data.father.father_name).data('reference_id', data.father.father_id);
        }
        if (data.mother) {
            $('input[name="mother"]').val(data.mother.mother_name).data('reference_id', data.mother.mother_id);
        }
        if (data.children) {
            $('input[name="children[]"]').val(data.children[0].child_name).data('reference_id', data.children[0].child_id);
            if (data.children.length > 1) {
                for (var i = 1; i < data.children.length; i++) {
                    var input_group = $('input[name="children[]"]').parents('div.input-group').first();
                    var new_input = expandInputGroup(input_group);
                    new_input.val(data.children[i].child_name).data('reference_id',data.children[i].child_id)
                }
            }
        }
        if (data.siblings) {
            $('input[name="sibling[]"]').val(data.siblings[0].sibling_name).data('reference_id', data.siblings[0].sibling_id);
            if (data.siblings.length > 1) {
                for (var i = 1; i < data.siblings.length; i++) {
                    var input_group = $('input[name="sibling[]"]').parents('div.input-group').first();
                    var new_input = expandInputGroup(input_group);
                    new_input.val(data.siblings[i].sibling_name).data('reference_id',data.siblings[i].sibling_id)
                }
            }
        }
        if (data.schools) {
            $('input[name="pesantren[]"]').val(data.schools[0].name).data('reference_id', data.schools[0].school_id);
            if (data.schools.length > 1) {
                for (var i = 1; i < data.schools.length; i++) {
                    var input_group = $('input[name="pesantren[]"]').parents('div.input-group').first();
                    var new_input = expandInputGroup(input_group);
                    new_input.val(data.schools[i].name).data('reference_id',data.schools[i].school_id)
                }
            }
        }
        if (data.masjids) {
            $('input[name="masjid[]"]').val(data.masjids[0].name).data('reference_id', data.masjids[0].masjid_id);
            if (data.masjids.length > 1) {
                for (var i = 1; i < data.masjids.length; i++) {
                    var input_group = $('input[name="masjid[]"]').parents('div.input-group').first();
                    var new_input = expandInputGroup(input_group);
                    new_input.val(data.masjids[i].name).data('reference_id',data.masjids[i].masjid_id)
                }
            }
        }

        if (data.is_cooperative == 't') {
            //centang
            $('input[name="kooperatif"]').prop('checked', true);
        }
    });
}