const $ = document.getElementById.bind(document)
const btnSubmit = $('btnSubmit')
const inputName = $('name')
const inputMail = $('email')
const inputPass = $('pwd')
const inputPass2 = $('pwd2')
const checkboxAgree = $('checkbox-agree')
const messageError = $('messageError')
const btnSignIn = $('headerSignIn')
const formDN = $('formDN')
const blur__screen = $('blur__screen')
const btnClose = $('close')
const formDK = $('formDK')
const btnSignUp = $('headerSignUp')
const btnCloses = $('closes')
const buyHouse = $('buyHouse')
const rentHouse = $('rentHouse')






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

const handleKeyUp = () => {
    messageError.innerHTML = ""
}

const handleChecked = () => {
    messageError.innerHTML = ""
}

const handleClick = (e) => {
    if (inputName.value.trim().length == 0) {
        e.preventDefault()
        inputName.focus()
        messageError.innerHTML = "Vui lòng nhập tên"
        inputName.addEventListener('keyup', handleKeyUp)
    } else if (inputMail.value.length == 0) {
        e.preventDefault()
        inputMail.focus()
        messageError.innerHTML = "Vui lòng nhập email"
        inputMail.addEventListener('keyup', handleKeyUp)
    } else if (!ValidateEmail(inputMail)) {
        e.preventDefault()
        messageError.innerHTML = "Vui lòng nhập đúng email"
        inputMail.addEventListener('keyup', handleKeyUp)
    } else if (inputPass.value.length == 0) {
        e.preventDefault()
        inputPass.focus()
        messageError.innerHTML = "Vui lòng nhập mật khẩu"
        inputPass.addEventListener('keyup', handleKeyUp)
    } else if (inputPass.value.length < 6) {
        e.preventDefault()
        inputPass.focus()
        messageError.innerHTML = "Độ dài mật khẩu tối thiểu là 6 kí tự"
        inputPass.addEventListener('keyup', handleKeyUp)
    } else if (inputPass2.value != inputPass.value) {
        e.preventDefault()
        inputPass2.focus()
        messageError.innerHTML = "Mật khẩu bạn nhập không khớp"
        inputPass2.addEventListener('keyup', handleKeyUp)
    } else if (!checkboxAgree.checked) {
        e.preventDefault()
        messageError.innerHTML = "Vui lòng đồng ý với điều khoản dịch vụ"
        checkboxAgree.focus()
        checkboxAgree.addEventListener('change', handleChecked)
    }

}

const handleDN = () => {
    jQuery('html,body').animate({ scrollTop: 0 }, 'fast');
    blur__screen.style.display = "block"
    formDN.style.display = "block"
    formDK.style.display = "none"
}

const handleClickOut = () => {
    formDN.style.display = "none"
    formDK.style.display = "none"
    formDMK.style.display = "none"
    blur__screen.style.display = "none"
    project__house.style.display = "none"
}

const handleExit = () => {
    formDK.style.display = "none"
    formDN.style.display = "none"
    formDMK.style.display = "none"
    blur__screen.style.display = "none"
    project__house.style.display = "none"
}

const handleDK = () => {
    jQuery('html,body').animate({ scrollTop: 0 }, 'fast');
    blur__screen.style.display = "block"
    formDK.style.display = "block"
    formDN.style.display = "none"
}

const handleChangeBackground = () => {
    buyHouse.classList.add("changeBg")
    rentHouse.classList.remove("changeBg")
}

const handleChangeBackground2 = () => {
    rentHouse.classList.add("changeBg")
    buyHouse.classList.remove("changeBg")
}



btnSubmit.addEventListener('click', handleClick)

btnSignIn.addEventListener('click',handleDN)

blur__screen.addEventListener('click',handleClickOut)

btnClose.addEventListener('click',handleExit)

btnSignUp.addEventListener('click',handleDK)

btnCloses.addEventListener('click',handleExit)

buyHouse.addEventListener('click',handleChangeBackground)

rentHouse.addEventListener('click',handleChangeBackground2)






