$(document).ready(function(){
	  $('.toggle-btn, .close-menu, .Navoverlay').click(function() {
	  // $('body').addClass('toggle-class');
	  $("body").toggleClass("toggle-class");
	});
});
/**************/
// $(document).ready(function() {
//     $('#dataTable').DataTable();
// } );

/**loader javascript**/

    var preloader = $('#loader-wrapper');
    var myVar;

    function aakashloader(){
        preloader.css("transition", "all 0.5s");
        preloader.css("visibility", "hidden");
        preloader.css("opacity", "0");
        window.scrollTo(0, 0);
    };

    function loaderfun() {
        myVar = setTimeout(aakashloader, 800);
    }

    var responseModal = function(status,title){
        $('#response-modal img').hide();
        if(status == 'success'){
           $('#success-img').show();
           $('#title').html('<p class="text-green">'+title+'</p>');
        }
        if(status == 'failed'){
           $('#failed-img').show();
           $('#response-modal .title').html('<p class="text-red">'+title+'</p>');
        }
        $('#response-modal').modal('show');
    }

/****end****/

$(document).ready(function (){
    $('.noty-btn').click(function (){
        $('.notification-card').toggleClass('show-noty');
    })
})