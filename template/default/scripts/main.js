$(function(){

    // Carousel script
    var nextPostBtn = $('.next'),
        prevPostBtn = $('.prev');

    $(".carosel_posts").slick({
        slidesToShow: 4,
        slidesToScroll: 1,
        infinite: true,
        nextArrow: nextPostBtn,
        prevArrow: prevPostBtn,
        autoplay: true,
        speed: 1000
    });

    // Hide General Msg
    setTimeout( function(){
        var generalMsg = $('.general_msg');
        generalMsg.slideUp()
    },5000);

});