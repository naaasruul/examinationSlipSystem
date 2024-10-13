</div>
  <!-- Footer -->
  <footer class="bg-light border-top mt-5  text-center py-4">
        <div class="container">
            <p>&copy; 2024 MudahJe. All rights reserved.</p>
            <p>
                <a href="#" class="text-white me-3">Privacy Policy</a>
                <a href="#" class="text-white">Terms of Service</a>
            </p>
        </div>
    </footer>
</body>
<script>
    $(function() {
        $('.nav-link').on('click', function() {

            // Remove 'active' class from all links
            $('.nav-link').removeClass('active');


            // Add 'active' class to the clicked link
            $(this).addClass('active');
        })
    })
</script>

</html>