/*
 Highcharts JS v4.0.1-modified ()
 
 (c) 2009-2014 Torstein Honsi
 
 License: www.highcharts.com/license
 */
(function () {
    function r(a, b) {
        var c;
        a || (a = {});
        for (c in b)
            a[c] = b[c];
        return a
    }
    function y() {
        var a, b = arguments, c, d = {}, e = function (a, b) {
            var c, d;
            typeof a !== "object" && (a = {});
            for (d in b)
                b.hasOwnProperty(d) && (c = b[d], a[d] = c && typeof c === "object" && Object.prototype.toString.call(c) !== "[object Array]" && d !== "renderTo" && typeof c.nodeType !== "number" ? e(a[d] || {}, c) : b[d]);
            return a
        };
        b[0] === !0 && (d = b[1], b = Array.prototype.slice.call(b, 2));
        c = b.length;
        for (a = 0; a < c; a++)
            d = e(d, b[a]);
        return d
    }
    function z(a, b) {
        return parseInt(a, b ||
                10)
    }
    function Ga(a) {
        return typeof a === "string"
    }
    function da(a) {
        return a && typeof a === "object"
    }
    function Ma(a) {
        return Object.prototype.toString.call(a) === "[object Array]"
    }
    function ia(a) {
        return typeof a === "number"
    }
    function za(a) {
        return V.log(a) / V.LN10
    }
    function ja(a) {
        return V.pow(10, a)
    }
    function ka(a, b) {
        for (var c = a.length; c--; )
            if (a[c] === b) {
                a.splice(c, 1);
                break
            }
    }
    function s(a) {
        return a !== t && a !== null
    }
    function C(a, b, c) {
        var d, e;
        if (Ga(b))
            s(c) ? a.setAttribute(b, c) : a && a.getAttribute && (e = a.getAttribute(b));
        else if (s(b) &&
                da(b))
            for (d in b)
                a.setAttribute(d, b[d]);
        return e
    }
    function ra(a) {
        return Ma(a) ? a : [a]
    }
    function p() {
        var a = arguments, b, c, d = a.length;
        for (b = 0; b < d; b++)
            if (c = a[b], c !== t && c !== null)
                return c
    }
    function F(a, b) {
        if (Aa && !ba && b && b.opacity !== t)
            b.filter = "alpha(opacity=" + b.opacity * 100 + ")";
        r(a.style, b)
    }
    function Z(a, b, c, d, e) {
        a = v.createElement(a);
        b && r(a, b);
        e && F(a, {padding: 0, border: S, margin: 0});
        c && F(a, c);
        d && d.appendChild(a);
        return a
    }
    function la(a, b) {
        var c = function () {
            return t
        };
        c.prototype = new a;
        r(c.prototype, b);
        return c
    }
    function Ha(a,
            b, c, d) {
        var e = Q.lang, a = +a || 0, f = b === -1 ? (a.toString().split(".")[1] || "").length : isNaN(b = N(b)) ? 2 : b, b = c === void 0 ? e.decimalPoint : c, d = d === void 0 ? e.thousandsSep : d, e = a < 0 ? "-" : "", c = String(z(a = N(a).toFixed(f))), g = c.length > 3 ? c.length % 3 : 0;
        return e + (g ? c.substr(0, g) + d : "") + c.substr(g).replace(/(\d{3})(?=\d)/g, "$1" + d) + (f ? b + N(a - c).toFixed(f).slice(2) : "")
    }
    function Ia(a, b) {
        return Array((b || 2) + 1 - String(a).length).join(0) + a
    }
    function Na(a, b, c) {
        var d = a[b];
        a[b] = function () {
            var a = Array.prototype.slice.call(arguments);
            a.unshift(d);
            return c.apply(this, a)
        }
    }
    function Ja(a, b) {
        for (var c = "{", d = !1, e, f, g, h, i, j = []; (c = a.indexOf(c)) !== -1; ) {
            e = a.slice(0, c);
            if (d) {
                f = e.split(":");
                g = f.shift().split(".");
                i = g.length;
                e = b;
                for (h = 0; h < i; h++)
                    e = e[g[h]];
                if (f.length)
                    f = f.join(":"), g = /\.([0-9])/, h = Q.lang, i = void 0, /f$/.test(f) ? (i = (i = f.match(g)) ? i[1] : -1, e !== null && (e = Ha(e, i, h.decimalPoint, f.indexOf(",") > -1 ? h.thousandsSep : ""))) : e = db(f, e)
            }
            j.push(e);
            a = a.slice(c + 1);
            c = (d = !d) ? "}" : "{"
        }
        j.push(a);
        return j.join("")
    }
    function mb(a) {
        return V.pow(10, U(V.log(a) / V.LN10))
    }
    function nb(a, b, c, d) {
        var e, c = p(c, 1);
        e = a / c;
        b || (b = [1, 2, 2.5, 5, 10], d && d.allowDecimals === !1 && (c === 1 ? b = [1, 2, 5, 10] : c <= 0.1 && (b = [1 / c])));
        for (d = 0; d < b.length; d++)
            if (a = b[d], e <= (b[d] + (b[d + 1] || b[d])) / 2)
                break;
        a *= c;
        return a
    }
    function ob(a, b) {
        var c = a.length, d, e;
        for (e = 0; e < c; e++)
            a[e].ss_i = e;
        a.sort(function (a, c) {
            d = b(a, c);
            return d === 0 ? a.ss_i - c.ss_i : d
        });
        for (e = 0; e < c; e++)
            delete a[e].ss_i
    }
    function Oa(a) {
        for (var b = a.length, c = a[0]; b--; )
            a[b] < c && (c = a[b]);
        return c
    }
    function Ba(a) {
        for (var b = a.length, c = a[0]; b--; )
            a[b] > c && (c = a[b]);
        return c
    }
    function Pa(a, b) {
        for (var c in a)
            a[c] && a[c] !== b && a[c].destroy && a[c].destroy(), delete a[c]
    }
    function Qa(a) {
        eb || (eb = Z(Ka));
        a && eb.appendChild(a);
        eb.innerHTML = ""
    }
    function ea(a) {
        return parseFloat(a.toPrecision(14))
    }
    function Ra(a, b) {
        va = p(a, b.animation)
    }
    function Cb() {
        var a = Q.global.useUTC, b = a ? "getUTC" : "get", c = a ? "setUTC" : "set";
        Sa = (a && Q.global.timezoneOffset || 0) * 6E4;
        fb = a ? Date.UTC : function (a, b, c, g, h, i) {
            return(new Date(a, b, p(c, 1), p(g, 0), p(h, 0), p(i, 0))).getTime()
        };
        pb = b + "Minutes";
        qb = b + "Hours";
        rb = b + "Day";
        Ya = b + "Date";
        gb = b + "Month";
        hb = b + "FullYear";
        Db = c + "Minutes";
        Eb = c + "Hours";
        sb = c + "Date";
        Fb = c + "Month";
        Gb = c + "FullYear"
    }
    function O() {
    }
    function Ta(a, b, c, d) {
        this.axis = a;
        this.pos = b;
        this.type = c || "";
        this.isNew = !0;
        !c && !d && this.addLabel()
    }
    function ma() {
        this.init.apply(this, arguments)
    }
    function Za() {
        this.init.apply(this, arguments)
    }
    function Hb(a, b, c, d, e) {
        var f = a.chart.inverted;
        this.axis = a;
        this.isNegative = c;
        this.options = b;
        this.x = d;
        this.total = null;
        this.points = {};
        this.stack = e;
        this.alignOptions = {align: b.align || (f ? c ? "left" :
                    "right" : "center"), verticalAlign: b.verticalAlign || (f ? "middle" : c ? "bottom" : "top"), y: p(b.y, f ? 4 : c ? 14 : -6), x: p(b.x, f ? c ? -6 : 6 : 0)};
        this.textAlign = b.textAlign || (f ? c ? "right" : "left" : "center")
    }
    var t, v = document, E = window, V = Math, w = V.round, U = V.floor, La = V.ceil, u = V.max, G = V.min, N = V.abs, $ = V.cos, fa = V.sin, na = V.PI, Ca = na * 2 / 360, wa = navigator.userAgent, Ib = E.opera, Aa = /msie/i.test(wa) && !Ib, ib = v.documentMode === 8, tb = /AppleWebKit/.test(wa), Ua = /Firefox/.test(wa), Jb = /(Mobile|Android|Windows Phone)/.test(wa), xa = "http://www.w3.org/2000/svg",
            ba = !!v.createElementNS && !!v.createElementNS(xa, "svg").createSVGRect, Ob = Ua && parseInt(wa.split("Firefox/")[1], 10) < 4, ga = !ba && !Aa && !!v.createElement("canvas").getContext, $a, ab, Kb = {}, ub = 0, eb, Q, db, va, vb, A, oa, sa = function () {
        return t
    }, W = [], bb = 0, Ka = "div", S = "none", Pb = /^[0-9]+$/, Qb = "stroke-width", fb, Sa, pb, qb, rb, Ya, gb, hb, Db, Eb, sb, Fb, Gb, D = {}, R;
    E.Highcharts ? oa(16, !0) : R = E.Highcharts = {};
    db = function (a, b, c) {
        if (!s(b) || isNaN(b))
            return"Invalid date";
        var a = p(a, "%Y-%m-%d %H:%M:%S"), d = new Date(b - Sa), e, f = d[qb](), g = d[rb](),
                h = d[Ya](), i = d[gb](), j = d[hb](), k = Q.lang, l = k.weekdays, d = r({a: l[g].substr(0, 3), A: l[g], d: Ia(h), e: h, b: k.shortMonths[i], B: k.months[i], m: Ia(i + 1), y: j.toString().substr(2, 2), Y: j, H: Ia(f), I: Ia(f % 12 || 12), l: f % 12 || 12, M: Ia(d[pb]()), p: f < 12 ? "AM" : "PM", P: f < 12 ? "am" : "pm", S: Ia(d.getSeconds()), L: Ia(w(b % 1E3), 3)}, R.dateFormats);
        for (e in d)
            for (; a.indexOf("%" + e) !== - 1; )
                a = a.replace("%" + e, typeof d[e] === "function" ? d[e](b) : d[e]);
        return c ? a.substr(0, 1).toUpperCase() + a.substr(1) : a
    };
    oa = function (a, b) {
        var c = "Highcharts error #" + a + ": www.highcharts.com/errors/" +
                a;
        if (b)
            throw c;
        E.console && console.log(c)
    };
    A = {millisecond: 1, second: 1E3, minute: 6E4, hour: 36E5, day: 864E5, week: 6048E5, month: 26784E5, year: 31556952E3};
    vb = {init: function (a, b, c) {
            var b = b || "", d = a.shift, e = b.indexOf("C") > -1, f = e ? 7 : 3, g, b = b.split(" "), c = [].concat(c), h, i, j = function (a) {
                for (g = a.length; g--; )
                    a[g] === "M" && a.splice(g + 1, 0, a[g + 1], a[g + 2], a[g + 1], a[g + 2])
            };
            e && (j(b), j(c));
            a.isArea && (h = b.splice(b.length - 6, 6), i = c.splice(c.length - 6, 6));
            if (d <= c.length / f && b.length === c.length)
                for (; d--; )
                    c = [].concat(c).splice(0, f).concat(c);
            a.shift = 0;
            if (b.length)
                for (a = c.length; b.length < a; )
                    d = [].concat(b).splice(b.length - f, f), e && (d[f - 6] = d[f - 2], d[f - 5] = d[f - 1]), b = b.concat(d);
            h && (b = b.concat(h), c = c.concat(i));
            return[b, c]
        }, step: function (a, b, c, d) {
            var e = [], f = a.length;
            if (c === 1)
                e = d;
            else if (f === b.length && c < 1)
                for (; f--; )
                    d = parseFloat(a[f]), e[f] = isNaN(d) ? a[f] : c * parseFloat(b[f] - d) + d;
            else
                e = b;
            return e
        }};
    (function (a) {
        E.HighchartsAdapter = E.HighchartsAdapter || a && {init: function (b) {
                var c = a.fx, d = c.step, e, f = a.Tween, g = f && f.propHooks;
                e = a.cssHooks.opacity;
                a.extend(a.easing,
                        {easeOutQuad: function (a, b, c, d, e) {
                                return-d * (b /= e) * (b - 2) + c
                            }});
                a.each(["cur", "_default", "width", "height", "opacity"], function (a, b) {
                    var e = d, k;
                    b === "cur" ? e = c.prototype : b === "_default" && f && (e = g[b], b = "set");
                    (k = e[b]) && (e[b] = function (c) {
                        var d, c = a ? c : this;
                        if (c.prop !== "align")
                            return d = c.elem, d.attr ? d.attr(c.prop, b === "cur" ? t : c.now) : k.apply(this, arguments)
                    })
                });
                Na(e, "get", function (a, b, c) {
                    return b.attr ? b.opacity || 0 : a.call(this, b, c)
                });
                e = function (a) {
                    var c = a.elem, d;
                    if (!a.started)
                        d = b.init(c, c.d, c.toD), a.start = d[0], a.end =
                                d[1], a.started = !0;
                    c.attr("d", b.step(a.start, a.end, a.pos, c.toD))
                };
                f ? g.d = {set: e} : d.d = e;
                this.each = Array.prototype.forEach ? function (a, b) {
                    return Array.prototype.forEach.call(a, b)
                } : function (a, b) {
                    var c, d = a.length;
                    for (c = 0; c < d; c++)
                        if (b.call(a[c], a[c], c, a) === !1)
                            return c
                };
                a.fn.highcharts = function () {
                    var a = "Chart", b = arguments, c, d;
                    if (this[0]) {
                        Ga(b[0]) && (a = b[0], b = Array.prototype.slice.call(b, 1));
                        c = b[0];
                        if (c !== t)
                            c.chart = c.chart || {}, c.chart.renderTo = this[0], new R[a](c, b[1]), d = this;
                        c === t && (d = W[C(this[0], "data-highcharts-chart")])
                    }
                    return d
                }
            },
            getScript: a.getScript, inArray: a.inArray, adapterRun: function (b, c) {
                return a(b)[c]()
            }, grep: a.grep, map: function (a, c) {
                for (var d = [], e = 0, f = a.length; e < f; e++)
                    d[e] = c.call(a[e], a[e], e, a);
                return d
            }, offset: function (b) {
                return a(b).offset()
            }, addEvent: function (b, c, d) {
                a(b).bind(c, d)
            }, removeEvent: function (b, c, d) {
                var e = v.removeEventListener ? "removeEventListener" : "detachEvent";
                v[e] && b && !b[e] && (b[e] = function () {
                });
                a(b).unbind(c, d)
            }, fireEvent: function (b, c, d, e) {
                var f = a.Event(c), g = "detached" + c, h;
                !Aa && d && (delete d.layerX,
                        delete d.layerY, delete d.returnValue);
                r(f, d);
                b[c] && (b[g] = b[c], b[c] = null);
                a.each(["preventDefault", "stopPropagation"], function (a, b) {
                    var c = f[b];
                    f[b] = function () {
                        try {
                            c.call(f)
                        } catch (a) {
                            b === "preventDefault" && (h = !0)
                        }
                    }
                });
                a(b).trigger(f);
                b[g] && (b[c] = b[g], b[g] = null);
                e && !f.isDefaultPrevented() && !h && e(f)
            }, washMouseEvent: function (a) {
                var c = a.originalEvent || a;
                if (c.pageX === t)
                    c.pageX = a.pageX, c.pageY = a.pageY;
                return c
            }, animate: function (b, c, d) {
                var e = a(b);
                if (!b.style)
                    b.style = {};
                if (c.d)
                    b.toD = c.d, c.d = 1;
                e.stop();
                c.opacity !==
                        t && b.attr && (c.opacity += "px");
                e.animate(c, d)
            }, stop: function (b) {
                a(b).stop()
            }}
    })(E.jQuery);
    var T = E.HighchartsAdapter, H = T || {};
    T && T.init.call(T, vb);
    var jb = H.adapterRun, Rb = H.getScript, Da = H.inArray, q = H.each, wb = H.grep, Sb = H.offset, Va = H.map, K = H.addEvent, X = H.removeEvent, J = H.fireEvent, Tb = H.washMouseEvent, kb = H.animate, cb = H.stop, H = {enabled: !0, x: 0, y: 15, style: {color: "#606060", cursor: "default", fontSize: "11px"}};
    Q = {colors: "#7cb5ec,#434348,#90ed7d,#f7a35c,#8085e9,#f15c80,#e4d354,#8085e8,#8d4653,#91e8e1".split(","),
        symbols: ["circle", "diamond", "square", "triangle", "triangle-down"], lang: {loading: "Loading...", months: "January,February,March,April,May,June,July,August,September,October,November,December".split(","), shortMonths: "Jan,Feb,Mar,Apr,May,Jun,Jul,Aug,Sep,Oct,Nov,Dec".split(","), weekdays: "Sunday,Monday,Tuesday,Wednesday,Thursday,Friday,Saturday".split(","), decimalPoint: ".", numericSymbols: "k,M,G,T,P,E".split(","), resetZoom: "Reset zoom", resetZoomTitle: "Reset zoom level 1:1", thousandsSep: ","}, global: {useUTC: !0,
            canvasToolsURL: "http://code.highcharts.com/4.0.1-modified/modules/canvas-tools.js", VMLRadialGradientURL: "http://code.highcharts.com/4.0.1-modified/gfx/vml-radial-gradient.png"}, chart: {borderColor: "#4572A7", borderRadius: 0, defaultSeriesType: "line", ignoreHiddenSeries: !0, spacing: [10, 10, 15, 10], backgroundColor: "#FFFFFF", plotBorderColor: "#C0C0C0", resetZoomButton: {theme: {zIndex: 20}, position: {align: "right", x: -10, y: 10}}}, title: {text: "Chart title", align: "center", margin: 15, style: {color: "#333333", fontSize: "18px"}},
        subtitle: {text: "", align: "center", style: {color: "#555555"}}, plotOptions: {line: {allowPointSelect: !1, showCheckbox: !1, animation: {duration: 1E3}, events: {}, lineWidth: 2, marker: {lineWidth: 0, radius: 4, lineColor: "#FFFFFF", states: {hover: {enabled: !0, lineWidthPlus: 1, radiusPlus: 2}, select: {fillColor: "#FFFFFF", lineColor: "#000000", lineWidth: 2}}}, point: {events: {}}, dataLabels: y(H, {align: "center", enabled: !1, formatter: function () {
                        return this.y === null ? "" : Ha(this.y, -1)
                    }, verticalAlign: "bottom", y: 0}), cropThreshold: 300, pointRange: 0,
                states: {hover: {lineWidthPlus: 1, marker: {}, halo: {size: 10, opacity: 0.25}}, select: {marker: {}}}, stickyTracking: !0, turboThreshold: 1E3}}, labels: {style: {position: "absolute", color: "#3E576F"}}, legend: {enabled: !0, align: "center", layout: "horizontal", labelFormatter: function () {
                return this.name
            }, borderColor: "#909090", borderRadius: 0, navigation: {activeColor: "#274b6d", inactiveColor: "#CCC"}, shadow: !1, itemStyle: {color: "#333333", fontSize: "12px", fontWeight: "bold"}, itemHoverStyle: {color: "#000"}, itemHiddenStyle: {color: "#CCC"},
            itemCheckboxStyle: {position: "absolute", width: "13px", height: "13px"}, symbolPadding: 5, verticalAlign: "bottom", x: 0, y: 0, title: {style: {fontWeight: "bold"}}}, loading: {labelStyle: {fontWeight: "bold", position: "relative", top: "45%"}, style: {position: "absolute", backgroundColor: "white", opacity: 0.5, textAlign: "center"}}, tooltip: {enabled: !0, animation: ba, backgroundColor: "rgba(249, 249, 249, .85)", borderWidth: 1, borderRadius: 3, dateTimeLabelFormats: {millisecond: "%A, %b %e, %H:%M:%S.%L", second: "%A, %b %e, %H:%M:%S", minute: "%A, %b %e, %H:%M",
                hour: "%A, %b %e, %H:%M", day: "%A, %b %e, %Y", week: "Week from %A, %b %e, %Y", month: "%B %Y", year: "%Y"}, headerFormat: '<span style="font-size: 10px">{point.key}</span><br/>', pointFormat: '<span style="color:{series.color}">●</span> {series.name}: <b>{point.y}</b><br/>', shadow: !0, snap: Jb ? 25 : 10, style: {color: "#333333", cursor: "default", fontSize: "12px", padding: "8px", whiteSpace: "nowrap"}}, credits: {enabled: !0, text: "", href: "http://www.highcharts.com", position: {align: "right", x: -10, verticalAlign: "bottom",
                y: -5}, style: {cursor: "pointer", color: "#909090", fontSize: "9px"}}};
    var ca = Q.plotOptions, T = ca.line;
    Cb();
    var Ub = /rgba\(\s*([0-9]{1,3})\s*,\s*([0-9]{1,3})\s*,\s*([0-9]{1,3})\s*,\s*([0-9]?(?:\.[0-9]+)?)\s*\)/, Vb = /#([a-fA-F0-9]{2})([a-fA-F0-9]{2})([a-fA-F0-9]{2})/, Wb = /rgb\(\s*([0-9]{1,3})\s*,\s*([0-9]{1,3})\s*,\s*([0-9]{1,3})\s*\)/, ya = function (a) {
        var b = [], c, d;
        (function (a) {
            a && a.stops ? d = Va(a.stops, function (a) {
                return ya(a[1])
            }) : (c = Ub.exec(a)) ? b = [z(c[1]), z(c[2]), z(c[3]), parseFloat(c[4], 10)] : (c = Vb.exec(a)) ? b =
                    [z(c[1], 16), z(c[2], 16), z(c[3], 16), 1] : (c = Wb.exec(a)) && (b = [z(c[1]), z(c[2]), z(c[3]), 1])
        })(a);
        return{get: function (c) {
                var f;
                d ? (f = y(a), f.stops = [].concat(f.stops), q(d, function (a, b) {
                    f.stops[b] = [f.stops[b][0], a.get(c)]
                })) : f = b && !isNaN(b[0]) ? c === "rgb" ? "rgb(" + b[0] + "," + b[1] + "," + b[2] + ")" : c === "a" ? b[3] : "rgba(" + b.join(",") + ")" : a;
                return f
            }, brighten: function (a) {
                if (d)
                    q(d, function (b) {
                        b.brighten(a)
                    });
                else if (ia(a) && a !== 0) {
                    var c;
                    for (c = 0; c < 3; c++)
                        b[c] += z(a * 255), b[c] < 0 && (b[c] = 0), b[c] > 255 && (b[c] = 255)
                }
                return this
            }, rgba: b, setOpacity: function (a) {
                b[3] =
                        a;
                return this
            }}
    };
    O.prototype = {opacity: 1, textProps: "fontSize,fontWeight,fontFamily,color,lineHeight,width,textDecoration,textShadow,HcTextStroke".split(","), init: function (a, b) {
            this.element = b === "span" ? Z(b) : v.createElementNS(xa, b);
            this.renderer = a
        }, animate: function (a, b, c) {
            b = p(b, va, !0);
            cb(this);
            if (b) {
                b = y(b, {});
                if (c)
                    b.complete = c;
                kb(this, a, b)
            } else
                this.attr(a), c && c();
            return this
        }, colorGradient: function (a, b, c) {
            var d = this.renderer, e, f, g, h, i, j, k, l, n, m, o = [];
            a.linearGradient ? f = "linearGradient" : a.radialGradient &&
                    (f = "radialGradient");
            if (f) {
                g = a[f];
                h = d.gradients;
                j = a.stops;
                n = c.radialReference;
                Ma(g) && (a[f] = g = {x1: g[0], y1: g[1], x2: g[2], y2: g[3], gradientUnits: "userSpaceOnUse"});
                f === "radialGradient" && n && !s(g.gradientUnits) && (g = y(g, {cx: n[0] - n[2] / 2 + g.cx * n[2], cy: n[1] - n[2] / 2 + g.cy * n[2], r: g.r * n[2], gradientUnits: "userSpaceOnUse"}));
                for (m in g)
                    m !== "id" && o.push(m, g[m]);
                for (m in j)
                    o.push(j[m]);
                o = o.join(",");
                h[o] ? a = h[o].attr("id") : (g.id = a = "highcharts-" + ub++, h[o] = i = d.createElement(f).attr(g).add(d.defs), i.stops = [], q(j, function (a) {
                    a[1].indexOf("rgba") ===
                            0 ? (e = ya(a[1]), k = e.get("rgb"), l = e.get("a")) : (k = a[1], l = 1);
                    a = d.createElement("stop").attr({offset: a[0], "stop-color": k, "stop-opacity": l}).add(i);
                    i.stops.push(a)
                }));
                c.setAttribute(b, "url(" + d.url + "#" + a + ")")
            }
        }, attr: function (a, b) {
            var c, d, e = this.element, f, g = this, h;
            typeof a === "string" && b !== t && (c = a, a = {}, a[c] = b);
            if (typeof a === "string")
                g = (this[a + "Getter"] || this._defaultGetter).call(this, a, e);
            else {
                for (c in a) {
                    d = a[c];
                    h = !1;
                    this.symbolName && /^(x|y|width|height|r|start|end|innerR|anchorX|anchorY)/.test(c) && (f || (this.symbolAttr(a),
                            f = !0), h = !0);
                    if (this.rotation && (c === "x" || c === "y"))
                        this.doTransform = !0;
                    h || (this[c + "Setter"] || this._defaultSetter).call(this, d, c, e);
                    this.shadows && /^(width|height|visibility|x|y|d|transform|cx|cy|r)$/.test(c) && this.updateShadows(c, d)
                }
                if (this.doTransform)
                    this.updateTransform(), this.doTransform = !1
            }
            return g
        }, updateShadows: function (a, b) {
            for (var c = this.shadows, d = c.length; d--; )
                c[d].setAttribute(a, a === "height" ? u(b - (c[d].cutHeight || 0), 0) : a === "d" ? this.d : b)
        }, addClass: function (a) {
            var b = this.element, c = C(b, "class") ||
                    "";
            c.indexOf(a) === -1 && C(b, "class", c + " " + a);
            return this
        }, symbolAttr: function (a) {
            var b = this;
            q("x,y,r,start,end,width,height,innerR,anchorX,anchorY".split(","), function (c) {
                b[c] = p(a[c], b[c])
            });
            b.attr({d: b.renderer.symbols[b.symbolName](b.x, b.y, b.width, b.height, b)})
        }, clip: function (a) {
            return this.attr("clip-path", a ? "url(" + this.renderer.url + "#" + a.id + ")" : S)
        }, crisp: function (a) {
            var b, c = {}, d, e = a.strokeWidth || this.strokeWidth || 0;
            d = w(e) % 2 / 2;
            a.x = U(a.x || this.x || 0) + d;
            a.y = U(a.y || this.y || 0) + d;
            a.width = U((a.width || this.width ||
                    0) - 2 * d);
            a.height = U((a.height || this.height || 0) - 2 * d);
            a.strokeWidth = e;
            for (b in a)
                this[b] !== a[b] && (this[b] = c[b] = a[b]);
            return c
        }, css: function (a) {
            var b = this.styles, c = {}, d = this.element, e, f, g = "";
            e = !b;
            if (a && a.color)
                a.fill = a.color;
            if (b)
                for (f in a)
                    a[f] !== b[f] && (c[f] = a[f], e = !0);
            if (e) {
                e = this.textWidth = a && a.width && d.nodeName.toLowerCase() === "text" && z(a.width);
                b && (a = r(b, c));
                this.styles = a;
                e && (ga || !ba && this.renderer.forExport) && delete a.width;
                if (Aa && !ba)
                    F(this.element, a);
                else {
                    b = function (a, b) {
                        return"-" + b.toLowerCase()
                    };
                    for (f in a)
                        g += f.replace(/([A-Z])/g, b) + ":" + a[f] + ";";
                    C(d, "style", g)
                }
                e && this.added && this.renderer.buildText(this)
            }
            return this
        }, on: function (a, b) {
            var c = this, d = c.element;
            ab && a === "click" ? (d.ontouchstart = function (a) {
                c.touchEventFired = Date.now();
                a.preventDefault();
                b.call(d, a)
            }, d.onclick = function (a) {
                (wa.indexOf("Android") === -1 || Date.now() - (c.touchEventFired || 0) > 1100) && b.call(d, a)
            }) : d["on" + a] = b;
            return this
        }, setRadialReference: function (a) {
            this.element.radialReference = a;
            return this
        }, translate: function (a, b) {
            return this.attr({translateX: a,
                translateY: b})
        }, invert: function () {
            this.inverted = !0;
            this.updateTransform();
            return this
        }, updateTransform: function () {
            var a = this.translateX || 0, b = this.translateY || 0, c = this.scaleX, d = this.scaleY, e = this.inverted, f = this.rotation, g = this.element;
            e && (a += this.attr("width"), b += this.attr("height"));
            a = ["translate(" + a + "," + b + ")"];
            e ? a.push("rotate(90) scale(-1,1)") : f && a.push("rotate(" + f + " " + (g.getAttribute("x") || 0) + " " + (g.getAttribute("y") || 0) + ")");
            (s(c) || s(d)) && a.push("scale(" + p(c, 1) + " " + p(d, 1) + ")");
            a.length && g.setAttribute("transform",
                    a.join(" "))
        }, toFront: function () {
            var a = this.element;
            a.parentNode.appendChild(a);
            return this
        }, align: function (a, b, c) {
            var d, e, f, g, h = {};
            e = this.renderer;
            f = e.alignedObjects;
            if (a) {
                if (this.alignOptions = a, this.alignByTranslate = b, !c || Ga(c))
                    this.alignTo = d = c || "renderer", ka(f, this), f.push(this), c = null
            } else
                a = this.alignOptions, b = this.alignByTranslate, d = this.alignTo;
            c = p(c, e[d], e);
            d = a.align;
            e = a.verticalAlign;
            f = (c.x || 0) + (a.x || 0);
            g = (c.y || 0) + (a.y || 0);
            if (d === "right" || d === "center")
                f += (c.width - (a.width || 0)) / {right: 1, center: 2}[d];
            h[b ? "translateX" : "x"] = w(f);
            if (e === "bottom" || e === "middle")
                g += (c.height - (a.height || 0)) / ({bottom: 1, middle: 2}[e] || 1);
            h[b ? "translateY" : "y"] = w(g);
            this[this.placed ? "animate" : "attr"](h);
            this.placed = !0;
            this.alignAttr = h;
            return this
        }, getBBox: function () {
            var a = this.bBox, b = this.renderer, c, d, e = this.rotation;
            c = this.element;
            var f = this.styles, g = e * Ca;
            d = this.textStr;
            var h;
            if (d === "" || Pb.test(d))
                h = "num." + d.toString().length + (f ? "|" + f.fontSize + "|" + f.fontFamily : "");
            h && (a = b.cache[h]);
            if (!a) {
                if (c.namespaceURI === xa || b.forExport) {
                    try {
                        a =
                                c.getBBox ? r({}, c.getBBox()) : {width: c.offsetWidth, height: c.offsetHeight}
                    } catch (i) {
                    }
                    if (!a || a.width < 0)
                        a = {width: 0, height: 0}
                } else
                    a = this.htmlGetBBox();
                if (b.isSVG) {
                    c = a.width;
                    d = a.height;
                    if (Aa && f && f.fontSize === "11px" && d.toPrecision(3) === "16.9")
                        a.height = d = 14;
                    if (e)
                        a.width = N(d * fa(g)) + N(c * $(g)), a.height = N(d * $(g)) + N(c * fa(g))
                }
                this.bBox = a;
                h && (b.cache[h] = a)
            }
            return a
        }, show: function (a) {
            return a && this.element.namespaceURI === xa ? (this.element.removeAttribute("visibility"), this) : this.attr({visibility: a ? "inherit" : "visible"})
        },
        hide: function () {
            return this.attr({visibility: "hidden"})
        }, fadeOut: function (a) {
            var b = this;
            b.animate({opacity: 0}, {duration: a || 150, complete: function () {
                    b.hide()
                }})
        }, add: function (a) {
            var b = this.renderer, c = a || b, d = c.element || b.box, e = this.element, f = this.zIndex, g, h;
            if (a)
                this.parentGroup = a;
            this.parentInverted = a && a.inverted;
            this.textStr !== void 0 && b.buildText(this);
            if (f)
                c.handleZ = !0, f = z(f);
            if (c.handleZ) {
                a = d.childNodes;
                for (g = 0; g < a.length; g++)
                    if (b = a[g], c = C(b, "zIndex"), b !== e && (z(c) > f || !s(f) && s(c))) {
                        d.insertBefore(e,
                                b);
                        h = !0;
                        break
                    }
            }
            h || d.appendChild(e);
            this.added = !0;
            if (this.onAdd)
                this.onAdd();
            return this
        }, safeRemoveChild: function (a) {
            var b = a.parentNode;
            b && b.removeChild(a)
        }, destroy: function () {
            var a = this, b = a.element || {}, c = a.shadows, d = a.renderer.isSVG && b.nodeName === "SPAN" && a.parentGroup, e, f;
            b.onclick = b.onmouseout = b.onmouseover = b.onmousemove = b.point = null;
            cb(a);
            if (a.clipPath)
                a.clipPath = a.clipPath.destroy();
            if (a.stops) {
                for (f = 0; f < a.stops.length; f++)
                    a.stops[f] = a.stops[f].destroy();
                a.stops = null
            }
            a.safeRemoveChild(b);
            for (c &&
                    q(c, function (b) {
                        a.safeRemoveChild(b)
                    }); d && d.div && d.div.childNodes.length === 0; )
                b = d.parentGroup, a.safeRemoveChild(d.div), delete d.div, d = b;
            a.alignTo && ka(a.renderer.alignedObjects, a);
            for (e in a)
                delete a[e];
            return null
        }, shadow: function (a, b, c) {
            var d = [], e, f, g = this.element, h, i, j, k;
            if (a) {
                i = p(a.width, 3);
                j = (a.opacity || 0.15) / i;
                k = this.parentInverted ? "(-1,-1)" : "(" + p(a.offsetX, 1) + ", " + p(a.offsetY, 1) + ")";
                for (e = 1; e <= i; e++) {
                    f = g.cloneNode(0);
                    h = i * 2 + 1 - 2 * e;
                    C(f, {isShadow: "true", stroke: a.color || "black", "stroke-opacity": j *
                                e, "stroke-width": h, transform: "translate" + k, fill: S});
                    if (c)
                        C(f, "height", u(C(f, "height") - h, 0)), f.cutHeight = h;
                    b ? b.element.appendChild(f) : g.parentNode.insertBefore(f, g);
                    d.push(f)
                }
                this.shadows = d
            }
            return this
        }, xGetter: function (a) {
            this.element.nodeName === "circle" && (a = {x: "cx", y: "cy"}[a] || a);
            return this._defaultGetter(a)
        }, _defaultGetter: function (a) {
            a = p(this[a], this.element ? this.element.getAttribute(a) : null, 0);
            /^[\-0-9\.]+$/.test(a) && (a = parseFloat(a));
            return a
        }, dSetter: function (a, b, c) {
            a && a.join && (a = a.join(" "));
            /(NaN| {2}|^$)/.test(a) && (a = "M 0 0");
            c.setAttribute(b, a);
            this[b] = a
        }, dashstyleSetter: function (a) {
            var b;
            if (a = a && a.toLowerCase()) {
                a = a.replace("shortdashdotdot", "3,1,1,1,1,1,").replace("shortdashdot", "3,1,1,1").replace("shortdot", "1,1,").replace("shortdash", "3,1,").replace("longdash", "8,3,").replace(/dot/g, "1,3,").replace("dash", "4,3,").replace(/,$/, "").split(",");
                for (b = a.length; b--; )
                    a[b] = z(a[b]) * this.element.getAttribute("stroke-width");
                a = a.join(",");
                this.element.setAttribute("stroke-dasharray", a)
            }
        },
        alignSetter: function (a) {
            this.element.setAttribute("text-anchor", {left: "start", center: "middle", right: "end"}[a])
        }, opacitySetter: function (a, b, c) {
            this[b] = a;
            c.setAttribute(b, a)
        }, titleSetter: function (a) {
            var b = this.element.getElementsByTagName("title")[0];
            b || (b = v.createElementNS(xa, "title"), this.element.appendChild(b));
            b.textContent = a
        }, textSetter: function (a) {
            if (a !== this.textStr)
                delete this.bBox, this.textStr = a, this.added && this.renderer.buildText(this)
        }, fillSetter: function (a, b, c) {
            typeof a === "string" ? c.setAttribute(b,
                    a) : a && this.colorGradient(a, b, c)
        }, zIndexSetter: function (a, b, c) {
            c.setAttribute(b, a);
            this[b] = a
        }, _defaultSetter: function (a, b, c) {
            c.setAttribute(b, a)
        }};
    O.prototype.yGetter = O.prototype.xGetter;
    O.prototype.translateXSetter = O.prototype.translateYSetter = O.prototype.rotationSetter = O.prototype.verticalAlignSetter = O.prototype.scaleXSetter = O.prototype.scaleYSetter = function (a, b) {
        this[b] = a;
        this.doTransform = !0
    };
    O.prototype["stroke-widthSetter"] = O.prototype.strokeSetter = function (a, b, c) {
        this[b] = a;
        if (this.stroke && this["stroke-width"])
            this.strokeWidth =
                    this["stroke-width"], O.prototype.fillSetter.call(this, this.stroke, "stroke", c), c.setAttribute("stroke-width", this["stroke-width"]), this.hasStroke = !0;
        else if (b === "stroke-width" && a === 0 && this.hasStroke)
            c.removeAttribute("stroke"), this.hasStroke = !1
    };
    var ta = function () {
        this.init.apply(this, arguments)
    };
    ta.prototype = {Element: O, init: function (a, b, c, d, e) {
            var f = location, g, d = this.createElement("svg").attr({version: "1.1"}).css(this.getStyle(d));
            g = d.element;
            a.appendChild(g);
            a.innerHTML.indexOf("xmlns") === -1 && C(g,
                    "xmlns", xa);
            this.isSVG = !0;
            this.box = g;
            this.boxWrapper = d;
            this.alignedObjects = [];
            this.url = (Ua || tb) && v.getElementsByTagName("base").length ? f.href.replace(/#.*?$/, "").replace(/([\('\)])/g, "\\$1").replace(/ /g, "%20") : "";
            this.createElement("desc").add().element.appendChild(v.createTextNode("Created with Highcharts 4.0.1-modified"));
            this.defs = this.createElement("defs").add();
            this.forExport = e;
            this.gradients = {};
            this.cache = {};
            this.setSize(b, c, !1);
            var h;
            if (Ua && a.getBoundingClientRect)
                this.subPixelFix = b = function () {
                    F(a,
                            {left: 0, top: 0});
                    h = a.getBoundingClientRect();
                    F(a, {left: La(h.left) - h.left + "px", top: La(h.top) - h.top + "px"})
                }, b(), K(E, "resize", b)
        }, getStyle: function (a) {
            return this.style = r({fontFamily: '"Lucida Grande", "Lucida Sans Unicode", Arial, Helvetica, sans-serif', fontSize: "12px"}, a)
        }, isHidden: function () {
            return!this.boxWrapper.getBBox().width
        }, destroy: function () {
            var a = this.defs;
            this.box = null;
            this.boxWrapper = this.boxWrapper.destroy();
            Pa(this.gradients || {});
            this.gradients = null;
            if (a)
                this.defs = a.destroy();
            this.subPixelFix &&
                    X(E, "resize", this.subPixelFix);
            return this.alignedObjects = null
        }, createElement: function (a) {
            var b = new this.Element;
            b.init(this, a);
            return b
        }, draw: function () {
        }, buildText: function (a) {
            for (var b = a.element, c = this, d = c.forExport, e = p(a.textStr, "").toString(), f = e.indexOf("<") !== -1, g = b.childNodes, h, i, j = C(b, "x"), k = a.styles, l = a.textWidth, n = k && k.lineHeight, m = k && k.HcTextStroke, o = g.length, aa = function (a) {
                return n ? z(n) : c.fontMetrics(/(px|em)$/.test(a && a.style.fontSize) ? a.style.fontSize : k && k.fontSize || c.style.fontSize ||
                        12, a).h
            }; o--; )
                b.removeChild(g[o]);
            !f && !m && e.indexOf(" ") === -1 ? b.appendChild(v.createTextNode(e)) : (h = /<.*style="([^"]+)".*>/, i = /<.*href="(http[^"]+)".*>/, l && !a.added && this.box.appendChild(b), e = f ? e.replace(/<(b|strong)>/g, '<span style="font-weight:bold">').replace(/<(i|em)>/g, '<span style="font-style:italic">').replace(/<a/g, "<span").replace(/<\/(b|strong|i|em|a)>/g, "</span>").split(/<br.*?>/g) : [e], e[e.length - 1] === "" && e.pop(), q(e, function (e, f) {
                var g, n = 0, e = e.replace(/<span/g, "|||<span").replace(/<\/span>/g,
                        "</span>|||");
                g = e.split("|||");
                q(g, function (e) {
                    if (e !== "" || g.length === 1) {
                        var m = {}, o = v.createElementNS(xa, "tspan"), p;
                        h.test(e) && (p = e.match(h)[1].replace(/(;| |^)color([ :])/, "$1fill$2"), C(o, "style", p));
                        i.test(e) && !d && (C(o, "onclick", 'location.href="' + e.match(i)[1] + '"'), F(o, {cursor: "pointer"}));
                        e = (e.replace(/<(.|\n)*?>/g, "") || " ").replace(/&lt;/g, "<").replace(/&gt;/g, ">");
                        if (e !== " ") {
                            o.appendChild(v.createTextNode(e));
                            if (n)
                                m.dx = 0;
                            else if (f && j !== null)
                                m.x = j;
                            C(o, m);
                            b.appendChild(o);
                            !n && f && (!ba && d && F(o, {display: "block"}),
                                    C(o, "dy", aa(o)));
                            if (l)
                                for (var e = e.replace(/([^\^])-/g, "$1- ").split(" "), m = n || e.length > 1 && k.whiteSpace !== "nowrap", q, I, s = k.HcHeight, t = [], u = aa(o), Lb = 1; m && (e.length || t.length); )
                                    delete a.bBox, q = a.getBBox(), I = q.width, !ba && c.forExport && (I = c.measureSpanWidth(o.firstChild.data, a.styles)), q = I > l, !q || e.length === 1 ? (e = t, t = [], e.length && (Lb++, s && Lb * u > s ? (e = ["..."], a.attr("title", a.textStr)) : (o = v.createElementNS(xa, "tspan"), C(o, {dy: u, x: j}), p && C(o, "style", p), b.appendChild(o), I > l && (l = I)))) : (o.removeChild(o.firstChild),
                                            t.unshift(e.pop())), e.length && o.appendChild(v.createTextNode(e.join(" ").replace(/- /g, "-")));
                            n++
                        }
                    }
                })
            }))
        }, button: function (a, b, c, d, e, f, g, h, i) {
            var j = this.label(a, b, c, i, null, null, null, null, "button"), k = 0, l, n, m, o, p, q, a = {x1: 0, y1: 0, x2: 0, y2: 1}, e = y({"stroke-width": 1, stroke: "#CCCCCC", fill: {linearGradient: a, stops: [[0, "#FEFEFE"], [1, "#F6F6F6"]]}, r: 2, padding: 5, style: {color: "black"}}, e);
            m = e.style;
            delete e.style;
            f = y(e, {stroke: "#68A", fill: {linearGradient: a, stops: [[0, "#FFF"], [1, "#ACF"]]}}, f);
            o = f.style;
            delete f.style;
            g = y(e, {stroke: "#68A", fill: {linearGradient: a, stops: [[0, "#9BD"], [1, "#CDF"]]}}, g);
            p = g.style;
            delete g.style;
            h = y(e, {style: {color: "#CCC"}}, h);
            q = h.style;
            delete h.style;
            K(j.element, Aa ? "mouseover" : "mouseenter", function () {
                k !== 3 && j.attr(f).css(o)
            });
            K(j.element, Aa ? "mouseout" : "mouseleave", function () {
                k !== 3 && (l = [e, f, g][k], n = [m, o, p][k], j.attr(l).css(n))
            });
            j.setState = function (a) {
                (j.state = k = a) ? a === 2 ? j.attr(g).css(p) : a === 3 && j.attr(h).css(q) : j.attr(e).css(m)
            };
            return j.on("click", function () {
                k !== 3 && d.call(j)
            }).attr(e).css(r({cursor: "default"},
            m))
        }, crispLine: function (a, b) {
            a[1] === a[4] && (a[1] = a[4] = w(a[1]) - b % 2 / 2);
            a[2] === a[5] && (a[2] = a[5] = w(a[2]) + b % 2 / 2);
            return a
        }, path: function (a) {
            var b = {fill: S};
            Ma(a) ? b.d = a : da(a) && r(b, a);
            return this.createElement("path").attr(b)
        }, circle: function (a, b, c) {
            a = da(a) ? a : {x: a, y: b, r: c};
            b = this.createElement("circle");
            b.xSetter = function (a) {
                this.element.setAttribute("cx", a)
            };
            b.ySetter = function (a) {
                this.element.setAttribute("cy", a)
            };
            return b.attr(a)
        }, arc: function (a, b, c, d, e, f) {
            if (da(a))
                b = a.y, c = a.r, d = a.innerR, e = a.start, f = a.end,
                        a = a.x;
            a = this.symbol("arc", a || 0, b || 0, c || 0, c || 0, {innerR: d || 0, start: e || 0, end: f || 0});
            a.r = c;
            return a
        }, rect: function (a, b, c, d, e, f) {
            var e = da(a) ? a.r : e, g = this.createElement("rect"), a = da(a) ? a : a === t ? {} : {x: a, y: b, width: u(c, 0), height: u(d, 0)};
            if (f !== t)
                a.strokeWidth = f, a = g.crisp(a);
            if (e)
                a.r = e;
            g.rSetter = function (a) {
                C(this.element, {rx: a, ry: a})
            };
            return g.attr(a)
        }, setSize: function (a, b, c) {
            var d = this.alignedObjects, e = d.length;
            this.width = a;
            this.height = b;
            for (this.boxWrapper[p(c, !0)?"animate":"attr"]({width:a, height:b}); e--; )
                d[e].align()
        },
        g: function (a) {
            var b = this.createElement("g");
            return s(a) ? b.attr({"class": "highcharts-" + a}) : b
        }, image: function (a, b, c, d, e) {
            var f = {preserveAspectRatio: S};
            arguments.length > 1 && r(f, {x: b, y: c, width: d, height: e});
            f = this.createElement("image").attr(f);
            f.element.setAttributeNS ? f.element.setAttributeNS("http://www.w3.org/1999/xlink", "href", a) : f.element.setAttribute("hc-svg-href", a);
            return f
        }, symbol: function (a, b, c, d, e, f) {
            var g, h = this.symbols[a], h = h && h(w(b), w(c), d, e, f), i = /^url\((.*?)\)$/, j, k;
            if (h)
                g = this.path(h), r(g,
                        {symbolName: a, x: b, y: c, width: d, height: e}), f && r(g, f);
            else if (i.test(a))
                k = function (a, b) {
                    a.element && (a.attr({width: b[0], height: b[1]}), a.alignByTranslate || a.translate(w((d - b[0]) / 2), w((e - b[1]) / 2)))
                }, j = a.match(i)[1], a = Kb[j], g = this.image(j).attr({x: b, y: c}), g.isImg = !0, a ? k(g, a) : (g.attr({width: 0, height: 0}), Z("img", {onload: function () {
                        k(g, Kb[j] = [this.width, this.height])
                    }, src: j}));
            return g
        }, symbols: {circle: function (a, b, c, d) {
                var e = 0.166 * c;
                return["M", a + c / 2, b, "C", a + c + e, b, a + c + e, b + d, a + c / 2, b + d, "C", a - e, b + d, a - e, b, a + c /
                            2, b, "Z"]
            }, square: function (a, b, c, d) {
                return["M", a, b, "L", a + c, b, a + c, b + d, a, b + d, "Z"]
            }, triangle: function (a, b, c, d) {
                return["M", a + c / 2, b, "L", a + c, b + d, a, b + d, "Z"]
            }, "triangle-down": function (a, b, c, d) {
                return["M", a, b, "L", a + c, b, a + c / 2, b + d, "Z"]
            }, diamond: function (a, b, c, d) {
                return["M", a + c / 2, b, "L", a + c, b + d / 2, a + c / 2, b + d, a, b + d / 2, "Z"]
            }, arc: function (a, b, c, d, e) {
                var f = e.start, c = e.r || c || d, g = e.end - 0.001, d = e.innerR, h = e.open, i = $(f), j = fa(f), k = $(g), g = fa(g), e = e.end - f < na ? 0 : 1;
                return["M", a + c * i, b + c * j, "A", c, c, 0, e, 1, a + c * k, b + c * g, h ? "M" : "L", a + d *
                            k, b + d * g, "A", d, d, 0, e, 0, a + d * i, b + d * j, h ? "" : "Z"]
            }, callout: function (a, b, c, d, e) {
                var f = G(e && e.r || 0, c, d), g = f + 6, h = e && e.anchorX, i = e && e.anchorY, e = w(e.strokeWidth || 0) % 2 / 2;
                a += e;
                b += e;
                e = ["M", a + f, b, "L", a + c - f, b, "C", a + c, b, a + c, b, a + c, b + f, "L", a + c, b + d - f, "C", a + c, b + d, a + c, b + d, a + c - f, b + d, "L", a + f, b + d, "C", a, b + d, a, b + d, a, b + d - f, "L", a, b + f, "C", a, b, a, b, a + f, b];
                h && h > c && i > b + g && i < b + d - g ? e.splice(13, 3, "L", a + c, i - 6, a + c + 6, i, a + c, i + 6, a + c, b + d - f) : h && h < 0 && i > b + g && i < b + d - g ? e.splice(33, 3, "L", a, i + 6, a - 6, i, a, i - 6, a, b + f) : i && i > d && h > a + g && h < a + c - g ? e.splice(23,
                        3, "L", h + 6, b + d, h, b + d + 6, h - 6, b + d, a + f, b + d) : i && i < 0 && h > a + g && h < a + c - g && e.splice(3, 3, "L", h - 6, b, h, b - 6, h + 6, b, c - f, b);
                return e
            }}, clipRect: function (a, b, c, d) {
            var e = "highcharts-" + ub++, f = this.createElement("clipPath").attr({id: e}).add(this.defs), a = this.rect(a, b, c, d, 0).add(f);
            a.id = e;
            a.clipPath = f;
            return a
        }, text: function (a, b, c, d) {
            var e = ga || !ba && this.forExport, f = {};
            if (d && !this.forExport)
                return this.html(a, b, c);
            f.x = Math.round(b || 0);
            if (c)
                f.y = Math.round(c);
            if (a || a === 0)
                f.text = a;
            a = this.createElement("text").attr(f);
            e && a.css({position: "absolute"});
            if (!d)
                a.xSetter = function (a, b, c) {
                    var d = c.getElementsByTagName("tspan"), e, f = c.getAttribute(b), n;
                    for (n = 0; n < d.length; n++)
                        e = d[n], e.getAttribute(b) === f && e.setAttribute(b, a);
                    c.setAttribute(b, a)
                };
            return a
        }, fontMetrics: function (a, b) {
            a = a || this.style.fontSize;
            if (b && E.getComputedStyle)
                b = b.element || b, a = E.getComputedStyle(b, "").fontSize;
            var a = /px/.test(a) ? z(a) : /em/.test(a) ? parseFloat(a) * 12 : 12, c = a < 24 ? a + 4 : w(a * 1.2), d = w(c * 0.8);
            return{h: c, b: d, f: a}
        }, label: function (a, b, c, d, e, f, g, h, i) {
            function j() {
                var a, b;
                a = o.element.style;
                I = (Wa === void 0 || xb === void 0 || m.styles.textAlign) && o.textStr && o.getBBox();
                m.width = (Wa || I.width || 0) + 2 * B + u;
                m.height = (xb || I.height || 0) + 2 * B;
                Ea = B + n.fontMetrics(a && a.fontSize, o).b;
                if (zb) {
                    if (!p)
                        a = w(-L * B), b = h ? -Ea : 0, m.box = p = d ? n.symbol(d, a, b, m.width, m.height, M) : n.rect(a, b, m.width, m.height, 0, M[Qb]), p.attr("fill", S).add(m);
                    p.isImg || p.attr(r({width: w(m.width), height: w(m.height)}, M));
                    M = null
                }
            }
            function k() {
                var a = m.styles, a = a && a.textAlign, b = u + B * (1 - L), c;
                c = h ? 0 : Ea;
                if (s(Wa) && I && (a === "center" || a === "right"))
                    b += {center: 0.5,
                        right: 1}[a] * (Wa - I.width);
                if (b !== o.x || c !== o.y)
                    o.attr("x", b), c !== t && o.attr("y", c);
                o.x = b;
                o.y = c
            }
            function l(a, b) {
                p ? p.attr(a, b) : M[a] = b
            }
            var n = this, m = n.g(i), o = n.text("", 0, 0, g).attr({zIndex: 1}), p, I, L = 0, B = 3, u = 0, Wa, xb, v, yb, x = 0, M = {}, Ea, zb;
            m.onAdd = function () {
                o.add(m);
                m.attr({text: a || "", x: b, y: c});
                p && s(e) && m.attr({anchorX: e, anchorY: f})
            };
            m.widthSetter = function (a) {
                Wa = a
            };
            m.heightSetter = function (a) {
                xb = a
            };
            m.paddingSetter = function (a) {
                s(a) && a !== B && (B = a, k())
            };
            m.paddingLeftSetter = function (a) {
                s(a) && a !== u && (u = a, k())
            };
            m.alignSetter =
                    function (a) {
                        L = {left: 0, center: 0.5, right: 1}[a]
                    };
            m.textSetter = function (a) {
                a !== t && o.textSetter(a);
                j();
                k()
            };
            m["stroke-widthSetter"] = function (a, b) {
                a && (zb = !0);
                x = a % 2 / 2;
                l(b, a)
            };
            m.strokeSetter = m.fillSetter = m.rSetter = function (a, b) {
                b === "fill" && a && (zb = !0);
                l(b, a)
            };
            m.anchorXSetter = function (a, b) {
                e = a;
                l(b, a + x - v)
            };
            m.anchorYSetter = function (a, b) {
                f = a;
                l(b, a - yb)
            };
            m.xSetter = function (a) {
                m.x = a;
                L && (a -= L * ((Wa || I.width) + B));
                v = w(a);
                m.attr("translateX", v)
            };
            m.ySetter = function (a) {
                yb = m.y = w(a);
                m.attr("translateY", yb)
            };
            var z = m.css;
            return r(m,
                    {css: function (a) {
                            if (a) {
                                var b = {}, a = y(a);
                                q(m.textProps, function (c) {
                                    a[c] !== t && (b[c] = a[c], delete a[c])
                                });
                                o.css(b)
                            }
                            return z.call(m, a)
                        }, getBBox: function () {
                            return{width: I.width + 2 * B, height: I.height + 2 * B, x: I.x - B, y: I.y - B}
                        }, shadow: function (a) {
                            p && p.shadow(a);
                            return m
                        }, destroy: function () {
                            X(m.element, "mouseenter");
                            X(m.element, "mouseleave");
                            o && (o = o.destroy());
                            p && (p = p.destroy());
                            O.prototype.destroy.call(m);
                            m = n = j = k = l = null
                        }})
        }};
    $a = ta;
    r(O.prototype, {htmlCss: function (a) {
            var b = this.element;
            if (b = a && b.tagName === "SPAN" &&
                    a.width)
                delete a.width, this.textWidth = b, this.updateTransform();
            this.styles = r(this.styles, a);
            F(this.element, a);
            return this
        }, htmlGetBBox: function () {
            var a = this.element, b = this.bBox;
            if (!b) {
                if (a.nodeName === "text")
                    a.style.position = "absolute";
                b = this.bBox = {x: a.offsetLeft, y: a.offsetTop, width: a.offsetWidth, height: a.offsetHeight}
            }
            return b
        }, htmlUpdateTransform: function () {
            if (this.added) {
                var a = this.renderer, b = this.element, c = this.translateX || 0, d = this.translateY || 0, e = this.x || 0, f = this.y || 0, g = this.textAlign || "left",
                        h = {left: 0, center: 0.5, right: 1}[g], i = this.shadows;
                F(b, {marginLeft: c, marginTop: d});
                i && q(i, function (a) {
                    F(a, {marginLeft: c + 1, marginTop: d + 1})
                });
                this.inverted && q(b.childNodes, function (c) {
                    a.invertChild(c, b)
                });
                if (b.tagName === "SPAN") {
                    var j = this.rotation, k, l = z(this.textWidth), n = [j, g, b.innerHTML, this.textWidth].join(",");
                    if (n !== this.cTT) {
                        k = a.fontMetrics(b.style.fontSize).b;
                        s(j) && this.setSpanRotation(j, h, k);
                        i = p(this.elemWidth, b.offsetWidth);
                        if (i > l && /[ \-]/.test(b.textContent || b.innerText))
                            F(b, {width: l + "px", display: "block",
                                whiteSpace: "normal"}), i = l;
                        this.getSpanCorrection(i, k, h, j, g)
                    }
                    F(b, {left: e + (this.xCorr || 0) + "px", top: f + (this.yCorr || 0) + "px"});
                    if (tb)
                        k = b.offsetHeight;
                    this.cTT = n
                }
            } else
                this.alignOnAdd = !0
        }, setSpanRotation: function (a, b, c) {
            var d = {}, e = Aa ? "-ms-transform" : tb ? "-webkit-transform" : Ua ? "MozTransform" : Ib ? "-o-transform" : "";
            d[e] = d.transform = "rotate(" + a + "deg)";
            d[e + (Ua ? "Origin" : "-origin")] = d.transformOrigin = b * 100 + "% " + c + "px";
            F(this.element, d)
        }, getSpanCorrection: function (a, b, c) {
            this.xCorr = -a * c;
            this.yCorr = -b
        }});
    r(ta.prototype,
            {html: function (a, b, c) {
                    var d = this.createElement("span"), e = d.element, f = d.renderer;
                    d.textSetter = function (a) {
                        a !== e.innerHTML && delete this.bBox;
                        e.innerHTML = this.textStr = a
                    };
                    d.xSetter = d.ySetter = d.alignSetter = d.rotationSetter = function (a, b) {
                        b === "align" && (b = "textAlign");
                        d[b] = a;
                        d.htmlUpdateTransform()
                    };
                    d.attr({text: a, x: w(b), y: w(c)}).css({position: "absolute", whiteSpace: "nowrap", fontFamily: this.style.fontFamily, fontSize: this.style.fontSize});
                    d.css = d.htmlCss;
                    if (f.isSVG)
                        d.add = function (a) {
                            var b, c = f.box.parentNode,
                                    j = [];
                            if (this.parentGroup = a) {
                                if (b = a.div, !b) {
                                    for (; a; )
                                        j.push(a), a = a.parentGroup;
                                    q(j.reverse(), function (a) {
                                        var d;
                                        b = a.div = a.div || Z(Ka, {className: C(a.element, "class")}, {position: "absolute", left: (a.translateX || 0) + "px", top: (a.translateY || 0) + "px"}, b || c);
                                        d = b.style;
                                        r(a, {translateXSetter: function (b, c) {
                                                d.left = b + "px";
                                                a[c] = b;
                                                a.doTransform = !0
                                            }, translateYSetter: function (b, c) {
                                                d.top = b + "px";
                                                a[c] = b;
                                                a.doTransform = !0
                                            }, visibilitySetter: function (a, b) {
                                                d[b] = a
                                            }})
                                    })
                                }
                            } else
                                b = c;
                            b.appendChild(e);
                            d.added = !0;
                            d.alignOnAdd && d.htmlUpdateTransform();
                            return d
                        };
                    return d
                }});
    var Y;
    if (!ba && !ga) {
        Y = {init: function (a, b) {
                var c = ["<", b, ' filled="f" stroked="f"'], d = ["position: ", "absolute", ";"], e = b === Ka;
                (b === "shape" || e) && d.push("left:0;top:0;width:1px;height:1px;");
                d.push("visibility: ", e ? "hidden" : "visible");
                c.push(' style="', d.join(""), '"/>');
                if (b)
                    c = e || b === "span" || b === "img" ? c.join("") : a.prepVML(c), this.element = Z(c);
                this.renderer = a
            }, add: function (a) {
                var b = this.renderer, c = this.element, d = b.box, d = a ? a.element || a : d;
                a && a.inverted && b.invertChild(c, d);
                d.appendChild(c);
                this.added = !0;
                this.alignOnAdd && !this.deferUpdateTransform && this.updateTransform();
                if (this.onAdd)
                    this.onAdd();
                return this
            }, updateTransform: O.prototype.htmlUpdateTransform, setSpanRotation: function () {
                var a = this.rotation, b = $(a * Ca), c = fa(a * Ca);
                F(this.element, {filter: a ? ["progid:DXImageTransform.Microsoft.Matrix(M11=", b, ", M12=", -c, ", M21=", c, ", M22=", b, ", sizingMethod='auto expand')"].join("") : S})
            }, getSpanCorrection: function (a, b, c, d, e) {
                var f = d ? $(d * Ca) : 1, g = d ? fa(d * Ca) : 0, h = p(this.elemHeight, this.element.offsetHeight),
                        i;
                this.xCorr = f < 0 && -a;
                this.yCorr = g < 0 && -h;
                i = f * g < 0;
                this.xCorr += g * b * (i ? 1 - c : c);
                this.yCorr -= f * b * (d ? i ? c : 1 - c : 1);
                e && e !== "left" && (this.xCorr -= a * c * (f < 0 ? -1 : 1), d && (this.yCorr -= h * c * (g < 0 ? -1 : 1)), F(this.element, {textAlign: e}))
            }, pathToVML: function (a) {
                for (var b = a.length, c = []; b--; )
                    if (ia(a[b]))
                        c[b] = w(a[b] * 10) - 5;
                    else if (a[b] === "Z")
                        c[b] = "x";
                    else if (c[b] = a[b], a.isArc && (a[b] === "wa" || a[b] === "at"))
                        c[b + 5] === c[b + 7] && (c[b + 7] += a[b + 7] > a[b + 5] ? 1 : -1), c[b + 6] === c[b + 8] && (c[b + 8] += a[b + 8] > a[b + 6] ? 1 : -1);
                return c.join(" ") || "x"
            }, clip: function (a) {
                var b =
                        this, c;
                a ? (c = a.members, ka(c, b), c.push(b), b.destroyClip = function () {
                    ka(c, b)
                }, a = a.getCSS(b)) : (b.destroyClip && b.destroyClip(), a = {clip: ib ? "inherit" : "rect(auto)"});
                return b.css(a)
            }, css: O.prototype.htmlCss, safeRemoveChild: function (a) {
                a.parentNode && Qa(a)
            }, destroy: function () {
                this.destroyClip && this.destroyClip();
                return O.prototype.destroy.apply(this)
            }, on: function (a, b) {
                this.element["on" + a] = function () {
                    var a = E.event;
                    a.target = a.srcElement;
                    b(a)
                };
                return this
            }, cutOffPath: function (a, b) {
                var c, a = a.split(/[ ,]/);
                c = a.length;
                if (c === 9 || c === 11)
                    a[c - 4] = a[c - 2] = z(a[c - 2]) - 10 * b;
                return a.join(" ")
            }, shadow: function (a, b, c) {
                var d = [], e, f = this.element, g = this.renderer, h, i = f.style, j, k = f.path, l, n, m, o;
                k && typeof k.value !== "string" && (k = "x");
                n = k;
                if (a) {
                    m = p(a.width, 3);
                    o = (a.opacity || 0.15) / m;
                    for (e = 1; e <= 3; e++) {
                        l = m * 2 + 1 - 2 * e;
                        c && (n = this.cutOffPath(k.value, l + 0.5));
                        j = ['<shape isShadow="true" strokeweight="', l, '" filled="false" path="', n, '" coordsize="10 10" style="', f.style.cssText, '" />'];
                        h = Z(g.prepVML(j), null, {left: z(i.left) + p(a.offsetX, 1), top: z(i.top) +
                                    p(a.offsetY, 1)});
                        if (c)
                            h.cutOff = l + 1;
                        j = ['<stroke color="', a.color || "black", '" opacity="', o * e, '"/>'];
                        Z(g.prepVML(j), null, null, h);
                        b ? b.element.appendChild(h) : f.parentNode.insertBefore(h, f);
                        d.push(h)
                    }
                    this.shadows = d
                }
                return this
            }, updateShadows: sa, setAttr: function (a, b) {
                ib ? this.element[a] = b : this.element.setAttribute(a, b)
            }, classSetter: function (a) {
                this.element.className = a
            }, dashstyleSetter: function (a, b, c) {
                (c.getElementsByTagName("stroke")[0] || Z(this.renderer.prepVML(["<stroke/>"]), null, null, c))[b] = a || "solid";
                this[b] = a
            }, dSetter: function (a, b, c) {
                var d = this.shadows, a = a || [];
                this.d = a.join && a.join(" ");
                c.path = a = this.pathToVML(a);
                if (d)
                    for (c = d.length; c--; )
                        d[c].path = d[c].cutOff ? this.cutOffPath(a, d[c].cutOff) : a;
                this.setAttr(b, a)
            }, fillSetter: function (a, b, c) {
                var d = c.nodeName;
                if (d === "SPAN")
                    c.style.color = a;
                else if (d !== "IMG")
                    c.filled = a !== S, this.setAttr("fillcolor", this.renderer.color(a, c, b, this))
            }, opacitySetter: sa, rotationSetter: function (a, b, c) {
                c = c.style;
                this[b] = c[b] = a;
                c.left = -w(fa(a * Ca) + 1) + "px";
                c.top = w($(a * Ca)) + "px"
            },
            strokeSetter: function (a, b, c) {
                this.setAttr("strokecolor", this.renderer.color(a, c, b))
            }, "stroke-widthSetter": function (a, b, c) {
                c.stroked = !!a;
                this[b] = a;
                ia(a) && (a += "px");
                this.setAttr("strokeweight", a)
            }, titleSetter: function (a, b) {
                this.setAttr(b, a)
            }, visibilitySetter: function (a, b, c) {
                a === "inherit" && (a = "visible");
                this.shadows && q(this.shadows, function (c) {
                    c.style[b] = a
                });
                c.nodeName === "DIV" && (a = a === "hidden" ? "-999em" : 0, ib || (c.style[b] = a ? "visible" : "hidden"), b = "top");
                c.style[b] = a
            }, xSetter: function (a, b, c) {
                this[b] = a;
                b ===
                        "x" ? b = "left" : b === "y" && (b = "top");
                this.updateClipping ? (this[b] = a, this.updateClipping()) : c.style[b] = a
            }, zIndexSetter: function (a, b, c) {
                c.style[b] = a
            }};
        R.VMLElement = Y = la(O, Y);
        Y.prototype.ySetter = Y.prototype.widthSetter = Y.prototype.heightSetter = Y.prototype.xSetter;
        var ha = {Element: Y, isIE8: wa.indexOf("MSIE 8.0") > -1, init: function (a, b, c, d) {
                var e;
                this.alignedObjects = [];
                d = this.createElement(Ka).css(r(this.getStyle(d), {position: "relative"}));
                e = d.element;
                a.appendChild(d.element);
                this.isVML = !0;
                this.box = e;
                this.boxWrapper =
                        d;
                this.cache = {};
                this.setSize(b, c, !1);
                if (!v.namespaces.hcv) {
                    v.namespaces.add("hcv", "urn:schemas-microsoft-com:vml");
                    try {
                        v.createStyleSheet().cssText = "hcv\\:fill, hcv\\:path, hcv\\:shape, hcv\\:stroke{ behavior:url(#default#VML); display: inline-block; } "
                    } catch (f) {
                        v.styleSheets[0].cssText += "hcv\\:fill, hcv\\:path, hcv\\:shape, hcv\\:stroke{ behavior:url(#default#VML); display: inline-block; } "
                    }
                }
            }, isHidden: function () {
                return!this.box.offsetWidth
            }, clipRect: function (a, b, c, d) {
                var e = this.createElement(),
                        f = da(a);
                return r(e, {members: [], left: (f ? a.x : a) + 1, top: (f ? a.y : b) + 1, width: (f ? a.width : c) - 1, height: (f ? a.height : d) - 1, getCSS: function (a) {
                        var b = a.element, c = b.nodeName, a = a.inverted, d = this.top - (c === "shape" ? b.offsetTop : 0), e = this.left, b = e + this.width, f = d + this.height, d = {clip: "rect(" + w(a ? e : d) + "px," + w(a ? f : b) + "px," + w(a ? b : f) + "px," + w(a ? d : e) + "px)"};
                        !a && ib && c === "DIV" && r(d, {width: b + "px", height: f + "px"});
                        return d
                    }, updateClipping: function () {
                        q(e.members, function (a) {
                            a.element && a.css(e.getCSS(a))
                        })
                    }})
            }, color: function (a, b, c, d) {
                var e =
                        this, f, g = /^rgba/, h, i, j = S;
                a && a.linearGradient ? i = "gradient" : a && a.radialGradient && (i = "pattern");
                if (i) {
                    var k, l, n = a.linearGradient || a.radialGradient, m, o, p, I, L, B = "", a = a.stops, u, s = [], t = function () {
                        h = ['<fill colors="' + s.join(",") + '" opacity="', p, '" o:opacity2="', o, '" type="', i, '" ', B, 'focus="100%" method="any" />'];
                        Z(e.prepVML(h), null, null, b)
                    };
                    m = a[0];
                    u = a[a.length - 1];
                    m[0] > 0 && a.unshift([0, m[1]]);
                    u[0] < 1 && a.push([1, u[1]]);
                    q(a, function (a, b) {
                        g.test(a[1]) ? (f = ya(a[1]), k = f.get("rgb"), l = f.get("a")) : (k = a[1], l = 1);
                        s.push(a[0] *
                                100 + "% " + k);
                        b ? (p = l, I = k) : (o = l, L = k)
                    });
                    if (c === "fill")
                        if (i === "gradient")
                            c = n.x1 || n[0] || 0, a = n.y1 || n[1] || 0, m = n.x2 || n[2] || 0, n = n.y2 || n[3] || 0, B = 'angle="' + (90 - V.atan((n - a) / (m - c)) * 180 / na) + '"', t();
                        else {
                            var j = n.r, r = j * 2, w = j * 2, x = n.cx, M = n.cy, v = b.radialReference, y, j = function () {
                                v && (y = d.getBBox(), x += (v[0] - y.x) / y.width - 0.5, M += (v[1] - y.y) / y.height - 0.5, r *= v[2] / y.width, w *= v[2] / y.height);
                                B = 'src="' + Q.global.VMLRadialGradientURL + '" size="' + r + "," + w + '" origin="0.5,0.5" position="' + x + "," + M + '" color2="' + L + '" ';
                                t()
                            };
                            d.added ? j() :
                                    d.onAdd = j;
                            j = I
                        }
                    else
                        j = k
                } else if (g.test(a) && b.tagName !== "IMG")
                    f = ya(a), h = ["<", c, ' opacity="', f.get("a"), '"/>'], Z(this.prepVML(h), null, null, b), j = f.get("rgb");
                else {
                    j = b.getElementsByTagName(c);
                    if (j.length)
                        j[0].opacity = 1, j[0].type = "solid";
                    j = a
                }
                return j
            }, prepVML: function (a) {
                var b = this.isIE8, a = a.join("");
                b ? (a = a.replace("/>", ' xmlns="urn:schemas-microsoft-com:vml" />'), a = a.indexOf('style="') === -1 ? a.replace("/>", ' style="display:inline-block;behavior:url(#default#VML);" />') : a.replace('style="', 'style="display:inline-block;behavior:url(#default#VML);')) :
                        a = a.replace("<", "<hcv:");
                return a
            }, text: ta.prototype.html, path: function (a) {
                var b = {coordsize: "10 10"};
                Ma(a) ? b.d = a : da(a) && r(b, a);
                return this.createElement("shape").attr(b)
            }, circle: function (a, b, c) {
                var d = this.symbol("circle");
                if (da(a))
                    c = a.r, b = a.y, a = a.x;
                d.isCircle = !0;
                d.r = c;
                return d.attr({x: a, y: b})
            }, g: function (a) {
                var b;
                a && (b = {className: "highcharts-" + a, "class": "highcharts-" + a});
                return this.createElement(Ka).attr(b)
            }, image: function (a, b, c, d, e) {
                var f = this.createElement("img").attr({src: a});
                arguments.length >
                        1 && f.attr({x: b, y: c, width: d, height: e});
                return f
            }, createElement: function (a) {
                return a === "rect" ? this.symbol(a) : ta.prototype.createElement.call(this, a)
            }, invertChild: function (a, b) {
                var c = this, d = b.style, e = a.tagName === "IMG" && a.style;
                F(a, {flip: "x", left: z(d.width) - (e ? z(e.top) : 1), top: z(d.height) - (e ? z(e.left) : 1), rotation: -90});
                q(a.childNodes, function (b) {
                    c.invertChild(b, a)
                })
            }, symbols: {arc: function (a, b, c, d, e) {
                    var f = e.start, g = e.end, h = e.r || c || d, c = e.innerR, d = $(f), i = fa(f), j = $(g), k = fa(g);
                    if (g - f === 0)
                        return["x"];
                    f = ["wa",
                        a - h, b - h, a + h, b + h, a + h * d, b + h * i, a + h * j, b + h * k];
                    e.open && !c && f.push("e", "M", a, b);
                    f.push("at", a - c, b - c, a + c, b + c, a + c * j, b + c * k, a + c * d, b + c * i, "x", "e");
                    f.isArc = !0;
                    return f
                }, circle: function (a, b, c, d, e) {
                    e && (c = d = 2 * e.r);
                    e && e.isCircle && (a -= c / 2, b -= d / 2);
                    return["wa", a, b, a + c, b + d, a + c, b + d / 2, a + c, b + d / 2, "e"]
                }, rect: function (a, b, c, d, e) {
                    return ta.prototype.symbols[!s(e) || !e.r ? "square" : "callout"].call(0, a, b, c, d, e)
                }}};
        R.VMLRenderer = Y = function () {
            this.init.apply(this, arguments)
        };
        Y.prototype = y(ta.prototype, ha);
        $a = Y
    }
    ta.prototype.measureSpanWidth =
            function (a, b) {
                var c = v.createElement("span"), d;
                d = v.createTextNode(a);
                c.appendChild(d);
                F(c, b);
                this.box.appendChild(c);
                d = c.offsetWidth;
                Qa(c);
                return d
            };
    var Mb;
    if (ga)
        R.CanVGRenderer = Y = function () {
            xa = "http://www.w3.org/1999/xhtml"
        }, Y.prototype.symbols = {}, Mb = function () {
            function a() {
                var a = b.length, d;
                for (d = 0; d < a; d++)
                    b[d]();
                b = []
            }
            var b = [];
            return{push: function (c, d) {
                    b.length === 0 && Rb(d, a);
                    b.push(c)
                }}
        }(), $a = Y;
    Ta.prototype = {addLabel: function () {
            var a = this.axis, b = a.options, c = a.chart, d = a.horiz, e = a.categories, f = a.names,
                    g = this.pos, h = b.labels, i = h.rotation, j = a.tickPositions, d = d && e && !h.step && !h.staggerLines && !h.rotation && c.plotWidth / j.length || !d && (c.margin[3] || c.chartWidth * 0.33), k = g === j[0], l = g === j[j.length - 1], n, f = e ? p(e[g], f[g], g) : g, e = this.label, m = j.info;
            a.isDatetimeAxis && m && (n = b.dateTimeLabelFormats[m.higherRanks[g] || m.unitName]);
            this.isFirst = k;
            this.isLast = l;
            b = a.labelFormatter.call({axis: a, chart: c, isFirst: k, isLast: l, dateTimeLabelFormat: n, value: a.isLog ? ea(ja(f)) : f});
            g = d && {width: u(1, w(d - 2 * (h.padding || 10))) + "px"};
            g = r(g,
                    h.style);
            if (s(e))
                e && e.attr({text: b}).css(g);
            else {
                n = {align: a.labelAlign};
                if (ia(i))
                    n.rotation = i;
                if (d && h.ellipsis)
                    g.HcHeight = a.len / j.length;
                this.label = e = s(b) && h.enabled ? c.renderer.text(b, 0, 0, h.useHTML).attr(n).css(g).add(a.labelGroup) : null;
                a.tickBaseline = c.renderer.fontMetrics(h.style.fontSize, e).b;
                i && a.side === 2 && (a.tickBaseline *= $(i * Ca))
            }
            this.yOffset = e ? p(h.y, a.tickBaseline + (a.side === 2 ? 8 : -(e.getBBox().height / 2))) : 0
        }, getLabelSize: function () {
            var a = this.label, b = this.axis;
            return a ? a.getBBox()[b.horiz ? "height" :
                    "width"] : 0
        }, getLabelSides: function () {
            var a = this.label.getBBox(), b = this.axis, c = b.horiz, d = b.options.labels, a = c ? a.width : a.height, b = c ? d.x - a * {left: 0, center: 0.5, right: 1}[b.labelAlign] : 0;
            return[b, c ? a + b : a]
        }, handleOverflow: function (a, b) {
            var c = !0, d = this.axis, e = this.isFirst, f = this.isLast, g = d.horiz ? b.x : b.y, h = d.reversed, i = d.tickPositions, j = this.getLabelSides(), k = j[0], j = j[1], l, n, m, o = this.label.line || 0;
            l = d.labelEdge;
            n = d.justifyLabels && (e || f);
            l[o] === t || g + k > l[o] ? l[o] = g + j : n || (c = !1);
            if (n) {
                l = (n = d.justifyToPlot) ? d.pos :
                        0;
                n = n ? l + d.len : d.chart.chartWidth;
                do
                    a += e ? 1 : -1, m = d.ticks[i[a]];
                while (i[a] && (!m || !m.label || m.label.line !== o));
                d = m && m.label.xy && m.label.xy.x + m.getLabelSides()[e ? 0 : 1];
                e && !h || f && h ? g + k < l && (g = l - k, m && g + j > d && (c = !1)) : g + j > n && (g = n - j, m && g + k < d && (c = !1));
                b.x = g
            }
            return c
        }, getPosition: function (a, b, c, d) {
            var e = this.axis, f = e.chart, g = d && f.oldChartHeight || f.chartHeight;
            return{x: a ? e.translate(b + c, null, null, d) + e.transB : e.left + e.offset + (e.opposite ? (d && f.oldChartWidth || f.chartWidth) - e.right - e.left : 0), y: a ? g - e.bottom + e.offset -
                        (e.opposite ? e.height : 0) : g - e.translate(b + c, null, null, d) - e.transB}
        }, getLabelPosition: function (a, b, c, d, e, f, g, h) {
            var i = this.axis, j = i.transA, k = i.reversed, l = i.staggerLines, a = a + e.x - (f && d ? f * j * (k ? -1 : 1) : 0), b = b + this.yOffset - (f && !d ? f * j * (k ? 1 : -1) : 0);
            if (l)
                c.line = g / (h || 1) % l, b += c.line * (i.labelOffset / l);
            return{x: a, y: b}
        }, getMarkPath: function (a, b, c, d, e, f) {
            return f.crispLine(["M", a, b, "L", a + (e ? 0 : -c), b + (e ? c : 0)], d)
        }, render: function (a, b, c) {
            var d = this.axis, e = d.options, f = d.chart.renderer, g = d.horiz, h = this.type, i = this.label,
                    j = this.pos, k = e.labels, l = this.gridLine, n = h ? h + "Grid" : "grid", m = h ? h + "Tick" : "tick", o = e[n + "LineWidth"], q = e[n + "LineColor"], I = e[n + "LineDashStyle"], L = e[m + "Length"], n = e[m + "Width"] || 0, B = e[m + "Color"], u = e[m + "Position"], m = this.mark, s = k.step, r = !0, w = d.tickmarkOffset, v = this.getPosition(g, j, w, b), x = v.x, v = v.y, M = g && x === d.pos + d.len || !g && v === d.pos ? -1 : 1, c = p(c, 1);
            this.isActive = !0;
            if (o) {
                j = d.getPlotLinePath(j + w, o * M, b, !0);
                if (l === t) {
                    l = {stroke: q, "stroke-width": o};
                    if (I)
                        l.dashstyle = I;
                    if (!h)
                        l.zIndex = 1;
                    if (b)
                        l.opacity = 0;
                    this.gridLine =
                            l = o ? f.path(j).attr(l).add(d.gridGroup) : null
                }
                if (!b && l && j)
                    l[this.isNew ? "attr" : "animate"]({d: j, opacity: c})
            }
            if (n && L)
                u === "inside" && (L = -L), d.opposite && (L = -L), h = this.getMarkPath(x, v, L, n * M, g, f), m ? m.animate({d: h, opacity: c}) : this.mark = f.path(h).attr({stroke: B, "stroke-width": n, opacity: c}).add(d.axisGroup);
            if (i && !isNaN(x))
                i.xy = v = this.getLabelPosition(x, v, i, g, k, w, a, s), this.isFirst && !this.isLast && !p(e.showFirstLabel, 1) || this.isLast && !this.isFirst && !p(e.showLastLabel, 1) ? r = !1 : !d.isRadial && !k.step && !k.rotation && !b &&
                        c !== 0 && (r = this.handleOverflow(a, v)), s && a % s && (r = !1), r && !isNaN(v.y) ? (v.opacity = c, i[this.isNew ? "attr" : "animate"](v), this.isNew = !1) : i.attr("y", -9999)
        }, destroy: function () {
            Pa(this, this.axis)
        }};
    R.PlotLineOrBand = function (a, b) {
        this.axis = a;
        if (b)
            this.options = b, this.id = b.id
    };
    R.PlotLineOrBand.prototype = {render: function () {
            var a = this, b = a.axis, c = b.horiz, d = (b.pointRange || 0) / 2, e = a.options, f = e.label, g = a.label, h = e.width, i = e.to, j = e.from, k = s(j) && s(i), l = e.value, n = e.dashStyle, m = a.svgElem, o = [], p, q = e.color, L = e.zIndex, B = e.events,
                    t = {}, r = b.chart.renderer;
            b.isLog && (j = za(j), i = za(i), l = za(l));
            if (h) {
                if (o = b.getPlotLinePath(l, h), t = {stroke: q, "stroke-width": h}, n)
                    t.dashstyle = n
            } else if (k) {
                j = u(j, b.min - d);
                i = G(i, b.max + d);
                o = b.getPlotBandPath(j, i, e);
                if (q)
                    t.fill = q;
                if (e.borderWidth)
                    t.stroke = e.borderColor, t["stroke-width"] = e.borderWidth
            } else
                return;
            if (s(L))
                t.zIndex = L;
            if (m)
                if (o)
                    m.animate({d: o}, null, m.onGetPath);
                else {
                    if (m.hide(), m.onGetPath = function () {
                        m.show()
                    }, g)
                        a.label = g = g.destroy()
                }
            else if (o && o.length && (a.svgElem = m = r.path(o).attr(t).add(), B))
                for (p in d =
                        function (b) {
                            m.on(b, function (c) {
                                B[b].apply(a, [c])
                            })
                        }, B)
                    d(p);
            if (f && s(f.text) && o && o.length && b.width > 0 && b.height > 0) {
                f = y({align: c && k && "center", x: c ? !k && 4 : 10, verticalAlign: !c && k && "middle", y: c ? k ? 16 : 10 : k ? 6 : -4, rotation: c && !k && 90}, f);
                if (!g) {
                    t = {align: f.textAlign || f.align, rotation: f.rotation};
                    if (s(L))
                        t.zIndex = L;
                    a.label = g = r.text(f.text, 0, 0, f.useHTML).attr(t).css(f.style).add()
                }
                b = [o[1], o[4], k ? o[6] : o[1]];
                k = [o[2], o[5], k ? o[7] : o[2]];
                o = Oa(b);
                c = Oa(k);
                g.align(f, !1, {x: o, y: c, width: Ba(b) - o, height: Ba(k) - c});
                g.show()
            } else
                g &&
                        g.hide();
            return a
        }, destroy: function () {
            ka(this.axis.plotLinesAndBands, this);
            delete this.axis;
            Pa(this)
        }};
    ma.prototype = {defaultOptions: {dateTimeLabelFormats: {millisecond: "%H:%M:%S.%L", second: "%H:%M:%S", minute: "%H:%M", hour: "%H:%M", day: "%e. %b", week: "%e. %b", month: "%b '%y", year: "%Y"}, endOnTick: !1, gridLineColor: "#C0C0C0", labels: H, lineColor: "#C0D0E0", lineWidth: 1, minPadding: 0.01, maxPadding: 0.01, minorGridLineColor: "#E0E0E0", minorGridLineWidth: 1, minorTickColor: "#A0A0A0", minorTickLength: 2, minorTickPosition: "outside",
            startOfWeek: 1, startOnTick: !1, tickColor: "#C0D0E0", tickLength: 10, tickmarkPlacement: "between", tickPixelInterval: 100, tickPosition: "outside", tickWidth: 1, title: {align: "middle", style: {color: "#707070"}}, type: "linear"}, defaultYAxisOptions: {endOnTick: !0, gridLineWidth: 1, tickPixelInterval: 72, showLastLabel: !0, labels: {x: -8, y: 3}, lineWidth: 0, maxPadding: 0.05, minPadding: 0.05, startOnTick: !0, tickWidth: 0, title: {rotation: 270, text: "Values"}, stackLabels: {enabled: !1, formatter: function () {
                    return Ha(this.total, -1)
                }, style: H.style}},
        defaultLeftAxisOptions: {labels: {x: -15, y: null}, title: {rotation: 270}}, defaultRightAxisOptions: {labels: {x: 15, y: null}, title: {rotation: 90}}, defaultBottomAxisOptions: {labels: {x: 0, y: null}, title: {rotation: 0}}, defaultTopAxisOptions: {labels: {x: 0, y: -15}, title: {rotation: 0}}, init: function (a, b) {
            var c = b.isX;
            this.horiz = a.inverted ? !c : c;
            this.coll = (this.isXAxis = c) ? "xAxis" : "yAxis";
            this.opposite = b.opposite;
            this.side = b.side || (this.horiz ? this.opposite ? 0 : 2 : this.opposite ? 1 : 3);
            this.setOptions(b);
            var d = this.options, e = d.type;
            this.labelFormatter = d.labels.formatter || this.defaultLabelFormatter;
            this.userOptions = b;
            this.minPixelPadding = 0;
            this.chart = a;
            this.reversed = d.reversed;
            this.zoomEnabled = d.zoomEnabled !== !1;
            this.categories = d.categories || e === "category";
            this.names = [];
            this.isLog = e === "logarithmic";
            this.isDatetimeAxis = e === "datetime";
            this.isLinked = s(d.linkedTo);
            this.tickmarkOffset = this.categories && d.tickmarkPlacement === "between" ? 0.5 : 0;
            this.ticks = {};
            this.labelEdge = [];
            this.minorTicks = {};
            this.plotLinesAndBands = [];
            this.alternateBands =
                    {};
            this.len = 0;
            this.minRange = this.userMinRange = d.minRange || d.maxZoom;
            this.range = d.range;
            this.offset = d.offset || 0;
            this.stacks = {};
            this.oldStacks = {};
            this.min = this.max = null;
            this.crosshair = p(d.crosshair, ra(a.options.tooltip.crosshairs)[c ? 0 : 1], !1);
            var f, d = this.options.events;
            Da(this, a.axes) === -1 && (c && !this.isColorAxis ? a.axes.splice(a.xAxis.length, 0, this) : a.axes.push(this), a[this.coll].push(this));
            this.series = this.series || [];
            if (a.inverted && c && this.reversed === t)
                this.reversed = !0;
            this.removePlotLine = this.removePlotBand =
                    this.removePlotBandOrLine;
            for (f in d)
                K(this, f, d[f]);
            if (this.isLog)
                this.val2lin = za, this.lin2val = ja
        }, setOptions: function (a) {
            this.options = y(this.defaultOptions, this.isXAxis ? {} : this.defaultYAxisOptions, [this.defaultTopAxisOptions, this.defaultRightAxisOptions, this.defaultBottomAxisOptions, this.defaultLeftAxisOptions][this.side], y(Q[this.coll], a))
        }, defaultLabelFormatter: function () {
            var a = this.axis, b = this.value, c = a.categories, d = this.dateTimeLabelFormat, e = Q.lang.numericSymbols, f = e && e.length, g, h = a.options.labels.format,
                    a = a.isLog ? b : a.tickInterval;
            if (h)
                g = Ja(h, this);
            else if (c)
                g = b;
            else if (d)
                g = db(d, b);
            else if (f && a >= 1E3)
                for (; f-- && g === t; )
                    c = Math.pow(1E3, f + 1), a >= c && e[f] !== null && (g = Ha(b / c, -1) + e[f]);
            g === t && (g = N(b) >= 1E4 ? Ha(b, 0) : Ha(b, -1, t, ""));
            return g
        }, getSeriesExtremes: function () {
            var a = this, b = a.chart;
            a.hasVisibleSeries = !1;
            a.dataMin = a.dataMax = null;
            a.buildStacks && a.buildStacks();
            q(a.series, function (c) {
                if (c.visible || !b.options.chart.ignoreHiddenSeries) {
                    var d;
                    d = c.options.threshold;
                    var e;
                    a.hasVisibleSeries = !0;
                    a.isLog && d <= 0 && (d =
                            null);
                    if (a.isXAxis) {
                        if (d = c.xData, d.length)
                            a.dataMin = G(p(a.dataMin, d[0]), Oa(d)), a.dataMax = u(p(a.dataMax, d[0]), Ba(d))
                    } else {
                        c.getExtremes();
                        e = c.dataMax;
                        c = c.dataMin;
                        if (s(c) && s(e))
                            a.dataMin = G(p(a.dataMin, c), c), a.dataMax = u(p(a.dataMax, e), e);
                        if (s(d))
                            if (a.dataMin >= d)
                                a.dataMin = d, a.ignoreMinPadding = !0;
                            else if (a.dataMax < d)
                                a.dataMax = d, a.ignoreMaxPadding = !0
                    }
                }
            })
        }, translate: function (a, b, c, d, e, f) {
            var g = 1, h = 0, i = d ? this.oldTransA : this.transA, d = d ? this.oldMin : this.min, j = this.minPixelPadding, e = (this.options.ordinal || this.isLog &&
                    e) && this.lin2val;
            if (!i)
                i = this.transA;
            if (c)
                g *= -1, h = this.len;
            this.reversed && (g *= -1, h -= g * (this.sector || this.len));
            b ? (a = a * g + h, a -= j, a = a / i + d, e && (a = this.lin2val(a))) : (e && (a = this.val2lin(a)), f === "between" && (f = 0.5), a = g * (a - d) * i + h + g * j + (ia(f) ? i * f * this.pointRange : 0));
            return a
        }, toPixels: function (a, b) {
            return this.translate(a, !1, !this.horiz, null, !0) + (b ? 0 : this.pos)
        }, toValue: function (a, b) {
            return this.translate(a - (b ? 0 : this.pos), !0, !this.horiz, null, !0)
        }, getPlotLinePath: function (a, b, c, d, e) {
            var f = this.chart, g = this.left,
                    h = this.top, i, j, k = c && f.oldChartHeight || f.chartHeight, l = c && f.oldChartWidth || f.chartWidth, n;
            i = this.transB;
            e = p(e, this.translate(a, null, null, c));
            a = c = w(e + i);
            i = j = w(k - e - i);
            if (isNaN(e))
                n = !0;
            else if (this.horiz) {
                if (i = h, j = k - this.bottom, a < g || a > g + this.width)
                    n = !0
            } else if (a = g, c = l - this.right, i < h || i > h + this.height)
                n = !0;
            return n && !d ? null : f.renderer.crispLine(["M", a, i, "L", c, j], b || 1)
        }, getLinearTickPositions: function (a, b, c) {
            var d, e = ea(U(b / a) * a), f = ea(La(c / a) * a), g = [];
            if (b === c && ia(b))
                return[b];
            for (b = e; b <= f; ) {
                g.push(b);
                b = ea(b +
                        a);
                if (b === d)
                    break;
                d = b
            }
            return g
        }, getMinorTickPositions: function () {
            var a = this.options, b = this.tickPositions, c = this.minorTickInterval, d = [], e;
            if (this.isLog) {
                e = b.length;
                for (a = 1; a < e; a++)
                    d = d.concat(this.getLogTickPositions(c, b[a - 1], b[a], !0))
            } else if (this.isDatetimeAxis && a.minorTickInterval === "auto")
                d = d.concat(this.getTimeTicks(this.normalizeTimeTickInterval(c), this.min, this.max, a.startOfWeek)), d[0] < this.min && d.shift();
            else
                for (b = this.min + (b[0] - this.min) % c; b <= this.max; b += c)
                    d.push(b);
            return d
        }, adjustForMinRange: function () {
            var a =
                    this.options, b = this.min, c = this.max, d, e = this.dataMax - this.dataMin >= this.minRange, f, g, h, i, j;
            if (this.isXAxis && this.minRange === t && !this.isLog)
                s(a.min) || s(a.max) ? this.minRange = null : (q(this.series, function (a) {
                    i = a.xData;
                    for (g = j = a.xIncrement?1:i.length - 1; g > 0; g--)
                        if (h = i[g] - i[g - 1], f === t || h < f)
                            f = h
                }), this.minRange = G(f * 5, this.dataMax - this.dataMin));
            if (c - b < this.minRange) {
                var k = this.minRange;
                d = (k - c + b) / 2;
                d = [b - d, p(a.min, b - d)];
                if (e)
                    d[2] = this.dataMin;
                b = Ba(d);
                c = [b + k, p(a.max, b + k)];
                if (e)
                    c[2] = this.dataMax;
                c = Oa(c);
                c - b < k &&
                        (d[0] = c - k, d[1] = p(a.min, c - k), b = Ba(d))
            }
            this.min = b;
            this.max = c
        }, setAxisTranslation: function (a) {
            var b = this, c = b.max - b.min, d = b.axisPointRange || 0, e, f = 0, g = 0, h = b.linkedParent, i = !!b.categories, j = b.transA;
            if (b.isXAxis || i || d)
                h ? (f = h.minPointOffset, g = h.pointRangePadding) : q(b.series, function (a) {
                    var h = i ? 1 : b.isXAxis ? a.pointRange : b.axisPointRange || 0, j = a.options.pointPlacement, m = a.closestPointRange;
                    h > c && (h = 0);
                    d = u(d, h);
                    f = u(f, Ga(j) ? 0 : h / 2);
                    g = u(g, j === "on" ? 0 : h);
                    !a.noSharedTooltip && s(m) && (e = s(e) ? G(e, m) : m)
                }), h = b.ordinalSlope &&
                        e ? b.ordinalSlope / e : 1, b.minPointOffset = f *= h, b.pointRangePadding = g *= h, b.pointRange = G(d, c), b.closestPointRange = e;
            if (a)
                b.oldTransA = j;
            b.translationSlope = b.transA = j = b.len / (c + g || 1);
            b.transB = b.horiz ? b.left : b.bottom;
            b.minPixelPadding = j * f
        }, setTickPositions: function (a) {
            var b = this, c = b.chart, d = b.options, e = b.isLog, f = b.isDatetimeAxis, g = b.isXAxis, h = b.isLinked, i = b.options.tickPositioner, j = d.maxPadding, k = d.minPadding, l = d.tickInterval, n = d.minTickInterval, m = d.tickPixelInterval, o, aa = b.categories;
            h ? (b.linkedParent = c[b.coll][d.linkedTo],
                    c = b.linkedParent.getExtremes(), b.min = p(c.min, c.dataMin), b.max = p(c.max, c.dataMax), d.type !== b.linkedParent.options.type && oa(11, 1)) : (b.min = p(b.userMin, d.min, b.dataMin), b.max = p(b.userMax, d.max, b.dataMax));
            if (e)
                !a && G(b.min, p(b.dataMin, b.min)) <= 0 && oa(10, 1), b.min = ea(za(b.min)), b.max = ea(za(b.max));
            if (b.range && s(b.max))
                b.userMin = b.min = u(b.min, b.max - b.range), b.userMax = b.max, b.range = null;
            b.beforePadding && b.beforePadding();
            b.adjustForMinRange();
            if (!aa && !b.axisPointRange && !b.usePercentage && !h && s(b.min) && s(b.max) &&
                    (c = b.max - b.min)) {
                if (!s(d.min) && !s(b.userMin) && k && (b.dataMin < 0 || !b.ignoreMinPadding))
                    b.min -= c * k;
                if (!s(d.max) && !s(b.userMax) && j && (b.dataMax > 0 || !b.ignoreMaxPadding))
                    b.max += c * j
            }
            if (ia(d.floor))
                b.min = u(b.min, d.floor);
            if (ia(d.ceiling))
                b.max = G(b.max, d.ceiling);
            b.min === b.max || b.min === void 0 || b.max === void 0 ? b.tickInterval = 1 : h && !l && m === b.linkedParent.options.tickPixelInterval ? b.tickInterval = b.linkedParent.tickInterval : (b.tickInterval = p(l, aa ? 1 : (b.max - b.min) * m / u(b.len, m)), !s(l) && b.len < m && !this.isRadial && !this.isLog &&
                    !aa && d.startOnTick && d.endOnTick && (o = !0, b.tickInterval /= 4));
            g && !a && q(b.series, function (a) {
                a.processData(b.min !== b.oldMin || b.max !== b.oldMax)
            });
            b.setAxisTranslation(!0);
            b.beforeSetTickPositions && b.beforeSetTickPositions();
            if (b.postProcessTickInterval)
                b.tickInterval = b.postProcessTickInterval(b.tickInterval);
            if (b.pointRange)
                b.tickInterval = u(b.pointRange, b.tickInterval);
            if (!l && b.tickInterval < n)
                b.tickInterval = n;
            if (!f && !e && !l)
                b.tickInterval = nb(b.tickInterval, null, mb(b.tickInterval), d);
            b.minorTickInterval =
                    d.minorTickInterval === "auto" && b.tickInterval ? b.tickInterval / 5 : d.minorTickInterval;
            b.tickPositions = a = d.tickPositions ? [].concat(d.tickPositions) : i && i.apply(b, [b.min, b.max]);
            if (!a)
                !b.ordinalPositions && (b.max - b.min) / b.tickInterval > u(2 * b.len, 200) && oa(19, !0), a = f ? b.getTimeTicks(b.normalizeTimeTickInterval(b.tickInterval, d.units), b.min, b.max, d.startOfWeek, b.ordinalPositions, b.closestPointRange, !0) : e ? b.getLogTickPositions(b.tickInterval, b.min, b.max) : b.getLinearTickPositions(b.tickInterval, b.min, b.max), o &&
                        a.splice(1, a.length - 2), b.tickPositions = a;
            if (!h)
                e = a[0], f = a[a.length - 1], h = b.minPointOffset || 0, d.startOnTick ? b.min = e : b.min - h > e && a.shift(), d.endOnTick ? b.max = f : b.max + h < f && a.pop(), a.length === 1 && (d = N(b.max) > 1E13 ? 1 : 0.001, b.min -= d, b.max += d)
        }, setMaxTicks: function () {
            var a = this.chart, b = a.maxTicks || {}, c = this.tickPositions, d = this._maxTicksKey = [this.coll, this.pos, this.len].join("-");
            if (!this.isLinked && !this.isDatetimeAxis && c && c.length > (b[d] || 0) && this.options.alignTicks !== !1)
                b[d] = c.length;
            a.maxTicks = b
        }, adjustTickAmount: function () {
            var a =
                    this._maxTicksKey, b = this.tickPositions, c = this.chart.maxTicks;
            if (c && c[a] && !this.isDatetimeAxis && !this.categories && !this.isLinked && this.options.alignTicks !== !1 && this.min !== t) {
                var d = this.tickAmount, e = b.length;
                this.tickAmount = a = c[a];
                if (e < a) {
                    for (; b.length < a; )
                        b.push(ea(b[b.length - 1] + this.tickInterval));
                    this.transA *= (e - 1) / (a - 1);
                    this.max = b[b.length - 1]
                }
                if (s(d) && a !== d)
                    this.isDirty = !0
            }
        }, setScale: function () {
            var a = this.stacks, b, c, d, e;
            this.oldMin = this.min;
            this.oldMax = this.max;
            this.oldAxisLength = this.len;
            this.setAxisSize();
            e = this.len !== this.oldAxisLength;
            q(this.series, function (a) {
                if (a.isDirtyData || a.isDirty || a.xAxis.isDirty)
                    d = !0
            });
            if (e || d || this.isLinked || this.forceRedraw || this.userMin !== this.oldUserMin || this.userMax !== this.oldUserMax) {
                if (!this.isXAxis)
                    for (b in a)
                        for (c in a[b])
                            a[b][c].total = null, a[b][c].cum = 0;
                this.forceRedraw = !1;
                this.getSeriesExtremes();
                this.setTickPositions();
                this.oldUserMin = this.userMin;
                this.oldUserMax = this.userMax;
                if (!this.isDirty)
                    this.isDirty = e || this.min !== this.oldMin || this.max !== this.oldMax
            } else if (!this.isXAxis) {
                if (this.oldStacks)
                    a =
                            this.stacks = this.oldStacks;
                for (b in a)
                    for (c in a[b])
                        a[b][c].cum = a[b][c].total
            }
            this.setMaxTicks()
        }, setExtremes: function (a, b, c, d, e) {
            var f = this, g = f.chart, c = p(c, !0), e = r(e, {min: a, max: b});
            J(f, "setExtremes", e, function () {
                f.userMin = a;
                f.userMax = b;
                f.eventArgs = e;
                f.isDirtyExtremes = !0;
                c && g.redraw(d)
            })
        }, zoom: function (a, b) {
            var c = this.dataMin, d = this.dataMax, e = this.options;
            this.allowZoomOutside || (s(c) && a <= G(c, p(e.min, c)) && (a = t), s(d) && b >= u(d, p(e.max, d)) && (b = t));
            this.displayBtn = a !== t || b !== t;
            this.setExtremes(a, b, !1, t,
                    {trigger: "zoom"});
            return!0
        }, setAxisSize: function () {
            var a = this.chart, b = this.options, c = b.offsetLeft || 0, d = this.horiz, e = p(b.width, a.plotWidth - c + (b.offsetRight || 0)), f = p(b.height, a.plotHeight), g = p(b.top, a.plotTop), b = p(b.left, a.plotLeft + c), c = /%$/;
            c.test(f) && (f = parseInt(f, 10) / 100 * a.plotHeight);
            c.test(g) && (g = parseInt(g, 10) / 100 * a.plotHeight + a.plotTop);
            this.left = b;
            this.top = g;
            this.width = e;
            this.height = f;
            this.bottom = a.chartHeight - f - g;
            this.right = a.chartWidth - e - b;
            this.len = u(d ? e : f, 0);
            this.pos = d ? b : g
        }, getExtremes: function () {
            var a =
                    this.isLog;
            return{min: a ? ea(ja(this.min)) : this.min, max: a ? ea(ja(this.max)) : this.max, dataMin: this.dataMin, dataMax: this.dataMax, userMin: this.userMin, userMax: this.userMax}
        }, getThreshold: function (a) {
            var b = this.isLog, c = b ? ja(this.min) : this.min, b = b ? ja(this.max) : this.max;
            c > a || a === null ? a = c : b < a && (a = b);
            return this.translate(a, 0, 1, 0, 1)
        }, autoLabelAlign: function (a) {
            a = (p(a, 0) - this.side * 90 + 720) % 360;
            return a > 15 && a < 165 ? "right" : a > 195 && a < 345 ? "left" : "center"
        }, getOffset: function () {
            var a = this, b = a.chart, c = b.renderer, d = a.options,
                    e = a.tickPositions, f = a.ticks, g = a.horiz, h = a.side, i = b.inverted ? [1, 0, 3, 2][h] : h, j, k, l = 0, n, m = 0, o = d.title, aa = d.labels, I = 0, L = b.axisOffset, b = b.clipOffset, B = [-1, 1, 1, -1][h], r, w = 1, v = p(aa.maxStaggerLines, 5), y, z, x, M, Ea;
            a.hasData = j = a.hasVisibleSeries || s(a.min) && s(a.max) && !!e;
            a.showAxis = k = j || p(d.showEmpty, !0);
            a.staggerLines = a.horiz && aa.staggerLines;
            if (!a.axisGroup)
                a.gridGroup = c.g("grid").attr({zIndex: d.gridZIndex || 1}).add(), a.axisGroup = c.g("axis").attr({zIndex: d.zIndex || 2}).add(), a.labelGroup = c.g("axis-labels").attr({zIndex: aa.zIndex ||
                            7}).addClass("highcharts-" + a.coll.toLowerCase() + "-labels").add();
            if (j || a.isLinked) {
                a.labelAlign = p(aa.align || a.autoLabelAlign(aa.rotation));
                q(e, function (b) {
                    f[b] ? f[b].addLabel() : f[b] = new Ta(a, b)
                });
                if (a.horiz && !a.staggerLines && v && !aa.rotation) {
                    for (j = a.reversed ? [].concat(e).reverse() : e; w < v; ) {
                        y = [];
                        z = !1;
                        for (r = 0; r < j.length; r++)
                            x = j[r], M = (M = f[x].label && f[x].label.getBBox()) ? M.width : 0, Ea = r % w, M && (x = a.translate(x), y[Ea] !== t && x < y[Ea] && (z = !0), y[Ea] = x + M);
                        if (z)
                            w++;
                        else
                            break
                    }
                    if (w > 1)
                        a.staggerLines = w
                }
                q(e, function (b) {
                    if (h ===
                            0 || h === 2 || {1: "left", 3: "right"}[h] === a.labelAlign)
                        I = u(f[b].getLabelSize(), I)
                });
                if (a.staggerLines)
                    I *= a.staggerLines, a.labelOffset = I
            } else
                for (r in f)
                    f[r].destroy(), delete f[r];
            if (o && o.text && o.enabled !== !1) {
                if (!a.axisTitle)
                    a.axisTitle = c.text(o.text, 0, 0, o.useHTML).attr({zIndex: 7, rotation: o.rotation || 0, align: o.textAlign || {low: "left", middle: "center", high: "right"}[o.align]}).addClass("highcharts-" + this.coll.toLowerCase() + "-title").css(o.style).add(a.axisGroup), a.axisTitle.isNew = !0;
                if (k)
                    l = a.axisTitle.getBBox()[g ?
                            "height" : "width"], n = o.offset, m = s(n) ? 0 : p(o.margin, g ? 5 : 10);
                a.axisTitle[k ? "show" : "hide"]()
            }
            a.offset = B * p(d.offset, L[h]);
            c = h === 2 ? a.tickBaseline : 0;
            g = I + m + (I && B * (g ? p(aa.y, a.tickBaseline + 8) : aa.x) - c);
            a.axisTitleMargin = p(n, g);
            L[h] = u(L[h], a.axisTitleMargin + l + B * a.offset, g);
            b[i] = u(b[i], U(d.lineWidth / 2) * 2)
        }, getLinePath: function (a) {
            var b = this.chart, c = this.opposite, d = this.offset, e = this.horiz, f = this.left + (c ? this.width : 0) + d, d = b.chartHeight - this.bottom - (c ? this.height : 0) + d;
            c && (a *= -1);
            return b.renderer.crispLine(["M",
                e ? this.left : f, e ? d : this.top, "L", e ? b.chartWidth - this.right : f, e ? d : b.chartHeight - this.bottom], a)
        }, getTitlePosition: function () {
            var a = this.horiz, b = this.left, c = this.top, d = this.len, e = this.options.title, f = a ? b : c, g = this.opposite, h = this.offset, i = z(e.style.fontSize || 12), d = {low: f + (a ? 0 : d), middle: f + d / 2, high: f + (a ? d : 0)}[e.align], b = (a ? c + this.height : b) + (a ? 1 : -1) * (g ? -1 : 1) * this.axisTitleMargin + (this.side === 2 ? i : 0);
            return{x: a ? d : b + (g ? this.width : 0) + h + (e.x || 0), y: a ? b - (g ? this.height : 0) + h : d + (e.y || 0)}
        }, render: function () {
            var a = this,
                    b = a.horiz, c = a.reversed, d = a.chart, e = d.renderer, f = a.options, g = a.isLog, h = a.isLinked, i = a.tickPositions, j, k = a.axisTitle, l = a.ticks, n = a.minorTicks, m = a.alternateBands, o = f.stackLabels, p = f.alternateGridColor, I = a.tickmarkOffset, L = f.lineWidth, B = d.hasRendered && s(a.oldMin) && !isNaN(a.oldMin), r = a.hasData, u = a.showAxis, w, v = f.labels.overflow, y = a.justifyLabels = b && v !== !1, x;
            a.labelEdge.length = 0;
            a.justifyToPlot = v === "justify";
            q([l, n, m], function (a) {
                for (var b in a)
                    a[b].isActive = !1
            });
            if (r || h)
                if (a.minorTickInterval && !a.categories &&
                        q(a.getMinorTickPositions(), function (b) {
                            n[b] || (n[b] = new Ta(a, b, "minor"));
                            B && n[b].isNew && n[b].render(null, !0);
                            n[b].render(null, !1, 1)
                        }), i.length && (j = i.slice(), (b && c || !b && !c) && j.reverse(), y && (j = j.slice(1).concat([j[0]])), q(j, function (b, c) {
                    y && (c = c === j.length - 1 ? 0 : c + 1);
                    if (!h || b >= a.min && b <= a.max)
                        l[b] || (l[b] = new Ta(a, b)), B && l[b].isNew && l[b].render(c, !0, 0.1), l[b].render(c)
                }), I && a.min === 0 && (l[-1] || (l[-1] = new Ta(a, -1, null, !0)), l[-1].render(-1))), p && q(i, function (b, c) {
                    if (c % 2 === 0 && b < a.max)
                        m[b] || (m[b] = new R.PlotLineOrBand(a)),
                                w = b + I, x = i[c + 1] !== t ? i[c + 1] + I : a.max, m[b].options = {from: g ? ja(w) : w, to: g ? ja(x) : x, color: p}, m[b].render(), m[b].isActive = !0
                }), !a._addedPlotLB)
                    q((f.plotLines || []).concat(f.plotBands || []), function (b) {
                        a.addPlotBandOrLine(b)
                    }), a._addedPlotLB = !0;
            q([l, n, m], function (a) {
                var b, c, e = [], f = va ? va.duration || 500 : 0, g = function () {
                    for (c = e.length; c--; )
                        a[e[c]] && !a[e[c]].isActive && (a[e[c]].destroy(), delete a[e[c]])
                };
                for (b in a)
                    if (!a[b].isActive)
                        a[b].render(b, !1, 0), a[b].isActive = !1, e.push(b);
                a === m || !d.hasRendered || !f ? g() : f && setTimeout(g,
                        f)
            });
            if (L)
                b = a.getLinePath(L), a.axisLine ? a.axisLine.animate({d: b}) : a.axisLine = e.path(b).attr({stroke: f.lineColor, "stroke-width": L, zIndex: 7}).add(a.axisGroup), a.axisLine[u ? "show" : "hide"]();
            if (k && u)
                k[k.isNew ? "attr" : "animate"](a.getTitlePosition()), k.isNew = !1;
            o && o.enabled && a.renderStackTotals();
            a.isDirty = !1
        }, redraw: function () {
            this.render();
            q(this.plotLinesAndBands, function (a) {
                a.render()
            });
            q(this.series, function (a) {
                a.isDirty = !0
            })
        }, destroy: function (a) {
            var b = this, c = b.stacks, d, e = b.plotLinesAndBands;
            a || X(b);
            for (d in c)
                Pa(c[d]), c[d] = null;
            q([b.ticks, b.minorTicks, b.alternateBands], function (a) {
                Pa(a)
            });
            for (a = e.length; a--; )
                e[a].destroy();
            q("stackTotalGroup,axisLine,axisTitle,axisGroup,cross,gridGroup,labelGroup".split(","), function (a) {
                b[a] && (b[a] = b[a].destroy())
            });
            this.cross && this.cross.destroy()
        }, drawCrosshair: function (a, b) {
            if (this.crosshair)
                if ((s(b) || !p(this.crosshair.snap, !0)) === !1)
                    this.hideCrosshair();
                else {
                    var c, d = this.crosshair, e = d.animation;
                    p(d.snap, !0) ? s(b) && (c = this.chart.inverted != this.horiz ? b.plotX :
                            this.len - b.plotY) : c = this.horiz ? a.chartX - this.pos : this.len - a.chartY + this.pos;
                    c = this.isRadial ? this.getPlotLinePath(this.isXAxis ? b.x : p(b.stackY, b.y)) : this.getPlotLinePath(null, null, null, null, c);
                    if (c === null)
                        this.hideCrosshair();
                    else if (this.cross)
                        this.cross.attr({visibility: "visible"})[e ? "animate" : "attr"]({d: c}, e);
                    else {
                        e = {"stroke-width": d.width || 1, stroke: d.color || "#C0C0C0", zIndex: d.zIndex || 2};
                        if (d.dashStyle)
                            e.dashstyle = d.dashStyle;
                        this.cross = this.chart.renderer.path(c).attr(e).add()
                    }
                }
        }, hideCrosshair: function () {
            this.cross &&
                    this.cross.hide()
        }};
    r(ma.prototype, {getPlotBandPath: function (a, b) {
            var c = this.getPlotLinePath(b), d = this.getPlotLinePath(a);
            d && c ? d.push(c[4], c[5], c[1], c[2]) : d = null;
            return d
        }, addPlotBand: function (a) {
            return this.addPlotBandOrLine(a, "plotBands")
        }, addPlotLine: function (a) {
            return this.addPlotBandOrLine(a, "plotLines")
        }, addPlotBandOrLine: function (a, b) {
            var c = (new R.PlotLineOrBand(this, a)).render(), d = this.userOptions;
            c && (b && (d[b] = d[b] || [], d[b].push(a)), this.plotLinesAndBands.push(c));
            return c
        }, removePlotBandOrLine: function (a) {
            for (var b =
                    this.plotLinesAndBands, c = this.options, d = this.userOptions, e = b.length; e--; )
                b[e].id === a && b[e].destroy();
            q([c.plotLines || [], d.plotLines || [], c.plotBands || [], d.plotBands || []], function (b) {
                for (e = b.length; e--; )
                    b[e].id === a && ka(b, b[e])
            })
        }});
    ma.prototype.getTimeTicks = function (a, b, c, d) {
        var e = [], f = {}, g = Q.global.useUTC, h, i = new Date(b - Sa), j = a.unitRange, k = a.count;
        if (s(b)) {
            j >= A.second && (i.setMilliseconds(0), i.setSeconds(j >= A.minute ? 0 : k * U(i.getSeconds() / k)));
            if (j >= A.minute)
                i[Db](j >= A.hour ? 0 : k * U(i[pb]() / k));
            if (j >= A.hour)
                i[Eb](j >=
                        A.day ? 0 : k * U(i[qb]() / k));
            if (j >= A.day)
                i[sb](j >= A.month ? 1 : k * U(i[Ya]() / k));
            j >= A.month && (i[Fb](j >= A.year ? 0 : k * U(i[gb]() / k)), h = i[hb]());
            j >= A.year && (h -= h % k, i[Gb](h));
            if (j === A.week)
                i[sb](i[Ya]() - i[rb]() + p(d, 1));
            b = 1;
            Sa && (i = new Date(i.getTime() + Sa));
            h = i[hb]();
            for (var d = i.getTime(), l = i[gb](), n = i[Ya](), m = g ? Sa : (864E5 + i.getTimezoneOffset() * 6E4) % 864E5; d < c; )
                e.push(d), j === A.year ? d = fb(h + b * k, 0) : j === A.month ? d = fb(h, l + b * k) : !g && (j === A.day || j === A.week) ? d = fb(h, l, n + b * k * (j === A.day ? 1 : 7)) : d += j * k, b++;
            e.push(d);
            q(wb(e, function (a) {
                return j <=
                        A.hour && a % A.day === m
            }), function (a) {
                f[a] = "day"
            })
        }
        e.info = r(a, {higherRanks: f, totalRange: j * k});
        return e
    };
    ma.prototype.normalizeTimeTickInterval = function (a, b) {
        var c = b || [["millisecond", [1, 2, 5, 10, 20, 25, 50, 100, 200, 500]], ["second", [1, 2, 5, 10, 15, 30]], ["minute", [1, 2, 5, 10, 15, 30]], ["hour", [1, 2, 3, 4, 6, 8, 12]], ["day", [1, 2]], ["week", [1, 2]], ["month", [1, 2, 3, 4, 6]], ["year", null]], d = c[c.length - 1], e = A[d[0]], f = d[1], g;
        for (g = 0; g < c.length; g++)
            if (d = c[g], e = A[d[0]], f = d[1], c[g + 1] && a <= (e * f[f.length - 1] + A[c[g + 1][0]]) / 2)
                break;
        e === A.year &&
                a < 5 * e && (f = [1, 2, 5]);
        c = nb(a / e, f, d[0] === "year" ? u(mb(a / e), 1) : 1);
        return{unitRange: e, count: c, unitName: d[0]}
    };
    ma.prototype.getLogTickPositions = function (a, b, c, d) {
        var e = this.options, f = this.len, g = [];
        if (!d)
            this._minorAutoInterval = null;
        if (a >= 0.5)
            a = w(a), g = this.getLinearTickPositions(a, b, c);
        else if (a >= 0.08)
            for (var f = U(b), h, i, j, k, l, e = a > 0.3 ? [1, 2, 4] : a > 0.15 ? [1, 2, 4, 6, 8] : [1, 2, 3, 4, 5, 6, 7, 8, 9]; f < c + 1 && !l; f++) {
                i = e.length;
                for (h = 0; h < i && !l; h++)
                    j = za(ja(f) * e[h]), j > b && (!d || k <= c) && k !== t && g.push(k), k > c && (l = !0), k = j
            }
        else if (b = ja(b),
                c = ja(c), a = e[d ? "minorTickInterval" : "tickInterval"], a = p(a === "auto" ? null : a, this._minorAutoInterval, (c - b) * (e.tickPixelInterval / (d ? 5 : 1)) / ((d ? f / this.tickPositions.length : f) || 1)), a = nb(a, null, mb(a)), g = Va(this.getLinearTickPositions(a, b, c), za), !d)
            this._minorAutoInterval = a / 5;
        if (!d)
            this.tickInterval = a;
        return g
    };
    var Nb = R.Tooltip = function () {
        this.init.apply(this, arguments)
    };
    Nb.prototype = {init: function (a, b) {
            var c = b.borderWidth, d = b.style, e = z(d.padding);
            this.chart = a;
            this.options = b;
            this.crosshairs = [];
            this.now = {x: 0,
                y: 0};
            this.isHidden = !0;
            this.label = a.renderer.label("", 0, 0, b.shape || "callout", null, null, b.useHTML, null, "tooltip").attr({padding: e, fill: b.backgroundColor, "stroke-width": c, r: b.borderRadius, zIndex: 8}).css(d).css({padding: 0}).add().attr({y: -9999});
            ga || this.label.shadow(b.shadow);
            this.shared = b.shared
        }, destroy: function () {
            if (this.label)
                this.label = this.label.destroy();
            clearTimeout(this.hideTimer);
            clearTimeout(this.tooltipTimeout)
        }, move: function (a, b, c, d) {
            var e = this, f = e.now, g = e.options.animation !== !1 && !e.isHidden &&
                    (N(a - f.x) > 1 || N(b - f.y) > 1), h = e.followPointer || e.len > 1;
            r(f, {x: g ? (2 * f.x + a) / 3 : a, y: g ? (f.y + b) / 2 : b, anchorX: h ? t : g ? (2 * f.anchorX + c) / 3 : c, anchorY: h ? t : g ? (f.anchorY + d) / 2 : d});
            e.label.attr(f);
            if (g)
                clearTimeout(this.tooltipTimeout), this.tooltipTimeout = setTimeout(function () {
                    e && e.move(a, b, c, d)
                }, 32)
        }, hide: function () {
            var a = this, b;
            clearTimeout(this.hideTimer);
            if (!this.isHidden)
                b = this.chart.hoverPoints, this.hideTimer = setTimeout(function () {
                    a.label.fadeOut();
                    a.isHidden = !0
                }, p(this.options.hideDelay, 500)), b && q(b, function (a) {
                    a.setState()
                }),
                        this.chart.hoverPoints = null
        }, getAnchor: function (a, b) {
            var c, d = this.chart, e = d.inverted, f = d.plotTop, g = 0, h = 0, i, a = ra(a);
            c = a[0].tooltipPos;
            this.followPointer && b && (b.chartX === t && (b = d.pointer.normalize(b)), c = [b.chartX - d.plotLeft, b.chartY - f]);
            c || (q(a, function (a) {
                i = a.series.yAxis;
                g += a.plotX;
                h += (a.plotLow ? (a.plotLow + a.plotHigh) / 2 : a.plotY) + (!e && i ? i.top - f : 0)
            }), g /= a.length, h /= a.length, c = [e ? d.plotWidth - h : g, this.shared && !e && a.length > 1 && b ? b.chartY - f : e ? d.plotHeight - g : h]);
            return Va(c, w)
        }, getPosition: function (a, b, c) {
            var d =
                    this.chart, e = this.distance, f = {}, g, h = ["y", d.chartHeight, b, c.plotY + d.plotTop], i = ["x", d.chartWidth, a, c.plotX + d.plotLeft], j = c.ttBelow || d.inverted && !c.negative || !d.inverted && c.negative, k = function (a, b, c, d) {
                var g = c < d - e, b = d + e + c < b, c = d - e - c;
                d += e;
                if (j && b)
                    f[a] = d;
                else if (!j && g)
                    f[a] = c;
                else if (g)
                    f[a] = c;
                else if (b)
                    f[a] = d;
                else
                    return!1
            }, l = function (a, b, c, d) {
                if (d < e || d > b - e)
                    return!1;
                else
                    f[a] = d < c / 2 ? 1 : d > b - c / 2 ? b - c - 2 : d - c / 2
            }, n = function (a) {
                var b = h;
                h = i;
                i = b;
                g = a
            }, m = function () {
                k.apply(0, h) !== !1 ? l.apply(0, i) === !1 && !g && (n(!0), m()) :
                        g ? f.x = f.y = 0 : (n(!0), m())
            };
            (d.inverted || this.len > 1) && n();
            m();
            return f
        }, defaultFormatter: function (a) {
            var b = this.points || ra(this), c = b[0].series, d;
            d = [a.tooltipHeaderFormatter(b[0])];
            q(b, function (a) {
                c = a.series;
                d.push(c.tooltipFormatter && c.tooltipFormatter(a) || a.point.tooltipFormatter(c.tooltipOptions.pointFormat))
            });
            d.push(a.options.footerFormat || "");
            return d.join("")
        }, refresh: function (a, b) {
            var c = this.chart, d = this.label, e = this.options, f, g, h = {}, i, j = [];
            i = e.formatter || this.defaultFormatter;
            var h = c.hoverPoints,
                    k, l = this.shared;
            clearTimeout(this.hideTimer);
            this.followPointer = ra(a)[0].series.tooltipOptions.followPointer;
            g = this.getAnchor(a, b);
            f = g[0];
            g = g[1];
            l && (!a.series || !a.series.noSharedTooltip) ? (c.hoverPoints = a, h && q(h, function (a) {
                a.setState()
            }), q(a, function (a) {
                a.setState("hover");
                j.push(a.getLabelConfig())
            }), h = {x: a[0].category, y: a[0].y}, h.points = j, this.len = j.length, a = a[0]) : h = a.getLabelConfig();
            i = i.call(h, this);
            h = a.series;
            this.distance = p(h.tooltipOptions.distance, 16);
            i === !1 ? this.hide() : (this.isHidden && (cb(d),
                    d.attr("opacity", 1).show()), d.attr({text: i}), k = e.borderColor || a.color || h.color || "#606060", d.attr({stroke: k}), this.updatePosition({plotX: f, plotY: g, negative: a.negative, ttBelow: a.ttBelow}), this.isHidden = !1);
            J(c, "tooltipRefresh", {text: i, x: f + c.plotLeft, y: g + c.plotTop, borderColor: k})
        }, updatePosition: function (a) {
            var b = this.chart, c = this.label, c = (this.options.positioner || this.getPosition).call(this, c.width, c.height, a);
            this.move(w(c.x), w(c.y), a.plotX + b.plotLeft, a.plotY + b.plotTop)
        }, tooltipHeaderFormatter: function (a) {
            var b =
                    a.series, c = b.tooltipOptions, d = c.dateTimeLabelFormats, e = c.xDateFormat, f = b.xAxis, g = f && f.options.type === "datetime" && ia(a.key), c = c.headerFormat, f = f && f.closestPointRange, h;
            if (g && !e) {
                if (f)
                    for (h in A) {
                        if (A[h] >= f || A[h] <= A.day && a.key % A[h] > 0) {
                            e = d[h];
                            break
                        }
                    }
                else
                    e = d.day;
                e = e || d.year
            }
            g && e && (c = c.replace("{point.key}", "{point.key:" + e + "}"));
            return Ja(c, {point: a, series: b})
        }};
    var pa;
    ab = v.documentElement.ontouchstart !== t;
    var Xa = R.Pointer = function (a, b) {
        this.init(a, b)
    };
    Xa.prototype = {init: function (a, b) {
            var c = b.chart, d =
                    c.events, e = ga ? "" : c.zoomType, c = a.inverted, f;
            this.options = b;
            this.chart = a;
            this.zoomX = f = /x/.test(e);
            this.zoomY = e = /y/.test(e);
            this.zoomHor = f && !c || e && c;
            this.zoomVert = e && !c || f && c;
            this.hasZoom = f || e;
            this.runChartClick = d && !!d.click;
            this.pinchDown = [];
            this.lastValidTouch = {};
            if (R.Tooltip && b.tooltip.enabled)
                a.tooltip = new Nb(a, b.tooltip), this.followTouchMove = b.tooltip.followTouchMove;
            this.setDOMEvents()
        }, normalize: function (a, b) {
            var c, d, a = a || window.event, a = Tb(a);
            if (!a.target)
                a.target = a.srcElement;
            d = a.touches ? a.touches.length ?
                    a.touches.item(0) : a.changedTouches[0] : a;
            if (!b)
                this.chartPosition = b = Sb(this.chart.container);
            d.pageX === t ? (c = u(a.x, a.clientX - b.left), d = a.y) : (c = d.pageX - b.left, d = d.pageY - b.top);
            return r(a, {chartX: w(c), chartY: w(d)})
        }, getCoordinates: function (a) {
            var b = {xAxis: [], yAxis: []};
            q(this.chart.axes, function (c) {
                b[c.isXAxis ? "xAxis" : "yAxis"].push({axis: c, value: c.toValue(a[c.horiz ? "chartX" : "chartY"])})
            });
            return b
        }, getIndex: function (a) {
            var b = this.chart;
            return b.inverted ? b.plotHeight + b.plotTop - a.chartY : a.chartX - b.plotLeft
        },
        runPointActions: function (a) {
            var b = this.chart, c = b.series, d = b.tooltip, e, f, g = b.hoverPoint, h = b.hoverSeries, i, j, k = b.chartWidth, l = this.getIndex(a);
            if (d && this.options.tooltip.shared && (!h || !h.noSharedTooltip)) {
                f = [];
                i = c.length;
                for (j = 0; j < i; j++)
                    if (c[j].visible && c[j].options.enableMouseTracking !== !1 && !c[j].noSharedTooltip && c[j].singularTooltips !== !0 && c[j].tooltipPoints.length && (e = c[j].tooltipPoints[l]) && e.series)
                        e._dist = N(l - e.clientX), k = G(k, e._dist), f.push(e);
                for (i = f.length; i--; )
                    f[i]._dist > k && f.splice(i, 1);
                if (f.length &&
                        f[0].clientX !== this.hoverX)
                    d.refresh(f, a), this.hoverX = f[0].clientX
            }
            c = h && h.tooltipOptions.followPointer;
            if (h && h.tracker && !c) {
                if ((e = h.tooltipPoints[l]) && e !== g)
                    e.onMouseOver(a)
            } else
                d && c && !d.isHidden && (h = d.getAnchor([{}], a), d.updatePosition({plotX: h[0], plotY: h[1]}));
            if (d && !this._onDocumentMouseMove)
                this._onDocumentMouseMove = function (a) {
                    if (W[pa])
                        W[pa].pointer.onDocumentMouseMove(a)
                }, K(v, "mousemove", this._onDocumentMouseMove);
            q(b.axes, function (b) {
                b.drawCrosshair(a, p(e, g))
            })
        }, reset: function (a) {
            var b = this.chart,
                    c = b.hoverSeries, d = b.hoverPoint, e = b.tooltip, f = e && e.shared ? b.hoverPoints : d;
            (a = a && e && f) && ra(f)[0].plotX === t && (a = !1);
            if (a)
                e.refresh(f), d && d.setState(d.state, !0);
            else {
                if (d)
                    d.onMouseOut();
                if (c)
                    c.onMouseOut();
                e && e.hide();
                if (this._onDocumentMouseMove)
                    X(v, "mousemove", this._onDocumentMouseMove), this._onDocumentMouseMove = null;
                q(b.axes, function (a) {
                    a.hideCrosshair()
                });
                this.hoverX = null
            }
        }, scaleGroups: function (a, b) {
            var c = this.chart, d;
            q(c.series, function (e) {
                d = a || e.getPlotBox();
                e.xAxis && e.xAxis.zoomEnabled && (e.group.attr(d),
                        e.markerGroup && (e.markerGroup.attr(d), e.markerGroup.clip(b ? c.clipRect : null)), e.dataLabelsGroup && e.dataLabelsGroup.attr(d))
            });
            c.clipRect.attr(b || c.clipBox)
        }, dragStart: function (a) {
            var b = this.chart;
            b.mouseIsDown = a.type;
            b.cancelClick = !1;
            b.mouseDownX = this.mouseDownX = a.chartX;
            b.mouseDownY = this.mouseDownY = a.chartY
        }, drag: function (a) {
            var b = this.chart, c = b.options.chart, d = a.chartX, e = a.chartY, f = this.zoomHor, g = this.zoomVert, h = b.plotLeft, i = b.plotTop, j = b.plotWidth, k = b.plotHeight, l, n = this.mouseDownX, m = this.mouseDownY,
                    o = c.panKey && a[c.panKey + "Key"];
            d < h ? d = h : d > h + j && (d = h + j);
            e < i ? e = i : e > i + k && (e = i + k);
            this.hasDragged = Math.sqrt(Math.pow(n - d, 2) + Math.pow(m - e, 2));
            if (this.hasDragged > 10) {
                l = b.isInsidePlot(n - h, m - i);
                if (b.hasCartesianSeries && (this.zoomX || this.zoomY) && l && !o && !this.selectionMarker)
                    this.selectionMarker = b.renderer.rect(h, i, f ? 1 : j, g ? 1 : k, 0).attr({fill: c.selectionMarkerFill || "rgba(69,114,167,0.25)", zIndex: 7}).add();
                this.selectionMarker && f && (d -= n, this.selectionMarker.attr({width: N(d), x: (d > 0 ? 0 : d) + n}));
                this.selectionMarker &&
                        g && (d = e - m, this.selectionMarker.attr({height: N(d), y: (d > 0 ? 0 : d) + m}));
                l && !this.selectionMarker && c.panning && b.pan(a, c.panning)
            }
        }, drop: function (a) {
            var b = this.chart, c = this.hasPinched;
            if (this.selectionMarker) {
                var d = {xAxis: [], yAxis: [], originalEvent: a.originalEvent || a}, e = this.selectionMarker, f = e.attr ? e.attr("x") : e.x, g = e.attr ? e.attr("y") : e.y, h = e.attr ? e.attr("width") : e.width, i = e.attr ? e.attr("height") : e.height, j;
                if (this.hasDragged || c)
                    q(b.axes, function (b) {
                        if (b.zoomEnabled) {
                            var c = b.horiz, e = a.type === "touchend" ? b.minPixelPadding :
                                    0, m = b.toValue((c ? f : g) + e), c = b.toValue((c ? f + h : g + i) - e);
                            !isNaN(m) && !isNaN(c) && (d[b.coll].push({axis: b, min: G(m, c), max: u(m, c)}), j = !0)
                        }
                    }), j && J(b, "selection", d, function (a) {
                        b.zoom(r(a, c ? {animation: !1} : null))
                    });
                this.selectionMarker = this.selectionMarker.destroy();
                c && this.scaleGroups()
            }
            if (b)
                F(b.container, {cursor: b._cursor}), b.cancelClick = this.hasDragged > 10, b.mouseIsDown = this.hasDragged = this.hasPinched = !1, this.pinchDown = []
        }, onContainerMouseDown: function (a) {
            a = this.normalize(a);
            a.preventDefault && a.preventDefault();
            this.dragStart(a)
        }, onDocumentMouseUp: function (a) {
            W[pa] && W[pa].pointer.drop(a)
        }, onDocumentMouseMove: function (a) {
            var b = this.chart, c = this.chartPosition, d = b.hoverSeries, a = this.normalize(a, c);
            c && d && !this.inClass(a.target, "highcharts-tracker") && !b.isInsidePlot(a.chartX - b.plotLeft, a.chartY - b.plotTop) && this.reset()
        }, onContainerMouseLeave: function () {
            var a = W[pa];
            if (a)
                a.pointer.reset(), a.pointer.chartPosition = null
        }, onContainerMouseMove: function (a) {
            var b = this.chart;
            pa = b.index;
            a = this.normalize(a);
            b.mouseIsDown ===
                    "mousedown" && this.drag(a);
            (this.inClass(a.target, "highcharts-tracker") || b.isInsidePlot(a.chartX - b.plotLeft, a.chartY - b.plotTop)) && !b.openMenu && this.runPointActions(a)
        }, inClass: function (a, b) {
            for (var c; a; ) {
                if (c = C(a, "class"))
                    if (c.indexOf(b) !== -1)
                        return!0;
                    else if (c.indexOf("highcharts-container") !== -1)
                        return!1;
                a = a.parentNode
            }
        }, onTrackerMouseOut: function (a) {
            var b = this.chart.hoverSeries, c = (a = a.relatedTarget || a.toElement) && a.point && a.point.series;
            if (b && !b.options.stickyTracking && !this.inClass(a, "highcharts-tooltip") &&
                    c !== b)
                b.onMouseOut()
        }, onContainerClick: function (a) {
            var b = this.chart, c = b.hoverPoint, d = b.plotLeft, e = b.plotTop, a = this.normalize(a);
            a.cancelBubble = !0;
            b.cancelClick || (c && this.inClass(a.target, "highcharts-tracker") ? (J(c.series, "click", r(a, {point: c})), b.hoverPoint && c.firePointEvent("click", a)) : (r(a, this.getCoordinates(a)), b.isInsidePlot(a.chartX - d, a.chartY - e) && J(b, "click", a)))
        }, setDOMEvents: function () {
            var a = this, b = a.chart.container;
            b.onmousedown = function (b) {
                a.onContainerMouseDown(b)
            };
            b.onmousemove = function (b) {
                a.onContainerMouseMove(b)
            };
            b.onclick = function (b) {
                a.onContainerClick(b)
            };
            K(b, "mouseleave", a.onContainerMouseLeave);
            bb === 1 && K(v, "mouseup", a.onDocumentMouseUp);
            if (ab)
                b.ontouchstart = function (b) {
                    a.onContainerTouchStart(b)
                }, b.ontouchmove = function (b) {
                    a.onContainerTouchMove(b)
                }, bb === 1 && K(v, "touchend", a.onDocumentTouchEnd)
        }, destroy: function () {
            var a;
            X(this.chart.container, "mouseleave", this.onContainerMouseLeave);
            bb || (X(v, "mouseup", this.onDocumentMouseUp), X(v, "touchend", this.onDocumentTouchEnd));
            clearInterval(this.tooltipTimeout);
            for (a in this)
                this[a] =
                        null
        }};
    r(R.Pointer.prototype, {pinchTranslate: function (a, b, c, d, e, f) {
            (this.zoomHor || this.pinchHor) && this.pinchTranslateDirection(!0, a, b, c, d, e, f);
            (this.zoomVert || this.pinchVert) && this.pinchTranslateDirection(!1, a, b, c, d, e, f)
        }, pinchTranslateDirection: function (a, b, c, d, e, f, g, h) {
            var i = this.chart, j = a ? "x" : "y", k = a ? "X" : "Y", l = "chart" + k, n = a ? "width" : "height", m = i["plot" + (a ? "Left" : "Top")], o, p, q = h || 1, r = i.inverted, B = i.bounds[a ? "h" : "v"], t = b.length === 1, u = b[0][l], s = c[0][l], w = !t && b[1][l], v = !t && c[1][l], x, c = function () {
                !t &&
                        N(u - w) > 20 && (q = h || N(s - v) / N(u - w));
                p = (m - s) / q + u;
                o = i["plot" + (a ? "Width" : "Height")] / q
            };
            c();
            b = p;
            b < B.min ? (b = B.min, x = !0) : b + o > B.max && (b = B.max - o, x = !0);
            x ? (s -= 0.8 * (s - g[j][0]), t || (v -= 0.8 * (v - g[j][1])), c()) : g[j] = [s, v];
            r || (f[j] = p - m, f[n] = o);
            f = r ? 1 / q : q;
            e[n] = o;
            e[j] = b;
            d[r ? a ? "scaleY" : "scaleX" : "scale" + k] = q;
            d["translate" + k] = f * m + (s - f * u)
        }, pinch: function (a) {
            var b = this, c = b.chart, d = b.pinchDown, e = b.followTouchMove, f = a.touches, g = f.length, h = b.lastValidTouch, i = b.hasZoom, j = b.selectionMarker, k = {}, l = g === 1 && (b.inClass(a.target, "highcharts-tracker") &&
                    c.runTrackerClick || c.runChartClick), n = {};
            (i || e) && !l && a.preventDefault();
            Va(f, function (a) {
                return b.normalize(a)
            });
            if (a.type === "touchstart")
                q(f, function (a, b) {
                    d[b] = {chartX: a.chartX, chartY: a.chartY}
                }), h.x = [d[0].chartX, d[1] && d[1].chartX], h.y = [d[0].chartY, d[1] && d[1].chartY], q(c.axes, function (a) {
                    if (a.zoomEnabled) {
                        var b = c.bounds[a.horiz ? "h" : "v"], d = a.minPixelPadding, e = a.toPixels(p(a.options.min, a.dataMin)), f = a.toPixels(p(a.options.max, a.dataMax)), g = G(e, f), e = u(e, f);
                        b.min = G(a.pos, g - d);
                        b.max = u(a.pos + a.len, e +
                                d)
                    }
                });
            else if (d.length) {
                if (!j)
                    b.selectionMarker = j = r({destroy: sa}, c.plotBox);
                b.pinchTranslate(d, f, k, j, n, h);
                b.hasPinched = i;
                b.scaleGroups(k, n);
                !i && e && g === 1 && this.runPointActions(b.normalize(a))
            }
        }, onContainerTouchStart: function (a) {
            var b = this.chart;
            pa = b.index;
            a.touches.length === 1 ? (a = this.normalize(a), b.isInsidePlot(a.chartX - b.plotLeft, a.chartY - b.plotTop) ? (this.runPointActions(a), this.pinch(a)) : this.reset()) : a.touches.length === 2 && this.pinch(a)
        }, onContainerTouchMove: function (a) {
            (a.touches.length === 1 || a.touches.length ===
                    2) && this.pinch(a)
        }, onDocumentTouchEnd: function (a) {
            W[pa] && W[pa].pointer.drop(a)
        }});
    if (E.PointerEvent || E.MSPointerEvent) {
        var ua = {}, Ab = !!E.PointerEvent, Xb = function () {
            var a, b = [];
            b.item = function (a) {
                return this[a]
            };
            for (a in ua)
                ua.hasOwnProperty(a) && b.push({pageX: ua[a].pageX, pageY: ua[a].pageY, target: ua[a].target});
            return b
        }, Bb = function (a, b, c, d) {
            a = a.originalEvent || a;
            if ((a.pointerType === "touch" || a.pointerType === a.MSPOINTER_TYPE_TOUCH) && W[pa])
                d(a), d = W[pa].pointer, d[b]({type: c, target: a.currentTarget, preventDefault: sa,
                    touches: Xb()})
        };
        r(Xa.prototype, {onContainerPointerDown: function (a) {
                Bb(a, "onContainerTouchStart", "touchstart", function (a) {
                    ua[a.pointerId] = {pageX: a.pageX, pageY: a.pageY, target: a.currentTarget}
                })
            }, onContainerPointerMove: function (a) {
                Bb(a, "onContainerTouchMove", "touchmove", function (a) {
                    ua[a.pointerId] = {pageX: a.pageX, pageY: a.pageY};
                    if (!ua[a.pointerId].target)
                        ua[a.pointerId].target = a.currentTarget
                })
            }, onDocumentPointerUp: function (a) {
                Bb(a, "onContainerTouchEnd", "touchend", function (a) {
                    delete ua[a.pointerId]
                })
            },
            batchMSEvents: function (a) {
                a(this.chart.container, Ab ? "pointerdown" : "MSPointerDown", this.onContainerPointerDown);
                a(this.chart.container, Ab ? "pointermove" : "MSPointerMove", this.onContainerPointerMove);
                a(v, Ab ? "pointerup" : "MSPointerUp", this.onDocumentPointerUp)
            }});
        Na(Xa.prototype, "init", function (a, b, c) {
            a.call(this, b, c);
            (this.hasZoom || this.followTouchMove) && F(b.container, {"-ms-touch-action": S, "touch-action": S})
        });
        Na(Xa.prototype, "setDOMEvents", function (a) {
            a.apply(this);
            (this.hasZoom || this.followTouchMove) &&
                    this.batchMSEvents(K)
        });
        Na(Xa.prototype, "destroy", function (a) {
            this.batchMSEvents(X);
            a.call(this)
        })
    }
    var lb = R.Legend = function (a, b) {
        this.init(a, b)
    };
    lb.prototype = {init: function (a, b) {
            var c = this, d = b.itemStyle, e = p(b.padding, 8), f = b.itemMarginTop || 0;
            this.options = b;
            if (b.enabled)
                c.itemStyle = d, c.itemHiddenStyle = y(d, b.itemHiddenStyle), c.itemMarginTop = f, c.padding = e, c.initialItemX = e, c.initialItemY = e - 5, c.maxItemWidth = 0, c.chart = a, c.itemHeight = 0, c.lastLineHeight = 0, c.symbolWidth = p(b.symbolWidth, 16), c.pages = [], c.render(),
                        K(c.chart, "endResize", function () {
                            c.positionCheckboxes()
                        })
        }, colorizeItem: function (a, b) {
            var c = this.options, d = a.legendItem, e = a.legendLine, f = a.legendSymbol, g = this.itemHiddenStyle.color, c = b ? c.itemStyle.color : g, h = b ? a.legendColor || a.color || "#CCC" : g, g = a.options && a.options.marker, i = {fill: h}, j;
            d && d.css({fill: c, color: c});
            e && e.attr({stroke: h});
            if (f) {
                if (g && f.isMarker)
                    for (j in i.stroke = h, g = a.convertAttribs(g), g)
                        d = g[j], d !== t && (i[j] = d);
                f.attr(i)
            }
        }, positionItem: function (a) {
            var b = this.options, c = b.symbolPadding, b = !b.rtl,
                    d = a._legendItemPos, e = d[0], d = d[1], f = a.checkbox;
            a.legendGroup && a.legendGroup.translate(b ? e : this.legendWidth - e - 2 * c - 4, d);
            if (f)
                f.x = e, f.y = d
        }, destroyItem: function (a) {
            var b = a.checkbox;
            q(["legendItem", "legendLine", "legendSymbol", "legendGroup"], function (b) {
                a[b] && (a[b] = a[b].destroy())
            });
            b && Qa(a.checkbox)
        }, destroy: function () {
            var a = this.group, b = this.box;
            if (b)
                this.box = b.destroy();
            if (a)
                this.group = a.destroy()
        }, positionCheckboxes: function (a) {
            var b = this.group.alignAttr, c, d = this.clipHeight || this.legendHeight;
            if (b)
                c =
                        b.translateY, q(this.allItems, function (e) {
                            var f = e.checkbox, g;
                            f && (g = c + f.y + (a || 0) + 3, F(f, {left: b.translateX + e.checkboxOffset + f.x - 20 + "px", top: g + "px", display: g > c - 6 && g < c + d - 6 ? "" : S}))
                        })
        }, renderTitle: function () {
            var a = this.padding, b = this.options.title, c = 0;
            if (b.text) {
                if (!this.title)
                    this.title = this.chart.renderer.label(b.text, a - 3, a - 4, null, null, null, null, null, "legend-title").attr({zIndex: 1}).css(b.style).add(this.group);
                a = this.title.getBBox();
                c = a.height;
                this.offsetWidth = a.width;
                this.contentGroup.attr({translateY: c})
            }
            this.titleHeight =
                    c
        }, renderItem: function (a) {
            var b = this.chart, c = b.renderer, d = this.options, e = d.layout === "horizontal", f = this.symbolWidth, g = d.symbolPadding, h = this.itemStyle, i = this.itemHiddenStyle, j = this.padding, k = e ? p(d.itemDistance, 20) : 0, l = !d.rtl, n = d.width, m = d.itemMarginBottom || 0, o = this.itemMarginTop, q = this.initialItemX, r = a.legendItem, t = a.series && a.series.drawLegendSymbol ? a.series : a, B = t.options, B = this.createCheckboxForItem && B && B.showCheckbox, s = d.useHTML;
            if (!r) {
                a.legendGroup = c.g("legend-item").attr({zIndex: 1}).add(this.scrollGroup);
                a.legendItem = r = c.text(d.labelFormat ? Ja(d.labelFormat, a) : d.labelFormatter.call(a), l ? f + g : -g, this.baseline || 0, s).css(y(a.visible ? h : i)).attr({align: l ? "left" : "right", zIndex: 2}).add(a.legendGroup);
                if (!this.baseline)
                    this.baseline = c.fontMetrics(h.fontSize, r).f + 3 + o, r.attr("y", this.baseline);
                t.drawLegendSymbol(this, a);
                this.setItemEvents && this.setItemEvents(a, r, s, h, i);
                this.colorizeItem(a, a.visible);
                B && this.createCheckboxForItem(a)
            }
            c = r.getBBox();
            f = a.checkboxOffset = d.itemWidth || a.legendItemWidth || f + g + c.width +
                    k + (B ? 20 : 0);
            this.itemHeight = g = w(a.legendItemHeight || c.height);
            if (e && this.itemX - q + f > (n || b.chartWidth - 2 * j - q - d.x))
                this.itemX = q, this.itemY += o + this.lastLineHeight + m, this.lastLineHeight = 0;
            this.maxItemWidth = u(this.maxItemWidth, f);
            this.lastItemY = o + this.itemY + m;
            this.lastLineHeight = u(g, this.lastLineHeight);
            a._legendItemPos = [this.itemX, this.itemY];
            e ? this.itemX += f : (this.itemY += o + g + m, this.lastLineHeight = g);
            this.offsetWidth = n || u((e ? this.itemX - q - k : f) + j, this.offsetWidth)
        }, getAllItems: function () {
            var a = [];
            q(this.chart.series,
                    function (b) {
                        var c = b.options;
                        if (p(c.showInLegend, !s(c.linkedTo) ? t : !1, !0))
                            a = a.concat(b.legendItems || (c.legendType === "point" ? b.data : b))
                    });
            return a
        }, render: function () {
            var a = this, b = a.chart, c = b.renderer, d = a.group, e, f, g, h, i = a.box, j = a.options, k = a.padding, l = j.borderWidth, n = j.backgroundColor;
            a.itemX = a.initialItemX;
            a.itemY = a.initialItemY;
            a.offsetWidth = 0;
            a.lastItemY = 0;
            if (!d)
                a.group = d = c.g("legend").attr({zIndex: 7}).add(), a.contentGroup = c.g().attr({zIndex: 1}).add(d), a.scrollGroup = c.g().add(a.contentGroup);
            a.renderTitle();
            e = a.getAllItems();
            ob(e, function (a, b) {
                return(a.options && a.options.legendIndex || 0) - (b.options && b.options.legendIndex || 0)
            });
            j.reversed && e.reverse();
            a.allItems = e;
            a.display = f = !!e.length;
            q(e, function (b) {
                a.renderItem(b)
            });
            g = j.width || a.offsetWidth;
            h = a.lastItemY + a.lastLineHeight + a.titleHeight;
            h = a.handleOverflow(h);
            if (l || n) {
                g += k;
                h += k;
                if (i) {
                    if (g > 0 && h > 0)
                        i[i.isNew ? "attr" : "animate"](i.crisp({width: g, height: h})), i.isNew = !1
                } else
                    a.box = i = c.rect(0, 0, g, h, j.borderRadius, l || 0).attr({stroke: j.borderColor, "stroke-width": l ||
                                0, fill: n || S}).add(d).shadow(j.shadow), i.isNew = !0;
                i[f ? "show" : "hide"]()
            }
            a.legendWidth = g;
            a.legendHeight = h;
            q(e, function (b) {
                a.positionItem(b)
            });
            f && d.align(r({width: g, height: h}, j), !0, "spacingBox");
            b.isResizing || this.positionCheckboxes()
        }, handleOverflow: function (a) {
            var b = this, c = this.chart, d = c.renderer, e = this.options, f = e.y, f = c.spacingBox.height + (e.verticalAlign === "top" ? -f : f) - this.padding, g = e.maxHeight, h, i = this.clipRect, j = e.navigation, k = p(j.animation, !0), l = j.arrowSize || 12, n = this.nav, m = this.pages, o, r = this.allItems;
            e.layout === "horizontal" && (f /= 2);
            g && (f = G(f, g));
            m.length = 0;
            if (a > f && !e.useHTML) {
                this.clipHeight = h = u(f - 20 - this.titleHeight - this.padding, 0);
                this.currentPage = p(this.currentPage, 1);
                this.fullHeight = a;
                q(r, function (a, b) {
                    var c = a._legendItemPos[1], d = w(a.legendItem.getBBox().height), e = m.length;
                    if (!e || c - m[e - 1] > h && (o || c) !== m[e - 1])
                        m.push(o || c), e++;
                    b === r.length - 1 && c + d - m[e - 1] > h && m.push(c);
                    c !== o && (o = c)
                });
                if (!i)
                    i = b.clipRect = d.clipRect(0, this.padding, 9999, 0), b.contentGroup.clip(i);
                i.attr({height: h});
                if (!n)
                    this.nav = n =
                            d.g().attr({zIndex: 1}).add(this.group), this.up = d.symbol("triangle", 0, 0, l, l).on("click", function () {
                        b.scroll(-1, k)
                    }).add(n), this.pager = d.text("", 15, 10).css(j.style).add(n), this.down = d.symbol("triangle-down", 0, 0, l, l).on("click", function () {
                        b.scroll(1, k)
                    }).add(n);
                b.scroll(0);
                a = f
            } else if (n)
                i.attr({height: c.chartHeight}), n.hide(), this.scrollGroup.attr({translateY: 1}), this.clipHeight = 0;
            return a
        }, scroll: function (a, b) {
            var c = this.pages, d = c.length, e = this.currentPage + a, f = this.clipHeight, g = this.options.navigation,
                    h = g.activeColor, g = g.inactiveColor, i = this.pager, j = this.padding;
            e > d && (e = d);
            if (e > 0)
                b !== t && Ra(b, this.chart), this.nav.attr({translateX: j, translateY: f + this.padding + 7 + this.titleHeight, visibility: "visible"}), this.up.attr({fill: e === 1 ? g : h}).css({cursor: e === 1 ? "default" : "pointer"}), i.attr({text: e + "/" + d}), this.down.attr({x: 18 + this.pager.getBBox().width, fill: e === d ? g : h}).css({cursor: e === d ? "default" : "pointer"}), c = -c[e - 1] + this.initialItemY, this.scrollGroup.animate({translateY: c}), this.currentPage = e, this.positionCheckboxes(c)
        }};
    H = R.LegendSymbolMixin = {drawRectangle: function (a, b) {
            var c = a.options.symbolHeight || 12;
            b.legendSymbol = this.chart.renderer.rect(0, a.baseline - 5 - c / 2, a.symbolWidth, c, a.options.symbolRadius || 0).attr({zIndex: 3}).add(b.legendGroup)
        }, drawLineMarker: function (a) {
            var b = this.options, c = b.marker, d;
            d = a.symbolWidth;
            var e = this.chart.renderer, f = this.legendGroup, a = a.baseline - w(e.fontMetrics(a.options.itemStyle.fontSize, this.legendItem).b * 0.3), g;
            if (b.lineWidth) {
                g = {"stroke-width": b.lineWidth};
                if (b.dashStyle)
                    g.dashstyle =
                            b.dashStyle;
                this.legendLine = e.path(["M", 0, a, "L", d, a]).attr(g).add(f)
            }
            if (c && c.enabled !== !1)
                b = c.radius, this.legendSymbol = d = e.symbol(this.symbol, d / 2 - b, a - b, 2 * b, 2 * b).add(f), d.isMarker = !0
        }};
    (/Trident\/7\.0/.test(wa) || Ua) && Na(lb.prototype, "positionItem", function (a, b) {
        var c = this, d = function () {
            b._legendItemPos && a.call(c, b)
        };
        d();
        setTimeout(d)
    });
    Za.prototype = {init: function (a, b) {
            var c, d = a.series;
            a.series = null;
            c = y(Q, a);
            c.series = a.series = d;
            this.userOptions = a;
            d = c.chart;
            this.margin = this.splashArray("margin", d);
            this.spacing =
                    this.splashArray("spacing", d);
            var e = d.events;
            this.bounds = {h: {}, v: {}};
            this.callback = b;
            this.isResizing = 0;
            this.options = c;
            this.axes = [];
            this.series = [];
            this.hasCartesianSeries = d.showAxes;
            var f = this, g;
            f.index = W.length;
            W.push(f);
            bb++;
            d.reflow !== !1 && K(f, "load", function () {
                f.initReflow()
            });
            if (e)
                for (g in e)
                    K(f, g, e[g]);
            f.xAxis = [];
            f.yAxis = [];
            f.animation = ga ? !1 : p(d.animation, !0);
            f.pointCount = f.colorCounter = f.symbolCounter = 0;
            f.firstRender()
        }, initSeries: function (a) {
            var b = this.options.chart;
            (b = D[a.type || b.type || b.defaultSeriesType]) ||
                    oa(17, !0);
            b = new b;
            b.init(this, a);
            return b
        }, isInsidePlot: function (a, b, c) {
            var d = c ? b : a, a = c ? a : b;
            return d >= 0 && d <= this.plotWidth && a >= 0 && a <= this.plotHeight
        }, adjustTickAmounts: function () {
            this.options.chart.alignTicks !== !1 && q(this.axes, function (a) {
                a.adjustTickAmount()
            });
            this.maxTicks = null
        }, redraw: function (a) {
            var b = this.axes, c = this.series, d = this.pointer, e = this.legend, f = this.isDirtyLegend, g, h, i = this.hasCartesianSeries, j = this.isDirtyBox, k = c.length, l = k, n = this.renderer, m = n.isHidden(), o = [];
            Ra(a, this);
            m && this.cloneRenderTo();
            for (this.layOutTitles(); l--; )
                if (a = c[l], a.options.stacking && (g = !0, a.isDirty)) {
                    h = !0;
                    break
                }
            if (h)
                for (l = k; l--; )
                    if (a = c[l], a.options.stacking)
                        a.isDirty = !0;
            q(c, function (a) {
                a.isDirty && a.options.legendType === "point" && (f = !0)
            });
            if (f && e.options.enabled)
                e.render(), this.isDirtyLegend = !1;
            g && this.getStacks();
            if (i) {
                if (!this.isResizing)
                    this.maxTicks = null, q(b, function (a) {
                        a.setScale()
                    });
                this.adjustTickAmounts()
            }
            this.getMargins();
            i && (q(b, function (a) {
                a.isDirty && (j = !0)
            }), q(b, function (a) {
                if (a.isDirtyExtremes)
                    a.isDirtyExtremes =
                            !1, o.push(function () {
                                J(a, "afterSetExtremes", r(a.eventArgs, a.getExtremes()));
                                delete a.eventArgs
                            });
                (j || g) && a.redraw()
            }));
            j && this.drawChartBox();
            q(c, function (a) {
                a.isDirty && a.visible && (!a.isCartesian || a.xAxis) && a.redraw()
            });
            d && d.reset(!0);
            n.draw();
            J(this, "redraw");
            m && this.cloneRenderTo(!0);
            q(o, function (a) {
                a.call()
            })
        }, get: function (a) {
            var b = this.axes, c = this.series, d, e;
            for (d = 0; d < b.length; d++)
                if (b[d].options.id === a)
                    return b[d];
            for (d = 0; d < c.length; d++)
                if (c[d].options.id === a)
                    return c[d];
            for (d = 0; d < c.length; d++) {
                e =
                        c[d].points || [];
                for (b = 0; b < e.length; b++)
                    if (e[b].id === a)
                        return e[b]
            }
            return null
        }, getAxes: function () {
            var a = this, b = this.options, c = b.xAxis = ra(b.xAxis || {}), b = b.yAxis = ra(b.yAxis || {});
            q(c, function (a, b) {
                a.index = b;
                a.isX = !0
            });
            q(b, function (a, b) {
                a.index = b
            });
            c = c.concat(b);
            q(c, function (b) {
                new ma(a, b)
            });
            a.adjustTickAmounts()
        }, getSelectedPoints: function () {
            var a = [];
            q(this.series, function (b) {
                a = a.concat(wb(b.points || [], function (a) {
                    return a.selected
                }))
            });
            return a
        }, getSelectedSeries: function () {
            return wb(this.series, function (a) {
                return a.selected
            })
        },
        getStacks: function () {
            var a = this;
            q(a.yAxis, function (a) {
                if (a.stacks && a.hasVisibleSeries)
                    a.oldStacks = a.stacks
            });
            q(a.series, function (b) {
                if (b.options.stacking && (b.visible === !0 || a.options.chart.ignoreHiddenSeries === !1))
                    b.stackKey = b.type + p(b.options.stack, "")
            })
        }, setTitle: function (a, b, c) {
            var g;
            var d = this, e = d.options, f;
            f = e.title = y(e.title, a);
            g = e.subtitle = y(e.subtitle, b), e = g;
            q([["title", a, f], ["subtitle", b, e]], function (a) {
                var b = a[0], c = d[b], e = a[1], a = a[2];
                c && e && (d[b] = c = c.destroy());
                a && a.text && !c && (d[b] = d.renderer.text(a.text,
                        0, 0, a.useHTML).attr({align: a.align, "class": "highcharts-" + b, zIndex: a.zIndex || 4}).css(a.style).add())
            });
            d.layOutTitles(c)
        }, layOutTitles: function (a) {
            var b = 0, c = this.title, d = this.subtitle, e = this.options, f = e.title, e = e.subtitle, g = this.renderer, h = this.spacingBox.width - 44;
            if (c && (c.css({width: (f.width || h) + "px"}).align(r({y: g.fontMetrics(f.style.fontSize, c).b - 3}, f), !1, "spacingBox"), !f.floating && !f.verticalAlign))
                b = c.getBBox().height;
            d && (d.css({width: (e.width || h) + "px"}).align(r({y: b + (f.margin - 13) + g.fontMetrics(f.style.fontSize,
                        d).b}, e), !1, "spacingBox"), !e.floating && !e.verticalAlign && (b = La(b + d.getBBox().height)));
            c = this.titleOffset !== b;
            this.titleOffset = b;
            if (!this.isDirtyBox && c)
                this.isDirtyBox = c, this.hasRendered && p(a, !0) && this.isDirtyBox && this.redraw()
        }, getChartSize: function () {
            var a = this.options.chart, b = a.width, a = a.height, c = this.renderToClone || this.renderTo;
            if (!s(b))
                this.containerWidth = jb(c, "width");
            if (!s(a))
                this.containerHeight = jb(c, "height");
            this.chartWidth = u(0, b || this.containerWidth || 600);
            this.chartHeight = u(0, p(a, this.containerHeight >
                    19 ? this.containerHeight : 400))
        }, cloneRenderTo: function (a) {
            var b = this.renderToClone, c = this.container;
            a ? b && (this.renderTo.appendChild(c), Qa(b), delete this.renderToClone) : (c && c.parentNode === this.renderTo && this.renderTo.removeChild(c), this.renderToClone = b = this.renderTo.cloneNode(0), F(b, {position: "absolute", top: "-9999px", display: "block"}), b.style.setProperty && b.style.setProperty("display", "block", "important"), v.body.appendChild(b), c && b.appendChild(c))
        }, getContainer: function () {
            var a, b = this.options.chart,
                    c, d, e;
            this.renderTo = a = b.renderTo;
            e = "highcharts-" + ub++;
            if (Ga(a))
                this.renderTo = a = v.getElementById(a);
            a || oa(13, !0);
            c = z(C(a, "data-highcharts-chart"));
            !isNaN(c) && W[c] && W[c].hasRendered && W[c].destroy();
            C(a, "data-highcharts-chart", this.index);
            a.innerHTML = "";
            !b.skipClone && !a.offsetWidth && this.cloneRenderTo();
            this.getChartSize();
            c = this.chartWidth;
            d = this.chartHeight;
            this.container = a = Z(Ka, {className: "highcharts-container" + (b.className ? " " + b.className : ""), id: e}, r({position: "relative", overflow: "hidden", width: c +
                        "px", height: d + "px", textAlign: "left", lineHeight: "normal", zIndex: 0, "-webkit-tap-highlight-color": "rgba(0,0,0,0)"}, b.style), this.renderToClone || a);
            this._cursor = a.style.cursor;
            this.renderer = b.forExport ? new ta(a, c, d, b.style, !0) : new $a(a, c, d, b.style);
            ga && this.renderer.create(this, a, c, d)
        }, getMargins: function () {
            var a = this.spacing, b, c = this.legend, d = this.margin, e = this.options.legend, f = p(e.margin, 20), g = e.x, h = e.y, i = e.align, j = e.verticalAlign, k = this.titleOffset;
            this.resetMargins();
            b = this.axisOffset;
            if (k && !s(d[0]))
                this.plotTop =
                        u(this.plotTop, k + this.options.title.margin + a[0]);
            if (c.display && !e.floating)
                if (i === "right") {
                    if (!s(d[1]))
                        this.marginRight = u(this.marginRight, c.legendWidth - g + f + a[1])
                } else if (i === "left") {
                    if (!s(d[3]))
                        this.plotLeft = u(this.plotLeft, c.legendWidth + g + f + a[3])
                } else if (j === "top") {
                    if (!s(d[0]))
                        this.plotTop = u(this.plotTop, c.legendHeight + h + f + a[0])
                } else if (j === "bottom" && !s(d[2]))
                    this.marginBottom = u(this.marginBottom, c.legendHeight - h + f + a[2]);
            this.extraBottomMargin && (this.marginBottom += this.extraBottomMargin);
            this.extraTopMargin &&
                    (this.plotTop += this.extraTopMargin);
            this.hasCartesianSeries && q(this.axes, function (a) {
                a.getOffset()
            });
            s(d[3]) || (this.plotLeft += b[3]);
            s(d[0]) || (this.plotTop += b[0]);
            s(d[2]) || (this.marginBottom += b[2]);
            s(d[1]) || (this.marginRight += b[1]);
            this.setChartSize()
        }, reflow: function (a) {
            var b = this, c = b.options.chart, d = b.renderTo, e = c.width || jb(d, "width"), f = c.height || jb(d, "height"), c = a ? a.target : E, d = function () {
                if (b.container)
                    b.setSize(e, f, !1), b.hasUserSize = null
            };
            if (!b.hasUserSize && e && f && (c === E || c === v)) {
                if (e !== b.containerWidth ||
                        f !== b.containerHeight)
                    clearTimeout(b.reflowTimeout), a ? b.reflowTimeout = setTimeout(d, 100) : d();
                b.containerWidth = e;
                b.containerHeight = f
            }
        }, initReflow: function () {
            var a = this, b = function (b) {
                a.reflow(b)
            };
            K(E, "resize", b);
            K(a, "destroy", function () {
                X(E, "resize", b)
            })
        }, setSize: function (a, b, c) {
            var d = this, e, f, g;
            d.isResizing += 1;
            g = function () {
                d && J(d, "endResize", null, function () {
                    d.isResizing -= 1
                })
            };
            Ra(c, d);
            d.oldChartHeight = d.chartHeight;
            d.oldChartWidth = d.chartWidth;
            if (s(a))
                d.chartWidth = e = u(0, w(a)), d.hasUserSize = !!e;
            if (s(b))
                d.chartHeight =
                        f = u(0, w(b));
            (va ? kb : F)(d.container, {width: e + "px", height: f + "px"}, va);
            d.setChartSize(!0);
            d.renderer.setSize(e, f, c);
            d.maxTicks = null;
            q(d.axes, function (a) {
                a.isDirty = !0;
                a.setScale()
            });
            q(d.series, function (a) {
                a.isDirty = !0
            });
            d.isDirtyLegend = !0;
            d.isDirtyBox = !0;
            d.layOutTitles();
            d.getMargins();
            d.redraw(c);
            d.oldChartHeight = null;
            J(d, "resize");
            va === !1 ? g() : setTimeout(g, va && va.duration || 500)
        }, setChartSize: function (a) {
            var b = this.inverted, c = this.renderer, d = this.chartWidth, e = this.chartHeight, f = this.options.chart, g = this.spacing,
                    h = this.clipOffset, i, j, k, l;
            this.plotLeft = i = w(this.plotLeft);
            this.plotTop = j = w(this.plotTop);
            this.plotWidth = k = u(0, w(d - i - this.marginRight));
            this.plotHeight = l = u(0, w(e - j - this.marginBottom));
            this.plotSizeX = b ? l : k;
            this.plotSizeY = b ? k : l;
            this.plotBorderWidth = f.plotBorderWidth || 0;
            this.spacingBox = c.spacingBox = {x: g[3], y: g[0], width: d - g[3] - g[1], height: e - g[0] - g[2]};
            this.plotBox = c.plotBox = {x: i, y: j, width: k, height: l};
            d = 2 * U(this.plotBorderWidth / 2);
            b = La(u(d, h[3]) / 2);
            c = La(u(d, h[0]) / 2);
            this.clipBox = {x: b, y: c, width: U(this.plotSizeX -
                        u(d, h[1]) / 2 - b), height: u(0, U(this.plotSizeY - u(d, h[2]) / 2 - c))};
            a || q(this.axes, function (a) {
                a.setAxisSize();
                a.setAxisTranslation()
            })
        }, resetMargins: function () {
            var a = this.spacing, b = this.margin;
            this.plotTop = p(b[0], a[0]);
            this.marginRight = p(b[1], a[1]);
            this.marginBottom = p(b[2], a[2]);
            this.plotLeft = p(b[3], a[3]);
            this.axisOffset = [0, 0, 0, 0];
            this.clipOffset = [0, 0, 0, 0]
        }, drawChartBox: function () {
            var a = this.options.chart, b = this.renderer, c = this.chartWidth, d = this.chartHeight, e = this.chartBackground, f = this.plotBackground, g =
                    this.plotBorder, h = this.plotBGImage, i = a.borderWidth || 0, j = a.backgroundColor, k = a.plotBackgroundColor, l = a.plotBackgroundImage, n = a.plotBorderWidth || 0, m, o = this.plotLeft, p = this.plotTop, q = this.plotWidth, r = this.plotHeight, t = this.plotBox, s = this.clipRect, u = this.clipBox;
            m = i + (a.shadow ? 8 : 0);
            if (i || j)
                if (e)
                    e.animate(e.crisp({width: c - m, height: d - m}));
                else {
                    e = {fill: j || S};
                    if (i)
                        e.stroke = a.borderColor, e["stroke-width"] = i;
                    this.chartBackground = b.rect(m / 2, m / 2, c - m, d - m, a.borderRadius, i).attr(e).addClass("highcharts-background").add().shadow(a.shadow)
                }
            if (k)
                f ?
                        f.animate(t) : this.plotBackground = b.rect(o, p, q, r, 0).attr({fill: k}).add().shadow(a.plotShadow);
            if (l)
                h ? h.animate(t) : this.plotBGImage = b.image(l, o, p, q, r).add();
            s ? s.animate({width: u.width, height: u.height}) : this.clipRect = b.clipRect(u);
            if (n)
                g ? g.animate(g.crisp({x: o, y: p, width: q, height: r})) : this.plotBorder = b.rect(o, p, q, r, 0, -n).attr({stroke: a.plotBorderColor, "stroke-width": n, fill: S, zIndex: 1}).add();
            this.isDirtyBox = !1
        }, propFromSeries: function () {
            var a = this, b = a.options.chart, c, d = a.options.series, e, f;
            q(["inverted",
                "angular", "polar"], function (g) {
                c = D[b.type || b.defaultSeriesType];
                f = a[g] || b[g] || c && c.prototype[g];
                for (e = d && d.length; !f && e--; )
                    (c = D[d[e].type]) && c.prototype[g] && (f = !0);
                a[g] = f
            })
        }, linkSeries: function () {
            var a = this, b = a.series;
            q(b, function (a) {
                a.linkedSeries.length = 0
            });
            q(b, function (b) {
                var d = b.options.linkedTo;
                if (Ga(d) && (d = d === ":previous" ? a.series[b.index - 1] : a.get(d)))
                    d.linkedSeries.push(b), b.linkedParent = d
            })
        }, renderSeries: function () {
            q(this.series, function (a) {
                a.translate();
                a.setTooltipPoints && a.setTooltipPoints();
                a.render()
            })
        }, renderLabels: function () {
            var a = this, b = a.options.labels;
            b.items && q(b.items, function (c) {
                var d = r(b.style, c.style), e = z(d.left) + a.plotLeft, f = z(d.top) + a.plotTop + 12;
                delete d.left;
                delete d.top;
                a.renderer.text(c.html, e, f).attr({zIndex: 2}).css(d).add()
            })
        }, render: function () {
            var a = this.axes, b = this.renderer, c = this.options;
            this.setTitle();
            this.legend = new lb(this, c.legend);
            this.getStacks();
            q(a, function (a) {
                a.setScale()
            });
            this.getMargins();
            this.maxTicks = null;
            q(a, function (a) {
                a.setTickPositions(!0);
                a.setMaxTicks()
            });
            this.adjustTickAmounts();
            this.getMargins();
            this.drawChartBox();
            this.hasCartesianSeries && q(a, function (a) {
                a.render()
            });
            if (!this.seriesGroup)
                this.seriesGroup = b.g("series-group").attr({zIndex: 3}).add();
            this.renderSeries();
            this.renderLabels();
            this.showCredits(c.credits);
            this.hasRendered = !0
        }, showCredits: function (a) {
            if (a.enabled && !this.credits)
                this.credits = this.renderer.text(a.text, 0, 0).on("click", function () {
                    if (a.href)
                        location.href = a.href
                }).attr({align: a.position.align, zIndex: 8}).css(a.style).add().align(a.position)
        },
        destroy: function () {
            var a = this, b = a.axes, c = a.series, d = a.container, e, f = d && d.parentNode;
            J(a, "destroy");
            W[a.index] = t;
            bb--;
            a.renderTo.removeAttribute("data-highcharts-chart");
            X(a);
            for (e = b.length; e--; )
                b[e] = b[e].destroy();
            for (e = c.length; e--; )
                c[e] = c[e].destroy();
            q("title,subtitle,chartBackground,plotBackground,plotBGImage,plotBorder,seriesGroup,clipRect,credits,pointer,scroller,rangeSelector,legend,resetZoomButton,tooltip,renderer".split(","), function (b) {
                var c = a[b];
                c && c.destroy && (a[b] = c.destroy())
            });
            if (d)
                d.innerHTML =
                        "", X(d), f && Qa(d);
            for (e in a)
                delete a[e]
        }, isReadyToRender: function () {
            var a = this;
            return!ba && E == E.top && v.readyState !== "complete" || ga && !E.canvg ? (ga ? Mb.push(function () {
                a.firstRender()
            }, a.options.global.canvasToolsURL) : v.attachEvent("onreadystatechange", function () {
                v.detachEvent("onreadystatechange", a.firstRender);
                v.readyState === "complete" && a.firstRender()
            }), !1) : !0
        }, firstRender: function () {
            var a = this, b = a.options, c = a.callback;
            if (a.isReadyToRender()) {
                a.getContainer();
                J(a, "init");
                a.resetMargins();
                a.setChartSize();
                a.propFromSeries();
                a.getAxes();
                q(b.series || [], function (b) {
                    a.initSeries(b)
                });
                a.linkSeries();
                J(a, "beforeRender");
                if (R.Pointer)
                    a.pointer = new Xa(a, b);
                a.render();
                a.renderer.draw();
                c && c.apply(a, [a]);
                q(a.callbacks, function (b) {
                    b.apply(a, [a])
                });
                a.cloneRenderTo(!0);
                J(a, "load")
            }
        }, splashArray: function (a, b) {
            var c = b[a], c = da(c) ? c : [c, c, c, c];
            return[p(b[a + "Top"], c[0]), p(b[a + "Right"], c[1]), p(b[a + "Bottom"], c[2]), p(b[a + "Left"], c[3])]
        }};
    Za.prototype.callbacks = [];
    Y = R.CenteredSeriesMixin = {getCenter: function () {
            var a = this.options,
                    b = this.chart, c = 2 * (a.slicedOffset || 0), d, e = b.plotWidth - 2 * c, f = b.plotHeight - 2 * c, b = a.center, a = [p(b[0], "50%"), p(b[1], "50%"), a.size || "100%", a.innerSize || 0], g = G(e, f), h;
            return Va(a, function (a, b) {
                h = /%$/.test(a);
                d = b < 2 || b === 2 && h;
                return(h ? [e, f, g, g][b] * z(a) / 100 : a) + (d ? c : 0)
            })
        }};
    var Fa = function () {
    };
    Fa.prototype = {init: function (a, b, c) {
            this.series = a;
            this.applyOptions(b, c);
            this.pointAttr = {};
            if (a.options.colorByPoint && (b = a.options.colors || a.chart.options.colors, this.color = this.color || b[a.colorCounter++], a.colorCounter ===
                    b.length))
                a.colorCounter = 0;
            a.chart.pointCount++;
            return this
        }, applyOptions: function (a, b) {
            var c = this.series, d = c.pointValKey, a = Fa.prototype.optionsToObject.call(this, a);
            r(this, a);
            this.options = this.options ? r(this.options, a) : a;
            if (d)
                this.y = this[d];
            if (this.x === t && c)
                this.x = b === t ? c.autoIncrement() : b;
            return this
        }, optionsToObject: function (a) {
            var b = {}, c = this.series, d = c.pointArrayMap || ["y"], e = d.length, f = 0, g = 0;
            if (typeof a === "number" || a === null)
                b[d[0]] = a;
            else if (Ma(a)) {
                if (a.length > e) {
                    c = typeof a[0];
                    if (c === "string")
                        b.name =
                                a[0];
                    else if (c === "number")
                        b.x = a[0];
                    f++
                }
                for (; g < e; )
                    b[d[g++]] = a[f++]
            } else if (typeof a === "object") {
                b = a;
                if (a.dataLabels)
                    c._hasPointLabels = !0;
                if (a.marker)
                    c._hasPointMarkers = !0
            }
            return b
        }, destroy: function () {
            var a = this.series.chart, b = a.hoverPoints, c;
            a.pointCount--;
            if (b && (this.setState(), ka(b, this), !b.length))
                a.hoverPoints = null;
            if (this === a.hoverPoint)
                this.onMouseOut();
            if (this.graphic || this.dataLabel)
                X(this), this.destroyElements();
            this.legendItem && a.legend.destroyItem(this);
            for (c in this)
                this[c] = null
        }, destroyElements: function () {
            for (var a =
                    "graphic,dataLabel,dataLabelUpper,group,connector,shadowGroup".split(","), b, c = 6; c--; )
                b = a[c], this[b] && (this[b] = this[b].destroy())
        }, getLabelConfig: function () {
            return{x: this.category, y: this.y, key: this.name || this.category, series: this.series, point: this, percentage: this.percentage, total: this.total || this.stackTotal}
        }, tooltipFormatter: function (a) {
            var b = this.series, c = b.tooltipOptions, d = p(c.valueDecimals, ""), e = c.valuePrefix || "", f = c.valueSuffix || "";
            q(b.pointArrayMap || ["y"], function (b) {
                b = "{point." + b;
                if (e || f)
                    a =
                            a.replace(b + "}", e + b + "}" + f);
                a = a.replace(b + "}", b + ":,." + d + "f}")
            });
            return Ja(a, {point: this, series: this.series})
        }, firePointEvent: function (a, b, c) {
            var d = this, e = this.series.options;
            (e.point.events[a] || d.options && d.options.events && d.options.events[a]) && this.importEvents();
            a === "click" && e.allowPointSelect && (c = function (a) {
                d.select(null, a.ctrlKey || a.metaKey || a.shiftKey)
            });
            J(this, a, b, c)
        }};
    var P = function () {
    };
    P.prototype = {isCartesian: !0, type: "line", pointClass: Fa, sorted: !0, requireSorting: !0, pointAttrToOptions: {stroke: "lineColor",
            "stroke-width": "lineWidth", fill: "fillColor", r: "radius"}, axisTypes: ["xAxis", "yAxis"], colorCounter: 0, parallelArrays: ["x", "y"], init: function (a, b) {
            var c = this, d, e, f = a.series, g = function (a, b) {
                return p(a.options.index, a._i) - p(b.options.index, b._i)
            };
            c.chart = a;
            c.options = b = c.setOptions(b);
            c.linkedSeries = [];
            c.bindAxes();
            r(c, {name: b.name, state: "", pointAttr: {}, visible: b.visible !== !1, selected: b.selected === !0});
            if (ga)
                b.animation = !1;
            e = b.events;
            for (d in e)
                K(c, d, e[d]);
            if (e && e.click || b.point && b.point.events && b.point.events.click ||
                    b.allowPointSelect)
                a.runTrackerClick = !0;
            c.getColor();
            c.getSymbol();
            q(c.parallelArrays, function (a) {
                c[a + "Data"] = []
            });
            c.setData(b.data, !1);
            if (c.isCartesian)
                a.hasCartesianSeries = !0;
            f.push(c);
            c._i = f.length - 1;
            ob(f, g);
            this.yAxis && ob(this.yAxis.series, g);
            q(f, function (a, b) {
                a.index = b;
                a.name = a.name || "Series " + (b + 1)
            })
        }, bindAxes: function () {
            var a = this, b = a.options, c = a.chart, d;
            q(a.axisTypes || [], function (e) {
                q(c[e], function (c) {
                    d = c.options;
                    if (b[e] === d.index || b[e] !== t && b[e] === d.id || b[e] === t && d.index === 0)
                        c.series.push(a),
                                a[e] = c, c.isDirty = !0
                });
                !a[e] && a.optionalAxis !== e && oa(18, !0)
            })
        }, updateParallelArrays: function (a, b) {
            var c = a.series, d = arguments;
            q(c.parallelArrays, typeof b === "number" ? function (d) {
                var f = d === "y" && c.toYData ? c.toYData(a) : a[d];
                c[d + "Data"][b] = f
            } : function (a) {
                Array.prototype[b].apply(c[a + "Data"], Array.prototype.slice.call(d, 2))
            })
        }, autoIncrement: function () {
            var a = this.options, b = this.xIncrement, b = p(b, a.pointStart, 0);
            this.pointInterval = p(this.pointInterval, a.pointInterval, 1);
            this.xIncrement = b + this.pointInterval;
            return b
        }, getSegments: function () {
            var a = -1, b = [], c, d = this.points, e = d.length;
            if (e)
                if (this.options.connectNulls) {
                    for (c = e; c--; )
                        d[c].y === null && d.splice(c, 1);
                    d.length && (b = [d])
                } else
                    q(d, function (c, g) {
                        c.y === null ? (g > a + 1 && b.push(d.slice(a + 1, g)), a = g) : g === e - 1 && b.push(d.slice(a + 1, g + 1))
                    });
            this.segments = b
        }, setOptions: function (a) {
            var b = this.chart, c = b.options.plotOptions, b = b.userOptions || {}, d = b.plotOptions || {}, e = c[this.type];
            this.userOptions = a;
            c = y(e, c.series, a);
            this.tooltipOptions = y(Q.tooltip, Q.plotOptions[this.type].tooltip,
                    b.tooltip, d.series && d.series.tooltip, d[this.type] && d[this.type].tooltip, a.tooltip);
            e.marker === null && delete c.marker;
            return c
        }, getCyclic: function (a, b, c) {
            var d = this.userOptions, e = "_" + a + "Index", f = a + "Counter";
            b || (s(d[e]) ? b = d[e] : (d[e] = b = this.chart[f] % c.length, this.chart[f] += 1), b = c[b]);
            this[a] = b
        }, getColor: function () {
            this.options.colorByPoint || this.getCyclic("color", this.options.color || ca[this.type].color, this.chart.options.colors)
        }, getSymbol: function () {
            var a = this.options.marker;
            this.getCyclic("symbol",
                    a.symbol, this.chart.options.symbols);
            if (/^url/.test(this.symbol))
                a.radius = 0
        }, drawLegendSymbol: H.drawLineMarker, setData: function (a, b, c, d) {
            var e = this, f = e.points, g = f && f.length || 0, h, i = e.options, j = e.chart, k = null, l = e.xAxis, n = l && !!l.categories, m = e.tooltipPoints, o = i.turboThreshold, r = this.xData, s = this.yData, u = (h = e.pointArrayMap) && h.length, a = a || [];
            h = a.length;
            b = p(b, !0);
            if (d !== !1 && h && g === h && !e.cropped && !e.hasGroupedData)
                q(a, function (a, b) {
                    f[b].update(a, !1)
                });
            else {
                e.xIncrement = null;
                e.pointRange = n ? 1 : i.pointRange;
                e.colorCounter = 0;
                q(this.parallelArrays, function (a) {
                    e[a + "Data"].length = 0
                });
                if (o && h > o) {
                    for (c = 0; k === null && c < h; )
                        k = a[c], c++;
                    if (ia(k)) {
                        n = p(i.pointStart, 0);
                        i = p(i.pointInterval, 1);
                        for (c = 0; c < h; c++)
                            r[c] = n, s[c] = a[c], n += i;
                        e.xIncrement = n
                    } else if (Ma(k))
                        if (u)
                            for (c = 0; c < h; c++)
                                i = a[c], r[c] = i[0], s[c] = i.slice(1, u + 1);
                        else
                            for (c = 0; c < h; c++)
                                i = a[c], r[c] = i[0], s[c] = i[1];
                    else
                        oa(12)
                } else
                    for (c = 0; c < h; c++)
                        if (a[c] !== t && (i = {series: e}, e.pointClass.prototype.applyOptions.apply(i, [a[c]]), e.updateParallelArrays(i, c), n && i.name))
                            l.names[i.x] =
                                    i.name;
                Ga(s[0]) && oa(14, !0);
                e.data = [];
                e.options.data = a;
                for (c = g; c--; )
                    f[c] && f[c].destroy && f[c].destroy();
                if (m)
                    m.length = 0;
                if (l)
                    l.minRange = l.userMinRange;
                e.isDirty = e.isDirtyData = j.isDirtyBox = !0;
                c = !1
            }
            b && j.redraw(c)
        }, processData: function (a) {
            var b = this.xData, c = this.yData, d = b.length, e;
            e = 0;
            var f, g, h = this.xAxis, i = this.options, j = i.cropThreshold, k = 0, l = this.isCartesian, n, m;
            if (l && !this.isDirty && !h.isDirty && !this.yAxis.isDirty && !a)
                return!1;
            if (l && this.sorted && (!j || d > j || this.forceCrop))
                if (n = h.getExtremes(), m = n.min,
                        n = n.max, b[d - 1] < m || b[0] > n)
                    b = [], c = [];
                else if (b[0] < m || b[d - 1] > n)
                    e = this.cropData(this.xData, this.yData, m, n), b = e.xData, c = e.yData, e = e.start, f = !0, k = b.length;
            for (a = b.length - 1; a >= 0; a--)
                d = b[a] - b[a - 1], !f && b[a] > m && b[a] < n && k++, d > 0 && (g === t || d < g) ? g = d : d < 0 && this.requireSorting && oa(15);
            this.cropped = f;
            this.cropStart = e;
            this.processedXData = b;
            this.processedYData = c;
            this.activePointCount = k;
            if (i.pointRange === null)
                this.pointRange = g || 1;
            this.closestPointRange = g
        }, cropData: function (a, b, c, d) {
            var e = a.length, f = 0, g = e, h = p(this.cropShoulder,
                    1), i;
            for (i = 0; i < e; i++)
                if (a[i] >= c) {
                    f = u(0, i - h);
                    break
                }
            for (; i < e; i++)
                if (a[i] > d) {
                    g = i + h;
                    break
                }
            return{xData: a.slice(f, g), yData: b.slice(f, g), start: f, end: g}
        }, generatePoints: function () {
            var a = this.options.data, b = this.data, c, d = this.processedXData, e = this.processedYData, f = this.pointClass, g = d.length, h = this.cropStart || 0, i, j = this.hasGroupedData, k, l = [], n;
            if (!b && !j)
                b = [], b.length = a.length, b = this.data = b;
            for (n = 0; n < g; n++)
                i = h + n, j ? l[n] = (new f).init(this, [d[n]].concat(ra(e[n]))) : (b[i] ? k = b[i] : a[i] !== t && (b[i] = k = (new f).init(this,
                        a[i], d[n])), l[n] = k);
            if (b && (g !== (c = b.length) || j))
                for (n = 0; n < c; n++)
                    if (n === h && !j && (n += g), b[n])
                        b[n].destroyElements(), b[n].plotX = t;
            this.data = b;
            this.points = l
        }, getExtremes: function (a) {
            var b = this.yAxis, c = this.processedXData, d, e = [], f = 0;
            d = this.xAxis.getExtremes();
            var g = d.min, h = d.max, i, j, k, l, a = a || this.stackedYData || this.processedYData;
            d = a.length;
            for (l = 0; l < d; l++)
                if (j = c[l], k = a[l], i = k !== null && k !== t && (!b.isLog || k.length || k > 0), j = this.getExtremesFromAll || this.cropped || (c[l + 1] || j) >= g && (c[l - 1] || j) <= h, i && j)
                    if (i = k.length)
                        for (; i--; )
                            k[i] !==
                                    null && (e[f++] = k[i]);
                    else
                        e[f++] = k;
            this.dataMin = p(void 0, Oa(e));
            this.dataMax = p(void 0, Ba(e))
        }, translate: function () {
            this.processedXData || this.processData();
            this.generatePoints();
            for (var a = this.options, b = a.stacking, c = this.xAxis, d = c.categories, e = this.yAxis, f = this.points, g = f.length, h = !!this.modifyValue, i = a.pointPlacement, j = i === "between" || ia(i), k = a.threshold, a = 0; a < g; a++) {
                var l = f[a], n = l.x, m = l.y, o = l.low, q = b && e.stacks[(this.negStacks && m < k ? "-" : "") + this.stackKey];
                if (e.isLog && m <= 0)
                    l.y = m = null;
                l.plotX = c.translate(n,
                        0, 0, 0, 1, i, this.type === "flags");
                if (b && this.visible && q && q[n])
                    q = q[n], m = q.points[this.index + "," + a], o = m[0], m = m[1], o === 0 && (o = p(k, e.min)), e.isLog && o <= 0 && (o = null), l.total = l.stackTotal = q.total, l.percentage = q.total && l.y / q.total * 100, l.stackY = m, q.setOffset(this.pointXOffset || 0, this.barW || 0);
                l.yBottom = s(o) ? e.translate(o, 0, 1, 0, 1) : null;
                h && (m = this.modifyValue(m, l));
                l.plotY = typeof m === "number" && m !== Infinity ? e.translate(m, 0, 1, 0, 1) : t;
                l.clientX = j ? c.translate(n, 0, 0, 0, 1) : l.plotX;
                l.negative = l.y < (k || 0);
                l.category = d && d[l.x] !==
                        t ? d[l.x] : l.x
            }
            this.getSegments()
        }, animate: function (a) {
            var b = this.chart, c = b.renderer, d;
            d = this.options.animation;
            var e = this.clipBox || b.clipBox, f = b.inverted, g;
            if (d && !da(d))
                d = ca[this.type].animation;
            g = ["_sharedClip", d.duration, d.easing, e.height].join(",");
            a ? (a = b[g], d = b[g + "m"], a || (b[g] = a = c.clipRect(r(e, {width: 0})), b[g + "m"] = d = c.clipRect(-99, f ? -b.plotLeft : -b.plotTop, 99, f ? b.chartWidth : b.chartHeight)), this.group.clip(a), this.markerGroup.clip(d), this.sharedClipKey = g) : ((a = b[g]) && a.animate({width: b.plotSizeX},
            d), b[g + "m"] && b[g + "m"].animate({width: b.plotSizeX + 99}, d), this.animate = null)
        }, afterAnimate: function () {
            var a = this.chart, b = this.sharedClipKey, c = this.group, d = this.clipBox;
            if (c && this.options.clip !== !1) {
                if (!b || !d)
                    c.clip(d ? a.renderer.clipRect(d) : a.clipRect);
                this.markerGroup.clip()
            }
            J(this, "afterAnimate");
            setTimeout(function () {
                b && a[b] && (d || (a[b] = a[b].destroy()), a[b + "m"] && (a[b + "m"] = a[b + "m"].destroy()))
            }, 100)
        }, drawPoints: function () {
            var a, b = this.points, c = this.chart, d, e, f, g, h, i, j, k;
            d = this.options.marker;
            var l =
                    this.pointAttr[""], n, m = this.markerGroup, o = p(d.enabled, this.activePointCount < 0.5 * this.xAxis.len / d.radius);
            if (d.enabled !== !1 || this._hasPointMarkers)
                for (f = b.length; f--; )
                    if (g = b[f], d = U(g.plotX), e = g.plotY, k = g.graphic, i = g.marker || {}, a = o && i.enabled === t || i.enabled, n = c.isInsidePlot(w(d), e, c.inverted), a && e !== t && !isNaN(e) && g.y !== null)
                        if (a = g.pointAttr[g.selected ? "select" : ""] || l, h = a.r, i = p(i.symbol, this.symbol), j = i.indexOf("url") === 0, k)
                            k[n ? "show" : "hide"](!0).animate(r({x: d - h, y: e - h}, k.symbolName ? {width: 2 * h, height: 2 *
                                        h} : {}));
                        else {
                            if (n && (h > 0 || j))
                                g.graphic = c.renderer.symbol(i, d - h, e - h, 2 * h, 2 * h).attr(a).add(m)
                        }
                    else if (k)
                        g.graphic = k.destroy()
        }, convertAttribs: function (a, b, c, d) {
            var e = this.pointAttrToOptions, f, g, h = {}, a = a || {}, b = b || {}, c = c || {}, d = d || {};
            for (f in e)
                g = e[f], h[f] = p(a[g], b[f], c[f], d[f]);
            return h
        }, getAttribs: function () {
            var a = this, b = a.options, c = ca[a.type].marker ? b.marker : b, d = c.states, e = d.hover, f, g = a.color;
            f = {stroke: g, fill: g};
            var h = a.points || [], i, j = [], k, l = a.pointAttrToOptions;
            k = a.hasPointSpecificOptions;
            var n = b.negativeColor,
                    m = c.lineColor, o = c.fillColor;
            i = b.turboThreshold;
            var p;
            b.marker ? (e.radius = e.radius || c.radius + e.radiusPlus, e.lineWidth = e.lineWidth || c.lineWidth + e.lineWidthPlus) : e.color = e.color || ya(e.color || g).brighten(e.brightness).get();
            j[""] = a.convertAttribs(c, f);
            q(["hover", "select"], function (b) {
                j[b] = a.convertAttribs(d[b], j[""])
            });
            a.pointAttr = j;
            g = h.length;
            if (!i || g < i || k)
                for (; g--; ) {
                    i = h[g];
                    if ((c = i.options && i.options.marker || i.options) && c.enabled === !1)
                        c.radius = 0;
                    if (i.negative && n)
                        i.color = i.fillColor = n;
                    k = b.colorByPoint ||
                            i.color;
                    if (i.options)
                        for (p in l)
                            s(c[l[p]]) && (k = !0);
                    if (k) {
                        c = c || {};
                        k = [];
                        d = c.states || {};
                        f = d.hover = d.hover || {};
                        if (!b.marker)
                            f.color = f.color || !i.options.color && e.color || ya(i.color).brighten(f.brightness || e.brightness).get();
                        f = {color: i.color};
                        if (!o)
                            f.fillColor = i.color;
                        if (!m)
                            f.lineColor = i.color;
                        k[""] = a.convertAttribs(r(f, c), j[""]);
                        k.hover = a.convertAttribs(d.hover, j.hover, k[""]);
                        k.select = a.convertAttribs(d.select, j.select, k[""])
                    } else
                        k = j;
                    i.pointAttr = k
                }
        }, destroy: function () {
            var a = this, b = a.chart, c = /AppleWebKit\/533/.test(wa),
                    d, e, f = a.data || [], g, h, i;
            J(a, "destroy");
            X(a);
            q(a.axisTypes || [], function (b) {
                if (i = a[b])
                    ka(i.series, a), i.isDirty = i.forceRedraw = !0
            });
            a.legendItem && a.chart.legend.destroyItem(a);
            for (e = f.length; e--; )
                (g = f[e]) && g.destroy && g.destroy();
            a.points = null;
            clearTimeout(a.animationTimeout);
            q("area,graph,dataLabelsGroup,group,markerGroup,tracker,graphNeg,areaNeg,posClip,negClip".split(","), function (b) {
                a[b] && (d = c && b === "group" ? "hide" : "destroy", a[b][d]())
            });
            if (b.hoverSeries === a)
                b.hoverSeries = null;
            ka(b.series, a);
            for (h in a)
                delete a[h]
        },
        getSegmentPath: function (a) {
            var b = this, c = [], d = b.options.step;
            q(a, function (e, f) {
                var g = e.plotX, h = e.plotY, i;
                b.getPointSpline ? c.push.apply(c, b.getPointSpline(a, e, f)) : (c.push(f ? "L" : "M"), d && f && (i = a[f - 1], d === "right" ? c.push(i.plotX, h) : d === "center" ? c.push((i.plotX + g) / 2, i.plotY, (i.plotX + g) / 2, h) : c.push(g, i.plotY)), c.push(e.plotX, e.plotY))
            });
            return c
        }, getGraphPath: function () {
            var a = this, b = [], c, d = [];
            q(a.segments, function (e) {
                c = a.getSegmentPath(e);
                e.length > 1 ? b = b.concat(c) : d.push(e[0])
            });
            a.singlePoints = d;
            return a.graphPath =
                    b
        }, drawGraph: function () {
            var a = this, b = this.options, c = [["graph", b.lineColor || this.color]], d = b.lineWidth, e = b.dashStyle, f = b.linecap !== "square", g = this.getGraphPath(), h = b.negativeColor;
            h && c.push(["graphNeg", h]);
            q(c, function (c, h) {
                var k = c[0], l = a[k];
                if (l)
                    cb(l), l.animate({d: g});
                else if (d && g.length)
                    l = {stroke: c[1], "stroke-width": d, fill: S, zIndex: 1}, e ? l.dashstyle = e : f && (l["stroke-linecap"] = l["stroke-linejoin"] = "round"), a[k] = a.chart.renderer.path(g).attr(l).add(a.group).shadow(!h && b.shadow)
            })
        }, clipNeg: function () {
            var a =
                    this.options, b = this.chart, c = b.renderer, d = a.negativeColor || a.negativeFillColor, e, f = this.graph, g = this.area, h = this.posClip, i = this.negClip;
            e = b.chartWidth;
            var j = b.chartHeight, k = u(e, j), l = this.yAxis;
            if (d && (f || g)) {
                d = w(l.toPixels(a.threshold || 0, !0));
                d < 0 && (k -= d);
                a = {x: 0, y: 0, width: k, height: d};
                k = {x: 0, y: d, width: k, height: k};
                if (b.inverted)
                    a.height = k.y = b.plotWidth - d, c.isVML && (a = {x: b.plotWidth - d - b.plotLeft, y: 0, width: e, height: j}, k = {x: d + b.plotLeft - e, y: 0, width: b.plotLeft + d, height: e});
                l.reversed ? (b = k, e = a) : (b = a, e = k);
                h ?
                        (h.animate(b), i.animate(e)) : (this.posClip = h = c.clipRect(b), this.negClip = i = c.clipRect(e), f && this.graphNeg && (f.clip(h), this.graphNeg.clip(i)), g && (g.clip(h), this.areaNeg.clip(i)))
            }
        }, invertGroups: function () {
            function a() {
                var a = {width: b.yAxis.len, height: b.xAxis.len};
                q(["group", "markerGroup"], function (c) {
                    b[c] && b[c].attr(a).invert()
                })
            }
            var b = this, c = b.chart;
            if (b.xAxis)
                K(c, "resize", a), K(b, "destroy", function () {
                    X(c, "resize", a)
                }), a(), b.invertGroups = a
        }, plotGroup: function (a, b, c, d, e) {
            var f = this[a], g = !f;
            g && (this[a] =
                    f = this.chart.renderer.g(b).attr({visibility: c, zIndex: d || 0.1}).add(e));
            f[g ? "attr" : "animate"](this.getPlotBox());
            return f
        }, getPlotBox: function () {
            var a = this.chart, b = this.xAxis, c = this.yAxis;
            if (a.inverted)
                b = c, c = this.xAxis;
            return{translateX: b ? b.left : a.plotLeft, translateY: c ? c.top : a.plotTop, scaleX: 1, scaleY: 1}
        }, render: function () {
            var a = this, b = a.chart, c, d = a.options, e = (c = d.animation) && !!a.animate && b.renderer.isSVG && p(c.duration, 500) || 0, f = a.visible ? "visible" : "hidden", g = d.zIndex, h = a.hasRendered, i = b.seriesGroup;
            c = a.plotGroup("group", "series", f, g, i);
            a.markerGroup = a.plotGroup("markerGroup", "markers", f, g, i);
            e && a.animate(!0);
            a.getAttribs();
            c.inverted = a.isCartesian ? b.inverted : !1;
            a.drawGraph && (a.drawGraph(), a.clipNeg());
            a.drawDataLabels && a.drawDataLabels();
            a.visible && a.drawPoints();
            a.drawTracker && a.options.enableMouseTracking !== !1 && a.drawTracker();
            b.inverted && a.invertGroups();
            d.clip !== !1 && !a.sharedClipKey && !h && c.clip(b.clipRect);
            e && a.animate();
            if (!h)
                e ? a.animationTimeout = setTimeout(function () {
                    a.afterAnimate()
                },
                        e) : a.afterAnimate();
            a.isDirty = a.isDirtyData = !1;
            a.hasRendered = !0
        }, redraw: function () {
            var a = this.chart, b = this.isDirtyData, c = this.group, d = this.xAxis, e = this.yAxis;
            c && (a.inverted && c.attr({width: a.plotWidth, height: a.plotHeight}), c.animate({translateX: p(d && d.left, a.plotLeft), translateY: p(e && e.top, a.plotTop)}));
            this.translate();
            this.setTooltipPoints && this.setTooltipPoints(!0);
            this.render();
            b && J(this, "updatedData")
        }};
    Hb.prototype = {destroy: function () {
            Pa(this, this.axis)
        }, render: function (a) {
            var b = this.options,
                    c = b.format, c = c ? Ja(c, this) : b.formatter.call(this);
            this.label ? this.label.attr({text: c, visibility: "hidden"}) : this.label = this.axis.chart.renderer.text(c, null, null, b.useHTML).css(b.style).attr({align: this.textAlign, rotation: b.rotation, visibility: "hidden"}).add(a)
        }, setOffset: function (a, b) {
            var c = this.axis, d = c.chart, e = d.inverted, f = this.isNegative, g = c.translate(c.usePercentage ? 100 : this.total, 0, 0, 0, 1), c = c.translate(0), c = N(g - c), h = d.xAxis[0].translate(this.x) + a, i = d.plotHeight, f = {x: e ? f ? g : g - c : h, y: e ? i - h - b : f ? i - g -
                        c : i - g, width: e ? c : b, height: e ? b : c};
            if (e = this.label)
                e.align(this.alignOptions, null, f), f = e.alignAttr, e[this.options.crop === !1 || d.isInsidePlot(f.x, f.y) ? "show" : "hide"](!0)
        }};
    ma.prototype.buildStacks = function () {
        var a = this.series, b = p(this.options.reversedStacks, !0), c = a.length;
        if (!this.isXAxis) {
            for (this.usePercentage = !1; c--; )
                a[b ? c : a.length - c - 1].setStackedPoints();
            if (this.usePercentage)
                for (c = 0; c < a.length; c++)
                    a[c].setPercentStacks()
        }
    };
    ma.prototype.renderStackTotals = function () {
        var a = this.chart, b = a.renderer, c =
                this.stacks, d, e, f = this.stackTotalGroup;
        if (!f)
            this.stackTotalGroup = f = b.g("stack-labels").attr({visibility: "visible", zIndex: 6}).add();
        f.translate(a.plotLeft, a.plotTop);
        for (d in c)
            for (e in a = c[d], a)
                a[e].render(f)
    };
    P.prototype.setStackedPoints = function () {
        if (this.options.stacking && !(this.visible !== !0 && this.chart.options.chart.ignoreHiddenSeries !== !1)) {
            var a = this.processedXData, b = this.processedYData, c = [], d = b.length, e = this.options, f = e.threshold, g = e.stack, e = e.stacking, h = this.stackKey, i = "-" + h, j = this.negStacks,
                    k = this.yAxis, l = k.stacks, n = k.oldStacks, m, o, p, q, r, s;
            for (q = 0; q < d; q++) {
                r = a[q];
                s = b[q];
                p = this.index + "," + q;
                o = (m = j && s < f) ? i : h;
                l[o] || (l[o] = {});
                if (!l[o][r])
                    n[o] && n[o][r] ? (l[o][r] = n[o][r], l[o][r].total = null) : l[o][r] = new Hb(k, k.options.stackLabels, m, r, g);
                o = l[o][r];
                o.points[p] = [o.cum || 0];
                e === "percent" ? (m = m ? h : i, j && l[m] && l[m][r] ? (m = l[m][r], o.total = m.total = u(m.total, o.total) + N(s) || 0) : o.total = ea(o.total + (N(s) || 0))) : o.total = ea(o.total + (s || 0));
                o.cum = (o.cum || 0) + (s || 0);
                o.points[p].push(o.cum);
                c[q] = o.cum
            }
            if (e === "percent")
                k.usePercentage =
                        !0;
            this.stackedYData = c;
            k.oldStacks = {}
        }
    };
    P.prototype.setPercentStacks = function () {
        var a = this, b = a.stackKey, c = a.yAxis.stacks, d = a.processedXData;
        q([b, "-" + b], function (b) {
            var e;
            for (var f = d.length, g, h; f--; )
                if (g = d[f], e = (h = c[b] && c[b][g]) && h.points[a.index + "," + f], g = e)
                    h = h.total ? 100 / h.total : 0, g[0] = ea(g[0] * h), g[1] = ea(g[1] * h), a.stackedYData[f] = g[1]
        })
    };
    r(Za.prototype, {addSeries: function (a, b, c) {
            var d, e = this;
            a && (b = p(b, !0), J(e, "addSeries", {options: a}, function () {
                d = e.initSeries(a);
                e.isDirtyLegend = !0;
                e.linkSeries();
                b &&
                        e.redraw(c)
            }));
            return d
        }, addAxis: function (a, b, c, d) {
            var e = b ? "xAxis" : "yAxis", f = this.options;
            new ma(this, y(a, {index: this[e].length, isX: b}));
            f[e] = ra(f[e] || {});
            f[e].push(a);
            p(c, !0) && this.redraw(d)
        }, showLoading: function (a) {
            var b = this, c = b.options, d = b.loadingDiv, e = c.loading, f = function () {
                d && F(d, {left: b.plotLeft + "px", top: b.plotTop + "px", width: b.plotWidth + "px", height: b.plotHeight + "px"})
            };
            if (!d)
                b.loadingDiv = d = Z(Ka, {className: "highcharts-loading"}, r(e.style, {zIndex: 10, display: S}), b.container), b.loadingSpan = Z("span",
                        null, e.labelStyle, d), K(b, "redraw", f);
            b.loadingSpan.innerHTML = a || c.lang.loading;
            if (!b.loadingShown)
                F(d, {opacity: 0, display: ""}), kb(d, {opacity: e.style.opacity}, {duration: e.showDuration || 0}), b.loadingShown = !0;
            f()
        }, hideLoading: function () {
            var a = this.options, b = this.loadingDiv;
            b && kb(b, {opacity: 0}, {duration: a.loading.hideDuration || 100, complete: function () {
                    F(b, {display: S})
                }});
            this.loadingShown = !1
        }});
    r(Fa.prototype, {update: function (a, b, c) {
            var d = this, e = d.series, f = d.graphic, g, h = e.data, i = e.chart, j = e.options, b = p(b,
                    !0);
            d.firePointEvent("update", {options: a}, function () {
                d.applyOptions(a);
                if (da(a)) {
                    e.getAttribs();
                    if (f)
                        a && a.marker && a.marker.symbol ? d.graphic = f.destroy() : f.attr(d.pointAttr[d.state || ""]);
                    if (a && a.dataLabels && d.dataLabel)
                        d.dataLabel = d.dataLabel.destroy()
                }
                g = Da(d, h);
                e.updateParallelArrays(d, g);
                j.data[g] = d.options;
                e.isDirty = e.isDirtyData = !0;
                if (!e.fixedBox && e.hasCartesianSeries)
                    i.isDirtyBox = !0;
                j.legendType === "point" && i.legend.destroyItem(d);
                b && i.redraw(c)
            })
        }, remove: function (a, b) {
            var c = this, d = c.series, e = d.points,
                    f = d.chart, g, h = d.data;
            Ra(b, f);
            a = p(a, !0);
            c.firePointEvent("remove", null, function () {
                g = Da(c, h);
                h.length === e.length && e.splice(g, 1);
                h.splice(g, 1);
                d.options.data.splice(g, 1);
                d.updateParallelArrays(c, "splice", g, 1);
                c.destroy();
                d.isDirty = !0;
                d.isDirtyData = !0;
                a && f.redraw()
            })
        }});
    r(P.prototype, {addPoint: function (a, b, c, d) {
            var e = this.options, f = this.data, g = this.graph, h = this.area, i = this.chart, j = this.xAxis && this.xAxis.names, k = g && g.shift || 0, l = e.data, n, m = this.xData;
            Ra(d, i);
            c && q([g, h, this.graphNeg, this.areaNeg], function (a) {
                if (a)
                    a.shift =
                            k + 1
            });
            if (h)
                h.isArea = !0;
            b = p(b, !0);
            d = {series: this};
            this.pointClass.prototype.applyOptions.apply(d, [a]);
            g = d.x;
            h = m.length;
            if (this.requireSorting && g < m[h - 1])
                for (n = !0; h && m[h - 1] > g; )
                    h--;
            this.updateParallelArrays(d, "splice", h, 0, 0);
            this.updateParallelArrays(d, h);
            if (j)
                j[g] = d.name;
            l.splice(h, 0, a);
            n && (this.data.splice(h, 0, null), this.processData());
            e.legendType === "point" && this.generatePoints();
            c && (f[0] && f[0].remove ? f[0].remove(!1) : (f.shift(), this.updateParallelArrays(d, "shift"), l.shift()));
            this.isDirtyData = this.isDirty =
                    !0;
            b && (this.getAttribs(), i.redraw())
        }, remove: function (a, b) {
            var c = this, d = c.chart, a = p(a, !0);
            if (!c.isRemoving)
                c.isRemoving = !0, J(c, "remove", null, function () {
                    c.destroy();
                    d.isDirtyLegend = d.isDirtyBox = !0;
                    d.linkSeries();
                    a && d.redraw(b)
                });
            c.isRemoving = !1
        }, update: function (a, b) {
            var c = this, d = this.chart, e = this.userOptions, f = this.type, g = D[f].prototype, h = ["group", "markerGroup", "dataLabelsGroup"], i;
            q(h, function (a) {
                h[a] = c[a];
                delete c[a]
            });
            a = y(e, {animation: !1, index: this.index, pointStart: this.xData[0]}, {data: this.options.data},
            a);
            this.remove(!1);
            for (i in g)
                g.hasOwnProperty(i) && (this[i] = t);
            r(this, D[a.type || f].prototype);
            q(h, function (a) {
                c[a] = h[a]
            });
            this.init(d, a);
            d.linkSeries();
            p(b, !0) && d.redraw(!1)
        }});
    r(ma.prototype, {update: function (a, b) {
            var c = this.chart, a = c.options[this.coll][this.options.index] = y(this.userOptions, a);
            this.destroy(!0);
            this._addedPlotLB = t;
            this.init(c, r(a, {events: t}));
            c.isDirtyBox = !0;
            p(b, !0) && c.redraw()
        }, remove: function (a) {
            for (var b = this.chart, c = this.coll, d = this.series, e = d.length; e--; )
                d[e] && d[e].remove(!1);
            ka(b.axes, this);
            ka(b[c], this);
            b.options[c].splice(this.options.index, 1);
            q(b[c], function (a, b) {
                a.options.index = b
            });
            this.destroy();
            b.isDirtyBox = !0;
            p(a, !0) && b.redraw()
        }, setTitle: function (a, b) {
            this.update({title: a}, b)
        }, setCategories: function (a, b) {
            this.update({categories: a}, b)
        }});
    ha = la(P);
    D.line = ha;
    ca.area = y(T, {threshold: 0});
    var qa = la(P, {type: "area", getSegments: function () {
            var a = [], b = [], c = [], d = this.xAxis, e = this.yAxis, f = e.stacks[this.stackKey], g = {}, h, i, j = this.points, k = this.options.connectNulls, l, n, m;
            if (this.options.stacking &&
                    !this.cropped) {
                for (n = 0; n < j.length; n++)
                    g[j[n].x] = j[n];
                for (m in f)
                    f[m].total !== null && c.push(+m);
                c.sort(function (a, b) {
                    return a - b
                });
                q(c, function (a) {
                    if (!k || g[a] && g[a].y !== null)
                        g[a] ? b.push(g[a]) : (h = d.translate(a), l = f[a].percent ? f[a].total ? f[a].cum * 100 / f[a].total : 0 : f[a].cum, i = e.toPixels(l, !0), b.push({y: null, plotX: h, clientX: h, plotY: i, yBottom: i, onMouseOver: sa}))
                });
                b.length && a.push(b)
            } else
                P.prototype.getSegments.call(this), a = this.segments;
            this.segments = a
        }, getSegmentPath: function (a) {
            var b = P.prototype.getSegmentPath.call(this,
                    a), c = [].concat(b), d, e = this.options;
            d = b.length;
            var f = this.yAxis.getThreshold(e.threshold), g;
            d === 3 && c.push("L", b[1], b[2]);
            if (e.stacking && !this.closedStacks)
                for (d = a.length - 1; d >= 0; d--)
                    g = p(a[d].yBottom, f), d < a.length - 1 && e.step && c.push(a[d + 1].plotX, g), c.push(a[d].plotX, g);
            else
                this.closeSegment(c, a, f);
            this.areaPath = this.areaPath.concat(c);
            return b
        }, closeSegment: function (a, b, c) {
            a.push("L", b[b.length - 1].plotX, c, "L", b[0].plotX, c)
        }, drawGraph: function () {
            this.areaPath = [];
            P.prototype.drawGraph.apply(this);
            var a =
                    this, b = this.areaPath, c = this.options, d = c.negativeColor, e = c.negativeFillColor, f = [["area", this.color, c.fillColor]];
            (d || e) && f.push(["areaNeg", d, e]);
            q(f, function (d) {
                var e = d[0], f = a[e];
                f ? f.animate({d: b}) : a[e] = a.chart.renderer.path(b).attr({fill: p(d[2], ya(d[1]).setOpacity(p(c.fillOpacity, 0.75)).get()), zIndex: 0}).add(a.group)
            })
        }, drawLegendSymbol: H.drawRectangle});
    D.area = qa;
    ca.spline = y(T);
    ha = la(P, {type: "spline", getPointSpline: function (a, b, c) {
            var d = b.plotX, e = b.plotY, f = a[c - 1], g = a[c + 1], h, i, j, k;
            if (f && g) {
                a = f.plotY;
                j = g.plotX;
                var g = g.plotY, l;
                h = (1.5 * d + f.plotX) / 2.5;
                i = (1.5 * e + a) / 2.5;
                j = (1.5 * d + j) / 2.5;
                k = (1.5 * e + g) / 2.5;
                l = (k - i) * (j - d) / (j - h) + e - k;
                i += l;
                k += l;
                i > a && i > e ? (i = u(a, e), k = 2 * e - i) : i < a && i < e && (i = G(a, e), k = 2 * e - i);
                k > g && k > e ? (k = u(g, e), i = 2 * e - k) : k < g && k < e && (k = G(g, e), i = 2 * e - k);
                b.rightContX = j;
                b.rightContY = k
            }
            c ? (b = ["C", f.rightContX || f.plotX, f.rightContY || f.plotY, h || d, i || e, d, e], f.rightContX = f.rightContY = null) : b = ["M", d, e];
            return b
        }});
    D.spline = ha;
    ca.areaspline = y(ca.area);
    qa = qa.prototype;
    ha = la(ha, {type: "areaspline", closedStacks: !0, getSegmentPath: qa.getSegmentPath,
        closeSegment: qa.closeSegment, drawGraph: qa.drawGraph, drawLegendSymbol: H.drawRectangle});
    D.areaspline = ha;
    ca.column = y(T, {borderColor: "#FFFFFF", borderRadius: 0, groupPadding: 0.2, marker: null, pointPadding: 0.1, minPointLength: 0, cropThreshold: 50, pointRange: null, states: {hover: {brightness: 0.1, shadow: !1, halo: !1}, select: {color: "#C0C0C0", borderColor: "#000000", shadow: !1}}, dataLabels: {align: null, verticalAlign: null, y: null}, stickyTracking: !1, tooltip: {distance: 6}, threshold: 0});
    ha = la(P, {type: "column", pointAttrToOptions: {stroke: "borderColor",
            fill: "color", r: "borderRadius"}, cropShoulder: 0, trackerGroups: ["group", "dataLabelsGroup"], negStacks: !0, init: function () {
            P.prototype.init.apply(this, arguments);
            var a = this, b = a.chart;
            b.hasRendered && q(b.series, function (b) {
                if (b.type === a.type)
                    b.isDirty = !0
            })
        }, getColumnMetrics: function () {
            var a = this, b = a.options, c = a.xAxis, d = a.yAxis, e = c.reversed, f, g = {}, h, i = 0;
            b.grouping === !1 ? i = 1 : q(a.chart.series, function (b) {
                var c = b.options, e = b.yAxis;
                if (b.type === a.type && b.visible && d.len === e.len && d.pos === e.pos)
                    c.stacking ? (f = b.stackKey,
                            g[f] === t && (g[f] = i++), h = g[f]) : c.grouping !== !1 && (h = i++), b.columnIndex = h
            });
            var c = G(N(c.transA) * (c.ordinalSlope || b.pointRange || c.closestPointRange || c.tickInterval || 1), c.len), j = c * b.groupPadding, k = (c - 2 * j) / i, l = b.pointWidth, b = s(l) ? (k - l) / 2 : k * b.pointPadding, l = p(l, k - 2 * b);
            return a.columnMetrics = {width: l, offset: b + (j + ((e ? i - (a.columnIndex || 0) : a.columnIndex) || 0) * k - c / 2) * (e ? -1 : 1)}
        }, translate: function () {
            var a = this, b = a.chart, c = a.options, d = a.borderWidth = p(c.borderWidth, a.activePointCount > 0.5 * a.xAxis.len ? 0 : 1), e = a.yAxis,
                    f = a.translatedThreshold = e.getThreshold(c.threshold), g = p(c.minPointLength, 5), c = a.getColumnMetrics(), h = c.width, i = a.barW = La(u(h, 1 + 2 * d)), j = a.pointXOffset = c.offset, k = -(d % 2 ? 0.5 : 0), l = d % 2 ? 0.5 : 1;
            b.renderer.isVML && b.inverted && (l += 1);
            P.prototype.translate.apply(a);
            q(a.points, function (c) {
                var d = p(c.yBottom, f), o = G(u(-999 - d, c.plotY), e.len + 999 + d), q = c.plotX + j, r = i, s = G(o, d), t;
                t = u(o, d) - s;
                N(t) < g && g && (t = g, s = w(N(s - f) > g ? d - g : f - (e.translate(c.y, 0, 1, 0, 1) <= f ? g : 0)));
                c.barX = q;
                c.pointWidth = h;
                c.tooltipPos = b.inverted ? [e.len - o, a.xAxis.len -
                            q - r / 2] : [q + r / 2, o];
                d = N(q) < 0.5;
                r = w(q + r) + k;
                q = w(q) + k;
                r -= q;
                o = N(s) < 0.5;
                t = w(s + t) + l;
                s = w(s) + l;
                t -= s;
                d && (q += 1, r -= 1);
                o && (s -= 1, t += 1);
                c.shapeType = "rect";
                c.shapeArgs = {x: q, y: s, width: r, height: t}
            })
        }, getSymbol: sa, drawLegendSymbol: H.drawRectangle, drawGraph: sa, drawPoints: function () {
            var a = this, b = this.chart, c = a.options, d = b.renderer, e = c.animationLimit || 250, f, g;
            q(a.points, function (h) {
                var i = h.plotY, j = h.graphic;
                if (i !== t && !isNaN(i) && h.y !== null)
                    f = h.shapeArgs, i = s(a.borderWidth) ? {"stroke-width": a.borderWidth} : {}, g = h.pointAttr[h.selected ?
                            "select" : ""] || a.pointAttr[""], j ? (cb(j), j.attr(i)[b.pointCount < e ? "animate" : "attr"](y(f))) : h.graphic = d[h.shapeType](f).attr(g).attr(i).add(a.group).shadow(c.shadow, null, c.stacking && !c.borderRadius);
                else if (j)
                    h.graphic = j.destroy()
            })
        }, animate: function (a) {
            var b = this.yAxis, c = this.options, d = this.chart.inverted, e = {};
            if (ba)
                a ? (e.scaleY = 0.001, a = G(b.pos + b.len, u(b.pos, b.toPixels(c.threshold))), d ? e.translateX = a - b.len : e.translateY = a, this.group.attr(e)) : (e.scaleY = 1, e[d ? "translateX" : "translateY"] = b.pos, this.group.animate(e,
                        this.options.animation), this.animate = null)
        }, remove: function () {
            var a = this, b = a.chart;
            b.hasRendered && q(b.series, function (b) {
                if (b.type === a.type)
                    b.isDirty = !0
            });
            P.prototype.remove.apply(a, arguments)
        }});
    D.column = ha;
    ca.bar = y(ca.column);
    qa = la(ha, {type: "bar", inverted: !0});
    D.bar = qa;
    ca.scatter = y(T, {lineWidth: 0, tooltip: {headerFormat: '<span style="color:{series.color}">●</span> <span style="font-size: 10px;"> {series.name}</span><br/>', pointFormat: "x: <b>{point.x}</b><br/>y: <b>{point.y}</b><br/>"}, stickyTracking: !1});
    qa = la(P, {type: "scatter", sorted: !1, requireSorting: !1, noSharedTooltip: !0, trackerGroups: ["markerGroup", "dataLabelsGroup"], takeOrdinalPosition: !1, singularTooltips: !0, drawGraph: function () {
            this.options.lineWidth && P.prototype.drawGraph.call(this)
        }});
    D.scatter = qa;
    ca.pie = y(T, {borderColor: "#FFFFFF", borderWidth: 1, center: [null, null], clip: !1, colorByPoint: !0, dataLabels: {distance: 30, enabled: !0, formatter: function () {
                return this.point.name
            }}, ignoreHiddenPoint: !0, legendType: "point", marker: null, size: null, showInLegend: !1,
        slicedOffset: 10, states: {hover: {brightness: 0.1, shadow: !1}}, stickyTracking: !1, tooltip: {followPointer: !0}});
    T = {type: "pie", isCartesian: !1, pointClass: la(Fa, {init: function () {
                Fa.prototype.init.apply(this, arguments);
                var a = this, b;
                if (a.y < 0)
                    a.y = null;
                r(a, {visible: a.visible !== !1, name: p(a.name, "Slice")});
                b = function (b) {
                    a.slice(b.type === "select")
                };
                K(a, "select", b);
                K(a, "unselect", b);
                return a
            }, setVisible: function (a) {
                var b = this, c = b.series, d = c.chart;
                b.visible = b.options.visible = a = a === t ? !b.visible : a;
                c.options.data[Da(b,
                        c.data)] = b.options;
                q(["graphic", "dataLabel", "connector", "shadowGroup"], function (c) {
                    if (b[c])
                        b[c][a ? "show" : "hide"](!0)
                });
                b.legendItem && d.legend.colorizeItem(b, a);
                if (!c.isDirty && c.options.ignoreHiddenPoint)
                    c.isDirty = !0, d.redraw()
            }, slice: function (a, b, c) {
                var d = this.series;
                Ra(c, d.chart);
                p(b, !0);
                this.sliced = this.options.sliced = a = s(a) ? a : !this.sliced;
                d.options.data[Da(this, d.data)] = this.options;
                a = a ? this.slicedTranslation : {translateX: 0, translateY: 0};
                this.graphic.animate(a);
                this.shadowGroup && this.shadowGroup.animate(a)
            },
            haloPath: function (a) {
                var b = this.shapeArgs, c = this.series.chart;
                return this.sliced || !this.visible ? [] : this.series.chart.renderer.symbols.arc(c.plotLeft + b.x, c.plotTop + b.y, b.r + a, b.r + a, {innerR: this.shapeArgs.r, start: b.start, end: b.end})
            }}), requireSorting: !1, noSharedTooltip: !0, trackerGroups: ["group", "dataLabelsGroup"], axisTypes: [], pointAttrToOptions: {stroke: "borderColor", "stroke-width": "borderWidth", fill: "color"}, singularTooltips: !0, getColor: sa, animate: function (a) {
            var b = this, c = b.points, d = b.startAngleRad;
            if (!a)
                q(c, function (a) {
                    var c = a.graphic, a = a.shapeArgs;
                    c && (c.attr({r: b.center[3] / 2, start: d, end: d}), c.animate({r: a.r, start: a.start, end: a.end}, b.options.animation))
                }), b.animate = null
        }, setData: function (a, b, c, d) {
            P.prototype.setData.call(this, a, !1, c, d);
            this.processData();
            this.generatePoints();
            p(b, !0) && this.chart.redraw(c)
        }, generatePoints: function () {
            var a, b = 0, c, d, e, f = this.options.ignoreHiddenPoint;
            P.prototype.generatePoints.call(this);
            c = this.points;
            d = c.length;
            for (a = 0; a < d; a++)
                e = c[a], b += f && !e.visible ? 0 : e.y;
            this.total =
                    b;
            for (a = 0; a < d; a++)
                e = c[a], e.percentage = b > 0 ? e.y / b * 100 : 0, e.total = b
        }, translate: function (a) {
            this.generatePoints();
            var b = 0, c = this.options, d = c.slicedOffset, e = d + c.borderWidth, f, g, h, i = c.startAngle || 0, j = this.startAngleRad = na / 180 * (i - 90), i = (this.endAngleRad = na / 180 * (p(c.endAngle, i + 360) - 90)) - j, k = this.points, l = c.dataLabels.distance, c = c.ignoreHiddenPoint, n, m = k.length, o;
            if (!a)
                this.center = a = this.getCenter();
            this.getX = function (b, c) {
                h = V.asin(G((b - a[1]) / (a[2] / 2 + l), 1));
                return a[0] + (c ? -1 : 1) * $(h) * (a[2] / 2 + l)
            };
            for (n = 0; n < m; n++) {
                o =
                        k[n];
                f = j + b * i;
                if (!c || o.visible)
                    b += o.percentage / 100;
                g = j + b * i;
                o.shapeType = "arc";
                o.shapeArgs = {x: a[0], y: a[1], r: a[2] / 2, innerR: a[3] / 2, start: w(f * 1E3) / 1E3, end: w(g * 1E3) / 1E3};
                h = (g + f) / 2;
                h > 1.5 * na ? h -= 2 * na : h < -na / 2 && (h += 2 * na);
                o.slicedTranslation = {translateX: w($(h) * d), translateY: w(fa(h) * d)};
                f = $(h) * a[2] / 2;
                g = fa(h) * a[2] / 2;
                o.tooltipPos = [a[0] + f * 0.7, a[1] + g * 0.7];
                o.half = h < -na / 2 || h > na / 2 ? 1 : 0;
                o.angle = h;
                e = G(e, l / 2);
                o.labelPos = [a[0] + f + $(h) * l, a[1] + g + fa(h) * l, a[0] + f + $(h) * e, a[1] + g + fa(h) * e, a[0] + f, a[1] + g, l < 0 ? "center" : o.half ? "right" : "left",
                    h]
            }
        }, drawGraph: null, drawPoints: function () {
            var a = this, b = a.chart.renderer, c, d, e = a.options.shadow, f, g;
            if (e && !a.shadowGroup)
                a.shadowGroup = b.g("shadow").add(a.group);
            q(a.points, function (h) {
                d = h.graphic;
                g = h.shapeArgs;
                f = h.shadowGroup;
                if (e && !f)
                    f = h.shadowGroup = b.g("shadow").add(a.shadowGroup);
                c = h.sliced ? h.slicedTranslation : {translateX: 0, translateY: 0};
                f && f.attr(c);
                d ? d.animate(r(g, c)) : h.graphic = d = b[h.shapeType](g).setRadialReference(a.center).attr(h.pointAttr[h.selected ? "select" : ""]).attr({"stroke-linejoin": "round"}).attr(c).add(a.group).shadow(e,
                        f);
                h.visible !== void 0 && h.setVisible(h.visible)
            })
        }, sortByAngle: function (a, b) {
            a.sort(function (a, d) {
                return a.angle !== void 0 && (d.angle - a.angle) * b
            })
        }, drawLegendSymbol: H.drawRectangle, getCenter: Y.getCenter, getSymbol: sa};
    T = la(P, T);
    D.pie = T;
    P.prototype.drawDataLabels = function () {
        var a = this, b = a.options, c = b.cursor, d = b.dataLabels, e = a.points, f, g, h, i;
        if (d.enabled || a._hasPointLabels)
            a.dlProcessOptions && a.dlProcessOptions(d), i = a.plotGroup("dataLabelsGroup", "data-labels", d.defer ? "hidden" : "visible", d.zIndex || 6), !a.hasRendered &&
                    p(d.defer, !0) && (i.attr({opacity: 0}), K(a, "afterAnimate", function () {
                a.visible && i.show();
                i[b.animation ? "animate" : "attr"]({opacity: 1}, {duration: 200})
            })), g = d, q(e, function (b) {
                var e, l = b.dataLabel, n, m, o = b.connector, q = !0;
                f = b.options && b.options.dataLabels;
                e = p(f && f.enabled, g.enabled);
                if (l && !e)
                    b.dataLabel = l.destroy();
                else if (e) {
                    d = y(g, f);
                    e = d.rotation;
                    n = b.getLabelConfig();
                    h = d.format ? Ja(d.format, n) : d.formatter.call(n, d);
                    d.style.color = p(d.color, d.style.color, a.color, "black");
                    if (l)
                        if (s(h))
                            l.attr({text: h}), q = !1;
                        else {
                            if (b.dataLabel =
                                    l = l.destroy(), o)
                                b.connector = o.destroy()
                        }
                    else if (s(h)) {
                        l = {fill: d.backgroundColor, stroke: d.borderColor, "stroke-width": d.borderWidth, r: d.borderRadius || 0, rotation: e, padding: d.padding, zIndex: 1};
                        for (m in l)
                            l[m] === t && delete l[m];
                        l = b.dataLabel = a.chart.renderer[e ? "text" : "label"](h, 0, -999, null, null, null, d.useHTML).attr(l).css(r(d.style, c && {cursor: c})).add(i).shadow(d.shadow)
                    }
                    l && a.alignDataLabel(b, l, d, null, q)
                }
            })
    };
    P.prototype.alignDataLabel = function (a, b, c, d, e) {
        var f = this.chart, g = f.inverted, h = p(a.plotX, -999),
                i = p(a.plotY, -999), j = b.getBBox();
        if (a = this.visible && (a.series.forceDL || f.isInsidePlot(h, w(i), g) || d && f.isInsidePlot(h, g ? d.x + 1 : d.y + d.height - 1, g)))
            d = r({x: g ? f.plotWidth - i : h, y: w(g ? f.plotHeight - h : i), width: 0, height: 0}, d), r(c, {width: j.width, height: j.height}), c.rotation ? b[e ? "attr" : "animate"]({x: d.x + c.x + d.width / 2, y: d.y + c.y + d.height / 2}).attr({align: c.align}) : (b.align(c, null, d), g = b.alignAttr, p(c.overflow, "justify") === "justify" ? this.justifyDataLabel(b, c, g, j, d, e) : p(c.crop, !0) && (a = f.isInsidePlot(g.x, g.y) && f.isInsidePlot(g.x +
                    j.width, g.y + j.height)));
        if (!a)
            b.attr({y: -999}), b.placed = !1
    };
    P.prototype.justifyDataLabel = function (a, b, c, d, e, f) {
        var g = this.chart, h = b.align, i = b.verticalAlign, j, k;
        j = c.x;
        if (j < 0)
            h === "right" ? b.align = "left" : b.x = -j, k = !0;
        j = c.x + d.width;
        if (j > g.plotWidth)
            h === "left" ? b.align = "right" : b.x = g.plotWidth - j, k = !0;
        j = c.y;
        if (j < 0)
            i === "bottom" ? b.verticalAlign = "top" : b.y = -j, k = !0;
        j = c.y + d.height;
        if (j > g.plotHeight)
            i === "top" ? b.verticalAlign = "bottom" : b.y = g.plotHeight - j, k = !0;
        if (k)
            a.placed = !f, a.align(b, null, e)
    };
    if (D.pie)
        D.pie.prototype.drawDataLabels =
                function () {
                    var a = this, b = a.data, c, d = a.chart, e = a.options.dataLabels, f = p(e.connectorPadding, 10), g = p(e.connectorWidth, 1), h = d.plotWidth, d = d.plotHeight, i, j, k = p(e.softConnector, !0), l = e.distance, n = a.center, m = n[2] / 2, o = n[1], r = l > 0, s, t, v, y = [[], []], z, A, G, F, x, M = [0, 0, 0, 0], J = function (a, b) {
                        return b.y - a.y
                    };
                    if (a.visible && (e.enabled || a._hasPointLabels)) {
                        P.prototype.drawDataLabels.apply(a);
                        q(b, function (a) {
                            a.dataLabel && a.visible && y[a.half].push(a)
                        });
                        for (F = 2; F--; ) {
                            var D = [], K = [], E = y[F], H = E.length, C;
                            if (H) {
                                a.sortByAngle(E,
                                        F - 0.5);
                                for (x = b = 0; !b && E[x]; )
                                    b = E[x] && E[x].dataLabel && (E[x].dataLabel.getBBox().height || 21), x++;
                                if (l > 0) {
                                    for (x = o - m - l; x <= o + m + l; x += b)
                                        D.push(x);
                                    t = D.length;
                                    if (H > t) {
                                        c = [].concat(E);
                                        c.sort(J);
                                        for (x = H; x--; )
                                            c[x].rank = x;
                                        for (x = H; x--; )
                                            E[x].rank >= t && E.splice(x, 1);
                                        H = E.length
                                    }
                                    for (x = 0; x < H; x++) {
                                        c = E[x];
                                        v = c.labelPos;
                                        c = 9999;
                                        var Q, O;
                                        for (O = 0; O < t; O++)
                                            Q = N(D[O] - v[1]), Q < c && (c = Q, C = O);
                                        if (C < x && D[x] !== null)
                                            C = x;
                                        else
                                            for (t < H - x + C && D[x] !== null && (C = t - H + x); D[C] === null; )
                                                C++;
                                        K.push({i: C, y: D[C]});
                                        D[C] = null
                                    }
                                    K.sort(J)
                                }
                                for (x = 0; x < H; x++) {
                                    c = E[x];
                                    v = c.labelPos;
                                    s = c.dataLabel;
                                    G = c.visible === !1 ? "hidden" : "visible";
                                    c = v[1];
                                    if (l > 0) {
                                        if (t = K.pop(), C = t.i, A = t.y, c > A && D[C + 1] !== null || c < A && D[C - 1] !== null)
                                            A = c
                                    } else
                                        A = c;
                                    z = e.justify ? n[0] + (F ? -1 : 1) * (m + l) : a.getX(C === 0 || C === D.length - 1 ? c : A, F);
                                    s._attr = {visibility: G, align: v[6]};
                                    s._pos = {x: z + e.x + ({left: f, right: -f}[v[6]] || 0), y: A + e.y - 10};
                                    s.connX = z;
                                    s.connY = A;
                                    if (this.options.size === null)
                                        t = s.width, z - t < f ? M[3] = u(w(t - z + f), M[3]) : z + t > h - f && (M[1] = u(w(z + t - h + f), M[1])), A - b / 2 < 0 ? M[0] = u(w(-A + b / 2), M[0]) : A + b / 2 > d && (M[2] = u(w(A + b / 2 - d), M[2]))
                                }
                            }
                        }
                        if (Ba(M) ===
                                0 || this.verifyDataLabelOverflow(M))
                            this.placeDataLabels(), r && g && q(this.points, function (b) {
                                i = b.connector;
                                v = b.labelPos;
                                if ((s = b.dataLabel) && s._pos)
                                    G = s._attr.visibility, z = s.connX, A = s.connY, j = k ? ["M", z + (v[6] === "left" ? 5 : -5), A, "C", z, A, 2 * v[2] - v[4], 2 * v[3] - v[5], v[2], v[3], "L", v[4], v[5]] : ["M", z + (v[6] === "left" ? 5 : -5), A, "L", v[2], v[3], "L", v[4], v[5]], i ? (i.animate({d: j}), i.attr("visibility", G)) : b.connector = i = a.chart.renderer.path(j).attr({"stroke-width": g, stroke: e.connectorColor || b.color || "#606060", visibility: G}).add(a.dataLabelsGroup);
                                else if (i)
                                    b.connector = i.destroy()
                            })
                    }
                }, D.pie.prototype.placeDataLabels = function () {
            q(this.points, function (a) {
                var a = a.dataLabel, b;
                if (a)
                    (b = a._pos) ? (a.attr(a._attr), a[a.moved ? "animate" : "attr"](b), a.moved = !0) : a && a.attr({y: -999})
            })
        }, D.pie.prototype.alignDataLabel = sa, D.pie.prototype.verifyDataLabelOverflow = function (a) {
            var b = this.center, c = this.options, d = c.center, e = c = c.minSize || 80, f;
            d[0] !== null ? e = u(b[2] - u(a[1], a[3]), c) : (e = u(b[2] - a[1] - a[3], c), b[0] += (a[3] - a[1]) / 2);
            d[1] !== null ? e = u(G(e, b[2] - u(a[0], a[2])), c) : (e =
                    u(G(e, b[2] - a[0] - a[2]), c), b[1] += (a[0] - a[2]) / 2);
            e < b[2] ? (b[2] = e, this.translate(b), q(this.points, function (a) {
                if (a.dataLabel)
                    a.dataLabel._pos = null
            }), this.drawDataLabels && this.drawDataLabels()) : f = !0;
            return f
        };
    if (D.column)
        D.column.prototype.alignDataLabel = function (a, b, c, d, e) {
            var f = this.chart, g = f.inverted, h = a.dlBox || a.shapeArgs, i = a.below || a.plotY > p(this.translatedThreshold, f.plotSizeY), j = p(c.inside, !!this.options.stacking);
            if (h && (d = y(h), g && (d = {x: f.plotWidth - d.y - d.height, y: f.plotHeight - d.x - d.width, width: d.height,
                height: d.width}), !j))
                g ? (d.x += i ? 0 : d.width, d.width = 0) : (d.y += i ? d.height : 0, d.height = 0);
            c.align = p(c.align, !g || j ? "center" : i ? "right" : "left");
            c.verticalAlign = p(c.verticalAlign, g || j ? "middle" : i ? "top" : "bottom");
            P.prototype.alignDataLabel.call(this, a, b, c, d, e)
        };
    T = R.TrackerMixin = {drawTrackerPoint: function () {
            var a = this, b = a.chart, c = b.pointer, d = a.options.cursor, e = d && {cursor: d}, f = function (c) {
                var d = c.target, e;
                if (b.hoverSeries !== a)
                    a.onMouseOver();
                for (; d && !e; )
                    e = d.point, d = d.parentNode;
                if (e !== t && e !== b.hoverPoint)
                    e.onMouseOver(c)
            };
            q(a.points, function (a) {
                if (a.graphic)
                    a.graphic.element.point = a;
                if (a.dataLabel)
                    a.dataLabel.element.point = a
            });
            if (!a._hasTracking)
                q(a.trackerGroups, function (b) {
                    if (a[b] && (a[b].addClass("highcharts-tracker").on("mouseover", f).on("mouseout", function (a) {
                        c.onTrackerMouseOut(a)
                    }).css(e), ab))
                        a[b].on("touchstart", f)
                }), a._hasTracking = !0
        }, drawTrackerGraph: function () {
            var a = this, b = a.options, c = b.trackByArea, d = [].concat(c ? a.areaPath : a.graphPath), e = d.length, f = a.chart, g = f.pointer, h = f.renderer, i = f.options.tooltip.snap,
                    j = a.tracker, k = b.cursor, l = k && {cursor: k}, k = a.singlePoints, n, m = function () {
                if (f.hoverSeries !== a)
                    a.onMouseOver()
            }, o = "rgba(192,192,192," + (ba ? 1.0E-4 : 0.002) + ")";
            if (e && !c)
                for (n = e + 1; n--; )
                    d[n] === "M" && d.splice(n + 1, 0, d[n + 1] - i, d[n + 2], "L"), (n && d[n] === "M" || n === e) && d.splice(n, 0, "L", d[n - 2] + i, d[n - 1]);
            for (n = 0; n < k.length; n++)
                e = k[n], d.push("M", e.plotX - i, e.plotY, "L", e.plotX + i, e.plotY);
            j ? j.attr({d: d}) : (a.tracker = h.path(d).attr({"stroke-linejoin": "round", visibility: a.visible ? "visible" : "hidden", stroke: o, fill: c ? o : S, "stroke-width": b.lineWidth +
                        (c ? 0 : 2 * i), zIndex: 2}).add(a.group), q([a.tracker, a.markerGroup], function (a) {
                a.addClass("highcharts-tracker").on("mouseover", m).on("mouseout", function (a) {
                    g.onTrackerMouseOut(a)
                }).css(l);
                if (ab)
                    a.on("touchstart", m)
            }))
        }};
    if (D.column)
        ha.prototype.drawTracker = T.drawTrackerPoint;
    if (D.pie)
        D.pie.prototype.drawTracker = T.drawTrackerPoint;
    if (D.scatter)
        qa.prototype.drawTracker = T.drawTrackerPoint;
    r(lb.prototype, {setItemEvents: function (a, b, c, d, e) {
            var f = this;
            (c ? b : a.legendGroup).on("mouseover", function () {
                a.setState("hover");
                b.css(f.options.itemHoverStyle)
            }).on("mouseout", function () {
                b.css(a.visible ? d : e);
                a.setState()
            }).on("click", function (b) {
                var c = function () {
                    a.setVisible()
                }, b = {browserEvent: b};
                a.firePointEvent ? a.firePointEvent("legendItemClick", b, c) : J(a, "legendItemClick", b, c)
            })
        }, createCheckboxForItem: function (a) {
            a.checkbox = Z("input", {type: "checkbox", checked: a.selected, defaultChecked: a.selected}, this.options.itemCheckboxStyle, this.chart.container);
            K(a.checkbox, "click", function (b) {
                J(a, "checkboxClick", {checked: b.target.checked},
                function () {
                    a.select()
                })
            })
        }});
    Q.legend.itemStyle.cursor = "pointer";
    r(Za.prototype, {showResetZoom: function () {
            var a = this, b = Q.lang, c = a.options.chart.resetZoomButton, d = c.theme, e = d.states, f = c.relativeTo === "chart" ? null : "plotBox";
            this.resetZoomButton = a.renderer.button(b.resetZoom, null, null, function () {
                a.zoomOut()
            }, d, e && e.hover).attr({align: c.position.align, title: b.resetZoomTitle}).add().align(c.position, !1, f)
        }, zoomOut: function () {
            var a = this;
            J(a, "selection", {resetSelection: !0}, function () {
                a.zoom()
            })
        }, zoom: function (a) {
            var b,
                    c = this.pointer, d = !1, e;
            !a || a.resetSelection ? q(this.axes, function (a) {
                b = a.zoom()
            }) : q(a.xAxis.concat(a.yAxis), function (a) {
                var e = a.axis, h = e.isXAxis;
                if (c[h ? "zoomX" : "zoomY"] || c[h ? "pinchX" : "pinchY"])
                    b = e.zoom(a.min, a.max), e.displayBtn && (d = !0)
            });
            e = this.resetZoomButton;
            if (d && !e)
                this.showResetZoom();
            else if (!d && da(e))
                this.resetZoomButton = e.destroy();
            b && this.redraw(p(this.options.chart.animation, a && a.animation, this.pointCount < 100))
        }, pan: function (a, b) {
            var c = this, d = c.hoverPoints, e;
            d && q(d, function (a) {
                a.setState()
            });
            q(b === "xy" ? [1, 0] : [1], function (b) {
                var d = a[b ? "chartX" : "chartY"], h = c[b ? "xAxis" : "yAxis"][0], i = c[b ? "mouseDownX" : "mouseDownY"], j = (h.pointRange || 0) / 2, k = h.getExtremes(), l = h.toValue(i - d, !0) + j, i = h.toValue(i + c[b ? "plotWidth" : "plotHeight"] - d, !0) - j;
                h.series.length && l > G(k.dataMin, k.min) && i < u(k.dataMax, k.max) && (h.setExtremes(l, i, !1, !1, {trigger: "pan"}), e = !0);
                c[b ? "mouseDownX" : "mouseDownY"] = d
            });
            e && c.redraw(!1);
            F(c.container, {cursor: "move"})
        }});
    r(Fa.prototype, {select: function (a, b) {
            var c = this, d = c.series, e = d.chart, a = p(a,
                    !c.selected);
            c.firePointEvent(a ? "select" : "unselect", {accumulate: b}, function () {
                c.selected = c.options.selected = a;
                d.options.data[Da(c, d.data)] = c.options;
                c.setState(a && "select");
                b || q(e.getSelectedPoints(), function (a) {
                    if (a.selected && a !== c)
                        a.selected = a.options.selected = !1, d.options.data[Da(a, d.data)] = a.options, a.setState(""), a.firePointEvent("unselect")
                })
            })
        }, onMouseOver: function (a) {
            var b = this.series, c = b.chart, d = c.tooltip, e = c.hoverPoint;
            if (e && e !== this)
                e.onMouseOut();
            this.firePointEvent("mouseOver");
            d && (!d.shared ||
                    b.noSharedTooltip) && d.refresh(this, a);
            this.setState("hover");
            c.hoverPoint = this
        }, onMouseOut: function () {
            var a = this.series.chart, b = a.hoverPoints;
            this.firePointEvent("mouseOut");
            if (!b || Da(this, b) === -1)
                this.setState(), a.hoverPoint = null
        }, importEvents: function () {
            if (!this.hasImportedEvents) {
                var a = y(this.series.options.point, this.options).events, b;
                this.events = a;
                for (b in a)
                    K(this, b, a[b]);
                this.hasImportedEvents = !0
            }
        }, setState: function (a, b) {
            var c = this.plotX, d = this.plotY, e = this.series, f = e.options.states, g = ca[e.type].marker &&
                    e.options.marker, h = g && !g.enabled, i = g && g.states[a], j = i && i.enabled === !1, k = e.stateMarkerGraphic, l = this.marker || {}, n = e.chart, m = e.halo, o, a = a || "";
            o = this.pointAttr[a] || e.pointAttr[a];
            if (!(a === this.state && !b || this.selected && a !== "select" || f[a] && f[a].enabled === !1 || a && (j || h && i.enabled === !1) || a && l.states && l.states[a] && l.states[a].enabled === !1)) {
                if (this.graphic)
                    g = g && this.graphic.symbolName && o.r, this.graphic.attr(y(o, g ? {x: c - g, y: d - g, width: 2 * g, height: 2 * g} : {})), k && k.hide();
                else {
                    if (a && i)
                        if (g = i.radius, l = l.symbol || e.symbol,
                                k && k.currentSymbol !== l && (k = k.destroy()), k)
                            k[b ? "animate" : "attr"]({x: c - g, y: d - g});
                        else if (l)
                            e.stateMarkerGraphic = k = n.renderer.symbol(l, c - g, d - g, 2 * g, 2 * g).attr(o).add(e.markerGroup), k.currentSymbol = l;
                    if (k)
                        k[a && n.isInsidePlot(c, d, n.inverted) ? "show" : "hide"]()
                }
                if ((c = f[a] && f[a].halo) && c.size) {
                    if (!m)
                        e.halo = m = n.renderer.path().add(e.seriesGroup);
                    m.attr(r({fill: ya(this.color || e.color).setOpacity(c.opacity).get()}, c.attributes))[b ? "animate" : "attr"]({d: this.haloPath(c.size)})
                } else
                    m && m.attr({d: []});
                this.state = a
            }
        },
        haloPath: function (a) {
            var b = this.series, c = b.chart, d = b.getPlotBox(), e = c.inverted;
            return c.renderer.symbols.circle(d.translateX + (e ? b.yAxis.len - this.plotY : this.plotX) - a, d.translateY + (e ? b.xAxis.len - this.plotX : this.plotY) - a, a * 2, a * 2)
        }});
    r(P.prototype, {onMouseOver: function () {
            var a = this.chart, b = a.hoverSeries;
            if (b && b !== this)
                b.onMouseOut();
            this.options.events.mouseOver && J(this, "mouseOver");
            this.setState("hover");
            a.hoverSeries = this
        }, onMouseOut: function () {
            var a = this.options, b = this.chart, c = b.tooltip, d = b.hoverPoint;
            if (d)
                d.onMouseOut();
            this && a.events.mouseOut && J(this, "mouseOut");
            c && !a.stickyTracking && (!c.shared || this.noSharedTooltip) && c.hide();
            this.setState();
            b.hoverSeries = null
        }, setState: function (a) {
            var b = this.options, c = this.graph, d = this.graphNeg, e = b.states, b = b.lineWidth, a = a || "";
            if (this.state !== a)
                this.state = a, e[a] && e[a].enabled === !1 || (a && (b = e[a].lineWidth || b + (e[a].lineWidthPlus || 0)), c && !c.dashstyle && (a = {"stroke-width": b}, c.attr(a), d && d.attr(a)))
        }, setVisible: function (a, b) {
            var c = this, d = c.chart, e = c.legendItem, f,
                    g = d.options.chart.ignoreHiddenSeries, h = c.visible;
            f = (c.visible = a = c.userOptions.visible = a === t ? !h : a) ? "show" : "hide";
            q(["group", "dataLabelsGroup", "markerGroup", "tracker"], function (a) {
                if (c[a])
                    c[a][f]()
            });
            if (d.hoverSeries === c)
                c.onMouseOut();
            e && d.legend.colorizeItem(c, a);
            c.isDirty = !0;
            c.options.stacking && q(d.series, function (a) {
                if (a.options.stacking && a.visible)
                    a.isDirty = !0
            });
            q(c.linkedSeries, function (b) {
                b.setVisible(a, !1)
            });
            if (g)
                d.isDirtyBox = !0;
            b !== !1 && d.redraw();
            J(c, f)
        }, setTooltipPoints: function (a) {
            var b =
                    [], c, d, e = this.xAxis, f = e && e.getExtremes(), g = e ? e.tooltipLen || e.len : this.chart.plotSizeX, h, i, j = [];
            if (!(this.options.enableMouseTracking === !1 || this.singularTooltips)) {
                if (a)
                    this.tooltipPoints = null;
                q(this.segments || this.points, function (a) {
                    b = b.concat(a)
                });
                e && e.reversed && (b = b.reverse());
                this.orderTooltipPoints && this.orderTooltipPoints(b);
                a = b.length;
                for (i = 0; i < a; i++)
                    if (e = b[i], c = e.x, c >= f.min && c <= f.max) {
                        h = b[i + 1];
                        c = d === t ? 0 : d + 1;
                        for (d = b[i + 1]?G(u(0, U((e.clientX + (h?h.wrappedClientX || h.clientX:g)) / 2)), g):g; c >= 0 && c <=
                                d; )
                            j[c++] = e
                    }
                this.tooltipPoints = j
            }
        }, show: function () {
            this.setVisible(!0)
        }, hide: function () {
            this.setVisible(!1)
        }, select: function (a) {
            this.selected = a = a === t ? !this.selected : a;
            if (this.checkbox)
                this.checkbox.checked = a;
            J(this, a ? "select" : "unselect")
        }, drawTracker: T.drawTrackerGraph});
    r(R, {Axis: ma, Chart: Za, Color: ya, Point: Fa, Tick: Ta, Renderer: $a, Series: P, SVGElement: O, SVGRenderer: ta, arrayMin: Oa, arrayMax: Ba, charts: W, dateFormat: db, format: Ja, pathAnim: vb, getOptions: function () {
            return Q
        }, hasBidiBug: Ob, isTouchDevice: Jb,
        numberFormat: Ha, seriesTypes: D, setOptions: function (a) {
            Q = y(!0, Q, a);
            Cb();
            return Q
        }, addEvent: K, removeEvent: X, createElement: Z, discardElement: Qa, css: F, each: q, extend: r, map: Va, merge: y, pick: p, splat: ra, extendClass: la, pInt: z, wrap: Na, svg: ba, canvas: ga, vml: !ba && !ga, product: "Highcharts", version: "4.0.1-modified"})
})();
