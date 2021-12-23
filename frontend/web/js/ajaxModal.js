$(document).ready(function () {
    $('.pjaxModalButton').click(function (e) {
        callAjaxModal(e, this);
    });
})

function callAjaxModal(e, el) {
    e.preventDefault();
    $('#PjaxModal').find('.modal-header').html('<div class=\'pull-left\'><h4>' + $(el).text() + '</h4></div><button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-hidden=\"true\">×</button>');
    if (imageExist($(el).attr('href'))) {
        $('#PjaxModal').modal('show').find('.modal-body').html('<img src="' + $(el).attr('href') + '" class="modal-lg" style="padding-right: 35px;">');
    } else {
        $('#PjaxModal').modal('show')
            .find('.modal-body')
            .load($(el).attr('href'));
    }
}

function imageExist(url) {
    var img = new Image();
    img.src = url;
    return img.height != 0;
}