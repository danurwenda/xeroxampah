function load_latihan(id) {
    $.getJSON(base_url + 'latihan/get/' + id, function (data) {

        $('form').append($('<input/>', {type: 'hidden', name: 'latihan_id', value: data.latihan_id}));
        $('input[name="tempat"]').val(data.tempat);
        $('input[name="sejak"]').combodate('setValue', data.sejak);
        $('input[name="hingga"]').combodate('setValue', data.hingga);
        $('input[name="motif"]').val(data.motif);
        $('input[name="label"]').val(data.label);
        $('textarea[name="materi"]').val(data.materi);
        //add selected city if any and select it in dropdown
        if (data.kotakab_id) {
            $.getJSON(base_url + 'kotakab/get/' + data.kotakab_id, function (kotakab) {
                $('select[name="kotakab"]')
                        .empty() //empty select
                        .append($("<option/>") //add option tag in select
                                .val(kotakab.kotakab_id) //set value for option to post it
                                .text(kotakab.kotakab)) //set a text for show in select
                        .val(kotakab.kotakab_id) //select option of select2
                        .trigger("change"); //apply to select2
            })
        }
    });
}