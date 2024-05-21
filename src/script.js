document.addEventListener('DOMContentLoaded', function() {

    function changeMainContent(url) {

        var mainContent = document.querySelector('.main');
        

        var xhr = new XMLHttpRequest();
        

        xhr.open('GET', url, true);


        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {

                mainContent.innerHTML = xhr.responseText;
            }
        };
        

        xhr.send();
    }


    var aboutBtn = document.getElementById('about');
    var contactBtn = document.getElementById('contact');
    var homeBtn = document.getElementById('home');
    var projectsBtn = document.getElementById('projects');
    var creditsBtn = document.getElementById('credits');


    aboutBtn.addEventListener('click', function() {
        changeMainContent('../panels/about.html');
        document.title = "Katie | About us"; 
    });

    contactBtn.addEventListener('click', function() {
        changeMainContent('../panels/contact.html');
        document.title = "Katie | Contact";
    });

    homeBtn.addEventListener('click', function() {
        changeMainContent('../panels/home.html');
        document.title = "Katie | Home";
    });

    projectsBtn.addEventListener('click', function() {
        changeMainContent('../panels/projects.html');
        document.title = "Katie | Projects";
    });


    changeMainContent('../panels/home.html');
    document.title = "Katie | Home";});
