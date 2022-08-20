const url_location = '/api/auth/login';

var login_btn = document.getElementById('login');
login_btn.addEventListener('click', function () {

    var account = document.getElementById('account').value;
    var password = document.getElementById('password').value;

    if (account == null || password == null) {
        swal("登入失敗", "請確認帳號密碼是否正確", "error");
        return false;
    } else {
        let formData = new FormData();
        formData.append('account', account); //required
        formData.append('password', password); //required
        axios({
            method: 'post',
            params: {          
                account:account,
                password:password,
            },
            url: url_location,
            headers: { 'Content-Type': 'application/json' },
        }).then(function (response) {
            if (response.data.status == "Success") {
                
                localStorage.setItem('jwt', response.data.access_token);

                window.location = '/';

            }
            else if(response.data.message == "Invalid Credentials"){
                
                swal("登入失敗2", "請確認帳號密碼是否正確", "error");

            }

        }).catch(function (response) {
            if (response.response.message == "Invalid Credentials") {

                swal("登入失敗1", "請確認帳號密碼是否正確", "error");

            }else {
                
                swal(account,password, "error");

            }
            

        })

    }

});