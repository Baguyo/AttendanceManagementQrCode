$(".toggle-icon").click(function (e) { 
    // e.preventDefault();
    $(".side-nav").toggleClass("active-sidebar");
    // $(".side-nav").slideToggle("fast");
});

if($(window).width() < 768){
    $(".side-nav").addClass("active-sidebar");
}