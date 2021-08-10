// Apparition of each part of home page with the switchers 
const switcherGrid = document.querySelector('#switcher-grid');
const switcherRoll = document.querySelector('#switcher-roll');

const candidatesGridWrapper = document.querySelector('#candidates-grid-wrapper');
const candidatesRollWrapper = document.querySelector('#candidates-roll-wrapper');

function appearance(onClickElement, elementToAppear, elementToDisappear){
    onClickElement.addEventListener('click', () => {
        elementToAppear.classList.add('switcher-appearance');
        elementToDisappear.classList.remove('switcher-appearance');
    })
}

appearance(switcherGrid, candidatesGridWrapper, candidatesRollWrapper); 
appearance(switcherRoll, candidatesRollWrapper, candidatesGridWrapper); 
