const requireFill = $('requireFill')


handleChangeCategory = () => {
    requireFill.style.display = "none";
    $('btnSearch').removeAttribute('disabled')
}

category.addEventListener('change',handleChangeCategory)

