// main.js

//This code will prevent unexpected menu close when 
// using some components (like accordion, forms, etc).
$(document).on('click', '.yamm .dropdown-menu', function(e) {
  e.stopPropagation()
})