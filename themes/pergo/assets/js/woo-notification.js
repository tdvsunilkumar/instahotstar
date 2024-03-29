"use strict";

function vi_wn_b64DecodeUnicode(e) {
    var t = "";
    if (e) try {
        t = decodeURIComponent(atob(e).split("").map(function(e) {
            return "%" + ("00" + e.charCodeAt(0).toString(16)).slice(-2)
        }).join(""))
    } catch (t) {
        return e
    }
    return t
}

function viSwipeDetect(e, t) {
    var o, i, n, a, s, c, r = e,
        _ = t || function(e) {};
    r.addEventListener("touchstart", function(e) {
        var t = e.changedTouches[0];
        o = "none", i = t.pageX, n = t.pageY, c = (new Date).getTime()
    }, !1), r.addEventListener("touchmove", function(e) {
        e.preventDefault()
    }, !1), r.addEventListener("touchend", function(e) {
        var t = e.changedTouches[0];
        a = t.pageX - i, s = t.pageY - n, (new Date).getTime() - c <= 300 && (Math.abs(a) >= 150 && Math.abs(s) <= 100 ? o = a < 0 ? "left" : "right" : Math.abs(s) >= 150 && Math.abs(a) <= 100 && (o = s < 0 ? "up" : "down")), _(o)
    }, !1)
}
jQuery(document).ready(function(e) {
    if (jQuery("#message-purchased").length > 0) {
        var t = woo_notification;
        0 == _woocommerce_notification_params.billing && 0 == _woocommerce_notification_params.detect && t.detect_address(), viSwipeDetect(document.getElementById("message-purchased"), function(t) {
            "none" !== t && (parseInt(woo_notification.time_close) > 0 && (e("#message-purchased").unbind(), woo_notification.setCookie("woo_notification_close", 1, 3600 * parseInt(woo_notification.time_close))), woo_notification.message_hide(!1, t))
        })
    }
}), jQuery(window).load(function() {
    var e = woo_notification;
    if (e.ajax_url = _woocommerce_notification_params.ajax_url, e.products = _woocommerce_notification_params.products, e.messages = _woocommerce_notification_params.messages, e.image = _woocommerce_notification_params.image, e.redirect_target = _woocommerce_notification_params.redirect_target, e.time = _woocommerce_notification_params.time, e.display_effect = _woocommerce_notification_params.display_effect, e.hidden_effect = _woocommerce_notification_params.hidden_effect, e.messages = _woocommerce_notification_params.messages, e.names = _woocommerce_notification_params.names, e.detect = _woocommerce_notification_params.detect, e.billing = _woocommerce_notification_params.billing, e.message_custom = _woocommerce_notification_params.message_custom, e.message_number_min = _woocommerce_notification_params.message_number_min, e.message_number_max = _woocommerce_notification_params.message_number_max, e.time_close = _woocommerce_notification_params.time_close, e.show_close = _woocommerce_notification_params.show_close, 0 == _woocommerce_notification_params.billing && 0 == _woocommerce_notification_params.detect) {
        e.cities = [e.getCookie("wn_city")], e.country = [e.getCookie("wn_country")];
        var t = e.getCookie("wn_ip");
        t && "undefined" != t && e.init()
    } else e.cities = _woocommerce_notification_params.cities, e.country = _woocommerce_notification_params.country, e.init()
});
var woo_notification = {
    billing: 0,
    in_the_same_cate: 0,
    loop: 0,
    init_delay: 5,
    total: 30,
    display_time: 10,
    next_time: 60,
    count: 0,
    intel: 0,
    wn_popup: 0,
    id: 0,
    messages: "",
    products: "",
    ajax_url: "",
    display_effect: "",
    hidden_effect: "",
    time: "",
    names: "",
    cities: "",
    country: "",
    message_custom: "",
    message_number_min: "",
    message_number_max: "",
    detect: 0,
    time_close: 0,
    show_close: 0,
    shortcodes: ["{first_name}", "{city}", "{state}", "{country}", "{product}", "{product_with_link}", "{time_ago}", "{custom}"],
    init: function() {
        this.ajax_url ? this.ajax_get_data() : setTimeout(function() {
            woo_notification.get_product()
        }, 1e3 * this.init_delay), jQuery("#message-purchased").on("mouseenter", function() {
            window.clearInterval(woo_notification.wn_popup)
        }).on("mouseleave", function() {
            woo_notification.message_show()
        })
    },
    detect_address: function() {
        this.getCookie("wn_ip") || jQuery.getJSON("https://extreme-ip-lookup.com/json/", function(e) {
            e.query && woo_notification.setCookie("wn_ip", e.query, 86400), e.city && woo_notification.setCookie("wn_city", e.city, 86400), e.country && woo_notification.setCookie("wn_country", e.country, 86400)
        })
    },
    ajax_get_data: function() {
        var e;
        this.ajax_url && (e = this.id ? "&id=" + this.id : "", jQuery.ajax({
            type: "POST",
            data: "action=woonotification_get_product" + e,
            url: this.ajax_url,
            success: function(e) {
                var t = jQuery.parseJSON(e);
                t && "undefined" != t && t.length > 0 && (woo_notification.products = t, woo_notification.message_show(), setTimeout(function() {
                    woo_notification.get_product()
                }, 1e3 * woo_notification.init_delay))
            },
            error: function(e) {}
        }))
    },
    message_show: function() {
        var e = this.count++;
        if (!(this.total <= e)) {
            window.clearInterval(this.intel);
            var t = jQuery("#message-purchased");
            t.hasClass(this.hidden_effect) && t.removeClass(this.hidden_effect), t.addClass(this.display_effect).css("display", "flex"), this.wn_popup = setTimeout(function() {
                woo_notification.message_hide()
            }, 1e3 * this.display_time)
        }
    },
    message_hide: function(e = !1, t = "") {
        var o = jQuery("#message-purchased");
        switch (o.hasClass(this.display_effect) && o.removeClass(this.display_effect), t) {
            case "left":
                o.addClass("bounceOutLeft");
                break;
            case "right":
                o.addClass("bounceOutRight");
                break;
            case "up":
                o.addClass("bounceOutUp");
                break;
            case "down":
                o.addClass("bounceOutDown");
                break;
            default:
                o.addClass(this.hidden_effect)
        }
        if (o.fadeOut(1e3), !e && !this.getCookie("woo_notification_close")) {
            var i = this.count;
            1 == this.loop ? this.total > i && (window.clearTimeout(this.wn_popup), this.intel = setInterval(function() {
                woo_notification.get_product()
            }, 1e3 * this.next_time)) : (window.clearTimeout(this.wn_popup), window.clearInterval(this.intel))
        }
    },
    get_time_string: function() {
        var e = this.random(0, 3600 * this.time),
            t = parseFloat(e / 86400);
        return t > 1 ? 1 == (t = parseInt(t)) ? t + " " + _woocommerce_notification_params.str_day : t + " " + _woocommerce_notification_params.str_days : (t = parseFloat(e / 3600)) > 1 ? 1 == (t = parseInt(t)) ? t + " " + _woocommerce_notification_params.str_hour : t + " " + _woocommerce_notification_params.str_hours : (t = parseFloat(e / 60)) > 1 ? 1 == (t = parseInt(t)) ? t + " " + _woocommerce_notification_params.str_min : t + " " + _woocommerce_notification_params.str_mins : t < 10 ? _woocommerce_notification_params.str_few_sec : (t = parseInt(t)) + " " + _woocommerce_notification_params.str_secs
    },
    get_product: function() {
        var e, t, o, i, n, a, s = this.products,
            c = this.messages,
            r = this.image,
            _ = this.redirect_target;
        if ("undefined" != s && s && c && s.length > 0 && c.length > 0) {
            var m = c[a = woo_notification.random(0, c.length - 1)],
                u = s[a = woo_notification.random(0, s.length - 1)];
            parseInt(this.billing) > 0 && parseInt(this.in_the_same_cate) < 1 ? (e = vi_wn_b64DecodeUnicode(u.first_name), i = vi_wn_b64DecodeUnicode(u.city), t = vi_wn_b64DecodeUnicode(u.state), o = vi_wn_b64DecodeUnicode(u.country), n = u.time) : (this.names && "undefined" != this.names ? (a = woo_notification.random(0, this.names.length - 1), e = vi_wn_b64DecodeUnicode(this.names[a])) : e = "", this.cities && "undefined" != this.cities ? (a = woo_notification.random(0, this.cities.length - 1), i = vi_wn_b64DecodeUnicode(this.cities[a])) : i = "", t = "", o = this.country, n = this.get_time_string());
            var d = '<span class="wn-popup-product-title">' + u.title + "</span>",
                f = '<a class="wn-popup-product-title-with-link" ';
            "1" === _ && (f += 'target="_blank"'), f += ' href="' + u.url + '">' + u.title + "</a>";
            var p = "<small>" + _woocommerce_notification_params.str_about + " " + n + " " + _woocommerce_notification_params.str_ago + " </small>",
                h = this.message_custom,
                l = "";
            u.thumb ? (jQuery("#message-purchased").addClass("wn-product-with-image").removeClass("wn-product-without-image"), r ? (l = '<a class="wn-notification-image-wrapper" ', "1" === _ && (l += 'target="_blank"'), l += ' href="' + u.url + '"><img class="wn-notification-image" src="' + u.thumb + '"></a>') : l = '<span class="wn-notification-image-wrapper"><img class="wn-notification-image" src="' + u.thumb + '"></span>') : jQuery("#message-purchased").addClass("wn-product-without-image").removeClass("wn-product-with-image"), h = h.replace("{number}", this.random(this.message_number_min, this.message_number_max));
            for (var w = this.shortcodes, g = [e, i, t, o, d, f, p, h], y = m, v = w.length - 1; v >= 0; v--) y = y.replace(w[v], g[v]);
            var b = "";
            parseInt(this.show_close) > 0 && (b = '<div id="notify-close"></div>');
            var C = l + '<p class="wn-notification-message-container">' + y + "</p>";
            jQuery("#message-purchased").html('<div class="message-purchase-main">' + C + "</div>" + b), this.close_notify(), woo_notification.message_show()
        }
    },
    close_notify: function() {
        jQuery("#notify-close").unbind(), jQuery("#notify-close").bind("click", function() {
            woo_notification.message_hide(), parseInt(woo_notification.time_close) > 0 && (jQuery("#message-purchased").unbind(), woo_notification.setCookie("woo_notification_close", 1, 3600 * parseInt(woo_notification.time_close)))
        })
    },
    random: function(e, t) {
        e = parseInt(e), t = parseInt(t);
        var o = Math.random() * (t - e);
        return Math.round(o) + e
    },
    setCookie: function(e, t, o) {
        var i = new Date;
        i.setTime(i.getTime() + 1e3 * o);
        var n = "expires=" + i.toUTCString();
        document.cookie = e + "=" + t + ";" + n + ";path=/"
    },
    getCookie: function(e) {
        for (var t = e + "=", o = decodeURIComponent(document.cookie).split(";"), i = 0; i < o.length; i++) {
            for (var n = o[i];
                " " == n.charAt(0);) n = n.substring(1);
            if (0 == n.indexOf(t)) return n.substring(t.length, n.length)
        }
        return ""
    }
};