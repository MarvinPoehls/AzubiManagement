function addSkill(parentId) {
    let div = document.createElement("div");
    div.setAttribute("class", "row my-2");
    let id = getUniqueId();
    div.setAttribute("id", id);
    document.getElementById(parentId).appendChild(div);

    let inputCol = document.createElement("div");
    inputCol.setAttribute("class", "col-10");
    div.appendChild(inputCol);

    let skill = document.createElement("input");
    skill.setAttribute("class", "form-control");
    skill.setAttribute("type", "text");
    if (parentId === "preSkills") {
        skill.setAttribute("name", "preSkills[]")
    }
    if (parentId === "newSkills") {
        skill.setAttribute("name", "newSkills[]")
    }
    inputCol.appendChild(skill);

    let buttonCol = document.createElement("div");
    buttonCol.setAttribute("class", "col-2");
    div.appendChild(buttonCol);

    let deleteSkillButton = document.createElement("button");
    deleteSkillButton.setAttribute("class", "btn btn-danger");
    deleteSkillButton.setAttribute("type", "button");
    deleteSkillButton.setAttribute("onclick", "deleteSkill('" + id + "')");
    buttonCol.appendChild(deleteSkillButton);

    let icon = document.createElement("i");
    icon.setAttribute("class", "bi bi-dash-circle")
    deleteSkillButton.appendChild(icon);
}

function deleteSkill(id) {
    let skill = document.getElementById(id)
    let splitedId = id.split(".");
    let type = splitedId[0];
    let skillName = skill.querySelector(".form-control").value;

    let xhr = new XMLHttpRequest();
    xhr.open('GET', 'index.php?controller=AddAzubi&action=deleteSkill(' + skillName + "," + type + ')', true);

    xhr.send();

    skill.remove();
}

function getUniqueId(){
    return Date.now().toString(36) + Math.floor(Math.pow(10, 12) + Math.random() * 9*Math.pow(10, 12)).toString(36)
}

$(document).ready(function(){
    $("#addPreSkill").click(function (){
        addSkill("preSkills");
    });

    $("#addNewSkill").click(function (){
        addSkill("newSkills");
    });
});