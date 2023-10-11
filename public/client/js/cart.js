$(function () {

    // $(document).ready(function () {
    //     // Lấy tất cả các nút "Plus" và "Minus"
    //     $(".btn-update-quantity").click(function () {
    //         // Lấy ID của sản phẩm tương ứng từ thuộc tính data-id
    //         var productId = $(this).data("id");

    //         // Lấy trường nhập số lượng dựa trên ID sản phẩm
    //         var quantityInput = $("#productQuantityInput-" + productId);

    //         // Lấy giá trị hiện tại trong trường nhập số lượng
    //         var currentQuantity = parseInt(quantityInput.val());

    //         // Kiểm tra xem nút "Plus" hay "Minus" đã được nhấp
    //         if ($(this).hasClass("btn-plus")) {
    //             // Nút "Plus" được nhấp, tăng số lượng lên 1
    //             currentQuantity++;
    //         } else if ($(this).hasClass("btn-minus")) {
    //             // Nút "Minus" được nhấp, giảm số lượng đi 1, nhưng đảm bảo không nhỏ hơn 1
    //             currentQuantity = Math.max(currentQuantity - 1, 1);
    //         }

    //         // Cập nhật giá trị trong trường nhập số lượng
    //         quantityInput.val(currentQuantity);

    //         // Gửi yêu cầu cập nhật số lượng đến máy chủ (nếu cần)
    //         // Thực hiện phần này theo yêu cầu của ứng dụng của bạn
    //     });
    // });
    
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
                cartProductPrice;
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
