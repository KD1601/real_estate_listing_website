const post = $('post')

function notLog() {
    handleDN()
}

function logged() {
    var dirPath = dirname(location.href);
    fullPath = dirPath + "/upload.php";
    window.location=fullPath;
}

function goMain() {
    var dirPath = dirname(location.href);
    fullPath = dirPath + "/index.php";
    window.location=fullPath;
}

function dirname(path)
{
   return path.replace(/\\/g,'/').replace(/\/[^\/]*$/, '');
}