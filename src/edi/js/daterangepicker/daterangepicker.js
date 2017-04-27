/**
 * @version: 2.1.13
 * @author: Dan Grossman http://www.dangrossman.info/
 * @copyright: Copyright (c) 2012-2015 Dan Grossman. All rights reserved.
 * @license: Licensed under the MIT license. See http://www.opensource.org/licenses/mit-license.php
 * @website: https://www.improvely.com/
 */

(function(root, factory) {

    if (typeof define === 'function' && define.amd) {
        define(['moment', 'jquery', 'exports'], function(momentjs, $, exports) {
            root.daterangepicker = factory(root, exports, momentjs, $);
        });

    } else if (typeof exports !== 'undefined') {
        var momentjs = require('moment');
        var jQuery = (typeof window != 'undefined') ? window.jQuery : undefined;  //isomorphic issue
        if (!jQuery) {
            try {
                jQuery = require('jquery');
                if (!jQuery.fn) jQuery.fn = {}; //isomorphic issue
            } catch (err) {
                if (!jQuery) throw new Error('jQuery dependency not found');
            }
        }

        factory(root, exports, momentjs, jQuery);

        // Finally, as a browser global.
    } else {
        root.daterangepicker = factory(root, {}, root.moment || moment, (root.jQuery || root.Zepto || root.ender || root.$));
    }

}(this || {}, function(root, daterangepicker, moment, $) { // 'this' doesn't exist on a server

    var DateRangePicker = function(element, options, cb) {

        //default settings for options
        this.parentEl = 'body';
        this.element = $(element);
        this.startDate = moment().startOf('day');
        this.endDate = moment().endOf('day');
        this.minDate = false;
        this.maxDate = false;
        this.dateLimit = false;
        this.autoApply = false;
        this.singleDatePicker = false;
        this.showDropdowns = false;
        this.showWeekNumbers = false;
        this.timePicker = false;
        this.timePicker24Hour = false;
        this.timePickerIncrement = 1;
        this.timePickerSeconds = false;
        this.linkedCalendars = true;
        this.autoUpdateInput = true;
        this.ranges = {};

        this.opens = 'right';
        if (this.element.hasClass('pull-right'))
            this.opens = 'left';

        this.drops = 'down';
        if (this.element.hasClass('dropup'))
            this.drops = 'up';

        this.buttonClasses = 'btn btn-sm';
        this.applyClass = 'btn-success';
        this.cancelClass = 'btn-default';

        this.locale = {
            format: 'MM/DD/YYYY',
            separator: ' - ',
            applyLabel: 'Apply',
            cancelLabel: 'Cancel',
            weekLabel: 'W',
            customRangeLabel: 'Custom Range',
            daysOfWeek: moment.weekdaysMin(),
            monthNames: moment.monthsShort(),
            firstDay: moment.localeData().firstDayOfWeek()
        };

        this.callback = function() { };

        //some state information
        this.isShowing = false;
        this.leftCalendar = {};
        this.rightCalendar = {};

        //custom options from user
        if (typeof options !== 'object' || options === null)
            options = {};

        //allow setting options with data attributes
        //data-api options will be overwritten with custom javascript options
        options = $.extend(this.element.data(), options);

        //html template for the picker UI
        if (typeof options.template !== 'string')
            options.template = '<div class="daterangepicker dropdown-menu">' +
            '<div class="calendar left">' +
            '<div class="daterangepicker_input">' +
            '<input class="input-mini" type="text" name="daterangepicker_start" value="" />' +
            '<i class="fa fa-calendar glyphicon glyphicon-calendar"></i>' +
            '<div class="calendar-time">' +
            '<div></div>' +
            '<i class="fa fa-clock-o glyphicon glyphicon-time"></i>' +
            '</div>' +
            '</div>' +
            '<div class="calendar-table"></div>' +
            '</div>' +
            '<div class="calendar right">' +
            '<div class="daterangepicker_input">' +
            '<input class="input-mini" type="text" name="daterangepicker_end" value="" />' +
            '<i class="fa fa-calendar glyphicon glyphicon-calendar"></i>' +
            '<div class="calendar-time">' +
            '<div></div>' +
            '<i class="fa fa-clock-o glyphicon glyphicon-time"></i>' +
            '</div>' +
            '</div>' +
            '<div class="calendar-table"></div>' +
            '</div>' +
            '<div class="ranges">' +
            '<div class="range_inputs">' +
            '<button class="applyBtn" disabled="disabled" type="button"></button> ' +
            '<button class="cancelBtn" type="button"></button>' +
            '</div>' +
            '</div>' +
            '</div>';

        this.parentEl = (options.parentEl && $(options.parentEl).length) ? $(options.parentEl) : $(this.parentEl);
        this.container = $(options.template).appendTo(this.parentEl);

        //
        // handle all the possible options overriding defaults
        //

        if (typeof options.locale === 'object') {

            if (typeof options.locale.format === 'string')
                this.locale.format = options.locale.format;

            if (typeof options.locale.separator === 'string')
                this.locale.separator = options.locale.separator;

            if (typeof options.locale.daysOfWeek === 'object')
                this.locale.daysOfWeek = options.locale.daysOfWeek.slice();

            if (typeof options.locale.monthNames === 'object')
                this.locale.monthNames = options.locale.monthNames.slice();

            if (typeof options.locale.firstDay === 'number')
                this.locale.firstDay = options.locale.firstDay;

            if (typeof options.locale.applyLabel === 'string')
                this.locale.applyLabel = options.locale.applyLabel;

            if (typeof options.locale.cancelLabel === 'string')
                this.locale.cancelLabel = options.locale.cancelLabel;

            if (typeof options.locale.weekLabel === 'string')
                this.locale.weekLabel = options.locale.weekLabel;

            if (typeof options.locale.customRangeLabel === 'string')
                this.locale.customRangeLabel = options.locale.customRangeLabel;

        }

        if (typeof options.startDate === 'string')
            this.startDate = moment(options.startDate, this.locale.format);

        if (typeof options.endDate === 'string')
            this.endDate = moment(options.endDate, this.locale.format);

        if (typeof options.minDate === 'string')
            this.minDate = moment(options.minDate, this.locale.format);

        if (typeof options.maxDate === 'string')
            this.maxDate = moment(options.maxDate, this.locale.format);

        if (typeof options.startDate === 'object')
            this.startDate = moment(options.startDate);

        if (typeof options.endDate === 'object')
            this.endDate = moment(options.endDate);

        if (typeof options.minDate === 'object')
            this.minDate = moment(options.minDate);

        if (typeof options.maxDate === 'object')
            this.maxDate = moment(options.maxDate);

        // sanity check for bad options
        if (this.minDate && this.startDate.isBefore(this.minDate))
            this.startDate = this.minDate.clone();

        // sanity check for bad options
        if (this.maxDate && this.endDate.isAfter(this.maxDate))
            this.endDate = this.maxDate.clone();

        if (typeof options.applyClass === 'string')
            this.applyClass = options.applyClass;

        if (typeof options.cancelClass === 'string')
            this.cancelClass = options.cancelClass;

        if (typeof options.dateLimit === 'object')
            this.dateLimit = options.dateLimit;

        if (typeof options.opens === 'string')
            this.opens = options.opens;

        if (typeof options.drops === 'string')
            this.drops = options.drops;

        if (typeof options.showWeekNumbers === 'boolean')
            this.showWeekNumbers = options.showWeekNumbers;

        if (typeof options.buttonClasses === 'string')
            this.buttonClasses = options.buttonClasses;

        if (typeof options.buttonClasses === 'object')
            this.buttonClasses = options.buttonClasses.join(' ');

        if (typeof options.showDropdowns === 'boolean')
            this.showDropdowns = options.showDropdowns;

        if (typeof options.singleDatePicker === 'boolean') {
            this.singleDatePicker = options.singleDatePicker;
            if (this.singleDatePicker)
                this.endDate = this.startDate.clone();
        }

        if (typeof options.timePicker === 'boolean')
            this.timePicker = options.timePicker;

        if (typeof options.timePickerSeconds === 'boolean')
            this.timePickerSeconds = options.timePickerSeconds;

        if (typeof options.timePickerIncrement === 'number')
            this.timePickerIncrement = options.timePickerIncrement;

        if (typeof options.timePicker24Hour === 'boolean')
            this.timePicker24Hour = options.timePicker24Hour;

        if (typeof options.autoApply === 'boolean')
            this.autoApply = options.autoApply;

        if (typeof options.autoUpdateInput === 'boolean')
            this.autoUpdateInput = options.autoUpdateInput;

        if (typeof options.linkedCalendars === 'boolean')
            this.linkedCalendars = options.linkedCalendars;

        if (typeof options.isInvalidDate === 'function')
            this.isInvalidDate = options.isInvalidDate;

        // update day names order to firstDay
        if (this.locale.firstDay != 0) {
            var iterator = this.locale.firstDay;
            while (iterator > 0) {
                this.locale.daysOfWeek.push(this.locale.daysOfWeek.shift());
                iterator--;
            }
        }

        var start, end, range;

        //if no start/end dates set, check if an input element contains initial values
        if (typeof options.startDate === 'undefined' && typeof options.endDate === 'undefined') {
            if ($(this.element).is('input[type=text]')) {
                var val = $(this.element).val(),
                    split = val.split(this.locale.separator);

                start = end = null;

                if (split.length == 2) {
                    start = moment(split[0], this.locale.format);
                    end = moment(split[1], this.locale.format);
                } else if (this.singleDatePicker && val !== "") {
                    start = moment(val, this.locale.format);
                    end = moment(val, this.locale.format);
                }
                if (start !== null && end !== null) {
                    this.setStartDate(start);
                    this.setEndDate(end);
                }
            }
        }

        if (typeof options.ranges === 'object') {
            for (range in options.ranges) {

                if (typeof options.ranges[range][0] === 'string')
                    start = moment(options.ranges[range][0], this.locale.format);
                else
                    start = moment(options.ranges[range][0]);

                if (typeof options.ranges[range][1] === 'string')
                    end = moment(options.ranges[range][1], this.locale.format);
                else
                    end = moment(options.ranges[range][1]);

                // If the start or end date exceed those allowed by the minDate or dateLimit
                // options, shorten the range to the allowable period.
                if (this.minDate && start.isBefore(this.minDate))
                    start = this.minDate.clone();

                var maxDate = this.maxDate;
                if (this.dateLimit && start.clone().add(this.dateLimit).isAfter(maxDate))
                    maxDate = start.clone().add(this.dateLimit);
                if (maxDate && end.isAfter(maxDate))
                    end = maxDate.clone();

                // If the end of the range is before the minimum or the start of the range is
                // after the maximum, don't display this range option at all.
                if ((this.minDate && end.isBefore(this.minDate)) || (maxDate && start.isAfter(maxDate)))
                    continue;

                //Support unicode chars in the range names.
                var elem = document.createElement('textarea');
                elem.innerHTML = range;
                rangeHtml = elem.value;

                this.ranges[rangeHtml] = [start, end];
            }

            var list = '<ul>';
            for (range in this.ranges) {
                list += '<li>' + range + '</li>';
            }
            list += '<li>' + this.locale.customRangeLabel + '</li>';
            list += '</ul>';
            this.container.find('.ranges').prepend(list);
        }

        if (typeof cb === 'function') {
            this.callback = cb;
        }

        if (!this.timePicker) {
            this.startDate = this.startDate.startOf('day');
            this.endDate = this.endDate.endOf('day');
            this.container.find('.calendar-time').hide();
        }

        //can't be used together for now
        if (this.timePicker && this.autoApply)
            this.autoApply = false;

        if (this.autoApply && typeof options.ranges !== 'object') {
            this.container.find('.ranges').hide();
        } else if (this.autoApply) {
            this.container.find('.applyBtn, .cancelBtn').addClass('hide');
        }

        if (this.singleDatePicker) {
            this.container.addClass('single');
            this.container.find('.calendar.left').addClass('single');
            this.container.find('.calendar.left').show();
            this.container.find('.calendar.right').hide();
            this.container.find('.daterangepicker_input input, .daterangepicker_input i').hide();
            if (!this.timePicker) {
                this.container.find('.ranges').hide();
            }
        }

        if (typeof options.ranges === 'undefined' && !this.singleDatePicker) {
            this.container.addClass('show-calendar');
        }

        this.container.addClass('opens' + this.opens);

        //swap the position of the predefined ranges if opens right
        if (typeof options.ranges !== 'undefined' && this.opens == 'right') {
            var ranges = this.container.find('.ranges');
            var html = ranges.clone();
            ranges.remove();
            this.container.find('.calendar.left').parent().prepend(html);
        }

        //apply CSS classes and labels to buttons
        this.container.find('.applyBtn, .cancelBtn').addClass(this.buttonClasses);
        if (this.applyClass.length)
            this.container.find('.applyBtn').addClass(this.applyClass);
        if (this.cancelClass.length)
            this.container.find('.cancelBtn').addClass(this.cancelClass);
        this.container.find('.applyBtn').html(this.locale.applyLabel);
        this.container.find('.cancelBtn').html(this.locale.cancelLabel);

        //
        // event listeners
        //

        this.container.find('.calendar')
            .on('click.daterangepicker', '.prev', $.proxy(this.clickPrev, this))
            .on('click.daterangepicker', '.next', $.proxy(this.clickNext, this))
            .on('click.daterangepicker', 'td.available', $.proxy(this.clickDate, this))
            .on('mouseenter.daterangepicker', 'td.available', $.proxy(this.hoverDate, this))
            .on('mouseleave.daterangepicker', 'td.available', $.proxy(this.updateFormInputs, this))
            .on('change.daterangepicker', 'select.yearselect', $.proxy(this.monthOrYearChanged, this))
            .on('change.daterangepicker', 'select.monthselect', $.proxy(this.monthOrYearChanged, this))
            .on('change.daterangepicker', 'select.hourselect,select.minuteselect,select.secondselect,select.ampmselect', $.proxy(this.timeChanged, this))
            .on('click.daterangepicker', '.daterangepicker_input input', $.proxy(this.showCalendars, this))
            //.on('keyup.daterangepicker', '.daterangepicker_input input', $.proxy(this.formInputsChanged, this))
            .on('change.daterangepicker', '.daterangepicker_input input', $.proxy(this.formInputsChanged, this));

        this.container.find('.ranges')
            .on('click.daterangepicker', 'button.applyBtn', $.proxy(this.clickApply, this))
            .on('click.daterangepicker', 'button.cancelBtn', $.proxy(this.clickCancel, this))
            .on('click.daterangepicker', 'li', $.proxy(this.clickRange, this))
            .on('mouseenter.daterangepicker', 'li', $.proxy(this.hoverRange, this))
            .on('mouseleave.daterangepicker', 'li', $.proxy(this.updateFormInputs, this));

        if (this.element.is('input')) {
            this.element.on({
                'click.daterangepicker': $.proxy(this.show, this),
                'focus.daterangepicker': $.proxy(this.show, this),
                'keyup.daterangepicker': $.proxy(this.elementChanged, this),
                'keydown.daterangepicker': $.proxy(this.keydown, this)
            });
        } else {
            this.element.on('click.daterangepicker', $.proxy(this.toggle, this));
        }

        //
        // if attached to a text input, set the initial value
        //

        if (this.element.is('input') && !this.singleDatePicker && this.autoUpdateInput) {
            this.element.val(this.startDate.format(this.locale.format) + this.locale.separator + this.endDate.format(this.locale.format));
            this.element.trigger('change');
        } else if (this.element.is('input') && this.autoUpdateInput) {
            this.element.val(this.startDate.format(this.locale.format));
            this.element.trigger('change');
        }

    };

    DateRangePicker.prototype = {

        constructor: DateRangePicker,

        setStartDate: function(startDate) {
            if (typeof startDate === 'string')
                this.startDate = moment(startDate, this.locale.format);

            if (typeof startDate === 'object')
                this.startDate = moment(startDate);

            if (!this.timePicker)
                this.startDate = this.startDate.startOf('day');

            if (this.timePicker && this.timePickerIncrement)
                this.startDate.minute(Math.round(this.startDate.minute() / this.timePickerIncrement) * this.timePickerIncrement);

            if (this.minDate && this.startDate.isBefore(this.minDate))
                this.startDate = this.minDate;

            if (this.maxDate && this.startDate.isAfter(this.maxDate))
                this.startDate = this.maxDate;

            if (!this.isShowing)
                this.updateElement();

            this.updateMonthsInView();
        },

        setEndDate: function(endDate) {
            if (typeof endDate === 'string')
                this.endDate = moment(endDate, this.locale.format);

            if (typeof endDate === 'object')
                this.endDate = moment(endDate);

            if (!this.timePicker)
                this.endDate = this.endDate.endOf('day');

            if (this.timePicker && this.timePickerIncrement)
                this.endDate.minute(Math.round(this.endDate.minute() / this.timePickerIncrement) * this.timePickerIncrement);

            if (this.endDate.isBefore(this.startDate))
                this.endDate = this.startDate.clone();

            if (this.maxDate && this.endDate.isAfter(this.maxDate))
                this.endDate = this.maxDate;

            if (this.dateLimit && this.startDate.clone().add(this.dateLimit).isBefore(this.endDate))
                this.endDate = this.startDate.clone().add(this.dateLimit);

            if (!this.isShowing)
                this.updateElement();

            this.updateMonthsInView();
        },

        isInvalidDate: function() {
            return false;
        },

        updateView: function() {
            if (this.timePicker) {
                this.renderTimePicker('left');
                this.renderTimePicker('right');
                if (!this.endDate) {
                    this.container.find('.right .calendar-time select').attr('disabled', 'disabled').addClass('disabled');
                } else {
                    this.container.find('.right .calendar-time select').removeAttr('disabled').removeClass('disabled');
                }
            }
            if (this.endDate) {
                this.container.find('input[name="daterangepicker_end"]').removeClass('active');
                this.container.find('input[name="daterangepicker_start"]').addClass('active');
            } else {
                this.container.find('input[name="daterangepicker_end"]').addClass('active');
                this.container.find('input[name="daterangepicker_start"]').removeClass('active');
            }
            this.updateMonthsInView();
            this.updateCalendars();
            this.updateFormInputs();
        },

        updateMonthsInView: function() {
            if (this.endDate) {

                //if both dates are visible already, do nothing
                if (!this.singleDatePicker && this.leftCalendar.month && this.rightCalendar.month &&
                    (this.startDate.format('YYYY-MM') == this.leftCalendar.month.format('YYYY-MM') || this.startDate.format('YYYY-MM') == this.rightCalendar.month.format('YYYY-MM'))
                    &&
                    (this.endDate.format('YYYY-MM') == this.leftCalendar.month.format('YYYY-MM') || this.endDate.format('YYYY-MM') == this.rightCalendar.month.format('YYYY-MM'))
                ) {
                    return;
                }

                this.leftCalendar.month = this.startDate.clone().date(2);
                if (!this.linkedCalendars && (this.endDate.month() != this.startDate.month() || this.endDate.year() != this.startDate.year())) {
                    this.rightCalendar.month = this.endDate.clone().date(2);
                } else {
                    this.rightCalendar.month = this.startDate.clone().date(2).add(1, 'month');
                }

            } else {
                if (this.leftCalendar.month.format('YYYY-MM') != this.startDate.format('YYYY-MM') && this.rightCalendar.month.format('YYYY-MM') != this.startDate.format('YYYY-MM')) {
                    this.leftCalendar.month = this.startDate.clone().date(2);
                    this.rightCalendar.month = this.startDate.clone().date(2).add(1, 'month');
                }
            }
        },

        updateCalendars: function() {

            if (this.timePicker) {
                var hour, minute, second;
                if (this.endDate) {
                    hour = parseInt(this.container.find('.left .hourselect').val(), 10);
                    minute = parseInt(this.container.find('.left .minuteselect').val(), 10);
                    second = this.timePickerSeconds ? parseInt(this.container.find('.left .secondselect').val(), 10) : 0;
                    if (!this.timePicker24Hour) {
                        var ampm = this.container.find('.left .ampmselect').val();
                        if (ampm === 'PM' && hour < 12)
                            hour += 12;
                        if (ampm === 'AM' && hour === 12)
                            hour = 0;
                    }
                } else {
                    hour = parseInt(this.container.find('.right .hourselect').val(), 10);
                    minute = parseInt(this.container.find('.right .minuteselect').val(), 10);
                    second = this.timePickerSeconds ? parseInt(this.container.find('.right .secondselect').val(), 10) : 0;
                    if (!this.timePicker24Hour) {
                        var ampm = this.container.find('.left .ampmselect').val();
                        if (ampm === 'PM' && hour < 12)
                            hour += 12;
                        if (ampm === 'AM' && hour === 12)
                            hour = 0;
                    }
                }
                this.leftCalendar.month.hour(hour).minute(minute).second(second);
                this.rightCalendar.month.hour(hour).minute(minute).second(second);
            }

            this.renderCalendar('left');
            this.renderCalendar('right');

            //highlight any predefined range matching the current start and end dates
            this.container.find('.ranges li').removeClass('active');
            if (this.endDate == null) return;

            var customRange = true;
            var i = 0;
            for (var range in this.ranges) {
                if (this.timePicker) {
                    if (this.startDate.isSame(this.ranges[range][0]) && this.endDate.isSame(this.ranges[range][1])) {
                        customRange = false;
                        this.chosenLabel = this.container.find('.ranges li:eq(' + i + ')').addClass('active').html();
                        break;
                    }
                } else {
                    //ignore times when comparing dates if time picker is not enabled
                    if (this.startDate.format('YYYY-MM-DD') == this.ranges[range][0].format('YYYY-MM-DD') && this.endDate.format('YYYY-MM-DD') == this.ranges[range][1].format('YYYY-MM-DD')) {
                        customRange = false;
                        this.chosenLabel = this.container.find('.ranges li:eq(' + i + ')').addClass('active').html();
                        break;
                    }
                }
                i++;
            }
            if (customRange) {
                this.chosenLabel = this.container.find('.ranges li:last').addClass('active').html();
                this.showCalendars();
            }

        },

        renderCalendar: function(side) {

            //
            // Build the matrix of dates that will populate the calendar
            //

            var calendar = side == 'left' ? this.leftCalendar : this.rightCalendar;
            var month = calendar.month.month();
            var year = calendar.month.year();
            var hour = calendar.month.hour();
            var minute = calendar.month.minute();
            var second = calendar.month.second();
            var daysInMonth = moment([year, month]).daysInMonth();
            var firstDay = moment([year, month, 1]);
            var lastDay = moment([year, month, daysInMonth]);
            var lastMonth = moment(firstDay).subtract(1, 'month').month();
            var lastYear = moment(firstDay).subtract(1, 'month').year();
            var daysInLastMonth = moment([lastYear, lastMonth]).daysInMonth();
            var dayOfWeek = firstDay.day();

            //initialize a 6 rows x 7 columns array for the calendar
            var calendar = [];
            calendar.firstDay = firstDay;
            calendar.lastDay = lastDay;

            for (var i = 0; i < 6; i++) {
                calendar[i] = [];
            }

            //populate the calendar with date objects
            var startDay = daysInLastMonth - dayOfWeek + this.locale.firstDay + 1;
            if (startDay > daysInLastMonth)
                startDay -= 7;

            if (dayOfWeek == this.locale.firstDay)
                startDay = daysInLastMonth - 6;

            var curDate = moment([lastYear, lastMonth, startDay, 12, minute, second]);

            var col, row;
            for (var i = 0, col = 0, row = 0; i < 42; i++, col++, curDate = moment(curDate).add(24, 'hour')) {
                if (i > 0 && col % 7 === 0) {
                    col = 0;
                    row++;
                }
                calendar[row][col] = curDate.clone().hour(hour).minute(minute).second(second);
                curDate.hour(12);

                if (this.minDate && calendar[row][col].format('YYYY-MM-DD') == this.minDate.format('YYYY-MM-DD') && calendar[row][col].isBefore(this.minDate) && side == 'left') {
                    calendar[row][col] = this.minDate.clone();
                }

                if (this.maxDate && calendar[row][col].format('YYYY-MM-DD') == this.maxDate.format('YYYY-MM-DD') && calendar[row][col].isAfter(this.maxDate) && side == 'right') {
                    calendar[row][col] = this.maxDate.clone();
                }

            }

            //make the calendar object available to hoverDate/clickDate
            if (side == 'left') {
                this.leftCalendar.calendar = calendar;
            } else {
                this.rightCalendar.calendar = calendar;
            }

            //
            // Display the calendar
            //

            var minDate = side == 'left' ? this.minDate : this.startDate;
            var maxDate = this.maxDate;
            var selected = side == 'left' ? this.startDate : this.endDate;

            var html = '<table class="table-condensed">';
            html += '<thead>';
            html += '<tr>';

            // add empty cell for week number
            if (this.showWeekNumbers)
                html += '<th></th>';

            if ((!minDate || minDate.isBefore(calendar.firstDay)) && (!this.linkedCalendars || side == 'left')) {
                html += '<th class="prev available"><i class="fa fa-chevron-left glyphicon glyphicon-chevron-left"></i></th>';
            } else {
                html += '<th></th>';
            }

            var dateHtml = this.locale.monthNames[calendar[1][1].month()] + calendar[1][1].format(" YYYY");

            if (this.showDropdowns) {
                var currentMonth = calendar[1][1].month();
                var currentYear = calendar[1][1].year();
                var maxYear = (maxDate && maxDate.year()) || (currentYear + 5);
                var minYear = (minDate && minDate.year()) || (currentYear - 50);
                var inMinYear = currentYear == minYear;
                var inMaxYear = currentYear == maxYear;

                var monthHtml = '<select class="monthselect">';
                for (var m = 0; m < 12; m++) {
                    if ((!inMinYear || m >= minDate.month()) && (!inMaxYear || m <= maxDate.month())) {
                        monthHtml += "<option value='" + m + "'" +
                        (m === currentMonth ? " selected='selected'" : "") +
                        ">" + this.locale.monthNames[m] + "</option>";
                    } else {
                        monthHtml += "<option value='" + m + "'" +
                        (m === currentMonth ? " selected='selected'" : "") +
                        " disabled='disabled'>" + this.locale.monthNames[m] + "</option>";
                    }
                }
                monthHtml += "</select>";

                var yearHtml = '<select class="yearselect">';
                for (var y = minYear; y <= maxYear; y++) {
                    yearHtml += '<option value="' + y + '"' +
                    (y === currentYear ? ' selected="selected"' : '') +
                    '>' + y + '</option>';
                }
                yearHtml += '</select>';

                dateHtml = monthHtml + yearHtml;
            }

            html += '<th colspan="5" class="month">' + dateHtml + '</th>';
            if ((!maxDate || maxDate.isAfter(calendar.lastDay)) && (!this.linkedCalendars || side == 'right' || this.singleDatePicker)) {
                html += '<th class="next available"><i class="fa fa-chevron-right glyphicon glyphicon-chevron-right"></i></th>';
            } else {
                html += '<th></th>';
            }

            html += '</tr>';
            html += '<tr>';

            // add week number label
            if (this.showWeekNumbers)
                html += '<th class="week">' + this.locale.weekLabel + '</th>';

            $.each(this.locale.daysOfWeek, function(index, dayOfWeek) {
                html += '<th>' + dayOfWeek + '</th>';
      per\aeinvhelper.cpp,1626,-2147467259
AEInvHelper::RemoveFileSpec,base\appcompat\programs\inventory\aeinvhelper\aeinvhelper.cpp,1626,-2147467259
AEInvHelper::RemoveFileSpec,base\appcompat\programs\inventory\aeinvhelper\aeinvhelper.cpp,1626,-2147467259
AEInvHelper::RemoveFileSpec,base\appcompat\programs\inventory\aeinvhelper\aeinvhelper.cpp,1626,-2147467259
AEInvHelper::RemoveFileSpec,base\appcompat\programs\inventory\aeinvhelper\aeinvhelper.cpp,1626,-2147467259
AEInvHelper::RemoveFileSpec,base\appcompat\programs\inventory\aeinvhelper\aeinvhelper.cpp,1626,-2147467259
AEInvHelper::RemoveFileSpec,base\appcompat\programs\inventory\aeinvhelper\aeinvhelper.cpp,1626,-2147467259
AEInvHelper::RemoveFileSpec,base\appcompat\programs\inventory\aeinvhelper\aeinvhelper.cpp,1626,-2147467259
AEInvHelper::RemoveFileSpec,base\appcompat\programs\inventory\aeinvhelper\aeinvhelper.cpp,1626,-2147467259
AEInvHelper::RemoveFileSpec,base\appcompat\programs\inventory\aeinvhelper\aeinvhelper.cpp,1626,-2147467259
AEInvHelper::RemoveFileSpec,base\appcompat\programs\inventory\aeinvhelper\aeinvhelper.cpp,1626,-2147467259
AEInvHelper::RemoveFileSpec,base\appcompat\programs\inventory\aeinvhelper\aeinvhelper.cpp,1626,-2147467259
AEInvHelper::RemoveFileSpec,base\appcompat\programs\inventory\aeinvhelper\aeinvhelper.cpp,1626,-2147467259
AEInvHelper::RemoveFileSpec,base\appcompat\programs\inventory\aeinvhelper\aeinvhelper.cpp,1626,-2147467259
AEInvHelper::RemoveFileSpec,base\appcompat\programs\inventory\aeinvhelper\aeinvhelper.cpp,1626,-2147467259
AEInvHelper::RemoveFileSpec,base\appcompat\programs\inventory\aeinvhelper\aeinvhelper.cpp,1626,-2147467259
AEInvHelper::RemoveFileSpec,base\appcompat\programs\inventory\aeinvhelper\aeinvhelper.cpp,1626,-2147467259
AEInvHelper::RemoveFileSpec,base\appcompat\programs\inventory\aeinvhelper\aeinvhelper.cpp,1626,-2147467259
AEInvHelper::RemoveFileSpec,base\appcompat\programs\inventory\aeinvhelper\aeinvhelper.cpp,1626,-2147467259
AEInvHelper::RemoveFileSpec,base\appcompat\programs\inventory\aeinvhelper\aeinvhelper.cpp,1626,-2147467259
AEInvHelper::RemoveFileSpec,base\appcompat\programs\inventory\aeinvhelper\aeinvhelper.cpp,1626,-2147467259
AEInvHelper::RemoveFileSpec,base\appcompat\programs\inventory\aeinvhelper\aeinvhelper.cpp,1626,-2147467259
AEInvHelper::RemoveFileSpec,base\appcompat\programs\inventory\aeinvhelper\aeinvhelper.cpp,1626,-2147467259
AEInvHelper::RemoveFileSpec,base\appcompat\programs\inventory\aeinvhelper\aeinvhelper.cpp,1626,-2147467259
AEInvHelper::RemoveFileSpec,base\appcompat\programs\inventory\aeinvhelper\aeinvhelper.cpp,1626,-2147467259
AEInvHelper::RemoveFileSpec,base\appcompat\programs\inventory\aeinvhelper\aeinvhelper.cpp,1626,-2147467259
AEInvHelper::RemoveFileSpec,base\appcompat\programs\inventory\aeinvhelper\aeinvhelper.cpp,1626,-2147467259
AEInvHelper::RemoveFileSpec,base\appcompat\programs\inventory\aeinvhelper\aeinvhelper.cpp,1626,-2147467259
AEInvHelper::RemoveFileSpec,base\appcompat\programs\inventory\aeinvhelper\aeinvhelper.cpp,1626,-2147467259
AEInvHelper::RemoveFileSpec,base\appcompat\programs\inventory\aeinvhelper\aeinvhelper.cpp,1626,-2147467259
AEInvHelper::RemoveFileSpec,base\appcompat\programs\inventory\aeinvhelper\aeinvhelper.cpp,1626,-2147467259
AEInvHelper::RemoveFileSpec,base\appcompat\programs\inventory\aeinvhelper\aeinvhelper.cpp,1626,-2147467259
AEInvHelper::RemoveFileSpec,base\appcompat\programs\inventory\aeinvhelper\aeinvhelper.cpp,1626,-2147467259
AEInvHelper::RemoveFileSpec,base\appcompat\programs\inventory\aeinvhelper\aeinvhelper.cpp,1626,-2147467259
AEInvHelper::RemoveFileSpec,base\appcompat\programs\inventory\aeinvhelper\aeinvhelper.cpp,1626,-2147467259
AEInvHelper::RemoveFileSpec,base\appcompat\programs\inventory\aeinvhelper\aeinvhelper.cpp,1626,-2147467259
AEInvHelper::RemoveFileSpec,base\appcompat\programs\inventory\aeinvhelper\aeinvhelper.cpp,1626,-2147467259
AEInvHelper::RemoveFileSpec,base\appcompat\programs\inventory\aeinvhelper\aeinvhelper.cpp,1626,-2147467259
AEInvHelper::RemoveFileSpec,base\appcompat\programs\inventory\fo FnhllAKWRHGAlo+ESXykKAAAAAAAAAAAwAAAAAAAAEaphjojH6pBabDSgSnsfLHeAAQAAgAAAAAAAAAAAAAAAAAAAAAB4vFIJp5wRkeyPxAQ9RJGKPqbqVvKO0mKuIl8ec8o/uhmCjImkVxP+7sgiYWmMt8FvcOXmlQiTNWFiWlrbpbqgwAAAAAAAASaMIIEljCCA36gAwIBAgIIPyn7nUraJZEwDQYJKoZIhvcNAQELBQAwSTELMAkGA1UEBhMCVVMxEzARBgNVBAoTCkdvb2dsZSBJbmMxJTAjBgNVBAMTHEdvb2dsZSBJbnRlcm5ldCBBdXRob3JpdHkgRzIwHhcNMTYwNzI4MTE0MDAwWhcNMTYxMDIwMTE0MDAwWjBzMQswCQYDVQQGEwJVUzETMBEGA1UECAwKQ2FsaWZvcm5pYTEWMBQGA1UEBwwNTW91bnRhaW4gVmlldzETMBEGA1UECgwKR29vZ2xlIEluYzEiMCAGA1UEAwwZdHBjLmdvb2dsZXN5bmRpY2F0aW9uLmNvbTCCASIwDQYJKoZIhvcNAQEBBQADggEPADCCAQoCggEBAIQ4ndiLmI/5KZ7Y8ThkFsE48VQCa1NA2kRnRvseM/ieAZlh0SKIHRIz5N5BFy4bchu0CBqe6FpCLM5tZODIaYgsFzYwWLY0vW2dU7rCfKpKSLSBwQRgqLnThsNB1QAVcVNl5RFreP/n+2DADzMwujk+kYO0LNF0AdLJxmMQcTBW0MUiDVa5OqC6Cs0oyjBMA+kxFauPOznYKmHI8ndwPwBb/gbFy0CMWvKHWOdBw5bwb+GKV9eDCOB6Fytyqo6ofHlwUvqFUXorlncV0r3+qH36IJz1v+2/IoQfUE1OzYPgRS8SSZ7svUnDnQf9DgKzUf4juEmttBiYnbM5BxypHMMCAwEAAaOCAVYwggFSMB0GA1UdJQQWMBQGCCsGAQUFBwMBBggrBgEFBQcDAjAkBgNVHREEHTAbghl0cGMuZ29vZ2xlc3luZGljYXRpb24uY29tMGgGCCsGAQUFBwEBBFwwWjArBggrBgEFBQcwAoYfaHR0cDovL3BraS5nb29nbGUuY29tL0dJQUcyLmNydDArBggrBgEFBQcwAYYfaHR0cDovL2NsaWVudHMxLmdvb2dsZS5jb20vb2NzcDAdBgNVHQ4EFgQU0ex9COPdaHAOhxa1V7mBm6tG/GMwDAYDVR0TAQH/BAIwADAfBgNVHSMEGDAWgBRK3QYWG7z2aLV29YG2u2IaulqBLzAhBgNVHSAEGjAYMAwGCisGAQQB1nkCBQEwCAYGZ4EMAQICMDAGA1UdHwQpMCcwJaAjoCGGH2h0dHA6Ly9wa2kuZ29vZ2xlLmNvbS9HSUFHMi5jcmwwDQYJKoZIhvcNAQELBQADggEBAEMpLDVJJEYNo6eNeWaECT0rysQCOkVxGR87fhNM29QLT2LiLNeCFwK4/sGDbp5Ox76nOh0o3qGML9kdwOtImOy2O3JIjtqJl/nwxaRx7TP12CztlawU7Xjx37ekLd6YOvJKgouhnXdOhNtEMo7+kjAIrTB4qss7glhirEvnjZN0Fnr11sH60q5qChodEnRQJhhQtcxEARR6sD+C9BXZYk7E0doTONGilhUms00Eab/t/1Tcxvy5ne2JQ6Mpe46L9Ywx8LTX6+tmeSDV/L3QSiTAQnlqIn1p04t3Avrofshcr+S4DwAbw2CSZVlVO6esKrmUiJH/WM+Plligl/qI/CvALwADAAAAAAEBAAA= request-method GET response-head HTTP/2.0 200 OK
Content-Type: image/png
Access-Control-Allow-Origin: *
Date: Tue, 02 Aug 2016 17:31:00 GMT
Expires: Wed, 02 Aug 2017 17:31:00 GMT
Cache-Control: public, max-age=31536000
Last-Modified: Tue, 19 Jul 2016 12:55:04 GMT
x-content-type-options: nosniff
Server: sffe
Content-Length: 3914
X-XSS-Protection: 1; mode=block
Alternate-Protocol: 443:quic
Alt-Svc: quic=":443"; ma=2592000; v="36,35,34,33,32,31,30"
X-Firefox-Spdy: h2
   J                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    /**
 * Swahili translation for bootstrap-datepicker
 * Edwin Mugendi <https://github.com/edwinmugendi>
 * Source: http://scriptsource.org/cms/scripts/page.php?item_id=entry_detail&uid=xnfaqyzcku
 */
;
(function ($) {
    $.fn.datepicker.dates['sw'] = {
        days: ["Jumapili", "Jumatatu", "Jumanne", "Jumatano", "Alhamisi", "Ijumaa", "Jumamosi", "Jumapili"],
        daysShort: ["J2", "J3", "J4", "J5", "Alh", "Ij", "J1", "J2"],
        daysMin: ["2", "3", "4", "5", "A", "I", "1", "2"],
        months: ["Januari", "Februari", "Machi", "Aprili", "Mei", "Juni", "Julai", "Agosti", "Septemba", "Oktoba", "Novemba", "Desemba"],
        monthsShort: ["Jan", "Feb", "Mac", "Apr", "Mei", "Jun", "Jul", "Ago", "Sep", "Okt", "Nov", "Des"],
        today: "Leo"
    };
}(jQuery));
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        /**
 * Thai translation for bootstrap-datepicker
 * Suchau Jiraprapot <seroz24@gmail.com>
 */
;
(function ($) {
    $.fn.datepicker.dates['th'] = {
        days: ["อาทิตย์", "จันทร์", "อังคาร", "พุธ", "พฤหัส", "ศุกร์", "เสาร์", "อาทิตย์"],
        daysShort: ["อา", "จ", "อ", "พ", "พฤ", "ศ", "ส", "อา"],
        daysMin: ["อา", "จ", "อ", "พ", "พฤ", "ศ", "ส", "อา"],
        months: ["มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม"],
        monthsShort: ["ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค."],
        today: "วันนี้"
    };
}(jQuery));
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    �S�g           W�ml<�G�       �    :https://www.google.com/ads/measurement/l?ebcid=ALh7CaRXAPbqKH2HtOUaZs8sVltkUzMPg9rOtbG6rCE-DaPiQKP3-_MdV-ESAoTiYihgwbOggOgcBSKmlFaq62CBYOocFD55fg security-info FnhllAKWRHGAlo+ESXykKAAAAAAAAAAAwAAAAAAAAEaphjojH6pBabDSgSnsfLHeAAQAAgAAAAAAAAAAAAAAAAAAAAAB4vFIJp5wRkeyPxAQ9RJGKPqbqVvKO0mKuIl8ec8o/uhmCjImkVxP+7sgiYWmMt8FvcOXmlQiTNWFiWlrbpbqgwAAAAAAAASEMIIEgDCCA2igAwIBAgIIORWTXMrZJggwDQYJKoZIhvcNAQELBQAwSTELMAkGA1UEBhMCVVMxEzARBgNVBAoTCkdvb2dsZSBJbmMxJTAjBgNVBAMTHEdvb2dsZSBJbnRlcm5ldCBBdXRob3JpdHkgRzIwHhcNMTYwNzEzMTMxODU2WhcNMTYxMDA1MTMxNjAwWjBoMQswCQYDVQQGEwJVUzETMBEGA1UECAwKQ2FsaWZvcm5pYTEWMBQGA1UEBwwNTW91bnRhaW4gVmlldzETMBEGA1UECgwKR29vZ2xlIEluYzEXMBUGA1UEAwwOd3d3Lmdvb2dsZS5jb20wggEiMA0GCSqGSIb3DQEBAQUAA4IBDwAwggEKAoIBAQDkNYMd9AGxMuv6wC7XBkzi6G7l+jqq+xoxs3zW+8jmGntRh/ggnTNLTQiwLPquusGbPo4nbVX2UQV7ATyWeg7WZQuVjgeeF7WG++xwtLUtW3noSCmePSasWx0mcJu2tiuMWqsmPbR08k14tz4jiqmRDQQfttffVS1wk0Oul6+x7hN8AyZ24gUWzb+L5ILA+8CtsZB/u9XFtf+yEr277J7vH7GyEJxYt3u2dxy/nrNlF8o2wUl+U1bvUnQVRPNiFXLK2uiQ4XkL7F3Uk19q09snjHcOixYHSYgyGYATCfV/d6hQ+RSKzd7TQp/YHtT1LgmUUefHHu04LXVnuhKUYYZnAgMBAAGjggFLMIIBRzAdBgNVHSUEFjAUBggrBgEFBQcDAQYIKwYBBQUHAwIwGQYDVR0RBBIwEIIOd3d3Lmdvb2dsZS5jb20waAYIKwYBBQUHAQEEXDBaMCsGCCsGAQUFBzAChh9odHRwOi8vcGtpLmdvb2dsZS5jb20vR0lBRzIuY3J0MCsGCCsGAQUFBzABhh9odHRwOi8vY2xpZW50czEuZ29vZ2xlLmNvbS9vY3NwMB0GA1UdDgQWBBRU6a8Q+y3AwMTsYpTXqT+xJ6n9bzAMBgNVHRMBAf8EAjAAMB8GA1UdIwQYMBaAFErdBhYbvPZotXb1gba7Yhq6WoEvMCEGA1UdIAQaMBgwDAYKKwYBBAHWeQIFATAIBgZngQwBAgIwMAYDVR0fBCkwJzAloCOgIYYfaHR0cDovL3BraS5nb29nbGUuY29tL0dJQUcyLmNybDANBgkqhkiG9w0BAQsFAAOCAQEAiw4H269LfRl/Vrm6BmTCS5ipvbE6qMbwdB++eA/NaHU29bbFzRIRIo7T6nHynAE6QTUS0fRoZ2bnoaxYZ98hSqnPlpDC3D2IImcrSywIejS0aFcT6UZT57QUm7iANDs3N7XHsXXLT0wrvXZSGPKxS2JtOS3J5lRoN4fbYLuAHEzBn7zAqtrd98EEaYGdDerMo8kAyIDHqV4OiukIYkefRqQpi1B8hPFuFw8KDGuAHdfHOoUmuRo4yxs5Br7FhoLLtdN+5UD3tbWYGZo49dl+K2ZqYOiNIHSTg78YaLM2s82G0WcL3oSzZg/ne+HZdhTu2YNFbGnoBIrgPjiPTV6WssAvAAMAAAAAAQEAAA== request-method GET response-head HTTP/2.0 204 No Content
Content-Type: text/html; charset=UTF-8
x-content-type-options: nosniff
Date: Mon, 01 Aug 2016 15:40:24 GMT
Server: jumble_frontend_server
Content-Length: 0
X-XSS-Protection: 1; mode=block
X-Frame-Options: SAMEORIGIN
Alternate-Protocol: 443:quic
Alt-Svc: quic=":443"; ma=2592000; v="36,35,34,33,32,31,30,29,28,27,26,25"
X-Firefox-Spdy: h2
 uncompressed-len 0                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                             GIF89a  �    ���!�   ,       L ;ؽ&��8      W�k�W�k�<�F�      ^    :http://video.moatads.com/pixel.gif?e=17&de=12880678&d=595549%3A1159095%3Aundefined%3Aundefined&cb=0&ed=073dc68-clean&i=TUBEMOGUL_VIDEO_INT1&t=1470065614095&zMoatDCPS=Y29tLnR1YmVtb2d1bC5hcGkudnBhaWQ6OlZwYWlkUHJveHksbnVsbA%3D%3D&bd=null&zMoatDRFQ=0&zMoatDAC=com.tubemogul.api.vpaid%3A%3AVpaidProxy&bo=608665&ee=e898ebf-clean&bq=7&o=6&m=0&q=0&ac=1&cs=0 request-method GET response-head HTTP/1.1 200 OK
Server: nginx
Date: Mon, 01 Aug 2016 15:33:33 GMT
Content-Type: image/gif
Content-Length: 43
Last-Modified: Mon, 28 Sep 1970 06:00:00 GMT
Expires: Thu, 01 Jan 1970 00:00:01 GMT
Cache-Control: no-cache
Pragma: no-cache
    +                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                       2016-08-02T09:27:30.822-05:00| vmx| I125: Log for VMware Player pid=9884 version=12.1.1 build=build-3770994 option=Release
2016-08-02T09:27:30.822-05:00| vmx| I125: The process is 64-bit.
2016-08-02T09:27:30.822-05:00| vmx| I125: Host codepage=windows-1252 encoding=windows-1252
2016-08-02T09:27:30.822-05:00| vmx| I125: Host is Windows 8.1, 64-bit  (Build 9600)
2016-08-02T09:27:30.805-05:00| vmx| I125: VTHREAD initialize main thread 0 "vmx" host id 8220
2016-08-02T09:27:30.807-05:00| vmx| I125: LOCALE windows-1252 -> NULL User=409 System=409
2016-08-02T09:27:30.807-05:00| vmx| I125: Msg_SetLocaleEx: HostLocale=windows-1252 UserLocale=NULL
2016-08-02T09:27:30.808-05:00| vmx| I125: FILE: FileCreateDirectoryRetry: Non-retriable error encountered (C:\ProgramData\VMware): Cannot create a file when that file already exists (183)
2016-08-02T09:27:30.808-05:00| vmx| I125: FILE: FileCreateDirectoryRetry: Non-retriable error encountered (C:\ProgramData\VMware\VMware Workstation): Cannot create a file when that file already exists (183)
2016-08-02T09:27:30.809-05:00| vmx| I125: FILE: FileCreateDirectoryRetry: Non-retriable error encountered (C:\ProgramData\VMware): Cannot create a file when that file already exists (183)
2016-08-02T09:27:30.809-05:00| vmx| I125: FILE: FileCreateDirectoryRetry: Non-retriable error encountered (C:\ProgramData\VMware\VMware Workstation): Cannot create a file when that file already exists (183)
2016-08-02T09:27:30.809-05:00| vmx| I125: FILE: FileCreateDirectoryRetry: Non-retriable error encountered (C:\ProgramData\VMware): Cannot create a file when that file already exists (183)
2016-08-02T09:27:30.809-05:00| vmx| I125: FILE: FileCreateDirectoryRetry: Non-retriable error encountered (C:\ProgramData\VMware\VMware Workstation): Cannot create a file when that file already exists (183)
2016-08-02T09:27:30.810-05:00| vmx| I125: DictionaryLoad: Cannot open file "C:\Users\Alex Lappen\AppData\Roaming\VMware\config.ini": The system cannot find the file specified.
2016-08-02T09:27:30.810-05:00| vmx| I125: Msg_Reset:
2016-08-02T09:27:30.810-05:00| vmx| I125: [msg.dictionary.load.openFailed] Cannot open file "C:\Users\Alex Lappen\AppData\Roaming\VMware\config.ini": The system cannot find the file specified.
2016-08-02T09:27:30.810-05:00| vmx| I125: ----------------------------------------
2016-08-02T09:27:30.810-05:00| vmx| I125: ConfigDB: Failed to load C:\Users\Alex Lappen\AppData\Roaming\VMware\config.ini
2016-08-02T09:27:30.810-05:00| vmx| I125: OBJLIB-LIB: Objlib initialized.
2016-08-02T09:27:30.811-05:00| vmx| I125: FILE: FileCreateDirectoryRetry: Non-retriable error encountered (C:\ProgramData\VMware): Cannot create a file when that file already exists (183)
2016-08-02T09:27:30.811-05:00| vmx| I125: FILE: FileCreateDirectoryRetry: Non-retriable error encountered (C:\ProgramData\VMware\VMware Player): Cannot create a file when that file already exists (183)
2016-08-02T09:27:30.811-05:00| vmx| I125: DictionaryLoad: Cannot open file "C:\ProgramData\VMware\VMware Player\config.ini": The system cannot find the file specified.
2016-08-02T09:27:30.811-05:00| vmx| I125: PREF Optional preferences file not found at C:\ProgramData\VMware\VMware Player\config.ini. Using default values.
2016-08-02T09:27:30.811-05:00| vmx| I125: FILE: FileCreateDirectoryRetry: Non-retriable error encountered (C:\ProgramData\VMware): Cannot create a file when that file already exists (183)
2016-08-02T09:27:30.811-05:00| vmx| I125: FILE: FileCreateDirectoryRetry: Non-retriable error encountered (C:\ProgramData\VMware\VMware Player): Cannot create a file when that file already exists (183)
2016-08-02T09:27:30.811-05:00| vmx| I125: DictionaryLoad: Cannot open file "C:\ProgramData\VMware\VMware Player\settings.ini": The system cannot find the file specified.
2016-08-02T09:27:30.811-05:00| vmx| I125: PREF Optional preferences file not found at C:\ProgramData\VMware\VMware Player\settings.ini. Using default values.
2016-08-02T09:27:30.811-05:00| vmx| I125: FILE: FileCreateDirectoryRetry: Non-retriable error encountered�PNG

   IHDR   <   <   ��N%    IDATx�͚w�����=9����]�B	$�,�@�1�ؘd8p��8`�����>��6"�$����U@qW���ivggv'O��t���$v�[u��{�����~������o�y~��͋/�����������r�K/����9Ǘx���.�VT�t�6M���4�(e� ���0�gF?z����w��(������W~�ʦ��Z��d{
����&
+��q�2�3i� �@ב�?TT���+��FNH���\j��
1Ͳ-�W���:63��dL� ����Xpޅ��k{%�'/��.��џ�M؜I_{}��M����X��??xW�ٜ,���/���@ �t*<������b�44�E���4-iZ6�ֵ8ʪ�PJC�>�F����`����^c��+W��dOo[]���ɡ[^x�>�?\]�rOɻ�U+"�3<vt�fOd�<���华���%A%�m}���=;���|��pUM3�B\���e-t[K��n�i�'Eb�4�&I�K��¥WV�ٸ��=I���H�p��|�����ծ�j}y��onYItij����>q$�@�.R6�;�sbA7�=�^x���2����"�������\\��l&V_�Ґ	G�4�lb@�u�e�N�i��l�0V���&��� ��iW������k.w�s��O]u��h��=Ʀ�.s��͠,����T)�w.]u�ihC2�Rz<*���*;gc��"�k[�Á���E?���7�J��~�?�N�����~��
QRw��عY8El���g^��j�����I���q��y@����5��wU��=G�pVL��:G��}� ��44_�Q���9]w�7�������M�ʅ��H6%�yfj�,	��&�v(��M�躶a�-%Q�(�!k�o�>Ў���H��ȟ�TZ��-M��� @}	��������_V�s�I���M���Xm�H�2`U�@�J�� i���|���e��x�ӻl�᩶�,��ZB�������pUU���4I���́���y4J�ϷG�ina�B������x����ʹMׄy�������U�6�v��y[�
�چ���؀���s��|�0�*�8����Jm(�0�UX��isW2�t�N�Zz�7���R�O�<�S��:Ա�����NLMSP��?j�����Ѐ��V����=�J�2<ٱ悧+ϝ�9Od�@Q 4�������s�����`�T�BĔd�?�t�k���/�s2_�0�j	U,TW03�'eI��ڋVJ�,���rIo�>��tNOuM?\WUˎ�>���Sq�l,�OD�����d�2h�\��d����\4�s�C7a'P4A(zﾾу]le5c�^���v���]�-��C�1ڳ�����_��f��b&Ǖ�.�v����Ja��#'��K��O�kl��XŠ^Cc��ѝ3�$eBc��0��La&5��5X�۽�iq��T$T��2��֫t�UU��Y�4@R�L������lhg�fA���o�G-L�r��O�����׭ݱ% (�D���++\n��{I1ԑc��~��b9E��k��$�<�{�b�I�����<( ���2m3��� g��⶟�䱶C�rǇt]�aʙ"B��)(������tַѪi��Ola���>s��2�h�<mq��v��p��>��ˣ3�Ĕ��e_��T3�eB�ǿ�XZSD!>^��r:�ɺ��D��(	��`8C�M�QL�!9���XI])9m���Rt��滄��>	N�pK�p��J�_�7;�o��ӆ���ı{潙6���,AP�	���K�]�!6�?=�ꆀ���6�*�g����*��d�'�@X�u �|޷����^LO�\� Ú�
���3�rXA�
�����:S-�]��	ʴ-�h��X���ƠI  ��J[���0��m�i�i�R�|����.*��Wo��EM��&A�8MY9w��I[��h<�ФI����J������ڲ���8N6��c��L଱����4 �EL V+eeI���V��yiw>��<�4�Bj���Ay�TԜN�\Gg�Ͽy|�Y�@%�t{+��v���