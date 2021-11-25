function confirmDeletion(title, message, href) {
    var messageContent = "<p data-translate='" + message + "'></p>";
    $('#modal-text').append(messageContent);
    var titleContent = "<strong class='mr-auto' data-translate='" + title + "'></strong>";
    $('#modal-title').append(titleContent);
    document.getElementById('delete-button').href = href;
    $("#exampleModal").modal('toggle');
}