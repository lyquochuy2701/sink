(function($) {
    "use strict";

    function initProducts() {
        if ('select2' in $.fn) {
            $('select[name="product_cat"]:not(.hierarchical)').select2();
            $('select[name="product_category"]:not(.hierarchical)').select2();
        }
    }
    function initProductCategoriesWidget() {
        $('ul.product-categories li.cat-parent a').on('click', function(event) {
            event.stopPropagation();
        });
        $('ul.product-categories li.cat-parent').on('click', function(event) {
            var item = this;
            var children = $(this).find('> ul.children');
            if (children.css('display') == 'none') {
                children.stop(true, true).slideDown();
                children.show();
                $(item).find('> a').addClass('open');
            } else {
                children.stop(true, true).slideUp(400, function() {
                    children.hide();
                    $(item).find('> a').removeClass('open');
                });
            }
            event.stopPropagation();
            return false;
        });
    }
    function initQuantity() {
        $('.quantity input[name="quantity"]').each(function() {
            var qty_el = this;
            $(qty_el).parent().find('.qty-increase').off('click.azexo-woo').on('click.azexo-woo', function() {
                var qty = qty_el.value;
                if (!isNaN(qty))
                    qty_el.value++;
            });
            $(qty_el).parent().find('.qty-decrease').off('click.azexo-woo').on('click.azexo-woo', function() {
                var qty = qty_el.value;
                if (!isNaN(qty) && qty > 1)
                    qty_el.value--;
            });
        });
        return false;
    }
    function initReviewRatings() {
        $('.comment-form-mark select').hide().before('<p class="stars"><span><a class="star-1" href="#">1</a><a class="star-2" href="#">2</a><a class="star-3" href="#">3</a><a class="star-4" href="#">4</a><a class="star-5" href="#">5</a></span></p>');

        $('body')
                .on('click', '.comment-form-mark p.stars a', function() {
                    var $star = $(this),
                            $rating = $(this).closest('.comment-form-mark').find('select'),
                            $container = $(this).closest('.stars');

                    $rating.val($star.text());
                    $star.siblings('a').removeClass('active');
                    $star.addClass('active');
                    $container.addClass('selected');

                    return false;
                });
    }
    function initInfiniteScroll() {
        if ('infinitescroll' in $.fn) {
            if ($('#content.infinite-scroll > ul.products').length) {
                $('#content.infinite-scroll > ul.products').infinitescroll({
                    navSelector: "nav.woocommerce-pagination",
                    nextSelector: "nav.woocommerce-pagination a.next",
                    itemSelector: "#content > ul.products > li",
                    loading: {
                        img: azexo.templateurl + "/images/infinitescroll-loader.svg",
                        msgText: '<em class="infinite-scroll-loading">Loading ...</em>',
                        finishedMsg: '<em class="infinite-scroll-done">Done</em>',
                    },
                    errorCallback: function() {
                    }
                }, function(arrayOfNewElems) {
                    $(document).trigger('infinitescroll', {new_elems: arrayOfNewElems});
                    window.azexo.refresh();
                    $('#content.infinite-scroll .image.lazy').each(function() {
                        if ($(this).data('waypoint_handler'))
                            $(this).data('waypoint_handler')();
                    });
                });
                $('#content.infinite-scroll .image.lazy').each(function() {
                    if ($(this).data('waypoint_handler'))
                        $(this).data('waypoint_handler')();
                });
                $('#content.infinite-scroll nav.woocommerce-pagination').hide();
            }
        }
    }
    $(function() {
        function msieversion() {
            var ua = window.navigator.userAgent;
            var msie = ua.indexOf("MSIE ");

            if (msie > 0)      // If Internet Explorer, return version number
                return parseInt(ua.substring(msie + 5, ua.indexOf(".", msie)));

            return false;
        }

        initProducts();
        initProductCategoriesWidget();
        initQuantity();
        initReviewRatings();
        initInfiniteScroll();
        $(document).ajaxComplete(function() {
            initQuantity();
        });
        $(document.body).on('adding_to_cart', function(event, button, data) {
            $('.menu-item.cart .count').each(function() {
                var count = parseInt($(this).text(), 10);
                count++;
                $(this).text(count);
            });
        });

        if (!msieversion()) {
            var current_url = window.location.href;
            current_url = current_url.replace('?registered=true', '');
            current_url = current_url.replace('?verify=false', '');
            current_url = current_url.replace('?verify=true', '');
            current_url = current_url.replace('?resend=true', '');
            window.history.replaceState('', '', current_url);
        }


    });
})(jQuery);