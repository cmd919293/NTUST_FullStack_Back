(function () {
    addEventListener('load', function () {
        if (location.pathname !== '/login') {
            if ('email' in localStorage && 'password' in localStorage) {
                let formData = new FormData();
                formData.append('email', localStorage['email']);
                formData.append('password', localStorage['password']);
                localStorage.removeItem('email');
                localStorage.removeItem('password');
                loginFetch(formData);
                return;
            }
        }
        let loginForm = document.getElementById('loginForm');
        if (loginForm) {
            loginForm.addEventListener('submit', function () {
                let formData = new FormData(this);
                loginFetch(formData);
            });
        }
    });

    function loginFetch(formData) {
        fetch(`${location.origin}/api/login`, {
            method: 'POST',
            body: formData,
            mode: "cors",
        })
            .then(r => r.json())
            .catch(e => console.log(e))
            .then(r => {
                if (r.status) {
                    localStorage['token'] = r.message.token;
                }
            });
    }
})();
