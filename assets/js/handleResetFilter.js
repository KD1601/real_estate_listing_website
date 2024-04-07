const refresh__img = $('refresh__img')
const category = $('category')
const selectLocation = $('selectLocation')
const rent = $('rent')
const area = $('area')
const bedrooms = $('bedrooms')
const toilet = $('toilet')
const inputText__name = $('inputText__name')


const handleReset = () => {
    category.selectedIndex = 0
    location.selectedIndex = 0
    rent.selectedIndex = 0
    area.selectedIndex = 0
    bedrooms.selectedIndex = 0
    toilet.selectedIndex = 0
    inputText__name.value = ""
}

refresh__img.addEventListener('click',handleReset)