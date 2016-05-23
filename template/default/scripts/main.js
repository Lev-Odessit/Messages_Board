$(function(){
    var $navLinkWithCategories = $('.nav_categories'),
        $navCategoriesSubMenu = $('.sub-menu');

    $navLinkWithCategories.on('mouseenter', function(){
        $(this).addClass('active');
    });
    
    $('body').on('mouseenter',function(){
        $navLinkWithCategories.removeClass('active');
    })

    

});