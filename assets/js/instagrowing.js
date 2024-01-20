function moveDots(event) {
    if ($(window).width() <= 768) {
        var slid = $('.feedback-slider .owl-item.active');
        var dot = $('.feedback-slider .owl-controls');
        var fed = $('.feedback-content-btn');
        var height = slid.height();
        console.log("height: " + height);
        var ch = 50 - (height - 230);
        console.log("ch: " + ch);
        dot.css('bottom', ch + 'px');
        fed.css('top', (ch * -1) + 10 + 'px');
    }
    console.log(event);
}

function billetFadeOut() {
    $('#billet').fadeOut();
    $('body').css('padding-top', 0);
}

function billetFadeIn() {
    $('#billet').fadeIn();
    var billetHeight = $('#billet').height();
    $('body').css('padding-top', billetHeight);
}

function checkCookie() {
    console.log(window.location.href);
    if (window.location.href == 'https://instagrowing.net/buy-instagram-autolikes/') {
        billetFadeOut();
        return false;
    }
    if ($('.checkout-section').length > 0) {
        billetFadeOut();
        return false;
    }
    var billet = getCookieBillet("billet");
    if (billet == "no") billetFadeOut();
    else billetFadeIn();
}

function getCookieBillet(cname) {
    var name = cname + "=";
    var decodedCookie = decodeURIComponent(document.cookie);
    var ca = decodedCookie.split(';');
    for (var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}
$(document).ready(function() {
    $('img').each(function(e) {
        var src = $(this).data('src');
        if (src)
            $(this).attr('src', src);
    });
    $('.footer-menus ul li.title-menu a').click(function(e) {
        e.preventDefault();
    });
    checkCookie();
    $('#closebillet').click(function() {
        document.cookie = "billet=no; expires=" + 60 * 60 * 24 * 7 * 2;
        billetFadeOut();
    })
    $(".hamburger").click(function() {
        $(this).toggleClass("is-active");
        $('.main-menu.mob').toggleClass('active');
    });
    if ($(window).width() <= 768) {
        if ($('.table-colhead').length > 0) {
            $('.advantages-t').each(function() {
                var t = $(this).parent();
                $(this).insertAfter(t.find('.price'));
            })
        }
        $('.main-menu.mob ul li>a').click(function(e) {
            var m = $(this).parent().find('.sub-menu');
            if (m.hasClass('close-m')) {
                m.fadeIn(300);
                m.removeClass('close-m');
            } else {
                m.fadeOut(300);
                m.addClass('close-m');
            }
        });
    }
    if ($(window).width() <= 992) {
        $('.step-slider').owlCarousel({
            loop: false,
            margin: 5,
            navText: [],
            nav: false,
            center: true,
            dots: true,
            items: 1,
            autoHeight: true
        });
        $('.inns-footer-add').append($('.inns-footer').html());
        $('.inns-footer').html('');
    } else {
        $('.step-slider').trigger('destroy.owl.carousel').removeClass('owl-carousel owl-loaded');
        $('.step-slider').find('.owl-stage-outer').children().unwrap();
    }
    $(window).resize(function() {
        if ($(window).width() <= 992) {
            $('.step-slider').owlCarousel({
                loop: false,
                margin: 5,
                navText: [],
                nav: false,
                center: true,
                dots: true,
                items: 1,
                autoHeight: true
            });
        } else {
            $('.step-slider').trigger('destroy.owl.carousel').removeClass('owl-carousel owl-loaded');
            $('.step-slider').find('.owl-stage-outer').children().unwrap();
        }
    });
    if ($(window).width() <= 768) {
        $('.feedback-slider').owlCarousel({
            loop: false,
            navText: false,
            nav: false,
            dots: true,
            margin: 0,
            items: 1,
            responsiveClass: true,
            autoHeight: true,
            responsive: {
                0: {
                    items: 1,
                    nav: false,
                    dots: true
                },
                768: {
                    items: 1,
                },
                1000: {
                    items: 1,
                }
            }
        });
    } else {
        $('.feedback-slider').owlCarousel({
            loop: false,
            navText: false,
            nav: true,
            dots: false,
            margin: 0,
            items: 1,
            responsiveClass: true,
            responsive: {
                0: {
                    items: 1,
                    nav: false,
                    dots: true
                },
                768: {
                    items: 1,
                },
                1000: {
                    items: 1,
                }
            }
        });
    }
    if ($(window).width() <= 768) {
        $('.likes-offers').owlCarousel({
            loop: false,
            navText: false,
            nav: true,
            dots: false,
            margin: 0,
            items: 1,
            responsiveClass: true,
            autoHeight: true,
            responsive: {
                0: {
                    items: 1,
                    nav: true,
                    dots: false
                },
                768: {
                    items: 1,
                },
                1000: {
                    items: 1,
                }
            }
        });
    } else {
        $('.likes-offers').owlCarousel({
            loop: false,
            navText: false,
            nav: true,
            dots: false,
            margin: 0,
            items: 4,
            responsiveClass: true,
            responsive: {
                0: {
                    items: 4,
                    nav: true,
                    dots: false
                },
                768: {
                    items: 2,
                },
                1000: {
                    items: 4,
                }
            }
        });
    }
    $(".main-screen").on("click", "a", function(event) {
        event.preventDefault();
        var id = $(this).attr('href'),
            top = $(id).offset().top;
        $('body,html').animate({
            scrollTop: top
        }, 1500);
    });
    if ($('.sec-winer').length > 0) {
        var hw = $('.sec-winer').height() * 2 + 120;
        $('.sec-winer').css('max-height', hw + 'px');
        $('.sec-winer .to-f').click(function(e) {
            e.preventDefault();
            var n = $(this).data('to');
            $('.sec-winer .to-f').removeClass('active');
            $(this).addClass('active');
            $('.sec-w-cont.active').removeClass('active');
            $('.sec-w-cont').fadeOut(100);
            $('.sec-w-cont.to-w-' + n).fadeIn(300);
            $('.sec-w-cont.to-w-' + n).addClass('active');
        })
    }
    $.fn.scrollToTop = function() {
        $(this).hide().removeAttr("href");
        if ($(window).scrollTop() >= "250") $(this).fadeIn("slow")
        var scrollDiv = $(this);
        $(window).scroll(function() {
            if ($(window).scrollTop() <= "250") $(scrollDiv).fadeOut("slow")
            else $(scrollDiv).fadeIn("slow")
        });
        $(this).click(function() {
            $("html, body").animate({
                scrollTop: 0
            }, "slow")
        })
    }
    $("#go-top").scrollToTop();
});

function setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
    var expires = "expires=" + d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

function getCookie(cname) {
    var name = cname + "=";
    var decodedCookie = decodeURIComponent(document.cookie);
    var ca = decodedCookie.split(';');
    for (var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}

function makeid() {
    var text = "";
    var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
    for (var i = 0; i < 5; i++)
        text += possible.charAt(Math.floor(Math.random() * possible.length));
    return text;
}
var code_id = makeid();

function validateEmail(email) {
    var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    var valid_ = re.test(email);
    var form = $('.account-view form');
    form.find('.subtitle.medium').remove();
    if (valid_) {} else {
        form.find('[name=email]').after('<p class="subtitle medium">Email not correct!</p>');
        return false;
    }
    return true;
}
var payer = makeid();
var costOfAdd_summ = 0;
var costOfAdd_count = 1;
var num_count_wait = 8;
var time_interval = null;

function loader(key, container) {
    if (key) {
        $(container).css('position', 'relative');
        $(container).append('<div class="loader"><i class="fas fa-spinner fa-spin"></i></div>');
    } else {
        $(container + ' .loader').remove();
    }
}

function removePay() {
    if ($('.default-part.payment').length > 0) {
        $('.default-part.payment').remove();
    }
    if ($('.account-change.account-photo').length > 0) {
        $('.account-change.account-photo').remove();
    }
    if ($('.summary').length > 0) {
        $('.summary').remove();
    }
}

function setPackage(packege) {
    $('.package').data('package', packege);
}

function saveLogForm(form) {
    var demo = $('.content .package').data('type');
    var free = 0;
    if (demo === 'demo')
        free = 1;
    var type = $('.default-part.checkout-section').data('product');
    if ($('.account-view input[name="account"]').length > 0) {
        var link = $('.account-view input[name="account"]').val();
        if (demo === 'demo')
            link = 'https://www.instagram.com/' + link + '/';
    } else {
        var link = $('.account-change.main-account').data('account');
    }
    var product_id = $('.content .package').data('product-id');
    $.ajax({
        type: 'POST',
        dataType: 'html',
        url: '/wp-admin/admin-ajax.php',
        data: {
            'action': 'send_log_form_action',
            'code': code_id + '_' + form,
            'link': link,
            'type': type,
            'product_id': product_id,
            'free': free,
        },
        success: function(data) {}
    });
}

function saveLog(log) {
    log = payer + ': ' + log;
    $.ajax({
        type: 'POST',
        dataType: 'html',
        url: '/wp-admin/admin-ajax.php',
        data: {
            'action': 'save_log_action',
            'log': log
        },
        success: function(data) {}
    });
}

function sendPayDataNew(id_product, account, product, package, email, media) {
    loader(true, '.section.template-content');
    $.ajax({
        type: 'POST',
        dataType: 'html',
        url: '/wp-admin/admin-ajax.php',
        data: {
            'action': 'get_payment_action',
            'id_product': id_product,
            'account': account,
            'product': product,
            'package': package,
            'email': email,
            'media': media,
            'costOfAdd_summ': costOfAdd_summ,
            'costOfAdd_count': costOfAdd_count,
        },
        success: function(data) {
            loader(false, '.section.template-content');
            if (data) {
                $('.section.template-content .container').append(data);
                $([document.documentElement, document.body]).animate({
                    scrollTop: $(".default-part.payment").offset().top
                }, 1000);
            }
        }
    });
}

function showPayBlock(account, product_id) {
    var type = $('.package').data('type');
    var product = $('.checkout-section').data('product');
    var id_product = $('.package').data('product-id');
    var package = $('.package').data('package');
    var email = $('.account-change.main-account').data('email');
    if (type === 'demo') {
        $.ajax({
            type: 'POST',
            dataType: 'html',
            url: '/wp-admin/admin-ajax.php',
            data: {
                'action': 'get_demo_action',
                'id_product': product_id,
                'email': email,
                'account': account,
            },
            success: function(data) {
                if (data) {
                    $('.checkout-section').append(data);
                    $([document.documentElement, document.body]).animate({
                        scrollTop: $(".default-part.payment").offset().top
                    }, 1000);
                }
            }
        });
    } else {
        var media = '';
        var c_m = $('.media-item.active').length;
        var c = 0;
        if (c_m > 0) {
            $('.media-item.active').each(function() {
                media += $(this).data('url') + ';';
                c++;
                if (c >= c_m) {
                    sendPayDataNew(id_product, account, product, package, email, media);
                }
            });
        } else {
            sendPayDataNew(id_product, account, product, package, email, media);
        }
    }
}

function showCheckedViews(account, product_id, type) {
    var tttt = $('.package').data('type');
    saveLogForm('get_account_photo_action');
    if (type != 'video') {
        $('.checkout-section').append('<div class="loader" style="position: relative;padding-top: 0px;"><i class="fas fa-spinner fa-spin"></i></div>');
    }
    $.ajax({
        type: 'POST',
        dataType: 'html',
        url: '/wp-admin/admin-ajax.php',
        data: {
            'action': 'get_account_photo_action',
            'id_product': product_id,
            'account': account,
            'type': type,
            'tttt': tttt
        },
        success: function(data) {
            if (data) {
                saveLogForm('get_account_photo_action');
                $('.default-part.checkout-section').append(data);
                var typeq = $('.package').data('type');
                if (typeq == 'demo') {
                    $('.account-change.account-photo .subtitle.medium').html("You can select at most 1 post.")
                }
                loader(false, '.checkout-section');
            }
        }
    });
}

function nextStep() {
    var product = $('.checkout-section').data('product');
    var account = $('.account-change.main-account').data('account');
    var account_id = $('.account-change.main-account').data('id');
    var product_id = $('.package').data('product-id');
    if (account && product_id) {
        switch (product) {
            case 'followers':
            case 'auto-views':
            case 'autolikes':
            case 'uk-instagram-followers':
            case 'us-instagram-followers':
            case 'real-followers':
            case 'story-views':
            case 'tv-likes':
            case 'tv-views':
                showPayBlock(account, product_id);
                break;
            case 'views':
                showCheckedViews(account_id, product_id, 'video');
                break;
            case 'likes':
            case 'emoji-comments':
            case 'random-comments':
                showCheckedViews(account_id, product_id, 'image');
                break;
        }
    }
}

function getCount() {
    var count = $('.checkout-section .media-item.active').length;
    return count;
}

function getTotal() {
    var count = getCount();
    var packege = $('.package').data('package');
    return Math.ceil(packege / count);
}

function reloadCart() {
    setTimeout(function() {
        var total = getTotal();
        var costTotal = total * costOfAdd_count;
        $('.count-likes-set').text(parseInt(costTotal));
        $('.count-likes-set-d .n-p').text(parseInt(total));
        console.log(costOfAdd_count);
        if (costOfAdd_count > 1)
            $('.count-likes-set-d .c-p').text('(+' + parseInt(costTotal - total) + ')');
        else
            $('.count-likes-set-d .c-p').text('');
    }, 200);
}

function doneAllCart() {
    var account = $('.account-change.main-account').data('account');
    var product_id = $('.package').data('product-id');
    showPayBlock(account, product_id);
}

function addSummary(id_media) {
    var product = $('.checkout-section').data('product');
    var img = $('.item-id-' + id_media + ' img').attr('src');
    var block = '<div class="summary-item summary-item-' + id_media + '">' + '<img src="' + img + '" alt="">' + '<p><span class="count-likes-set-d"><span class="n-p"></span><span class="c-p" style="color: #ff7b7b;"></span> </span> ' + product + '</p>' + '<a href="#" onclick="removeSummary(\'' + id_media + '\');return false;"><i class="far fa-times-circle"></i></a>' + '</div>';
    $('#summary-list').append(block);
    $('.summary').fadeIn(300);
    if ($('.default-part.payment').length < 1) {
        var account = $('.account-change.main-account').data('account');
        var product_id = $('.package').data('product-id');
    }
    reloadCart();
}

function removeSummary(id_media) {
    $('.summary-item-' + id_media).remove();
    $('.item-id-' + id_media).removeClass('active');
    reloadCart();
    if ($('.checkout-section .media-item.active').length < 1) {
        $('.summary').fadeOut(300);
        if ($('.default-part.payment').length > 0) {
            $('.default-part.payment').remove();
        }
    }
}

function checkPaysData(paymentID, email, first_name, last_name, payer_id, status, actions) {
    var product = $('.checkout-section').data('product');
    var account = $('.account-change.main-account').data('account');
    var product_id = $('.package').data('product-id');
    var packege = $('.package').data('package');
    var media = '';
    var c_m = $('.media-item.active').length;
    var c = 0;
    if (c_m > 0) {
        $('.media-item.active').each(function() {
            media += $(this).data('url') + ';';
            c++;
            if (c >= c_m) {
                sendPayData(paymentID, email, first_name, last_name, payer_id, status, product, account, product_id, packege, media, actions);
            }
        });
    } else {
        sendPayData(paymentID, email, first_name, last_name, payer_id, status, product, account, product_id, packege, media, actions);
    }
}

function sendPayData(paymentID, email, first_name, last_name, payer_id, status, product, account, product_id, packege, media, actions) {
    $.ajax({
        type: 'POST',
        dataType: 'html',
        url: '/wp-admin/admin-ajax.php',
        data: {
            'action': 'set_payment_data_action',
            'paymentID': paymentID,
            'email': email,
            'first_name': first_name,
            'last_name': last_name,
            'payer_id': payer_id,
            'status': status,
            'product': product,
            'account': account,
            'product_id': product_id,
            'packege': packege,
            'media': media
        },
        success: function(data) {
            actions.redirect();
        }
    });
}

function selectAccount2(response) {
    loader(true, '.account-view');
    var _this = $(this);
    var account = $('.account-view input[name="account"]').val();
    var email = $('.account-view input[name="email"]').val();
    var product = $('.package').data('product-id');
    var tttt = $('.checkout-section').data('product');
    var type = $('.package').data('type');
    if (!validateEmail(email)) {
        loader(false, '.account-view');
        return false;
    }
    setCookie('email', email, 365);
    setCookie('account', account, 365);
    saveLogForm('get_account_action');
    $.ajax({
        type: 'POST',
        dataType: 'html',
        url: '/wp-admin/admin-ajax.php',
        data: {
            'action': 'get_account_action',
            'account': account,
            'email': email,
            'product': product,
            'type': type,
            'tttt': tttt,
            'recaptcha': response
        },
        success: function(data) {
            if (data) {
                if (data === 'Failed to validate Recaptcha') {
                    alert(data);
                } else {
                    $('.account-view').html(data);
                }
                saveLogForm('get_account_action');
            }
            loader(false, '.account-view');
        }
    });
}

function selectAccount() {
    var _this = $(this);
    var account = $('.account-view input[name="account"]').val();
    var email = $('.account-view input[name="email"]').val();
    var product = $('.package').data('product-id');
    var tttt = $('.checkout-section').data('product');
    var type = $('.package').data('type');
    if (!validateEmail(email)) {
        loader(false, '.account-view');
        return false;
    }
    if (tttt == 'views') {
        num_count_wait = 8;
        $('.checkout-section').css('position', 'relative');
        $('.checkout-section').append('<div class="loader"><i class="fas fa-spinner fa-spin"></i><div style="top: -60px;position: relative;color: #91a1f6;font-size: 18px;font-weight: 800;" class="num-count-wait">' + num_count_wait + '</div></div>');
        time_interval = setInterval(function() {
            num_count_wait = num_count_wait - 1;
            if (num_count_wait < 1) {
                num_count_wait = 'Wait';
                clearInterval(time_interval);
            }
            $('.num-count-wait').html(num_count_wait);
        }, 1000);
    } else {
        loader(true, '.account-view');
    }
    setCookie('email', email, 365);
    setCookie('account', account, 365);
    saveLogForm('get_account_action');
    $.ajax({
        type: 'POST',
        dataType: 'html',
        url: '/wp-admin/admin-ajax.php',
        data: {
            'action': 'get_account_action',
            'account': account,
            'email': email,
            'product': product,
            'type': type,
            'tttt': tttt,
        },
        success: function(data) {
            if (data) {
                $('.account-view').html(data);
                if ($('.account-view').find('form').length > 0)
                    loader(false, '.checkout-section');
                saveLogForm('get_account_action');
            }
            if (tttt != 'views') {
                loader(false, '.account-view');
            }
        }
    });
}

function testCapcha() {
    if (grecaptcha === undefined) {
        alert('Recaptcha not defined');
        return;
    }
    var response = grecaptcha.getResponse();
    if (!response) {
        alert('Coud not get recaptcha response');
        return;
    }
    selectAccount2(response);
}
$(document).ready(function() {
    if ($('.account-view input[name="email"]').length > 0) {
        var email = getCookie('email');
        if (email)
            $('.account-view input[name="email"]').val(email)
    }
    if ($('.account-view input[name="account"]').length > 0) {
        var account = getCookie('account');
        if (account)
            $('.account-view input[name="account"]').val(account)
    }
    var type = $('.package').data('type');
    $('.package').on('click', '.select-new-package', function(e) {
        e.preventDefault();
        removePay();
        $('.package').fadeOut(30);
        $('.package').data('product-id', false);
        $('.package-select').fadeIn(300);
    });
    $('.package-select .change-new-package').click(function(e) {
        e.preventDefault();
        loader(true, '.package-select');
        var _this = $(this);
        var id_product = $('.package-select select').val();
        var product = _this.data('product');
        $.ajax({
            type: 'POST',
            dataType: 'html',
            url: '/wp-admin/admin-ajax.php',
            data: {
                'action': 'get_package_action',
                'id_product': id_product,
                'product': product,
            },
            success: function(data) {
                if (data) {
                    $('.package').html(data);
                    $('.package-select').fadeOut(30);
                    $('.package').fadeIn(300);
                    $('.package').data('product-id', id_product);
                    nextStep();
                    loader(false, '.package-select');
                }
            }
        });
    });
    $('.account-view').on('click', '.select-account', function(e) {
        e.preventDefault();
        if ($('.g-recaptcha').length > 0) {
            testCapcha();
            return;
        }
        selectAccount();
    });
    $('.account-view').on('click', '.account-change-btn', function(e) {
        e.preventDefault();
        removePay();
        var _this = $(this);
        var tttt = $('.checkout-section').data('product');
        $.ajax({
            type: 'POST',
            dataType: 'html',
            url: '/wp-admin/admin-ajax.php',
            data: {
                'action': 'change_account_action',
                'tttt': tttt,
            },
            success: function(data) {
                if (data) {
                    $('.account-view').html(data);
                    if ($('.account-view input[name="email"]').length > 0) {
                        var email = getCookie('email');
                        if (email)
                            $('.account-view input[name="email"]').val(email)
                    }
                    if ($('.account-view input[name="account"]').length > 0) {
                        var account = getCookie('account');
                        if (account)
                            $('.account-view input[name="account"]').val(account)
                    }
                }
            },
        });
    });
    $('.checkout-section').on('click', '.load-more-media', function(e) {
        e.preventDefault();
        loader(true, '.load-upp-load');
        var maxId = $('.account-photo .media-cor').last().data('maxid');
        if (maxId) {
            var account_id = $('.account-change.main-account').data('id');
            var product = $('.checkout-section').data('product');
            var type = 'image';
            saveLogForm('get_account_photo_next_action');
            if (product == 'views') type = 'video';
            $.ajax({
                type: 'POST',
                dataType: 'html',
                url: '/wp-admin/admin-ajax.php',
                data: {
                    'action': 'get_account_photo_next_action',
                    'maxId': maxId,
                    'account': account_id,
                    'type': type
                },
                success: function(data) {
                    if (data) {
                        saveLogForm('get_account_photo_next_action');
                        $('.account-change.account-photo .row').append(data);
                    }
                    loader(false, '.load-upp-load');
                },
            });
        } else {
            loader(false, '.load-upp-load');
        }
    });
    $('.checkout-section').on('click', '.media-item', function(e) {
        e.preventDefault();
        var _this = $(this);
        var type = $('.package').data('type');
        var id = _this.data('id');
        var product = $('.checkout-section').data('product');
        var package = $('.package').data('package');
        if (_this.hasClass('active')) {
            removeSummary(id);
        } else {
            var count = getCount();
            var total = getTotal();
            if (type == 'demo') {
                if (count >= 1) {
                    alert('You can choose a maximum of 1 posts.');
                } else {
                    addSummary(id);
                    _this.addClass('active');
                }
            } else if (product == 'random-comments') {
                if (package == 10 && count >= 1) {
                    alert('You can choose a maximum of 1 posts.');
                } else if (package == 25 && count >= 2) {
                    alert('You can choose a maximum of 2 posts.');
                } else if (package == 50 && count >= 4) {
                    alert('You can choose a maximum of 4 posts.');
                } else if (package == 100 && count >= 6) {
                    alert('You can choose a maximum of 6 posts.');
                } else {
                    addSummary(id);
                    _this.addClass('active');
                }
            } else {
                if (count >= 10) {
                    alert('You can choose a maximum of 10 posts.');
                } else if (total <= 100 && (product == 'views' || product == 'tv-views')) {
                    alert('Minimal amount 100 ' + product + '. To enlarge, change the package.');
                } else if (total <= 20 && (product == 'likes' || product == 'tv-likes')) {
                    alert('Minimal amount 20 ' + product + '. To enlarge, change the package.');
                } else {
                    addSummary(id);
                    _this.addClass('active');
                }
            }
        }
    });
    $('.section.template-content').on('click', '.get-demo-load', function(e) {
        e.preventDefault();
        loader(true, '.default-part.payment');
        var email = $('.default-part.payment').data('email');
        var account = $('.default-part.payment').data('account');
        var id_account = $('.account-change.main-account').data('id');
        var key = $('.account-change.main-account').data('key');
        var product = $('.default-part.payment').data('product');
        var packege = $('.package').data('package');
        var medias = '';
        var c_m = $('.media-item.active').length;
        var c = 0;
        if (c_m > 0) {
            $('.media-item.active').each(function() {
                medias += $(this).data('url') + ';';
                c++;
                if (c >= c_m) {
                    $.ajax({
                        type: 'POST',
                        dataType: 'html',
                        url: '/wp-admin/admin-ajax.php',
                        data: {
                            'action': 'load_demo_action',
                            'email': email,
                            'account': account,
                            'product': product,
                            'medias': medias,
                            'packege': packege,
                            'id_account': id_account,
                            'key': key
                        },
                        success: function(data) {
                            $('.section.template-content').html(data);
                        }
                    });
                }
            });
        } else {
            $.ajax({
                type: 'POST',
                dataType: 'html',
                url: '/wp-admin/admin-ajax.php',
                data: {
                    'action': 'load_demo_action',
                    'email': email,
                    'account': account,
                    'product': product,
                    'medias': medias,
                    'packege': packege,
                    'id_account': id_account,
                    'key': key
                },
                success: function(data) {
                    $('.section.template-content').html(data);
                }
            });
        }
    });
    $('.section.template-content').on('click', '.close-account-lock', function(e) {
        e.preventDefault();
        $('.account-lock').fadeOut(300);
    });
    $('.section.template-content').on('click', '#upgrade-hide', function(e) {
        e.preventDefault();
        $('#summary-upgrade').remove();
    });
    $('.section.template-content').on('click', '#upgrade-button', function(e) {
        e.preventDefault();
        costOfAdd_summ = $('#summary-upgrade').data('summ');
        costOfAdd_count = $('#summary-upgrade').data('count');
        reloadCart();
        if ($('#summary-upgrade').data('t') == "1") {
            if ($('.default-part.payment').length > 0) {
                $('.default-part.payment').remove();
            }
            doneAllCart();
        } else {
            if ($('.default-part.payment').length > 0) {
                $('.default-part.payment').remove();
                doneAllCart();
            }
        }
        $('#summary-upgrade').fadeOut();
    });
    $('.section.template-content').on('click', '#checkout-payment-downgrade-button', function(e) {
        e.preventDefault();
        costOfAdd_summ = 0;
        costOfAdd_count = 1;
        reloadCart();
        $('#summary-upgrade').fadeIn();
        if ($('.default-part.payment').length > 0) {
            $('.default-part.payment').remove();
        }
        doneAllCart();
    });
});
! function(d, l) {
    "use strict";
    var e = !1,
        o = !1;
    if (l.querySelector)
        if (d.addEventListener) e = !0;
    if (d.wp = d.wp || {}, !d.wp.receiveEmbedMessage)
        if (d.wp.receiveEmbedMessage = function(e) {
                var t = e.data;
                if (t)
                    if (t.secret || t.message || t.value)
                        if (!/[^a-zA-Z0-9]/.test(t.secret)) {
                            var r, a, i, s, n, o = l.querySelectorAll('iframe[data-secret="' + t.secret + '"]'),
                                c = l.querySelectorAll('blockquote[data-secret="' + t.secret + '"]');
                            for (r = 0; r < c.length; r++) c[r].style.display = "none";
                            for (r = 0; r < o.length; r++)
                                if (a = o[r], e.source === a.contentWindow) {
                                    if (a.removeAttribute("style"), "height" === t.message) {
                                        if (1e3 < (i = parseInt(t.value, 10))) i = 1e3;
                                        else if (~~i < 200) i = 200;
                                        a.height = i
                                    }
                                    if ("link" === t.message)
                                        if (s = l.createElement("a"), n = l.createElement("a"), s.href = a.getAttribute("src"), n.href = t.value, n.host === s.host)
                                            if (l.activeElement === a) d.top.location.href = t.value
                                }
                        }
            }, e) d.addEventListener("message", d.wp.receiveEmbedMessage, !1), l.addEventListener("DOMContentLoaded", t, !1), d.addEventListener("load", t, !1);
    function t() {
        if (!o) {
            o = !0;
            var e, t, r, a, i = -1 !== navigator.appVersion.indexOf("MSIE 10"),
                s = !!navigator.userAgent.match(/Trident.*rv:11\./),
                n = l.querySelectorAll("iframe.wp-embedded-content");
            for (t = 0; t < n.length; t++) {
                if (!(r = n[t]).getAttribute("data-secret")) a = Math.random().toString(36).substr(2, 10), r.src += "#?secret=" + a, r.setAttribute("data-secret", a);
                if (i || s)(e = r.cloneNode(!0)).removeAttribute("security"), r.parentNode.replaceChild(e, r)
            }
        }
    }
}(window, document);