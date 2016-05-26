function load_latsen(id) {
    $.getJSON(base_url + 'latsen/get/' + id, function (data) {

        $('form').append($('<input/>',{type:'hidden',name:'latsen_id',value:data.latsen_id}));
        $('input[name="tempat"]').val(data.tempat);
        $('input[name="sejak"]').combodate('setValue',data.sejak);
        $('input[name="hingga"]').combodate('setValue',data.hingga);
        $('input[name="motif"]').val(data.motif);
        $('input[name="materi"]').val(data.materi);
    });
}