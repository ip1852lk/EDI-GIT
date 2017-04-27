window.getDependencyGrid = function(url, contentId, msg, errorTitle, errorMsg) 
{
    $('#'+contentId).html('<i class="fa fa-spin fa-spinner"></i> '+msg);
    $.ajax({
        type: 'GET',
        cache: false,
        url: url,
        dataType: 'html',
        data: {}
    }).success(function(data) {
        $('#'+contentId).html(data);
    }).error(function(xhr, status, error) {
        $('#'+contentId).html('<span class="label label-danger">'+errorTitle+'</span> '+errorMsg);
    });
};