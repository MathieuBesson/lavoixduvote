// Add acordion on each section
document.querySelectorAll(".what-are-presidentials-wrapper__explanation-list-item-title").forEach(section => {
    section.addEventListener("click", e => {
        // Toggle icon X to -
        e.target.parentNode.querySelector(".toggle-open-icon").classList.toggle("close");
        let sectionContent = e.target.parentNode.querySelector(".what-are-presidentials-wrapper__explanation-list-item-content")
        sectionContent.classList.toggle("close");
        // Update Section content height
        sectionContent.style.maxHeight = sectionContent.style.maxHeight ? null : sectionContent.scrollHeight + "px"
    });
})




















const dragNav = require('./drag-nav');

// All tab button
const buttons = document.querySelectorAll('.drag-nav-slider-wrapper__list-item button');
// All defintions with word
const definitions = document.querySelectorAll('.what-are-presidentials-wrapper__explanation-list-item');

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
 * @param {string} id - Id of the theme choose
 */
function displayDefinitionByCategorie(id) {
    [...definitions].forEach(definition => {
        if ([definition.dataset.theme, 'all'].includes(id)) {
            definition.classList.remove('invisible');
        } else {
            definition.classList.add('invisible');
        }
    })
}

// Slide nav for small screens
var sliderWrapper = document.querySelector('.drag-nav-slider-wrapper'),
    sliderItems = document.querySelector('.drag-nav-slider-wrapper__list');

dragNav(sliderItems, sliderWrapper);