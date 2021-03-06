function load_pengajian(id) {
    $.getJSON(base_url + 'pengajian/get/' + id, function (data) {

        $('form').append($('<input/>', {type: 'hidden', name: 'pengajian_id', value: data.pengajian_id}));
        $('input[name="topik"]').val(data.topik);
        $('input[name="lokasi"]').val(data.lokasi);
        $('input[name="label"]').val(data.label);
        //add selected masjid if any and select it in dropdown
        if (data.masjid) {
            $.getJSON(base_url + 'masjid/get/' + data.masjid, function (masjid) {
                $('select[name="masjid"]')
                        .empty() //empty select
                        .append($("<option/>") //add option tag in select
                                .val(masjid.masjid_id) //set value for option to post it
                                .text(masjid.masjid_name)) //set a text for show in select
                        .val(masjid.masjid_id) //select option of select2
                        .trigger("change"); //apply to select
            })
        }
        //similarly, to school
        if (data.school) {
            $.getJSON(base_url + 'school/get/' + data.school, function (skul) {
                $('select[name="school"]')
                        .empty() //empty select
                        .append($("<option/>") //add option tag in select
                                .val(skul.school_id) //set value for option to post it
                                .text(skul.school_name)) //set a text for show in select
                        .val(skul.school_id) //select option of select2
                        .trigger("change"); //apply to select2
            })
        }
        //similarly, to individual home
        if (data.rumah) {
            $.getJSON(base_url + 'individu/get/' + data.rumah, function (rumah) {
                $('select[name="rumah"]')
                        .empty() //empty select
                        .append($("<option/>") //add option tag in select
                                .val(rumah.individu_id) //set value for option to post it
                                .text(rumah.individu_name)) //set a text for show in select
                        .val(rumah.individu_id) //select option of select2
                        .trigger("change"); //apply to select2
            })
        }
    });
}

