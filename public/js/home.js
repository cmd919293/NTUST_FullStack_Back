(function () {
    addEventListener('load', function () {
        let container = document.querySelector('main.py-4 .container > div');
        GetAmount().then(r => {
            GetAllCard(container, 0, 50, r);
        });
    });

    function createCard(titleStr, imgSrc) {
        let card = document.createElement('div');
        let header = document.createElement('div');
        let title = document.createElement('span');
        let clsBtn = document.createElement('span');
        let body = document.createElement('div');
        let img = new Image();
        card.className = 'card';
        header.className = 'card-header';
        clsBtn.className = 'close';
        body.className = 'card-body';
        img.width = img.height = 200;
        img.src = imgSrc;
        title.innerHTML = titleStr;
        body.append(img);
        header.append(title);
        header.append(clsBtn);
        card.append(header);
        card.append(body);
        return card;
    }

    function GetAmount() {
        return fetch(`${location.origin}/api/GetMonstersAmount`)
            .then(r => r.text())
            .catch(console.error)
            .then(r => parseInt(r.toString()));
    }

    function GetMonsters(s, e) {
        return fetch(`${location.origin}/api/GetMonsters/${s}/${e}`)
            .then(r => r.json())
            .catch(console.error);
    }

    function GetAllCard(container, start, end, limit) {
        if (start >= limit) return;
        end = Math.min(limit, end);
        GetMonsters(start, end - 1).then(r => {
            for (let i of r) {
                let card = createCard(`${i['id']}.${i['NAME']}`, i['Icon']['src']);
                container.append(card);
            }
            GetAllCard(container, end , end + 50, limit);
        });
    }
})();
