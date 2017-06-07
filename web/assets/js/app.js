$(document).ready(function(){

   $('form').submit(function(e) {
       e.preventDefault();

       $.ajax({
           type: 'post',
           url: '/',
           data: $(this).serialize(),
           dataType: 'json'
       })
           .done(function(data) {
               $('#url_shortener_url').val(data.url).focus();
               $('#title').text(data.title);
               $('#subtitle').text(data.subtitle);
               $('#submitUrl').hide();
               $('#clearUrl').show();
               $('#copyShortUrl').show();
           })
   });

    $('#copyShortUrl').click(function () {
        document.getElementById('url_shortener_url').select();
        document.execCommand('copy');
        this.className = 'btn btn-success btn-fill btn';
        this.innerHTML = "<i class='fa fa-check'></i>&nbsp;Copied";
    });

    $('#clearUrl').click(function(){
        $('#url_shortener_url').val('').focus();
        $('#title').text("Bigger isn't always better.");
        $('#subtitle').text('Enter your long link and let us generate a short youRL for you instead!');
        $('#submitUrl').show();
        $('#clearUrl').hide();
        $('#copyShortUrl').hide();
    });

    $('[data-toggle="tooltip"]').tooltip();
});