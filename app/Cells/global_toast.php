<div class="position-fixed top-0 end-0 p-3" style="z-index: 10000">
    <div id="liveToast" class="toast fade text-white bg-<?= $type ?>" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body">
                <?= $message ?>
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close" onclick="hideToast()"></button>
        </div>
    </div>
</div>

<script>
    let msg = "<?= $message ?>";
    window.addEventListener('load', function () {
        if (msg.length === 0) return
        showToast();
    })
    function showToast() {
        let liveToast = $("#liveToast")
        liveToast.removeClass("hide")
        liveToast.addClass("show")
        setTimeout(function () {
            hideToast()
        }, 3000)
    }
    function hideToast() {
        let liveToast = $("#liveToast")
        liveToast.removeClass("show")
        liveToast.addClass("hide")
    }
</script>