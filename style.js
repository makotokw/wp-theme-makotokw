window.PR_SHOULD_USE_CONTINUATION = !0;

var prettyPrintOne, prettyPrint;

(function() {
    function a(a) {
        function b(a) {
            var b = a.charCodeAt(0);
            if (92 !== b) return b;
            var c = a.charAt(1);
            return b = l[c], b ? b : c >= "0" && "7" >= c ? parseInt(a.substring(1), 8) : "u" === c || "x" === c ? parseInt(a.substring(2), 16) : a.charCodeAt(1);
        }
        function c(a) {
            if (32 > a) return (16 > a ? "\\x0" : "\\x") + a.toString(16);
            var b = String.fromCharCode(a);
            return "\\" === b || "-" === b || "]" === b || "^" === b ? "\\" + b : b;
        }
        function d(a) {
            var d = a.substring(1, a.length - 1).match(new RegExp("\\\\u[0-9A-Fa-f]{4}|\\\\x[0-9A-Fa-f]{2}|\\\\[0-3][0-7]{0,2}|\\\\[0-7]{1,2}|\\\\[\\s\\S]|-|[^-\\\\]", "g")), e = [], f = "^" === d[0], g = [ "[" ];
            f && g.push("^");
            for (var h = f ? 1 : 0, i = d.length; i > h; ++h) {
                var j = d[h];
                if (/\\[bdsw]/i.test(j)) g.push(j); else {
                    var k, l = b(j);
                    i > h + 2 && "-" === d[h + 1] ? (k = b(d[h + 2]), h += 2) : k = l, e.push([ l, k ]), 
                    65 > k || l > 122 || (65 > k || l > 90 || e.push([ 32 | Math.max(65, l), 32 | Math.min(k, 90) ]), 
                    97 > k || l > 122 || e.push([ -33 & Math.max(97, l), -33 & Math.min(k, 122) ]));
                }
            }
            e.sort(function(a, b) {
                return a[0] - b[0] || b[1] - a[1];
            });
            for (var m = [], n = [], h = 0; h < e.length; ++h) {
                var o = e[h];
                o[0] <= n[1] + 1 ? n[1] = Math.max(n[1], o[1]) : m.push(n = o);
            }
            for (var h = 0; h < m.length; ++h) {
                var o = m[h];
                g.push(c(o[0])), o[1] > o[0] && (o[1] + 1 > o[0] && g.push("-"), g.push(c(o[1])));
            }
            return g.push("]"), g.join("");
        }
        function e(a) {
            for (var b = a.source.match(new RegExp("(?:\\[(?:[^\\x5C\\x5D]|\\\\[\\s\\S])*\\]|\\\\u[A-Fa-f0-9]{4}|\\\\x[A-Fa-f0-9]{2}|\\\\[0-9]+|\\\\[^ux0-9]|\\(\\?[:!=]|[\\(\\)\\^]|[^\\x5B\\x5C\\(\\)\\^]+)", "g")), e = b.length, h = [], i = 0, j = 0; e > i; ++i) {
                var k = b[i];
                if ("(" === k) ++j; else if ("\\" === k.charAt(0)) {
                    var l = +k.substring(1);
                    l && (j >= l ? h[l] = -1 : b[i] = c(l));
                }
            }
            for (var i = 1; i < h.length; ++i) -1 === h[i] && (h[i] = ++f);
            for (var i = 0, j = 0; e > i; ++i) {
                var k = b[i];
                if ("(" === k) ++j, h[j] || (b[i] = "(?:"); else if ("\\" === k.charAt(0)) {
                    var l = +k.substring(1);
                    l && j >= l && (b[i] = "\\" + h[l]);
                }
            }
            for (var i = 0; e > i; ++i) "^" === b[i] && "^" !== b[i + 1] && (b[i] = "");
            if (a.ignoreCase && g) for (var i = 0; e > i; ++i) {
                var k = b[i], m = k.charAt(0);
                k.length >= 2 && "[" === m ? b[i] = d(k) : "\\" !== m && (b[i] = k.replace(/[a-zA-Z]/g, function(a) {
                    var b = a.charCodeAt(0);
                    return "[" + String.fromCharCode(-33 & b, 32 | b) + "]";
                }));
            }
            return b.join("");
        }
        for (var f = 0, g = !1, h = !1, i = 0, j = a.length; j > i; ++i) {
            var k = a[i];
            if (k.ignoreCase) h = !0; else if (/[a-z]/i.test(k.source.replace(/\\u[0-9a-f]{4}|\\x[0-9a-f]{2}|\\[^ux]/gi, ""))) {
                g = !0, h = !1;
                break;
            }
        }
        for (var l = {
            b: 8,
            t: 9,
            n: 10,
            v: 11,
            f: 12,
            r: 13
        }, m = [], i = 0, j = a.length; j > i; ++i) {
            var k = a[i];
            if (k.global || k.multiline) throw new Error("" + k);
            m.push("(?:" + e(k) + ")");
        }
        return new RegExp(m.join("|"), h ? "gi" : "g");
    }
    function b(a, b) {
        function c(a) {
            switch (a.nodeType) {
              case 1:
                if (d.test(a.className)) return;
                for (var i = a.firstChild; i; i = i.nextSibling) c(i);
                var j = a.nodeName.toLowerCase();
                ("br" === j || "li" === j) && (e[h] = "\n", g[h << 1] = f++, g[1 | h++ << 1] = a);
                break;

              case 3:
              case 4:
                var k = a.nodeValue;
                k.length && (k = b ? k.replace(/\r\n?/g, "\n") : k.replace(/[ \t\r\n]+/g, " "), 
                e[h] = k, g[h << 1] = f, f += k.length, g[1 | h++ << 1] = a);
            }
        }
        var d = /(?:^|\s)nocode(?:\s|$)/, e = [], f = 0, g = [], h = 0;
        return c(a), {
            sourceCode: e.join("").replace(/\n$/, ""),
            spans: g
        };
    }
    function c(a, b, c, d) {
        if (b) {
            var e = {
                sourceCode: b,
                basePos: a
            };
            c(e), d.push.apply(d, e.decorations);
        }
    }
    function d(a) {
        for (var b = void 0, c = a.firstChild; c; c = c.nextSibling) {
            var d = c.nodeType;
            b = 1 === d ? b ? a : c : 3 === d ? Q.test(c.nodeValue) ? a : b : b;
        }
        return b === a ? void 0 : b;
    }
    function e(b, d) {
        var e, f = {};
        (function() {
            for (var c = b.concat(d), g = [], h = {}, i = 0, j = c.length; j > i; ++i) {
                var k = c[i], l = k[3];
                if (l) for (var m = l.length; --m >= 0; ) f[l.charAt(m)] = k;
                var n = k[1], o = "" + n;
                h.hasOwnProperty(o) || (g.push(n), h[o] = null);
            }
            g.push(/[\0-\uffff]/), e = a(g);
        })();
        var g = d.length, h = function(a) {
            for (var b = a.sourceCode, i = a.basePos, k = [ i, I ], l = 0, m = b.match(e) || [], n = {}, o = 0, p = m.length; p > o; ++o) {
                var q, r = m[o], s = n[r], t = void 0;
                if ("string" == typeof s) q = !1; else {
                    var u = f[r.charAt(0)];
                    if (u) t = r.match(u[1]), s = u[0]; else {
                        for (var v = 0; g > v; ++v) if (u = d[v], t = r.match(u[1])) {
                            s = u[0];
                            break;
                        }
                        t || (s = I);
                    }
                    q = s.length >= 5 && "lang-" === s.substring(0, 5), !q || t && "string" == typeof t[1] || (q = !1, 
                    s = L), q || (n[r] = s);
                }
                var w = l;
                if (l += r.length, q) {
                    var x = t[1], y = r.indexOf(x), z = y + x.length;
                    t[2] && (z = r.length - t[2].length, y = z - x.length);
                    var A = s.substring(5);
                    c(i + w, r.substring(0, y), h, k), c(i + w + y, x, j(A, x), k), c(i + w + z, r.substring(z), h, k);
                } else k.push(i + w, s);
            }
            a.decorations = k;
        };
        return h;
    }
    function f(a) {
        var b = [], c = [];
        a.tripleQuotedStrings ? b.push([ C, /^(?:\'\'\'(?:[^\'\\]|\\[\s\S]|\'{1,2}(?=[^\']))*(?:\'\'\'|$)|\"\"\"(?:[^\"\\]|\\[\s\S]|\"{1,2}(?=[^\"]))*(?:\"\"\"|$)|\'(?:[^\\\']|\\[\s\S])*(?:\'|$)|\"(?:[^\\\"]|\\[\s\S])*(?:\"|$))/, null, "'\"" ]) : a.multiLineStrings ? b.push([ C, /^(?:\'(?:[^\\\']|\\[\s\S])*(?:\'|$)|\"(?:[^\\\"]|\\[\s\S])*(?:\"|$)|\`(?:[^\\\`]|\\[\s\S])*(?:\`|$))/, null, "'\"`" ]) : b.push([ C, /^(?:\'(?:[^\\\'\r\n]|\\.)*(?:\'|$)|\"(?:[^\\\"\r\n]|\\.)*(?:\"|$))/, null, "\"'" ]), 
        a.verbatimStrings && c.push([ C, /^@\"(?:[^\"]|\"\")*(?:\"|$)/, null ]);
        var d = a.hashComments;
        if (d && (a.cStyleComments ? (d > 1 ? b.push([ E, /^#(?:##(?:[^#]|#(?!##))*(?:###|$)|.*)/, null, "#" ]) : b.push([ E, /^#(?:(?:define|e(?:l|nd)if|else|error|ifn?def|include|line|pragma|undef|warning)\b|[^\r\n]*)/, null, "#" ]), 
        c.push([ C, /^<(?:(?:(?:\.\.\/)*|\/?)(?:[\w-]+(?:\/[\w-]+)+)?[\w-]+\.h(?:h|pp|\+\+)?|[a-z]\w*)>/, null ])) : b.push([ E, /^#[^\r\n]*/, null, "#" ])), 
        a.cStyleComments && (c.push([ E, /^\/\/[^\r\n]*/, null ]), c.push([ E, /^\/\*[\s\S]*?(?:\*\/|$)/, null ])), 
        a.regexLiterals) {
            var f = "/(?=[^/*])(?:[^/\\x5B\\x5C]|\\x5C[\\s\\S]|\\x5B(?:[^\\x5C\\x5D]|\\x5C[\\s\\S])*(?:\\x5D|$))+/";
            c.push([ "lang-regex", new RegExp("^" + P + "(" + f + ")") ]);
        }
        var g = a.types;
        g && c.push([ F, g ]);
        var h = ("" + a.keywords).replace(/^ | $/g, "");
        h.length && c.push([ D, new RegExp("^(?:" + h.replace(/[\s,]+/g, "|") + ")\\b"), null ]), 
        b.push([ I, /^\s+/, null, " \r\n	 " ]);
        var i = /^.[^\s\w\.$@\'\"\`\/\\]*/;
        return c.push([ G, /^@[a-z_$][a-z_$@0-9]*/i, null ], [ F, /^(?:[@_]?[A-Z]+[a-z][A-Za-z_$@0-9]*|\w+_t\b)/, null ], [ I, /^[a-z_$][a-z_$@0-9]*/i, null ], [ G, new RegExp("^(?:0x[a-f0-9]+|(?:\\d(?:_\\d+)*\\d*(?:\\.\\d*)?|\\.\\d\\+)(?:e[+\\-]?\\d+)?)[a-z]*", "i"), null, "0123456789" ], [ I, /^\\[\s\S]?/, null ], [ H, i, null ]), 
        e(b, c);
    }
    function g(a, b, c) {
        function d(a) {
            switch (a.nodeType) {
              case 1:
                if (f.test(a.className)) break;
                if ("br" === a.nodeName) e(a), a.parentNode && a.parentNode.removeChild(a); else for (var b = a.firstChild; b; b = b.nextSibling) d(b);
                break;

              case 3:
              case 4:
                if (c) {
                    var i = a.nodeValue, j = i.match(g);
                    if (j) {
                        var k = i.substring(0, j.index);
                        a.nodeValue = k;
                        var l = i.substring(j.index + j[0].length);
                        if (l) {
                            var m = a.parentNode;
                            m.insertBefore(h.createTextNode(l), a.nextSibling);
                        }
                        e(a), k || a.parentNode.removeChild(a);
                    }
                }
            }
        }
        function e(a) {
            function b(a, c) {
                var d = c ? a.cloneNode(!1) : a, e = a.parentNode;
                if (e) {
                    var f = b(e, 1), g = a.nextSibling;
                    f.appendChild(d);
                    for (var h = g; h; h = g) g = h.nextSibling, f.appendChild(h);
                }
                return d;
            }
            for (;!a.nextSibling; ) if (a = a.parentNode, !a) return;
            for (var c, d = b(a.nextSibling, 0); (c = d.parentNode) && 1 === c.nodeType; ) d = c;
            j.push(d);
        }
        for (var f = /(?:^|\s)nocode(?:\s|$)/, g = /\r\n?|\n/, h = a.ownerDocument, i = h.createElement("li"); a.firstChild; ) i.appendChild(a.firstChild);
        for (var j = [ i ], k = 0; k < j.length; ++k) d(j[k]);
        b === (0 | b) && j[0].setAttribute("value", b);
        var l = h.createElement("ol");
        l.className = "linenums";
        for (var m = Math.max(0, 0 | b - 1) || 0, k = 0, n = j.length; n > k; ++k) i = j[k], 
        i.className = "L" + (k + m) % 10, i.firstChild || i.appendChild(h.createTextNode(" ")), 
        l.appendChild(i);
        a.appendChild(l);
    }
    function h(a) {
        var b = /\bMSIE\s(\d+)/.exec(navigator.userAgent);
        b = b && +b[1] <= 8;
        var c = /\n/g, d = a.sourceCode, e = d.length, f = 0, g = a.spans, h = g.length, i = 0, j = a.decorations, k = j.length, l = 0;
        j[k] = e;
        var m, n;
        for (n = m = 0; k > n; ) j[n] !== j[n + 2] ? (j[m++] = j[n++], j[m++] = j[n++]) : n += 2;
        for (k = m, n = m = 0; k > n; ) {
            for (var o = j[n], p = j[n + 1], q = n + 2; k >= q + 2 && j[q + 1] === p; ) q += 2;
            j[m++] = o, j[m++] = p, n = q;
        }
        k = j.length = m;
        var r, s = a.sourceNode;
        s && (r = s.style.display, s.style.display = "none");
        try {
            for (;h > i; ) {
                g[i];
                var t, u = g[i + 2] || e, v = j[l + 2] || e, q = Math.min(u, v), w = g[i + 1];
                if (1 !== w.nodeType && (t = d.substring(f, q))) {
                    b && (t = t.replace(c, "\r")), w.nodeValue = t;
                    var x = w.ownerDocument, y = x.createElement("span");
                    y.className = j[l + 1];
                    var z = w.parentNode;
                    z.replaceChild(y, w), y.appendChild(w), u > f && (g[i + 1] = w = x.createTextNode(d.substring(q, u)), 
                    z.insertBefore(w, y.nextSibling));
                }
                f = q, f >= u && (i += 2), f >= v && (l += 2);
            }
        } finally {
            s && (s.style.display = r);
        }
    }
    function i(a, b) {
        for (var c = b.length; --c >= 0; ) {
            var d = b[c];
            S.hasOwnProperty(d) ? n.console && console.warn("cannot override language handler %s", d) : S[d] = a;
        }
    }
    function j(a, b) {
        return a && S.hasOwnProperty(a) || (a = /^\s*</.test(b) ? "default-markup" : "default-code"), 
        S[a];
    }
    function k(a) {
        var c = a.langExtension;
        try {
            var d = b(a.sourceNode, a.pre), e = d.sourceCode;
            a.sourceCode = e, a.spans = d.spans, a.basePos = 0, j(c, e)(a), h(a);
        } catch (f) {
            n.console && console.log(f && f.stack ? f.stack : f);
        }
    }
    function l(a, b, c) {
        var d = document.createElement("pre");
        d.innerHTML = a, c && g(d, c, !0);
        var e = {
            langExtension: b,
            numberLines: c,
            sourceNode: d,
            pre: 1
        };
        return k(e), d.innerHTML;
    }
    function m(a) {
        function b(a) {
            return document.getElementsByTagName(a);
        }
        function c() {
            for (var b = n.PR_SHOULD_USE_CONTINUATION ? l.now() + 250 : 1/0; o < f.length && l.now() < b; o++) {
                var e = f[o], h = e.className;
                if (q.test(h) && !r.test(h)) {
                    for (var i = !1, j = e.parentNode; j; j = j.parentNode) {
                        var v = j.tagName;
                        if (u.test(v) && j.className && q.test(j.className)) {
                            i = !0;
                            break;
                        }
                    }
                    if (!i) {
                        e.className += " prettyprinted";
                        var w, x = h.match(p);
                        !x && (w = d(e)) && t.test(w.tagName) && (x = w.className.match(p)), x && (x = x[1]);
                        var y;
                        if (s.test(e.tagName)) y = 1; else {
                            var z = e.currentStyle, A = z ? z.whiteSpace : document.defaultView && document.defaultView.getComputedStyle ? document.defaultView.getComputedStyle(e, null).getPropertyValue("white-space") : 0;
                            y = A && "pre" === A.substring(0, 3);
                        }
                        var B = e.className.match(/\blinenums\b(?::(\d+))?/);
                        B = B ? B[1] && B[1].length ? +B[1] : !0 : !1, B && g(e, B, y), m = {
                            langExtension: x,
                            sourceNode: e,
                            numberLines: B,
                            pre: y
                        }, k(m);
                    }
                }
            }
            o < f.length ? setTimeout(c, 250) : a && a();
        }
        for (var e = [ b("pre"), b("code"), b("xmp") ], f = [], h = 0; h < e.length; ++h) for (var i = 0, j = e[h].length; j > i; ++i) f.push(e[h][i]);
        e = null;
        var l = Date;
        l.now || (l = {
            now: function() {
                return +new Date();
            }
        });
        var m, o = 0, p = /\blang(?:uage)?-([\w.]+)(?!\S)/, q = /\bprettyprint\b/, r = /\bprettyprinted\b/, s = /pre|xmp/i, t = /^code$/i, u = /^(?:pre|code|xmp)$/i;
        c();
    }
    var n = window, o = [ "break,continue,do,else,for,if,return,while" ], p = [ o, "auto,case,char,const,default,double,enum,extern,float,goto,int,long,register,short,signed,sizeof,static,struct,switch,typedef,union,unsigned,void,volatile" ], q = [ p, "catch,class,delete,false,import,new,operator,private,protected,public,this,throw,true,try,typeof" ], r = [ q, "alignof,align_union,asm,axiom,bool,concept,concept_map,const_cast,constexpr,decltype,dynamic_cast,explicit,export,friend,inline,late_check,mutable,namespace,nullptr,reinterpret_cast,static_assert,static_cast,template,typeid,typename,using,virtual,where" ], s = [ q, "abstract,boolean,byte,extends,final,finally,implements,import,instanceof,null,native,package,strictfp,super,synchronized,throws,transient" ], t = [ s, "as,base,by,checked,decimal,delegate,descending,dynamic,event,fixed,foreach,from,group,implicit,in,interface,internal,into,is,let,lock,object,out,override,orderby,params,partial,readonly,ref,sbyte,sealed,stackalloc,string,select,uint,ulong,unchecked,unsafe,ushort,var,virtual,where" ], u = "all,and,by,catch,class,else,extends,false,finally,for,if,in,is,isnt,loop,new,no,not,null,of,off,on,or,return,super,then,throw,true,try,unless,until,when,while,yes", v = [ q, "debugger,eval,export,function,get,null,set,undefined,var,with,Infinity,NaN" ], w = "caller,delete,die,do,dump,elsif,eval,exit,foreach,for,goto,if,import,last,local,my,next,no,our,print,package,redo,require,sub,undef,unless,until,use,wantarray,while,BEGIN,END", x = [ o, "and,as,assert,class,def,del,elif,except,exec,finally,from,global,import,in,is,lambda,nonlocal,not,or,pass,print,raise,try,with,yield,False,True,None" ], y = [ o, "alias,and,begin,case,class,def,defined,elsif,end,ensure,false,in,module,next,nil,not,or,redo,rescue,retry,self,super,then,true,undef,unless,until,when,yield,BEGIN,END" ], z = [ o, "case,done,elif,esac,eval,fi,function,in,local,set,then,until" ], A = [ r, t, v, w + x, y, z ], B = /^(DIR|FILE|vector|(de|priority_)?queue|list|stack|(const_)?iterator|(multi)?(set|map)|bitset|u?(int|float)\d*)\b/, C = "str", D = "kwd", E = "com", F = "typ", G = "lit", H = "pun", I = "pln", J = "tag", K = "dec", L = "src", M = "atn", N = "atv", O = "nocode", P = "(?:^^\\.?|[+-]|[!=]=?=?|\\#|%=?|&&?=?|\\(|\\*=?|[+\\-]=|->|\\/=?|::?|<<?=?|>>?>?=?|,|;|\\?|@|\\[|~|{|\\^\\^?=?|\\|\\|?=?|break|case|continue|delete|do|else|finally|instanceof|return|throw|try|typeof)\\s*", Q = /\S/, R = f({
        keywords: A,
        hashComments: !0,
        cStyleComments: !0,
        multiLineStrings: !0,
        regexLiterals: !0
    }), S = {};
    i(R, [ "default-code" ]), i(e([], [ [ I, /^[^<?]+/ ], [ K, /^<!\w[^>]*(?:>|$)/ ], [ E, /^<\!--[\s\S]*?(?:-\->|$)/ ], [ "lang-", /^<\?([\s\S]+?)(?:\?>|$)/ ], [ "lang-", /^<%([\s\S]+?)(?:%>|$)/ ], [ H, /^(?:<[%?]|[%?]>)/ ], [ "lang-", /^<xmp\b[^>]*>([\s\S]+?)<\/xmp\b[^>]*>/i ], [ "lang-js", /^<script\b[^>]*>([\s\S]*?)(<\/script\b[^>]*>)/i ], [ "lang-css", /^<style\b[^>]*>([\s\S]*?)(<\/style\b[^>]*>)/i ], [ "lang-in.tag", /^(<\/?[a-z][^<>]*>)/i ] ]), [ "default-markup", "htm", "html", "mxml", "xhtml", "xml", "xsl" ]), 
    i(e([ [ I, /^[\s]+/, null, " 	\r\n" ], [ N, /^(?:\"[^\"]*\"?|\'[^\']*\'?)/, null, "\"'" ] ], [ [ J, /^^<\/?[a-z](?:[\w.:-]*\w)?|\/?>$/i ], [ M, /^(?!style[\s=]|on)[a-z](?:[\w:-]*\w)?/i ], [ "lang-uq.val", /^=\s*([^>\'\"\s]*(?:[^>\'\"\s\/]|\/(?=\s)))/ ], [ H, /^[=<>\/]+/ ], [ "lang-js", /^on\w+\s*=\s*\"([^\"]+)\"/i ], [ "lang-js", /^on\w+\s*=\s*\'([^\']+)\'/i ], [ "lang-js", /^on\w+\s*=\s*([^\"\'>\s]+)/i ], [ "lang-css", /^style\s*=\s*\"([^\"]+)\"/i ], [ "lang-css", /^style\s*=\s*\'([^\']+)\'/i ], [ "lang-css", /^style\s*=\s*([^\"\'>\s]+)/i ] ]), [ "in.tag" ]), 
    i(e([], [ [ N, /^[\s\S]+/ ] ]), [ "uq.val" ]), i(f({
        keywords: r,
        hashComments: !0,
        cStyleComments: !0,
        types: B
    }), [ "c", "cc", "cpp", "cxx", "cyc", "m" ]), i(f({
        keywords: "null,true,false"
    }), [ "json" ]), i(f({
        keywords: t,
        hashComments: !0,
        cStyleComments: !0,
        verbatimStrings: !0,
        types: B
    }), [ "cs" ]), i(f({
        keywords: s,
        cStyleComments: !0
    }), [ "java" ]), i(f({
        keywords: z,
        hashComments: !0,
        multiLineStrings: !0
    }), [ "bsh", "csh", "sh" ]), i(f({
        keywords: x,
        hashComments: !0,
        multiLineStrings: !0,
        tripleQuotedStrings: !0
    }), [ "cv", "py" ]), i(f({
        keywords: w,
        hashComments: !0,
        multiLineStrings: !0,
        regexLiterals: !0
    }), [ "perl", "pl", "pm" ]), i(f({
        keywords: y,
        hashComments: !0,
        multiLineStrings: !0,
        regexLiterals: !0
    }), [ "rb" ]), i(f({
        keywords: v,
        cStyleComments: !0,
        regexLiterals: !0
    }), [ "js" ]), i(f({
        keywords: u,
        hashComments: 3,
        cStyleComments: !0,
        multilineStrings: !0,
        tripleQuotedStrings: !0,
        regexLiterals: !0
    }), [ "coffee" ]), i(e([], [ [ C, /^[\s\S]+/ ] ]), [ "regex" ]);
    var T = n.PR = {
        createSimpleLexer: e,
        registerLangHandler: i,
        sourceDecorator: f,
        PR_ATTRIB_NAME: M,
        PR_ATTRIB_VALUE: N,
        PR_COMMENT: E,
        PR_DECLARATION: K,
        PR_KEYWORD: D,
        PR_LITERAL: G,
        PR_NOCODE: O,
        PR_PLAIN: I,
        PR_PUNCTUATION: H,
        PR_SOURCE: L,
        PR_STRING: C,
        PR_TAG: J,
        PR_TYPE: F,
        prettyPrintOne: n.prettyPrintOne = l,
        prettyPrint: n.prettyPrint = m
    };
    "function" == typeof define && define.amd && define(function() {
        return T;
    });
})(), function() {
    var a = navigator.userAgent.toLowerCase().indexOf("webkit") > -1, b = navigator.userAgent.toLowerCase().indexOf("opera") > -1, c = navigator.userAgent.toLowerCase().indexOf("msie") > -1;
    if ((a || b || c) && "undefined" != typeof document.getElementById) {
        var d = window.addEventListener ? "addEventListener" : "attachEvent";
        window[d]("hashchange", function() {
            var a = document.getElementById(location.hash.substring(1));
            a && (/^(?:a|select|input|button|textarea)$/i.test(a.tagName) || (a.tabIndex = -1), 
            a.focus());
        }, !1);
    }
}(), function(a) {
    function b() {
        function b(a) {
            var b = parseInt(a);
            return isNaN(b) ? 0 : b;
        }
        var c = a("#shareThis"), d = c.data("url"), f = encodeURIComponent(d);
        e && (a.ajax({
            url: "http://urls.api.twitter.com/1/urls/count.json?url=" + f,
            dataType: "jsonp"
        }).done(function(d) {
            if (d) {
                var e = a("<a/>").addClass("share-count share-count-link").text(b(d.count));
                e.attr({
                    href: "http://twitter.com/search?q=" + f,
                    target: "_blank"
                }), c.find(".share-twitter .share-title").append(e);
            }
        }), a.ajax({
            url: "http://api.b.st-hatena.com/entry.count?url=" + f,
            dataType: "jsonp"
        }).done(function(d) {
            var e = a("<span/>").addClass("share-count").text(b(d));
            c.find(".share-hatena .share-title").append(e);
        }), a.ajax({
            url: "https://graph.facebook.com/?id=" + f,
            dataType: "jsonp"
        }).done(function(d) {
            if (d) {
                var e = a("<span/>").addClass("share-count").text(b(d.shares));
                c.find(".share-facebook .share-title").append(e);
            }
        }), makotokw && makotokw.counter_api && makotokw.counter_api.length > 0 && a.ajax({
            url: makotokw.counter_api + "?url=" + f,
            dataType: "jsonp"
        }).done(function(d) {
            if (d) {
                var e = a("<span/>").addClass("share-count").text(b(d.pocket));
                c.find(".share-pocket .share-title").append(e);
                var f = a("<span/>").addClass("share-count").text(b(d.google));
                c.find(".share-googleplus .share-title").append(f);
            }
        }));
    }
    function c() {
        var c = a("#shareThis");
        c.length > 0 && e && a(window).bind("scroll.shareThis load.shareThis", function() {
            a(this).scrollTop() + a(this).height() > c.offset().top && (b(), a(this).unbind("scroll.shareThis load.shareThis"));
        });
    }
    function d() {
        var b = a(window).height(), c = a(document.body).height() - j.height(), d = b - c;
        e && (d -= 32), 0 >= d && (d = 1), j.height(d);
    }
    var e = !1, f = navigator.userAgent, g = f.match(/msie/i), h = g && f.match(/msie 7\./i), i = g && f.match(/msie 8\./i);
    g && (h ? a("html").addClass("ie ie7") : i ? a("html").addClass("ie ie8") : a("html").addClass("ie"));
    var j = (a("#main"), a("#footerMargin"));
    a(window).on("sticky", d).scroll(d).resize(d), a(document).ready(function() {
        a.isFunction(prettyPrint) && prettyPrint(), e = a("#wpadminbar").length > 0, c(), 
        d();
    });
}(jQuery);