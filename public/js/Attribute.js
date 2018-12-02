(function () {
    addEventListener('load', function () {
        let createBtn = document.getElementById('createAttribute');
        if (createBtn) {
            createBtn.addEventListener('click', function () {
                let f = new FormData(this.form);
                let token = localStorage["token"];
                fetch(`${location.origin}/api/CreateAttribute`, {
                    method: 'POST',
                    headers: new Headers({
                        'Authorization': 'Bearer' + token,
                    }),
                    body: f,
                    mode: "cors",
                })
                    .then(r => r.json())
                    .catch(e => console.log(e))
                    .then(r => {
                        if (r.status) {
                            location.href = `${location.origin}/Attribute`;
                        }
                    });
            });
        }
        let updateBtn = document.getElementById('updateAttribute');
        if (updateBtn) {
            updateBtn.addEventListener('click', function () {
                let f = new FormData(this.form);
                let token = localStorage["token"];
                fetch(`${location.origin}/api/UpdateAttribute`, {
                    method: 'POST',
                    headers: new Headers({
                        'Authorization': 'Bearer' + token,
                    }),
                    body: f,
                    mode: "cors",
                })
                    .then(r => r.json())
                    .catch(e => console.log(e))
                    .then(r => {
                        if (r.status) {
                            location.href = `${location.origin}/Attribute`;
                        }
                    });
            });
        }
    });
})();
