function display_image(src) {
    imDiv = document.getElementById("image_show");
    imDiv.style.visibility = 'visible';
    imDiv.style.opacity = '1';
    imDiv.children[0].children[0].src = src;
    hideDiv(imDiv, imDiv.children[0]);
}

function hideDiv(outerDiv, innerDiv) {
    outerDiv.addEventListener('click', function(e) {
        if (!innerDiv.contains(e.target)) {
            outerDiv.style.visibility = 'hidden';
            outerDiv.style.opacity = 0;
            innerDiv.children[0].src = '';
        }

    })
}

function onError(e) {
    if (e.src != './bgimage/loading_image.gif') e.src = './bgimage/loading_image.gif';
    // setTimeout(,3000)
}