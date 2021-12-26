$(document).ready(function () {
    $('.pjaxModalButton').click(function (e) {
        callAjaxModal(e, $(this));
    });
})

let callAjaxModal = (e, el) => {
    e.preventDefault();
    let pJaxModal = $('#PjaxModal');
    pJaxModal.find('#pjax-modal-title').html(el.text() || el.data('title'));
    if (imageExist(el.attr('href'))) {
        let img = $('<img>', {
            'src': el.attr('href'),
            'class': 'modal-lg',
            'style': 'padding-right: 35px'
        })
        pJaxModal.modal('show')
            .find('.modal-body')
            .html(img);
    } else {
        pJaxModal.modal('show')
            .find('.modal-body')
            .load(el.attr('href'));
    }
}

let imageExist = (url) => {
    let img = new Image();
    img.src = url;
    return img.height !== 0;
}