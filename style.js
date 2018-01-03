window.Modernizr = function(e, t, n) {
    function r(e) {
        b.cssText = e;
    }
    function o(e, t) {
        return r(C.join(e + ";") + (t || ""));
    }
    function i(e, t) {
        return typeof e === t;
    }
    function a(e, t) {
        return !!~("" + e).indexOf(t);
    }
    function s(e, t) {
        for (var r in e) {
            var o = e[r];
            if (!a(o, "-") && b[o] !== n) return "pfx" != t || o;
        }
        return !1;
    }
    function l(e, t, r) {
        for (var o in e) {
            var a = t[e[o]];
            if (a !== n) return r === !1 ? e[o] : i(a, "function") ? a.bind(r || t) : a;
        }
        return !1;
    }
    function c(e, t, n) {
        var r = e.charAt(0).toUpperCase() + e.slice(1), o = (e + " " + N.join(r + " ") + r).split(" ");
        return i(t, "string") || i(t, "undefined") ? s(o, t) : (o = (e + " " + T.join(r + " ") + r).split(" "), 
        l(o, t, n));
    }
    function u() {
        p.input = function(n) {
            for (var r = 0, o = n.length; r < o; r++) A[n[r]] = !!(n[r] in w);
            return A.list && (A.list = !(!t.createElement("datalist") || !e.HTMLDataListElement)), 
            A;
        }("autocomplete autofocus list placeholder max min multiple pattern required step".split(" ")), 
        p.inputtypes = function(e) {
            for (var r, o, i, a = 0, s = e.length; a < s; a++) w.setAttribute("type", o = e[a]), 
            r = "text" !== w.type, r && (w.value = x, w.style.cssText = "position:absolute;visibility:hidden;", 
            /^range$/.test(o) && w.style.WebkitAppearance !== n ? (g.appendChild(w), i = t.defaultView, 
            r = i.getComputedStyle && "textfield" !== i.getComputedStyle(w, null).WebkitAppearance && 0 !== w.offsetHeight, 
            g.removeChild(w)) : /^(search|tel)$/.test(o) || (r = /^(url|email)$/.test(o) ? w.checkValidity && w.checkValidity() === !1 : w.value != x)), 
            L[e[a]] = !!r;
            return L;
        }("search tel url email datetime date month week time datetime-local number range color".split(" "));
    }
    var d, f, h = "2.8.3", p = {}, m = !0, g = t.documentElement, v = "modernizr", y = t.createElement(v), b = y.style, w = t.createElement("input"), x = ":)", S = {}.toString, C = " -webkit- -moz- -o- -ms- ".split(" "), E = "Webkit Moz O ms", N = E.split(" "), T = E.toLowerCase().split(" "), k = {
        svg: "http://www.w3.org/2000/svg"
    }, P = {}, L = {}, A = {}, _ = [], H = _.slice, $ = function(e, n, r, o) {
        var i, a, s, l, c = t.createElement("div"), u = t.body, d = u || t.createElement("body");
        if (parseInt(r, 10)) for (;r--; ) s = t.createElement("div"), s.id = o ? o[r] : v + (r + 1), 
        c.appendChild(s);
        return i = [ "&#173;", '<style id="s', v, '">', e, "</style>" ].join(""), c.id = v, 
        (u ? c : d).innerHTML += i, d.appendChild(c), u || (d.style.background = "", d.style.overflow = "hidden", 
        l = g.style.overflow, g.style.overflow = "hidden", g.appendChild(d)), a = n(c, e), 
        u ? c.parentNode.removeChild(c) : (d.parentNode.removeChild(d), g.style.overflow = l), 
        !!a;
    }, R = function(t) {
        var n = e.matchMedia || e.msMatchMedia;
        if (n) return n(t) && n(t).matches || !1;
        var r;
        return $("@media " + t + " { #" + v + " { position: absolute; } }", function(t) {
            r = "absolute" == (e.getComputedStyle ? getComputedStyle(t, null) : t.currentStyle).position;
        }), r;
    }, M = function() {
        function e(e, o) {
            o = o || t.createElement(r[e] || "div"), e = "on" + e;
            var a = e in o;
            return a || (o.setAttribute || (o = t.createElement("div")), o.setAttribute && o.removeAttribute && (o.setAttribute(e, ""), 
            a = i(o[e], "function"), i(o[e], "undefined") || (o[e] = n), o.removeAttribute(e))), 
            o = null, a;
        }
        var r = {
            select: "input",
            change: "input",
            submit: "form",
            reset: "form",
            error: "img",
            load: "img",
            abort: "img"
        };
        return e;
    }(), O = {}.hasOwnProperty;
    f = i(O, "undefined") || i(O.call, "undefined") ? function(e, t) {
        return t in e && i(e.constructor.prototype[t], "undefined");
    } : function(e, t) {
        return O.call(e, t);
    }, Function.prototype.bind || (Function.prototype.bind = function(e) {
        var t = this;
        if ("function" != typeof t) throw new TypeError();
        var n = H.call(arguments, 1), r = function() {
            if (this instanceof r) {
                var o = function() {};
                o.prototype = t.prototype;
                var i = new o(), a = t.apply(i, n.concat(H.call(arguments)));
                return Object(a) === a ? a : i;
            }
            return t.apply(e, n.concat(H.call(arguments)));
        };
        return r;
    }), P.flexbox = function() {
        return c("flexWrap");
    }, P.flexboxlegacy = function() {
        return c("boxDirection");
    }, P.canvas = function() {
        var e = t.createElement("canvas");
        return !(!e.getContext || !e.getContext("2d"));
    }, P.canvastext = function() {
        return !(!p.canvas || !i(t.createElement("canvas").getContext("2d").fillText, "function"));
    }, P.webgl = function() {
        return !!e.WebGLRenderingContext;
    }, P.touch = function() {
        var n;
        return "ontouchstart" in e || e.DocumentTouch && t instanceof DocumentTouch ? n = !0 : $([ "@media (", C.join("touch-enabled),("), v, ")", "{#modernizr{top:9px;position:absolute}}" ].join(""), function(e) {
            n = 9 === e.offsetTop;
        }), n;
    }, P.geolocation = function() {
        return "geolocation" in navigator;
    }, P.postmessage = function() {
        return !!e.postMessage;
    }, P.websqldatabase = function() {
        return !!e.openDatabase;
    }, P.indexedDB = function() {
        return !!c("indexedDB", e);
    }, P.hashchange = function() {
        return M("hashchange", e) && (t.documentMode === n || t.documentMode > 7);
    }, P.history = function() {
        return !(!e.history || !history.pushState);
    }, P.draganddrop = function() {
        var e = t.createElement("div");
        return "draggable" in e || "ondragstart" in e && "ondrop" in e;
    }, P.websockets = function() {
        return "WebSocket" in e || "MozWebSocket" in e;
    }, P.rgba = function() {
        return r("background-color:rgba(150,255,150,.5)"), a(b.backgroundColor, "rgba");
    }, P.hsla = function() {
        return r("background-color:hsla(120,40%,100%,.5)"), a(b.backgroundColor, "rgba") || a(b.backgroundColor, "hsla");
    }, P.multiplebgs = function() {
        return r("background:url(https://),url(https://),red url(https://)"), /(url\s*\(.*?){3}/.test(b.background);
    }, P.backgroundsize = function() {
        return c("backgroundSize");
    }, P.borderimage = function() {
        return c("borderImage");
    }, P.borderradius = function() {
        return c("borderRadius");
    }, P.boxshadow = function() {
        return c("boxShadow");
    }, P.textshadow = function() {
        return "" === t.createElement("div").style.textShadow;
    }, P.opacity = function() {
        return o("opacity:.55"), /^0.55$/.test(b.opacity);
    }, P.cssanimations = function() {
        return c("animationName");
    }, P.csscolumns = function() {
        return c("columnCount");
    }, P.cssgradients = function() {
        var e = "background-image:", t = "gradient(linear,left top,right bottom,from(#9f9),to(white));", n = "linear-gradient(left top,#9f9, white);";
        return r((e + "-webkit- ".split(" ").join(t + e) + C.join(n + e)).slice(0, -e.length)), 
        a(b.backgroundImage, "gradient");
    }, P.cssreflections = function() {
        return c("boxReflect");
    }, P.csstransforms = function() {
        return !!c("transform");
    }, P.csstransforms3d = function() {
        var e = !!c("perspective");
        return e && "webkitPerspective" in g.style && $("@media (transform-3d),(-webkit-transform-3d){#modernizr{left:9px;position:absolute;height:3px;}}", function(t, n) {
            e = 9 === t.offsetLeft && 3 === t.offsetHeight;
        }), e;
    }, P.csstransitions = function() {
        return c("transition");
    }, P.fontface = function() {
        var e;
        return $('@font-face {font-family:"font";src:url("https://")}', function(n, r) {
            var o = t.getElementById("smodernizr"), i = o.sheet || o.styleSheet, a = i ? i.cssRules && i.cssRules[0] ? i.cssRules[0].cssText : i.cssText || "" : "";
            e = /src/i.test(a) && 0 === a.indexOf(r.split(" ")[0]);
        }), e;
    }, P.generatedcontent = function() {
        var e;
        return $([ "#", v, "{font:0/0 a}#", v, ':after{content:"', x, '";visibility:hidden;font:3px/1 a}' ].join(""), function(t) {
            e = t.offsetHeight >= 3;
        }), e;
    }, P.video = function() {
        var e = t.createElement("video"), n = !1;
        try {
            (n = !!e.canPlayType) && (n = new Boolean(n), n.ogg = e.canPlayType('video/ogg; codecs="theora"').replace(/^no$/, ""), 
            n.h264 = e.canPlayType('video/mp4; codecs="avc1.42E01E"').replace(/^no$/, ""), n.webm = e.canPlayType('video/webm; codecs="vp8, vorbis"').replace(/^no$/, ""));
        } catch (r) {}
        return n;
    }, P.audio = function() {
        var e = t.createElement("audio"), n = !1;
        try {
            (n = !!e.canPlayType) && (n = new Boolean(n), n.ogg = e.canPlayType('audio/ogg; codecs="vorbis"').replace(/^no$/, ""), 
            n.mp3 = e.canPlayType("audio/mpeg;").replace(/^no$/, ""), n.wav = e.canPlayType('audio/wav; codecs="1"').replace(/^no$/, ""), 
            n.m4a = (e.canPlayType("audio/x-m4a;") || e.canPlayType("audio/aac;")).replace(/^no$/, ""));
        } catch (r) {}
        return n;
    }, P.localstorage = function() {
        try {
            return localStorage.setItem(v, v), localStorage.removeItem(v), !0;
        } catch (e) {
            return !1;
        }
    }, P.sessionstorage = function() {
        try {
            return sessionStorage.setItem(v, v), sessionStorage.removeItem(v), !0;
        } catch (e) {
            return !1;
        }
    }, P.webworkers = function() {
        return !!e.Worker;
    }, P.applicationcache = function() {
        return !!e.applicationCache;
    }, P.svg = function() {
        return !!t.createElementNS && !!t.createElementNS(k.svg, "svg").createSVGRect;
    }, P.inlinesvg = function() {
        var e = t.createElement("div");
        return e.innerHTML = "<svg/>", (e.firstChild && e.firstChild.namespaceURI) == k.svg;
    }, P.smil = function() {
        return !!t.createElementNS && /SVGAnimate/.test(S.call(t.createElementNS(k.svg, "animate")));
    }, P.svgclippaths = function() {
        return !!t.createElementNS && /SVGClipPath/.test(S.call(t.createElementNS(k.svg, "clipPath")));
    };
    for (var B in P) f(P, B) && (d = B.toLowerCase(), p[d] = P[B](), _.push((p[d] ? "" : "no-") + d));
    return p.input || u(), p.addTest = function(e, t) {
        if ("object" == typeof e) for (var r in e) f(e, r) && p.addTest(r, e[r]); else {
            if (e = e.toLowerCase(), p[e] !== n) return p;
            t = "function" == typeof t ? t() : t, "undefined" != typeof m && m && (g.className += " " + (t ? "" : "no-") + e), 
            p[e] = t;
        }
        return p;
    }, r(""), y = w = null, function(e, t) {
        function n(e, t) {
            var n = e.createElement("p"), r = e.getElementsByTagName("head")[0] || e.documentElement;
            return n.innerHTML = "x<style>" + t + "</style>", r.insertBefore(n.lastChild, r.firstChild);
        }
        function r() {
            var e = y.elements;
            return "string" == typeof e ? e.split(" ") : e;
        }
        function o(e) {
            var t = v[e[m]];
            return t || (t = {}, g++, e[m] = g, v[g] = t), t;
        }
        function i(e, n, r) {
            if (n || (n = t), u) return n.createElement(e);
            r || (r = o(n));
            var i;
            return i = r.cache[e] ? r.cache[e].cloneNode() : p.test(e) ? (r.cache[e] = r.createElem(e)).cloneNode() : r.createElem(e), 
            !i.canHaveChildren || h.test(e) || i.tagUrn ? i : r.frag.appendChild(i);
        }
        function a(e, n) {
            if (e || (e = t), u) return e.createDocumentFragment();
            n = n || o(e);
            for (var i = n.frag.cloneNode(), a = 0, s = r(), l = s.length; a < l; a++) i.createElement(s[a]);
            return i;
        }
        function s(e, t) {
            t.cache || (t.cache = {}, t.createElem = e.createElement, t.createFrag = e.createDocumentFragment, 
            t.frag = t.createFrag()), e.createElement = function(n) {
                return y.shivMethods ? i(n, e, t) : t.createElem(n);
            }, e.createDocumentFragment = Function("h,f", "return function(){var n=f.cloneNode(),c=n.createElement;h.shivMethods&&(" + r().join().replace(/[\w\-]+/g, function(e) {
                return t.createElem(e), t.frag.createElement(e), 'c("' + e + '")';
            }) + ");return n}")(y, t.frag);
        }
        function l(e) {
            e || (e = t);
            var r = o(e);
            return !y.shivCSS || c || r.hasCSS || (r.hasCSS = !!n(e, "article,aside,dialog,figcaption,figure,footer,header,hgroup,main,nav,section{display:block}mark{background:#FF0;color:#000}template{display:none}")), 
            u || s(e, r), e;
        }
        var c, u, d = "3.7.0", f = e.html5 || {}, h = /^<|^(?:button|map|select|textarea|object|iframe|option|optgroup)$/i, p = /^(?:a|b|code|div|fieldset|h1|h2|h3|h4|h5|h6|i|label|li|ol|p|q|span|strong|style|table|tbody|td|th|tr|ul)$/i, m = "_html5shiv", g = 0, v = {};
        !function() {
            try {
                var e = t.createElement("a");
                e.innerHTML = "<xyz></xyz>", c = "hidden" in e, u = 1 == e.childNodes.length || function() {
                    t.createElement("a");
                    var e = t.createDocumentFragment();
                    return "undefined" == typeof e.cloneNode || "undefined" == typeof e.createDocumentFragment || "undefined" == typeof e.createElement;
                }();
            } catch (n) {
                c = !0, u = !0;
            }
        }();
        var y = {
            elements: f.elements || "abbr article aside audio bdi canvas data datalist details dialog figcaption figure footer header hgroup main mark meter nav output progress section summary template time video",
            version: d,
            shivCSS: f.shivCSS !== !1,
            supportsUnknownElements: u,
            shivMethods: f.shivMethods !== !1,
            type: "default",
            shivDocument: l,
            createElement: i,
            createDocumentFragment: a
        };
        e.html5 = y, l(t);
    }(this, t), p._version = h, p._prefixes = C, p._domPrefixes = T, p._cssomPrefixes = N, 
    p.mq = R, p.hasEvent = M, p.testProp = function(e) {
        return s([ e ]);
    }, p.testAllProps = c, p.testStyles = $, p.prefixed = function(e, t, n) {
        return t ? c(e, t, n) : c(e, "pfx");
    }, g.className = g.className.replace(/(^|\s)no-js(\s|$)/, "$1$2") + (m ? " js " + _.join(" ") : ""), 
    p;
}(this, this.document);

var IN_GLOBAL_SCOPE = !0;

window.PR_SHOULD_USE_CONTINUATION = !0;

var prettyPrintOne, prettyPrint;

!function() {
    function e(e) {
        function t(e) {
            var t = e.charCodeAt(0);
            if (92 !== t) return t;
            var n = e.charAt(1);
            return t = d[n], t ? t : "0" <= n && n <= "7" ? parseInt(e.substring(1), 8) : "u" === n || "x" === n ? parseInt(e.substring(2), 16) : e.charCodeAt(1);
        }
        function n(e) {
            if (e < 32) return (e < 16 ? "\\x0" : "\\x") + e.toString(16);
            var t = String.fromCharCode(e);
            return "\\" === t || "-" === t || "]" === t || "^" === t ? "\\" + t : t;
        }
        function r(e) {
            var r = e.substring(1, e.length - 1).match(new RegExp("\\\\u[0-9A-Fa-f]{4}|\\\\x[0-9A-Fa-f]{2}|\\\\[0-3][0-7]{0,2}|\\\\[0-7]{1,2}|\\\\[\\s\\S]|-|[^-\\\\]", "g")), o = [], i = "^" === r[0], a = [ "[" ];
            i && a.push("^");
            for (var s = i ? 1 : 0, l = r.length; s < l; ++s) {
                var c = r[s];
                if (/\\[bdsw]/i.test(c)) a.push(c); else {
                    var u, d = t(c);
                    s + 2 < l && "-" === r[s + 1] ? (u = t(r[s + 2]), s += 2) : u = d, o.push([ d, u ]), 
                    u < 65 || d > 122 || (u < 65 || d > 90 || o.push([ 32 | Math.max(65, d), 32 | Math.min(u, 90) ]), 
                    u < 97 || d > 122 || o.push([ Math.max(97, d) & -33, Math.min(u, 122) & -33 ]));
                }
            }
            o.sort(function(e, t) {
                return e[0] - t[0] || t[1] - e[1];
            });
            for (var f = [], h = [], s = 0; s < o.length; ++s) {
                var p = o[s];
                p[0] <= h[1] + 1 ? h[1] = Math.max(h[1], p[1]) : f.push(h = p);
            }
            for (var s = 0; s < f.length; ++s) {
                var p = f[s];
                a.push(n(p[0])), p[1] > p[0] && (p[1] + 1 > p[0] && a.push("-"), a.push(n(p[1])));
            }
            return a.push("]"), a.join("");
        }
        function o(e) {
            for (var t = e.source.match(new RegExp("(?:\\[(?:[^\\x5C\\x5D]|\\\\[\\s\\S])*\\]|\\\\u[A-Fa-f0-9]{4}|\\\\x[A-Fa-f0-9]{2}|\\\\[0-9]+|\\\\[^ux0-9]|\\(\\?[:!=]|[\\(\\)\\^]|[^\\x5B\\x5C\\(\\)\\^]+)", "g")), o = t.length, s = [], l = 0, c = 0; l < o; ++l) {
                var u = t[l];
                if ("(" === u) ++c; else if ("\\" === u.charAt(0)) {
                    var d = +u.substring(1);
                    d && (d <= c ? s[d] = -1 : t[l] = n(d));
                }
            }
            for (var l = 1; l < s.length; ++l) -1 === s[l] && (s[l] = ++i);
            for (var l = 0, c = 0; l < o; ++l) {
                var u = t[l];
                if ("(" === u) ++c, s[c] || (t[l] = "(?:"); else if ("\\" === u.charAt(0)) {
                    var d = +u.substring(1);
                    d && d <= c && (t[l] = "\\" + s[d]);
                }
            }
            for (var l = 0; l < o; ++l) "^" === t[l] && "^" !== t[l + 1] && (t[l] = "");
            if (e.ignoreCase && a) for (var l = 0; l < o; ++l) {
                var u = t[l], f = u.charAt(0);
                u.length >= 2 && "[" === f ? t[l] = r(u) : "\\" !== f && (t[l] = u.replace(/[a-zA-Z]/g, function(e) {
                    var t = e.charCodeAt(0);
                    return "[" + String.fromCharCode(t & -33, 32 | t) + "]";
                }));
            }
            return t.join("");
        }
        for (var i = 0, a = !1, s = !1, l = 0, c = e.length; l < c; ++l) {
            var u = e[l];
            if (u.ignoreCase) s = !0; else if (/[a-z]/i.test(u.source.replace(/\\u[0-9a-f]{4}|\\x[0-9a-f]{2}|\\[^ux]/gi, ""))) {
                a = !0, s = !1;
                break;
            }
        }
        for (var d = {
            b: 8,
            t: 9,
            n: 10,
            v: 11,
            f: 12,
            r: 13
        }, f = [], l = 0, c = e.length; l < c; ++l) {
            var u = e[l];
            if (u.global || u.multiline) throw new Error("" + u);
            f.push("(?:" + o(u) + ")");
        }
        return new RegExp(f.join("|"), s ? "gi" : "g");
    }
    function t(e, t) {
        function n(e) {
            var l = e.nodeType;
            if (1 == l) {
                if (r.test(e.className)) return;
                for (var c = e.firstChild; c; c = c.nextSibling) n(c);
                var u = e.nodeName.toLowerCase();
                "br" !== u && "li" !== u || (o[s] = "\n", a[s << 1] = i++, a[s++ << 1 | 1] = e);
            } else if (3 == l || 4 == l) {
                var d = e.nodeValue;
                d.length && (d = t ? d.replace(/\r\n?/g, "\n") : d.replace(/[ \t\r\n]+/g, " "), 
                o[s] = d, a[s << 1] = i, i += d.length, a[s++ << 1 | 1] = e);
            }
        }
        var r = /(?:^|\s)nocode(?:\s|$)/, o = [], i = 0, a = [], s = 0;
        return n(e), {
            sourceCode: o.join("").replace(/\n$/, ""),
            spans: a
        };
    }
    function n(e, t, n, r) {
        if (t) {
            var o = {
                sourceCode: t,
                basePos: e
            };
            n(o), r.push.apply(r, o.decorations);
        }
    }
    function r(e) {
        for (var t = void 0, n = e.firstChild; n; n = n.nextSibling) {
            var r = n.nodeType;
            t = 1 === r ? t ? e : n : 3 === r && U.test(n.nodeValue) ? e : t;
        }
        return t === e ? void 0 : t;
    }
    function o(t, r) {
        var o, i = {};
        !function() {
            for (var n = t.concat(r), a = [], s = {}, l = 0, c = n.length; l < c; ++l) {
                var u = n[l], d = u[3];
                if (d) for (var f = d.length; --f >= 0; ) i[d.charAt(f)] = u;
                var h = u[1], p = "" + h;
                s.hasOwnProperty(p) || (a.push(h), s[p] = null);
            }
            a.push(/[\0-\uffff]/), o = e(a);
        }();
        var a = r.length, s = function(e) {
            for (var t = e.sourceCode, l = e.basePos, u = [ l, M ], d = 0, f = t.match(o) || [], h = {}, p = 0, m = f.length; p < m; ++p) {
                var g, v = f[p], y = h[v], b = void 0;
                if ("string" == typeof y) g = !1; else {
                    var w = i[v.charAt(0)];
                    if (w) b = v.match(w[1]), y = w[0]; else {
                        for (var x = 0; x < a; ++x) if (w = r[x], b = v.match(w[1])) {
                            y = w[0];
                            break;
                        }
                        b || (y = M);
                    }
                    g = y.length >= 5 && "lang-" === y.substring(0, 5), !g || b && "string" == typeof b[1] || (g = !1, 
                    y = j), g || (h[v] = y);
                }
                var S = d;
                if (d += v.length, g) {
                    var C = b[1], E = v.indexOf(C), N = E + C.length;
                    b[2] && (N = v.length - b[2].length, E = N - C.length);
                    var T = y.substring(5);
                    n(l + S, v.substring(0, E), s, u), n(l + S + E, C, c(T, C), u), n(l + S + N, v.substring(N), s, u);
                } else u.push(l + S, y);
            }
            e.decorations = u;
        };
        return s;
    }
    function i(e) {
        var t = [], n = [];
        e.tripleQuotedStrings ? t.push([ L, /^(?:\'\'\'(?:[^\'\\]|\\[\s\S]|\'{1,2}(?=[^\']))*(?:\'\'\'|$)|\"\"\"(?:[^\"\\]|\\[\s\S]|\"{1,2}(?=[^\"]))*(?:\"\"\"|$)|\'(?:[^\\\']|\\[\s\S])*(?:\'|$)|\"(?:[^\\\"]|\\[\s\S])*(?:\"|$))/, null, "'\"" ]) : e.multiLineStrings ? t.push([ L, /^(?:\'(?:[^\\\']|\\[\s\S])*(?:\'|$)|\"(?:[^\\\"]|\\[\s\S])*(?:\"|$)|\`(?:[^\\\`]|\\[\s\S])*(?:\`|$))/, null, "'\"`" ]) : t.push([ L, /^(?:\'(?:[^\\\'\r\n]|\\.)*(?:\'|$)|\"(?:[^\\\"\r\n]|\\.)*(?:\"|$))/, null, "\"'" ]), 
        e.verbatimStrings && n.push([ L, /^@\"(?:[^\"]|\"\")*(?:\"|$)/, null ]);
        var r = e.hashComments;
        r && (e.cStyleComments ? (r > 1 ? t.push([ _, /^#(?:##(?:[^#]|#(?!##))*(?:###|$)|.*)/, null, "#" ]) : t.push([ _, /^#(?:(?:define|e(?:l|nd)if|else|error|ifn?def|include|line|pragma|undef|warning)\b|[^\r\n]*)/, null, "#" ]), 
        n.push([ L, /^<(?:(?:(?:\.\.\/)*|\/?)(?:[\w-]+(?:\/[\w-]+)+)?[\w-]+\.h(?:h|pp|\+\+)?|[a-z]\w*)>/, null ])) : t.push([ _, /^#[^\r\n]*/, null, "#" ])), 
        e.cStyleComments && (n.push([ _, /^\/\/[^\r\n]*/, null ]), n.push([ _, /^\/\*[\s\S]*?(?:\*\/|$)/, null ]));
        var i = e.regexLiterals;
        if (i) {
            var a = i > 1 ? "" : "\n\r", s = a ? "." : "[\\S\\s]", l = "/(?=[^/*" + a + "])(?:[^/\\x5B\\x5C" + a + "]|\\x5C" + s + "|\\x5B(?:[^\\x5C\\x5D" + a + "]|\\x5C" + s + ")*(?:\\x5D|$))+/";
            n.push([ "lang-regex", RegExp("^" + F + "(" + l + ")") ]);
        }
        var c = e.types;
        c && n.push([ H, c ]);
        var u = ("" + e.keywords).replace(/^ | $/g, "");
        u.length && n.push([ A, new RegExp("^(?:" + u.replace(/[\s,]+/g, "|") + ")\\b"), null ]), 
        t.push([ M, /^\s+/, null, " \r\n\t " ]);
        var d = "^.[^\\s\\w.$@'\"`/\\\\]*";
        return e.regexLiterals && (d += "(?!s*/)"), n.push([ $, /^@[a-z_$][a-z_$@0-9]*/i, null ], [ H, /^(?:[@_]?[A-Z]+[a-z][A-Za-z_$@0-9]*|\w+_t\b)/, null ], [ M, /^[a-z_$][a-z_$@0-9]*/i, null ], [ $, new RegExp("^(?:0x[a-f0-9]+|(?:\\d(?:_\\d+)*\\d*(?:\\.\\d*)?|\\.\\d\\+)(?:e[+\\-]?\\d+)?)[a-z]*", "i"), null, "0123456789" ], [ M, /^\\[\s\S]?/, null ], [ R, new RegExp(d), null ]), 
        o(t, n);
    }
    function a(e, t, n) {
        function r(e) {
            var t = e.nodeType;
            if (1 != t || i.test(e.className)) {
                if ((3 == t || 4 == t) && n) {
                    var l = e.nodeValue, c = l.match(a);
                    if (c) {
                        var u = l.substring(0, c.index);
                        e.nodeValue = u;
                        var d = l.substring(c.index + c[0].length);
                        if (d) {
                            var f = e.parentNode;
                            f.insertBefore(s.createTextNode(d), e.nextSibling);
                        }
                        o(e), u || e.parentNode.removeChild(e);
                    }
                }
            } else if ("br" === e.nodeName) o(e), e.parentNode && e.parentNode.removeChild(e); else for (var h = e.firstChild; h; h = h.nextSibling) r(h);
        }
        function o(e) {
            function t(e, n) {
                var r = n ? e.cloneNode(!1) : e, o = e.parentNode;
                if (o) {
                    var i = t(o, 1), a = e.nextSibling;
                    i.appendChild(r);
                    for (var s = a; s; s = a) a = s.nextSibling, i.appendChild(s);
                }
                return r;
            }
            for (;!e.nextSibling; ) if (e = e.parentNode, !e) return;
            for (var n, r = t(e.nextSibling, 0); (n = r.parentNode) && 1 === n.nodeType; ) r = n;
            c.push(r);
        }
        for (var i = /(?:^|\s)nocode(?:\s|$)/, a = /\r\n?|\n/, s = e.ownerDocument, l = s.createElement("li"); e.firstChild; ) l.appendChild(e.firstChild);
        for (var c = [ l ], u = 0; u < c.length; ++u) r(c[u]);
        t === (0 | t) && c[0].setAttribute("value", t);
        var d = s.createElement("ol");
        d.className = "linenums";
        for (var f = Math.max(0, t - 1 | 0) || 0, u = 0, h = c.length; u < h; ++u) l = c[u], 
        l.className = "L" + (u + f) % 10, l.firstChild || l.appendChild(s.createTextNode(" ")), 
        d.appendChild(l);
        e.appendChild(d);
    }
    function s(e) {
        var t = /\bMSIE\s(\d+)/.exec(navigator.userAgent);
        t = t && +t[1] <= 8;
        var n = /\n/g, r = e.sourceCode, o = r.length, i = 0, a = e.spans, s = a.length, l = 0, c = e.decorations, u = c.length, d = 0;
        c[u] = o;
        var f, h;
        for (h = f = 0; h < u; ) c[h] !== c[h + 2] ? (c[f++] = c[h++], c[f++] = c[h++]) : h += 2;
        for (u = f, h = f = 0; h < u; ) {
            for (var p = c[h], m = c[h + 1], g = h + 2; g + 2 <= u && c[g + 1] === m; ) g += 2;
            c[f++] = p, c[f++] = m, h = g;
        }
        u = c.length = f;
        var v, y = e.sourceNode;
        y && (v = y.style.display, y.style.display = "none");
        try {
            for (;l < s; ) {
                var b, w = (a[l], a[l + 2] || o), x = c[d + 2] || o, g = Math.min(w, x), S = a[l + 1];
                if (1 !== S.nodeType && (b = r.substring(i, g))) {
                    t && (b = b.replace(n, "\r")), S.nodeValue = b;
                    var C = S.ownerDocument, E = C.createElement("span");
                    E.className = c[d + 1];
                    var N = S.parentNode;
                    N.replaceChild(E, S), E.appendChild(S), i < w && (a[l + 1] = S = C.createTextNode(r.substring(g, w)), 
                    N.insertBefore(S, E.nextSibling));
                }
                i = g, i >= w && (l += 2), i >= x && (d += 2);
            }
        } finally {
            y && (y.style.display = v);
        }
    }
    function l(e, t) {
        for (var n = t.length; --n >= 0; ) {
            var r = t[n];
            q.hasOwnProperty(r) ? h.console && console.warn("cannot override language handler %s", r) : q[r] = e;
        }
    }
    function c(e, t) {
        return e && q.hasOwnProperty(e) || (e = /^\s*</.test(t) ? "default-markup" : "default-code"), 
        q[e];
    }
    function u(e) {
        var n = e.langExtension;
        try {
            var r = t(e.sourceNode, e.pre), o = r.sourceCode;
            e.sourceCode = o, e.spans = r.spans, e.basePos = 0, c(n, o)(e), s(e);
        } catch (i) {
            h.console && console.log(i && i.stack || i);
        }
    }
    function d(e, t, n) {
        var r = document.createElement("div");
        r.innerHTML = "<pre>" + e + "</pre>", r = r.firstChild, n && a(r, n, !0);
        var o = {
            langExtension: t,
            numberLines: n,
            sourceNode: r,
            pre: 1
        };
        return u(o), r.innerHTML;
    }
    function f(e, t) {
        function n(e) {
            return i.getElementsByTagName(e);
        }
        function o() {
            for (var t = h.PR_SHOULD_USE_CONTINUATION ? m.now() + 250 : 1 / 0; v < c.length && m.now() < t; v++) {
                for (var n = c[v], i = E, l = n; l = l.previousSibling; ) {
                    var d = l.nodeType, f = (7 === d || 8 === d) && l.nodeValue;
                    if (f ? !/^\??prettify\b/.test(f) : 3 !== d || /\S/.test(l.nodeValue)) break;
                    if (f) {
                        i = {}, f.replace(/\b(\w+)=([\w:.%+-]+)/g, function(e, t, n) {
                            i[t] = n;
                        });
                        break;
                    }
                }
                var p = n.className;
                if ((i !== E || b.test(p)) && !w.test(p)) {
                    for (var N = !1, T = n.parentNode; T; T = T.parentNode) {
                        var k = T.tagName;
                        if (C.test(k) && T.className && b.test(T.className)) {
                            N = !0;
                            break;
                        }
                    }
                    if (!N) {
                        n.className += " prettyprinted";
                        var P = i.lang;
                        if (!P) {
                            P = p.match(y);
                            var L;
                            !P && (L = r(n)) && S.test(L.tagName) && (P = L.className.match(y)), P && (P = P[1]);
                        }
                        var A;
                        if (x.test(n.tagName)) A = 1; else {
                            var _ = n.currentStyle, H = s.defaultView, $ = _ ? _.whiteSpace : H && H.getComputedStyle ? H.getComputedStyle(n, null).getPropertyValue("white-space") : 0;
                            A = $ && "pre" === $.substring(0, 3);
                        }
                        var R = i.linenums;
                        (R = "true" === R || +R) || (R = p.match(/\blinenums\b(?::(\d+))?/), R = !!R && (!R[1] || !R[1].length || +R[1])), 
                        R && a(n, R, A), g = {
                            langExtension: P,
                            sourceNode: n,
                            numberLines: R,
                            pre: A
                        }, u(g);
                    }
                }
            }
            v < c.length ? setTimeout(o, 250) : "function" == typeof e && e();
        }
        for (var i = t || document.body, s = i.ownerDocument || document, l = [ n("pre"), n("code"), n("xmp") ], c = [], d = 0; d < l.length; ++d) for (var f = 0, p = l[d].length; f < p; ++f) c.push(l[d][f]);
        l = null;
        var m = Date;
        m.now || (m = {
            now: function() {
                return +new Date();
            }
        });
        var g, v = 0, y = /\blang(?:uage)?-([\w.]+)(?!\S)/, b = /\bprettyprint\b/, w = /\bprettyprinted\b/, x = /pre|xmp/i, S = /^code$/i, C = /^(?:pre|code|xmp)$/i, E = {};
        o();
    }
    var h = window, p = [ "break,continue,do,else,for,if,return,while" ], m = [ p, "auto,case,char,const,default,double,enum,extern,float,goto,inline,int,long,register,short,signed,sizeof,static,struct,switch,typedef,union,unsigned,void,volatile" ], g = [ m, "catch,class,delete,false,import,new,operator,private,protected,public,this,throw,true,try,typeof" ], v = [ g, "alignof,align_union,asm,axiom,bool,concept,concept_map,const_cast,constexpr,decltype,delegate,dynamic_cast,explicit,export,friend,generic,late_check,mutable,namespace,nullptr,property,reinterpret_cast,static_assert,static_cast,template,typeid,typename,using,virtual,where" ], y = [ g, "abstract,assert,boolean,byte,extends,final,finally,implements,import,instanceof,interface,null,native,package,strictfp,super,synchronized,throws,transient" ], b = [ y, "as,base,by,checked,decimal,delegate,descending,dynamic,event,fixed,foreach,from,group,implicit,in,internal,into,is,let,lock,object,out,override,orderby,params,partial,readonly,ref,sbyte,sealed,stackalloc,string,select,uint,ulong,unchecked,unsafe,ushort,var,virtual,where" ], w = "all,and,by,catch,class,else,extends,false,finally,for,if,in,is,isnt,loop,new,no,not,null,of,off,on,or,return,super,then,throw,true,try,unless,until,when,while,yes", x = [ g, "debugger,eval,export,function,get,null,set,undefined,var,with,Infinity,NaN" ], S = "caller,delete,die,do,dump,elsif,eval,exit,foreach,for,goto,if,import,last,local,my,next,no,our,print,package,redo,require,sub,undef,unless,until,use,wantarray,while,BEGIN,END", C = [ p, "and,as,assert,class,def,del,elif,except,exec,finally,from,global,import,in,is,lambda,nonlocal,not,or,pass,print,raise,try,with,yield,False,True,None" ], E = [ p, "alias,and,begin,case,class,def,defined,elsif,end,ensure,false,in,module,next,nil,not,or,redo,rescue,retry,self,super,then,true,undef,unless,until,when,yield,BEGIN,END" ], N = [ p, "as,assert,const,copy,drop,enum,extern,fail,false,fn,impl,let,log,loop,match,mod,move,mut,priv,pub,pure,ref,self,static,struct,true,trait,type,unsafe,use" ], T = [ p, "case,done,elif,esac,eval,fi,function,in,local,set,then,until" ], k = [ v, b, x, S, C, E, T ], P = /^(DIR|FILE|vector|(de|priority_)?queue|list|stack|(const_)?iterator|(multi)?(set|map)|bitset|u?(int|float)\d*)\b/, L = "str", A = "kwd", _ = "com", H = "typ", $ = "lit", R = "pun", M = "pln", O = "tag", B = "dec", j = "src", D = "atn", z = "atv", I = "nocode", F = "(?:^^\\.?|[+-]|[!=]=?=?|\\#|%=?|&&?=?|\\(|\\*=?|[+\\-]=|->|\\/=?|::?|<<?=?|>>?>?=?|,|;|\\?|@|\\[|~|{|\\^\\^?=?|\\|\\|?=?|break|case|continue|delete|do|else|finally|instanceof|return|throw|try|typeof)\\s*", U = /\S/, V = i({
        keywords: k,
        hashComments: !0,
        cStyleComments: !0,
        multiLineStrings: !0,
        regexLiterals: !0
    }), q = {};
    l(V, [ "default-code" ]), l(o([], [ [ M, /^[^<?]+/ ], [ B, /^<!\w[^>]*(?:>|$)/ ], [ _, /^<\!--[\s\S]*?(?:-\->|$)/ ], [ "lang-", /^<\?([\s\S]+?)(?:\?>|$)/ ], [ "lang-", /^<%([\s\S]+?)(?:%>|$)/ ], [ R, /^(?:<[%?]|[%?]>)/ ], [ "lang-", /^<xmp\b[^>]*>([\s\S]+?)<\/xmp\b[^>]*>/i ], [ "lang-js", /^<script\b[^>]*>([\s\S]*?)(<\/script\b[^>]*>)/i ], [ "lang-css", /^<style\b[^>]*>([\s\S]*?)(<\/style\b[^>]*>)/i ], [ "lang-in.tag", /^(<\/?[a-z][^<>]*>)/i ] ]), [ "default-markup", "htm", "html", "mxml", "xhtml", "xml", "xsl" ]), 
    l(o([ [ M, /^[\s]+/, null, " \t\r\n" ], [ z, /^(?:\"[^\"]*\"?|\'[^\']*\'?)/, null, "\"'" ] ], [ [ O, /^^<\/?[a-z](?:[\w.:-]*\w)?|\/?>$/i ], [ D, /^(?!style[\s=]|on)[a-z](?:[\w:-]*\w)?/i ], [ "lang-uq.val", /^=\s*([^>\'\"\s]*(?:[^>\'\"\s\/]|\/(?=\s)))/ ], [ R, /^[=<>\/]+/ ], [ "lang-js", /^on\w+\s*=\s*\"([^\"]+)\"/i ], [ "lang-js", /^on\w+\s*=\s*\'([^\']+)\'/i ], [ "lang-js", /^on\w+\s*=\s*([^\"\'>\s]+)/i ], [ "lang-css", /^style\s*=\s*\"([^\"]+)\"/i ], [ "lang-css", /^style\s*=\s*\'([^\']+)\'/i ], [ "lang-css", /^style\s*=\s*([^\"\'>\s]+)/i ] ]), [ "in.tag" ]), 
    l(o([], [ [ z, /^[\s\S]+/ ] ]), [ "uq.val" ]), l(i({
        keywords: v,
        hashComments: !0,
        cStyleComments: !0,
        types: P
    }), [ "c", "cc", "cpp", "cxx", "cyc", "m" ]), l(i({
        keywords: "null,true,false"
    }), [ "json" ]), l(i({
        keywords: b,
        hashComments: !0,
        cStyleComments: !0,
        verbatimStrings: !0,
        types: P
    }), [ "cs" ]), l(i({
        keywords: y,
        cStyleComments: !0
    }), [ "java" ]), l(i({
        keywords: T,
        hashComments: !0,
        multiLineStrings: !0
    }), [ "bash", "bsh", "csh", "sh" ]), l(i({
        keywords: C,
        hashComments: !0,
        multiLineStrings: !0,
        tripleQuotedStrings: !0
    }), [ "cv", "py", "python" ]), l(i({
        keywords: S,
        hashComments: !0,
        multiLineStrings: !0,
        regexLiterals: 2
    }), [ "perl", "pl", "pm" ]), l(i({
        keywords: E,
        hashComments: !0,
        multiLineStrings: !0,
        regexLiterals: !0
    }), [ "rb", "ruby" ]), l(i({
        keywords: x,
        cStyleComments: !0,
        regexLiterals: !0
    }), [ "javascript", "js" ]), l(i({
        keywords: w,
        hashComments: 3,
        cStyleComments: !0,
        multilineStrings: !0,
        tripleQuotedStrings: !0,
        regexLiterals: !0
    }), [ "coffee" ]), l(i({
        keywords: N,
        cStyleComments: !0,
        multilineStrings: !0
    }), [ "rc", "rs", "rust" ]), l(o([], [ [ L, /^[\s\S]+/ ] ]), [ "regex" ]);
    var Y = h.PR = {
        createSimpleLexer: o,
        registerLangHandler: l,
        sourceDecorator: i,
        PR_ATTRIB_NAME: D,
        PR_ATTRIB_VALUE: z,
        PR_COMMENT: _,
        PR_DECLARATION: B,
        PR_KEYWORD: A,
        PR_LITERAL: $,
        PR_NOCODE: I,
        PR_PLAIN: M,
        PR_PUNCTUATION: R,
        PR_SOURCE: j,
        PR_STRING: L,
        PR_TAG: O,
        PR_TYPE: H,
        prettyPrintOne: IN_GLOBAL_SCOPE ? h.prettyPrintOne = d : prettyPrintOne = d,
        prettyPrint: prettyPrint = IN_GLOBAL_SCOPE ? h.prettyPrint = f : prettyPrint = f
    };
    "function" == typeof define && define.amd && define("google-code-prettify", [], function() {
        return Y;
    });
}(), function(e, t) {
    "use strict";
    "function" == typeof define && define.amd ? define([], t) : "object" == typeof exports ? module.exports = t() : e.Headroom = t();
}(this, function() {
    "use strict";
    function e(e) {
        this.callback = e, this.ticking = !1;
    }
    function t(e) {
        return e && "undefined" != typeof window && (e === window || e.nodeType);
    }
    function n(e) {
        if (arguments.length <= 0) throw new Error("Missing arguments in extend function");
        var r, o, i = e || {};
        for (o = 1; o < arguments.length; o++) {
            var a = arguments[o] || {};
            for (r in a) "object" != typeof i[r] || t(i[r]) ? i[r] = i[r] || a[r] : i[r] = n(i[r], a[r]);
        }
        return i;
    }
    function r(e) {
        return e === Object(e) ? e : {
            down: e,
            up: e
        };
    }
    function o(e, t) {
        t = n(t, o.options), this.lastKnownScrollY = 0, this.elem = e, this.tolerance = r(t.tolerance), 
        this.classes = t.classes, this.offset = t.offset, this.scroller = t.scroller, this.initialised = !1, 
        this.onPin = t.onPin, this.onUnpin = t.onUnpin, this.onTop = t.onTop, this.onNotTop = t.onNotTop, 
        this.onBottom = t.onBottom, this.onNotBottom = t.onNotBottom;
    }
    var i = {
        bind: !!function() {}.bind,
        classList: "classList" in document.documentElement,
        rAF: !!(window.requestAnimationFrame || window.webkitRequestAnimationFrame || window.mozRequestAnimationFrame)
    };
    return window.requestAnimationFrame = window.requestAnimationFrame || window.webkitRequestAnimationFrame || window.mozRequestAnimationFrame, 
    e.prototype = {
        constructor: e,
        update: function() {
            this.callback && this.callback(), this.ticking = !1;
        },
        requestTick: function() {
            this.ticking || (requestAnimationFrame(this.rafCallback || (this.rafCallback = this.update.bind(this))), 
            this.ticking = !0);
        },
        handleEvent: function() {
            this.requestTick();
        }
    }, o.prototype = {
        constructor: o,
        init: function() {
            if (o.cutsTheMustard) return this.debouncer = new e(this.update.bind(this)), this.elem.classList.add(this.classes.initial), 
            setTimeout(this.attachEvent.bind(this), 100), this;
        },
        destroy: function() {
            var e = this.classes;
            this.initialised = !1, this.elem.classList.remove(e.unpinned, e.pinned, e.top, e.notTop, e.initial), 
            this.scroller.removeEventListener("scroll", this.debouncer, !1);
        },
        attachEvent: function() {
            this.initialised || (this.lastKnownScrollY = this.getScrollY(), this.initialised = !0, 
            this.scroller.addEventListener("scroll", this.debouncer, !1), this.debouncer.handleEvent());
        },
        unpin: function() {
            var e = this.elem.classList, t = this.classes;
            !e.contains(t.pinned) && e.contains(t.unpinned) || (e.add(t.unpinned), e.remove(t.pinned), 
            this.onUnpin && this.onUnpin.call(this));
        },
        pin: function() {
            var e = this.elem.classList, t = this.classes;
            e.contains(t.unpinned) && (e.remove(t.unpinned), e.add(t.pinned), this.onPin && this.onPin.call(this));
        },
        top: function() {
            var e = this.elem.classList, t = this.classes;
            e.contains(t.top) || (e.add(t.top), e.remove(t.notTop), this.onTop && this.onTop.call(this));
        },
        notTop: function() {
            var e = this.elem.classList, t = this.classes;
            e.contains(t.notTop) || (e.add(t.notTop), e.remove(t.top), this.onNotTop && this.onNotTop.call(this));
        },
        bottom: function() {
            var e = this.elem.classList, t = this.classes;
            e.contains(t.bottom) || (e.add(t.bottom), e.remove(t.notBottom), this.onBottom && this.onBottom.call(this));
        },
        notBottom: function() {
            var e = this.elem.classList, t = this.classes;
            e.contains(t.notBottom) || (e.add(t.notBottom), e.remove(t.bottom), this.onNotBottom && this.onNotBottom.call(this));
        },
        getScrollY: function() {
            return void 0 !== this.scroller.pageYOffset ? this.scroller.pageYOffset : void 0 !== this.scroller.scrollTop ? this.scroller.scrollTop : (document.documentElement || document.body.parentNode || document.body).scrollTop;
        },
        getViewportHeight: function() {
            return window.innerHeight || document.documentElement.clientHeight || document.body.clientHeight;
        },
        getElementPhysicalHeight: function(e) {
            return Math.max(e.offsetHeight, e.clientHeight);
        },
        getScrollerPhysicalHeight: function() {
            return this.scroller === window || this.scroller === document.body ? this.getViewportHeight() : this.getElementPhysicalHeight(this.scroller);
        },
        getDocumentHeight: function() {
            var e = document.body, t = document.documentElement;
            return Math.max(e.scrollHeight, t.scrollHeight, e.offsetHeight, t.offsetHeight, e.clientHeight, t.clientHeight);
        },
        getElementHeight: function(e) {
            return Math.max(e.scrollHeight, e.offsetHeight, e.clientHeight);
        },
        getScrollerHeight: function() {
            return this.scroller === window || this.scroller === document.body ? this.getDocumentHeight() : this.getElementHeight(this.scroller);
        },
        isOutOfBounds: function(e) {
            var t = e < 0, n = e + this.getScrollerPhysicalHeight() > this.getScrollerHeight();
            return t || n;
        },
        toleranceExceeded: function(e, t) {
            return Math.abs(e - this.lastKnownScrollY) >= this.tolerance[t];
        },
        shouldUnpin: function(e, t) {
            var n = e > this.lastKnownScrollY, r = e >= this.offset;
            return n && r && t;
        },
        shouldPin: function(e, t) {
            var n = e < this.lastKnownScrollY, r = e <= this.offset;
            return n && t || r;
        },
        update: function() {
            var e = this.getScrollY(), t = e > this.lastKnownScrollY ? "down" : "up", n = this.toleranceExceeded(e, t);
            this.isOutOfBounds(e) || (e <= this.offset ? this.top() : this.notTop(), e + this.getViewportHeight() >= this.getScrollerHeight() ? this.bottom() : this.notBottom(), 
            this.shouldUnpin(e, n) ? this.unpin() : this.shouldPin(e, n) && this.pin(), this.lastKnownScrollY = e);
        }
    }, o.options = {
        tolerance: {
            up: 0,
            down: 0
        },
        offset: 0,
        scroller: window,
        classes: {
            pinned: "headroom--pinned",
            unpinned: "headroom--unpinned",
            top: "headroom--top",
            notTop: "headroom--not-top",
            bottom: "headroom--bottom",
            notBottom: "headroom--not-bottom",
            initial: "headroom"
        }
    }, o.cutsTheMustard = "undefined" != typeof i && i.rAF && i.bind && i.classList, 
    o;
}), function(e) {
    e && (e.fn.headroom = function(t) {
        return this.each(function() {
            var n = e(this), r = n.data("headroom"), o = "object" == typeof t && t;
            o = e.extend(!0, {}, Headroom.options, o), r || (r = new Headroom(this, o), r.init(), 
            n.data("headroom", r)), "string" == typeof t && (r[t](), "destroy" === t && n.removeData("headroom"));
        });
    }, e("[data-headroom]").each(function() {
        var t = e(this);
        t.headroom(t.data());
    }));
}(window.Zepto || window.jQuery), function(e) {
    function t() {
        var t = e(window).height(), o = e(document.body).height() - r.height(), i = t - o;
        n && (i -= 32), i <= 0 && (i = 1), r.height(i);
    }
    var n = !1, r = e("#footerMargin");
    e(window).on("sticky", t).scroll(t).resize(t), e("#siteLogo").each(function() {
        var t = e(this);
        if (Modernizr.svg) {
            var n = t.attr("id"), r = t.attr("class");
            e.get(t.attr("src"), function(o) {
                var i = e(o).find("svg");
                "undefined" != typeof n && i.attr("id", n), "undefined" != typeof r && i.attr("class", r + " replaced-svg"), 
                i = i.removeAttr("xmlns:a"), t.replaceWith(i);
            }, "xml");
        } else t.attr("src", t.attr("src").replace(/\.svg/gi, ".png"));
    }), e(document).ready(function() {
        e.isFunction(prettyPrint) && prettyPrint(), n = e("#wpadminbar").length > 0, e("#siteHeader").headroom(), 
        t();
    });
}(jQuery);