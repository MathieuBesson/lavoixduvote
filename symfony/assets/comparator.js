const dragNav = require("./drag-nav"),
    flashMessage = require("./flash-message"),
    comparatorWrapper = document.querySelector(".comparator-wrapper"),
    allCardCandidates = document.querySelectorAll(
        ".candidates-grid-wrapper__item"
    ),
    nbCandidateCardsSelected = document.querySelectorAll(
        ".nb-candidates-selected"
    ),
    startComparaisonButtons = document.querySelectorAll(".start-comparaison"),
    comparatorHeaderStandard = document.querySelector(
        ".comparator-wrapper__header-standard"
    ),
    comparatorHeaderReveal = document.querySelector(
        ".comparator-wrapper__header-reveal"
    ),
    candidateWrapper = document.querySelector(".candidates-grid-wrapper"),
    mesuresButtons = document.querySelectorAll(".mesure-list__title"),
    measuresGroup = document.querySelectorAll(
        ".comparator-wrapper-measures__theme"
    ),
    comparatorRevealContent = document.querySelector(
        ".comparator-wrapper__content-reveal"
    ),
    sliderWrapper = document.getElementById("slider-nav-wrapper"),
    sliderItems = document.getElementById("slider-nav-wrapper__list"),
    comparatorWrapperGrid = document.querySelector(".comparator-wrapper-grid"),
    returnToChoice = document.getElementById("return-to-choice");

const tickElementClass = "tick-selection-candidate";
const tickElement = (number) =>
    `<span class="${tickElementClass}">${number}</span>`;
const nbMaxCandidatesToCompare = 4;
const nbMinCandidatesToCompare = 2;
let candidateCardsSelectedByOrder = {};

let stepComparaison = "standard";

let idsTicks = [1, 2, 3, 4];
let nbElementSelected = 0;

const gridDisplayStandard = ["col-6", "col-lg-3"];
const gridDisplayComparator = ["col-sm-3", "col-6"];

const comparatorWidthRevealClass = ["col-12", "col-lg-10", "mx-auto"];

// Event listener on choice of candidates to compare
allCardCandidates.forEach((candidateCard) => {
    candidateCard.addEventListener("click", (e) => {
        // Activation of the choice only on "choice" part of the comparator (not in "reveal")
        if (stepComparaison === "standard") {
            // Toggle on tick in card on click
            if (candidateCard.innerHTML.includes(tickElementClass)) {
                removeCandidate(candidateCard);

                // Update number of candidates selected
                nbElementSelected--;
                updateNbCandidateCardsSelected(nbElementSelected);

                // Add .grey-filter class
                candidateCard
                    .querySelector(".card")
                    .classList.add("grey-filter");
            } else {
	            if (nbElementSelected + 1 <= nbMaxCandidatesToCompare) {
                    addCandidate(candidateCard);

                    // Update number of candidates selected
                    nbElementSelected++;
                    updateNbCandidateCardsSelected(nbElementSelected);

                    // Remove .grey-filter class
                    candidateCard
                        .querySelector(".card")
                        .classList.remove("grey-filter");
                } else {
                    // Error message
                    flashMessage(
                        "Vous ne pouvez selectionner que " +
                            nbMaxCandidatesToCompare +
                            " éléments",
                        "icon-lvdv-shield-white"
                    );
                }
            }
        }
    });
});

// Passage to the reveal of the comparator on click on start button
['click', 'touchend'].forEach(function(e) {
	startComparaisonButtons.forEach(function(el) {
		el.addEventListener(e, (e) => {
			// Verification of the number of candidates choose
			if (
					Object.keys(candidateCardsSelectedByOrder).length >=
					nbMinCandidatesToCompare
			) {
				switchStandardToReveal("reveal");
				// Click on the first measure
				onClickOnOneMeasure(mesuresButtons[0]);
			} else {
				// Error message
				flashMessage(
						"Sélectionner au moins 2 candidats pour effectuer une comparaison",
						"icon-lvdv-shield-white"
				);
			}
		});
	});
})

// Event on click on measure nav
mesuresButtons.forEach((measureButton) => {
	['click', 'touchend'].forEach(function(e) {
		measureButton.addEventListener(e, () => {
			// if this measures is not already selected
			if (!measureButton.classList.contains("active")) {
				onClickOnOneMeasure(measureButton);
			}
		});
	})
});

// Action to return to choice screen
returnToChoice.addEventListener("click", () => {
    switchStandardToReveal("standard");
});

// Slide nav for small screens
dragNav(sliderItems, sliderWrapper);

/**
 * Switch between choice view and reveal view
 * @param state {string} - State of the screen 'standard' or 'reveal'
 */
function switchStandardToReveal(state = "reveal") {
    const oppositeState = state === "reveal" ? "standard" : "reveal";
    // Set action for each block
    let action = {};
    if (state === "reveal") {
        action = {
            toggleAdd: "add",
            toggleRemove: "remove",
        };
    } else {
        action = {
            toggleAdd: "remove",
            toggleRemove: "add",
        };
    }

    stepComparaison = state;

    returnToChoice.classList[action.toggleRemove]("d-none");
    comparatorWrapperGrid.classList[action.toggleAdd](state);
    comparatorWrapperGrid.classList[action.toggleRemove](oppositeState);

    // Pass screen to col-10 on large screen
    comparatorWrapper.classList[action.toggleAdd](comparatorWidthRevealClass);

    // Don't display standard header and display reveal header
    comparatorHeaderStandard.classList[action.toggleAdd]("d-none");
    comparatorHeaderReveal.classList[action.toggleAdd]("d-flex");

    // Display comparator measures
    comparatorRevealContent.classList[action.toggleRemove]("d-none");

    // Don't display start comparaison button
    startComparaisonButtons.forEach(function(e) {
        e.classList[action.toggleAdd]("d-none");
    });

    // Don't display return to choice button
    returnToChoice.classList[action.toggleRemove]("d-none");

    allCardCandidates.forEach((candidate) => {
        // Don't display all candidates cards
        if (
            !Object.keys(candidateCardsSelectedByOrder).includes(
                candidate.dataset.name
            )
        ) {
            candidate.classList[action.toggleAdd]("d-none");
        } else {
            candidate
                .querySelector(".card")
                .classList[action.toggleRemove]("grey-filter");
            // Don't display all candidates card titles
            candidate
                .querySelector(".card-title")
                .classList[action.toggleAdd]("d-none");
            candidate
                .querySelector(".card-subtitle")
                .classList[action.toggleAdd]("d-none");

            // Change col disposition on candidates card
            gridDisplayStandard.forEach((className) => {
                candidate.classList[action.toggleRemove](
                    gridDisplayStandard[className]
                );
            });
            gridDisplayComparator.forEach((className) => {
                candidate.classList[action.toggleAdd](
                    gridDisplayComparator[className]
                );
            });

            candidate.classList[action.toggleAdd]("comparator-card");
        }
    });

    // Don't display all tick on candidates cards
    if (state === "reveal") {
        // Remove all ticks
        document
            .querySelectorAll(".tick-selection-candidate")
            .forEach((tick) => {
                tick.remove();
            });
    } else {
        // Reset vars
        candidateCardsSelectedByOrder = {};
        idsTicks = [1, 2, 3, 4];
        nbElementSelected = 0;

        // Measures slider go to left 0
        sliderItems.style.left = "0";
    }
}

/**
 * Action on click on one measure button
 * @param {Element} measureButton - Clicked element
 */
function onClickOnOneMeasure(measureButton) {
    // Add active class on button
    toggleClass(mesuresButtons, measureButton, "active");

    // Don't display candidates measures for candidates no selected
    [].slice
        .call(document.getElementById(measureButton.dataset.theme).children)
        .forEach((candidateMeasure) => {
            if (
                !Object.keys(candidateCardsSelectedByOrder).includes(
                    candidateMeasure.dataset.name
                )
            ) {
                candidateMeasure.classList.add("d-none");
            } else {
                candidateMeasure.classList.remove("d-none");
            }
        });

    // Sorting candidates choices by order of selection
    sortingCandidatesByOrderSelected(measureButton.dataset.theme);

    // Don't display the measureGroup for themes no selected
    measuresGroup.forEach((measureGroup) => {
        if (measureButton.dataset.theme !== measureGroup.dataset.theme) {
            measureGroup.classList.add("d-none");
        } else {
            measureGroup.classList.remove("d-none");
        }
    });
}

/**
 * Sort candidates by slected order choice
 * @param {string} theme - Theme selected
 */
function sortingCandidatesByOrderSelected(theme) {
    const themeGroup = document.getElementById(theme);

    // Separation between displayed elements from the non-displayed
    let dNoneCandidateMeasure = [];
    let displayedCandidateMeasure = [];
    [...themeGroup.children].map((candidateMeasure) => {
        if (candidateMeasure.classList.contains("d-none")) {
            dNoneCandidateMeasure.push(candidateMeasure);
        } else {
            displayedCandidateMeasure.push(candidateMeasure);
        }
    });

    // Sort all displayed candidates measures by user choice
    displayedCandidateMeasure = displayedCandidateMeasure.sort((a, b) =>
        candidateCardsSelectedByOrder[a.dataset.name] >
        candidateCardsSelectedByOrder[b.dataset.name]
            ? 1
            : -1
    );

    // Delete previous order of candidates
    themeGroup.innerHTML = "";

    // Add new order of candidates
    themeGroup.append(...displayedCandidateMeasure, ...dNoneCandidateMeasure);
}

/**
 */

/**
 * Remove active class of all and add active on selected
 * @param all {HTMLCollection} - Collection of elements in which to remove the class
 * @param selected {Element} - Element selected
 * @param className {string} - Classname to add on selected element
 */
function toggleClass(all, selected, className) {
    all.forEach((one) => {
        one.classList.remove(className);
    });
    selected.classList.add(className);
}

/**
 * Remove tick to a candidate card
 * @param {Element} candidate - Candidate card to remove tick
 */
function removeCandidate(candidate) {
    const tick = candidate.querySelector("." + tickElementClass);

    actualizeCandidatesTick(tick.innerHTML);

    delete candidateCardsSelectedByOrder[candidate.dataset.name];

    // Remove the tick of the DOM
    candidate.removeChild(tick);
}

/**
 * Actualise the ticks to recalculate position of every elements
 *
 * @param numberRemoved
 */
function actualizeCandidatesTick(numberRemoved) {
    // The tick already there
    let currentTick = [];
    document.querySelectorAll("." + tickElementClass).forEach(function (tick) {
        let tickNumber = tick.innerHTML;
        if (parseInt(tickNumber) > parseInt(numberRemoved)) {
            tickNumber--;
            tick.innerHTML = tickNumber.toString();
        }
        currentTick.push(parseInt(tick.innerHTML));
    });
    // Invert the tab to create the new idTicks array with the tick that aren't in html DOM
    let newIdTick = [];
    for (let i = 1; i <= 4; i++) {
        if (!currentTick.includes(i)) {
            newIdTick.push(i);
        }
    }
    idsTicks = newIdTick;
}

/**
 * Add tick to a candidate card
 * @param {Element} candidate - Candidate card to display tick
 */
function addCandidate(candidate) {
    // Remove the tick in the array
    const counter = idsTicks.splice(
        idsTicks.indexOf(Math.min(...idsTicks)),
        1
    )[0];

    // Add candidate to selected candidates
    candidateCardsSelectedByOrder[candidate.dataset.name] = counter;

    // Add the tick in the DOM
    candidate.innerHTML += tickElement(counter);
}

function updateNbCandidateCardsSelected(nbElementSelected) {
    nbCandidateCardsSelected.forEach(function(e) {
		e.textContent = nbElementSelected === 0 ? "..." : nbElementSelected;
    });
}
