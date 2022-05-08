/* -------------------------------------------------------------------------- */

/*                                  Draggable                                 */

/* -------------------------------------------------------------------------- */

import {Sortable} from '@startinfinity/draggable'
import * as fn from './functions'
import {utils} from './utils'
import {Collapse} from "bootstrap";

var Selectors = {
    BODY: 'body',
    KANBAN_CONTAINER: '.kanban-container',
    KABNBAN_COLUMN: '.kanban-column',
    KANBAN_ITEMS_CONTAINER: '.kanban-items-container',
    KANBAN_ITEM: '.kanban-item',
    ADD_CARD_FORM: '.add-card-form'
}
var Events = {
    DRAG_START: 'drag:start',
    DRAG_STOP: 'drag:stop'
}
var ClassNames = {
    FORM_ADDED: 'form-added'
}
var columns = document.querySelectorAll(Selectors.KABNBAN_COLUMN);
var columnContainers = document.querySelectorAll(Selectors.KANBAN_ITEMS_CONTAINER);
var container = document.querySelector(Selectors.KANBAN_CONTAINER);

if (columnContainers.length) {
    // Initialize Sortable
    var sortable = new Sortable(columnContainers, {
        draggable: Selectors.KANBAN_ITEM,
        delay: 200,
        mirror: {
            appendTo: Selectors.BODY,
            constrainDimensions: true
        },
        scrollable: {
            draggable: Selectors.KANBAN_ITEM,
            scrollableElements: [].concat(fn._toConsumableArray(columnContainers), [container])
        }
    }) // Hide form when drag start

    sortable.on(Events.DRAG_START, function () {
        columns.forEach(function (column) {
            utils.hasClass(column, ClassNames.FORM_ADDED) && column.classList.remove(ClassNames.FORM_ADDED);
        });
    }) // Place forms and other contents bottom of the sortable container

    sortable.on(Events.DRAG_STOP, function (_ref2) {
        var el = _ref2.data.source;
        var columnContainer = el.closest(Selectors.KANBAN_ITEMS_CONTAINER);
        var form = columnContainer.querySelector(Selectors.ADD_CARD_FORM);
        !el.nextElementSibling && columnContainer.appendChild(form);
    })
}

var Selectors = {
    KANBAN_COLUMN: '.kanban-column',
    KANBAN_ITEMS_CONTAINER: '.kanban-items-container',
    BTN_ADD_CARD: '.btn-add-card',
    COLLAPSE: '.collapse',
    ADD_LIST_FORM: '#addListForm',
    BTN_COLLAPSE_DISMISS: '[data-dismiss="collapse"]',
    BTN_FORM_HIDE: '[data-btn-form="hide"]',
    INPUT_ADD_CARD: '[data-input="add-card"]',
    INPUT_ADD_LIST: '[data-input="add-list"]'
}
var ClassNames = {
    FORM_ADDED: 'form-added',
    D_NONE: 'd-none'
}
var Events = {
    CLICK: 'click',
    SHOW_BS_COLLAPSE: 'show.bs.collapse',
    SHOWN_BS_COLLAPSE: 'shown.bs.collapse'
}
var addCardButtons = document.querySelectorAll(Selectors.BTN_ADD_CARD);
var formHideButtons = document.querySelectorAll(Selectors.BTN_FORM_HIDE);
var addListForm = document.querySelector(Selectors.ADD_LIST_FORM);
var collapseDismissButtons = document.querySelectorAll(Selectors.BTN_COLLAPSE_DISMISS); // Show add card form and place scrollbar bottom of the list

addCardButtons && addCardButtons.forEach(function (button) {
    button.addEventListener(Events.CLICK, function (_ref4) {
        var el = _ref4.currentTarget
        var column = el.closest(Selectors.KANBAN_COLUMN)
        var container = column.querySelector(Selectors.KANBAN_ITEMS_CONTAINER)
        var scrollHeight = container.scrollHeight
        column.classList.add(ClassNames.FORM_ADDED)
        container.querySelector(Selectors.INPUT_ADD_CARD).focus()
        container.scrollTo({
            top: scrollHeight
        })
    })
}) // Remove add card form

formHideButtons.forEach(function (button) {
    button.addEventListener(Events.CLICK, function (_ref5) {
        var el = _ref5.currentTarget
        el.closest(Selectors.KANBAN_COLUMN).classList.remove(ClassNames.FORM_ADDED)
    })
})

if (addListForm) {
    // Hide add list button when the form is going to show
    addListForm.addEventListener(Events.SHOW_BS_COLLAPSE, function (_ref6) {
        var el = _ref6.currentTarget
        var nextElement = el.nextElementSibling
        nextElement && nextElement.classList.add(ClassNames.D_NONE)
    }) // Focus input field when the form is shown

    addListForm.addEventListener(Events.SHOWN_BS_COLLAPSE, function (_ref7) {
        var el = _ref7.currentTarget;
        el.querySelector(Selectors.INPUT_ADD_LIST).focus()
    })
} // Hide add list form when the dismiss button is clicked


collapseDismissButtons.forEach(function (button) {
    button.addEventListener(Events.CLICK, function (_ref8) {
        var el = _ref8.currentTarget;
        var collapseElement = el.closest(Selectors.COLLAPSE);
        var collapse = Collapse.getInstance(collapseElement);
        utils.hasClass(collapseElement.nextElementSibling, ClassNames.D_NONE) && collapseElement.nextElementSibling.classList.remove(ClassNames.D_NONE);
        collapse.hide();
    })
})