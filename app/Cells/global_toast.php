<div class="position-fixed top-0 end-0 p-3" style="z-index: 10000">
    <div id="liveToast" class="toast fade text-white" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body">
                <!-- The message will be dynamically set here -->
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                    aria-label="Close" onclick="hideToast()"></button>
        </div>
    </div>
</div>

<script>
    let message = "<?= /** @var string $message */ $message ?>";
    let type = "<?= /** @var string $type */ $type ?>";

    window.addEventListener('load', function () {
        if (message.length === 0) return;
        showToast(type, message);
    });

    function showToast(type, message) {
        let liveToast = $("#liveToast");
        liveToast.find(".toast-body").text(message);
        liveToast.addClass("bg-" + type);
        liveToast.removeClass("hide").addClass("show");
        setTimeout(function () {
            hideToast();
        }, 3000);
    }

    function hideToast() {
        let liveToast = $("#liveToast");
        liveToast.removeClass("show").addClass("hide");
    }
</script>
