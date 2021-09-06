module.exports = function dragNav(items, wrapper) {
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

        if (movement <= 0 && movement >= -items.offsetWidth + wrapper.offsetWidth) {
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
};