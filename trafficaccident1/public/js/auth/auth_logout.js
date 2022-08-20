const url_logout = '/api/auth/logout';

var logout_btn = document.getElementById('logout');
logout_btn.addEventListener('click', function () {

    let token = localStorage.getItem('jwt');

    axios({
        method: 'POST',
        url: url_logout,
        headers: {
            "Accept": "application/json",
            "Authorization": "Bearer " + token
        },
    }).then(function (response) {

        if (response.data.status == "Success") {

            localStorage.removeItem('jwt');

            window.location = '/';

        }

        console.log(response);

    }).catch(function (response) {

        console.log(response);

    })

});
