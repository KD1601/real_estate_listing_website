const logo = $('logo-header')

const goMainPage = () => {
    handleLogOut()
}

function goMain() {
    var dirPath = dirname(location.href);
    fullPath = dirPath + "/index.php";
    window.location = fullPath;
}

function dirname(path) {
    return path.replace(/\\/g, '/').replace(/\/[^\/]*$/, '');
}

logo.addEventListener('click',goMain)

