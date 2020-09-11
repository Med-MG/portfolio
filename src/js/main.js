/* -------------------------------------------

Name: 	MedMg
Version:  1.0
Author:		Mohamed Mouiguina 
Portfolio:  mohamedmouiguina.com

p.s. I am available for Freelance hire (UI design, web development). mail: mouiguina.mohammed@gmail.com


------------------------------------------- */
$(function() {

    "use strict";
  
    // swup js
    const options = {
      containers: ["#swup", "#swupMenu"],
      animateHistoryBrowsing: true,
    };
  
    const swup = new Swup(options);
  
    // scrollbar
    Scrollbar.use(OverscrollPlugin);
    Scrollbar.init(document.querySelector('#scrollbar'), {
      damping: 0.05,
      renderByPixel: true,
      continuousScrolling: true,
    });
    Scrollbar.init(document.querySelector('#scrollbar2'), {
      damping: 0.05,
      renderByPixel: true,
      continuousScrolling: true,
    });
  
    // page loading
    $(document).ready(function() {
      anime({
        targets: '.art-preloader .art-preloader-content',
        opacity: [0, 1],
        delay: 200,
        duration: 600,
        easing: 'linear',
        complete: function(anim) {
  
        }
      });
      anime({
        targets: '.art-preloader',
        opacity: [1, 0],
        delay: 2200,
        duration: 400,
        easing: 'linear',
        complete: function(anim) {
          $('.art-preloader').css('display', 'none');
        }
      });
    });