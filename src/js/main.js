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
    var bar = new ProgressBar.Line(preloader, {
        strokeWidth: 1.7,
        easing: 'easeInOut',
        duration: 1400,
        delay: 750,
        trailWidth: 1.7,
        svgStyle: {
          width: '100%',
          height: '100%'
        },
        step: (state, bar) => {
          bar.setText(Math.round(bar.value() * 100) + ' %');
        }
      });
    
      bar.animate(1);
    
      // counters
      anime({
        targets: '.art-counter-frame',
        opacity: [0, 1],
        duration: 800,
        delay: 2300,
        easing: 'linear',
      });
    
      anime({
        targets: '.art-counter',
        delay: 1300,
        opacity: [1, 1],
        complete: function(anim) {
          $('.art-counter').each(function() {
            $(this).prop('Counter', 0).animate({
              Counter: $(this).text()
            }, {
              duration: 2000,
              easing: 'linear',
              step: function(now) {
                $(this).text(Math.ceil(now));
              }
            });
          });
        }
      });
    
      // progressbars
      var bar = new ProgressBar.Circle(circleprog1, {
        strokeWidth: 7,
        easing: 'easeInOut',
        duration: 1400,
        delay: 2500,
        trailWidth: 7,
        step: function(state, circle) {
          var value = Math.round(circle.value() * 100);
          if (value === 0) {
            circle.setText('');
          } else {
            circle.setText(value);
          }
        }
      });
    
      bar.animate(1);
    
      var bar = new ProgressBar.Circle(circleprog2, {
        strokeWidth: 7,
        easing: 'easeInOut',
        duration: 1400,
        delay: 2600,
        trailWidth: 7,
        step: function(state, circle) {
          var value = Math.round(circle.value() * 100);
          if (value === 0) {
            circle.setText('');
          } else {
            circle.setText(value);
          }
        }
      });
    
      bar.animate(0.9);
      
  var bar = new ProgressBar.Circle(circleprog3, {
    strokeWidth: 7,
    easing: 'easeInOut',
    duration: 1400,
    delay: 2700,
    trailWidth: 7,
    step: function(state, circle) {
      var value = Math.round(circle.value() * 100);
      if (value === 0) {
        circle.setText('');
      } else {
        circle.setText(value);
      }
    }
  });

  bar.animate(0.7);

  var bar = new ProgressBar.Line(lineprog1, {
    strokeWidth: 1.72,
    easing: 'easeInOut',
    duration: 1400,
    delay: 2800,
    trailWidth: 1.72,
    svgStyle: {
      width: '100%',
      height: '100%'
    },
    step: (state, bar) => {
      bar.setText(Math.round(bar.value() * 100) + ' %');
    }
  });

  bar.animate(.9);

  var bar = new ProgressBar.Line(lineprog2, {
    strokeWidth: 1.72,
    easing: 'easeInOut',
    duration: 1400,
    delay: 2900,
    trailWidth: 1.72,
    svgStyle: {
      width: '100%',
      height: '100%'
    },
    step: (state, bar) => {
      bar.setText(Math.round(bar.value() * 100) + ' %');
    }
  });

  bar.animate(.95);

  var bar = new ProgressBar.Line(lineprog3, {
    strokeWidth: 1.72,
    easing: 'easeInOut',
    duration: 1400,
    delay: 3000,
    trailWidth: 1.72,
    svgStyle: {
      width: '100%',
      height: '100%'
    },
    step: (state, bar) => {
      bar.setText(Math.round(bar.value() * 100) + ' %');
    }
  });

  bar.animate(.75);

  var bar = new ProgressBar.Line(lineprog4, {
    strokeWidth: 1.72,
    easing: 'easeInOut',
    duration: 1400,
    delay: 3100,
    trailWidth: 1.72,
    svgStyle: {
      width: '100%',
      height: '100%'
    },
    step: (state, bar) => {
      bar.setText(Math.round(bar.value() * 100) + ' %');
    }
  });

  bar.animate(.65);

  var bar = new ProgressBar.Line(lineprog5, {
    strokeWidth: 1.72,
    easing: 'easeInOut',
    duration: 1400,
    delay: 3200,
    trailWidth: 1.72,
    svgStyle: {
      width: '100%',
      height: '100%'
    },
    step: (state, bar) => {
      bar.setText(Math.round(bar.value() * 100) + ' %');
    }
  });

  bar.animate(.85);

  
  // Contact form
  $('.art-input').keyup(function() {
    if ($(this).val()) {
      $(this).addClass('art-active');
    } else {
      $(this).removeClass('art-active');
    }
  });

  $("#form").submit(function() {
    $.ajax({
      type: "POST",
      url: "mail.php",
      data: $(this).serialize()
    }).done(function() {

      var tl = anime.timeline({
        easing: 'easeOutExpo',
      });

      tl
        .add({
          targets: '.art-submit',
          opacity: 0,
          scale: .5,
        })
        .add({
          targets: '.art-success',
          scale: 1,
          height: '45px',
        })
    });
    return false;
  });

  // portfolio filter
  $('.art-filter a').on('click', function() {
    $('.art-filter .art-current').removeClass('art-current');
    $(this).addClass('art-current');

    var selector = $(this).data('filter');
    $('.art-grid').isotope({
      filter: selector
    });
    return false;
  });
