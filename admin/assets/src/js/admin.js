import './main/submit-pages.js';
import './main/tabs.js';
import './main/filters.js';
import './main/pagination.js';
jQuery(function () {
    jQuery(".redirect-prod-page, .redirect-user-page").on('change', function(){
        var parent = jQuery(this).parent();
        parent.find(".warning-private-page-redirect").show();
        if(!parent.find('.redirect-prod-page')[0].checked && !parent.find('.redirect-user-page')[0].checked){
            parent.find(".warning-private-page-redirect").hide();
        }
    });
});