const dragNav = require('./drag-nav');

const comparatorWrapper = document.querySelector('.comparator-wrapper'); 
const allCardCandidates = document.querySelectorAll('.candidates-grid-wrapper__item'); 
const nbCandidateCardsSelected = document.getElementById('nb-candidates-selected');
const startComparaison = document.getElementById('start-comparaison'); 
const comparatorHeaderStandard = document.querySelector('.comparator-wrapper__header-standard');
const comparatorHeaderReveal = document.querySelector('.comparator-wrapper__header-reveal');
const candidateWrapper = document.querySelector('.candidates-grid-wrapper');
const comparatorRevealContent = document.querySelector('.comparator-wrapper__content-reveal');
const tickElementClass = 'tick-selection-candidate';
const tickElement = (number) => `<span class="${tickElementClass}">${number}</span>`;
let candidateCardsSelected = {};

let stepComparaison = 'choice'; 

let idsTicks = [1, 2, 3, 4]; 
let nbElementSelected = 0; 

const gridDisplayStandard = {normal: 'col-6', lg: 'col-lg-3'};
const gridDisplayComparator = {normal: 'col-3'};

allCardCandidates.forEach(candidateCard => {
    candidateCard.addEventListener('click', e => {
        if(stepComparaison === 'choice'){
            if(candidateCard.innerHTML.includes(tickElementClass)){
                removeCandidate(candidateCard.querySelector('.' + tickElementClass))
    
                // Update number of candidates selected
                nbElementSelected--; 
                updateNbcandidateCardsSelected(nbElementSelected);
    
                // Add .grey-filter class
                candidateCard.querySelector('.card').classList.add('grey-filter');
            } else {
                if(idsTicks.length !== 0){
                    addCandidate(candidateCard);
    
                    // Update number of candidates selected
                    nbElementSelected++; 
                    updateNbcandidateCardsSelected(nbElementSelected);
    
                    // Remove .grey-filter class
                    candidateCard.querySelector('.card').classList.remove('grey-filter');
                } else {
                    // Message erreur
                    addFlashMessage('Vous ne pouvez selectionner que 4 éléments', 'icon-lvdv-shield-white'); 
                }
            }
            console.log(candidateCardsSelected)
        }
    })
})

startComparaison.addEventListener('click', e => {

    if(Object.keys(candidateCardsSelected).length >= 2){
        stepComparaison = 'reveal'; 
        comparatorWrapper.classList.add('col-12', 'col-lg-10', 'mx-auto');
        comparatorHeaderStandard.classList.add('d-none');
        comparatorHeaderReveal.classList.add('d-flex');

        comparatorRevealContent.classList.remove('d-none')

        let candidateSelectedNames = []
        for (const order in candidateCardsSelected) {
            candidateSelectedNames.push(candidateCardsSelected[order]); 
        }

        allCardCandidates.forEach(candidate => {
            if(!candidateSelectedNames.includes(candidate.dataset.name)){
                candidate.style.display = 'none'; 
            } else {
                candidate.querySelector('.card-title').style.display = 'none'; 
                candidate.querySelector('.card-subtitle').style.display = 'none'; 
                for(className in gridDisplayStandard){
                    candidate.classList.remove(gridDisplayStandard[className]); 
                }
                for(className in gridDisplayComparator){
                    candidate.classList.add(gridDisplayComparator[className]); 
                }
                candidate.classList.add('comparator-card'); 
        
            }
        })

        startComparaison.style.display = 'none'; 

        document.querySelectorAll('.tick-selection-candidate').forEach(tick => {
            tick.style.display = 'none'; 
        })


    } else {
        addFlashMessage('Sélectionner au moins 2 candidats pour effectuer une comparaison', 'icon-lvdv-shield-white'); 
    }

})


// Slide nav for small screens
var sliderWrapper = document.getElementById('slider-nav-wrapper'),
    sliderItems = document.getElementById('slider-nav-wrapper__list');

dragNav(sliderItems, sliderWrapper);

// Afficher les images des candidats selectionnés 
// col-2 + gap à la place de col-3 sur toutes les images selectionnées 
// on vire le nom du candidat 





/**
 * Remove tick to a candidate card 
 * @param {Element} tick - Tick to remove 
*/
function removeCandidate(tick){
    const counter = parseInt(tick.textContent);

    // Add Id of the tick in array
    idsTicks.push(counter);

    // Remove candidate of selected candidates 
    delete candidateCardsSelected[counter]; 

    // Remove the tick of the DOM
    tick.parentNode.removeChild(tick)
}

/**
 * Add tick to a candidate card 
 * @param {Element} candidate - Candidate card to display tick 
*/
function addCandidate(candidate){
    // Remove the tick in the array
    const counter = idsTicks.splice(idsTicks.indexOf(Math.min(...idsTicks)), 1);

    // Add candidate to selected candidates 
    candidateCardsSelected[counter] =  candidate.dataset.name;

    // Add the tick in the DOM
    candidate.innerHTML += tickElement(counter);
}

function updateNbcandidateCardsSelected(nbElementSelected){
    nbCandidateCardsSelected.textContent = nbElementSelected === 0 ? '...' : nbElementSelected; 
}

/**
 * Display flash message on screen and remove it 
 * @param {string} message - Content of flash message 
 * @param {string} icon - CSS class of the icon choose
*/
function addFlashMessage(message, icon){
    if(document.body.querySelector('.flash-message-wrapper') === null){
        const flashMessage = createFlashMessage(message, icon); 
        document.body.appendChild(flashMessage);
        setTimeout(() => { document.body.removeChild(flashMessage); }, 6000);
    }
}

/**
 * Create flash message element 
 * @param {string} message - Content of flash message 
 * @param {string} icon - CSS class of the icon choose
 * @return {Element} - The HTML flash message 
*/
const createFlashMessage = (message, icon) => htmlToElement(`<div class="flash-message-wrapper d-flex justify-content-center">
                                                                <p class="flash-message-wrapper__content d-flex">
                                                                    <i class="icon ${icon}"></i>
                                                                    ${message}
                                                                </p>
                                                            </div>`)

/**
 * Transform a string to DOM element  
 * @param {string} html - The string to stransform in HTML 
 * @return {Element} A DOM element 
*/
 function htmlToElement(html) {
    var template = document.createElement('template');
    html = html.trim(); // Never return a text node of whitespace as the result
    template.innerHTML = html;
    return template.content.firstChild;
}