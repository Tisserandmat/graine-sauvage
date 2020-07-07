$(document).ready(function () {
    //Sidenav animation

    $(".sidenav-anim").on("mouseover", function () {
        $(".sidenav-anim").addClass("animate");
    });

    $(".sidenav-anim").on("mouseleave", function () {
        $(".sidenav-anim").removeClass("animate");

        if ($(".inner-list-bottom .drop-down-list#dropdown").is(":visible")) {
            $(".drop-down-list#dropdown").removeClass("animate");
        }
    });

    $(".open-dropdown").on("click", function (e) {
        e.preventDefault();
        $(".drop-down-list#dropdown").toggleClass("animate");
    });

    $(".sidenav-anim").on("click", function (e) {
        var target = $(e.target);
        var tar_class = target.attr("class");
        var tar_class_par = $("." + tar_class).parents("inner-align");

        if (!(target.hasClass("open-dropdown"))) {
            if ($(".inner-list-bottom .drop-down-list#dropdown").is(":visible")) {
                $(".drop-down-list#dropdown").removeClass("animate");
            }
        }
    });

    $(".nav-list-link").on("click", function () {
        $(".nav-list-link").removeClass("active");
        $(this).addClass("active");
    });

    //END: Sidenav animation

    //Dropdown animation

    $(".sidebar-container").on("click", function (e) {
        var tar_ele = $(e.target);
        var tar_class, tab_active, this_ele;
        if (!tar_ele.parents(".dropdown-item").hasClass("dropdown-item")) {
            this_ele = tar_ele.parents(".tab-dropdown-parent");
            tar_class = this_ele.hasClass("tab-dropdown-parent");
            tab_active = this_ele.hasClass("active-tab");

            if (tar_class) {            //If clicked inside tab list
                if (tab_active) {
                    $(".tab-dropdown-parent").removeClass("active-tab");
                    $(".tab-dropdown-parent .drop-down-list#tab-dropdown").removeClass("animate");
                } else {
                    $(".tab-dropdown-parent").removeClass("active-tab");
                    $(".tab-dropdown-parent .drop-down-list#tab-dropdown").removeClass("animate");
                    this_ele.addClass("active-tab");
                    this_ele.find(".drop-down-list#tab-dropdown").addClass("animate");
                    ;
                }
            } else {
                $(".tab-dropdown-parent").removeClass("active-tab");
                $(".tab-dropdown-parent .drop-down-list#tab-dropdown").removeClass("animate");
            }
        }
    });

    //END: Dropdown animation

});
