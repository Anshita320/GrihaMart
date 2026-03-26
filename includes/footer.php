<footer class="bg-dark text-white text-center py-4 mt-5">
    <p class="mb-0">© <?php echo date("Y"); ?> GrihaMart | All Rights Reserved</p>
</footer>
<script>
document.querySelectorAll(".add-to-cart").forEach(button => {
    button.addEventListener("click", function() {

        let productId = this.getAttribute("data-id");

        fetch("add_to_cart.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded"
            },
            body: "product_id=" + productId
        })
        .then(response => response.text())
        .then(data => {
            if(data === "added") {
                alert("Product Added To Cart!");
            }
        });

    });
});
</script>
</body>
</html>