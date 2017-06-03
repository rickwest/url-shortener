var copyBtn = document.getElementById('copyShortUrl');
copyBtn.addEventListener('click', function () {

    document.getElementById('shortUrl').select();
    document.execCommand('copy');

    copyBtn.className = 'btn btn-success btn-fill btn';
    copyBtn.innerHTML = "<i class='fa fa-check'></i>&nbsp;Copied";
});