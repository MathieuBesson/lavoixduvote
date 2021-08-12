let slider = document.getElementById('slider'),
    sliderItems = document.getElementById('slider-wrapper__slides'),
    sliderDots = document.getElementById('slider-dots');

function slide(wrapper, items) {
    let posX1 = 0,
        posX2 = 0,
        posInitial,
        posFinal,
        threshold = 100,
        slides = items.getElementsByClassName('slider-wrapper__slides-item'),
        slidesLength = slides.length,
        firstSlide = slides[0],
        lastSlide = slides[slidesLength - 1],
        cloneFirst = cloneELement(firstSlide),
        cloneLast = cloneELement(lastSlide),
        index = 0,
        allowShift = true;

    // Clone first and last slide
    items.appendChild(cloneFirst);
    items.insertBefore(cloneLast, firstSlide);
    wrapper.classList.add('loaded');

    // Mouse events
    items.onmousedown = dragStart;

    // Touch events
    items.addEventListener('touchstart', dragStart);
    items.addEventListener('touchend', dragEnd);
    items.addEventListener('touchmove', dragAction);

    // Transition events
    items.addEventListener('transitionend', checkIndex);

    // Fix width bug of slides on responsive view
    window.addEventListener('resize', resetForResponsive);

    // Display dots
    displayDot();

    function cloneELement(el){
        let newEl = el.cloneNode(true);
        newEl.classList.add('clone');
        return newEl;
    }

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

    function dragAction(e) {
        e = e || window.event;

        if (e.type == 'touchmove') {
            posX2 = posX1 - e.touches[0].clientX;
            posX1 = e.touches[0].clientX;
        } else {
            posX2 = posX1 - e.clientX;
            posX1 = e.clientX;
        }
        items.style.left = (items.offsetLeft - posX2) + "px";
    }

    function dragEnd(e) {
        posFinal = items.offsetLeft;
        if (posFinal - posInitial < -threshold) {
            shiftSlide(1, 'drag');
        } else if (posFinal - posInitial > threshold) {
            shiftSlide(-1, 'drag');
        } else {
            items.style.left = (posInitial) + "px";
        }
        document.onmouseup = null;
        document.onmousemove = null;
    }

    function resetForResponsive(e){
        items.style.left = -items.getElementsByClassName('slider-wrapper__slides-item')[0].offsetWidth + "px";
        toggleActiveDot(0, index);
        index = 0;
    }

    function shiftSlide(dir, action) {
        items.classList.add('shifting');

        const slideSize = items.getElementsByClassName('slider-wrapper__slides-item')[0].offsetWidth;

        if (allowShift) {
            if (!action) {
                posInitial = items.offsetLeft;
            }

            const oldIndex = index;
            if (dir == 1) {
                items.style.left = (posInitial - slideSize) + "px";
                index++;
            } else if (dir == -1) {
                items.style.left = (posInitial + slideSize) + "px";
                index--;
            }
            toggleActiveDot(index, oldIndex);
        }

        allowShift = false;
    }

    function checkIndex() {
        items.classList.remove('shifting');
        const slideSize = items.getElementsByClassName('slider-wrapper__slides-item')[0].offsetWidth;

        if (index == -1) {
            items.style.left = -(slidesLength * slideSize) + "px";
            index = slidesLength - 1;
        }

        if (index == slidesLength) {
            items.style.left = -(1 * slideSize) + "px";
            index = 0;
        }

        allowShift = true;
    }

    function toggleActiveDot(index, oldIndex = null) {
        if (oldIndex !== null) {
            changeDotClass('remove', oldIndex);
        }
        changeDotClass('add', index);
    }

    function displayDot(){
        for ($i = 0; $i < slidesLength; $i++) {
            sliderDots.innerHTML += '<span class="slider-dots-item"></span>';
        }
        toggleActiveDot(index);
    }

    function changeDotClass(action, index) {
        switch (index) {
            case -1:
                sliderDots.children[slidesLength - 1].classList[action]('active-dot')
                break;

            case slidesLength:
                sliderDots.children[0].classList[action]('active-dot')
                break;

            default:
                sliderDots.children[index].classList[action]('active-dot')
                break;
        }
    }
}

slide(slider, sliderItems);