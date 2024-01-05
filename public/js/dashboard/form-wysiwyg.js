$(document).ready(function() {
    $("#editor-container").sortable({
        containment: "parent",
        handle: ".drag-handler"
    });
});

/**
 * Loading / saving WYSIWYG editor
 */
function form_load(elem) {
    let json = $(elem).parent().siblings('input[name=form-content]').val();
    json = JSON.parse(json);

    let container = $(elem).parent().siblings('#form-wysiwyg-modal').find('#editor-container');
    container.html('<div id="pad" style="height:1px;"></div>');
    json.forEach((field) => {
        let type = ['text', 'number', 'select'].includes(field['type']) ? field['type'] : 'text';

        let nf = $('#t-field-card').clone().removeAttr('id');
        let nff = $('#t-field-card-opts').children(`#t-${type}`).children('#field').clone();
        nff.find('label').text(field['label']);
        nf.find('#field-field').prepend(nff);
        let nfo = $('#t-field-card-opts').children(`#t-${type}`).children('#opts').clone();
        nfo.find('input[name=type]').val(field['type']);
        nfo.find('input[name=label]').val(field['label']);
        nfo.find('input[name=name]').val(field['name']);
        nfo.find('input[name=default]').val(field['value']);
        nfo.find('input[name=required]').prop('checked', field['required']);
        nf.find('#field-opts').append(nfo);

        switch (type) {
            case 'text':
                break;
            case 'number':
                nfo.find('input[name=min]').val(field['min']);
                nfo.find('input[name=max]').val(field['max']);
                break;
            case 'select':
                nfo.find('input[name=options-array]').val(JSON.stringify(field['options']));
                opt_container = nfo.find('#options');
                $.map(field['options'], (val, key) => {
                    let opt = $('#t-dropdown-option').clone().removeAttr('id');
                    opt.prepend(val);
                    opt.children('input[name=key]').val(key);
                    opt.children('input[name=label]').val(val);
                    opt_container.append(opt);
                });
                nfo.find('input[name=multiple]').prop('checked', field['multiple']);
                break;
        }

        nf.insertBefore(container.children('#pad'));
    });
}

function form_save(elem) {
    let data = $.map($(elem).parent().siblings('#editor-container').children(':not(#pad)'), (field) => {
        field_data = {
            'name':     $(field).find('input[name=name]').val(),
            'label':    $(field).find('input[name=label]').val(),
            'type':     $(field).find('input[name=type]').val(),
            'required': $(field).find('input[name=required]').is(':checked'),
        };
        switch (field_data['type']) {
            case 'number':
                let min = $(field).find('input[name=min]').val();
                if (min != '') 
                    field_data['min'] = min;
                let max = $(field).find('input[name=max]').val();
                if (max != '') 
                    field_data['max'] = max;
                break;
            case 'select':
                field_data['options'] = JSON.parse($(field).find('input[name=options-array]').val());
                field_data['multiple'] = $(field).find('input[name=multiple]').is(':checked');
                break;
        }
        return field_data;
    });
    $(elem).parents(':eq(3)').siblings('input[name=form-content]').val(JSON.stringify(data));
    $(elem).parents(':eq(3)').siblings('input[name=form-content]').trigger("change");
}


/**
 * Functions related to managing fields
 */
function field_add(elem) {
    let type = $(elem).siblings('#new-type').children('select').val();
    let label = $(elem).siblings('#new-label').children('input').val();
    let required = $(elem).siblings('#new-required').children('input').is(':checked');

    if (label == '') {
        $(elem).siblings('.invalid-feedback').show();
        $(elem).siblings('#new-label').children('input').addClass('border-danger')
        return;
    } else {
        $(elem).siblings('#new-label').children('input').removeClass('border-danger')
        $(elem).siblings('.invalid-feedback').hide();
    }

    let nf = $('#t-field-card').clone().removeAttr('id');
    let nff = $('#t-field-card-opts').children(`#t-${type}`).children('#field').clone();
    nff.find('label').text(label);
    nf.find('#field-field').prepend(nff);
    let nfo = $('#t-field-card-opts').children(`#t-${type}`).children('#opts').clone();
    nfo.find('input[name=type]').val(type);
    nfo.find('input[name=label]').val(label);
    nfo.find('input[name=required]').prop('checked', required);
    nf.find('#field-opts').append(nfo);

    let names = $(elem).parents(':eq(1)').siblings('#editor-container').find('input[name=name]').toArray().map((t) => $(t).val());
    let name = label.substring(0, 24).toLowerCase().replace(/[\W_]+/g,"-");
    let name_base = name;
    for (let i = 1; names.includes(name); i++) {
        name = name_base + '-' + i;
    }
    nfo.find('input[name=name]').val(name);
    
    switch (type) {
        case 'text':
            break;
        case 'number':
            let min = $(elem).siblings('#number-options').find('#new-min').children('input').val();
            let max = $(elem).siblings('#number-options').find('#new-max').children('input').val();

            nfo.find('input[name=min]').val(min);
            nfo.find('input[name=max]').val(max);

            $(elem).siblings('#number-options').find('#new-min').children('input').val('');
            $(elem).siblings('#number-options').find('#new-max').children('input').val('')
            break;
        case 'select':
            let options = $(elem).siblings('#select-options').find('input[name=options-array]').val();
            let multiple = $(elem).siblings('#select-options').find('#new-multiple').children('input').is(':checked');

            nfo.find('input[name=options-array]').val(options);
            $(elem).siblings('#select-options').find('#options').children().appendTo(nfo.find('#options'));
            nfo.find('input[name=multiple]').prop('checked', multiple);

            $(elem).siblings('#select-options').find('input[name=options-array]').val('');
            $(elem).siblings('#select-options').find('#new-multiple').children('input').prop('checked', false);
            break;
    }

    nf.insertBefore($(elem).parents(':eq(1)').siblings('#editor-container').children('#pad'));
    $(elem).siblings('#new-label').children('input').val('');
    $(elem).siblings('#new-required').children('input').prop('checked', true);
}

function update_label(elem) {
    $(elem).parents(':eq(2)').siblings('#field-field').find('label').text($(elem).val());
}


/**
 * Functions related to managing a list of options
 */
function options_add(elem) {
    let val = $(elem).siblings('#dropdown-item').val();
    let opt = $('#t-dropdown-option').clone().removeAttr('id');
    opt.prepend(val);

    let keys = $(elem).parent().siblings('#options').find('input[name=key]').toArray().map((t) => $(t).val());
    let key = val.substring(0, 24).toLowerCase().replace(/[\W_]+/g,"-");
    let key_base = key;
    for (let i = 1; keys.includes(key); i++) {
        key = key_base + '-' + i;
    }
    opt.children('input[name=key]').val(key);
    opt.children('input[name=label]').val(val);

    let p = $(elem).parent();
    p.siblings('#options').append(opt);
    p.siblings('#options-array').val(JSON.stringify(options_extract(p.siblings('#options'))));

    $(elem).siblings('#dropdown-item').val('');
}

function options_remove(elem) {
    let p = $(elem).parent().parent(); 
    $(elem).parent().remove();
    p.siblings('#options-array').val(JSON.stringify(options_extract(p)))
}

function options_extract(elem) {
    options = {};
    $.map($(elem).children(), (e) => options[$(e).children('input[name=key]').val()] = $(e).children('input[name=label]').val());
    return options;
}


/**
 * Loading / saving JSON editor
 */
function jsoneditor_load(elem) {
    let json = $(elem).parent().siblings('input[name=form-content]').val();
    let container = $(elem).parent().siblings('#form-jsoneditor-modal').find('#editor-container');
    container.find('textarea').val(JSON.stringify(JSON.parse(json), null, 2));
}

function jsoneditor_save(elem) {
    let data = $(elem).parent().siblings('#editor-container').find('textarea').val();
    try {
        data = JSON.parse(data);
    } catch (e) {
        $(elem).siblings('.invalid-feedback').show();
        return;
    }
    $(elem).parents(':eq(3)').siblings('input[name=form-content]').val(JSON.stringify(data));
    $(elem).siblings('.invalid-feedback').hide();
    $(elem).parents(':eq(3)').modal('hide');
    $(elem).parents(':eq(3)').siblings('input[name=form-content]').trigger("change");
}
