function deviceHandler() {
    var contact_div = document.getElementById('contact_div');
    var rightDiv = document.getElementsByClassName('rightDiv')[0];
    var messDiv = document.querySelector('#message_maindiv');
    var BackBtn = document.querySelector('#backBtn');
    var headerUser = document.querySelector('#user_header');
    if (window.screen.width < 900) {
        if (flag == '<900') {
            if (messDiv.style.visibility == '') {
                contact_div.className = contact_div.className.replace(/(?!col-)\d+/, '12');
                rightDiv.className = rightDiv.className.replace(/(?!col-)\d+/, '0');

            } else {
                headerUser.className = 'contact_detail col-10';
                BackBtn.style.display = '';
                BackBtn.className = 'col-1 btn';
                contact_div.className = contact_div.className.replace(/(?!col-)\d+/, '0');
                rightDiv.className = rightDiv.className.replace(/(?!col-)\d+/, '12');
            }
            flag = '>900';

        } else {};
    } else {
        if (flag == '>900') {
            BackBtn.className = 'col-0 btn';
            BackBtn.style.display = 'none';
            headerUser.className = 'contact_detail col-11';

            contact_div.className = contact_div.className.replace(/(?!col-)\d+/, '4');
            rightDiv.className = rightDiv.className.replace(/(?!col-)\d+/, '8');

            flag = '<900';
        } else {}


    }
}