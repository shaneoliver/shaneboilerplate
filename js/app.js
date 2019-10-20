/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
 */
try {
    window.$ = jQuery || window.jQuery || require('jquery');
    window.Popper = require('popper.js').default;
    require('bootstrap');
} catch(error) {}

import AOS from 'aos';
import Headroom from 'headroom.js';
import lightcase from 'lightcase/src/js/lightcase';
		
// Handle the hamburger click animation
$('.hamburger').click(function() {
    $(this).toggleClass('is-active');
});

// Add Bootstrap responsive div around table elements
$('table').each(function(){
    $(this).addClass('table')
    .wrap('<div class="table-responsive"></div>');
});

// Add Bootstrap responsive embed class wrapper to required elements
$('iframe[src*="youtube"], iframe[src*="vimeo"]').each(function(){
    $(this).addClass('embed-responsive-item')
    .wrap('<div class="embed-responsive embed-responsive-16by9"></div>');
});

const header = document.querySelector('.headroom');
const app = document.querySelector('#app');

// Our header is positioned fixed, so let's offset the app element to the headers height
app.style.paddingTop =`${header.offsetHeight}px`;

// Initialize the Headroom library
let headroom = new Headroom(header, {
    // vertical offset in px before element is first unpinned
    offset : header.offsetHeight,
    // scroll tolerance in px before state changes
    tolerance : 0,
    // or you can specify tolerance individually for up/down scroll
    tolerance : {
        up : 5,
        down : 0
    },
    // css classes to apply
    classes : {
        // when element is initialised
        initial : "headroom",
        // when scrolling up
        pinned : "headroom--pinned",
        // when scrolling down
        unpinned : "headroom--unpinned",
        // when above offset
        top : "headroom--top",
        // when below offset
        notTop : "headroom--not-top",
        // when at bottom of scoll area
        bottom : "headroom--bottom",
        // when not at bottom of scroll area
        notBottom : "headroom--not-bottom",
        // when frozen method has been called
        frozen: "headroom--frozen"
    },
    // element to listen to scroll events on, defaults to `window`
    scroller : window,
    // callback when pinned, `this` is headroom object
    onPin : function() {},
    // callback when unpinned, `this` is headroom object
    onUnpin : function() {},
    // callback when above offset, `this` is headroom object
    onTop : function() {},
    // callback when below offset, `this` is headroom object
    onNotTop : function() {},
    // callback when at bottom of page, `this` is headroom object
    onBottom : function() {},
    // callback when moving away from bottom of page, `this` is headroom object
    onNotBottom : function() {}
})
headroom.init();

// Attach Lightcase rel attribute to all gallery anchors
const galleries = document.querySelectorAll('.wp-block-gallery, .gallery');
let galleryInstance = 0;

[...galleries].forEach(gallery => {
    const items = gallery.querySelectorAll('li');			
    const anchors = gallery.querySelectorAll('a');
    [...anchors].forEach(anchor => {
        if(! anchor.href.match(/\.(jpg|gif|png|jpeg)$/i)) {
            anchor.href = anchor.querySelector('img').src;
        }
        anchor.setAttribute('data-rel', `lightcase:galleryBlock${galleryInstance}:slideshow`);
    });

    [...items].forEach(item => {
        item.setAttribute('data-aos', 'fade-up');
    })

    galleryInstance++;
})

// Initialize the Animate on scroll library
AOS.init();

// Init lightcase
$(document).ready(function(){
    $('a[data-rel^=lightcase]').lightcase({
        maxWidth: 1024,
        maxHeight: 768,
        
        iframe: {
            width: 1280,
            height: 720,
            allowfullscreen: 1
        }
    });
});

// Add the loading property to all images in the entry content
const images = document.querySelectorAll('.entry-content img');
[...images].forEach(image => {
    image.loading = 'lazy';
});
