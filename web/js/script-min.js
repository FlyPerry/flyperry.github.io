$(function ()   {
    var App;
    window.userEventHandler = function (event, data = {}) {
        for (var i in console.log("event:" + event), "undefined" != typeof VK && (console.log("vk pixel event: " + event), VK.Retargeting.Event(event)), "undefined" != typeof fbq && (console.log("fb pixel event: " + event), fbq("trackCustom", event)), window) if (new RegExp(/yaCounter/).test(i)) {
            var ya_counter_id = i;
            ya_counter_id = eval(ya_counter_id), ya_counter_id.reachGoal(event), console.log("ym event: " + event), "add" != event && "order" != event || (window.dataLayer = window.dataLayer || [], window.dataLayer.push(data))
        }
        return "undefined" != typeof ga && (console.log("ga event: " + event), "add" == event && ga("send", {
            hitType: "event",
            eventCategory: "Items",
            eventAction: "Add"
        }), "order" == event && ga("send", {hitType: "event", eventCategory: "Items", eventAction: "Order"})), !0
    }, window.addshop = (App = {
        version: "0.02",
        basket: {
            status: 0, storage_name: "addshop_basket", getData: function () {
                var t = JSON.parse(localStorage.getItem(this.storage_name));
                return null == t ? [] : t
            },
            getItem: function (t) {
                var e = this.getData(), i = {};
                return $.each(e, function (e, a) {
                    e == t && (i = a)
                }), i
            },
            saveData: function (t) {
                try {
                    localStorage.setItem(this.storage_name, JSON.stringify(t))
                } catch (t) {
                    t == QUOTA_EXCEEDED_ERR && alert("Ошибка добавления номера в корзину.")
                }
            },
            clean: function () {
                this.saveData([])
            },
            addItem: function (t) {
                var e = this.getData(), i = !1;
                $.each(e, function (a, n) {
                    n.offer_id == t.offer_id && (i++, e[a].quantity = 1 * e[a].quantity, e[a].quantity += 1 * t.quantity)
                }), 0 == i && (e.push(t), window.userEventHandler("add", {
                    ecommerce: {
                        add: {
                            products: [{
                                id: t.offer_id,
                                name: t.title,
                                price: t.price,
                                quantity: t.quantity
                            }]
                        }
                    }
                })), this.saveData(e)
            },
            replaceItemByIndex: function (t, e) {
                var i = this.getData();
                i.splice(e, 1, t), this.saveData(i)
            },
            removeItemByIndex: function (t) {
                var e = this.getData();
                e.splice(t, 1), this.saveData(e), $(".pop_up_price").remove()
            },
            numberWithCommas: function (t) {
                return t.toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ")
            },
            renderfloatBasketList: function () {
                var t = this.getData(), e = parseFloat(window.customer_discount), i = 0, a = "", n = 1 - e / 100, s = 0,
                    o = 0, c = "", r = "", l = 0;
                e && (r = "discount_exist"), $.each(t, function (t, c) {
                    if ($(".pop_up_price").remove(), 0 != c.discount) if (i = c.discount, "percent" === c.discount_type) var d = 1 - parseFloat(c.discount) / 100; else d = parseFloat(c.discount);
                    var p = "", u = parseFloat(c.quantity).toFixed(1);
                    l += parseInt(u);
                    var m = parseFloat(c.price).toFixed(2), v = m * n;
                    if ("percent" === c.discount_type) var _ = m * d; else _ = m - d;
                    if (d ? (r = "discount_exist", p = `<div class="price_new">Цена со скидкой: ${App.basket.numberWithCommas(_.toFixed(2))} ${shop_currency}</div>`) : e && (r = "discount_exist", p = `<div class="price_new">Цена со скидкой: ${App.basket.numberWithCommas(v.toFixed(2))}  ${shop_currency}</div>`), "percent" === c.discount_type) var h = parseFloat(c.price * c.quantity).toFixed(2); else h = parseFloat((c.price - c.discount) * c.quantity).toFixed(2);
                    0, a += `<div class="item_in_basket">\n\t\t\t\t\t\t\t\t\t<a  href="${c.link}">\n\t\t\t\t\t\t\t\t\t<div class="image"><img src="${c.image}" /></div>\n\t\t\t\t\t\t\t\t\t<div class="descr">\n\t\t\t\t\t\t\t\t\t\t<div class="title">${c.title}</div>\n\t\t\t\t\t\t\t\t\t\t<div class="quantity">Количество: ${u}</div>\n\t\t\t\t\t\t\t\t\t\t<div class="price ${r}">Цена: ${m}  ${shop_currency}</div>\n\t\t\t\t\t\t\t\t\t\t${p}\n\t\t\t\t\t\t\t\t\t</div>\n\t\t\t\t\t\t\t\t\t</a>\n\t\t\t\t\t\t\t\t</div>`, o += parseFloat(h), d && d < 1 ? "percent" == c.discount_type && (h *= d) : e && (h *= 1 - e / 100), s += parseFloat(h)
                }), c = window.customer_discount || i ? s.toFixed(2) : "";
                var d = "";
                var p = ($("body").outerWidth() - $(".inner").outerWidth()) / 2 + "px";
                return $("#basket_popup_list").css("right", p), "kanasi" == template_class ? $(".basket").append(`<div class="pop_up_price">${parseInt(s)} ${shop_currency}</div>`) : "taymyr" == template_class ? ($(".basket .icon_cont").append(`<div class="pop_up_price">${parseInt(s)} ${shop_currency}</div>`), $(".basket a").append(`<div class="pop_up_count">${l}</div>`)) : "simple" != template_class && "mirror" != template_class && "michigan" != template_class && "superior" != template_class || $(".basket a").append(`<div class="pop_up_count">${l}</div>`), !0
            },
        },
        storage: {
            status: 0, storage_name: "addshop_common", getData: function () {
                var t = JSON.parse(sessionStorage.getItem(this.storage_name));
                return null == t ? {} : t
            },
            saveData: function (t) {
                try {
                    return sessionStorage.setItem(this.storage_name, JSON.stringify(t)), !0
                } catch (t) {
                    return t == QUOTA_EXCEEDED_ERR && alert("Ошибка добавления в хранилище."), !1
                }
            },
            clean: function () {
                return this.saveData({}), !0
            },
            setProp: function (t, e) {
                var i = this.getData();
                return i[t] = e, this.saveData(i), !0
            },
            setProps: function (t) {
                var e = this.getData();
                return $.extend(e, t), this.saveData(e), !0
            },
            removeProp: function (t) {
                var e = this.getData();
                return delete e[t], this.saveData(e), !0
            }, getProp: function (t) {
                return this.getData()[t] || ""
            }
        },
        checkDropdownMenu: function () {
            $(".menu_collapse_1 .level_1 .level_2").before('<div class="chevron_down"><i class="chevron_down_icon"></i></div>')
        },
        renderFavorites: function () {
            var t = App.storage.getProp("favorites") || [];
            $("#favorites_list").html(""), 0 == t.length && $("#favorites_list").html("Пока тут пусто."), $.each(t, function (e) {
                $("#favorites_list").append(`<div class="item_favorites"><img class="image" src="${t[e].image}" /><a class="title" href="${t[e].link}">${t[e].title}</a><span class="price">${t[e].price} ${shop_currency}</span> <span class="remove" data-index="${e}"><i class="fas fa-trash-alt"></i></span></div>`)
            })
        },
        setCookieSimple: function (t, e) {
            document.cookie = t + "=" + (e || "")
        },
        setCookie: function (t, e, i) {
            var a = (i = i || {}).expires;
            if ("number" == typeof a && a) {
                var n = new Date;
                n.setTime(n.getTime() + 1e3 * a), a = i.expires = n
            }
            a && a.toUTCString && (i.expires = a.toUTCString());
            var s = t + "=" + (e = encodeURIComponent(e)) + ";path=/";
            for (var o in i) {
                s += "; " + o;
                var c = i[o];
                !0 !== c && (s += "=" + c)
            }
            document.cookie = s
        },
        itemSC: function (t) {
            var e, i, a = 0, n = 0, s = (t = $(t), new Swiper(".gallery-top", {}));
            if (t.hasClass("color")) {
                var o = !1;
                $(".size").addClass("disabled"), $(".size.active").removeClass("disabled"), $(".colors .color.active").removeClass("disabled")
            }
            $(".color.active").data("color") && (a = 1 * $(".color.active").data("color")), $(".size.active").data("size") && (n = 1 * $(".size.active").data("size")), $.each(window.item.offers, function (t, e) {
                a > 0 && 0 == n && a == e.color_id && $('.size[data-size="' + e.size_id + '"]').removeClass("disabled"), n > 0 && 0 == a && n == e.size_id && $('.color[data-color="' + e.color_id + '"]').removeClass("disabled")
            }), s.slideTo((e = "offer_image_" + a, i = 0, $.each($(".gallery-top .swiper-wrapper").children(), function (t, a) {
                if ($(a).hasClass(e)) return i = t, !1
            }), i), 0, !0), 0 == a && 0 == n && ($(".size").removeClass("disabled"), $(".color").removeClass("disabled")), $.each(window.item.offers, function (t, e) {
                e.color_id == a && e.size_id == n && (o = e)
            });
            var c = window.item.step || 1;
            if (o) {
                var r = window.item.max_in_order, l = window.item.min_in_order;
                if (1 * o.quantity > 0 && 1 * o.infinitely == 0) $(".availability").text("В наличии"), r = o.quantity; else if (1 == o.infinitely) $(".availability").text("В наличии"); else {
                    if (!(1 * o.quantity <= 0 && 1 * window.item.under_the_order == 1)) return $(".availability").text("Нет в наличии"), void $(".item_price").html("Извините, но данный товар закончился на складе.");
                    $(".availability").text("Под заказ")
                }
                let t = "", e = "", i = "", a = 0, n = "", s = "";
                switch (window.one_click_buy && (n = '<button class="oneclickbuy"><i class="f7-icons">arrowshape_turn_up_left_2</i>Купить сейчас</button>', s = '<button class="oneclickbuy"><i class="fas fa-shopping-bag"></i>Купить сейчас</button>'), window.item_discount ? (e = "discount_exist", t = `<span class="one_price">${((a = "absolute" == window.discount_type ? o.price - window.item_discount : o.price * (1 - window.item_discount / 100).toFixed(2)) * window.item.min_in_order).toFixed(2)} ${shop_currency}</span>`, i = `<span class="total_new">${(a * window.item.min_in_order).toFixed(2)} ${shop_currency}</span>`) : window.customer_discount && (e = "discount_exist", t = `<span class="one_price">${((a = o.price * (1 - window.customer_discount / 100).toFixed(2)) * window.item.min_in_order).toFixed(2)} ${shop_currency}</span>`, i = `<span class="total_new">${(a * window.item.min_in_order).toFixed(2)} ${shop_currency}</span>`), template_class) {
                    case"simple":
                        $(".item_price").html(`\n\t\t\t\t\t\t\t\t<form method="GET" action="/basket/add/">\n\t\t\t\t\t\t\t\t\t<input type="hidden" name="step" value="${c}" />\n\t\t\t\t\t\t\t\t\t<input type="hidden" name="max" value="${r}" />\n\t\t\t\t\t\t\t\t\t<input type="hidden" name="min" value="${l}" />\n\t\t\t\t\t\t\t\t\t<input type="hidden" name="price" value="${o.price}" />\n\t\t\t\t\t\t\t\t\t<input type="hidden" name="offer_id" value="${o.id}" />\n\t\t\t\t\t\t\t\t\t<div class="count">\n\t\t\t\t\t\t\t\t\t\t<div class="count_minus">-</div>\n\t\t\t\t\t\t\t\t\t\t<input type="text" name="quantity" class="number_input" value="${l}" min="${l}" step="${c}" max="${r}" />\n\t\t\t\t\t\t\t\t\t\t<div class="count_plus">+</div>\n\t\t\t\t\t\t\t\t\t</div>\n\t\t\t\t\t\t\t\t\t<div class="total_price">${App.basket.numberWithCommas(i)}<span class="total ${e}"> ${App.basket.numberWithCommas(o.price)}  ${shop_currency}</span></div>\n\t\t\t\t\t\t\t\t\t<button class="add_to_basket">В корзину</button>\n\t\t\t\t\t\t\t\t\t${n}\n\t\t\t\t\t\t\t\t</form>`), $(".simple_price").children().remove(), $(".simple_price").prepend(`<div class="total_price">${App.basket.numberWithCommas(i)}<span class="total ${e}"> ${App.basket.numberWithCommas(o.price * window.item.min_in_order)}  ${shop_currency}</span></div>`);
                        break;
                    case"superior":
                        $(".item_price").html(`<form method="GET" action="/basket/add/">\n\t\t\t\t\t\t\t\t\t<input type="hidden" name="step" value="${c}" />\n\t\t\t\t\t\t\t\t\t<input type="hidden" name="max" value="${r}" />\n\t\t\t\t\t\t\t\t\t<input type="hidden" name="min" value="${l}" />\n\t\t\t\t\t\t\t\t\t<input type="hidden" name="price" value="${o.price}" />\n\t\t\t\t\t\t\t\t\t<input type="hidden" name="offer_id" value="${o.id}" />\n\t\t\t\t\t\t\t\t\t<div class="count">\n\t\t\t\t\t\t\t\t\t<div class="count_minus">-</div>\n\t\t\t\t\t\t\t\t\t<input type="text" name="quantity" class="number_input" value="${l}" min="${l}" step="${c}" max="${r}"  />\n\t\t\t\t\t\t\t\t\t<div class="count_plus">+</div>\n\t\t\t\t\t\t\t\t</div>\n\t\t\t\t\t\t\t\t\t<button class="add_to_basket"><i class="fas fa-cart-plus"></i>В корзину</button>\n\t\t\t\t\t\t\t\t\t${s}\n\t\t\t\t\t\t\t\t</form>`), $(".item_top_price").children().remove(), $(".item_top_price").prepend(`<div class="total_price">${App.basket.numberWithCommas(i)}<span class="total ${e}"> ${App.basket.numberWithCommas(o.price * window.item.min_in_order)}  ${shop_currency}</span></div>`);
                        break;
                    case"michigan":
                    case"tahoe":
                        $(".item_price").html(`\n\t\t\t\t\t\t\t\t<form method="GET" action="/basket/add/">\n\t\t\t\t\t\t\t\t\t<input type="hidden" name="step" value="${c}" />\n\t\t\t\t\t\t\t\t\t<input type="hidden" name="max" value="${r}" />\n\t\t\t\t\t\t\t\t\t<input type="hidden" name="min" value="${l}" />\n\t\t\t\t\t\t\t\t\t<input type="hidden" name="price" value="${o.price}" />\n\t\t\t\t\t\t\t\t\t<input type="hidden" name="offer_id" value="${o.id}" />\n\t\t\t\t\t\t\t\t\t<div class="count">\n\t\t\t\t\t\t\t\t\t\t<div class="count_minus">-</div>\n\t\t\t\t\t\t\t\t\t\t<input type="text" name="quantity" class="number_input" value="${l}" min="${l}" step="${c}" max="${r}" />\n\t\t\t\t\t\t\t\t\t\t<div class="count_plus">+</div>\n\t\t\t\t\t\t\t\t\t</div>\n\t\t\t\t\t\t\t\t\t<div class="total_price">${App.basket.numberWithCommas(i)}<span class="total ${e}"> ${App.basket.numberWithCommas(o.price * window.item.min_in_order)}  ${shop_currency}</span></div>\n\t\t\t\t\t\t\t\t\t<button class="add_to_basket">В корзину</button>\n\t\t\t\t\t\t\t\t\t${n}\n\t\t\t\t\t\t\t\t</form>`);
                        break;
                    case"taymyr":
                        $(".item_price").html(`\n\t\t\t\t\t\t\t\t<form method="GET" action="/basket/add/">\n\t\t\t\t\t\t\t\t\t<input type="hidden" name="step" value="${c}" />\n\t\t\t\t\t\t\t\t\t<input type="hidden" name="max" value="${r}" />\n\t\t\t\t\t\t\t\t\t<input type="hidden" name="min" value="${l}" />\n\t\t\t\t\t\t\t\t\t<input type="hidden" name="price" value="${o.price}" />\n\t\t\t\t\t\t\t\t\t<input type="hidden" name="offer_id" value="${o.id}" />\n\t\t\t\t\t\t\t\t\t<div class="count">\n\t\t\t\t\t\t\t\t\t\t<div class="count_minus">-</div>\n\t\t\t\t\t\t\t\t\t\t<input type="text" name="quantity" class="number_input" value="${l}" min="${l}" step="${c}" max="${r}" />\n\t\t\t\t\t\t\t\t\t\t<div class="count_plus">+</div>\n\t\t\t\t\t\t\t\t\t</div>\n\t\t\t\t\t\t\t\t\t<div class="total_price">${App.basket.numberWithCommas(i)}<span class="total ${e}"> ${App.basket.numberWithCommas(o.price * window.item.min_in_order)}  ${shop_currency}</span></div>\n\t\t\t\t\t\t\t\t\t<button class="item_add_to_cart">В корзину</button>\n\t\t\t\t\t\t\t\t\t${n}\n\t\t\t\t\t\t\t\t</form>`);
                        break;
                    default:
                        $(".item_price").html(`\n\t\t\t\t\t\t\t\t<form method="GET" action="/basket/add/">\n\t\t\t\t\t\t\t\t\t<input type="hidden" name="step" value="${c}" />\n\t\t\t\t\t\t\t\t\t<input type="hidden" name="max" value="${r}" />\n\t\t\t\t\t\t\t\t\t<input type="hidden" name="min" value="${l}" />\n\t\t\t\t\t\t\t\t\t<input type="hidden" name="price" value="${o.price}" />\n\t\t\t\t\t\t\t\t\t<input type="hidden" name="offer_id" value="${o.id}" />\n\t\t\t\t\t\t\t\t\t<div class="count">\n\t\t\t\t\t\t\t\t\t<span class="details_title">Количество: </span>\n\t\t\t\t\t\t\t\t\t<div class="count_minus">-</div>\n\t\t\t\t\t\t\t\t\t<input type="text" name="quantity" class="number_input" value="${l}" min="${l}" step="${c}" max="${r}"  />\n\t\t\t\t\t\t\t\t\t<div class="count_plus">+</div>\n\t\t\t\t\t\t\t\t</div>\n\t\t\t\t\t\t\t\t\t<button class="add_to_basket"><i class="f7-icons">cart_fill</i>В корзину</button>\n\t\t\t\t\t\t\t\t\t${n}\n\t\t\t\t\t\t\t\t</form>\n\t\t\t\t\t\t\t\t<div class="price_one_wrapp">\n\t\t\t\t\t\t\t\t\t<span class="details_title ">Цена:</span>${App.basket.numberWithCommas(t)}<span class="one_price ${App.basket.numberWithCommas(e)}">${App.basket.numberWithCommas(o.price)} ${shop_currency}</span> \n\t\t\t\t\t\t\t\t</div>\n\t\t\t\t\t\t\t\t<div class="total_price"><span class="details_title">Общая сумма.:</span>${App.basket.numberWithCommas(i)}<span class="total ${e}"> ${App.basket.numberWithCommas(o.price * window.item.min_in_order)}  ${shop_currency}</span></div>`)
                }
                $("body").on("click", ".oneclickbuy", function (t) {
                    t.stopPropagation(), t.preventDefault();
                    var e = $(".item_preview").find('[name="quantity"]').eq(0).val(),
                        i = $(".item_preview").find('[name="quantity"]').attr("step");
                    if (0 == e || isNaN(e)) 0 == $(".item_preview .count .invalid").length ? $(".item_preview .count").append('<span class="invalid" style="color:red;  font-size: 12px;">Некорректное значение поля</span>') : $(".item_preview .count .invalid").text("Некорректное значение поля"); else {
                        $(".item_preview .invalid").remove(), 1 == i && (e = parseInt(e));
                        var a = "";
                        null != $(".item_preview .size.active").eq(0).text() && (a = $(".item_preview .size.active").eq(0).text()), null != $(".item_preview .color.active .color_view").eq(0).attr("title") && (a += " " + $(".item_preview .color.active .color_view").eq(0).attr("title"));
                        var n = {
                            title: $(".item_title").eq(0).text(),
                            vendor_code: $(".vendor_or_id").eq(0).text(),
                            offer_title: a,
                            image: $(".extra_image").find("img").eq(0).attr("src"),
                            offer_id: $(".item_preview").find('[name="offer_id"]').eq(0).val(),
                            quantity: e,
                            price: $(".item_preview").find('[name="price"]').eq(0).val(),
                            max: $(".item_preview").find('[name="max"]').eq(0).val(),
                            step: $(".item_preview").find('[name="step"]').eq(0).val(),
                            discount: window.item_discount,
                            discount_type: $(".item_price").data("discount-type"),
                            one_click_buy: !0,
                            link: window.location.pathname
                        };
                        App.basket.addItem(n), window.location.href = "/checkout/"
                    }
                })
            }
        },
        stringFind: function (t, e) {
            return -1 != t.search(e)
        },
        eventListener: function () {
            if (App.checkDropdownMenu(), setTimeout(function () {
                !function () {
                    let t = document.getElementById("menu-toggler");
                    $(t).length && t.addEventListener("click", function () {
                        $(".menu_p").toggleClass("menu_open")
                    });

                    function e() {
                        let t = Array.from($(".menu #menu_list .li")), e = function (t) {
                            let e = document.getElementById("menu_list");
                            var i = 0;
                            return t.filter(function (t) {
                                if ((i += t.getBoundingClientRect().width) + 50 > e.offsetWidth) return t
                            })
                        }(t), i = document.getElementById("menu_popup");
                        null != i && e.forEach(function (t) {
                            i.appendChild(t)
                        }), 0 == e.length ? $("#menu-toggler").hide() : $("#menu-toggler").show()
                    }

                    window.addEventListener("resize", (i = function () {
                        (function () {
                            let t = Array.from(document.querySelectorAll("#menu_popup .li")),
                                e = document.getElementById("menu_list");
                            t.forEach(function (t) {
                                e.appendChild(t)
                            })
                        })(), e()
                    }, a = 450, function () {
                        var t = this, e = arguments, o = n && !s;
                        clearTimeout(s), s = setTimeout(function () {
                            s = null, n || i.apply(t, e)
                        }, a), o && i.apply(t, e)
                    })), e(), $("#menu_list").css("overflow", "visible");
                    var i, a, n, s
                }()
            }, 400), void 0 !== window.item || $(".items_table").length) {
                if (void 0 !== window.item) {
                    App.itemSC();
                    var t = 0, e = 0;
                    $.each(window.item.offers, function (i, a) {
                        1 * a.size_id != 0 && t++, 1 * a.color_id != 0 && e++
                    }), 0 == e ? $(".colors_wrapper").hide() : setTimeout(function () {
                        $(".colors .color:first-child").click()
                    }, 300), 0 == t ? $(".sizes_wrapper").hide() : setTimeout(function () {
                        $(".sizes .size:first-child").hasClass("disabled") ? $(".sizes .size").click() : $(".sizes .size:first-child").click()
                    }, 150), $("body").on("click", ".colors", function (t) {
                        $(this).toggleClass("active")
                    }), $("body").on("click", ".color", function (t) {
                        t.stopPropagation(), t.preventDefault();
                        var e = $(".size.active").data("size");
                        $(".size").removeClass("active"), setTimeout(function () {
                            $('.sizes .size[data-size="' + e + '"]').hasClass("disabled") ? $(".sizes .size").click() : $('.sizes .size[data-size="' + e + '"]').click()
                        }, 100), $(this).hasClass("disabled") || ($(this).hasClass("active") || ($(".color").removeClass("active"), $(this).addClass("active")), App.itemSC(this))
                    }), $("body").on("click", ".sizes", function (t) {
                        $(this).toggleClass("active")
                    }), $("body").on("click", ".item_tab_controlls .tab", function () {
                        var t = $(this).data("tabControll");
                        $(".item_tab_controlls .tab").removeClass("active"), $(this).addClass("active"), $(".tab_content").removeClass("active"), $(".tab_content").each(function () {
                            $(this).data("tabContent") == t && $(this).addClass("active")
                        })
                    }), $("body").on("click", ".size", function () {
                        $(this).hasClass("disabled") || ($(this).hasClass("active") || ($(".size").removeClass("active"), $(this).addClass("active")), App.itemSC(this))
                    })
                }
            }
            switch ($("body").on("click", ".show_style div", function (t) {
                $(".show_style div").removeClass("active"), $(this).addClass("active"), $(".items").removeClass("list grid");
                var e = $(this).data("id");
                $(".items").addClass(e), App.setCookieSimple("view", e)
            }), $(".main").click(function () {
                $(".search_form").removeClass("active"), $("body").removeClass("search_opened"), $(".slogan").removeClass("hide")
            }), $("body").click(function (t) {
                0 === $(t.target).closest(".icon").length && $(".links").removeClass("active"), 0 === $(t.target).closest(".filter_bar").length && $(".filter_bar").removeClass("active"), 0 !== $(t.target).closest(".user_mob").length || $(t.target).hasClass("logout") || $(".logout").removeClass("active"), 0 === $(t.target).closest(".menu").length && $(".menu_p").removeClass("menu_open"), 0 !== $(t.target).closest(".new_category").length || $(t.target).closest(".catalog_title") || ($(".new_category").removeClass("active"), $("body").removeClass("menu_active")), 0 !== $(t.target).closest(".catalog_title").length || $(t.target).closest(".categories") || $(".categories").removeClass("active"), 0 === $(t.target).closest(".search_open").length && $(".search_open").removeClass("active")
            }), template_class) {
                case"simple":
                    App.stringFind(window.location.pathname, /manufacturers/) ? $(".top-right-bottom-left .level_1").prepend('<li class="li light"><span class="current">Бренды</span></li>') : $(".top-right-bottom-left .level_1").prepend('<li class="li light"><a href="/manufacturers/">Бренды</a></li>'), $(".user_profile").on("click", ".user_email", function () {
                        $(".user_mob").toggleClass("active")
                    });
                    break;
                case"victoria":
                    var a = $(".header-top").outerHeight() + $(".header-middle").outerHeight() + $(".header-bottom").outerHeight(),
                        n = ($("body").outerWidth() - $(".inner").outerWidth()) / 2;
                    $(".header-middle").on("click", ".user", function () {
                        $(".user-popup").toggleClass("active")
                    }), $(".search_form").css("height", a), $(".slider .swiper-pagination").css("padding-right", n), $(".search_form").on("click", ".feather-x-circle", function () {
                        $(".search_form").removeClass("active")
                    });
                    break;
                case"superior":
                    $("body").on("click", ".search_bg", function () {
                        $(".search_form").removeClass("active"), $("body").removeClass("search_opened")
                    }), $("header").on("click", ".user.login", function () {
                        $(this).toggleClass("active"), $(".user_popup").toggleClass("active")
                    });
                    break;
                case"mirror":
                    $("body").on("click", ".search_open", function () {
                        $("header .logo_wrapper").addClass("hidden")
                    }), $("body").on("click", ".main", function () {
                        $("header .logo_wrapper").removeClass("hidden")
                    }), $("body").on("click", ".menu_opener", function () {
                        $(".menu-wrapper").addClass("show"), $(".menu-wrapper-overlay").addClass("show")
                    }), $("body").on("click", ".menu-close", function () {
                        $(".menu-wrapper").removeClass("show"), $(".menu-wrapper-overlay").removeClass("show")
                    }), $("body").on("click", ".menu-wrapper-overlay", function () {
                        $(".menu-wrapper").removeClass("show"), $(".menu-wrapper-overlay").removeClass("show")
                    }), $("body").on("click", ".user-profile", function () {
                        $(".user-popup").toggleClass("active")
                    });
                    break;
                case"michigan":
                    $("body").on("click", ".catalog_title", function () {
                        $(".catalog_wrapper").toggleClass("active")
                    });
                    break;
                case"mystic":
                    $(".search_open").click(function (t) {
                        t.stopPropagation(), $(".search_form ").addClass("active"), $("#search").focus()
                    }), $(".search_form").click(function (t) {
                        t.stopPropagation()
                    }), $("body").click(function () {
                        $(".search_form ").removeClass("active")
                    }), $(".target-burger, .close_mobile_menu").click(function (t) {
                        t.preventDefault(), $("body").toggleClass("menu_open"), $("html").toggleClass("popup_open")
                    });
                    break;
                case"kanasi":
                case"tahoe":
                    $(".search_open").click(function (t) {
                        t.stopPropagation(), $(".search_form ").addClass("active"), $(".search_open ").addClass("hide"), $("#search").focus()
                    }), $(".search_form").click(function (t) {
                        t.stopPropagation()
                    }), $("body").click(function () {
                        $(".search_form ").removeClass("active"), $(".search_open ").removeClass("hide")
                    });
                    break;
                case"ladoga":
                    var s = $(".level_1").children();
                    for (i = 0; i < $(".level_1").children().length; i++) s[i].children.length > 1 && $(s[i]).append('<i class="f7-icons">chevron_compact_right</i>');
                    var o = $(".level_2").children();
                    for (i = 0; i < $(".level_2").children().length; i++) o[i].children.length > 1 && $(o[i]).append('<i class="f7-icons">chevron_compact_right</i>')
            }
            if ($("body").on("click", "main, .slider", function () {
                $(".popup-city, .popup-cities, .user_popup, .user.login").removeClass("active"), $("body").removeClass("search_opened")
            }), $("body").on("click", ".customer-city", function () {
                $(".popup-city").toggleClass("active"), $(".popup-cities").removeClass("active")
            }), $(".popup-city").on("click", ".btn-primary", function () {
                $(".popup-city").removeClass("active")
            }), $(".popup-city").on("click", ".btn-secondary", function () {
                $(".popup-city").removeClass("active"), $(".popup-cities").addClass("active")
            }), $(".popup-cities").on("click", "li", function () {
                var t = $(this).data("name");
                App.setCookie("city", t, 0, "/"), $(".popup-cities").removeClass("active"), location.reload()
            }), $(".inner_more").click(function () {
                $(".inner_prop").toggleClass("dropdown")
            }), $(".horseshoe .catalog_title").click(function (t) {
                $(".categories").toggleClass("active")
            }), $("body").on("click", ".menu .close", function (t) {
                $(".menu").removeClass("active")
            }), $("body").on("click", ".mob_menu", function (t) {
                $(".menu").addClass("active")
            }), $("body").on("click", ".catalog_title.mob", function (t) {
                $(".sidebar").toggleClass("active")
            }), $("body").on("click", ".main .filter_bar .title", function (t) {
                $(this).parent().toggleClass("active"), $(".filter_bar .price_range .f_title").click()
            }), $("body").on("click", ".filter_bar .f_title", function (t) {
                $(this).toggleClass("active"), $(this).next().toggleClass("active")
            }), $(".search_form input").on("click", function (t) {
                $(this).parent().parent().addClass("active")
            }), $(".new_category li").hover(function (t) {
                if (window.innerWidth >= 1e3) {
                    $(this).children(".level_2") && $(this).addClass("active")
                }
            }, function () {
                window.innerWidth >= 1e3 && $(this).removeClass("active")
            }), window.onscroll = function () {
                (window.pageYOffset || document.documentElement.scrollTop) >= 150 ? $(".kanasi .basket").addClass("hide") : $(".kanasi .basket").removeClass("hide")
            }, "simple" !== template_class && "baikal" !== template_class && "michigan" !== template_class && "victoria" !== template_class && "isabelle" !== template_class && "louise" !== template_class && "kanasi" !== template_class && "champlain" !== template_class && "tahoe" !== template_class && "superior" !== template_class && "ladoga" !== template_class && "emerald" !== template_class && "taymyr" !== template_class || ($(".menu_popup_mob .close").click(function (t) {
                $(".menu_popup_mob").toggleClass("active")
            }), $(".mob_menu").click(function (t) {
                $(".menu_popup_mob").toggleClass("active")
            })), $(".baikal .catalog_title").click(function (t) {
                $(".categories").toggleClass("active")
            }), $(".emerald .catalog_title").click(function (t) {
                $(".emerald .categories").toggleClass("active")
            }), $(".ladoga .catalog_title").click(function (t) {
                $(".ladoga .categories_mob").toggleClass("active")
            }), $(".new_category .chevron_down").click(function (t) {
                if (window.innerWidth < 1e3) {
                    $(".new_category li").removeClass("active"), $(this).siblings(".level_2") && $(this).parent().addClass("active")
                }
            }), $("body").on("click", ".search_open", function (t) {
                console.log("touchend"), $(this).addClass("active"), $(".search_form").addClass("active"), $(".slogan").addClass("hide"), $(".search_form input").focus(), $("body").addClass("search_opened")
            }), $("body").on("click", ".user_mob, .icon", function (t) {
                $(this).next().addClass("active")
            }), $("body").on("click", ".login_or_reg, .icon", function (t) {
                $(this).next().addClass("active")
            }), $("body").on("click", ".catalog_title", function (t) {
                $(".nositebar .categories").toggleClass("active")
            }), $("select").each(function () {
                var t = $(this), e = $(this).children("option").length;
                t.addClass("s-hidden"), t.wrap('<div class="select"></div>'), t.after('<div class="styledSelect"></div>');
                var i = t.next("div.styledSelect");
                i.text(t.children("option:selected").eq(0).text() || t.children("option").eq(0).text());
                for (var a = $("<ul />", {class: "options"}).insertAfter(i), n = 0; n < e; n++) $("<li />", {
                    text: t.children("option").eq(n).text(),
                    rel: t.children("option").eq(n).val()
                }).appendTo(a);
                var s = a.children("li");
                i.click(function (t) {
                    t.stopPropagation(), $("div.styledSelect.active").each(function () {
                        $(this).removeClass("active").next("ul.options").hide()
                    }), $(this).toggleClass("active").next("ul.options").toggle()
                }), s.click(function (e) {
                    e.stopPropagation(), i.text($(this).text()).removeClass("active"), t.val($(this).attr("rel")), a.hide(), t.parents(".sort_show").length && $(".filter_items").submit()
                }), $(document).click(function () {
                    i.removeClass("active"), a.hide()
                })
            }), "/basket/" == window.location.pathname && (App.basket.renderBasket(), $("#basket_list").on("click", ".basket_item_wrapp .remove", function () {
                var t = $(this).data("index");
                App.basket.removeItemByIndex(t), App.basket.renderBasket(), App.basket.renderfloatBasketList()
            })),
            "/favorites/" == window.location.pathname && (App.renderFavorites(), $("#favorites_list").on("click", ".remove", function () {
                var t = $(this).data("index"), e = App.storage.getProp("favorites") || [];
                e.splice(t, 1), App.storage.setProp("favorites", e), App.renderFavorites()
            })), App.basket.renderfloatBasketList(), $("body").on("mouseleave", "#basket_popup_list", function (t) {
                $(this).hide()
            }), $("body").on("mouseover", ".basket a", function (t) {
                t.preventDefault(), $(window).width() > 1200 && $("#basket_popup_list").show()
            }), $("body").on("click", "#basket_popup_list .close", function (t) {
                $("#basket_popup_list").hide()
            }), $("body").on("click", "#basket_popup .close", function (t) {
                $("body").removeClass("modal"), $("#basket_popup_wrapper").remove()
            }), $("body").on("change", '#checkout_form [name="customer_type"]', function (t) {
                "ur" == $(this).data("type") ? ($("#checkout_form .ul_extra_fields").show(), $(".ul_extra_fields").find("input[data-required]").attr("required", "required")) : ($("#checkout_form .ul_extra_fields").hide(), $(".ul_extra_fields").find("input[data-required]").removeAttr("required", "required"))
            }), $("body").on("click", ".menu_collapse_1 .chevron_down", function (t) {
                $(this).toggleClass("active"), $(this).next().toggleClass("active")
            }), $("body").on("change", ".item_price .number_input", function () {
                var t = $(this).parent().parent().find('input[name="price"]'), e = 1 * t.val(),
                    i = t.val() * (1 - window.customer_discount / 100), a = t.val() * (1 - window.item_discount / 100),
                    n = 1 * $(this).val();
                $(".total_price .total").html(App.basket.numberWithCommas((e * n).toFixed(2)) + " " + shop_currency)
                    , window.customer_discount ? $(".total_price .total_new").html(App.basket.numberWithCommas((i * n).toFixed(2)) + " " + shop_currency) : window.item_discount && $(".total_price .total_new").html(App.basket.numberWithCommas((a * n).toFixed(2)) + " " + shop_currency)
            }), $("body").on("click", ".add_favorite", function () {
                var t = $(this).data("id"), e = $(this).data(), i = App.storage.getProp("favorites") || [], a = 0;
                if ($(this).hasClass("active")) {
                    $(this).removeClass("active"), $(this).children("span").text("В избранное");
                    !function (t, e, i) {
                        for (var a = t.length; a--;) t[a] && t[a].hasOwnProperty(e) && arguments.length > 2 && t[a][e] === i && t.splice(a, 1)
                    }(i, "id", t)
                } else $(this).addClass("active"), $(this).children("span").text("В избранном"), $.each(i, function (t) {
                    i[t].id == e.id && (a = 1)
                }), a || i.push(e);
                App.storage.setProp("favorites", i)
            }), $("#search").on("keyup", function () {
                var t = $(this).val().trim();
                if (t.length < 4) return !1;
                t.length > 0 ? $.ajax({
                    dataType: "json",
                    type: "POST",
                    url: "/ajax/",
                    data: {action: "search", search: t},
                    success: function (e) {
                        if (e.results.items) {
                            var i = "";
                            $.each(e.results.items, function (t, a) {
                                console.log(t, e.results.limit), i += `<a class="search_item" href="${a.url}">\n\t\t\t\t\t\t\t\t\t\t<img src="/img/50x50${a.image}">\n\t\t\t\t\t\t\t\t\t\t<span>${a.title}</span>\n\t\t\t\t\t\t\t\t\t</a>`
                            }), e.results.total > e.results.limit && (i += `<a class="search_item all_results" href="/search/?search=${t}">\n\t\t\t\t\t\t\t\t\t<span>ВСЕ РЕЗУЛЬТАТЫ (${e.results.total})</span>\n\t\t\t\t\t\t\t\t\t</a>`), $("#autocomplete").html(i).show(), $("#autocomplete").addClass("active")
                        } else $("#autocomplete").empty().hide(), $("#autocomplete").removeClass("active")
                    }
                }) : $("#autocomplete").empty().hide()
            }), $("#autocomplete").click(function (t) {
                t.stopPropagation()
            }), $("#callback_form").on("submit", function () {
                var t = $("#callback_name").val(), e = $("#callback_phone").val();
                return t.length > 0 && e.length > 0 ? $.ajax({
                    dataType: "json",
                    type: "POST",
                    url: "/ajax/",
                    data: {action: "callback", name: t, phone: e},
                    success: function (t) {
                        "ERROR" != t.status ? ($("#callback_form").remove(), $(".callback-title").remove(), $(".callback-form").append('<div class="callback-msg">Благодарим за заявку. Наши специалисты свяжутся с вами в ближайшее время!</div>')) : alert(t.description)
                    },
                    error: function (t) {
                        $(".callback-form").html('<div class="callback-msg callback-error">Ошибка. Данные не отправлены.</div>')
                    }
                }) : alert("Поля не должны быть пустыми!"), !1
            }), $("body").on("click", ".callback-toggler", function () {
                $(this).parent().find(".callback-form").toggleClass("active")
            }), $(".callback-close").click(function () {
                $(".callback-form").removeClass("active")
            }), 1 == window.item_img_zoom && "" != window.item_img_zoom && $(window).width() > 1e3 && $(".item_info_wrapper").length) {
                var c = {cursor: "crosshair"}, r = $(".extra_image img"), l = "";
                setTimeout(function () {
                    (l = $(".swiper-slide.swiper-slide-active img.big")).elevateZoom(c)
                }, 1e3), r.on("click", function () {
                    $(".zoomContainer").remove(), setTimeout(function () {
                        (l = $(".swiper-slide.swiper-slide-active img.big")).removeData("elevateZoom"), l.attr("src", $(this).data("image")), l.data("zoom-image", $(this).data("zoom-image")), l.elevateZoom(c)
                    }, 500)
                })
            }
        },
        init: function () {
            App.eventListener()
        }
    }, App.init(), App)
});