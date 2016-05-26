function load_school(id) {
    $.getJSON(base_url + 'school/get/' + id, function (data) {

        $('form').append($('<input/>',{type:'hidden',name:'school_id',value:data.school_id}));
        $('input[name="name"]').val(data.name);
        $('input[name="address"]').val(data.address);
        $('input[name="city"]').val(data.city);
    });
}