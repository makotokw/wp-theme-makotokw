window.Modernizr = function(e, t, n) {
    function r(e) {
        b.cssText = e;
    }
    function a(e, t) {
        return r(C.join(e + ";") + (t || ""));
    }
    function o(e, t) {
        return typeof e === t;
    }
    function i(e, t) {
        return !!~("" + e).indexOf(t);
    }
    function s(e, t) {
        for (var r in e) {
            var a = e[r];
            if (!i(a, "-") && b[a] !== n) return "pfx" != t || a;
        }
        return !1;
    }
    function l(e, t, r) {
        for (var a in e) {
            var i = t[e[a]];
            if (i !== n) return r === !1 ? e[a] : o(i, "function") ? i.bind(r || t) : i;
        }
        return !1;
    }
    function c(e, t, n) {
        var r = e.charAt(0).toUpperCase() + e.slice(1), a = (e + " " + N.join(r + " ") + r).split(" ");
        return o(t, "string") || o(t, "undefined") ? s(a, t) : (a = (e + " " + k.join(r + " ") + r).split(" "), 
        l(a, t, n));
    }
    function u() {
        m.input = function(n) {
            for (var r = 0, a = n.length; r < a; r++) L[n[r]] = !!(n[r] in x);
            return L.list && (L.list = !(!t.createElement("datalist") || !e.HTMLDataListElement)), 
            L;
        }("autocomplete autofocus list placeholder max min multiple pattern required step".split(" ")), 
        m.inputtypes = function(e) {
            for (var r, a, o, i = 0, s = e.length; i < s; i++) x.setAttribute("type", a = e[i]), 
            r = "text" !== x.type, r && (x.value = w, x.style.cssText = "position:absolute;visibility:hidden;", 
            /^range$/.test(a) && x.style.WebkitAppearance !== n ? (g.appendChild(x), o = t.defaultView, 
            r = o.getComputedStyle && "textfield" !== o.getComputedStyle(x, null).WebkitAppearance && 0 !== x.offsetHeight, 
            g.removeChild(x)) : /^(search|tel)$/.test(a) || (r = /^(url|email)$/.test(a) ? x.checkValidity && x.checkValidity() === !1 : x.value != w)), 
            _[e[i]] = !!r;
            return _;
        }("search tel url email datetime date month week time datetime-local number range color".split(" "));
    }
    var d, f, p = "2.8.3", m = {}, h = !0, g = t.documentElement, v = "modernizr", y = t.createElement(v), b = y.style, x = t.createElement("input"), w = ":)", S = {}.toString, C = " -webkit- -moz- -o- -ms- ".split(" "), E = "Webkit Moz O ms", N = E.split(" "), k = E.toLowerCase().split(" "), P = {
        svg: "http://www.w3.org/2000/svg"
    }, T = {}, _ = {}, L = {}, $ = [], A = $.slice, R = function(e, n, r, a) {
        var o, i, s, l, c = t.createElement("div"), u = t.body, d = u || t.createElement("body");
        if (parseInt(r, 10)) for (;r--; ) s = t.createElement("div"), s.id = a ? a[r] : v + (r + 1), 
        c.appendChild(s);
        return o = [ "&#173;", '<style id="s', v, '">', e, "</style>" ].join(""), c.id = v, 
        (u ? c : d).innerHTML += o, d.appendChild(c), u || (d.style.background = "", d.style.overflow = "hidden", 
        l = g.style.overflow, g.style.overflow = "hidden", g.appendChild(d)), i = n(c, e), 
        u ? c.parentNode.removeChild(c) : (d.parentNode.removeChild(d), g.style.overflow = l), 
        !!i;
    }, M = function(t) {
        var n = e.matchMedia || e.msMatchMedia;
        if (n) return n(t) && n(t).matches || !1;
        var r;
        return R("@media " + t + " { #" + v + " { position: absolute; } }", function(t) {
            r = "absolute" == (e.getComputedStyle ? getComputedStyle(t, null) : t.currentStyle).position;
        }), r;
    }, O = function() {
        function e(e, a) {
            a = a || t.createElement(r[e] || "div"), e = "on" + e;
            var i = e in a;
            return i || (a.setAttribute || (a = t.createElement("div")), a.setAttribute && a.removeAttribute && (a.setAttribute(e, ""), 
            i = o(a[e], "function"), o(a[e], "undefined") || (a[e] = n), a.removeAttribute(e))), 
            a = null, i;
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
    }(), D = {}.hasOwnProperty;
    f = o(D, "undefined") || o(D.call, "undefined") ? function(e, t) {
        return t in e && o(e.constructor.prototype[t], "undefined");
    } : function(e, t) {
        return D.call(e, t);
    }, Function.prototype.bind || (Function.prototype.bind = function(e) {
        var t = this;
        if ("function" != typeof t) throw new TypeError();
        var n = A.call(arguments, 1), r = function() {
            if (this instanceof r) {
                var a = function() {};
                a.prototype = t.prototype;
                var o = new a(), i = t.apply(o, n.concat(A.call(arguments)));
                return Object(i) === i ? i : o;
            }
            return t.apply(e, n.concat(A.call(arguments)));
        };
        return r;
    }), T.flexbox = function() {
        return c("flexWrap");
    }, T.flexboxlegacy = function() {
        return c("boxDirection");
    }, T.canvas = function() {
        var e = t.createElement("canvas");
        return !(!e.getContext || !e.getContext("2d"));
    }, T.canvastext = function() {
        return !(!m.canvas || !o(t.createElement("canvas").getContext("2d").fillText, "function"));
    }, T.webgl = function() {
        return !!e.WebGLRenderingContext;
    }, T.touch = function() {
        var n;
        return "ontouchstart" in e || e.DocumentTouch && t instanceof DocumentTouch ? n = !0 : R([ "@media (", C.join("touch-enabled),("), v, ")", "{#modernizr{top:9px;position:absolute}}" ].join(""), function(e) {
            n = 9 === e.offsetTop;
        }), n;
    }, T.geolocation = function() {
        return "geolocation" in navigator;
    }, T.postmessage = function() {
        return !!e.postMessage;
    }, T.websqldatabase = function() {
        return !!e.openDatabase;
    }, T.indexedDB = function() {
        return !!c("indexedDB", e);
    }, T.hashchange = function() {
        return O("hashchange", e) && (t.documentMode === n || t.documentMode > 7);
    }, T.history = function() {
        return !(!e.history || !history.pushState);
    }, T.draganddrop = function() {
        var e = t.createElement("div");
        return "draggable" in e || "ondragstart" in e && "ondrop" in e;
    }, T.websockets = function() {
        return "WebSocket" in e || "MozWebSocket" in e;
    }, T.rgba = function() {
        return r("background-color:rgba(150,255,150,.5)"), i(b.backgroundColor, "rgba");
    }, T.hsla = function() {
        return r("background-color:hsla(120,40%,100%,.5)"), i(b.backgroundColor, "rgba") || i(b.backgroundColor, "hsla");
    }, T.multiplebgs = function() {
        return r("background:url(https://),url(https://),red url(https://)"), /(url\s*\(.*?){3}/.test(b.background);
    }, T.backgroundsize = function() {
        return c("backgroundSize");
    }, T.borderimage = function() {
        return c("borderImage");
    }, T.borderradius = function() {
        return c("borderRadius");
    }, T.boxshadow = function() {
        return c("boxShadow");
    }, T.textshadow = function() {
        return "" === t.createElement("div").style.textShadow;
    }, T.opacity = function() {
        return a("opacity:.55"), /^0.55$/.test(b.opacity);
    }, T.cssanimations = function() {
        return c("animationName");
    }, T.csscolumns = function() {
        return c("columnCount");
    }, T.cssgradients = function() {
        var e = "background-image:", t = "gradient(linear,left top,right bottom,from(#9f9),to(white));", n = "linear-gradient(left top,#9f9, white);";
        return r((e + "-webkit- ".split(" ").join(t + e) + C.join(n + e)).slice(0, -e.length)), 
        i(b.backgroundImage, "gradient");
    }, T.cssreflections = function() {
        return c("boxReflect");
    }, T.csstransforms = function() {
        return !!c("transform");
    }, T.csstransforms3d = function() {
        var e = !!c("perspective");
        return e && "webkitPerspective" in g.style && R("@media (transform-3d),(-webkit-transform-3d){#modernizr{left:9px;position:absolute;height:3px;}}", function(t, n) {
            e = 9 === t.offsetLeft && 3 === t.offsetHeight;
        }), e;
    }, T.csstransitions = function() {
        return c("transition");
    }, T.fontface = function() {
        var e;
        return R('@font-face {font-family:"font";src:url("https://")}', function(n, r) {
            var a = t.getElementById("smodernizr"), o = a.sheet || a.styleSheet, i = o ? o.cssRules && o.cssRules[0] ? o.cssRules[0].cssText : o.cssText || "" : "";
            e = /src/i.test(i) && 0 === i.indexOf(r.split(" ")[0]);
        }), e;
    }, T.generatedcontent = function() {
        var e;
        return R([ "#", v, "{font:0/0 a}#", v, ':after{content:"', w, '";visibility:hidden;font:3px/1 a}' ].join(""), function(t) {
            e = t.offsetHeight >= 3;
        }), e;
    }, T.video = function() {
        var e = t.createElement("video"), n = !1;
        try {
            (n = !!e.canPlayType) && (n = new Boolean(n), n.ogg = e.canPlayType('video/ogg; codecs="theora"').replace(/^no$/, ""), 
            n.h264 = e.canPlayType('video/mp4; codecs="avc1.42E01E"').replace(/^no$/, ""), n.webm = e.canPlayType('video/webm; codecs="vp8, vorbis"').replace(/^no$/, ""));
        } catch (r) {}
        return n;
    }, T.audio = function() {
        var e = t.createElement("audio"), n = !1;
        try {
            (n = !!e.canPlayType) && (n = new Boolean(n), n.ogg = e.canPlayType('audio/ogg; codecs="vorbis"').replace(/^no$/, ""), 
            n.mp3 = e.canPlayType("audio/mpeg;").replace(/^no$/, ""), n.wav = e.canPlayType('audio/wav; codecs="1"').replace(/^no$/, ""), 
            n.m4a = (e.canPlayType("audio/x-m4a;") || e.canPlayType("audio/aac;")).replace(/^no$/, ""));
        } catch (r) {}
        return n;
    }, T.localstorage = function() {
        try {
            return localStorage.setItem(v, v), localStorage.removeItem(v), !0;
        } catch (e) {
            return !1;
        }
    }, T.sessionstorage = function() {
        try {
            return sessionStorage.setItem(v, v), sessionStorage.removeItem(v), !0;
        } catch (e) {
            return !1;
        }
    }, T.webworkers = function() {
        return !!e.Worker;
    }, T.applicationcache = function() {
        return !!e.applicationCache;
    }, T.svg = function() {
        return !!t.createElementNS && !!t.createElementNS(P.svg, "svg").createSVGRect;
    }, T.inlinesvg = function() {
        var e = t.createElement("div");
        return e.innerHTML = "<svg/>", (e.firstChild && e.firstChild.namespaceURI) == P.svg;
    }, T.smil = function() {
        return !!t.createElementNS && /SVGAnimate/.test(S.call(t.createElementNS(P.svg, "animate")));
    }, T.svgclippaths = function() {
        return !!t.createElementNS && /SVGClipPath/.test(S.call(t.createElementNS(P.svg, "clipPath")));
    };
    for (var I in T) f(T, I) && (d = I.toLowerCase(), m[d] = T[I](), $.push((m[d] ? "" : "no-") + d));
    return m.input || u(), m.addTest = function(e, t) {
        if ("object" == typeof e) for (var r in e) f(e, r) && m.addTest(r, e[r]); else {
            if (e = e.toLowerCase(), m[e] !== n) return m;
            t = "function" == typeof t ? t() : t, "undefined" != typeof h && h && (g.className += " " + (t ? "" : "no-") + e), 
            m[e] = t;
        }
        return m;
    }, r(""), y = x = null, function(e, t) {
        function n(e, t) {
            var n = e.createElement("p"), r = e.getElementsByTagName("head")[0] || e.documentElement;
            return n.innerHTML = "x<style>" + t + "</style>", r.insertBefore(n.lastChild, r.firstChild);
        }
        function r() {
            var e = y.elements;
            return "string" == typeof e ? e.split(" ") : e;
        }
        function a(e) {
            var t = v[e[h]];
            return t || (t = {}, g++, e[h] = g, v[g] = t), t;
        }
        function o(e, n, r) {
            if (n || (n = t), u) return n.createElement(e);
            r || (r = a(n));
            var o;
            return o = r.cache[e] ? r.cache[e].cloneNode() : m.test(e) ? (r.cache[e] = r.createElem(e)).cloneNode() : r.createElem(e), 
            !o.canHaveChildren || p.test(e) || o.tagUrn ? o : r.frag.appendChild(o);
        }
        function i(e, n) {
            if (e || (e = t), u) return e.createDocumentFragment();
            n = n || a(e);
            for (var o = n.frag.cloneNode(), i = 0, s = r(), l = s.length; i < l; i++) o.createElement(s[i]);
            return o;
        }
        function s(e, t) {
            t.cache || (t.cache = {}, t.createElem = e.createElement, t.createFrag = e.createDocumentFragment, 
            t.frag = t.createFrag()), e.createElement = function(n) {
                return y.shivMethods ? o(n, e, t) : t.createElem(n);
            }, e.createDocumentFragment = Function("h,f", "return function(){var n=f.cloneNode(),c=n.createElement;h.shivMethods&&(" + r().join().replace(/[\w\-]+/g, function(e) {
                return t.createElem(e), t.frag.createElement(e), 'c("' + e + '")';
            }) + ");return n}")(y, t.frag);
        }
        function l(e) {
            e || (e = t);
            var r = a(e);
            return !y.shivCSS || c || r.hasCSS || (r.hasCSS = !!n(e, "article,aside,dialog,figcaption,figure,footer,header,hgroup,main,nav,section{display:block}mark{background:#FF0;color:#000}template{display:none}")), 
            u || s(e, r), e;
        }
        var c, u, d = "3.7.0", f = e.html5 || {}, p = /^<|^(?:button|map|select|textarea|object|iframe|option|optgroup)$/i, m = /^(?:a|b|code|div|fieldset|h1|h2|h3|h4|h5|h6|i|label|li|ol|p|q|span|strong|style|table|tbody|td|th|tr|ul)$/i, h = "_html5shiv", g = 0, v = {};
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
            createElement: o,
            createDocumentFragment: i
        };
        e.html5 = y, l(t);
    }(this, t), m._version = p, m._prefixes = C, m._domPrefixes = k, m._cssomPrefixes = N, 
    m.mq = M, m.hasEvent = O, m.testProp = function(e) {
        return s([ e ]);
    }, m.testAllProps = c, m.testStyles = R, m.prefixed = function(e, t, n) {
        return t ? c(e, t, n) : c(e, "pfx");
    }, g.className = g.className.replace(/(^|\s)no-js(\s|$)/, "$1$2") + (h ? " js " + $.join(" ") : ""), 
    m;
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
            var r = e.substring(1, e.length - 1).match(new RegExp("\\\\u[0-9A-Fa-f]{4}|\\\\x[0-9A-Fa-f]{2}|\\\\[0-3][0-7]{0,2}|\\\\[0-7]{1,2}|\\\\[\\s\\S]|-|[^-\\\\]", "g")), a = [], o = "^" === r[0], i = [ "[" ];
            o && i.push("^");
            for (var s = o ? 1 : 0, l = r.length; s < l; ++s) {
                var c = r[s];
                if (/\\[bdsw]/i.test(c)) i.push(c); else {
                    var u, d = t(c);
                    s + 2 < l && "-" === r[s + 1] ? (u = t(r[s + 2]), s += 2) : u = d, a.push([ d, u ]), 
                    u < 65 || d > 122 || (u < 65 || d > 90 || a.push([ 32 | Math.max(65, d), 32 | Math.min(u, 90) ]), 
                    u < 97 || d > 122 || a.push([ Math.max(97, d) & -33, Math.min(u, 122) & -33 ]));
                }
            }
            a.sort(function(e, t) {
                return e[0] - t[0] || t[1] - e[1];
            });
            for (var f = [], p = [], s = 0; s < a.length; ++s) {
                var m = a[s];
                m[0] <= p[1] + 1 ? p[1] = Math.max(p[1], m[1]) : f.push(p = m);
            }
            for (var s = 0; s < f.length; ++s) {
                var m = f[s];
                i.push(n(m[0])), m[1] > m[0] && (m[1] + 1 > m[0] && i.push("-"), i.push(n(m[1])));
            }
            return i.push("]"), i.join("");
        }
        function a(e) {
            for (var t = e.source.match(new RegExp("(?:\\[(?:[^\\x5C\\x5D]|\\\\[\\s\\S])*\\]|\\\\u[A-Fa-f0-9]{4}|\\\\x[A-Fa-f0-9]{2}|\\\\[0-9]+|\\\\[^ux0-9]|\\(\\?[:!=]|[\\(\\)\\^]|[^\\x5B\\x5C\\(\\)\\^]+)", "g")), a = t.length, s = [], l = 0, c = 0; l < a; ++l) {
                var u = t[l];
                if ("(" === u) ++c; else if ("\\" === u.charAt(0)) {
                    var d = +u.substring(1);
                    d && (d <= c ? s[d] = -1 : t[l] = n(d));
                }
            }
            for (var l = 1; l < s.length; ++l) -1 === s[l] && (s[l] = ++o);
            for (var l = 0, c = 0; l < a; ++l) {
                var u = t[l];
                if ("(" === u) ++c, s[c] || (t[l] = "(?:"); else if ("\\" === u.charAt(0)) {
                    var d = +u.substring(1);
                    d && d <= c && (t[l] = "\\" + s[d]);
                }
            }
            for (var l = 0; l < a; ++l) "^" === t[l] && "^" !== t[l + 1] && (t[l] = "");
            if (e.ignoreCase && i) for (var l = 0; l < a; ++l) {
                var u = t[l], f = u.charAt(0);
                u.length >= 2 && "[" === f ? t[l] = r(u) : "\\" !== f && (t[l] = u.replace(/[a-zA-Z]/g, function(e) {
                    var t = e.charCodeAt(0);
                    return "[" + String.fromCharCode(t & -33, 32 | t) + "]";
                }));
            }
            return t.join("");
        }
        for (var o = 0, i = !1, s = !1, l = 0, c = e.length; l < c; ++l) {
            var u = e[l];
            if (u.ignoreCase) s = !0; else if (/[a-z]/i.test(u.source.replace(/\\u[0-9a-f]{4}|\\x[0-9a-f]{2}|\\[^ux]/gi, ""))) {
                i = !0, s = !1;
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
            f.push("(?:" + a(u) + ")");
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
                "br" !== u && "li" !== u || (a[s] = "\n", i[s << 1] = o++, i[s++ << 1 | 1] = e);
            } else if (3 == l || 4 == l) {
                var d = e.nodeValue;
                d.length && (d = t ? d.replace(/\r\n?/g, "\n") : d.replace(/[ \t\r\n]+/g, " "), 
                a[s] = d, i[s << 1] = o, o += d.length, i[s++ << 1 | 1] = e);
            }
        }
        var r = /(?:^|\s)nocode(?:\s|$)/, a = [], o = 0, i = [], s = 0;
        return n(e), {
            sourceCode: a.join("").replace(/\n$/, ""),
            spans: i
        };
    }
    function n(e, t, n, r) {
        if (t) {
            var a = {
                sourceCode: t,
                basePos: e
            };
            n(a), r.push.apply(r, a.decorations);
        }
    }
    function r(e) {
        for (var t = void 0, n = e.firstChild; n; n = n.nextSibling) {
            var r = n.nodeType;
            t = 1 === r ? t ? e : n : 3 === r && H.test(n.nodeValue) ? e : t;
        }
        return t === e ? void 0 : t;
    }
    function a(t, r) {
        var a, o = {};
        !function() {
            for (var n = t.concat(r), i = [], s = {}, l = 0, c = n.length; l < c; ++l) {
                var u = n[l], d = u[3];
                if (d) for (var f = d.length; --f >= 0; ) o[d.charAt(f)] = u;
                var p = u[1], m = "" + p;
                s.hasOwnProperty(m) || (i.push(p), s[m] = null);
            }
            i.push(/[\0-\uffff]/), a = e(i);
        }();
        var i = r.length, s = function(e) {
            for (var t = e.sourceCode, l = e.basePos, u = [ l, O ], d = 0, f = t.match(a) || [], p = {}, m = 0, h = f.length; m < h; ++m) {
                var g, v = f[m], y = p[v], b = void 0;
                if ("string" == typeof y) g = !1; else {
                    var x = o[v.charAt(0)];
                    if (x) b = v.match(x[1]), y = x[0]; else {
                        for (var w = 0; w < i; ++w) if (x = r[w], b = v.match(x[1])) {
                            y = x[0];
                            break;
                        }
                        b || (y = O);
                    }
                    g = y.length >= 5 && "lang-" === y.substring(0, 5), !g || b && "string" == typeof b[1] || (g = !1, 
                    y = j), g || (p[v] = y);
                }
                var S = d;
                if (d += v.length, g) {
                    var C = b[1], E = v.indexOf(C), N = E + C.length;
                    b[2] && (N = v.length - b[2].length, E = N - C.length);
                    var k = y.substring(5);
                    n(l + S, v.substring(0, E), s, u), n(l + S + E, C, c(k, C), u), n(l + S + N, v.substring(N), s, u);
                } else u.push(l + S, y);
            }
            e.decorations = u;
        };
        return s;
    }
    function o(e) {
        var t = [], n = [];
        e.tripleQuotedStrings ? t.push([ _, /^(?:\'\'\'(?:[^\'\\]|\\[\s\S]|\'{1,2}(?=[^\']))*(?:\'\'\'|$)|\"\"\"(?:[^\"\\]|\\[\s\S]|\"{1,2}(?=[^\"]))*(?:\"\"\"|$)|\'(?:[^\\\']|\\[\s\S])*(?:\'|$)|\"(?:[^\\\"]|\\[\s\S])*(?:\"|$))/, null, "'\"" ]) : e.multiLineStrings ? t.push([ _, /^(?:\'(?:[^\\\']|\\[\s\S])*(?:\'|$)|\"(?:[^\\\"]|\\[\s\S])*(?:\"|$)|\`(?:[^\\\`]|\\[\s\S])*(?:\`|$))/, null, "'\"`" ]) : t.push([ _, /^(?:\'(?:[^\\\'\r\n]|\\.)*(?:\'|$)|\"(?:[^\\\"\r\n]|\\.)*(?:\"|$))/, null, "\"'" ]), 
        e.verbatimStrings && n.push([ _, /^@\"(?:[^\"]|\"\")*(?:\"|$)/, null ]);
        var r = e.hashComments;
        r && (e.cStyleComments ? (r > 1 ? t.push([ $, /^#(?:##(?:[^#]|#(?!##))*(?:###|$)|.*)/, null, "#" ]) : t.push([ $, /^#(?:(?:define|e(?:l|nd)if|else|error|ifn?def|include|line|pragma|undef|warning)\b|[^\r\n]*)/, null, "#" ]), 
        n.push([ _, /^<(?:(?:(?:\.\.\/)*|\/?)(?:[\w-]+(?:\/[\w-]+)+)?[\w-]+\.h(?:h|pp|\+\+)?|[a-z]\w*)>/, null ])) : t.push([ $, /^#[^\r\n]*/, null, "#" ])), 
        e.cStyleComments && (n.push([ $, /^\/\/[^\r\n]*/, null ]), n.push([ $, /^\/\*[\s\S]*?(?:\*\/|$)/, null ]));
        var o = e.regexLiterals;
        if (o) {
            var i = o > 1 ? "" : "\n\r", s = i ? "." : "[\\S\\s]", l = "/(?=[^/*" + i + "])(?:[^/\\x5B\\x5C" + i + "]|\\x5C" + s + "|\\x5B(?:[^\\x5C\\x5D" + i + "]|\\x5C" + s + ")*(?:\\x5D|$))+/";
            n.push([ "lang-regex", RegExp("^" + V + "(" + l + ")") ]);
        }
        var c = e.types;
        c && n.push([ A, c ]);
        var u = ("" + e.keywords).replace(/^ | $/g, "");
        u.length && n.push([ L, new RegExp("^(?:" + u.replace(/[\s,]+/g, "|") + ")\\b"), null ]), 
        t.push([ O, /^\s+/, null, " \r\n\t " ]);
        var d = "^.[^\\s\\w.$@'\"`/\\\\]*";
        return e.regexLiterals && (d += "(?!s*/)"), n.push([ R, /^@[a-z_$][a-z_$@0-9]*/i, null ], [ A, /^(?:[@_]?[A-Z]+[a-z][A-Za-z_$@0-9]*|\w+_t\b)/, null ], [ O, /^[a-z_$][a-z_$@0-9]*/i, null ], [ R, new RegExp("^(?:0x[a-f0-9]+|(?:\\d(?:_\\d+)*\\d*(?:\\.\\d*)?|\\.\\d\\+)(?:e[+\\-]?\\d+)?)[a-z]*", "i"), null, "0123456789" ], [ O, /^\\[\s\S]?/, null ], [ M, new RegExp(d), null ]), 
        a(t, n);
    }
    function i(e, t, n) {
        function r(e) {
            var t = e.nodeType;
            if (1 != t || o.test(e.className)) {
                if ((3 == t || 4 == t) && n) {
                    var l = e.nodeValue, c = l.match(i);
                    if (c) {
                        var u = l.substring(0, c.index);
                        e.nodeValue = u;
                        var d = l.substring(c.index + c[0].length);
                        if (d) {
                            var f = e.parentNode;
                            f.insertBefore(s.createTextNode(d), e.nextSibling);
                        }
                        a(e), u || e.parentNode.removeChild(e);
                    }
                }
            } else if ("br" === e.nodeName) a(e), e.parentNode && e.parentNode.removeChild(e); else for (var p = e.firstChild; p; p = p.nextSibling) r(p);
        }
        function a(e) {
            function t(e, n) {
                var r = n ? e.cloneNode(!1) : e, a = e.parentNode;
                if (a) {
                    var o = t(a, 1), i = e.nextSibling;
                    o.appendChild(r);
                    for (var s = i; s; s = i) i = s.nextSibling, o.appendChild(s);
                }
                return r;
            }
            for (;!e.nextSibling; ) if (e = e.parentNode, !e) return;
            for (var n, r = t(e.nextSibling, 0); (n = r.parentNode) && 1 === n.nodeType; ) r = n;
            c.push(r);
        }
        for (var o = /(?:^|\s)nocode(?:\s|$)/, i = /\r\n?|\n/, s = e.ownerDocument, l = s.createElement("li"); e.firstChild; ) l.appendChild(e.firstChild);
        for (var c = [ l ], u = 0; u < c.length; ++u) r(c[u]);
        t === (0 | t) && c[0].setAttribute("value", t);
        var d = s.createElement("ol");
        d.className = "linenums";
        for (var f = Math.max(0, t - 1 | 0) || 0, u = 0, p = c.length; u < p; ++u) l = c[u], 
        l.className = "L" + (u + f) % 10, l.firstChild || l.appendChild(s.createTextNode(" ")), 
        d.appendChild(l);
        e.appendChild(d);
    }
    function s(e) {
        var t = /\bMSIE\s(\d+)/.exec(navigator.userAgent);
        t = t && +t[1] <= 8;
        var n = /\n/g, r = e.sourceCode, a = r.length, o = 0, i = e.spans, s = i.length, l = 0, c = e.decorations, u = c.length, d = 0;
        c[u] = a;
        var f, p;
        for (p = f = 0; p < u; ) c[p] !== c[p + 2] ? (c[f++] = c[p++], c[f++] = c[p++]) : p += 2;
        for (u = f, p = f = 0; p < u; ) {
            for (var m = c[p], h = c[p + 1], g = p + 2; g + 2 <= u && c[g + 1] === h; ) g += 2;
            c[f++] = m, c[f++] = h, p = g;
        }
        u = c.length = f;
        var v, y = e.sourceNode;
        y && (v = y.style.display, y.style.display = "none");
        try {
            for (;l < s; ) {
                var b, x = (i[l], i[l + 2] || a), w = c[d + 2] || a, g = Math.min(x, w), S = i[l + 1];
                if (1 !== S.nodeType && (b = r.substring(o, g))) {
                    t && (b = b.replace(n, "\r")), S.nodeValue = b;
                    var C = S.ownerDocument, E = C.createElement("span");
                    E.className = c[d + 1];
                    var N = S.parentNode;
                    N.replaceChild(E, S), E.appendChild(S), o < x && (i[l + 1] = S = C.createTextNode(r.substring(g, x)), 
                    N.insertBefore(S, E.nextSibling));
                }
                o = g, o >= x && (l += 2), o >= w && (d += 2);
            }
        } finally {
            y && (y.style.display = v);
        }
    }
    function l(e, t) {
        for (var n = t.length; --n >= 0; ) {
            var r = t[n];
            G.hasOwnProperty(r) ? p.console && console.warn("cannot override language handler %s", r) : G[r] = e;
        }
    }
    function c(e, t) {
        return e && G.hasOwnProperty(e) || (e = /^\s*</.test(t) ? "default-markup" : "default-code"), 
        G[e];
    }
    function u(e) {
        var n = e.langExtension;
        try {
            var r = t(e.sourceNode, e.pre), a = r.sourceCode;
            e.sourceCode = a, e.spans = r.spans, e.basePos = 0, c(n, a)(e), s(e);
        } catch (o) {
            p.console && console.log(o && o.stack || o);
        }
    }
    function d(e, t, n) {
        var r = document.createElement("div");
        r.innerHTML = "<pre>" + e + "</pre>", r = r.firstChild, n && i(r, n, !0);
        var a = {
            langExtension: t,
            numberLines: n,
            sourceNode: r,
            pre: 1
        };
        return u(a), r.innerHTML;
    }
    function f(e, t) {
        function n(e) {
            return o.getElementsByTagName(e);
        }
        function a() {
            for (var t = p.PR_SHOULD_USE_CONTINUATION ? h.now() + 250 : 1 / 0; v < c.length && h.now() < t; v++) {
                for (var n = c[v], o = E, l = n; l = l.previousSibling; ) {
                    var d = l.nodeType, f = (7 === d || 8 === d) && l.nodeValue;
                    if (f ? !/^\??prettify\b/.test(f) : 3 !== d || /\S/.test(l.nodeValue)) break;
                    if (f) {
                        o = {}, f.replace(/\b(\w+)=([\w:.%+-]+)/g, function(e, t, n) {
                            o[t] = n;
                        });
                        break;
                    }
                }
                var m = n.className;
                if ((o !== E || b.test(m)) && !x.test(m)) {
                    for (var N = !1, k = n.parentNode; k; k = k.parentNode) {
                        var P = k.tagName;
                        if (C.test(P) && k.className && b.test(k.className)) {
                            N = !0;
                            break;
                        }
                    }
                    if (!N) {
                        n.className += " prettyprinted";
                        var T = o.lang;
                        if (!T) {
                            T = m.match(y);
                            var _;
                            !T && (_ = r(n)) && S.test(_.tagName) && (T = _.className.match(y)), T && (T = T[1]);
                        }
                        var L;
                        if (w.test(n.tagName)) L = 1; else {
                            var $ = n.currentStyle, A = s.defaultView, R = $ ? $.whiteSpace : A && A.getComputedStyle ? A.getComputedStyle(n, null).getPropertyValue("white-space") : 0;
                            L = R && "pre" === R.substring(0, 3);
                        }
                        var M = o.linenums;
                        (M = "true" === M || +M) || (M = m.match(/\blinenums\b(?::(\d+))?/), M = !!M && (!M[1] || !M[1].length || +M[1])), 
                        M && i(n, M, L), g = {
                            langExtension: T,
                            sourceNode: n,
                            numberLines: M,
                            pre: L
                        }, u(g);
                    }
                }
            }
            v < c.length ? setTimeout(a, 250) : "function" == typeof e && e();
        }
        for (var o = t || document.body, s = o.ownerDocument || document, l = [ n("pre"), n("code"), n("xmp") ], c = [], d = 0; d < l.length; ++d) for (var f = 0, m = l[d].length; f < m; ++f) c.push(l[d][f]);
        l = null;
        var h = Date;
        h.now || (h = {
            now: function() {
                return +new Date();
            }
        });
        var g, v = 0, y = /\blang(?:uage)?-([\w.]+)(?!\S)/, b = /\bprettyprint\b/, x = /\bprettyprinted\b/, w = /pre|xmp/i, S = /^code$/i, C = /^(?:pre|code|xmp)$/i, E = {};
        a();
    }
    var p = window, m = [ "break,continue,do,else,for,if,return,while" ], h = [ m, "auto,case,char,const,default,double,enum,extern,float,goto,inline,int,long,register,short,signed,sizeof,static,struct,switch,typedef,union,unsigned,void,volatile" ], g = [ h, "catch,class,delete,false,import,new,operator,private,protected,public,this,throw,true,try,typeof" ], v = [ g, "alignof,align_union,asm,axiom,bool,concept,concept_map,const_cast,constexpr,decltype,delegate,dynamic_cast,explicit,export,friend,generic,late_check,mutable,namespace,nullptr,property,reinterpret_cast,static_assert,static_cast,template,typeid,typename,using,virtual,where" ], y = [ g, "abstract,assert,boolean,byte,extends,final,finally,implements,import,instanceof,interface,null,native,package,strictfp,super,synchronized,throws,transient" ], b = [ y, "as,base,by,checked,decimal,delegate,descending,dynamic,event,fixed,foreach,from,group,implicit,in,internal,into,is,let,lock,object,out,override,orderby,params,partial,readonly,ref,sbyte,sealed,stackalloc,string,select,uint,ulong,unchecked,unsafe,ushort,var,virtual,where" ], x = "all,and,by,catch,class,else,extends,false,finally,for,if,in,is,isnt,loop,new,no,not,null,of,off,on,or,return,super,then,throw,true,try,unless,until,when,while,yes", w = [ g, "debugger,eval,export,function,get,null,set,undefined,var,with,Infinity,NaN" ], S = "caller,delete,die,do,dump,elsif,eval,exit,foreach,for,goto,if,import,last,local,my,next,no,our,print,package,redo,require,sub,undef,unless,until,use,wantarray,while,BEGIN,END", C = [ m, "and,as,assert,class,def,del,elif,except,exec,finally,from,global,import,in,is,lambda,nonlocal,not,or,pass,print,raise,try,with,yield,False,True,None" ], E = [ m, "alias,and,begin,case,class,def,defined,elsif,end,ensure,false,in,module,next,nil,not,or,redo,rescue,retry,self,super,then,true,undef,unless,until,when,yield,BEGIN,END" ], N = [ m, "as,assert,const,copy,drop,enum,extern,fail,false,fn,impl,let,log,loop,match,mod,move,mut,priv,pub,pure,ref,self,static,struct,true,trait,type,unsafe,use" ], k = [ m, "case,done,elif,esac,eval,fi,function,in,local,set,then,until" ], P = [ v, b, w, S, C, E, k ], T = /^(DIR|FILE|vector|(de|priority_)?queue|list|stack|(const_)?iterator|(multi)?(set|map)|bitset|u?(int|float)\d*)\b/, _ = "str", L = "kwd", $ = "com", A = "typ", R = "lit", M = "pun", O = "pln", D = "tag", I = "dec", j = "src", z = "atn", B = "atv", F = "nocode", V = "(?:^^\\.?|[+-]|[!=]=?=?|\\#|%=?|&&?=?|\\(|\\*=?|[+\\-]=|->|\\/=?|::?|<<?=?|>>?>?=?|,|;|\\?|@|\\[|~|{|\\^\\^?=?|\\|\\|?=?|break|case|continue|delete|do|else|finally|instanceof|return|throw|try|typeof)\\s*", H = /\S/, U = o({
        keywords: P,
        hashComments: !0,
        cStyleComments: !0,
        multiLineStrings: !0,
        regexLiterals: !0
    }), G = {};
    l(U, [ "default-code" ]), l(a([], [ [ O, /^[^<?]+/ ], [ I, /^<!\w[^>]*(?:>|$)/ ], [ $, /^<\!--[\s\S]*?(?:-\->|$)/ ], [ "lang-", /^<\?([\s\S]+?)(?:\?>|$)/ ], [ "lang-", /^<%([\s\S]+?)(?:%>|$)/ ], [ M, /^(?:<[%?]|[%?]>)/ ], [ "lang-", /^<xmp\b[^>]*>([\s\S]+?)<\/xmp\b[^>]*>/i ], [ "lang-js", /^<script\b[^>]*>([\s\S]*?)(<\/script\b[^>]*>)/i ], [ "lang-css", /^<style\b[^>]*>([\s\S]*?)(<\/style\b[^>]*>)/i ], [ "lang-in.tag", /^(<\/?[a-z][^<>]*>)/i ] ]), [ "default-markup", "htm", "html", "mxml", "xhtml", "xml", "xsl" ]), 
    l(a([ [ O, /^[\s]+/, null, " \t\r\n" ], [ B, /^(?:\"[^\"]*\"?|\'[^\']*\'?)/, null, "\"'" ] ], [ [ D, /^^<\/?[a-z](?:[\w.:-]*\w)?|\/?>$/i ], [ z, /^(?!style[\s=]|on)[a-z](?:[\w:-]*\w)?/i ], [ "lang-uq.val", /^=\s*([^>\'\"\s]*(?:[^>\'\"\s\/]|\/(?=\s)))/ ], [ M, /^[=<>\/]+/ ], [ "lang-js", /^on\w+\s*=\s*\"([^\"]+)\"/i ], [ "lang-js", /^on\w+\s*=\s*\'([^\']+)\'/i ], [ "lang-js", /^on\w+\s*=\s*([^\"\'>\s]+)/i ], [ "lang-css", /^style\s*=\s*\"([^\"]+)\"/i ], [ "lang-css", /^style\s*=\s*\'([^\']+)\'/i ], [ "lang-css", /^style\s*=\s*([^\"\'>\s]+)/i ] ]), [ "in.tag" ]), 
    l(a([], [ [ B, /^[\s\S]+/ ] ]), [ "uq.val" ]), l(o({
        keywords: v,
        hashComments: !0,
        cStyleComments: !0,
        types: T
    }), [ "c", "cc", "cpp", "cxx", "cyc", "m" ]), l(o({
        keywords: "null,true,false"
    }), [ "json" ]), l(o({
        keywords: b,
        hashComments: !0,
        cStyleComments: !0,
        verbatimStrings: !0,
        types: T
    }), [ "cs" ]), l(o({
        keywords: y,
        cStyleComments: !0
    }), [ "java" ]), l(o({
        keywords: k,
        hashComments: !0,
        multiLineStrings: !0
    }), [ "bash", "bsh", "csh", "sh" ]), l(o({
        keywords: C,
        hashComments: !0,
        multiLineStrings: !0,
        tripleQuotedStrings: !0
    }), [ "cv", "py", "python" ]), l(o({
        keywords: S,
        hashComments: !0,
        multiLineStrings: !0,
        regexLiterals: 2
    }), [ "perl", "pl", "pm" ]), l(o({
        keywords: E,
        hashComments: !0,
        multiLineStrings: !0,
        regexLiterals: !0
    }), [ "rb", "ruby" ]), l(o({
        keywords: w,
        cStyleComments: !0,
        regexLiterals: !0
    }), [ "javascript", "js" ]), l(o({
        keywords: x,
        hashComments: 3,
        cStyleComments: !0,
        multilineStrings: !0,
        tripleQuotedStrings: !0,
        regexLiterals: !0
    }), [ "coffee" ]), l(o({
        keywords: N,
        cStyleComments: !0,
        multilineStrings: !0
    }), [ "rc", "rs", "rust" ]), l(a([], [ [ _, /^[\s\S]+/ ] ]), [ "regex" ]);
    var W = p.PR = {
        createSimpleLexer: a,
        registerLangHandler: l,
        sourceDecorator: o,
        PR_ATTRIB_NAME: z,
        PR_ATTRIB_VALUE: B,
        PR_COMMENT: $,
        PR_DECLARATION: I,
        PR_KEYWORD: L,
        PR_LITERAL: R,
        PR_NOCODE: F,
        PR_PLAIN: O,
        PR_PUNCTUATION: M,
        PR_SOURCE: j,
        PR_STRING: _,
        PR_TAG: D,
        PR_TYPE: A,
        prettyPrintOne: IN_GLOBAL_SCOPE ? p.prettyPrintOne = d : prettyPrintOne = d,
        prettyPrint: prettyPrint = IN_GLOBAL_SCOPE ? p.prettyPrint = f : prettyPrint = f
    };
    "function" == typeof define && define.amd && define("google-code-prettify", [], function() {
        return W;
    });
}(), function(e) {
    function t() {
        var t = e(window).height(), a = e(document.body).height() - r.height(), o = t - a;
        n && (o -= 32), o <= 0 && (o = 1), r.height(o);
    }
    var n = !1, r = e("#footerMargin");
    e(window).on("sticky", t).scroll(t).resize(t), e("#siteLogo").each(function() {
        var t = e(this);
        if (Modernizr.svg) {
            var n = t.attr("id"), r = t.attr("class");
            e.get(t.attr("src"), function(a) {
                var o = e(a).find("svg");
                "undefined" != typeof n && o.attr("id", n), "undefined" != typeof r && o.attr("class", r + " replaced-svg"), 
                o = o.removeAttr("xmlns:a"), t.replaceWith(o);
            }, "xml");
        } else t.attr("src", t.attr("src").replace(/\.svg/gi, ".png"));
    }), e(document).ready(function() {
        e.isFunction(prettyPrint) && prettyPrint(), n = e("#wpadminbar").length > 0, t();
    });
}(jQuery);