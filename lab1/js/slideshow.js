const initBg = (autoplay = true) => {
    const currentPath = window.location.pathname;
    const pathSegments = currentPath.split('/');
    const currentHTMLFile = pathSegments[pathSegments.length - 1];
    let bgImgsNames, bgImgs;
    if (currentHTMLFile === "photos.html"){
        bgImgsNames = ['1.jpg', '2.jpg', '3.jpg', '4.jpg','5.jpg','6.jpg','7.jpg','8.jpg','9.jpg','10.jpg'];
        bgImgs = bgImgsNames.map(img => "img/collage/" + img);
    }else{
        bgImgsNames = ['1.jpg', '2.jpg', '3.jpg'];
        bgImgs = bgImgsNames.map(img => "img/" + img);
    }

    $.backstretch(bgImgs, {duration: 4000, fade: 500});

    if(!autoplay) {
      $.backstretch('pause');  
    }    
}

const setBg = id => {
    $.backstretch('show', id);
}

const setBgOverlay = () => {
    const windowWidth = window.innerWidth;
    const bgHeight = $('body').height();
    const tmBgLeft = $('.my-bg-left');

    $('.my-bg').height(bgHeight);
    
    if(windowWidth > 768) {
        tmBgLeft.css('border-left', `0`)
                .css('border-top', `${bgHeight}px solid transparent`);                
    } else {
        tmBgLeft.css('border-left', `${windowWidth}px solid transparent`)
                .css('border-top', `0`);
    }
}

$(document).ready(function () {
    const autoplayBg = true;	// set Auto Play for Background Images
    initBg(autoplayBg);    
    setBgOverlay();

    const bgControl = $('.my-bg-control');
    bgControl.click(function() {
        bgControl.removeClass('active');
        $(this).addClass('active');
        const id = $(this).data('id');                
        setBg(id);
    });

    $(window).on("backstretch.after", function (e, instance, index) {        
        const bgControl = $('.my-bg-control');
        bgControl.removeClass('active');
        const current = $(".my-bg-controls-wrapper").find(`[data-id=${index}]`);
        current.addClass('active');
    });

    $(window).resize(function() {
        setBgOverlay();
    });
});