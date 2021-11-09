const dragNav = require('./drag-nav');

// All tab button
const buttons = document.querySelectorAll('.drag-nav-slider-wrapper__list-item button');
// All defintions with word
const definitions = document.querySelectorAll('.glossary-wrapper__definitions-list-item');
// Research Icon magnifying glass
const researchIcon = document.querySelector('#research-icon');
// Research input
const researchInput = document.querySelector('#research-input');
// Nav List Wrapper
const navList = document.querySelector('.drag-nav-slider-wrapper');
// Nav Research Wrapper
const navResearch = document.querySelector('#nav-research');
// Element to display in case of non-result
const noDefinitions = document.querySelector('#no-definitions');
// Get parameter to search
const queryArgs = window.location.pathname.split('/');

// Add .active class for nav items and display or not definitions
[...buttons].forEach(currentButton => {
    currentButton.addEventListener('click', e => {
        [...buttons].forEach(button => {
            button.classList.remove('active')
        })
        currentButton.classList.add('active')

        displayDefinitionByCategorie(currentButton.dataset.id);
    });
})

/**
 * Display all definition for the tab choose
 * @param {string} id - Id of the category choose
 */
function displayDefinitionByCategorie(id) {
    [...definitions].forEach(definition => {
        if ([definition.dataset.category, 'all'].includes(id)) {
            definition.classList.remove('invisible');
        } else {
            definition.classList.add('invisible');
        }
    })
}

function toggleIcon(icon){
    const iconsClass = {
        'close': 'icon-lvdv-world-research', 
        'open': 'icon-twitter-primary'
    }

    if(icon.className.split(' ').includes(iconsClass.close)){
        icon.classList.remove(iconsClass.close); 
        icon.classList.add(iconsClass.open); 
    } else {
        icon.classList.remove(iconsClass.open); 
        icon.classList.add(iconsClass.close); 
    }
}

// Toggle search input
researchIcon.addEventListener('click', e => {
    researchInput.classList.toggle('visible');
    navList.classList.toggle('no-visible');
    navResearch.classList.toggle('visible');
    toggleIcon(researchIcon); 
})

// Display defintion in function of target data in input
researchInput.addEventListener('input', e => {
    let nbVisible = 0;
    // Comparaison between definition word and text enter in search input
    definitions.forEach(definition => {
        if (definition.querySelector('.glossary-wrapper__definitions-list-item-title').textContent.toLowerCase().includes(e.target.value.toLowerCase())) {
            nbVisible++;
            definition.classList.remove('invisible');
        } else {
            definition.classList.add('invisible');
        }
    })

    // If no defintions display default message
    if (nbVisible == 0) {
        noDefinitions.style.display = 'block';
    } else {
        noDefinitions.style.display = 'none';
    }
})


// Slide nav for small screens
var sliderWrapper = document.querySelector('.drag-nav-slider-wrapper'),
    sliderItems = document.querySelector('.drag-nav-slider-wrapper__list');

dragNav(sliderItems, sliderWrapper);

// Split the first param
queryArgs.shift();
if (queryArgs.length > 1) {
    // We have a search term
    researchIcon.dispatchEvent(new Event('click'));
    researchInput.value = decodeURIComponent(decodeURIComponent(queryArgs[1]));
    researchInput.dispatchEvent(new Event('input', { bubbles: true}));
}