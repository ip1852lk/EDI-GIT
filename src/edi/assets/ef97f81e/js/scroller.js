function setCurrentScrollerPosition()
{
    $.cookie('scrollLeft', $(document).scrollLeft());
    $.cookie('scrollTop', $(document).scrollTop());
    return true;
}