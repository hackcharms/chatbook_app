function header(e) {
    var con_id = e.id.split("_")[0];
    if (e.children[3])
        e.children[3].style.display = 'none';

    var messdiv = document.getElementById('message_maindiv');
    messdiv.style.display = 'block';
    document.querySelector('.rightDivdefault').style.display = 'none';
    var innerDIv = document.getElementById('message_inner');
    innerDIv.innerHTML = '';
    if (window.screen.width < 900) {
        var contact_div = document.getElementById('contact_div');
        var rightDiv = document.getElementsByClassName('rightDiv')[0];
        contact_div.className = contact_div.className.replace(/(?!col-)\d+/, '0');
        rightDiv.className = rightDiv.className.replace(/(?!col-)\d+/, '12');
    }
    fetch('./ajax/contents.php?pInfo=true&username=' + con_id + '&messId=0').
    then(res => { return res.json() }).
    then(data => {
        // var data = JSON.parse(out)
        // console.log(data);
        var div = document.getElementById('user_header');
        div.children[0].children[0].src = './uploads/' + data.imgSrc;
        div.children[1].innerHTML = data.name;
        div.children[2].innerHTML = "Last Seen  " + data.lastSeen;
        var popUp = document.getElementById('contact_details_popup').children[0];
        popUp.children[0].innerHTML = data.name;
        popUp.children[1].children[1].children[0].src = './uploads/' + data.imgSrc;
        var img_con = popUp.children[2].children[0];
        document.getElementById('user_id').innerHTML = '';
        document.getElementById('user_id').innerHTML = con_id;
        img_con.innerHTML = '';
        var media_list_array = data.media;
        for (var i in media_list_array) {
            var img = document.createElement('img');
            img.src = './uploads/' + data.media[i];
            img_con.appendChild(img);

        }
        var tableDiv = popUp.children[3].children[0];
        tableDiv.innerHTML = '';
        var table_cont = data.details
        for (var i in table_cont) {
            var textNode1 = document.createTextNode(i);
            var TextNode2 = document.createTextNode(table_cont[i]);
            var td1 = document.createElement('td');
            var td2 = document.createElement('td');
            var tr = document.createElement('tr');
            td1.appendChild(textNode1);
            td2.appendChild(TextNode2);
            // console.log(T1node+','+T2node+','+td1+','+td2+','+tr+','+t1+','+t2);
            tr.appendChild(td1)
            tr.appendChild(td2);
            tableDiv.appendChild(tr)

        }
        makeInputBox();
        insertChats(data.message, true);
        messageFormEnable();
        innerDIv.scrollTop = innerDIv.scrollHeight - 300;
        var loading = false;

        innerDIv.addEventListener('scroll', function() {
            console.log(innerDIv.scrollHeight, innerDIv.scrollTop);
            if (!loading) {
                // innerDIv.insertAdjacentHTML("afterbegin", '<li id="loadingEl"><img src="./bgimage/loading_image.gif"></li>');
                loading = true;
                setTimeout(() => {
                    insertOnscroll();
                    loading = false;
                    // document.getElementById('loadingEl').remove();
                }, 1000);

            }
        });

    }).catch(error => {
        console.log(error);
    })
    var d = document.getElementById("contact_details_popup");
    hideDiv(d, d.children[0]);

}

function showDiv(e) {
    var div = document.getElementById(e);
    div.style.visibility = 'visible';
    div.style.opacity = '1';
}

function insertOnscroll() {
    var innerDIv = document.getElementById('message_inner');
    if (innerDIv.scrollTop == 0 && innerDIv.scrollHeight !== innerDIv.offsetHeight) {
        // console.log(lastMessId);
        lastMessId = document.querySelector('li .idStamp').innerHTML;
        fetch('./ajax/contents.php?pInfo=false&username=' + user_id.innerText + '&messId=' + lastMessId)
            .then(res => { return res.json() })
            .then(chats => {
                // console.log(chats);
                insertChats(chats);
            })
            .catch(err => {
                console.log(err);
            })
        innerDIv.scr
    }
}

function insertChats(messages, clear = false) {
    var div = document.getElementById('message_inner');

    if (messages.length > 0) {
        var id = document.getElementById('user_id').innerHTML;
        var dayFlag = dayCalculator(messages[0]['time']);
        // var div = document.getElementById('message_inner');
        if (clear) {
            div.innerHTML = '';
        } else {
            var dayFlagLi = document.querySelector('li.day');
            if (dayFlagLi.innerText == dayCalculator(messages[0]['time'])) {
                dayFlagLi.remove();
            }
        }
        for (var i in messages) {
            // console.log(messages[i]['to']);
            if (messages[i]['to'] == id)
                var li = create_el('li', 'class=mine');
            else {
                var li = document.createElement('li');
            }
            var p = document.createElement('p');
            var node = document.createTextNode(messages[i]['message']);
            p.appendChild(node);
            if (messages[i]['image_src'] != '') {
                img = create_el('img', 'src=./uploads/' + messages[i]['image_src'] + ',onclick=display_image(this.src)');
                li.appendChild(img);
            }
            li.appendChild(p);
            time_stamp = create_el('p', 'class=time_stamp');
            let time = new Date(messages[i]['time']).toLocaleTimeString();
            time = time.replace(/(:\d\d\s+)/, ' ');
            time_node = document.createTextNode(time);
            time_stamp.appendChild(time_node);
            li.appendChild(time_stamp);

            idStamp = create_el('p', 'class=idStamp,style=display:none;');
            idStampNode = document.createTextNode(messages[i].id);
            idStamp.appendChild(idStampNode);
            li.appendChild(idStamp);
            // div.appendChild(li);
            div.insertAdjacentElement('afterbegin', li)
            day = dayCalculator(messages[i]['time']);
            if (day != dayFlag || i == messages.length - 1) {
                date = create_el('li', 'class=day');
                let p = document.createElement('p');
                p.appendChild(document.createTextNode(dayFlag));
                date.appendChild(p);
                // div.appendChild(date);
                div.insertAdjacentElement('afterbegin', date)
                dayFlag = day;
            }

        }
        // console.log(div);
    }
    //  else {
    //     if (document.querySelector('#message_inner li').innerText !== 'Last Element..')
    //         div.insertAdjacentHTML('afterbegin', '<li class=day ><p>Last Element..</p></li>');
    // }
}

function makeInputBox() {
    var inputFooter = document.getElementById('inputFooter');
    inputFooter.innerHTML = '';
    var iEmojy = create_el('i', 'class=fa fa-smile-o,onclick=insertAtCursor(this.nextElementSibling)');
    var textArea = create_el('textarea', 'name=message,id=inputTextArea,cols=30,rows=1,value=message,placeholder=Type your message here...,onfocus=detectKeyUp(this)');
    var user_id = document.getElementById('user_id').innerHTML;
    textArea.innerHTML = sessionStorage[user_id] ? sessionStorage[user_id] : '';
    var imgLabel = create_el('label', 'for=image_input');
    var iImg = create_el('i', 'class=fa fa-image,style=padding: 8px 5px,onclick=previewFile("image_input")');
    imgLabel.appendChild(iImg);
    var inputImg = create_el('input', 'type=file,name=image,id=image_input,style=display:none,accept=image/*');
    var labelSub = create_el('label', 'for=submit');
    var iSend = create_el('i', 'class=fa fa-send-o style=padding: 8px 7px;,title=Send');
    labelSub.appendChild(iSend);
    var SubBtn = create_el('input', 'type=submit,id=submit,style=display:none;');
    var form = create_el('form', 'class=chat-box-tray col-12,id=messagForm');
    form.appendChild(iEmojy);
    form.appendChild(textArea);
    form.appendChild(imgLabel);
    form.appendChild(inputImg);
    form.appendChild(labelSub);
    form.appendChild(SubBtn);
    var outerTray = create_el('div', 'class=col-12 chat-box-tray-outer,id=chat-box-tray-outer');
    outerTray.appendChild(form);
    inputFooter.appendChild(outerTray);
}