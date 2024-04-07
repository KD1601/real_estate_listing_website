const triggerForm = $('triggerForm')

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