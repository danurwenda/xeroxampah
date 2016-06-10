function load_lapas(id) {
    $.getJSON(base_url + 'lapas/get/' + id, function (data) {

        $('form').append($('<input/>',{type:'hidden',name:'lapas_id',value:data.lapas_id}));
        $('input[name="name"]').val(data.name);
        $('input[name="address"]').val(data.address);
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