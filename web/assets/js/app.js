$(document).ready(function(){
   $('form').submit(function(e) {
       e.preventDefault();

       $.ajax({
           type: 'post',
           url: '/',
           data: $(this).serialize()
       })
           .done(function(data) {
               $('#url_shortener_url').val(data.url);
               $('#title').text(data.title);
               $('#subtitle').text(data.subtitle);
               $('#submitUrl').addClass('hidden');
               $('#copyShortUrl').removeClass('hidden');
           })

           .fail(function(data) {
               console.log('fail' + data)
           })
   });

    $('#copyShortUrl').click(function () {
        document.getElementById('url_shortener_url').select();
        document.execCommand('copy');
        this.className = 'btn btn-success btn-fill btn';
        this.innerHTML = "<i class='fa fa-check'></i>&nbsp;Copied";
    });
});