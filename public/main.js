window.onload = function(){
    var date = new Date();
    document.getElementById(''+date.getDate()).scrollIntoView({
        behavior: 'smooth'
    });
};