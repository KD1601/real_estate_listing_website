const changePass = $('changePass')
const formDMK = $('DMK')
const btnCloses1 = $('closes1')
const btnDMK = $('bntDMK')
const emailDMK = $('emailDMK')
const passwordDMK = $('passwordDMK')
const passwordDMK2 = $('passwordDMK2')
const messageError2 = $('messageError2')

const handleChangePass = () => {
    jQuery('html,body').animate({ scrollTop: 0 }, 'fast');
    blur__screen.style.display = "block"
    formDMK.style.display = "block"
}

const checkInfo = (e) => {
    if (emailDMK.value.length == 0) {
        e.preventDefault()
        emailDMK.focus()
        messageError2.innerHTML = "Vui lòng nhập email"
        emailDMK.addEventListener('keyup', handleKeyUps)
    } else if (!ValidateEmail(emailDMK)) {
        e.preventDefault()
        messageError2.innerHTML = "Vui lòng nhập đúng email"
        emailDMK.addEventListener('keyup', handleKeyUps)
    } else if (passwordDMK.value.length == 0) {
        e.preventDefault()
        passwordDMK.focus()
        messageError2.innerHTML = "Vui lòng nhập mật khẩu"
        passwordDMK.addEventListener('keyup', handleKeyUps)
    } else if (passwordDMK.value.length < 6) {
        e.preventDefault()
        passwordDMK.focus()
        messageError2.innerHTML = "Độ dài mật khẩu tối thiểu là 6 kí tự"
        passwordDMK.addEventListener('keyup', handleKeyUps)
    } else if (passwordDMK2.value != passwordDMK.value) {
        e.preventDefault()
        passwordDMK2.focus()
        messageError2.innerHTML = "Mật khẩu bạn nhập không khớp"
        passwordDMK2.addEventListener('keyup', handleKeyUp)
    } 
}

changePass.addEventListener('click', handleChangePass)
btnCloses1.addEventListener('click',handleExit)
btnDMK.addEventListener('click',checkInfo)