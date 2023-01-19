function submit(formId) {
    document.getElementById(formId).submit();
}

function deleteAzubi(id) {
    let xhr = new XMLHttpRequest();
    xhr.open('GET', 'index.php?controller=LoadNextAzubi', true);

    xhr.onload = function () {
        if (this.status === 200) {
            document.getElementById(id).remove();
            console.log(xhr.responseText);
            //let nextAzubi = JSON.parse(xhr.responseText);
            //addToAzubiTable(nextAzubi);
        }
    }

    xhr.send();
}

function addToAzubiTable(azubi) {
    console.log("hi");
}

function setVisibility(status) {
    document.getElementById("suggestions").style.display = status;
}

function autofill() {
    deleteSuggestions();
    let searchValue = document.getElementById("search").value;
    if (searchValue.length > 1) {

        let xhr = new XMLHttpRequest();
        xhr.open('GET', 'index.php?controller=SearchSuggestion&filter='+ searchValue, true);

        xhr.onload = function () {
            if (this.status === 200) {
                let names = JSON.parse(this.responseText);
                for (let name of names) {
                    let button = document.createElement("button");
                    button.setAttribute('type', 'button');
                    button.setAttribute('id', removeTag("strong", name));
                    button.setAttribute('onclick', 'searchName("'+ removeTag("strong", name) +'")');
                    button.setAttribute('class', "btn btn-white border border-bottom d-block w-100 text-start");
                    button.innerHTML = name;
                    document.getElementById("suggestions").appendChild(button);
                }
            }
        }
        xhr.send();
    }
}

function removeTag(tag, string) {
    string = string.replace("<" + tag + ">", "");
    return string.replace("</" + tag + ">", "");
}

function searchName(filter) {
    document.getElementById("search").value = filter;
    submit("searchForm");
}

function deleteSuggestions() {
    document.getElementById("suggestions").innerHTML = "";
}

document.addEventListener('click', function(e){
    if (document.getElementById('searchBox').contains(e.target)){
        setVisibility("block");
    } else{
        setVisibility("none");
    }
});