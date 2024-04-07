const btnDN = $('signIn')
const userEmail = $('userEmail')
const userPwd = $('userPwd')
const messageErrors = $('messageErrors')

function ValidateEmail(inputText) {
    let mailFormat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
    if (inputText.value.match(mailFormat)) {
        return true;
    }
    else {
        inputMail.focus();
        return false;
    }
}

const handleKeyUps = () => {
    messageErrors.innerHTML = ""
}

const validateDN = (e) => {
    if (userEmail.value.length == 0) {
        e.preventDefault()
        userEmail.focus()
        messageErrors.innerHTML = "Vui lòng nhập email"
        userEmail.addEventListener('keyup', handleKeyUps)
    } else if (!ValidateEmail(userEmail)) {
        e.preventDefault()
        messageErrors.innerHTML = "Vui lòng nhập đúng email"
        userEmail.addEventListener('keyup', handleKeyUps)
    } else if (userPwd.value.length == 0) {
        e.preventDefault()
        userPwd.focus()
        messageErrors.innerHTML = "Vui lòng nhập mật khẩu"
        userPwd.addEventListener('keyup', handleKeyUps)
    } else if (userPwd.value.length < 6) {
        e.preventDefault()
        userPwd.focus()
        messageErrors.innerHTML = "Độ dài mật khẩu tối thiểu là 6 kí tự"
        userPwd.addEventListener('keyup', handleKeyUps)
    }

    
}
btnDN.addEventListener('click',validateDN)