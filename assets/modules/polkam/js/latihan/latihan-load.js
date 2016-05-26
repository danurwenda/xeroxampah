function load_latihan(id) {
    $.getJSON(base_url + 'latihan/get/' + id, function (data) {

        $('form').append($('<input/>',{type:'hidden',name:'latihan_id',value:data.latihan_id}));
        $('input[name="tempat"]').val(data.tempat);
        $('input[name="sejak"]').combodate('setValue',data.sejak);
        $('input[name="hingga"]').combodate('setValue',data.hingga);
        $('input[name="motif"]').val(data.motif);
        $('input[name="materi"]').val(data.materi);
    });
}