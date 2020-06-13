conn.onmessage = function(e) {
    var json = JSON.parse(e.data);
    fetch('./ajax/updateNewmess.php?username=' + json.from)
        .then(res => {
            return res.json();
        })
        .then(data => {
            var divId = document.getElementById(json.from + '_detail');
            divId.children[1].innerHTML = data.mess_time;
            divId.children[2].innerHTML = data.last_mess;
            if (data.count > 0) {
                var new_mess_node = document.createTextNode(data.count);
                var new_mess = create_el('div', 'class=col-1 mess_count');
                new_mess.appendChild(new_mess_node);
                divId.appendChild(new_mess);
            }
        })
}