function submit(formId) {
    $("#" + formId).submit();
}

function deleteAzubi(id) {
    $.ajax({
        url: 'index.php?controller=AzubiList&action=delete&deleteId=' + id,
        type: 'GET',
        success: function (data) {
            $('#' + id).remove();
            console.log(data);
            //let nextAzubi = JSON.parse(data);
            //addToAzubiTable(nextAzubi);
        }
    });
}

function addToAzubiTable(azubi) {
    console.log("hi");
}

function autofill() {
    let suggestions = $("#suggestions");
    suggestions.html("");
    let searchValue = $("#search").val();
    if (searchValue.length > 1) {
        $.ajax({
            type: 'GET',
            url: 'index.php?controller=SearchSuggestion&filter='+ searchValue,
            success: function (data) {
                let names = JSON.parse(data);
                $.each(names, function (index, element) {
                    let button = $("<button/>");
                    button.attr('type', 'button');
                    button.attr('id', removeTag("strong", element));
                    button.attr('onclick', 'searchName("'+ removeTag("strong", element) +'")');
                    button.attr('class', "btn btn-white border border-bottom w-100 text-start");
                    button.html(element);
                    suggestions.append(button);
                });
                suggestions.show();
            }
        });
    }
}

function removeTag(tag, string) {
    string = string.replace("<" + tag + ">", "");
    return string.replace("</" + tag + ">", "");
}

function searchName(filter) {
    $("#search").val(filter);
    submit("searchForm");
}

$(document).click(function(e) {
    if (document.getElementById('searchBox').contains(e.target)) {
        $('#suggestions').show();
    } else {
        $('#suggestions').hide();
    }
});