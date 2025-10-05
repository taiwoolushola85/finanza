$(document).ready(function() {
// Default page to load on page load
var defaultPage = 'admin_dashboard.php';
// Function to load page into div
function loadPage(pageUrl) {
// Load the page content
$('#content-area').load(pageUrl, function(response, status, xhr) {
// Check if there was an error loading the page
if(status === "error") {
$('#content-area').html('<div class="error">Page not found: ' + xhr.status + '</div>');
}
});
}
// Handle link clicks
$('.side-nav-link').on('click', function(e) {
e.preventDefault();
var pageUrl = $(this).attr('href');
$("#page_load").show();
// Validate the URL
if(pageUrl != undefined && pageUrl.trim() !== ""){
// Update active state
$('.side-nav-link').removeClass('active');
$(this).addClass('active');
setTimeout(function(){
$("#page_load").hide();
// Load the page
loadPage(pageUrl);
}, 2000); 
// Update URL hash (optional - for browser history)
window.location.hash = pageUrl.replace('.php', '');
} else {
alert('Invalid page URL');
}
});
// Load default page on initial page load
// Check if there's a hash in URL first
if(window.location.hash) {
var hashPage = window.location.hash.substring(1) + '.php';
var $link = $('.page-link[href="' + hashPage + '"]');
if($link.length > 0) {
$link.addClass('active');
loadPage(hashPage);
} else {
// Load default page if hash page doesn't exist
$('.side-nav-link[href="' + defaultPage + '"]').addClass('active');
loadPage(defaultPage);
}
} else {
// No hash - load default page
$('.side-nav-link[href="' + defaultPage + '"]').addClass('active');
loadPage(defaultPage);
}
// Handle browser back/forward buttons
$(window).on('hashchange', function() {
var hash = window.location.hash.substring(1);
if(hash) {
var hashPage = hash + '.php';
var $link = $('.side-nav-link[href="' + hashPage + '"]');
if($link.length > 0) {
$link.trigger('click');
}
} else {
$("#page_load").hide();
// Load default page when hash is cleared
loadPage(defaultPage);
}
});  
});

