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

// Inject bgImage through javascript and css variables
const candidatesWrapper = document.querySelectorAll('.candidate-roll-wrapper');
for (let i = 0 ; i < candidatesWrapper.length ; i++) {
    var style = document.createElement('style');
    style.type = 'text/css';
    style.innerHTML = '.bg-' + i + ' { background-image: var(bgPath' + i + '); }';
}

/**
 * Create a css class
 *
 * @see https://stackoverflow.com/a/8630641/9695883
 * @param selector
 * @param style
 */
function createCSSSelector (selector, style) {
    if (!document.styleSheets) return;
    if (document.getElementsByTagName('head').length == 0) return;

    var styleSheet,mediaType;

    if (document.styleSheets.length > 0) {
        for (var i = 0, l = document.styleSheets.length; i < l; i++) {
            if (document.styleSheets[i].disabled)
                continue;
            var media = document.styleSheets[i].media;
            mediaType = typeof media;

            if (mediaType === 'string') {
                if (media === '' || (media.indexOf('screen') !== -1)) {
                    styleSheet = document.styleSheets[i];
                }
            }
            else if (mediaType=='object') {
                if (media.mediaText === '' || (media.mediaText.indexOf('screen') !== -1)) {
                    styleSheet = document.styleSheets[i];
                }
            }

            if (typeof styleSheet !== 'undefined')
                break;
        }
    }

    if (typeof styleSheet === 'undefined') {
        var styleSheetElement = document.createElement('style');
        styleSheetElement.type = 'text/css';
        document.getElementsByTagName('head')[0].appendChild(styleSheetElement);

        for (i = 0; i < document.styleSheets.length; i++) {
            if (document.styleSheets[i].disabled) {
                continue;
            }
            styleSheet = document.styleSheets[i];
        }

        mediaType = typeof styleSheet.media;
    }

    if (mediaType === 'string') {
        for (var i = 0, l = styleSheet.rules.length; i < l; i++) {
            if(styleSheet.rules[i].selectorText && styleSheet.rules[i].selectorText.toLowerCase()==selector.toLowerCase()) {
                styleSheet.rules[i].style.cssText = style;
                return;
            }
        }
        styleSheet.addRule(selector,style);
    }
    else if (mediaType === 'object') {
        var styleSheetLength = (styleSheet.cssRules) ? styleSheet.cssRules.length : 0;
        for (var i = 0; i < styleSheetLength; i++) {
            if (styleSheet.cssRules[i].selectorText && styleSheet.cssRules[i].selectorText.toLowerCase() == selector.toLowerCase()) {
                styleSheet.cssRules[i].style.cssText = style;
                return;
            }
        }
        styleSheet.insertRule(selector + '{' + style + '}', styleSheetLength);
    }
}