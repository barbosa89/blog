/*!
 * Start Bootstrap - Freelancer v5.0.0 (https://startbootstrap.com/template-overviews/freelancer)
 * Copyright 2013-2018 Start Bootstrap
 * Licensed under MIT (https://github.com/BlackrockDigital/startbootstrap-freelancer/blob/master/LICENSE)
 */

(function() {
    "use strict";

    document.querySelectorAll('a.js-scroll-trigger[href*="#"]:not([href="#"])').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && location.hostname == this.hostname) {
                let target = document.querySelector(this.hash);
                target = target ? target : document.querySelector("[name=" + this.hash.slice(1) + "]");
                if (target) {
                    window.scrollTo({
                        top: target.offsetTop - 70,
                        behavior: 'smooth'
                    });
                    e.preventDefault();
                }
            }
        });
    });

    document.addEventListener('scroll', function() {
        if (document.documentElement.scrollTop > 100) {
            document.querySelector(".scroll-to-top").style.display = 'block';
        } else {
            document.querySelector(".scroll-to-top").style.display = 'none';
        }
    });

    document.querySelectorAll(".js-scroll-trigger").forEach(trigger => {
        trigger.addEventListener('click', function() {
            document.querySelector(".navbar-collapse").classList.remove("show");
        });
    });

    document.body.setAttribute('data-bs-spy', 'scroll');
    document.body.setAttribute('data-bs-target', '#mainNav');
    document.body.setAttribute('data-bs-offset', '80');

    var navbarShrink = function() {
        if (document.querySelector("#mainNav").offsetTop > 100) {
            document.querySelector("#mainNav").classList.add("navbar-shrink");
        } else {
            document.querySelector("#mainNav").classList.remove("navbar-shrink");
        }
    };

    navbarShrink();
    window.addEventListener('scroll', navbarShrink);

    document.querySelectorAll(".portfolio-item").forEach(item => {
        item.addEventListener('click', function() {
            // Implement magnificPopup functionality using vanilla JavaScript or a suitable alternative
        });
    });

    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('portfolio-modal-dismiss')) {
            e.preventDefault();
            // Close magnificPopup using vanilla JavaScript or a suitable alternative
        }
    });

    document.querySelectorAll(".floating-label-form-group").forEach(group => {
        group.addEventListener('input', function(e) {
            if (e.target.value) {
                group.classList.add("floating-label-form-group-with-value");
            } else {
                group.classList.remove("floating-label-form-group-with-value");
            }
        });

        group.addEventListener('focus', function() {
            group.classList.add("floating-label-form-group-with-focus");
        });

        group.addEventListener('blur', function() {
            group.classList.remove("floating-label-form-group-with-focus");
        });
    });
})();