const dragNav = require('./drag-nav'),
    flashMessage = require('./flash-message'),
    comparatorWrapper = document.querySelector('.comparator-wrapper'),
    allCardCandidates = document.querySelectorAll('.candidates-grid-wrapper__item'),
    nbCandidateCardsSelected = document.getElementById('nb-candidates-selected'),
    startComparaisonButton = document.getElementById('start-comparaison'),
    comparatorHeaderStandard = document.querySelector('.comparator-wrapper__header-standard'),
    comparatorHeaderReveal = document.querySelector('.comparator-wrapper__header-reveal'),
    candidateWrapper = document.querySelector('.candidates-grid-wrapper'),
    mesuresButtons = document.querySelectorAll('.mesure-list__title'),
    measuresGroup = document.querySelectorAll('.comparator-wrapper-measures__theme'),
    comparatorRevealContent = document.querySelector('.comparator-wrapper__content-reveal'),
    sliderWrapper = document.getElementById('slider-nav-wrapper'),
    sliderItems = document.getElementById('slider-nav-wrapper__list');


const tickElementClass = 'tick-selection-candidate';
const tickElement = (number) => `<span class="${tickElementClass}">${number}</span>`;
const nbMaxCandidatesToCompare = 4;
const nbMinCandidatesToCompare = 2;
let candidateCardsSelectedByOrder = {};

let stepComparaison = 'choice';

let idsTicks = [1, 2, 3, 4];
let nbElementSelected = 0;

const gridDisplayStandard = {normal: 'col-6', lg: 'col-lg-3'};
const gridDisplayComparator = {normal: 'col-sm-3', sm: 'col-6'};

// Event listener on choice of candidates to compare
allCardCandidates.forEach(candidateCard => {
    candidateCard.addEventListener('click', e => {
        // Activation of the choice only on "choice" part of the comparator (not in "reveal")
        if (stepComparaison === 'choice') {

            // Toggle on tick in card on click
            if (candidateCard.innerHTML.includes(tickElementClass)) {
                removeCandidate(candidateCard)

                // Update number of candidates selected
                nbElementSelected--;
                updateNbCandidateCardsSelected(nbElementSelected);

                // Add .grey-filter class
                candidateCard.querySelector('.card').classList.add('grey-filter');
            } else {
                if (nbElementSelected <= nbMaxCandidatesToCompare) {
                    addCandidate(candidateCard);

                    // Update number of candidates selected
                    nbElementSelected++;
                    updateNbCandidateCardsSelected(nbElementSelected);

                    // Remove .grey-filter class
                    candidateCard.querySelector('.card').classList.remove('grey-filter');
                } else {
                    // Error message
                    flashMessage('Vous ne pouvez selectionner que ' + nbMaxCandidatesToCompare + ' éléments', 'icon-lvdv-shield-white');
                }
            }
        }
    })
})

// Passage to the reveal of the comparator on click on start button
startComparaisonButton.addEventListener('click', e => {
    // Verification of the number of candidates choose
    if (Object.keys(candidateCardsSelectedByOrder).length >= nbMinCandidatesToCompare) {
        stepComparaison = 'reveal';
        // Pass screen to col-10 on large screen
        comparatorWrapper.classList.add('col-12', 'col-lg-10', 'mx-auto');

        // Don't display standard header and display reveal header
        comparatorHeaderStandard.classList.add('d-none');
        comparatorHeaderReveal.classList.add('d-flex');

        // Display comparator measures
        comparatorRevealContent.classList.remove('d-none')

        allCardCandidates.forEach(candidate => {
            // Don't display all candidates cards
            if (!Object.keys(candidateCardsSelectedByOrder).includes(candidate.dataset.name)) {
                candidate.classList.add('d-none');
            } else {
                // Don't display all candidates card titles
                candidate.querySelector('.card-title').classList.add('d-none');
                candidate.querySelector('.card-subtitle').classList.add('d-none');

                // Change col disposition on candidates card
                for (className in gridDisplayStandard) {
                    candidate.classList.remove(gridDisplayStandard[className]);
                }
                for (className in gridDisplayComparator) {
                    candidate.classList.add(gridDisplayComparator[className]);
                }
                candidate.classList.add('comparator-card');
            }
        })

        // Don't display start comparaison button
        startComparaisonButton.classList.add('d-none');

        // Don't display all tick on candidates cards
        document.querySelectorAll('.tick-selection-candidate').forEach(tick => {
            tick.classList.add('d-none');
        })

        // Click on the first measure
        onClickOnOneMeasure(mesuresButtons[0]);
    } else {
        // Error message
        flashMessage('Sélectionner au moins 2 candidats pour effectuer une comparaison', 'icon-lvdv-shield-white');
    }
})

// Event on click on measure nav
mesuresButtons.forEach(measureButton => {
    measureButton.addEventListener('click', () => {
        onClickOnOneMeasure(measureButton);
    })
})

/**
 * Reste à faire :
 *      - Revenir au choix du des candidats du comparateur
 */

/**
 * Questions :
 *      - A voir avec sensei : Mettre fix la barre des noms de mesure dès qu'elle touche le haut de la page
 *      - Poser la question si le 'comparer les X programmes' est nécéssaire et pas seulement => "compareer les programmes"
 */

// Slide nav for small screens
dragNav(sliderItems, sliderWrapper);

/**
 * Action on click on one measure button
 * @param {Element} measureButton - Clcked element
 */
function onClickOnOneMeasure(measureButton) {
    // Add active class on button
    toggleClass(mesuresButtons, measureButton, 'active');

    // Don't display candidates measures for candidates no selected
    [].slice.call(document.getElementById(measureButton.dataset.theme).children).forEach(candidateMeasure => {
        if (!Object.keys(candidateCardsSelectedByOrder).includes(candidateMeasure.dataset.name)) {
            candidateMeasure.classList.add('d-none');
        } else {
            candidateMeasure.classList.remove('d-none');
        }
    })

    // Sorting candidates choices by order of selection
    sortingCandidatesByOrderSelected(measureButton.dataset.theme);

    // Don't display the measureGroup if the theme no corresponding
    measuresGroup.forEach(measureGroup => {
        if (measureButton.dataset.theme !== measureGroup.dataset.theme) {
            measureGroup.classList.add('d-none');
        } else {
            measureGroup.classList.remove('d-none');
        }
    })
}


/**
 * Sort candidates by slected order choice
 */
function sortingCandidatesByOrderSelected(theme) {
    const themeGroup = document.getElementById(theme);

    candidatesMeasures = [].slice.call(themeGroup.children).sort((a, b) => candidateCardsSelectedByOrder[a.dataset.name] > candidateCardsSelectedByOrder[b.dataset.name] ? 1 : -1)

    // Delete previous order of candidates
    themeGroup.innerHTML = '';

    // Add new order of candidates
    candidatesMeasures.forEach((val) => {
        themeGroup.appendChild(val);
    });
}

/**
 * Remove active class of all and add active on selected
 */
function toggleClass(all, selected, className) {
    all.forEach(one => {
        one.classList.remove(className)
    })
    selected.classList.add(className);
}

/**
 * Remove tick to a candidate card
 * @param {Element} candidate - Candidate card to remove tick
 */
function removeCandidate(candidate) {

    const tick = candidate.querySelector('.' + tickElementClass);

    // Add Id of the tick in array
    idsTicks.push(parseInt(tick.textContent));

    // Remove candidate of selected candidates 
    delete candidateCardsSelectedByOrder[candidate.dataset.name];

    // Remove the tick of the DOM
    candidate.removeChild(tick)
}

/**
 * Add tick to a candidate card
 * @param {Element} candidate - Candidate card to display tick
 */
function addCandidate(candidate) {
    // Remove the tick in the array
    const counter = idsTicks.splice(idsTicks.indexOf(Math.min(...idsTicks)), 1)[0];

    // Add candidate to selected candidates
    candidateCardsSelectedByOrder[candidate.dataset.name] = counter;

    // Add the tick in the DOM
    candidate.innerHTML += tickElement(counter);
}

function updateNbCandidateCardsSelected(nbElementSelected) {
    nbCandidateCardsSelected.textContent = nbElementSelected === 0 ? '...' : nbElementSelected;
}