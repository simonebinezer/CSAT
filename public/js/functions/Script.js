


function removeError() {
    var errorElements = document.getElementsByClassName("error");
    for (let j = 0; j < errorElements.length; j++) {
        errorElements[j].style.display = "none";
    }
}
function errorDisplay(errorArray, idArray, messageArray) {
    for (let i = 0; i < idArray.length; i++) {
        // console.log(idArray[i]);
        var element = document.getElementById(errorArray[i])
        //console.log(element,"element");
        if (element) {
            if (idArray[i] in messageArray) {
                //       console.log(errorArray[i]);
                element.style.display = "block";
                element.innerText = messageArray[idArray[i]];
            } else {
                element.style.display = "none";
            }
        }
    }
}
