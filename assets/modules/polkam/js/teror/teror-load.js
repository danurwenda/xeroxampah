function load_teror(id) {
    $.getJSON(base_url + 'teror/get/' + id, function (data) {

        $('form').append($('<input/>',{type:'hidden',name:'teror_id',value:data.teror_id}));
        $('input[name="tempat"]').val(data.tempat);
        $('input[name="tanggal"]').combodate('setValue',data.tanggal);
        $('input[name="waktu"]').timepicker('setTime',data.waktu);
        $('input[name="serangan"]').val(data.serangan);
        $('input[name="motif"]').val(data.motif);
        $('input[name="sasaran"]').val(data.sasaran);
    });
}