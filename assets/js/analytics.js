document.addEventListener('DOMContentLoaded', function() {
    awm_send_analytics();
    //getRecentlViewed();
}, false);


function awm_send_analytics() {

    var data = {};
    data.id = awm_wp_analytics_vars.awm_wp_id;
    var options = {
        data: data,
        url: awmGlobals.url + "/wp-json/awm-wp-analytics/v1/analytics/",
    }
    awm_ajax_call(options);
}


/*


function getRecentlViewed() {
    var recent_div = document.getElementById('mtv-recently-seen');
    if (recent_div) {
        var options = {
            method: 'get',
            url: filox_js_variables.site_url + "/wp-json/awm-wp-analytics/v1/recently-viewed/?post_type=" + recent_div.getAttribute('post_type') + '&exclude=' + recent_div.getAttribute('exclude') + '&lang=' + recent_div.getAttribute('language'),
            callback: 'displayRecentlyViewed'
        }
        sbp_js_update_ajax_call(options);
    }
}



function displayRecentlyViewed(response) {
    if (response != '') {
        var elem = document.getElementById("mtv-recently-seen").querySelector('.mtv-recently-wrapper');
        elem.innerHTML = response;
        awm_recent_cards_slick();
        return true;
    }
    document.getElementById("mtv-recently-seen").outerHTML = '';

}
*/