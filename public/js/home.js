(function () {
    addEventListener('load', function () {
        let container = document.querySelector('main.py-4 .container > div');
        GetAmount().then(r => {
            GetAllCard(container, 0, 50, r);
        });
    });

    function createCard(titleStr, imgSrc, id) {
        let card = document.createElement('div');
        let header = document.createElement('div');
        let title = document.createElement('span');
        let clsBtn = document.createElement('span');
        let body = document.createElement('div');
        let hid = document.createElement('input');
        hid.type='hidden';
        hid.value = id;
        let img = new Image();
        card.className = 'card';
        header.className = 'card-header';
        clsBtn.className = 'close';
        clsBtn.addEventListener('click', removeCard);
        body.className = 'card-body';
        img.width = img.height = 200;
        img.src = imgSrc;
        title.innerHTML = titleStr;
        body.append(img);
        header.append(title);
        header.append(clsBtn);
        card.append(hid);
        card.append(header);
        card.append(body);
        return card;
    }

    function GetAmount() {
        return fetch(`${location.origin}/api/GetMonstersAmount`)
            .then(r => r.text())
            .catch(e => {
                console.error(e);
                return 0;
            })
            .then(r => parseInt(r.toString()));
    }

    function GetMonsters(s, e) {
        return fetch(`${location.origin}/api/GetMonsters/${s}/${e}`)
            .then(r => r.json())
            .catch(e => {
                console.error(e);
                return {};
            });
    }

    function GetAllCard(container, start, end, limit) {
        if (start >= limit) return;
        end = Math.min(limit, end);
        GetMonsters(start, end - 1).then(r => {
            for (let i of r) {
                let card = createCard(`${container.childElementCount + 1}.${i['NAME']}`, i['Icon']['src'], i['id']);
                container.append(card);
            }
            GetAllCard(container, end, end + 50, limit);
        });
    }

    function deleteMonster(id) {
        let token = localStorage['token'];
        return fetch(`${location.origin}/api/DeleteMonster/${id}?token=${token}`, {
            method: 'DELETE',
        })
            .then(r => r.json())
            .catch(e => {
                console.error(e);
                return {status: false};
            });
    }

    function removeCard() {
        let card = this.parentNode.parentNode;
        let id = card.querySelector('input[type=hidden]').value;
        let title = card.querySelector('.card-header span').innerText.replace(/^\d+\./, '');
        if (confirm(`確定要刪除 ${title} 嗎?\n(無法復原)`)) {
            deleteMonster(id).then(r => {
                if (r.status) {
                    card.remove();
                }
            });
        }
    }
})();
