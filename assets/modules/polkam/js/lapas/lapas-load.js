function load_lapas(id) {
    $.getJSON(base_url + 'lapas/get/' + id, function (data) {

        $('form').append($('<input/>',{type:'hidden',name:'lapas_id',value:data.lapas_id}));
        $('input[name="name"]').val(data.name);
        $('input[name="address"]').val(data.address);
        $('input[name="city"]').val(data.city);
    });
}