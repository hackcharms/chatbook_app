function messageFormEnable() {
    user_name = document.getElementById('user_id').innerHTML;
    var form = document.getElementById('messagForm');
    form.addEventListener('submit', (e) => {
        // console.log(user_name);  
        e.preventDefault();
        inputs = document.querySelector('input').value;
        textArea = document.querySelector('textarea').value;
        if (inputs != '' || textArea != '') {
            // console.log(form)
            data = new FormData(form);
            data.append('username', user_name);
            fetch('./ajax/messageHandler.php', {
                method: 'post',
                body: data
            }).then(res => {
                return res.json();
            }).then(data => {
                {
                    // console.log(data);
                    insertSendChats(data);
                    var msg = JSON.stringify({ to: data.username, msg: data.message, img: data.image_src });
                    conn.send(msg);
                    // console.log(msg);
                    var Messdiv = document.getElementById('contact_header_div');
                    Messdiv.scrollTop = Messdiv.scrollHeight;
                }
                loadContacts()
            }).catch(er => {
                console.log(er)
            });

            inputs = document.querySelector('input').value = '';
            textArea = document.querySelector('textarea');
            textArea.style.height = '19px';
            textArea.value = '';
            document.querySelector('#messagForm').style.height = 'auto';
            messageContainer = document.querySelector('#messageContainer');
            messageContainer.style.height = (messageContainer.parentElement.offsetHeight - messageContainer.nextElementSibling.offsetHeight) + 'px'

            sessionStorage[user_name] = '';
        }
        // {
        //     insertChats(data.message, con_id);
        // }
    })
}

function insertSendChats(messages) {
    div = document.getElementById('message_inner');
    // console.log(messages['to']);
    var li = create_el('li', 'class=mine');
    var p = document.createElement('p');
    var node = document.createTextNode(messages['message']);
    p.appendChild(node);
    if (messages['image_src']) {
        // console.log('inside Image==>' + messages['image_src']);
        img = create_el('img', 'src=./uploads/' + messages['image_src'] + ',onclick=display_image(this.src)');
        li.appendChild(img);
    }
    li.appendChild(p);
    time_stamp = create_el('p', 'class=time_stamp');
    time_node = document.createTextNode(messages['time'])
    time_stamp.appendChild(time_node);
    li.appendChild(time_stamp);
    // console.log(li);
    div.appendChild(li);

    // console.log(div);
}