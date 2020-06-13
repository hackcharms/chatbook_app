function search(searchBox) {
    // var contact_inner = document.querySelector('#contact_inner');
    var searchResult = document.querySelector('.search_result');
    searchResult.style.display = 'block';
    searchData = [];
    var divs = document.querySelectorAll("[id$=_user]");
    for (var i = 0; i < divs.length; i++) {
        var val = divs[i].id.split('_');
        searchData.push({ userName: val[0], userId: val[1], id: divs[i].id });
    }
    newUsersId = [];
    searchBox.addEventListener('keyup', () => {
        var inp = searchBox.value;
        if (10 >= inp.length && inp.length > 0) {
            var matchedData = searchData.filter((val, ind, ar) => {
                return val.userName.toLowerCase().substr(0, inp.length) == inp.toLowerCase() || val.userId.toLowerCase().substr(0, inp.length) == inp.toLowerCase();
            })
            var unMatchedData = searchData.filter((val, ind, ar) => {
                return !(val.userName.toLowerCase().substr(0, inp.length) == inp.toLowerCase() || val.userId.toLowerCase().substr(0, inp.length) == inp.toLowerCase());
            })
            if (inp.length == 10 && !isNaN(Number(inp)) && !matchedData[0]) {
                fetch('./ajax/matchingUser.php?user=' + inp).then(
                    res => { return res.json(); }).then(data => {
                    if (data) {
                        // console.log(!(data.user_name == newUsersId[0]));
                        // console.log(data.user_name == newUsersId[0]);
                        if (!(data.user_name + '_' + data.name + '_user' == newUsersId[0])) {
                            // console.log('already in new Users List');
                            var contact_img = create_el('img', 'src=./uploads/' + data.dp_src);
                            var contact_icon = create_el('div', 'class=contact_icon col-2,id=' + data.user_name + '_icon,onclick=display_image(this.children[0].src)');
                            contact_icon.appendChild(contact_img);
                            var title_node = document.createTextNode(data.name);
                            var contact_title = create_el('div', 'class=contact_title col-8');
                            contact_title.appendChild(title_node);
                            var last_mess_time_node = document.createTextNode('');
                            var last_mess_time = create_el('div', 'class=last_message_time col-4');
                            last_mess_time.appendChild(last_mess_time_node);
                            var last_mess_node = document.createTextNode('Click to Start Chating..');
                            var last_mess = create_el('div', 'class=col-10 last_message');
                            last_mess.appendChild(last_mess_node);
                            var contact_detail = create_el('div', 'class=contact_detail col-10,id=' + data.user_name + '_detail,onclick=header(this)');
                            contact_detail.appendChild(contact_title);
                            contact_detail.appendChild(last_mess_time);
                            contact_detail.appendChild(last_mess);
                            var contact_div = create_el('div', 'class=contact col-12,id=' + data.user_name + '_' + data.name + '_user');
                            contact_div.appendChild(contact_icon);
                            contact_div.appendChild(contact_detail);
                            searchResult.firstElementChild.nextElementSibling.insertAdjacentElement('afterend', contact_div);
                            newUsersId.push(data.user_name + '_' + data.name + '_user');
                        }
                    }
                    // else  
                    // console.log('non Matched');


                }).catch(err => { console.log(err) });

            } else {
                // console.log(newUsersId[0]);
                if (newUsersId[0]) {
                    document.getElementById(newUsersId[0]).remove();
                    newUsersId.pop();
                }
            }
        } else {
            // console.log(newUsersId[0]);
            if (newUsersId[0]) {
                document.getElementById(newUsersId[0]).remove();
                newUsersId.pop();
            }
        }
        // else if (inp.length == 10 && !isNaN(Number(inp))) {
        //     fetch('./ajax/matchingUser.php?user=' + inp).then(
        //         res => { return res.json(); }).then(data => {
        //         console.log(data);
        //     }).then(err => { console.log(err) });
        //     console.log('Addcontact', );
        // }
        // console.log(matchedData);
        // console.log(unMatchedData);
        if (matchedData) {
            if (matchedData.length > 0) {
                for (let i = 0; i < matchedData.length; i++) {
                    ref = document.querySelector('#contact_inner').firstChild;
                    newContact = document.getElementById(matchedData[i].id);
                    searchResult.firstElementChild.insertAdjacentElement('afterend', newContact);
                }
            }

        } else {
            unMatchedData = searchData;
        }
        contactList = document.querySelector('#contact_list');
        for (let i = 0; i < unMatchedData.length; i++) {
            element = document.getElementById(unMatchedData[i].id);
            contactList.insertAdjacentElement('beforeend', element);
        }
        // }
    })
}