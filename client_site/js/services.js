// Created by Mathew

//Date: 2/8/26
// The purpose of this .js file is to add functionality for the services list. I personally think this makes the site more functional,
//But I'm unsure if my client will agree, so feedback will definitely be needed.


//We are going to attach an event listener to each of the 'category-header' classes on the ``home_page.html`` file.
document.querySelectorAll(".category-header").forEach(header => {
    header.addEventListener("click", () => {
        const list = header.nextElementSibling;
        const arrow = header.querySelector(".arrow");

        list.classList.toggle("open");
        arrow.classList.toggle("rotated");
    });
});