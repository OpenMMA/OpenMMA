function verificationAJAX(e) {
    e.preventDefault();
    let obj = $(e.target);
    obj.children('.btn').addClass('disabled');
    $.ajax({
        url: obj.attr('action'),
        method: 'POST',
        data: obj.serialize()
    }).done((data) => {
        let parent = obj.parent();
        obj.remove();
        parent.append('<i class="fa-solid fa-check text-success"></i>');
    });
    return false;
}