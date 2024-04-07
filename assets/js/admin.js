const $ = document.getElementById.bind(document)

const logo = $('logo')
const signOutAdmin = $('signOut')
const triggerForm = $('triggerForm')
const showInf = $('showInf')
const x = $('x')
const OptionAP = $('OptionAP')
const tableAcceptPost = $('tableAcceptPost')
const managerUser = $('managerUser')
const tableUsers = $('tableUsers')




function signOut()
{
   var dirPath = dirname(location.href);
   fullPath = dirPath + "/index.php";
   window.location=fullPath;
}

function dirname(path) {
    return path.replace(/\\/g, '/').replace(/\/[^\/]*$/, '');
}

function autoSubmit(id, name, img1, img2, img3, owner, phoneContact)  {
    $('infHouseId').value = id
    $('infHouseName').value = name
    $('img1').value = img1
    $('img2').value = img2
    $('img3').value = img3
    $('owner').value = owner
    $('phoneContact').value = phoneContact
    triggerForm.submit()
}

const goAdminPage = () => {
var dirPath = dirname(location.href);
   fullPath = dirPath + "/admin.php";
   window.location=fullPath;
}

const handleExit = () => {
    showInf.style.display = "none"
    OptionAP.click()
}

const handleTable = () => {
    tableAcceptPost.style.display = "table"
    tableUsers.style.display = "none"
}

const handleTableUser = () => {
    tableUsers.style.display = "table"
    tableAcceptPost.style.display = "none"
}

logo.addEventListener('click',goAdminPage)
signOutAdmin.addEventListener('click',signOut)
x.addEventListener('click',handleExit)
OptionAP.addEventListener('click',handleTable)
managerUser.addEventListener('click',handleTableUser)


