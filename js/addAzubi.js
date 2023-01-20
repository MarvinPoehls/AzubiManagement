function addSkill(parentId) {
    let div = $("<div></div>");
    div.attr("class", "row my-2");
    let id = getUniqueId();
    div.attr("id", id);
    $("#" + parentId).append(div);

    let inputCol = $("<div></div>");
    inputCol.attr("class", "col-10");
    div.append(inputCol);

    let skill = $("<input/>");
    skill.attr("class", "form-control");
    skill.attr("type", "text");
    if (parentId === "preSkills") {
        skill.attr("name", "preSkills[]")
    }
    if (parentId === "newSkills") {
        skill.attr("name", "newSkills[]")
    }
    inputCol.append(skill);

    let buttonCol = $("<div></div>");
    buttonCol.attr("class", "col-2");
    div.append(buttonCol);

    let deleteSkillButton = $("<button/>");
    deleteSkillButton.attr("class", "btn btn-danger");
    deleteSkillButton.attr("type", "button");
    deleteSkillButton.attr("onclick", "deleteSkill('" + id + "')");
    buttonCol.append(deleteSkillButton);

    let icon = $("<i></i>");
    icon.attr("class", "bi bi-dash-circle");
    deleteSkillButton.append(icon);
}

function deleteSkill(id) {
    let skill = $("#" + id);
    let splitedId = id.split(".");
    let type = splitedId[0];
    let skillName = skill.find(".form-control").value;
    skill.remove();

    $.ajax({
        type: 'GET',
        url: 'index.php?controller=AddAzubi&action=deleteSkill(' + skillName + "," + type + ')',
    });
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