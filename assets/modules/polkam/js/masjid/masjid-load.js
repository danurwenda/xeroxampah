function load_masjid(id) {
    $.getJSON(base_url + 'masjid/get/' + id, function (data) {

        $('form').append($('<input/>',{type:'hidden',name:'masjid_id',value:data.masjid_id}));
        $('input[name="name"]').val(data.name);
        $('input[name="address"]').val(data.address);
        $('input[name="city"]').val(data.city);
    });
}