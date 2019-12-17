/**
 * First, we will load all of this project's Javascript utilities and other
 * dependencies. Then, we will be ready to develop a robust and powerful
 * application frontend using useful Laravel and JavaScript libraries.
 */

require('./bootstrap');

$(document).ready(function() {
    $(document).on("click", "#tags .tag-name", function() {
        let tag = $(this).text();
        console.log('tag');
    });
    window.setTimeout(function() {
        $("#message-alerts .alert").alert('close');
    }, 3000);
});
