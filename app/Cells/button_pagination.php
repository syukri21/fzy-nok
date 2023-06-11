<div class="d-flex justify-content-end mt-2">
    <nav aria-label="Pagination table">
        <ul class="pagination">
            <li class="page-item"><a class="page-link text-center changeQueryParam" data-value="-1" style="width: 100px"
                                     href="">Previous</a></li>
            <li class="page-item"><a class="page-link text-center changeQueryParam" data-value="1" style="width: 100px"
                                     href="">Next</a></li>
        </ul>
    </nav>
</div>

<script>
    window.addEventListener('load', function () {
        $(".changeQueryParam").click(function (event) {
            event.preventDefault(); // Prevent the default link behavior
            let currentURL = window.location.href;
            let url = new URL(currentURL);
            // Update or add the desired query parameter
            let page = url.searchParams.get('page')
            if (page === null) {
                page = 1
            }

            let stringData = $(this).attr('data-value')

            let data = parseInt(stringData)
            page = parseInt(page) + data
            if (page === 0) {
                page = 1
            }
            url.searchParams.set('page', page);
            window.location.href = url.href;
        })
    })

</script>