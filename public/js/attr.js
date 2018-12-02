(function () {
    addEventListener('load', function () {
        let container = document.querySelector('main.py-4 .container > div');
        let create = document.querySelector('div.create');
        if (create) {
            create.addEventListener('click', GoToAdd);
        }
        if (container) {
            GetAttributes().then(r => {
                for (let i of r) {
                    let card = createAttrCard(i);
                    container.append(card);
                }
            });
        }
    });

    function GetAttributes() {
        return fetch(`${location.origin}/api/GetAttributes`)
            .then(r => r.json())
            .catch(e => {
                console.error(e);
                return {};
            });
    }

    function createAttrCard(AttrStructure) {
        let card = document.createElement('div');
        let header = document.createElement('div');
        let id = document.createElement('span');
        let clsBtn = document.createElement('span');
        let body = document.createElement('div');
        let list = document.createElement('div');
        let hid = document.createElement('input');
        let keys = Object.keys(AttrStructure).sort().filter(b => b.startsWith('NAME'));
        list.className = 'list-group list-group-flush';
        for (let i of keys) {
            let div = document.createElement('div');
            div.className = 'list-group-item';
            div.innerHTML = AttrStructure[i];
            list.append(div);
        }
        hid.type = 'hidden';
        hid.value = AttrStructure['value'];
        card.className = 'card';
        header.className = 'card-header';
        clsBtn.className = 'close';
        body.className = 'card-body p-0';
        clsBtn.addEventListener('click', removeCard);
        card.addEventListener('click', GoToEdit);
        body.append(list);
        header.append(id);
        header.append(clsBtn);
        card.append(hid);
        card.append(header);
        card.append(body);
        return card;
    }

    function deleteAttribute(id) {
        let token = localStorage['token'];
        return fetch(`${location.origin}/api/DeleteAttribute/${id}?token=${token}`, {
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
            deleteAttribute(id).then(r => {
                if (r.status) {
                    card.remove();
                }
            });
        }
    }

    function GoToEdit() {
        if (event.target !== this.querySelector('.close')) {
            let id = this.querySelector('input[type=hidden]').value;
            location.href = `${location.origin}/Attribute/${id}/edit`;
        }
    }

    function GoToAdd() {
        location.href = `${location.origin}/Attribute/create`;
    }
})();
