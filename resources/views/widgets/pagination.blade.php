<style>
    .pagination {
        display: flex;
        flex-wrap: nowrap;
        list-style: none;
        padding: 0;
        justify-content: center;
        margin-top: 20px;
        gap: 5px;
        overflow-x: auto;
        scrollbar-width: thin;
        scrollbar-color: var(--primary) #f1f1f1;
    }

    .pagination::-webkit-scrollbar {
        height: 6px;
    }

    .pagination::-webkit-scrollbar-thumb {
        background-color: var(--primary);
        border-radius: 10px;
    }

    .pagination::-webkit-scrollbar-track {
        background: #f1f1f1;
    }

    .pagination li {
        margin: 0;
    }

    .pagination a {
        text-decoration: none;
        padding: 10px 15px;
        border: 2px solid var(--primary);
        color: var(--primary);
        border-radius: 4px;
        transition: background-color 0.3s, color 0.3s;
        display: inline-block;
        min-width: 40px;
        text-align: center;
    }

    .pagination a:hover {
        background-color: var(--primary);
        color: #fff;
    }

    .pagination_active {
        background-color: var(--primary);
        color: #fff !important;
        pointer-events: none;
        cursor: default;
    }

    .pagination-disabled {
        color: #ccc;
        border-color: #ccc;
        pointer-events: none;
        cursor: default;
    }

    .pagination-wrapper {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 10px;
    }

    .total-records {
        font-size: 14px;
        color: #666;
    }
  </style>






@if (method_exists($data['meta'],'currentPage'))
<div class="pagination-wrapper">
    <div>
        <ul class="pagination" id="pagination-list">
            @php
                $currentPage = $data['meta']->currentPage();
                $lastPage = $data['meta']->lastPage();
                $queryParams = request()->except('page');
                $baseUrl = request()->url() . '?' . http_build_query($queryParams);
            @endphp

            <!-- Previous Button -->
            <li>
                <a class="{{ $currentPage == 1 ? 'pagination-disabled' : '' }}"
                   href="{{ $currentPage > 1 ? $baseUrl . '&page=' . ($currentPage - 1) : '#' }}">
                   &laquo; Prev
                </a>
            </li>

            <!-- Pagination Numbers -->
            @for ($page = 1; $page <= $lastPage; $page++)
                <li>
                    <a class="{{ $currentPage == $page ? 'pagination_active' : '' }}"
                       data-page="{{ $page }}"
                       href="{{ $currentPage != $page ? $baseUrl . '&page=' . $page : '#' }}">
                       {{ $page }}
                    </a>
                </li>
            @endfor

            <!-- Next Button -->
            <li>
                <a class="{{ $currentPage == $lastPage ? 'pagination-disabled' : '' }}"
                   href="{{ $currentPage < $lastPage ? $baseUrl . '&page=' . ($currentPage + 1) : '#' }}">
                   Next &raquo;
                </a>
            </li>
        </ul>
    </div>
    <div class="total-records">
        Total Records: {{ $data['meta']->total() }}
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const paginationList = document.getElementById('pagination-list');
        const pages = Array.from(paginationList.querySelectorAll('a[data-page]'));
        const maxVisiblePages = 10;

        function updatePaginationView(currentPage) {
            pages.forEach((page, index) => {
                const pageNum = parseInt(page.getAttribute('data-page'));
                const start = Math.max(1, currentPage - Math.floor(maxVisiblePages / 2));
                const end = Math.min(start + maxVisiblePages - 1, pages.length);

                if (pageNum >= start && pageNum <= end) {
                    page.parentElement.style.display = '';
                } else {
                    page.parentElement.style.display = 'none';
                }

                if (pageNum === currentPage) {
                    // page.scrollIntoView({ behavior: 'smooth', inline: 'center' });
                }
            });
        }

        const currentPage = parseInt({{ $currentPage }});
        updatePaginationView(currentPage);

        pages.forEach(page => {
            page.addEventListener('click', () => {
                const selectedPage = parseInt(page.getAttribute('data-page'));
                // updatePaginationView(selectedPage);
            });
        });
    });
  </script>
@endif







