/**
 * Header scroll animation: goes down 100vh or up to 0 to skip the header
 * - It's a bit buggy but it will work just fine
 */

const windowHeight = window.innerHeight;
const vh = windowHeight / 100;

const UP = 0;
const DOWN = 1;

let animationRunning = false;

let preScroll = 0;
window.onscroll = (event) => {
  // Don't run simultaneously
  if (animationRunning) return;

  const scroll = document.documentElement.scrollTop;
  const direction = scroll > preScroll ? DOWN : UP;

  if (scroll < windowHeight) {
    if (direction === DOWN) {
      animationRunning = true;
      window.scrollTo({ behavior: "smooth", top: windowHeight });
      setTimeout(() => {
        window.scrollTo({ behavior: "auto", top: windowHeight });
        animationRunning = false;
        preScroll = windowHeight;
      }, 500);
    } else {
      animationRunning = true;
      window.scrollTo({ behavior: "smooth", top: 0 });
      setTimeout(() => {
        window.scrollTo({ behavior: "auto", top: 0 });
        animationRunning = false;
        preScroll = 0;
      }, 500);
    }
  }

  // Update previous scroll
  preScroll = scroll;
};

const stopScrolling = [
  (event) => {
    if (animationRunning) {
      event.preventDefault();
    }
  },
  { passive: false, cancelable: false },
];
document.addEventListener("wheel", ...stopScrolling);
document.addEventListener("touchmove", ...stopScrolling);
