
export const setScroller = (scroller, htmlElement, reverse) => {
    if(!scroller){
        return
    }
    if (reverse) {
        scroller.classList.add("reverse");
    }
    const scrollerInner = scroller.querySelector('.scroller__inner');
    scrollerInner.innerHTML = htmlElement;
};

const launchScroller = (scroller) => {
    const scrollerInner = scroller.querySelector('.scroller__inner');
    const scrollerContent = Array.from(scrollerInner.children);

    if(!scrollerContent){
        return
    }
    scrollerContent.forEach(item => {
        const duplicatedItem = item.cloneNode(true);
        duplicatedItem.setAttribute('aria-hidden', true);
        scrollerInner.appendChild(duplicatedItem);
    });

    addScrollerEventListeners(scroller);
};

const stopScrolling = (scroller) => {
    scroller.classList.add("stop");
};

const startScrolling = (scroller) => {
    scroller.classList.remove("stop");
};

const scrollOneChild = (scroller, reverse = false) => {
    stopScrolling(scroller);

    const scrollerInner = scroller.querySelector('.scroller__inner');
    const firstChild = scrollerInner.children[0];
    const childWidth = firstChild.offsetWidth + 10; // Width of the child plus 10px margin

    if (reverse) {
        // Move the last child to the beginning
        scrollerInner.insertBefore(scrollerInner.lastElementChild, scrollerInner.firstElementChild);
        scroller.scrollLeft += childWidth; // Adjust the scroll position to compensate for the child moved to the beginning
    }

    scroller.scrollBy({
        left: reverse ? -childWidth : childWidth,
        behavior: 'smooth'
    });

    // After the scroll ends, reset the position
    setTimeout(() => {
        if (!reverse) {
            // Move the first child to the end
            scrollerInner.appendChild(scrollerInner.firstElementChild);
            scroller.scrollLeft -= childWidth; // Adjust the scroll position to compensate for the child moved to the end
        }
        startScrolling(scroller);
    }, 500); // Timeout should match the scroll behavior duration
};




const addScrollerEventListeners = (scroller) => {


    scroller.addEventListener('mouseenter', ()=>stopScrolling(scroller));
    scroller.addEventListener('mouseleave', ()=>startScrolling(scroller));
    scroller.addEventListener('touchstart',()=> stopScrolling(scroller));
    scroller.addEventListener('touchend', ()=>startScrolling(scroller));
};

export const Scroller = () => {
    const scrollers = document.querySelectorAll('.scroller');


    if (scrollers.length === 0) {
        return;
    }

    scrollers.forEach(scroller => {
        const scrollLeft= scroller.parentElement.querySelector(".scroller__btn--left")
        const scrollRight = scroller.parentElement.querySelector(".scroller__btn--right")
        scrollRight?.addEventListener('click',()=>{
            scrollOneChild(scroller)
        })
        scrollLeft?.addEventListener('click',()=>{
            scrollOneChild(scroller,true)
        })
        launchScroller(scroller);
    });
};

export default Scroller;
