(function($) {

    $(document).ready(function(){
        // Inspired by https://www.youtube.com/watch?v=PDd8shcLvHI
        if ( 0 == YourSiteVar.childCount ) {
            alert('Yes, we have NO CHILDREN on this page today!');
        } else {
            alert('No, we have %d CHILDREN on this page today!'.replace(/%d/g,YourSiteVar.childCount) );
        }
    });

})(jQuery); // Fully reference jQuery after this point.