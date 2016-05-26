function load_nonteror(id) {
    $.getJSON(base_url + 'nonteror/get/' + id, function (data) {

        $('form').append($('<input/>',{type:'hidden',name:'nonteror_id',value:data.nonteror_id}));
        $('input[name="tempat"]').val(data.tempat);
        $('input[name="tanggal"]').combodate('setValue',data.tanggal);
        $('input[name="waktu"]').timepicker('setTime',data.waktu);
        $('input[name="pidana"]').val(data.pidana);
        $('input[name="nilai"]').val(data.nilai);
        $('input[name="motif"]').val(data.motif);
        $('input[name="korban"]').val(data.korban);
    });
}