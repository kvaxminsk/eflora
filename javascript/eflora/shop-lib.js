SM = {
    version: "1.0",
    shopSuffix: "&nbsp;товаров,&nbsp;товар,&nbsp;товара",
    shopCookie: "__shop",
    
    checkId: function (c) {
        var b = /^[0-9vm]+$/i;
        if (b.test(c)) {
            return c
        }
        return 0
    },
    Currency: {
        name: "",
        course: 1,
        decimals: 0,
        dsep: " ",
        tsep: "&nbsp;",
        init: function (cur) {
            if (typeof (cur.name) != "undefined") {
                this.name = cur.name
            }
            if (typeof (cur.course) != "undefined") {
                this.course = parseFloat(cur.course);
                if (!this.course) {
                    this.course = 1
                }
            }
            if (typeof (cur.decimals) != "undefined") {
                this.decimals = parseInt(cur.decimals);
                if (!this.decimals) {
                    this.decimals = 0
                }
            }
            if (typeof (cur.dsep) != "undefined") {
                this.dsep = cur.dsep
            }
            if (typeof (cur.tsep) != "undefined") {
                this.tsep = cur.tsep
            }
        }
    },
    Shop: {
        count: 0,
        price: 0,
        elements: [],
        save: function () {
            this.count = 0;
            this.price = 0;
            if (!this.elements) {
                return
            }
            
            cookie = new Array();
            for (i = 0; i < this.elements.length; i++){
                if(this.elements[i].id == null)
                    continue;
                
                this.count += this.elements[i].count;
                this.price += this.elements[i].price * this.elements[i].count;
                var obj = new Object();
                obj.id = this.elements[i].id;
                obj.count = this.elements[i].count;
                obj.price = this.elements[i].price;
                cookie[i] = obj;
            }
            SM.Cookie(SM.shopCookie, JSON.stringify(cookie), {
                expires: 7,
                path: "/"
            });
            if (typeof (this.onsave) == "function") {
                this.onsave()
            }
        },
        init: function (elements) {
            if (!elements) {
                elements = SM.Cookie(SM.shopCookie)
            }
            if (!elements) {
                return
            }
            
            if (typeof (elements) == "string") {
                var result = JSON.parse(elements);
                var n = 0;
                for (i = 0; i < result.length; i++){
                    id = SM.checkId(result[i].id);
                    price = SM.nf(result[i].price);
                    count = parseInt(result[i].count);
            
                    if (!id) {
                        throw 'Некорректный ID товара - ' + id;
                    }
                    this.elements[n] = {};
                    this.elements[n].id = id;
                    this.elements[n].count = typeof (count) == "undefined" ? 0 : count;
                    this.elements[n].price = typeof (price) == "undefined" ? 0 : price;
                    n++
                }
            }
            
            this.save()
        },
      
        add: function (id, count, price) {    
            f = 0;
            for (i in this.elements) {
                if (this.elements[i].id == id) {
                    f = 1;
                    break
                }
            }
            if (!f) {
                l = this.elements.length;
                this.elements[l] = new Object();
                this.elements[l].id = id;
                this.elements[l].price = price;
                this.elements[l].count = count;
            }
            this.save()
        },
        del: function (id) {
            newItems = new Array();
            n = 0;
            for (i = 0; i < this.elements.length; i++){
                if (this.elements[i].id != id) {
                    newItems[n] = this.elements[i];
                    n++
                }
            }
            this.elements = newItems;
            this.save()
        },
        find: function () {
            el = this.mkItem(arguments);
            for (i in this.elements) {
                if (this.elements[i].id == el.id) {
                    return i
                }
            }
        },
        update: function (id, count, price) {
            for (i = 0; i < this.elements.length; i++){
                if (this.elements[i].id == id) {
                    this.elements[i].count = count;
                    this.elements[i].price = price;
                }
            }
            this.save()
        },
        getCount: function () {
            return this.count
        },
        getPrice: function () {
            return this.price
        },
        clear: function () {
            this.elements = {};
            this.save()
        }
    },
    money: function (d, b, c) {
        b = b || "";
        c = c || "&nbsp;";
        $price = SM.formatPrice(d) + "";
        if (b) {
            $price = "<" + b + ">" + $price + "</" + b + ">"
        }
        if (SM.Currency.name) {
            $price += c + SM.Currency.name
        }
        return $price
    },
    nf: function (h, d, m, g) {
        function j(s, r) {
            r = !r ? " \\s\u00A0" : (r + "").replace(/([\[\]\(\)\.\?\/\*\{\}\+\$\^\:])/g, "\\$1");
            var q = new RegExp("[" + r + "]+$", "g");
            return (s + "").replace(q, "")
        }
        h = (h + "").replace(/[^0-9+\-Ee.]/g, "");
        var c = !isFinite(+h) ? 0 : +h,
            b = !isFinite(+d) ? 2 : Math.abs(d),
            p = (typeof g === "undefined") ? "" : g,
            e = (typeof m === "undefined") ? "." : m,
            o = "",
            k = function (s, r) {
                var q = Math.pow(10, r);
                return "" + Math.round(s * q) / q
            };
        o = (b ? k(c, b) : "" + Math.round(c)).split(".");
        if (o[0].length > 3) {
            o[0] = o[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, p)
        }
        if ((o[1] || "").length < b) {
            o[1] = o[1] || "";
            o[1] += new Array(b - o[1].length + 1).join("0")
        }
        val = o.join(e);
        if ((o[1] || "").length < b) {
            val = j(val, "0");
            val = j(val, ".")
        }
        return val
    },
    formatPrice: function (price) {
        price = SM.nf(price, SM.Currency.decimals, SM.Currency.dsep, SM.Currency.tsep);
        return price;
    },
    Cookie: function (c, m, q) {
        if (typeof m != "undefined") {
            q = q || {};
            if (m === null) {
                m = "";
                q.expires = -1
            }
            var g = "";
            if (q.expires && (typeof q.expires == "number" || q.expires.toUTCString)) {
                var h;
                if (typeof q.expires == "number") {
                    h = new Date();
                    h.setTime(h.getTime() + (q.expires * 24 * 60 * 60 * 1000))
                } else {
                    h = q.expires
                }
                g = "; expires=" + h.toUTCString()
            }
            var p = q.path ? "; path=" + (q.path) : "";
            var j = q.domain ? "; domain=" + (q.domain) : "";
            var b = q.secure ? "; secure" : "";
            document.cookie = [c, "=", encodeURIComponent(m), g, p, j, b].join("")
        } else {
            var e = null;
            if (document.cookie && document.cookie != "") {
                var o = document.cookie.split(";");
                for (var k = 0; k < o.length; k++) {
                    var d = o[k].replace(/^\s*|\s*$/g, "");
                    if (d.substring(0, c.length + 1) == (c + "=")) {
                        e = decodeURIComponent(d.substring(c.length + 1));
                        break
                    }
                }
            }
            return e
        }
    },
    ruscomp: function (c, b) {
        $comp = b.split(",");
        if (c == 0 || (c % 10) == 0) {
            return $comp[0]
        }
        if (c >= 5 && c <= 20) {
            return $comp[0]
        }
        if (c % 10 >= 5 && c % 10 <= 9) {
            return $comp[0]
        }
        if ((c % 10) == 1) {
            return $comp[1]
        }
        if ((c % 10) >= 2 && (c % 10) <= 4) {
            return $comp[2]
        }
    }
};