(function () {
    addEventListener('load', function () {
        localStorage.removeItem('email');
        localStorage.removeItem('password');
        let registerForm = document.getElementById('registerForm');
        if (registerForm) {
            registerForm.addEventListener('submit', function () {
                let f = new FormData(this);
                localStorage['email'] = f.get('email');
                localStorage['password'] = f.get('password');
            });
        }
    });
})();
