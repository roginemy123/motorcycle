

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdn.datatables.net/2.1.8/js/dataTables.min.js"></script>
<script src="assets/js/jquery-searchbox.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
<script defer src="assets/js/plugin.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function(){
        new DataTable("#table", {
            responsive: true
        });

        $('.js-searchBox').searchBox({
            elementWidth:'250'
        });
    })
</script>
</body>
</html>
