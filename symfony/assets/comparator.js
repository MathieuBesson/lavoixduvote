const allCandidates = document.querySelectorAll('.candidates-grid-wrapper__item'); 
const nbCandidatesSelected = document.getElementById('nb-candidates-selected');
const startComparaison = document.getElementById('start-comparaison'); 
const subTitle = document.getElementById('sub-title');
const candidateWrapper = document.querySelector('.candidates-grid-wrapper'); 
const tickElementClass = 'tick-selection-candidate';
const tickElement = (number) => `<span class="${tickElementClass}">${number}</span>`;
let candidatesSelected = {};

let idsTicks = [1, 2, 3, 4]; 
let nbElementSelected = 0; 

allCandidates.forEach(candidate => {
    candidate.addEventListener('click', e => {
        if(candidate.innerHTML.includes(tickElementClass)){
            removeCandidate(candidate.querySelector('.' + tickElementClass))

            // Update number of candidates selected
            nbElementSelected--; 
            updateNbCandidatesSelected(nbElementSelected);

            // Add .grey-filter class
            candidate.querySelector('.card').classList.add('grey-filter');
        } else {
            if(idsTicks.length !== 0){
                addCandidate(candidate);

                // Update number of candidates selected
                nbElementSelected++; 
                updateNbCandidatesSelected(nbElementSelected);

                // Remove .grey-filter class
                candidate.querySelector('.card').classList.remove('grey-filter');
            } else {
                // Message erreur
                addFlashMessage('Vous ne pouvez selectionner que 4 éléments', 'icon-lvdv-shield-white'); 
            }
        }
        console.log(candidatesSelected)
    })
})

startComparaison.addEventListener('click', e => {
    if(Object.keys(candidatesSelected).length >= 2){
        subTitle.textContent = 'Résultats de la comparaison...'; 

        let candidates = []
        for (const order in candidatesSelected) {
            candidates.push(candidatesSelected[order]); 
        }

        allCandidates.forEach(candidate => {
            if(!candidates.includes(candidate.dataset.name)){
                candidate.style.display = 'none'; 
            }
        })

        startComparaison.style.display = 'none'; 


    } else {
        addFlashMessage('Sélectionner au moins 2 candidats pour effectuer une comparaison', 'icon-lvdv-shield-white'); 
    }

})


/**
 * Remove tick to a candidate card 
 * @param {Element} tick - Tick to remove 
*/
function removeCandidate(tick){
    const counter = parseInt(tick.textContent);

    // Add Id of the tick in array
    idsTicks.push(counter);

    // Remove candidate of selected candidates 
    delete candidatesSelected[counter]; 

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
    candidatesSelected[counter] =  candidate.dataset.name;

    // Add the tick in the DOM
    candidate.innerHTML += tickElement(counter);
}

function updateNbCandidatesSelected(nbElementSelected){
    nbCandidatesSelected.textContent = nbElementSelected === 0 ? '...' : nbElementSelected; 
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