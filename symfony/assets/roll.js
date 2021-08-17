// The element to roll
const rollWrapper = document.querySelector('#candidates-roll-wrapper .rolling-base');
// The width to toggle
let widthToCenter = rollWrapper.clientWidth;
// The max width to set
let maxWidthToScroll = rollWrapper.scrollWidth - rollWrapper.clientWidth;
// The elements to scroll
const elementsToRoll = rollWrapper.children;

// Vertical smoth scroll on rollWraper element
function smoothScrollit(newScrollLeft) {
    rollWrapper.scroll({
        left: newScrollLeft,
        top: 0,
        behavior: 'smooth'
    });
}

// On resize we should do something
document.addEventListener('resize', function() {
    widthToCenter = rollWrapper.clientWidth;
    maxWidthToScroll = rollWrapper.scrollWidth - rollWrapper.clientWidth;
});

// Button
const rollButton = document.getElementById('letsroll');
const leftButton = document.getElementById('roll-left');
const rightButton = document.getElementById('roll-right');
// Random at start
smoothScrollit(widthToCenter * (Math.floor(Math.random() * elementsToRoll.length)));

// Random scroll
rollButton.addEventListener('click', function(e) {
    // random index of our elementsToRoll array factorized with our with to set
    rollButton.classList.toggle('rotate');
    let newScrollLeft = widthToCenter * (Math.floor(Math.random() * elementsToRoll.length));
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
    console.log(newScrollLeft - widthToCenter);
    if (newScrollLeft < 0) {
        newScrollLeft = maxWidthToScroll;
    }
    // Smoooth it
    smoothScrollit(newScrollLeft);
});
rightButton.addEventListener('click', (e) => {
    let newScrollLeft = rollWrapper.scrollLeft + widthToCenter;
    if (newScrollLeft > maxWidthToScroll) {
        newScrollLeft = 0;
    }
    // Smoooth it
    smoothScrollit(newScrollLeft);
});