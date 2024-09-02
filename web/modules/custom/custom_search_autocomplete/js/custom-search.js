(function ($) {
    $(document).ready(function() {
      $('.custom-search-form input.form-text').autocomplete({
        source: function(request, response) {
          $.ajax({
            url: '/custom-search-autocomplete',
            dataType: 'json',
            data: {
              q: request.term
            },
            success: function(data) {
              response(data);
            }
          });
        },
        minLength: 2 // Adjust minimum characters required before autocomplete kicks in.
      });
    });
  })(jQuery);
  