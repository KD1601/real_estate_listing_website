const project__house = $('project-house')
const btnCloses2 = $('closes2')

const handleBlur = () => {
    blur__screen.style.display = "block"
    project__house.style.display = "block"
}

btnCloses2.addEventListener('click',handleExit)