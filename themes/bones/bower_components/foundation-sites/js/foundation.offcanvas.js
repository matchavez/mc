/**
 * OffCanvas module.
 * @module foundation.offcanvas
 * @requires foundation.util.mediaQuery
 * @requires foundation.util.triggers
 * @requires foundation.util.motion
 */
!function($, Foundation) {

'use strict';

/**
 * Creates a new instance of an off-canvas wrapper.
 * @class
 * @fires OffCanvas#init
 * @param {Object} element - jQuery object to initialize.
 * @param {Object} options - Overrides to the default plugin settings.
 */
function OffCanvas(element, options) {
  this.$element = element;
  this.options = $.extend({}, OffCanvas.defaults, this.$element.data(), options);
  this.$lastTrigger = $();

  this._init();
  this._events();

  Foundation.registerPlugin(this, 'OffCanvas');
}

OffCanvas.defaults = {
  /**
   * Allow the user to click outside of the menu to close it.
   * @option
   * @example true
   */
  closeOnClick: true,
  /**
   * Amount of time in ms the open and close transition requires. If none selected, pulls from body style.
   * @option
   * @example 500
   */
  transitionTime: 0,
  /**
   * Direction the offcanvas opens from. Determines class applied to body.
   * @option
   * @example left
   */
  position: 'left',
  /**
   * Force the page to scroll to top on open.
   */
  forceTop: true,
  /**
   * Allow the offcanvas to be sticky while open. Does nothing if Sass option `$maincontent-prevent-scroll === true`.
   * Performance in Safari OSX/iOS is not great.
   */
  // isSticky: false,
  /**
   * Allow the offcanvas to remain open for certain breakpoints.
   * @option
   * @example false
   */
  isRevealed: false,
  /**
   * Breakpoint at which to reveal. JS will use a RegExp to target standard classes, if changing classnames, pass your class @`revealClass`.
   * @option
   * @example reveal-for-large
   */
  revealOn: null,
  /**
   * Force focus to the offcanvas on open. If true, will focus the opening trigger on close.
   * @option
   * @example true
   */
  autoFocus: true,
  /**
   * Class used to force an offcanvas to remain open. Foundation defaults for this are `reveal-for-large` & `reveal-for-medium`.
   * @option
   * TODO improve the regex testing for this.
   * @example reveal-for-large
   */
  revealClass: 'reveal-for-',
  /**
   * Triggers optional focus trapping when opening an offcanvas. Sets tabindex of [data-off-canvas-content] to -1 for accessibility purposes.
   * @option
   * @example true
   */
  trapFocus: false
};

/**
 * Initializes the off-canvas wrapper by adding the exit overlay (if needed).
 * @function
 * @private
 */
OffCanvas.prototype._init = function() {
  var id = this.$element.attr('id');

  this.$element.attr('aria-hidden', 'true');

  // Find triggers that affect this element and add aria-expanded to them
  $(document)
    .find('[data-open="'+id+'"], [data-close="'+id+'"], [data-toggle="'+id+'"]')
    .attr('aria-expanded', 'false')
    .attr('aria-controls', id);

  // Add a close trigger over the body if necessary
  if (this.options.closeOnClick){
    if($('.js-off-canvas-exit').length){
      this.$exiter = $('.js-off-canvas-exit');
    }else{
      var exiter = document.createElement('div');
      exiter.setAttribute('class', 'js-off-canvas-exit');
      $('[data-off-canvas-content]').append(exiter);

      this.$exiter = $(exiter);
    }
  }

  this.options.isRevealed = this.options.isRevealed || new RegExp(this.options.revealClass, 'g').test(this.$element[0].className);

  if(this.options.isRevealed){
    this.options.revealOn = this.options.revealOn || this.$element[0].className.match(/(reveal-for-medium|reveal-for-large)/g)[0].split('-')[2];
    this._setMQChecker();
  }
  if(!this.options.transitionTime){
    this.options.transitionTime = parseFloat(window.getComputedStyle($('[data-off-canvas-wrapper]')[0]).transitionDuration) * 1000;
  }
};

/**
 * Adds event handlers to the off-canvas wrapper and the exit overlay.
 * @function
 * @private
 */
OffCanvas.prototype._events = function() {
  this.$element.off('.zf.trigger .zf.offcanvas').on({
    'open.zf.trigger': this.open.bind(this),
    'close.zf.trigger': this.close.bind(this),
    'toggle.zf.trigger': this.toggle.bind(this),
    'keydown.zf.offcanvas': this._handleKeyboard.bind(this)
  });

  if (this.options.closeOnClick && this.$exiter.length) {
    this.$exiter.on({'click.zf.offcanvas': this.close.bind(this)});
  }
};
/**
 * Applies event listener for elements that will reveal at certain breakpoints.
 * @private
 */
OffCanvas.prototype._setMQChecker = function(){
  var _this = this;

  $(window).on('changed.zf.mediaquery', function(){
    if(Foundation.MediaQuery.atLeast(_this.options.revealOn)){
      _this.reveal(true);
    }else{
      _this.reveal(false);
    }
  }).one('load.zf.offcanvas', function(){
    if(Foundation.MediaQuery.atLeast(_this.options.revealOn)){
      _this.reveal(true);
    }
  });
};
/**
 * Handles the revealing/hiding the off-canvas at breakpoints, not the same as open.
 * @param {Boolean} isRevealed - true if element should be revealed.
 * @function
 */
OffCanvas.prototype.reveal = function(isRevealed){
  var $closer = this.$element.find('[data-close]');
  if(isRevealed){
    this.close();
    this.isRevealed = true;
    // if(!this.options.forceTop){
    //   var scrollPos = parseInt(window.pageYOffset);
    //   this.$element[0].style.transform = 'translate(0,' + scrollPos + 'px)';
    // }
    // if(this.options.isSticky){ this._stick(); }
    this.$element.off('open.zf.trigger toggle.zf.trigger');
    if($closer.length){ $closer.hide(); }
  }else{
    this.isRevealed = false;
    // if(this.options.isSticky || !this.options.forceTop){
    //   this.$element[0].style.transform = '';
    //   $(window).off('scroll.zf.offcanvas');
    // }
    this.$element.on({
      'open.zf.trigger': this.open.bind(this),
      'toggle.zf.trigger': this.toggle.bind(this)
    });
    if($closer.length){
      $closer.show();
    }
  }
};

/**
 * Opens the off-canvas menu.
 * @function
 * @param {Object} event - Event object passed from listener.
 * @param {jQuery} trigger - element that triggered the off-canvas to open.
 * @fires OffCanvas#opened
 */
OffCanvas.prototype.open = function(event, trigger) {
  if (this.$element.hasClass('is-open') || this.isRevealed){ return; }
  var _this = this,
      $body = $(document.body);
  $('body').scrollTop(0);
  // window.pageYOffset = 0;

  // if(!this.options.forceTop){
  //   var scrollPos = parseInt(window.pageYOffset);
  //   this.$element[0].style.transform = 'translate(0,' + scrollPos + 'px)';
  //   if(this.$exiter.length){
  //     this.$exiter[0].style.transform = 'translate(0,' + scrollPos + 'px)';
  //   }
  // }
  /**
   * Fires when the off-canvas menu opens.
   * @event OffCanvas#opened
   */
  Foundation.Move(this.options.transitionTime, this.$element, function(){
    $('[data-off-canvas-wrapper]').addClass('is-off-canvas-open is-open-'+ _this.options.position);

    _this.$element
      .addClass('is-open')

    // if(_this.options.isSticky){
    //   _this._stick();
    // }
  });
  this.$element.attr('aria-hidden', 'false')
      .trigger('opened.zf.offcanvas');

  if(this.options.closeOnClick){
    this.$exiter.addClass('is-visible');
  }
  if(trigger){
    this.$lastTrigger = trigger.attr('aria-expanded', 'true');
  }
  if(this.options.autoFocus){
    this.$element.one('finished.zf.animate', function(){
      _this.$element.find('a, button').eq(0).focus();
    });
  }
  if(this.options.trapFocus){
    $('[data-off-canvas-content]').attr('tabindex', '-1');
    this._trapFocus();
  }
};
/**
 * Traps focus within the offcanvas on open.
 * @private
 */
OffCanvas.prototype._trapFocus = function(){
  var focusable = Foundation.Keyboard.findFocusable(this.$element),
      first = focusable.eq(0),
      last = focusable.eq(-1);

  focusable.off('.zf.offcanvas').on('keydown.zf.offcanvas', function(e){
    if(e.which === 9 || e.keycode === 9){
      if(e.target === last[0] && !e.shiftKey){
        e.preventDefault();
        first.focus();
      }
      if(e.target === first[0] && e.shiftKey){
        e.preventDefault();
        last.focus();
      }
    }
  });
};
/**
 * Allows the offcanvas to appear sticky utilizing translate properties.
 * @private
 */
// OffCanvas.prototype._stick = function(){
//   var elStyle = this.$element[0].style;
//
//   if(this.options.closeOnClick){
//     var exitStyle = this.$exiter[0].style;
//   }
//
//   $(window).on('scroll.zf.offcanvas', function(e){
//     console.log(e);
//     var pageY = window.pageYOffset;
//     elStyle.transform = 'translate(0,' + pageY + 'px)';
//     if(exitStyle !== undefined){ exitStyle.transform = 'translate(0,' + pageY + 'px)'; }
//   });
//   // this.$element.trigger('stuck.zf.offcanvas');
// };
/**
 * Closes the off-canvas menu.
 * @function
 * @param {Function} cb - optional cb to fire after closure.
 * @fires OffCanvas#closed
 */
OffCanvas.prototype.close = function(cb) {
  if(!this.$element.hasClass('is-open') || this.isRevealed){ return; }

  var _this = this;

  //  Foundation.Move(this.options.transitionTime, this.$element, function(){
  $('[data-off-canvas-wrapper]').removeClass('is-off-canvas-open is-open-' + _this.options.position);
  _this.$element.removeClass('is-open');
    // Foundation._reflow();
  // });
  this.$element.attr('aria-hidden', 'true')
    /**
     * Fires when the off-canvas menu opens.
     * @event OffCanvas#closed
     */
      .trigger('closed.zf.offcanvas');
  // if(_this.options.isSticky || !_this.options.forceTop){
  //   setTimeout(function(){
  //     _this.$element[0].style.transform = '';
  //     $(window).off('scroll.zf.offcanvas');
  //   }, this.options.transitionTime);
  // }
  if(this.options.closeOnClick){
    this.$exiter.removeClass('is-visible');
  }

  this.$lastTrigger.attr('aria-expanded', 'false');
  if(this.options.trapFocus){
    $('[data-off-canvas-content]').removeAttr('tabindex');
  }

};

/**
 * Toggles the off-canvas menu open or closed.
 * @function
 * @param {Object} event - Event object passed from listener.
 * @param {jQuery} trigger - element that triggered the off-canvas to open.
 */
OffCanvas.prototype.toggle = function(event, trigger) {
  if (this.$element.hasClass('is-open')) {
    this.close(event, trigger);
  }
  else {
    this.open(event, trigger);
  }
};

/**
 * Handles keyboard input when detected. When the escape key is pressed, the off-canvas menu closes, and focus is restored to the element that opened the menu.
 * @function
 * @private
 */
OffCanvas.prototype._handleKeyboard = function(event) {
  if (event.which !== 27) return;

  event.stopPropagation();
  event.preventDefault();
  this.close();
  this.$lastTrigger.focus();
};
/**
 * Destroys the offcanvas plugin.
 * @function
 */
OffCanvas.prototype.destroy = function(){
  this.close();
  this.$element.off('.zf.trigger .zf.offcanvas');
  this.$exiter.off('.zf.offcanvas');

  Foundation.unregisterPlugin(this);
};

Foundation.plugin(OffCanvas, 'OffCanvas');

}(jQuery, Foundation);
