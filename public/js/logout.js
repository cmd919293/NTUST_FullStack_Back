(function () {
    addEventListener('load', function () {
        let logoutBtn = document.getElementById('logoutBtn');
        if (logoutBtn) {
            logoutBtn.addEventListener('click', function () {
                let token = localStorage['token'];
                event.preventDefault();
                fetch(`${location.origin}/api/logout`, {
                    headers: new Headers({
                        'Content-Type': 'application/json',
                        'Authorization': 'Bearer' + token
                    }),
                    mode: "cors",
                })
                    .then(r => r.json())
                    .catch(console.error)
                    .then(r => {
                        if (r.status) {
                            localStorage.removeItem('token');
                        }
                    });
                document.getElementById('logout-form').submit();
            });
        }
    });
})();
