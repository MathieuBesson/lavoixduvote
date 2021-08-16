// Set the target class 
let sliderItems = document.getElementById('slider-wrapper__slides'),
    sliderDots = document.getElementById('slider-dots');

function slide(items) {
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

    // Clone first and last slide to create infinite slider 
    items.appendChild(cloneFirst);
    items.insertBefore(cloneLast, firstSlide);

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

    // Set the width of the wrapper and each slide in fonction of the number of slide 
    sliderItems.style.width = slides.length * 100 + '%'; 
    [...slides].forEach(slide => {
        slide.style.width = (100 / slides.length) + '%'; 
    }); 
    
    /**
     * Clone and return element 
     * @param {*} el - HTML element to clone 
     * @returns - The clone of the element with .clone class (to no display on dektop)
     */
    function cloneELement(el){
        let newEl = el.cloneNode(true);
        newEl.classList.add('clone');
        return newEl;
    }

    /**
     * Save the initial drag position and launch the the action of following the click and stop the drag    
     * @param {*} e - Click event to start drag action 
     */
     function dragStart (e) {
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
     function dragAction (e) {
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

    /**
     * Action on the release of the click to go to next (or prev) slide or rest on current slide 
     * @param {*} e - Release event click to stop the drag 
     */
     function dragEnd (e) {
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

    /**
     * Reset the items group postion to the current slide on the windows resize 
     * @param {*} e - Window responsive event  
     */
    function resetForResponsive(e){
        items.style.left = -items.getElementsByClassName('slider-wrapper__slides-item')[0].offsetWidth * (index + 1) + "px";
    }

    /**
     * Slide changement
     * @param {number} dir - Direction of the change (-1 => prev, 1 => next)
     */
    function shiftSlide(dir, action) {
        items.classList.add('shifting');
        const slideSize = items.getElementsByClassName('slider-wrapper__slides-item')[0].offsetWidth;
        
        if (allowShift) {
          if (!action) { posInitial = items.offsetLeft; }
    
          const oldIndex = index; 
          if (dir == 1) {
            items.style.left = (posInitial - slideSize) + "px";
            index++;      
          } else if (dir == -1) {
            items.style.left = (posInitial + slideSize) + "px";
            index--;      
          }
          toggleActiveDot(index, oldIndex); 
        };
        
        allowShift = false;
      }

    /**
     * Verification of the index and change if needed 
     */
    function checkIndex (){
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

    /** Creation of th dots */
    function displayDot(){
        for ($i = 0; $i < slidesLength; $i++) {
            sliderDots.innerHTML += '<span class="slider-dots-item"></span>';
        }
        toggleActiveDot(index);
    }

    /**
     * Changement of the active dot on bottom of the slider 
     * @param {*} index - Index of the future active dot 
     * @param {*} oldIndex - Index of the old active dot 
    */
         function toggleActiveDot(index, oldIndex = null) {
            if (oldIndex !== null) {
                changeDotClass('remove', oldIndex);
            }
            changeDotClass('add', index);
        }

    /**
      * Update the class of the selected dot 
      * @param {*} action - Action to execute (remove or add)
      * @param {*} index - Index of the dot selected 
    */
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

// Slider activation 
slide(sliderItems);