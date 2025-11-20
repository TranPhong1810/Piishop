const modalBody = document.getElementById('AddSizeModalBody');
const inputSize = document.getElementById('inputSize');
const sizeModalBody = document.getElementById('AddSizeModalBody');

document.querySelector('.btn-add-size').addEventListener('click', function () {
    const sizeInput = document.createElement('input');
    const qtyInput = document.createElement('input');
    const id = Date.now();

    // gói lại item size
    const item = {
        id,
        size: '',
        quantity: 1
    };
    sizes.push(item);

    const div = document.createElement('div');
    div.classList.add('product-item-size');
    div.dataset.id = id;

    sizeInput.placeholder = 'Size';
    sizeInput.classList.add('form-control');
    sizeInput.addEventListener('input', e => {
        item.size = e.target.value;
        inputSize.value = JSON.stringify(sizes);
    });

    qtyInput.placeholder = 'Quantity';
    qtyInput.type = 'number';
    qtyInput.value = 1;
    qtyInput.classList.add('form-control');
    qtyInput.addEventListener('input', e => {
        item.quantity = parseInt(e.target.value) || 1;
        inputSize.value = JSON.stringify(sizes);
    });

    const removeBtn = document.createElement('button');
    removeBtn.type = 'button';
    removeBtn.classList.add('btn-remove-size');
    removeBtn.textContent = '×';
    removeBtn.addEventListener('click', () => {
        modalBody.removeChild(div);
        sizes = sizes.filter(s => s.id !== id);
        inputSize.value = JSON.stringify(sizes);
    });

    div.appendChild(sizeInput);
    div.appendChild(qtyInput);
    div.appendChild(removeBtn);

    modalBody.appendChild(div);
    inputSize.value = JSON.stringify(sizes);
});
function renderSizes() {
    sizeModalBody.innerHTML = '';
    sizes.forEach((item, index) => {
        const div = document.createElement('div');
        div.classList.add('product-item-size');
        div.innerHTML = `
            <input type="text" class="form-control size-input" placeholder="Size" value="${item.size}">
            <input type="number" class="form-control quantity-input" placeholder="Quantity" value="${item.quantity}">
            <button type="button" class=" btn-remove-size">X</button>
        `;
        // Nút xóa
        div.querySelector('.btn-remove-size').addEventListener('click', function () {
            sizes.splice(index, 1);
            renderSizes();
        });
        sizeModalBody.appendChild(div);
    });

    // Cập nhật input ẩn trước submit
    document.getElementById('inputSize').value = JSON.stringify(sizes);
}

// Gọi render khi load trang
document.addEventListener('DOMContentLoaded', renderSizes);

