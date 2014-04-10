$(document).ready(function(){
    $("div#picture").hover(function(){
        $( this ).css({
            "background-image":"url('./img/menubgr.png')"
        })
    }, function(){
        $( this ).css({
            "background-image":"url('./img/contentbgr.png')"
        })
				 
    });
    
    $("div.album").hover(function(){
        $( this ).css({
            "background-image":"url('./img/menubgr.png')"
        })
    }, function(){
        $( this ).css({
            "background-image":"url('./img/contentbgr.png')"
        })
				 
    });
});

