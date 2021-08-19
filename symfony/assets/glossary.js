// All tab button
const buttons = document.querySelectorAll('.glossary-wrapper__nav-list-item button');
// All defintions with word
const definitions = document.querySelectorAll('.glossary-wrapper__definitions-list-item');
// Research Icon magnifying glass
const researchIcon = document.querySelector('#research-icon');
// Research input
const researchInput = document.querySelector('#research-input');
// Nav List Wrapper
const navList = document.querySelector('.glossary-wrapper__nav-list-wrapper');
// Nav Research Wrapper
const navResearch = document.querySelector('#nav-research');
// Element to display in case of non-result
const noDefinitions = document.querySelector('#no-definitions');

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

// Toggle search input
researchIcon.addEventListener('click', e => {
    researchInput.classList.toggle('visible');
    navList.classList.toggle('no-visible');
    navResearch.classList.toggle('visible');
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
var sliderWrapper = document.getElementById('slider-nav-wrapper'),
    sliderItems = document.getElementById('slider-nav-wrapper__list');

function dragNav(items) {
    var posX1 = 0,
        posX2 = 0,
        posInitial;

    // Mouse events
    items.onmousedown = dragStart;

    // Touch events
    items.addEventListener('touchstart', dragStart);
    items.addEventListener('touchend', dragEnd);
    items.addEventListener('touchmove', dragAction);

    /**
     * Save the initial drag position and launch the the action of following the click and stop the drag
     * @param {*} e - Click event to start drag action
     */
    function dragStart(e) {
        e = e || window.event;
        e.preventDefault();
        posInitial = items.offsetLeft;

        if (e.type == 'touchstart') {
            posX1 = e.touches[0].clientX;
        } else {
            posX1 = e.clientX;
            document.onmouseup = dragEnd;
            document.onmousemove = dragAction;
        }
    }

    /**
     * Makes the slider follow the user's mouse
     * @param {*} e - Click event to drag the slide to follow th mouse
     */
    function dragAction(e) {
        e = e || window.event;

        if (e.type == 'touchmove') {
            posX2 = posX1 - e.touches[0].clientX;
            posX1 = e.touches[0].clientX;
        } else {
            posX2 = posX1 - e.clientX;
            posX1 = e.clientX;
        }
        const movement = items.offsetLeft - posX2;

        if (movement <= 0 && movement >= -sliderItems.offsetWidth + sliderWrapper.offsetWidth) {
            items.style.left = movement + "px";
        }
    }

    /**
     * Reset onmouseup and onmousemove at the end of drag
     * @param {*} e - Release event click to stop the drag
     */
    function dragEnd(e) {
        document.onmouseup = null;
        document.onmousemove = null;
    }
}

dragNav(sliderItems);