$(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    // Kiểm tra xem trang có được tải lại từ bộ nhớ đệm hay không
    if (localStorage.getItem('inputValue')) {
        // Nếu có, lấy giá trị từ bộ nhớ đệm và đặt nó vào input
        var storedValue = localStorage.getItem('inputValue');
        $('.cart_quantity_input').val(storedValue);
    }

    $('.quantity button').on('click', function () {
        var button = $(this);
        var inputElement = button.parent().parent().find('input');
        var oldValue = parseFloat(inputElement.val());

        if (button.hasClass('btn-plus')) {
            var newVal = oldValue + 1;
        } else {
            if (oldValue > 0) {
                var newVal = oldValue - 1;
            } else {
                newVal = 0;
            }
        }

        // Lưu giá trị mới vào bộ nhớ đệm
        localStorage.setItem('inputValue', newVal);

        // Đặt giá trị mới vào input
        inputElement.val(newVal);
    });

    function confirmDelete() {
        return new Promise((resolve, reject) => {
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!",
            }).then((result) => {
                if (result.isConfirmed) {
                    resolve(true);
                } else {
                    reject(false);
                }
            });
        });
    }

    getTotalValue();

    function getTotalValue() {
        let total = $(".total-price").data("price");
        let couponPrice = $(".coupon-div")?.data("price") ?? 0;
        $(".total-price-all").text(`$${total - couponPrice}`);
    }
    $(document).on("click", ".btn-remove-product", function (e) {
        let url = $(this).data("action");
        confirmDelete()
            .then(function () {
                $.post(url, (res) => {
                    let cart = res.cart;
                    let cartProductId = res.product_cart_id;
                    $("#productCountCart").text(cart.product_count);
                    $(".total-price")
                        .text(`$${cart.total_price}`)
                        .data("price", cart.product_count);
                    $(`#row-${cartProductId}`).remove();
                    getTotalValue();
                });
            })
            .catch(function () { });
    });


    const TIME_TO_UPDATE = 1000;

    $(document).on(
        "click",
        ".btn-update-quantity",
        _.debounce(function (e) {
            let url = $(this).data("action");
            console.log(url);
            let id = $(this).data("id");
            let data = {
                product_quantity: $(`#productQuantityInput-${id}`).val(),
            };
            $.post(url, data, (res) => {
                let cartProductId = res.product_cart_id;
                let cart = res.cart;
                $("#productCountCart").text(cart.product_count);
                if (res.remove_product) {
                    $(`#row-${cartProductId}`).remove();
                } else {
                    $(`#cartProductPrice${cartProductId}`).html(
                        `$${res.cart_product_price}`
                    );
                }
                getTotalValue();

                $(".total-price").text(`$${cart.total_price}`);
                Swal.fire({
                    position: "top-end",
                    icon: "success",
                    title: "success",
                    showConfirmButton: false,
                    timer: 1500,
                });
            });
        }, TIME_TO_UPDATE)
    );
});
