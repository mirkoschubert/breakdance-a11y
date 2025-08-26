/* document.addEventListener("DOMContentLoaded", function(event) { 
  let dropdownItems = document.querySelectorAll('.breakdance-dropdown-toggle')

  dropdownItems.forEach(item => {
    console.log(item)
    item.ariaHasPopup = true
  })
}) */

jQuery(document).ready(function($) {

  $('.breakdance-dropdown-toggle').each(function() {
    var $toggle = $(this);
    var $link = $toggle.find('a.breakdance-menu-link');

    $toggle.attr('aria-haspopup', true)
    $toggle.attr('aria-expanded', false)
    
    var observer = new MutationObserver(function(mutations) {
      mutations.forEach(function(mutation) {
        if (mutation.type === 'attributes' && mutation.attributeName === 'aria-expanded') {
          var expanded = $link.attr('aria-expanded');
          $toggle.attr('aria-expanded', expanded);
        }
      });
    });
    
    observer.observe($link[0], {
      attributes: true,
      attributeFilter: ['aria-expanded']
    });
  });

  // Form Input Aria
  $('.breakdance-form-field__input').each(function () {
    let $item = $(this)
    
    $item.removeAttr('aria-describedby')
  })
  
  // Required Aria
  $('.breakdance-form-field__required').each(function () {
    let $item = $(this)
    $item.attr('aria-hidden', true)
    $item.attr('role', 'none')
    $item.attr('tabindex', '0')
  })

  // Role and Tabindex
  $('.breakdance-form-field__label, .breakdance-form-dropzone').each(function () {
    let $item = $(this)
    $item.attr('role', 'none')
    $item.attr('tabindex', '0')
  })

  $('.breakdance-form-field__input[required]').each(function () {
    let $item = $(this)

    $item.attr('aria-required', true)
  })

  $('.bde-section .section-shape-divider svg').each(function () {
    let $item = $(this)
    $item.attr('role', 'presentation')
  })

  // External Links
	$('a').each(function() {
    let target = jQuery(this).attr('target')
    let text = jQuery(this).text()
    if(target == "_blank" || target == "blank" ) { 
      $(this).attr('aria-label',`Link ${text} öffnet in neuem Fenster`)
    } 
  })

  //Videos
  $('lite-youtube .lyt-top-wrapper').each(function () {
    let $item = $(this)
    $item.attr('role', 'button')
    $item.attr('tabindex', '0')
  })

  $('select').each(function(){
    new Choices(this, {
      shouldSort: false,
      searchEnabled: false,
      removeItemButton: this.multiple
    })
  })

})
