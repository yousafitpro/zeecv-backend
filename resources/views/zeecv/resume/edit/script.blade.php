  <!-- Custom JS -->
  <script>
    $(document).ready(function () {

      // Dynamic chevron icon flipping on collapse show/hide
      $('.collapse').on('show.bs.collapse', function () {
        $(this).prev().find('.icon-toggle').removeClass('fa-chevron-down').addClass('fa-chevron-up');
      }).on('hide.bs.collapse', function () {
        $(this).prev().find('.icon-toggle').removeClass('fa-chevron-up').addClass('fa-chevron-down');
      });

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

      // Real-time synchronization between editor form and preview sheet
      $('#roleTitle').on('input', function () {
        const val = $(this).val();
        $('#previewRole').text(val);
        $('#formRoleTitle').text(val.substring(0, 30) + (val.length > 30 ? '...' : ''));
      });

      $('#companyName').on('input', function () {
        const val = $(this).val();
        $('#previewCompany').text(val);
      });

      $('#location, #country').on('input', function () {
        const loc = $('#location').val();
        const country = $('#country').val();
        $('#previewLocation').text(`${loc}${country ? ', ' + country : ''}`);
      });

      $('#description').on('input', function () {
        $('#previewDescription').text($(this).val());
      });

      // Toggle present position dates
      $('#currentPos').on('change', function () {
        if ($(this).is(':checked')) {
          $('#endMonth, #endYear').prop('disabled', true);
          $('#previewDates').text(`${$('#startMonth').val()}/${$('#startYear').val()} – Present`);
        } else {
          $('#endMonth, #endYear').prop('disabled', false);
        }
      });

    });
  </script>