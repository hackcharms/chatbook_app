// ================>>>>> inputTray Height Controller  <<<<<<==================
function detectKeyUp(textArea) {
    textArea.style.height = 'auto';
    textArea.style.height = textArea.scrollHeight + 'px';
    // console.log(textArea.offsetHeight);
    // console.log(textArea.parentNode.offsetHeight);
    var k = textArea.parentNode.offsetHeight - textArea.offsetHeight;
    if (textArea.scrollHeight < 100) {
        textArea.parentNode.style.height = textArea.scrollHeight + k + 'px';
        // console.log('executed');

    } else {
        textArea.parentNode.style.height = '122px';
    }
    var messageMain = document.getElementById('messageMain');
    var messageContainer = document.getElementById('messageContainer');
    messageContainer.style.height = (messageMain.offsetHeight - textArea.parentNode.offsetHeight) + 'px';
    textArea.addEventListener('keyup', (event) => {
        inputs = document.querySelector('textarea').value;
        var user_id = document.getElementById('user_id').innerHTML;
        sessionStorage[user_id] = inputs;
        // console.log(inputs);
        // console.log(sessionStorage[user_id]);
        textArea.style.height = 'auto';
        if (textArea.scrollHeight < 100) {
            textArea.parentNode.style.height = textArea.scrollHeight + k + 'px';
        }
        textArea.style.height = textArea.scrollHeight + 'px';
        messageContainer.style.height = (messageMain.offsetHeight - textArea.parentNode.offsetHeight) + 'px';

    })
}
// ================>>>>> Insert in Input Box  <<<<<<==================


function insertAtCursor(myField, myValue) {
    //IE support
    if (document.selection) {
        myField.focus();
        var sel = document.selection.createRange();
        sel.text = myValue;
    }
    //MOZILLA and others
    else if (myField.selectionStart || myField.selectionStart == '0') {
        var startPos = myField.selectionStart;
        var endPos = myField.selectionEnd;
        myField.value = myField.value.substring(0, startPos) +
            myValue +
            myField.value.substring(endPos, myField.value.length);
    } else {
        myField.value += myValue;
    }
}



function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function(e) {
            document.querySelector('#image_preview_tag').setAttribute('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]); // convert to base64 string
    }
}

// function previewFile(id) {
//     var input = document.getElementById(id);
//     input.addEventListener('change', () => {
//         console.log(input.files[0]);
//         console.log(document.getElementById('input_preview_outer').style.display = 'block');
//         readURL(input);
//     })
// }