function showToast(title, titleColor, text) {
    var messageContent = "<p data-translate='" + text + "'></p>";
    $('#toast-body').append(messageContent);
    document.getElementById('header-toast').style.backgroundColor = titleColor;
    var titleContent = "<strong class='mr-auto' data-translate='" + title + "'></strong>";
    $('#button-header').before(titleContent);
    $('.toast').toast('show');
}
