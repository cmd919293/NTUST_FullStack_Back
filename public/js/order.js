(function () {
    addEventListener('load', function () {
        let shipmentBtn = document.querySelectorAll('.footer-form button:not(:disabled)');
        if (shipmentBtn.length > 0) {
            shipmentBtn.forEach(function (btn) {
                btn.addEventListener('click', function () {
                    let id = this.parentNode.querySelector('input[type=hidden]').value;
                    fetch(`${location.origin}/api/Shipment/${id}`, {
                        headers: new Headers({
                            'Content-Type': 'application/json',
                            'Authorization': 'Bearer' + localStorage.token
                        }),
                    }).then(
                        r => r.json()
                    ).catch(e => {
                        console.warn(e);
                        return e;
                    }).then(r => {
                        if (r.status) {
                            location.reload();
                        }
                    });
                });
            });
        }
    });
})();
