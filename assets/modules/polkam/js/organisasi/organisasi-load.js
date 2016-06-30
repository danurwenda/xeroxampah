function load_organisasi(id) {
    $.getJSON(base_url + 'organisasi/get/' + id, function (data) {

        $('form').append($('<input/>',{type:'hidden',name:'organisasi_id',value:data.organisasi_id}));
        $('input[name="label"]').val(data.label);
        $('input[name="name"]').val(data.name);
        $('input[name="daerah"]').val(data.daerah);
    });
}