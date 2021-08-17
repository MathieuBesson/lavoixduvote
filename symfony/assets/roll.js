// The element to roll
const rollWrapper = document.querySelector('#candidates-roll-wrapper .rolling-base');
// The width to toggle
let widthToCenter = rollWrapper.clientWidth;
// The max width to set
let maxWidthToScroll = rollWrapper.scrollWidth - rollWrapper.clientWidth;
// The elements to scroll
const elementsToRoll = rollWrapper.children;
// Current centered element, it will be usefull for reculalting the scroll after resizing window
let currentCenteredElement = Math.floor(Math.random() * elementsToRoll.length);
// Buttons
const rollButton = document.getElementById('letsroll');
const leftButton = document.getElementById('roll-left');
const rightButton = document.getElementById('roll-right');
// Random at start
smoothScrollit(widthToCenter * currentCenteredElement);

// Vertical smoth scroll on rollWraper element
function smoothScrollit(newScrollLeft) {
    rollWrapper.scroll({
        left: newScrollLeft,
        top: 0,
        behavior: 'smooth'
    });
}

// On resize we should recalculate and reposition
window.addEventListener('resize', function() {
    // Recalculate variables
    widthToCenter = rollWrapper.clientWidth;
    maxWidthToScroll = rollWrapper.scrollWidth - rollWrapper.clientWidth;
    // Reset the scroll
    rollWrapper.scrollLeft = widthToCenter * currentCenteredElement;
});

// Random scroll
rollButton.addEventListener('click', function(e) {
    // random index of our elementsToRoll array factorized with our with to set
    rollButton.classList.toggle('rotate');
    currentCenteredElement = Math.floor(Math.random() * elementsToRoll.length);
    let newScrollLeft = widthToCenter * currentCenteredElement;
    // We don't want the same choice that before
    if (newScrollLeft === rollWrapper.scrollLeft) {
        if ((newScrollLeft + widthToCenter) > maxWidthToScroll) {
            newScrollLeft -= widthToCenter;
        } else {
            newScrollLeft += widthToCenter;
        }
    }
    // Smoooth it
    smoothScrollit(newScrollLeft);
});
leftButton.addEventListener('click', (e) => {
    let newScrollLeft = rollWrapper.scrollLeft - widthToCenter;
    currentCenteredElement--;
    // Overflow !
    if (newScrollLeft < 0) {
        newScrollLeft = maxWidthToScroll;
        currentCenteredElement = elementsToRoll.length - 1;
    }
    // Smoooth it
    smoothScrollit(newScrollLeft);
});
rightButton.addEventListener('click', (e) => {
    let newScrollLeft = rollWrapper.scrollLeft + widthToCenter;
    currentCenteredElement++;
    // Overflow !
    if (newScrollLeft > maxWidthToScroll) {
        newScrollLeft = 0;
        currentCenteredElement = 1;
    }
    // Smoooth it
    smoothScrollit(newScrollLeft);
});