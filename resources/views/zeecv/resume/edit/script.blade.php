  <!-- Custom JS -->
  <script>
    function toggleUpDown(el){
          $(el).toggleClass('fa-chevron-down fa-chevron-up');
    }
    $(document).ready(function () {

      // Toggle Content / Template pill tabs & left column views
      $('#btnContentTab').on('click', function () {
        $('.toggle-pills .btn-pill').removeClass('active');
        $(this).addClass('active');
        
        $('#templateView').hide();
        $('#contentView').fadeIn(200);
      });

      $('#btnTemplateTab').on('click', function () {
        $('.toggle-pills .btn-pill').removeClass('active');
        $(this).addClass('active');
        
        $('#contentView').hide();
        $('#templateView').fadeIn(200);
      });


    });
  </script>