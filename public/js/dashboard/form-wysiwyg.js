$(document).ready(function() {
    $("#editor-container").sortable({
        containment: "parent",
        handle: ".drag-handler"
    });
});

/**
 * Functions related to managing fields
 */
function field_add(elem) {
    let type = $(elem).siblings('#new-type').children('select').val();
    let label = $(elem).siblings('#new-label').children('input').val();

    //let templates = $(elem).parents(':eq(1)').siblings().siblings('#template-elements');
    let nf = $('#t-field-card').clone();
    let nff = $('#t-field-card-opts').children(`#t-${type}`).children('#field').clone();
    nf.find('#field-field').prepend(nff);
    let nfo = $('#t-field-card-opts').children(`#t-${type}`).children('#opts').clone();
    nf.find('#field-opts').append(nfo);

    switch (type) {
        case 'text':
            break;
        case 'num':
            break;
        case 'select':
            break;
    }

    nf.insertBefore($(elem).parents(':eq(1)').siblings('#editor-container').children('#pad'));
}


/**
 * Functions related to managing a list of options
 */
function options_add(elem) {
    let val = $(elem).siblings('#dropdown-item').val();
    let opt = $('#t-dropdown-option').clone().removeAttr('id');
    opt.prepend(val);
    opt.children('input').val(val);

    let p = $(elem).parent();
    p.siblings('#options').append(opt);
    p.siblings('#options-array').val(JSON.stringify(options_extract(p.siblings('#options'))));
}

function options_remove(elem) {
    let p = $(elem).parent().parent(); 
    $(elem).parent().remove();
    p.siblings('#options-array').val(JSON.stringify(options_extract(p)))
}

function options_extract(elem) {
    return $.map($(elem).children(), (e) => $(e).children('input[type=hidden]').val());
}