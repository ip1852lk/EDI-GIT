window.openRelationPopup = function(url, selectBtn, closeBtn, callback, title, msg, errorTitle, errorMsg, data)
{
    window.relationBootbox = bootbox.dialog({
        className: 'extended-bootbox',
        title: '<div id="popup-title">'+title+'</div>',
        message: '<div id="popup-body"><i class="fa fa-spin fa-spinner"></i> '+msg+'</div>',
    });
    $.ajax({
        type: 'GET',
        cache: false,
        url: url,
        dataType: 'html',
        data: data !== undefined ? data : {}
    }).success(function(data) {
        $('#popup-body').html(data);
        $('#popup-body').on('click', '#'+selectBtn, callback);
        $('#popup-body').on('click', '#'+closeBtn, function() { window.relationBootbox.modal("hide"); });
    }).error(function(xhr, status, error) {
        $('#popup-body').html('<span class="label label-danger">'+errorTitle+'</span> '+errorMsg);
    });
};