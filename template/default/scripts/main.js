$(function(){

    var $navLinkWithCategories = $('.nav_categories'),
        $navCategoriesSubMenu = $('.sub-menu');

    $navLinkWithCategories.on('mouseenter', function(){
        $(this).addClass('active');
    });

    $('body').on('mouseenter',function(){
        $navLinkWithCategories.removeClass('active');
    });

    var nextPostBtn = $('.next'),
        prevPostBtn = $('.prev');

    // Carousel script
    $(".carosel_body").slick({
        slidesToShow: 4,
        slidesToScroll: 1,
        infinite: true,
        nextArrow: nextPostBtn,
        prevArrow: prevPostBtn
    });

});