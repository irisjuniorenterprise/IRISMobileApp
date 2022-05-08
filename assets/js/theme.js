import * as fn from './functions'
import {utils} from './utils'
import {Toast,Tooltip} from 'bootstrap'
/* -------------------------------------------------------------------------- */

/*                                  Detector                                  */

/* -------------------------------------------------------------------------- */

import is from 'is_js'
  var html = document.querySelector('html')
  is.opera() && utils.addClass(html, 'opera')
  is.mobile() && utils.addClass(html, 'mobile')
  is.firefox() && utils.addClass(html, 'firefox')
  is.safari() && utils.addClass(html, 'safari')
  is.ios() && utils.addClass(html, 'ios')
  is.iphone() && utils.addClass(html, 'iphone')
  is.ipad() && utils.addClass(html, 'ipad')
  is.ie() && utils.addClass(html, 'ie')
  is.edge() && utils.addClass(html, 'edge')
  is.chrome() && utils.addClass(html, 'chrome')
  is.mac() && utils.addClass(html, 'osx')
  is.windows() && utils.addClass(html, 'windows')
  navigator.userAgent.match('CriOS') && utils.addClass(html, 'chrome')
/*-----------------------------------------------
|   DomNode
-----------------------------------------------*/

var DomNode = function () {
  function DomNode(node) {
    fn._classCallCheck(this, DomNode)

    this.node = node
  }

  fn._createClass(DomNode, [{
    key: "addClass",
    value: function addClass(className) {
      this.isValidNode() && this.node.classList.add(className)
    }
  }, {
    key: "removeClass",
    value: function removeClass(className) {
      this.isValidNode() && this.node.classList.remove(className)
    }
  }, {
    key: "toggleClass",
    value: function toggleClass(className) {
      this.isValidNode() && this.node.classList.toggle(className)
    }
  }, {
    key: "hasClass",
    value: function hasClass(className) {
      this.isValidNode() && this.node.classList.contains(className)
    }
  }, {
    key: "data",
    value: function data(key) {
      if (this.isValidNode()) {
        try {
          return JSON.parse(this.node.dataset[this.camelize(key)])
        } catch (e) {
          return this.node.dataset[this.camelize(key)]
        }
      }

      return null
    }
  }, {
    key: "attr",
    value: function attr(name) {
      return this.isValidNode() && this.node[name]
    }
  }, {
    key: "setAttribute",
    value: function setAttribute(name, value) {
      this.isValidNode() && this.node.setAttribute(name, value)
    }
  }, {
    key: "removeAttribute",
    value: function removeAttribute(name) {
      this.isValidNode() && this.node.removeAttribute(name)
    }
  }, {
    key: "setProp",
    value: function setProp(name, value) {
      this.isValidNode() && (this.node[name] = value)
    }
  }, {
    key: "on",
    value: function on(event, cb) {
      this.isValidNode() && this.node.addEventListener(event, cb)
    }
  }, {
    key: "isValidNode",
    value: function isValidNode() {
      return !!this.node
    } // eslint-disable-next-line class-methods-use-this

  }, {
    key: "camelize",
    value: function camelize(str) {
      var text = str.replace(/[-_\s.]+(.)?/g, function (_, c) {
        return c ? c.toUpperCase() : ''
      })
      return "".concat(text.substr(0, 1).toLowerCase()).concat(text.substr(1))
    }
  }])

  return DomNode
}()

/*-----------------------------------------------
|   Dashboard Table dropdown
-----------------------------------------------*/


var dropdownMenuInit = function dropdownMenuInit() {
  // Only for ios
  if (is.ios()) {
    var Event = {
      SHOWN_BS_DROPDOWN: 'shown.bs.dropdown',
      HIDDEN_BS_DROPDOWN: 'hidden.bs.dropdown'
    }
    var Selector = {
      TABLE_RESPONSIVE: '.table-responsive',
      DROPDOWN_MENU: '.dropdown-menu'
    }
    document.querySelectorAll(Selector.TABLE_RESPONSIVE).forEach(function (table) {
      table.addEventListener(Event.SHOWN_BS_DROPDOWN, function (e) {
        var t = e.currentTarget

        if (t.scrollWidth > t.clientWidth) {
          t.style.paddingBottom = "".concat(e.target.nextElementSibling.clientHeight, "px")
        }
      })
      table.addEventListener(Event.HIDDEN_BS_DROPDOWN, function (e) {
        e.currentTarget.style.paddingBottom = ''
      })
    })
  }
}; // Reference
// https://github.com/twbs/bootstrap/issues/11037#issuecomment-274870381

/* -------------------------------------------------------------------------- */

/*                             Navbar Combo Layout                            */

/* -------------------------------------------------------------------------- */


var navbarComboInit = function navbarComboInit() {
  var Selector = {
    NAVBAR_VERTICAL: '.navbar-vertical',
    NAVBAR_TOP_COMBO: '[data-navbar-top="combo"]',
    COLLAPSE: '.collapse',
    DATA_MOVE_CONTAINER: '[data-move-container]',
    NAVBAR_NAV: '.navbar-nav',
    NAVBAR_VERTICAL_DIVIDER: '.navbar-vertical-divider'
  }
  var ClassName = {
    FLEX_COLUMN: 'flex-column'
  }
  var navbarVertical = document.querySelector(Selector.NAVBAR_VERTICAL)
  var navbarTopCombo = document.querySelector(Selector.NAVBAR_TOP_COMBO)

  var moveNavContent = function moveNavContent(windowWidth) {
    var navbarVerticalBreakpoint = utils.getBreakpoint(navbarVertical)
    var navbarTopBreakpoint = utils.getBreakpoint(navbarTopCombo)

    if (windowWidth < navbarTopBreakpoint) {
      var navbarCollapse = navbarTopCombo.querySelector(Selector.COLLAPSE)
      var navbarTopContent = navbarCollapse.innerHTML

      if (navbarTopContent) {
        var targetID = utils.getData(navbarTopCombo, 'move-target')
        var targetElement = document.querySelector(targetID)
        navbarCollapse.innerHTML = ''
        targetElement.insertAdjacentHTML('afterend', "\n            <div data-move-container>\n              <div class='navbar-vertical-divider'>\n                <hr class='navbar-vertical-hr' />\n              </div>\n              ".concat(navbarTopContent, "\n            </div>\n          "))

        if (navbarVerticalBreakpoint < navbarTopBreakpoint) {
          var navbarNav = document.querySelector(Selector.DATA_MOVE_CONTAINER).querySelector(Selector.NAVBAR_NAV)
           utils.addClass(navbarNav, ClassName.FLEX_COLUMN)
        }
      }
    } else {
      var moveableContainer = document.querySelector(Selector.DATA_MOVE_CONTAINER)

      if (moveableContainer) {
        var _navbarNav = moveableContainer.querySelector(Selector.NAVBAR_NAV)

        utils.hasClass(_navbarNav, ClassName.FLEX_COLUMN) && _navbarNav.classList.remove(ClassName.FLEX_COLUMN)
        moveableContainer.querySelector(Selector.NAVBAR_VERTICAL_DIVIDER).remove()
        navbarTopCombo.querySelector(Selector.COLLAPSE).innerHTML = moveableContainer.innerHTML
        moveableContainer.remove()
      }
    }
  }

  moveNavContent(window.innerWidth)
  utils.resize(function () {
    return moveNavContent(window.innerWidth)
  })
}
/* -------------------------------------------------------------------------- */

/*                         Navbar Darken on scroll                        */

/* -------------------------------------------------------------------------- */


var navbarDarkenOnScroll = function navbarDarkenOnScroll() {
  var Selector = {
    NAVBAR: '[data-navbar-darken-on-scroll]',
    NAVBAR_COLLAPSE: '.navbar-collapse',
    NAVBAR_TOGGLER: '.navbar-toggler'
  }
  var ClassNames = {
    COLLAPSED: 'collapsed'
  }
  var Events = {
    SCROLL: 'scroll',
    SHOW_BS_COLLAPSE: 'show.bs.collapse',
    HIDE_BS_COLLAPSE: 'hide.bs.collapse',
    HIDDEN_BS_COLLAPSE: 'hidden.bs.collapse'
  }
  var DataKey = {
    NAVBAR_DARKEN_ON_SCROLL: 'navbar-darken-on-scroll'
  }
  var navbar = document.querySelector(Selector.NAVBAR)

  function removeNavbarBgClass() {
    navbar.classList.remove('bg-dark')
    navbar.classList.remove('bg-100')
  }

  var toggleThemeClass = function toggleThemeClass(theme) {
    if (theme === 'dark') {
      navbar.classList.remove('navbar-dark')
      navbar.classList.add('navbar-light')
    } else {
      navbar.classList.remove('navbar-light')
      navbar.classList.add('navbar-dark')
    }
  }

  function getBgClassName(name, defaultColorName) {
    var parent = document.documentElement

    var allColors = fn._objectSpread(_objectSpread({}, utils.getColors(parent)), utils.getGrays(parent))

    var colorName = Object.keys(allColors).includes(name) ? name : defaultColorName
    var color = allColors[colorName]
    var bgClassName = "bg-".concat(colorName)
    return {
      color: color,
      bgClassName: bgClassName
    }
  }

  if (navbar) {
    var theme = localStorage.getItem('theme')
    var defaultColorName = theme === 'dark' ? '100' : 'dark'
    var name = utils.getData(navbar, DataKey.NAVBAR_DARKEN_ON_SCROLL)
    toggleThemeClass(theme)
    var themeController = document.body
    themeController.addEventListener('clickControl', function (_ref10) {
      var _ref10$detail = _ref10.detail,
          control = _ref10$detail.control,
          value = _ref10$detail.value

      if (control === 'theme') {
        toggleThemeClass(value)
        defaultColorName = value === 'dark' ? '100' : 'dark'

        if (navbar.classList.contains('bg-dark') || navbar.classList.contains('bg-100')) {
          removeNavbarBgClass()
          navbar.classList.add(getBgClassName(name, defaultColorName).bgClassName)
        }
      }
    })
    var windowHeight = window.innerHeight
    var html = document.documentElement
    var navbarCollapse = navbar.querySelector(Selector.NAVBAR_COLLAPSE)
    var colorRgb = utils.hexToRgb(getBgClassName(name, defaultColorName).color)

    var _window$getComputedSt = window.getComputedStyle(navbar),
        backgroundImage = _window$getComputedSt.backgroundImage

    var transition = 'background-color 0.35s ease'
    navbar.style.backgroundImage = 'none'; // Change navbar background color on scroll

    window.addEventListener(Events.SCROLL, function () {
      var scrollTop = html.scrollTop
      var alpha = scrollTop / windowHeight * 2
      alpha >= 1 && (alpha = 1)
      navbar.style.backgroundColor = "rgba(".concat(colorRgb[0], ", ").concat(colorRgb[1], ", ").concat(colorRgb[2], ", ").concat(alpha, ")")
      navbar.style.backgroundImage = alpha > 0 || utils.hasClass(navbarCollapse, 'show') ? backgroundImage : 'none'
    }); // Toggle bg class on window resize

    utils.resize(function () {
      var breakPoint = utils.getBreakpoint(navbar)

      if (window.innerWidth > breakPoint) {
        removeNavbarBgClass()
        navbar.style.backgroundImage = html.scrollTop ? backgroundImage : 'none'
        navbar.style.transition = 'none'
      } else if (!utils.hasClass(navbar.querySelector(Selector.NAVBAR_TOGGLER), ClassNames.COLLAPSED)) {
        removeNavbarBgClass()
        navbar.style.backgroundImage = backgroundImage
      }

      if (window.innerWidth <= breakPoint) {
        navbar.style.transition = utils.hasClass(navbarCollapse, 'show') ? transition : 'none'
      }
    })
    navbarCollapse.addEventListener(Events.SHOW_BS_COLLAPSE, function () {
      navbar.classList.add(getBgClassName(name, defaultColorName).bgClassName)
      navbar.style.backgroundImage = backgroundImage
      navbar.style.transition = transition
    })
    navbarCollapse.addEventListener(Events.HIDE_BS_COLLAPSE, function () {
      removeNavbarBgClass()
      !html.scrollTop && (navbar.style.backgroundImage = 'none')
    })
    navbarCollapse.addEventListener(Events.HIDDEN_BS_COLLAPSE, function () {
      navbar.style.transition = 'none'
    })
  }
}
/* -------------------------------------------------------------------------- */

/*                                 Navbar Top                                 */

/* -------------------------------------------------------------------------- */


var navbarTopDropShadow = function navbarTopDropShadow() {
  var Selector = {
    NAVBAR: '.navbar:not(.navbar-vertical)',
    NAVBAR_VERTICAL: '.navbar-vertical',
    NAVBAR_VERTICAL_CONTENT: '.navbar-vertical-content',
    NAVBAR_VERTICAL_COLLAPSE: 'navbarVerticalCollapse'
  }
  var ClassNames = {
    NAVBAR_GLASS_SHADOW: 'navbar-glass-shadow',
    SHOW: 'show'
  }
  var Events = {
    SCROLL: 'scroll',
    SHOW_BS_COLLAPSE: 'show.bs.collapse',
    HIDDEN_BS_COLLAPSE: 'hidden.bs.collapse'
  }
  var navDropShadowFlag = true
  var $navbar = document.querySelector(Selector.NAVBAR)
  var $navbarVertical = document.querySelector(Selector.NAVBAR_VERTICAL)
  var $navbarVerticalContent = document.querySelector(Selector.NAVBAR_VERTICAL_CONTENT)
  var $navbarVerticalCollapse = document.getElementById(Selector.NAVBAR_VERTICAL_COLLAPSE)
  var html = document.documentElement
  var breakPoint = utils.getBreakpoint($navbarVertical)

  var setDropShadow = function setDropShadow($elem) {
    if ($elem.scrollTop > 0 && navDropShadowFlag) {
      $navbar && $navbar.classList.add(ClassNames.NAVBAR_GLASS_SHADOW)
    } else {
      $navbar && $navbar.classList.remove(ClassNames.NAVBAR_GLASS_SHADOW)
    }
  }

  window.addEventListener(Events.SCROLL, function () {
    setDropShadow(html)
  })

  if ($navbarVerticalContent) {
    $navbarVerticalContent.addEventListener(Events.SCROLL, function () {
      if (window.outerWidth < breakPoint) {
        navDropShadowFlag = true
        setDropShadow($navbarVerticalContent)
      }
    })
  }

  if ($navbarVerticalCollapse) {
    $navbarVerticalCollapse.addEventListener(Events.SHOW_BS_COLLAPSE, function () {
      if (window.outerWidth < breakPoint) {
        navDropShadowFlag = false
        setDropShadow(html)
      }
    })
  }

  if ($navbarVerticalCollapse) {
    $navbarVerticalCollapse.addEventListener(Events.HIDDEN_BS_COLLAPSE, function () {
      navDropShadowFlag = !(utils.hasClass($navbarVerticalCollapse, ClassNames.SHOW) && window.outerWidth < breakPoint);

      setDropShadow(html)
    })
  }
}
/* -------------------------------------------------------------------------- */

/*                               Navbar Vertical                              */

/* -------------------------------------------------------------------------- */


var handleNavbarVerticalCollapsed = function handleNavbarVerticalCollapsed() {
  var Selector = {
    HTML: 'html',
    NAVBAR_VERTICAL_TOGGLE: '.navbar-vertical-toggle',
    NAVBAR_VERTICAL_COLLAPSE: '.navbar-vertical .navbar-collapse',
    ECHART_RESPONSIVE: '[data-echart-responsive]'
  }
  var Events = {
    CLICK: 'click',
    MOUSE_OVER: 'mouseover',
    MOUSE_LEAVE: 'mouseleave',
    NAVBAR_VERTICAL_TOGGLE: 'navbar.vertical.toggle'
  }
  var ClassNames = {
    NAVBAR_VERTICAL_COLLAPSED: 'navbar-vertical-collapsed',
    NAVBAR_VERTICAL_COLLAPSED_HOVER: 'navbar-vertical-collapsed-hover'
  }
  var navbarVerticalToggle = document.querySelector(Selector.NAVBAR_VERTICAL_TOGGLE)
  var html = document.querySelector(Selector.HTML)
  var navbarVerticalCollapse = document.querySelector(Selector.NAVBAR_VERTICAL_COLLAPSE)

  if (navbarVerticalToggle) {
    navbarVerticalToggle.addEventListener(Events.CLICK, function (e) {
      navbarVerticalToggle.blur()
      html.classList.toggle(ClassNames.NAVBAR_VERTICAL_COLLAPSED); // Set collapse state on localStorage

      var isNavbarVerticalCollapsed = utils.getItemFromStore('isNavbarVerticalCollapsed')
      utils.setItemToStore('isNavbarVerticalCollapsed', !isNavbarVerticalCollapsed)
      var event = new CustomEvent(Events.NAVBAR_VERTICAL_TOGGLE)
      e.currentTarget.dispatchEvent(event)
    })
  }

  if (navbarVerticalCollapse) {
    navbarVerticalCollapse.addEventListener(Events.MOUSE_OVER, function () {
      if (utils.hasClass(html, ClassNames.NAVBAR_VERTICAL_COLLAPSED)) {
        html.classList.add(ClassNames.NAVBAR_VERTICAL_COLLAPSED_HOVER)
      }
    })
    navbarVerticalCollapse.addEventListener(Events.MOUSE_LEAVE, function () {
      if (utils.hasClass(html, ClassNames.NAVBAR_VERTICAL_COLLAPSED_HOVER)) {
        html.classList.remove(ClassNames.NAVBAR_VERTICAL_COLLAPSED_HOVER)
      }
    })
  }
}
/* -------------------------------------------------------------------------- */

/*                                Theme Control                               */

/* -------------------------------------------------------------------------- */

/* eslint-disable no-param-reassign */


var initialDomSetup = function initialDomSetup(element) {
  if (!element) return
  var dataUrlDom = element.querySelector('[data-theme-control = "navbarPosition"]')
  var hasDataUrl = dataUrlDom ?utils.getData(dataUrlDom, 'page-url') : null
  element.querySelectorAll('[data-theme-control]').forEach(function (el) {
    var inputDataAttributeValue =utils.getData(el, 'theme-control')
    var localStorageValue = utils.getItemFromStore(inputDataAttributeValue)

    if (inputDataAttributeValue === 'navbarStyle' && !hasDataUrl && utils.getItemFromStore('navbarPosition') === 'top') {
      el.setAttribute('disabled', true)
    }

    if (el.type === 'checkbox') {
      if (inputDataAttributeValue === 'theme') {
        localStorageValue === 'dark' && el.setAttribute('checked', true)
      } else {
        localStorageValue && el.setAttribute('checked', true)
      }
    } else {
      var isChecked = localStorageValue === el.value
      isChecked && el.setAttribute('checked', true)
    }
  })
}

var changeTheme = function changeTheme(element) {
  element.querySelectorAll('[data-theme-control = "theme"]').forEach(function (el) {
    var inputDataAttributeValue =utils.getData(el, 'theme-control')
    var localStorageValue = utils.getItemFromStore(inputDataAttributeValue)

    if (el.type === 'checkbox') {
      localStorageValue === 'dark' ? el.checked = true : el.checked = false
    } else {
      localStorageValue === el.value ? el.checked = true : el.checked = false
    }
  })
}

var themeControl = function themeControl() {
  var themeController = new DomNode(document.body)
  var navbarVertical = document.querySelector('.navbar-vertical')
  initialDomSetup(themeController.node)
  themeController.on('click', function (e) {
    var target = new DomNode(e.target)

    if (target.data('theme-control')) {
      var control = target.data('theme-control')
      var value = e.target[e.target.type === 'radio' ? 'value' : 'checked']

      if (control === 'theme') {
        typeof value === 'boolean' && (value = value ? 'dark' : 'light')
      }

      utils.setItemToStore(control, value)

      switch (control) {
        case 'theme':
          {
            document.documentElement.classList[value === 'dark' ? 'add' : 'remove']('dark')
            var clickControl = new CustomEvent('clickControl', {
              detail: {
                control: control,
                value: value
              }
            })
            e.currentTarget.dispatchEvent(clickControl)
            changeTheme(themeController.node)
            break
          }

        case 'navbarStyle':
          {
            navbarVertical.classList.remove('navbar-card')
            navbarVertical.classList.remove('navbar-inverted')
            navbarVertical.classList.remove('navbar-vibrant')

            if (value !== 'transparent') {
              navbarVertical.classList.add("navbar-".concat(value))
            }

            break
          }

        case 'navbarPosition':
          {
            var pageUrl =utils.getData(target.node, 'page-url')
            pageUrl ? window.location.replace(pageUrl) : window.location.reload()
            break
          }

        default:
          window.location.reload()
      }
    }
  })
}
/* -------------------------------------------------------------------------- */

/*                                    Toast                                   */

/* -------------------------------------------------------------------------- */



  var toastElList = [].slice.call(document.querySelectorAll('.toast'))
  toastElList.map(function (toastEl) {
    return new Toast(toastEl)
  })
  var liveToastBtn = document.getElementById('liveToastBtn')

  if (liveToastBtn) {
    var liveToast = new Toast(document.getElementById('liveToast'))
    liveToastBtn.addEventListener('click', function () {
      liveToast && liveToast.show()
    })
  }

/* -------------------------------------------------------------------------- */

/*                                   Tooltip                                  */

/* -------------------------------------------------------------------------- */


  var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
  tooltipTriggerList.map(function (tooltipTriggerEl) {
    return new Tooltip(tooltipTriggerEl, {
      trigger: 'hover'
    })
  })

/* -------------------------------------------------------------------------- */

/*                            Theme Initialization                            */

/* -------------------------------------------------------------------------- */


utils.docReady(handleNavbarVerticalCollapsed)

utils.docReady(navbarTopDropShadow)

utils.docReady(navbarDarkenOnScroll)

utils.docReady(navbarComboInit)

utils.docReady(themeControl)

utils.docReady(dropdownMenuInit)


