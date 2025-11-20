class SearchManager {
    constructor(config) {
        this.config = {
            apiUrl: config.apiUrl,
            formSelector: '#search-form',
            inputSelector: '#search',
            listSelector: '#product-list',
            paginationSelector: '#pagination',
            perPageSelector: '#perPage',
            onRowRender: config.onRowRender, // callback render từng row
            ...config
        };

        this.state = {
            currentPage: 1,
            perPage: 10,
            searchQuery: '',
            publish: this.config.publish ?? ''
        };

        this.init();
    }

    init() {
        this.attachEvents();
        this.load();
    }

    attachEvents() {
        document.querySelector(this.config.formSelector)?.addEventListener('submit', (e) => {
            e.preventDefault();
            this.search();
        });

        document.querySelector(this.config.inputSelector)?.addEventListener('keyup', () => {
            this.search();
        });

        document.querySelector(this.config.perPageSelector)?.addEventListener('change', (e) => {
            this.state.perPage = parseInt(e.target.value);
            this.state.currentPage = 1;
            this.load();
        });

        document.querySelector(this.config.publishSelector)?.addEventListener('change', (e) => {
            this.state.publish = e.target.value;
            this.state.currentPage = 1;
            this.load();
        });
    }

    search() {
        this.state.searchQuery = document.querySelector(this.config.inputSelector).value;
        this.state.currentPage = 1;
        this.load();
    }

    async load() {
        try {
            const params = new URLSearchParams({
                q: this.state.searchQuery,
                page: this.state.currentPage,
                per_page: this.state.perPage
            });

            if (this.state.publish !== '') {
                params.append('publish', this.state.publish);
            }

            const response = await fetch(`${this.config.apiUrl}?${params}`, {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            });
            const data = await response.json();
            this.renderList(data.data);
            this.renderPagination(data.meta);
        } catch (err) {
            // console.error(err);
        }
    }

    renderList(items) {
        const listEl = document.querySelector(this.config.listSelector);
        if (!items || items.length === 0) {
            listEl.innerHTML = '<li style="padding: 20px;">No products found</li>';
            return;
        }
        listEl.innerHTML = items.map(item => this.config.onRowRender(item)).join('');
    }

    renderPagination(meta) {
        const paginationEl = document.querySelector(this.config.paginationSelector);
        if (!paginationEl || !meta) return;

        const { current_page, last_page } = meta;
        let html = '';

        // Previous
        html += `<li>
        <a href="#" ${current_page > 1
                ? `onclick="window.searchManager.goToPage(${current_page - 1}); return false;"`
                : 'style="opacity:0.5;cursor:not-allowed;" onclick="return false;"'}>
            <i class="icon-chevron-left"></i>
        </a>
    </li>`;

        // Trang đầu
        html += `<li ${current_page === 1 ? 'class="active"' : ''}>
        <a href="#" ${current_page !== 1 ? `onclick="window.searchManager.goToPage(1); return false;"` : 'onclick="return false;"'}>1</a>
    </li>`;

        // Dấu "..." nếu current_page > 2
        if (current_page > 3) html += `<li><span>...</span></li>`;

        // Trang trước và sau trang hiện tại (nếu không phải đầu/cuối)
        const start = Math.max(2, current_page - 1);
        const end = Math.min(last_page - 1, current_page + 1);

        for (let i = start; i <= end; i++) {
            if (i === 1 || i === last_page) continue;
            html += `<li ${i === current_page ? 'class="active"' : ''}>
            <a href="#" ${i !== current_page ? `onclick="window.searchManager.goToPage(${i}); return false;"` : 'onclick="return false;"'}>${i}</a>
        </li>`;
        }

        // Dấu "..." nếu current_page < last_page - 2
        if (current_page < last_page - 2) html += `<li><span>...</span></li>`;

        // Trang cuối
        if (last_page > 1) {
            html += `<li ${current_page === last_page ? 'class="active"' : ''}>
            <a href="#" ${current_page !== last_page ? `onclick="window.searchManager.goToPage(${last_page}); return false;"` : 'onclick="return false;"'}>${last_page}</a>
        </li>`;
        }

        // Next
        html += `<li>
        <a href="#" ${current_page < last_page
                ? `onclick="window.searchManager.goToPage(${current_page + 1}); return false;"`
                : 'style="opacity:0.5;cursor:not-allowed;" onclick="return false;"'}>
            <i class="icon-chevron-right"></i>
        </a>
    </li>`;

        paginationEl.innerHTML = html;
    }

    goToPage(page) {
        this.state.currentPage = page;
        this.load();
    }
}

// Ví dụ callback render row
window.searchManager = new SearchManager({

    apiUrl: '/products',
    listSelector: '#product-list',
    paginationSelector: '#pagination',
    perPageSelector: '#perPage',
    publishSelector: '#publish-filter',
    onRowRender: (p) => `
<li class="product-item gap14" id="product-${p.id}">
    <div class="image no-bg">
        <img src="${p.image_url}" alt="${p.name}">
    </div>

    <div class="flex items-center justify-between gap20 flex-grow">
        <div class="name">
            <a href="/admin/products/${p.id}" class="body-title-2">${p.name}</a>
        </div>

        <div class="body-text">${p.id}</div>
        <div class="body-text">${new Intl.NumberFormat('vi-VN').format(p.price)} ₫</div>
        <div class="body-text">${p.quantity}</div>
        <div class="body-text">${p.sale}%</div>
        <div class="body-text">${new Intl.NumberFormat('vi-VN').format(p.sale_price)} ₫</div>
        <div class="body-text">
            ${p.publish ? '<span style="color:green;">Published</span>' : '<span style="color:red;">Unpublished</span>'}
        </div>
        <div class="list-icon-function">
            <div class="item eye">
                <a href="/products/${p.id}"><i class="icon-eye"></i></a>
            </div>
            <div class="item edit">
                <a href="/products/${p.id}/edit"><i class="icon-edit-3"></i></a>
            </div>
            <div class="item trash">
                <button class="delete-btn btn btn-danger" data-id="${p.id}">
                    <i class="icon-trash-2"></i>
                </button>
            </div>
        </div>
    </div>
</li>
`
});
window.searchManagerTrashed = new SearchManager({
    apiUrl: '/products/trashed',
    listSelector: '#product-list-trashed',
    paginationSelector: '#pagination-trashed',
    perPageSelector: '#perPage-trashed',
    publishSelector: '#publish-filter',
    onRowRender: (p) => `
<li class="product-item gap14" id="product-${p.id}">
    <div class="image no-bg">
        <img src="${p.image_url}" alt="${p.name}">
    </div>

    <div class="flex items-center justify-between gap20 flex-grow">
        <div class="name">
            <a href="/admin/products/${p.id}" class="body-title-2">${p.name}</a>
        </div>

        <div class="body-text">${p.id}</div>
        <div class="body-text">${new Intl.NumberFormat('vi-VN').format(p.price)} ₫</div>
        <div class="body-text">${p.quantity}</div>
        <div class="body-text">${p.sale}%</div>
        <div class="body-text">${new Intl.NumberFormat('vi-VN').format(p.sale_price)} ₫</div>
        <div class="body-text">
            ${p.publish ? '<span style="color:green;">Published</span>' : '<span style="color:red;">Unpublished</span>'}
        </div>
        <div class="list-icon-function">
            <div class="item restore">
                <button class="btn btn-success restore-btn" data-id="${p.id}">
                    Restore
                </button>
            </div>
                                    <div class="item force-delete">
                                        <button class="btn btn-danger force-delete-btn" data-id="${p.id}">
                                            <i class="icon-trash-2"></i>
                                        </button>
                                    </div>
                                </div>
    </div>
</li>
`
});