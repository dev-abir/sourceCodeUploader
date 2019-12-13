
/* For next release(Maybe)
function scanForVars() {
    //TODO
}*/

window.onload = function(e) {
	var emptyId = getEmptyId();
    document.getElementById(emptyId).focus();
    document.getElementById(emptyId).select();
}

function getEmptyId() {
	inputs = document.getElementsByTagName("input");
	for (var i = 0; i < inputs.length; i++) {
		if(inputs[i].value === '' || inputs[i].value === null || inputs[i].value === undefined) {
			return inputs[i].id;
		}
	}

	textareas = document.getElementsByTagName("textarea");
	for (var i = 0; i < textareas.length; i++) {
		console.log(textareas[i]);
		if(textareas[i].innerHTML === '' || textareas[i].innerHTML === null || textareas[i].innerHTML === undefined) {
			return textareas[i].id;
		}
	}
}

function validateForm() {
    var creator = document.getElementById('textInput-creator').value;
    var questionInOneWord = document.getElementById('textInput-acceptQuestionInOneWord').value;
    var result = false;
    if (!creator.match(/^[0-9a-zA-Z]+$/)) {
	document.getElementById("info0").className = "text-danger";
	scrollToTop();
    }
    if(!questionInOneWord.match(/^[0-9a-zA-Z]+$/)) {
	document.getElementById("info1").className = "text-danger";
	scrollToTop();
    }
    if(creator.match(/^[0-9a-zA-Z]+$/)) {
	if(document.getElementById("info0").className == "text-danger") {
	    document.getElementById("info0").className = "text-primary";
	}
    }
    if(questionInOneWord.match(/^[0-9a-zA-Z]+$/)) {
	if(document.getElementById("info1").className == "text-danger") {
	    document.getElementById("info1").className = "text-primary";
	}
    }
    if(creator.match(/^[0-9a-zA-Z]+$/) && questionInOneWord.match(/^[0-9a-zA-Z]+$/)) {
	result = true;
    }
    return result;
}


function scrollToTop() {
	document.body.scrollTop = 0; // For Safari
	document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera
}
