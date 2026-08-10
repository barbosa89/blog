document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('a.js-scroll-trigger[href*="#"]:not([href="#"])').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && location.hostname == this.hostname) {
                let target = document.querySelector(this.hash);
                if (!target) {
                    target = document.querySelector("[name=" + this.hash.slice(1) + "]");
                }

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

    const scrollToTop = document.querySelector('.back-to-top');

    document.addEventListener('scroll', function() {
        if (!scrollToTop) {
            return;
        }

        if (document.documentElement.scrollTop > 500) {
            scrollToTop.style.display = 'block';
        } else {
            scrollToTop.style.display = 'none';
        }
    });

});
