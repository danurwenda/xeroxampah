function load_teror(id) {
    $.getJSON(base_url + 'teror/get/' + id, function (data) {

        $('form').append($('<input/>',{type:'hidden',name:'teror_id',value:data.teror_id}));
        $('input[name="tempat"]').val(data.tempat);
        $('input[name="tanggal"]').combodate('setValue',data.tanggal);
        $('input[name="waktu"]').timepicker('setTime',data.waktu);
        $('input[name="serangan"]').val(data.serangan);
        $('input[name="motif"]').val(data.motif);
        $('input[name="sasaran"]').val(data.sasaran);
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