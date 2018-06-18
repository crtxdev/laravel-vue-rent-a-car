import $ from 'jquery'

$(document).on('click', '.dropdown-menu.keep-open *', function (event) {
  event.stopPropagation()
})

$(document).on('click', '.dropdown-menu.keep-open .closes-dropdown', function() {
  $(this).closest('.dropdown-menu').siblings('.dropdown-toggle').dropdown('toggle')
})

$(document).on('click', '.sidebar-toggler', function(){
  $('body').toggleClass('sidebarOpen');
});
